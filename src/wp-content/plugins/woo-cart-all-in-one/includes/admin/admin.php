<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Admin {
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_filter(
			'plugin_action_links_woo-cart-all-in-one/woo-cart-all-in-one.php', array(
				$this,
				'settings_link'
			)
		);
	}

	public function settings_link( $links ) {
		$settings_link = sprintf( '<a href="%s?page=woo-cart-all-in-one" title="%s">%s</a>', esc_attr( admin_url( 'admin.php' ) ),
			esc_attr__( 'Settings', 'woo-cart-all-in-one' ),
			esc_html__( 'Settings', 'woo-cart-all-in-one' )
		);
		array_unshift( $links, $settings_link );

		return $links;
	}

	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woo-cart-all-in-one' );
		load_textdomain( 'woo-cart-all-in-one', VI_WOO_CART_ALL_IN_ONE_LANGUAGES . "woo-cart-all-in-one-$locale.mo" );
		load_plugin_textdomain( 'woo-cart-all-in-one', false, VI_WOO_CART_ALL_IN_ONE_LANGUAGES );

	}

	public function init() {
		load_plugin_textdomain( 'woo-cart-all-in-one' );
		$this->load_plugin_textdomain();
		if ( class_exists( 'VillaTheme_Support' ) ) {
			new VillaTheme_Support(
				array(
					'support'   => 'https://wordpress.org/support/plugin/woo-cart-all-in-one/',
					'docs'      => 'http://docs.villatheme.com/?item=woocommerce-cart-all-in-one',
					'review'    => 'https://wordpress.org/support/plugin/woo-cart-all-in-one/reviews/?rate=5#rate-response',
					'pro_url'   => 'https://1.envato.market/bW20B',
					'css'       => VI_WOO_CART_ALL_IN_ONE_CSS,
					'image'     => VI_WOO_CART_ALL_IN_ONE_IMAGES,
					'slug'      => 'woo-cart-all-in-one',
					'menu_slug' => 'woo-cart-all-in-one',
					'version'   => VI_WOO_CART_ALL_IN_ONE_VERSION
				)
			);
		}
	}
}