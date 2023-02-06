<?php
/*
Plugin Name: Inventory Source: Dropship Automation
Plugin URI: http://www.inventorysource.com/dropship-wordpress-plugin/
Description: Make dropshipping simple. Automatically upload and update your Wordpress / WooCommerce site with dropship products to monetize your traffic and build an eCommerce business.
Version: 1.0
Author: Inventory Source
Author URI: http://www.inventorysource.com/blog/author/inventorysource/
License: GPLv2 or later
*/
if ( ! defined( 'ABSPATH' ) ) exit; 
register_activation_hook( __FILE__, 'dropship_automation_install' );
load_plugin_textdomain( 'inventory-source-dropship-automation', false, dirname( plugin_basename( __FILE__ ) ) );
function dropship_automation_menu() {
    add_menu_page('Inventory Source', 'Inventory Source', 'manage_options', 'inventory-source-dropship-automation/dropship_automation_main.php', '', plugins_url( 'icon.png', __FILE__ ),'59');
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_menu', 'dropship_automation_menu' );
function dropship_automation_install(){
	global $wpdb;
	$dsapktblname = $wpdb->prefix . 'dropshipapikey';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE IF NOT EXISTS $dsapktblname (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		 `active` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
		PRIMARY KEY id (id)
	) $charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
?>
