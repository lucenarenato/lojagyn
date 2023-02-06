<?php
/**
 * Provide plugin with configuration that's needed by the plugin to work properly
 *
 * This file is used to contain definitions of environment needed.
 * Preparation when WordPress upgrade to use dotEnv.
 * The main idea is to not rewrite something over and over again.
 * Also to ease tech team to analyze when debugging mode is needed.
 * The file will contain mostly define global vars.
 *
 * @link       https://xolluteon.com
 * @since      3.4.1
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin/partials
 */

if(!defined('DROPSHIX_DEBUG'))
	define('DROPSHIX_DEBUG', false); // you can replace this with true or false (bool).

if(!defined('DROPSHIX_IS_LOCAL'))
	define('DROPSHIX_IS_LOCAL', false); // you can replace this with true or false (bool).

if(DROPSHIX_IS_LOCAL){
	define('DROPSHIX_SERVER', 'www.dropshix.local');
}else{
	define('DROPSHIX_SERVER', 'www.dropshix.com');
}

define('DROPSHIX_CHROME_EXTENSION_URL', 'https://chrome.google.com/webstore/detail/dropshix-extension/hfejflbgldokiangllcjbgkchghahigm');

define('DROPSHIX_VERSION', '4.0.14');

define('DROPSHIX_HOST', 'https://');

define('DROPSHIX_PLUGIN_PATH', WP_CONTENT_DIR . '/uploads/');

define('DROPSHIX_LOG_FILE', DROPSHIX_PLUGIN_PATH.'dropshix_debug.log');

define('DROPSHIX_URL', DROPSHIX_HOST.DROPSHIX_SERVER);

?>