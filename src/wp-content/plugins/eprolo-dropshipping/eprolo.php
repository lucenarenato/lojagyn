<?php
/*
   Plugin Name: EPROLO-Dropshipping
   Plugin URI: http://wordpress.org/extend/plugins/eprolo/
   Version: 1.6.2
   Author: EPROLO
   Description: EPROLO Dropshipping and aliexpress importer
   Text Domain: EPROLO
   Author URI:   https://www.eprolo.com
  */

//PHP minimum required version
$eprolo_minimalRequiredPhpVersion = '5.6';

/**
 * Prompt after PHP version error
 */
function Eprolo_noticePhpVersionWrong() {
	global $eprolo_minimalRequiredPhpVersion;
	echo '<div class="updated fade">EPROLO requires a newer version of PHP to be running </div>';
}

/**
 * Check version
 */
function eprolo_PhpVersionCheck() {
	global $eprolo_minimalRequiredPhpVersion;
	if ( version_compare( phpversion(), $eprolo_minimalRequiredPhpVersion ) < 0 ) {
		add_action( 'admin_notices', 'Eprolo_noticePhpVersionWrong' );
		return false;
	}
	return true;
}

/**
 *  Initialize the internationalization of this plugin (i18n). Different voices, none, default English
 *
 * @return void
 */
function eprolo_i18n_init() {
	$pluginDir = dirname( plugin_basename( __FILE__ ) );
	load_plugin_textdomain( 'eprolo', false, $pluginDir . '/languages/' );
}


// Adding method
add_action( 'plugins_loadedi', 'eprolo_i18n_init' );


//Check PHP version
if ( !eprolo_PhpVersionCheck() ) {
	// Only load and run the init function if we know PHP version can parse it
	return;
}

include_once 'Eprolo_init.php';
eprolo_init( __FILE__ );

//Define external AJAX interface
require_once 'Eprolo_AJAX.php';
function eprolo_disconnect_init() {
	$aPlugin = new Eprolo_AJAX();
	$aPlugin->eprolo_disconnect();
}
function eprolo_connect_key_init() {
	 $aPlugin = new Eprolo_AJAX();
	$aPlugin->eprolo_connect_key();
}
function eprolo_reflsh_init() {
	$aPlugin = new Eprolo_AJAX();
	$aPlugin->eprolo_reflsh();
}
// Interface Join Action
add_action( 'wp_ajax_eprolo_disconnect', 'eprolo_disconnect_init' );
add_action( 'wp_ajax_eprolo_connect_key', 'eprolo_connect_key_init' );
add_action( 'wp_ajax_eprolo_reflsh', 'eprolo_reflsh_init' );

