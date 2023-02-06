<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_Variable_Atc {
	protected $settings;

	public function __construct() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		if ( $this->settings->get_params( 'ajax_atc_pd_variable' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ) );
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'viwcaio_woocommerce_loop_add_to_cart_link' ), PHP_INT_MAX, 3 );
		}
		if ( $this->settings->get_params( 'pd_variable_bt_atc_text_enable' ) ) {
			add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'viwcaio_woocommerce_product_add_to_cart_text' ), PHP_INT_MAX, 2 );
		}
	}

	public function viwcaio_woocommerce_loop_add_to_cart_link( $result, $product ) {
		if ( $product->is_type( 'variable' ) ) {
			if ( ! wp_style_is( 'vi-wcaio-variable-atc', 'enqueued' ) ) {
				wp_enqueue_style( 'vi-wcaio-variable-atc' );
				wp_enqueue_style( 'vi-wcaio-nav-icons' );
			}
			if ( ! wp_script_is( 'vi-wcaio-variable-atc', 'enqueued' ) ) {
				wp_enqueue_script( 'vi-wcaio-variable-atc' );
				wp_enqueue_script( 'vi-wcaio-ajax-atc' );
				wp_enqueue_script( 'vi-wcaio-frontend-swatches' );
			}
			$result = str_replace( 'class="', 'class="vi-wcaio-loop-variable-bt-atc ', $result );
		}

		return $result;
	}

	public function viwcaio_woocommerce_product_add_to_cart_text( $var, $instance ) {
		$product = wc_get_product( get_the_ID() );
		if ( $product && $product->is_type( 'variable' ) ) {
			return $this->settings->get_params( 'pd_variable_bt_atc_text' );
		}

		return $var;
	}

	public function viwcaio_wp_enqueue_scripts() {
		if ( is_admin() ) {
			return;
		}
		wp_register_style( 'vi-wcaio-variable-atc', VI_WOO_CART_ALL_IN_ONE_CSS . 'variable-atc.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_register_style( 'vi-wcaio-nav-icons', VI_WOO_CART_ALL_IN_ONE_CSS . 'nav-icons.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		$suffix = WP_DEBUG ? '' : 'min.';
		wp_register_script( 'vi-wcaio-variable-atc', VI_WOO_CART_ALL_IN_ONE_JS . 'variable-atc.' . $suffix . 'js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_register_script( 'vi-wcaio-ajax-atc', VI_WOO_CART_ALL_IN_ONE_JS . 'ajax-add-to-cart.' . $suffix . 'js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_register_script( 'vi-wcaio-frontend-swatches', VI_WOO_CART_ALL_IN_ONE_JS . 'frontend-swatches.' . $suffix . 'js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		$args = array(
			'wc_ajax_url' => WC_AJAX::get_endpoint( "%%endpoint%%" ),
		);
		wp_localize_script( 'vi-wcaio-variable-atc', 'viwcaio_va_params', $args );
		$args1 = array(
			'ajax_atc'                            => $this->settings->get_params( 'ajax_atc' ),
			'wc_ajax_url'                         => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'woocommerce_enable_ajax_add_to_cart' => 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ? 1 : '',
			'added_to_cart'                       => did_action( 'woocommerce_add_to_cart' ) ?: '',
			'ajax_atc_pd_exclude'                 => $this->settings->get_params( 'ajax_atc_pd_exclude' ) ?: array(),
			'i18n_make_a_selection_text'          => apply_filters( 'vi-wcaio-i18n_make_a_selection_text', esc_html__( 'Please select some product options before adding this product to your cart.', 'woo-cart-all-in-one' ) ),
			'i18n_unavailable_text'               => apply_filters( 'vi-wcaio-i18n_unavailable_text', esc_html__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woo-cart-all-in-one' ) ),
			'cart_url'                            => apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url(), null ),
			'cart_redirect_after_add'             => get_option( 'woocommerce_cart_redirect_after_add' ),
		);
		wp_localize_script( 'vi-wcaio-ajax-atc', 'viwcaio_ajax_atc_params', $args1 );
	}
}