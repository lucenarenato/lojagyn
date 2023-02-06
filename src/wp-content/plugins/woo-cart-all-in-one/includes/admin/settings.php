<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Settings {
	public function __construct() {
		add_action( 'wp_ajax_viwcaio_search_product', array( $this, 'viwcaio_search_product' ) );
		add_action( 'wp_ajax_viwcaio_search_cats', array( $this, 'viwcaio_search_cats' ) );
	}

	public function viwcaio_search_cats() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( ! $keyword ) {
			$keyword = filter_input( INPUT_POST, 'keyword', FILTER_SANITIZE_STRING );
		}
		if ( empty( $keyword ) ) {
			die();
		}
		$categories = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'orderby'  => 'name',
				'order'    => 'ASC',
				'search'   => $keyword,
				'number'   => 100
			)
		);
		$items      = array();
		if ( count( $categories ) ) {
			foreach ( $categories as $category ) {
				$item    = array(
					'id'   => $category->term_id,
					'text' => $category->name
				);
				$items[] = $item;
			}
		}
		wp_send_json( $items );
		die;
	}

	public function viwcaio_search_product() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( ! $keyword ) {
			$keyword = filter_input( INPUT_POST, 'keyword', FILTER_SANITIZE_STRING );
		}
		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => array( 'product' ),
			'posts_per_page' => 50,
			's'              => $keyword

		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$prd           = wc_get_product( get_the_ID() );
				$product_id    = get_the_ID();
				$product_title = get_the_title() . '(#' . $product_id . ')';
				if ( ! $prd->is_in_stock() ) {
					continue;
				}

				if ( $prd->has_child() && $prd->is_type( 'variable' ) ) {
					$product_title    .= '(#VARIABLE)';
					$product          = array( 'id' => $product_id, 'text' => $product_title );
					$found_products[] = $product;
					$product_children = $prd->get_children();
					if ( count( $product_children ) ) {
						foreach ( $product_children as $product_child ) {
							$child_wc         = wc_get_product( $product_child );
							$get_atts         = $child_wc->get_variation_attributes();
							$attr_name        = array_values( $get_atts )[0];
							$product          = array(
								'id'   => $product_child,
								'text' => get_the_title() . ' - ' . $attr_name
							);
							$found_products[] = $product;
						}

					}
				} else {
					$product          = array( 'id' => $product_id, 'text' => $product_title );
					$found_products[] = $product;
				}
			}
		}
		wp_reset_postdata();
		wp_send_json( $found_products );
		die;
	}

	public static function remove_other_script() {
		global $wp_scripts;
		if ( isset( $wp_scripts->registered['jquery-ui-accordion'] ) ) {
			unset( $wp_scripts->registered['jquery-ui-accordion'] );
			wp_dequeue_script( 'jquery-ui-accordion' );
		}
		if ( isset( $wp_scripts->registered['accordion'] ) ) {
			unset( $wp_scripts->registered['accordion'] );
			wp_dequeue_script( 'accordion' );
		}
		$scripts = $wp_scripts->registered;
		foreach ( $scripts as $k => $script ) {
			preg_match( '/^\/wp-/i', $script->src, $result );
			if ( count( array_filter( $result ) ) ) {
				preg_match( '/^(\/wp-content\/plugins|\/wp-content\/themes)/i', $script->src, $result1 );
				if ( count( array_filter( $result1 ) ) ) {
					wp_dequeue_script( $script->handle );
				}
			} else {
				if ( $script->handle != 'query-monitor' ) {
					wp_dequeue_script( $script->handle );
				}
			}
		}
	}

	public static function enqueue_style( $handles = array(), $srcs = array(), $des = array(), $type = 'enqueue' ) {
		if ( empty( $handles ) || empty( $srcs ) ) {
			return;
		}
		$action = $type === 'enqueue' ? 'wp_enqueue_style' : 'wp_register_style';
		foreach ( $handles as $i => $handle ) {
			if ( ! $handle || empty( $srcs[ $i ] ) ) {
				continue;
			}
			$action( $handle, VI_WOO_CART_ALL_IN_ONE_CSS . $srcs[ $i ], ! empty( $des[ $i ] ) ? $des[ $i ] : array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}
	}

	public static function enqueue_script( $handles = array(), $srcs = array(), $des = array(), $type = 'enqueue', $in_footer = false ) {
		if ( empty( $handles ) || empty( $srcs ) ) {
			return;
		}
		$action = $type === 'register' ? 'wp_register_script' : 'wp_enqueue_script';
		foreach ( $handles as $i => $handle ) {
			if ( ! $handle || empty( $srcs[ $i ] ) ) {
				continue;
			}
			$action( $handle, VI_WOO_CART_ALL_IN_ONE_JS . $srcs[ $i ], ! empty( $des[ $i ] ) ? $des[ $i ] : array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION, $in_footer );
		}
	}

}