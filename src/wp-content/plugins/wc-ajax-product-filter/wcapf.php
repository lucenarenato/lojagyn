<?php
/**
 * Plugin Name: WC Ajax Product Filters
 * Description: A plugin to filter woocommerce products with AJAX request.
 * Plugin URI: https://goya.everthemes.com/
 * Version: 3.9.0
 * Author: Shamim Al Mamun
 * Text Domain: wcapf
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @since     1.0
 * @copyright Copyright (c) 2015, Shamim Al Mamun
 * @author    Shamim Al Mamun
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

/**
 * WCAPF main class
 */
if (!class_exists('WCAPF')) {
	class WCAPF
	{
		/**
		 * Plugin version, used for cache-busting of style and script file references.
		 *
		 * @var string
		 */
		public $version = '3.9.0';

		/**
		 * Unique identifier for the plugin.
		 *
		 * The variable name is used as the text domain when internationalizing strings of text.
		 *
		 * @var string
		 */
		public $plugin_slug;

		/**
		 * A reference to an instance of this class.
		 *
		 * @var WCAPF
		 */
		private static $_instance = null;

		/**
		 * Initialize the plugin.
		 */
		public function __construct()
		{
			add_action('plugins_loaded', array($this, 'init'));
		}

		/**
		 * Returns an instance of this class.
		 *
		 * @return WCAPF
		 */
		public static function instance()
		{
			if (!isset(self::$_instance)) {
				self::$_instance = new WCAPF();
			}

			return self::$_instance;
		}

		/**
		 * Init this plugin when WordPress Initializes.
		 */
		public function init()
		{
			$this->plugin_slug = 'wcapf';

			// Grab the translation for the plugin.
			add_action('init', array($this, 'loadPluginTextdomain'));

			// If woocommerce class exists and woocommerce version is greater than required version.
			if (class_exists('woocommerce') && WC()->version >= 2.1) {
				$this->defineConstants();
				$this->includes();

				// plugin action links
				add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'pluginActionLinks'));

				// plugin settings page
				if (is_admin()) {
					$this->pluginSettingsPageInit();
				}
			}
			// If woocommerce class exists but woocommerce version is older than required version.
			elseif (class_exists('woocommerce')) {
				add_action('admin_notices', array($this, 'updateWoocommerce'));
			}
			// If woocommerce plugin not found.
			else {
				add_action('admin_notices', array($this, 'needWoocommerce'));
			}

			// Disable plugin update from wordpress.org
			function disable_plugin_updates( $value ) {
			  if ( isset($value) && is_object($value) ) {
			  $plugin_file_name = basename(__DIR__) . '/' . basename(__FILE__);
			    if ( isset( $value->response[$plugin_file_name] ) ) {
			      unset( $value->response[$plugin_file_name] );
			    }
			  }
			  return $value;
			}
			add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );
		}

		/**
		 * Defind constants for this plugin.
		 */
		public function defineConstants()
		{
			$this->define('WCAPF_LOCALE', $this->plugin_slug);
			$this->define('WCAPF_PATH', $this->pluginPath());
			$this->define('WCAPF_ASSETS_PATH', $this->assetsPath());
			$this->define('WCAPF_CACHE_TIME', 60*60*12);
		}

		/**
		 * Include required core files.
		 */
		public function includes()
		{
			require_once 'includes/functions.php';
			require_once 'includes/hooks.php';
			require_once 'widgets/widget-category-filter.php';
			require_once 'widgets/widget-attribute-filter.php';
			require_once 'widgets/widget-price-filter.php';
			require_once 'widgets/widget-active-filter.php';
		}

		/**
		 * Define constants if not already defined.
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		public function define($name, $value)
		{
			if (!defined($name)) {
				define($name, $value);
			}
		}

		/**
		 * Register and enqueue frontend scripts.
		 *
		 * @return mixed
		 */
		public function frontendScripts()
		{
			$settings = get_option('wcapf_settings');

			wp_register_style('wcapf-style', WCAPF_ASSETS_PATH . 'css/wcapf-styles.css');

			wp_register_script('wcapf-script', WCAPF_ASSETS_PATH . 'js/scripts.js', array('jquery'), '20120206', true);
			wp_localize_script('wcapf-script', 'wcapf_price_filter_params', array(
				'currency_symbol' => get_woocommerce_currency_symbol(),
				'currency_pos'    => get_option('woocommerce_currency_pos')
			));

			if ($settings) {
				wp_localize_script('wcapf-script', 'wcapf_params', $settings);
			}

			wp_register_style('wcapf-nouislider-style', WCAPF_ASSETS_PATH . 'css/nouislider.min.css');
			wp_register_script('wcapf-nouislider-script', WCAPF_ASSETS_PATH . 'js/nouislider.min.js', array ('jquery'), '1.0', true);
			wp_register_script('wcapf-price-filter-script', WCAPF_ASSETS_PATH . 'js/price-filter.js', array ('jquery'), '1.0', true);

			wp_register_script('wcapf-select2', WCAPF_ASSETS_PATH . 'js/select2.min.js', array ('jquery'), '1.0', true);
		}

		/**
		 * Get plugin settings.
		 */
		public function pluginSettingsPageInit()
		{
			add_action('admin_menu', array($this, 'adminMenu'));
			add_action('admin_init', array($this, 'registerSettings'));
			add_action('admin_init', array($this, 'saveDefultSettings'));
		}

		/**
		 * Register admin menu.
		 */
		public function adminMenu()
		{
			add_options_page(__('WC Ajax Product Filter', 'wcapf'), __('WC Ajax Product Filter', 'wcapf'), 'manage_options', 'wcapf-settings', array($this, 'settingsPage'));
		}

		/**
		 * Render HTML for settings page.
		 */
		public function settingsPage()
		{
			require 'includes/settings.php';
		}

		/**
		 * Default settings for this plugin.
		 *
		 * @return array
		 */
		public function defaultSettings()
		{
			return array(
				'shop_loop_container'  => '.wcapf-before-products',
				'not_found_container'  => '.wcapf-before-products',
				'pagination_container' => '.woocommerce-pagination',
				'overlay_bg_color'     => '#fff',
				'sorting_control'      => '1',
				'scroll_to_top'        => '1',
				'scroll_to_top_offset' => '150',
				'custom_scripts'       => '',
				'disable_transients'   => '',
			);
		}

		/**
		 * Register settings.
		 */
		public function registerSettings()
		{
			register_setting('wcapf_settings', 'wcapf_settings', array($this, 'validateSettings'));
		}

		/**
		 * If settings are not found then save it.
		 */
		public function saveDefultSettings()
		{
			if (!get_option('wcapf_settings')) {
				// check if filter is applied
				$settings = apply_filters('wcapf_settings', $this->defaultSettings());
				update_option('wcapf_settings', $settings);
			}
		}

		/**
		 * Check for if filter is applied.
		 *
		 * @param  array $input
		 * @return array
		 */
		public function validateSettings($input)
		{
			if (has_filter('wcapf_settings')) {
				$input = apply_filters('wcapf_settings', $input);
			}

			if (isset($input['clear_transients']) && $input['clear_transients'] == '1' ) {
				// clear transient
				wcapf_clear_transients();
			}

			return $input;
		}

		/**
		 * Get chosen filters.
		 *
		 * @return array
		 */
		public function getChosenFilters()
		{
			// parse url
			$url = $_SERVER['QUERY_STRING'];
			parse_str($url, $query);

			$chosen = array();
			$term_ancestors = array();
			$active_filters = array();

			// keyword
			if (isset($_GET['keyword'])) {
				$keyword = (!empty($_GET['keyword'])) ? sanitize_key($_GET['keyword']) : '';
				$active_filters['keyword'] = $keyword;
			}

			// orderby
			if (isset($_GET['orderby'])) {
				$orderby = (!empty($_GET['orderby'])) ? sanitize_key($_GET['orderby']) : '';
				$active_filters['orderby'] = $orderby;
			}

			foreach ($query as $key => $value) {
				// attribute
				if (preg_match('/^attr/', $key) && !empty($query[$key])) {
					$terms = explode(',', $value);
					$new_key = str_replace(array('attra-', 'attro-'), '', $key);
					$taxonomy = 'pa_' . $new_key;

					if (preg_match('/^attra/', $key)) {
						$query_type = 'and';
					} else {
						$query_type = 'or';
					}

					$chosen[$taxonomy] = array(
						'terms'      => $terms,
						'query_type' => $query_type
					);

					foreach ($terms as $term_id) {
						$ancestors = wcapf_get_term_ancestors($term_id, $taxonomy);
						$term_data = wcapf_get_term_data($term_id, $taxonomy);
						$term_ancestors[$key][] = $ancestors;
						if ($term_data) {
							$active_filters['term'][$key][$term_id] = $term_data->name;
						}
					}
				}

				// category
				if (preg_match('/product-cat/', $key) && !empty($query[$key])) {
					$terms = explode(',', $value);
					$taxonomy = 'product_cat';

					if (preg_match('/^product-cata/', $key)) {
						$query_type = 'and';
					} else {
						$query_type = 'or';
					}

					$chosen[$taxonomy] = array(
						'terms'      => $terms,
						'query_type' => $query_type
					);

					foreach ($terms as $term_id) {
						$ancestors = wcapf_get_term_ancestors($term_id, $taxonomy);
						$term_data = wcapf_get_term_data($term_id, $taxonomy);
						$term_ancestors[$key][] = $ancestors;
						if ($term_data) {
							$active_filters['term'][$key][$term_id] = $term_data->name;
						}
					}
				}
			}

			// min-price
			if (isset($_GET['min-price'])) {
				$active_filters['min_price'] = (int)$_GET['min-price'];
			}

			// max-price
			if (isset($_GET['max-price'])) {
				$active_filters['max_price'] = (int)$_GET['max-price'];
			}

			return array(
				'chosen'         => $chosen,
				'term_ancestors' => $term_ancestors,
				'active_filters' => $active_filters
			);
		}

		/**
		 * Filtered product ids for given terms.
		 *
		 * @return array
		 */
		public function filteredProductIdsForTerms()
		{
			$chosen_filters = $this->getChosenFilters();
			$chosen_filters = $chosen_filters['chosen'];
			$results = array();

			// 99% copy of WC_Query
			if (sizeof($chosen_filters) > 0) {
				$matched_products = array(
					'and' => array(),
					'or'  => array()
				);

				$filtered_attribute = array(
					'and' => false,
					'or'  => false
				);

				foreach ($chosen_filters as $attribute => $data) {
					$matched_products_from_attribute = array();
					$filtered = false;

					if (sizeof($data['terms']) > 0) {
						foreach ($data['terms'] as $value) {
							$tax_query = array(
								array(
									'taxonomy' => $attribute,
									'terms'    => $value,
									'field'    => 'term_id'
								)
							);

							$args = array(
								'post_type'     => 'product',
								'numberposts'   => -1,
								'post_status'   => 'publish',
								'fields'        => 'ids',
								'no_found_rows' => true,
								'tax_query'     => $tax_query
							);

							$posts = get_posts($args);

							if (!is_wp_error($posts)) {
								if (sizeof($matched_products_from_attribute) > 0 || $filtered) {
									$matched_products_from_attribute = ($data['query_type'] === 'or') ? array_merge($posts, $matched_products_from_attribute) : array_intersect($posts, $matched_products_from_attribute);
								} else {
									$matched_products_from_attribute = $posts;
								}

								$filtered = true;
							}
						}
					}

					if (sizeof($matched_products[$data['query_type']]) > 0 || $filtered_attribute[$data['query_type']] === true) {
						$matched_products[$data['query_type']] = ($data['query_type'] === 'or') ? array_merge($matched_products_from_attribute, $matched_products[$data['query_type']]) : array_intersect($matched_products_from_attribute, $matched_products[$data['query_type']]);
					} else {
						$matched_products[$data['query_type']] = $matched_products_from_attribute;
					}

					$filtered_attribute[$data['query_type']] = true;
				}

				// combine our AND and OR result sets
				if ($filtered_attribute['and'] && $filtered_attribute['or']) {
					$results = array_intersect($matched_products['and'], $matched_products['or']);
					$results[] = 0;
				} else {
					$results = array_merge($matched_products['and'], $matched_products['or']);
					$results[] = 0;
				}
			}

			return $results;
		}

		/**
		 * Query for meta that should be set to the main query.
		 *
		 * @return array
		 */
		public function queryForMeta()
		{
			$meta_query = array();

			// rating filter
			if (isset($_GET['min_rating'])) {
				$meta_query[] = array(
					'key'           => '_wc_average_rating',
					'value'         => isset($_GET['min_rating']) ? floatval($_GET['min_rating']) : 0,
					'compare'       => '>=',
					'type'          => 'DECIMAL',
					'rating_filter' => true,
				);
			}

			if (isset($_GET['min-price']) || isset($_GET['max-price'])) {
				// price range for all published products
				$unfiltered_price_range = $this->getPriceRange(false);

				if (sizeof($unfiltered_price_range) === 2) {
					$min = (!empty($_GET['min-price'])) ? (int)$_GET['min-price'] : '';
					$max = (!empty($_GET['max-price'])) ? (int)$_GET['max-price'] : '';

					$min = (!empty($min)) ? $min : (int)$unfiltered_price_range[0];
					$max = (!empty($max)) ? $max : (int)$unfiltered_price_range[1];

					// if tax enabled
					if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && ! wc_prices_include_tax()) {
						$tax_classes = array_merge(array( ''), WC_Tax::get_tax_classes());

						foreach ($tax_classes as $tax_class) {
							$tax_rates = WC_Tax::get_rates($tax_class);
							$class_min = $min - WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($min, $tax_rates));
							$class_max = $max - WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));

							$min = $max = false;

							if ($min === false || $min > (int)$class_min) {
								$min = floor($class_min);
							}

							if ($max === false || $max < (int)$class_max) {
								$max = ceil($class_max);
							}
						}
					}

					// if WooCommerce Currency Switcher plugin is activated
					if (class_exists('WOOCS')) {
						global $WOOCS;

						$min = floor($WOOCS->woocs_exchange_value($min));
						$max = ceil($WOOCS->woocs_exchange_value($max));

					}

					$meta_query[] = array(
						'key'          => '_price',
						'value'        => apply_filters('wcapf_min_max_prices', array($min, $max)),
						'type'         => 'numeric',
						'compare'      => 'BETWEEN',
						'price_filter' => true,
					);
				}
			}

			$meta_query = apply_filters('wcapf_get_meta_query', $meta_query);

			return $meta_query;
		}

		/**
		 * Set filter.
		 *
		 * @param wp_query $q
		 */
		public function setFilter($q)
		{

			// check for if we are on main query and product archive page
			if (!is_main_query() && !is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
				return;
			}

			$search_results = $this->productIdsForGivenKeyword();
			$taxono_results = $this->filteredProductIdsForTerms();

			if (sizeof($search_results) > 0 && sizeof($taxono_results) > 0) {
				$post__in = array_intersect($search_results, $taxono_results);
			} elseif (sizeof($search_results) > 0 && sizeof($taxono_results) === 0) {
				$post__in = $search_results;
			} else {
				$post__in = $taxono_results;
			}
			
			$q->set('meta_query', $this->queryForMeta());
			$q->set('date_query', apply_filters('wcapf_get_date_query',array()));
			$q->set('post__in', apply_filters('wcapf_get_post__in',$post__in));

			return;
		}

		/**
		 * Retrive Product ids for given keyword.
		 *
		 * @return array
		 */
		public function productIdsForGivenKeyword()
		{
			if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
				$keyword = sanitize_key( $_GET['keyword'] );

				$args = array(
					's'           => $keyword,
					'post_type'   => 'product',
					'post_status' => 'publish',
					'numberposts' => -1,
					'fields'      => 'ids'
				);

				$results = get_posts($args);
				$results[] = 0;
			} else {
				$results = array();
			}

			return $results;
		}

		/**
		 * Get the unfiltered product ids.
		 *
		 * @return array
		 */
		public function unfilteredProductIds()
		{
 			if (!is_tax(get_object_taxonomies('product'))) {
 				$args = array(
 					'post_type'   => 'product',
 					'post_status' => 'publish',
 					'numberposts' => -1,
 					'fields'      => 'ids'
 				);

 				// get unfiltered products using transients
 				$transient_name = 'wcapf_unfiltered_product_ids';

 				if (false === ($unfiltered_product_ids = get_transient($transient_name))) {
 					$unfiltered_product_ids = get_posts($args);
 					set_transient($transient_name, $unfiltered_product_ids, wcapf_transient_lifespan());
 				}

 				return $unfiltered_product_ids;
 			} else {
 				global $wp_query;
 				$current_query = $wp_query;
 				$date_queries = array();

 				$current_query = json_decode(json_encode($current_query), true);

 				$meta_queries = (isset($current_query['meta_query']['queries'])) ? $current_query['meta_query']['queries'] : array();
 				$tax_queries = $current_query['tax_query']['queries'];
 				if (isset($current_query['date_query']['queries'])) {
 					$date_queries = $current_query['date_query']['queries'];	
 				}

 				$args = array(
 					'post_type'              => 'product',
 					'numberposts'            => -1,
 					'post_status'            => 'publish',
 					'meta_query'             => $meta_queries,
 					'tax_query'              => $tax_queries,
 					'date_query'             => $date_queries,
 					'fields'                 => 'ids',
 					'no_found_rows'          => true,
 					'update_post_meta_cache' => false,
 					'update_post_term_cache' => false,
 					'pagename'               => '',
 				);

 				$unfiltered_product_ids = get_posts($args);

 				if ($unfiltered_product_ids && !is_wp_error($unfiltered_product_ids)) {
 					return $unfiltered_product_ids;
 				} else {
 					return array();
 				}
 			}
 		}

		/**
		 * Get filtered product ids.
		 *
		 * @return array
		 */
		public function filteredProductIds()
		{
			global $wp_query;
			$current_query = $wp_query;

			if (!is_object($current_query) && !is_main_query() && !is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
				return;
			}

			$modified_query = $current_query->query;
			unset($modified_query['paged']);
			$meta_query = (key_exists('meta_query', $current_query->query_vars)) ? $current_query->query_vars['meta_query'] : array();
			$tax_query = (key_exists('tax_query', $current_query->query_vars)) ? $current_query->query_vars['tax_query'] : array();
			$date_query = (key_exists('date_query', $current_query->query_vars)) ? $current_query->query_vars['date_query'] : array();
			$post__in = (key_exists('post__in', $current_query->query_vars)) ? $current_query->query_vars['post__in'] : array();

			$filtered_product_ids = get_posts(
				array_merge(
					$modified_query,
					array(
						'post_type'   => 'product',
						'numberposts' => -1,
						'post_status' => 'publish',
						'post__in'    => $post__in,
						'meta_query'  => $meta_query,
						'tax_query'   => $tax_query,
						'date_query'  => $date_query,
						'fields'      => 'ids',
						'no_found_rows' => true,
						'update_post_meta_cache' => false,
						'update_post_term_cache' => false,
						'pagename'    => '',
					)
				)
			);

			return $filtered_product_ids;
		}

		/**
		 * Find Prices for given products.
		 *
		 * @param  array $products
		 * @return array
		 */
		public function findPriceRange($products)
		{
			$price_range = array();

			foreach ($products as $id) {
				$meta_value = get_post_meta($id, '_price', true);

				if ($meta_value) {
					$price_range[] = $meta_value;
				}

				// for child posts
				$product_variation = get_children(
					array(
						'post_type'   => 'product_variation',
						'post_parent' => $id,
						'numberposts' => -1
					)
				);

				if (sizeof($product_variation) > 0) {
					foreach ($product_variation as $variation) {
						$meta_value = get_post_meta($variation->ID, '_price', true);
						if ($meta_value) {
							$price_range[] = $meta_value;
						}
					}
				}
			}

			$price_range = array_unique($price_range);

			return $price_range;
		}

		/**
		 * Find price range for filtered products.
		 *
		 * @return array
		 */
		public function filteredProductsPriceRange()
		{
			$products = $this->filteredProductIds();

			if (sizeof($products) < 1) {
				return;
			}

			$filtered_products_price_range = $this->findPriceRange($products);

			return $filtered_products_price_range;
		}

		/**
		 * Find price range for unfiltered products.
		 *
		 * @return array
		 */
		public function unfilteredProductsPriceRange()
		{
			$products = $this->unfilteredProductIds();

			if (sizeof($products) < 1) {
				return;
			}

			// get unfiltered products price range using transients
			$transient_name = 'wcapf_unfiltered_product_price_range';

			if (false === ($unfiltered_products_price_range = get_transient($transient_name))) {
				$unfiltered_products_price_range = $this->findPriceRange($products);
				set_transient($transient_name, $unfiltered_products_price_range, wcapf_transient_lifespan());
			}

			return $unfiltered_products_price_range;
		}

		/**
		 * Get Price Range for given product ids.
		 * If filtered is true then return price range for filtered products,
		 * otherwise return price range for all products.
		 *
		 * @param  boolean $filtered
		 * @return array
		 */
		public function getPriceRange($filtered = true)
		{
			if ($filtered === true) {
				$price_range = $this->filteredProductsPriceRange();
			} else {
				$price_range = $this->unfilteredProductsPriceRange();
			}

			if (sizeof( (array) $price_range) >= 1) {
				$min = $max = false;

				foreach ($price_range as $price) {
					if ($min === false || $min > (int)$price) {
						$min = floor($price);
					}

					if ($max === false || $max < (int)$price) {
						$max = ceil($price);
					}
				}

				// if tax enabled and shop page shows price including tax
				if (wc_tax_enabled() && 'incl' === get_option('woocommerce_tax_display_shop') && ! wc_prices_include_tax()) {
					$tax_classes = array_merge(array( ''), WC_Tax::get_tax_classes());

					foreach ($tax_classes as $tax_class) {
						$tax_rates = WC_Tax::get_rates($tax_class);
						$class_min = $min + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($min, $tax_rates));
						$class_max = $max + WC_Tax::get_tax_total(WC_Tax::calc_exclusive_tax($max, $tax_rates));

						$min = $max = false;

						if ($min === false || $min > (int)$class_min) {
							$min = floor($class_min);
						}

						if ($max === false || $max < (int)$class_max) {
							$max = ceil($class_max);
						}
					}
				}

				// if WooCommerce Currency Switcher plugin is activated
				if (class_exists('WOOCS')) {
					global $WOOCS;

					$min = floor($WOOCS->woocs_exchange_value($min));
					$max = ceil($WOOCS->woocs_exchange_value($max));
				}

				// Return values even if they are the same
					return apply_filters('wcapf_min_max_prices', array($min, $max));

			} else {
				// empty array
				return array();
			}
		}

		/**
		 * HTML wrapper to insert before the shop loop.
		 *
		 * @return string
		 */
		public static function beforeProductsHolder()
		{
			echo '<div class="wcapf-before-products">';
		}

		/**
		 * HTML wrapper to insert after the shop loop.
		 *
		 * @return string
		 */
		public static function afterProductsHolder()
		{
			echo '</div>';
		}

		/**
		 * HTML wrapper to insert before the not found product loops.
		 *
		 * @param  string $template_name
		 * @param  string $template_path
		 * @param  string $located
		 * @return string
		 */
		public static function beforeNoProducts($template_name = '', $template_path = '', $located = '') {
		    if ($template_name == 'loop/no-products-found.php') {
		        echo '<div class="wcapf-before-products">';
		    }
		}

		/**
		 * HTML wrapper to insert after the not found product loops.
		 *
		 * @param  string $template_name
		 * @param  string $template_path
		 * @param  string $located
		 * @return string
		 */
		public static function afterNoProducts($template_name = '', $template_path = '', $located = '') {
		    if ($template_name == 'loop/no-products-found.php') {
		        echo '</div>';
		    }
		}

		/**
		 * Decode pagination links.
		 *
		 * @param string $link
		 *
		 * @return string
		 */
		public static function paginateLinks($link)
		{
			$link = urldecode($link);
			return $link;
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function loadPluginTextdomain()
		{
			load_plugin_textdomain('wcapf', FALSE, basename(dirname(__FILE__)) . '/languages/');
		}

		/**
		 * Get the plugin Path.
		 *
		 * @return string
		 */
		public function pluginPath()
		{
			return untrailingslashit(plugin_dir_url(__FILE__));
		}

		/**
		 * Get the plugin assets path.
		 *
		 * @return string
		 */
		public function assetsPath()
		{
			return trailingslashit(plugin_dir_url(__FILE__) . 'assets/');
		}

		/**
		 * Show admin notice if woocommerce plugin not found.
		 */
		public function needWoocommerce()
		{
			echo '<div class="error">';
			echo '<p>' . __('WC Ajax Product Filter needs WooCommerce plugin to work.', 'wcapf') . '</p>';
			echo '</div>';
		}

		/**
		 * Show admin notice if woocommerce plugin version is older than required version.
		 */
		public function updateWoocommerce()
		{
			echo '<div class="error">';
			echo '<p>' . __('To use WC Ajax Product Filter update your WooCommerce plugin.', 'wcapf') . '</p>';
			echo '</div>';
		}

		/**
		 * Show action links on the plugins page.
		 *
		 * @param  array $links
		 * @return array
		 */
		public function pluginActionLinks($links)
		{
			$links[] = '<a href="' . admin_url('options-general.php?page=wcapf-settings') . '">' . __('Settings', 'wcapf') . '</a>';
			return $links;
		}
	}
}

/**
 * Instantiate this class globally.
 */
$GLOBALS['wcapf'] = WCAPF::instance();
