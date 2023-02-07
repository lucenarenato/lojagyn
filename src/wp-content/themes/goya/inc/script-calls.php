<?php

/* Enqueue Styles
---------------------------------------------------------- */

	define( 'GOYA_SCRIPT_DEBUG', apply_filters( 'goya_script_debug', false ) );

	// Paths
	define( 'GOYA_ASSET_CSS', GOYA_THEME_URI . '/assets/css' );
	define( 'GOYA_ASSET_JS', GOYA_THEME_URI . '/assets/js' );
	define( 'GOYA_ASSET_ICON', GOYA_THEME_URI . '/assets/icons' );


	// Main Styles
	function goya_styles() {
		global $post;
			
		// Typekit fonts
		if ( get_theme_mod('main_font_source', '1') === '2' && get_theme_mod('main_font_typekit_kit_id', '') != '' ) {
			wp_enqueue_style( 'goya-typekit-main', '//use.typekit.net/' . esc_attr( get_theme_mod('main_font_typekit_kit_id', '') ) . '.css' );
		}
		if ( get_theme_mod('second_font_source', '1') === '2' && get_theme_mod('second_font_typekit_kit_id', '') != '' ) {
			wp_enqueue_style( 'goya-typekit-second', '//use.typekit.net/' . esc_attr( get_theme_mod('second_font_typekit_kit_id', '') ) . '.css' );
		}

		//Theme Styles
		wp_enqueue_style( 'goya-grid', GOYA_ASSET_CSS . '/grid.css', array(), GOYA_THEME_VERSION, 'all' );
		wp_enqueue_style( 'goya-core', GOYA_ASSET_CSS . '/core.css', array(), GOYA_THEME_VERSION, 'all' );

		// Theme icon font
		wp_enqueue_style( 'goya-icons', GOYA_ASSET_ICON . '/theme-icons/style.css', array(), GOYA_THEME_VERSION, 'all' );

		
		// WooCommerce
		if( goya_wc_active() ) {
			wp_enqueue_style( 'goya-shop', GOYA_ASSET_CSS . '/shop.css', array(), GOYA_THEME_VERSION, 'all' );
		}
		
		// Visual Composer elements
		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			wp_enqueue_style( 'goya-elements', GOYA_ASSET_CSS . '/vc-elements.css', array(), GOYA_THEME_VERSION, 'all' );
		}

		// Load RTL stylesheet if necessary
		if ( is_rtl() ) {
			wp_enqueue_style( 'goya-rtl', GOYA_ASSET_CSS . '/rtl.css', array(), GOYA_THEME_VERSION, 'all' );
		}

		// Inline styles from the customizer
		wp_register_style('goya-customizer-styles', false); // Register handle
		wp_enqueue_style('goya-customizer-styles');
		wp_add_inline_style('goya-customizer-styles', goya_custom_styles());

	}

	add_action('wp_enqueue_scripts', 'goya_styles', 10);



/* Register Scripts
---------------------------------------------------------- */

	function goya_scripts() {

		// Script path and suffix setup (debug mode loads un-minified scripts)
		if ( defined( 'GOYA_SCRIPT_DEBUG' ) && GOYA_SCRIPT_DEBUG ) {
			$script_path = GOYA_ASSET_JS . '/dev/';
			$suffix = '';
		} else {
			$script_path = GOYA_ASSET_JS . '/';
			$suffix = '.min';
		}
		
		if (!is_admin()) {
			global $post;

			// Script loaded by WordPress
			wp_enqueue_script( 'imagesloaded' );
			
			if ( apply_filters('goya_do_lazyload', get_theme_mod('lazy_load',false)) == true ) {
				// Lazy loading
				wp_enqueue_script( 'lazy-sizes',  GOYA_ASSET_JS . '/vendor/lazysizes.min.js', array( 'jquery' ), '5.3.0', TRUE);
			}
			// Detect browser capabilites
			wp_enqueue_script( 'modernizr', GOYA_ASSET_JS . '/vendor/modernizr.min.js', array('jquery'), '2.8.3', TRUE);
			wp_enqueue_script( 'mobile-detect',  GOYA_ASSET_JS . '/vendor/mobile-detect.min.js', array( 'jquery' ), '1.3.2', TRUE);
			wp_enqueue_script( 'in-viewport',  GOYA_ASSET_JS . '/vendor/isInViewport.min.js', array( 'jquery' ), '3.0.4', TRUE);
			
			// Autocomplete
			wp_enqueue_script( 'autocomplete',  GOYA_ASSET_JS . '/vendor/jquery.autocomplete.min.js', array( 'jquery' ), '1.4.1', TRUE);
			// Magnific Popup
			wp_enqueue_script( 'magnific-popup',  GOYA_ASSET_JS . '/vendor/jquery.magnific-popup.min.js', array( 'jquery' ), '3.0.1', TRUE);
			// Scrollbars
			wp_enqueue_script( 'perfect-scrollbar',  GOYA_ASSET_JS . '/vendor/perfect-scrollbar.jquery.min.js', array( 'jquery' ), '0.8.0', TRUE);
			//Sticky elements
			wp_enqueue_script( 'sticky-kit',  GOYA_ASSET_JS . '/vendor/sticky-kit.min.js', array( 'jquery' ), '1.1.3', TRUE);
			// Slick carousel
			wp_enqueue_script( 'jquery-slick',  GOYA_ASSET_JS . '/vendor/slick.min.js', array( 'jquery' ), '1.8.1', TRUE);
			// Masonry layouts
			wp_enqueue_script( 'isotope-pk',  GOYA_ASSET_JS . '/vendor/isotope.pkgd.min.js', array( 'jquery' ), '3.0.6', TRUE);
			wp_enqueue_script( 'packery',  GOYA_ASSET_JS . '/vendor/packery-mode.pkgd.min.js', array( 'jquery', ), '2.0.1', TRUE);
			// Underscore
			wp_enqueue_script('underscore');
			// Manage cookies
			wp_enqueue_script( 'cookie',  GOYA_ASSET_JS . '/vendor/jquery.cookie.min.js', array( 'jquery' ), '1.4.1');
			// Check for new/deleted DOM elements
			wp_enqueue_script( 'arrive',  GOYA_ASSET_JS . '/vendor/arrive.min.js', array( 'jquery' ), '2.4.1', TRUE);
			// Mobile menu
			if ( get_theme_mod('mobile_menu_type', 'sliding') == 'sliding') {
				wp_enqueue_script( 'sliding-menu',  GOYA_ASSET_JS . '/vendor/sliding-menu.min.js', array( 'jquery' ), '0.2.1', TRUE);	
			}
			// Comments
			if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) ) {
				wp_enqueue_script('comment-reply');
			}
			// Theme Core Script
			if( goya_wc_active() ) { // WooCommerce
				// Image zoom
				if ( goya_meta_config('product','image_hover_zoom',false) == true && is_product() ) {
					wp_enqueue_script('easyzoom', GOYA_ASSET_JS . '/vendor/easyzoom.min.js', array('jquery'), '2.5.2', TRUE);
				}
				// Core App script
				wp_enqueue_script('goya-app', $script_path . 'goya-app' . $suffix . '.js', array('jquery', 'underscore','wc-add-to-cart-variation'), GOYA_THEME_VERSION, TRUE);
			} else {
				// Core App script
				wp_enqueue_script('goya-app', $script_path . 'goya-app' . $suffix . '.js', array('jquery', 'underscore'), GOYA_THEME_VERSION, TRUE);
			}

			// Run animations when goya-app is delayed
			if ( apply_filters('goya_load_animations_script', false) == true ) {
				wp_enqueue_script('goya-animations', GOYA_ASSET_JS . '/goya-animations.min.js', '', GOYA_THEME_VERSION, TRUE);
			}

			// Theme variables
			$is_checkout = goya_wc_active() ? goya_is_real_checkout() : false;

			wp_localize_script( 'goya-app', 'goya_theme_vars', array( 
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'l10n' => array (
					'back' => esc_html__("Back", 'goya'),
					'view_cart' => esc_html__("View cart", 'goya')
				),
				'icons' => array(
					'prev_arrow' => goya_load_template_part('assets/img/svg/chevron-left.svg'),
					'next_arrow' => goya_load_template_part('assets/img/svg/chevron-right.svg'),
				),
				'settings' => array (
					'current_url' => get_permalink(),
					'site_url' => site_url(),
					'pageLoadTransition' => goya_meta_config('','page_transition',false),
					'ajaxSearchActive' => get_theme_mod( 'ajax_search', true ),
					'ajaxAddToCartSingle' => apply_filters('goya_ajax_atc_single_product', get_theme_mod( 'product_single_ajax_addtocart', true )),
					'cart_icon' => get_theme_mod( 'header_cart_icon_function', 'mini-cart' ),
					'minicart_auto' => get_theme_mod( 'open_minicart_automatically', true ),
					'shop_infinite_load' => goya_meta_config('shop','infinite_load','button'),
					'shop_update_url' => apply_filters( 'goya_shop_ajax_update_url', false ),
					'ajaxWishlistCounter' => get_theme_mod( 'ajax_wishlist_counter', false ),
					'YITH_WCWL_Premium' => class_exists('YITH_WCWL_Premium') ? true : false,
					'posts_per_page' => get_option('posts_per_page'),
					'related_slider' => get_theme_mod( 'product_upsell_related_slider', true ),
					'popup_length' => get_theme_mod( 'popup_frequency', 1 ),
					'is_front_page' => is_front_page(),
					'is_blog'  => goya_is_blog(),
					'is_cart'  => goya_wc_active() ? is_cart() : false,
					'is_checkout' => $is_checkout,
					'checkoutTermsPopup' => get_theme_mod( 'checkout_terms_popup', true ),
					'single_atc_nonce' => wp_create_nonce( 'goya-add-to-cart' ),
					'facebook4WC' => apply_filters( 'goya_wc_facebook_ajax_atc', in_array('facebook-for-woocommerce/facebook-for-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ),
				),
			) );
		}
	}
	add_action('wp_enqueue_scripts', 'goya_scripts');

/* Admin Assets
---------------------------------------------------------- */

	/* Load admin assets */
	function goya_admin_assets( $hook ) {
		
		// Admin CSS
		wp_enqueue_style( 'goya-admin-css', GOYA_ASSET_CSS . '/admin/admin.min.css', null, GOYA_THEME_VERSION);

		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {

			// Gutenberg styles
			wp_enqueue_style( 'goya-gutenberg', GOYA_ASSET_CSS . '/admin/gutenberg.css', false, GOYA_THEME_VERSION, 'all' );
			wp_add_inline_style( 'goya-gutenberg', goya_gutenberg_styles() );

			wp_enqueue_style( 'wp-color-picker' ); 

			// WP Bakery styles
			if (class_exists('WPBakeryVisualComposerAbstract')) {
				wp_enqueue_style( 'goya-admin-vc-css', GOYA_ASSET_CSS . '/admin/admin-vc.min.css', null, GOYA_THEME_VERSION);
				wp_enqueue_script( 'goya-admin-vc', GOYA_ASSET_JS . '/admin/admin-vc.min.js', array('jquery'), GOYA_THEME_VERSION);
			}

		}

		if ( in_array( $hook, array( 'post.php', 'post-new.php', 'nav-menus.php', 'term.php' ) ) ) {
			
			// General JS scripts
			wp_enqueue_script( 'goya-admin-general', GOYA_ASSET_JS . '/admin/admin-general.min.js', array( 'jquery', 'wp-color-picker' ), GOYA_THEME_VERSION, true );
		}
		
	}
	add_action( 'admin_enqueue_scripts', 'goya_admin_assets' );


	/* Load assets on login page */
	function goya_wp_login_assets( $hook ) {
		// Admin CSS
		wp_enqueue_style( 'goya-admin-css', GOYA_ASSET_CSS . '/admin/admin.min.css', null, GOYA_THEME_VERSION);
		// Theme icon font
		wp_enqueue_style( 'goya-icons', GOYA_ASSET_ICON . '/theme-icons/style.css', array(), GOYA_THEME_VERSION, 'all' );
	}
	add_action( 'login_enqueue_scripts', 'goya_wp_login_assets' );


	/* WooCommerce */
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );


	/* Shortcode inline styles
	---------------------------------------------------------- */
	
	function goya_enqueue_shortcodes_styles() {
		
		wp_register_style('goya-shortcodes-styles', false); // Register handle
		wp_enqueue_style('goya-shortcodes-styles');
		wp_add_inline_style('goya-shortcodes-styles', Goya_Layout::get_shortcodes_css_buffer(false));

	}

	add_action('wp_footer', 'goya_enqueue_shortcodes_styles');

	
	class Goya_Layout {

		static private $dynamic_shortcodes_css_buffer_code = array();

		// Show or return dynamic CSS code
		static function get_shortcodes_css_buffer( $print = false ) {
			if ( $print ) {
				echo implode( '', self::$dynamic_shortcodes_css_buffer_code );
				return true;
			} else {
				return implode( '', self::$dynamic_shortcodes_css_buffer_code );
			}
		}

		// Shortcodes dynamic CSS to buffer code
		static function append_to_shortcodes_css_buffer( $append_string = '' ) {
			$append_string = trim( $append_string );
			if ( strlen( $append_string ) == 0 ) { return false; }
			$append_array = preg_split( "/((\r?\n)|(\r\n?))/", $append_string );
			$new_append_string = '';
			foreach( $append_array as $index => $append_line ){
				$append_line = trim( $append_line );
				if ( strlen( $append_line ) == 0 ) { continue; }
				$new_append_string .= $append_line;
			}
			self::$dynamic_shortcodes_css_buffer_code[] = $new_append_string;
			return true;
		}

	}



	/* Default font
	---------------------------------------------------------- */
	
	function goya_has_default_font() {

		$main_font_family = $second_font_family = '';

		if ( get_theme_mod('main_font_source', '1') == '1' ) {
			$main_font = get_theme_mod( 'main_font', array() );
			$main_font_family = isset($main_font['font-family']) ? $main_font['font-family'] : '';
		}
		if ( get_theme_mod('second_font_source', '0') == '1' ) {
			$second_font = get_theme_mod( 'second_font', array() );
			$second_font_family = isset($second_font['font-family']) ? $second_font['font-family'] : '';
		}

		if ($main_font_family == '' || $main_font_family == 'Jost, sans-serif' || $second_font_family == 'Jost, sans-serif') {
			return true;
		} else {
			return false;
		}

	}
	

	/* Clean CSS inline styles
	---------------------------------------------------------- */

		function goya_clean_custom_css($styles) {

			// Remove comments
			$styles = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $styles);
			// Remove space after colons
			$styles = str_replace(': ', ':', $styles);
			// Remove whitespace
			$styles = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $styles);

			return $styles;
			
		}

		
	/* Deregister unnecessary styles
		---------------------------------------------------------- */

		function goya_deregister_styles() {

			// From YITH Wishlist
			// It may cause a warning in Query Monitor because it has other dependencies.
			//wp_deregister_style( 'yith-wcwl-font-awesome' );


		}
		add_action( 'wp_print_styles', 'goya_deregister_styles', 100 );

		