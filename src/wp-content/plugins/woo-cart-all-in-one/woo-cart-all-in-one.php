<?php
/**
 * Plugin Name: Cart All In One For WooCommerce
 * Plugin URI: https://villatheme.com/extensions/woocommerce-cart-all-in-one/
 * Description: Cart All In One For WooCommerce helps your customers view cart effortlessly.
 * Author: VillaTheme
 * Author URI:https://villatheme.com
 * Version: 1.1.9
 * Text Domain: woo-cart-all-in-one
 * Domain Path: /languages
 * Copyright 2019-2022 VillaTheme.com. All rights reserved.
 * Requires PHP: 7.0
 * Requires at least: 5.0
 * Tested up to:6.0
 * WC requires at least: 5.0
 * WC tested up to: 6.5
 */

if (!defined('ABSPATH')) {
    exit();
}
define( 'VI_WOO_CART_ALL_IN_ONE_VERSION', '1.1.9' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce-cart-all-in-one/woocommerce-cart-all-in-one.php' ) ) {
	return;
}
$viwcaio_errors = array();
if ( ! version_compare( phpversion(), '7.0', '>=' ) ) {
	$viwcaio_errors[] = esc_html__( 'Please update PHP version at least 7.0 to use Cart All In One For WooCommerce.', 'woo-cart-all-in-one' );
}
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	$viwcaio_errors[] = esc_html__( 'Please install and activate WooCommerce to use Cart All In One For WooCommerce.', 'woo-cart-all-in-one' );
}
if ( empty( $viwcaio_errors ) ) {
	define( 'VI_WOO_CART_ALL_IN_ONE_DIR',  plugin_dir_path( __FILE__ ) );
	define( 'VI_WOO_CART_ALL_IN_ONE_INC', VI_WOO_CART_ALL_IN_ONE_DIR . "includes" . DIRECTORY_SEPARATOR );
	$init_file = VI_WOO_CART_ALL_IN_ONE_INC . "define.php";
	require_once $init_file;
}


class WOO_CART_ALL_IN_ONE
{
	protected $errors;
    public function __construct($errors = array())
    {
	    $this->errors = $errors;
	    if ( ! empty( $errors ) ) {
		    add_action( 'admin_notices', array( $this, 'global_note' ) );
		    return;
	    }
    }

    /**
     * Notify if WooCommerce is not activated
     */
    function global_note()
    {
	    if ( count( $this->errors ) ) {
		    foreach ( $this->errors as $error ) {
			    echo sprintf( '<div id="message" class="error"><p>%s</p></div>', esc_html( $error ) );
		    }
	    }
    }
}

new WOO_CART_ALL_IN_ONE($viwcaio_errors);