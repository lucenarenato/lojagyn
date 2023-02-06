<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_Ajax_Add_to_Cart {
	protected $settings;

	public function __construct() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ) );
	}

	public function viwcaio_wp_enqueue_scripts() {
		if ( is_admin() || is_customize_preview() ) {
			return;
		}
		if ( ! $this->settings->get_params( 'ajax_atc' ) ) {
			return;
		}
		if ( WP_DEBUG ) {
			wp_enqueue_script( 'vi-wcaio-ajax-atc', VI_WOO_CART_ALL_IN_ONE_JS . 'ajax-add-to-cart.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		} else {
			wp_enqueue_script( 'vi-wcaio-ajax-atc', VI_WOO_CART_ALL_IN_ONE_JS . 'ajax-add-to-cart.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}
		$args = array(
			'ajax_atc'                            => 1,
			'wc_ajax_url'                         => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'added_to_cart'                       => did_action( 'woocommerce_add_to_cart' ) ?: '',
			'woocommerce_enable_ajax_add_to_cart' => 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ? 1 : '',
			'ajax_atc_pd_exclude'                 => $this->settings->get_params( 'ajax_atc_pd_exclude' ) ?: array(),
			'i18n_make_a_selection_text'          => apply_filters( 'vi-wcaio-i18n_make_a_selection_text', esc_html__( 'Please select some product options before adding this product to your cart.', 'woo-cart-all-in-one' ) ),
			'i18n_unavailable_text'               => apply_filters( 'vi-wcaio-i18n_unavailable_text', esc_html__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woo-cart-all-in-one' ) ),
			'cart_url'                            => apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url(), null ),
			'cart_redirect_after_add'             => get_option( 'woocommerce_cart_redirect_after_add' ),
		);
		wp_localize_script( 'vi-wcaio-ajax-atc', 'viwcaio_ajax_atc_params', $args );
	}
}