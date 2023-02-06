<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'VI_WOO_CART_ALL_IN_ONE_ADMIN', VI_WOO_CART_ALL_IN_ONE_INC . "admin" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_FRONTEND', VI_WOO_CART_ALL_IN_ONE_INC . "frontend" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_TEMPLATES', VI_WOO_CART_ALL_IN_ONE_INC . "templates" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_CART_ALL_IN_ONE_LANGUAGES', VI_WOO_CART_ALL_IN_ONE_DIR . "languages" . DIRECTORY_SEPARATOR );

$plugin_url = plugins_url( 'woo-cart-all-in-one' );
$plugin_url = str_replace( '/includes', '', $plugin_url );
define( 'VI_WOO_CART_ALL_IN_ONE_CSS', $plugin_url . '/assets/css/' );
define( 'VI_WOO_CART_ALL_IN_ONE_JS', $plugin_url . '/assets/js/' );
define( 'VI_WOO_CART_ALL_IN_ONE_IMAGES', $plugin_url . "/assets/images/" );

if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "functions.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "functions.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "support.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "support.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "data.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "data.php";
}
if ( is_file( VI_WOO_CART_ALL_IN_ONE_INC . "customize-control.php" ) ) {
	require_once VI_WOO_CART_ALL_IN_ONE_INC . "customize-control.php";
}
villatheme_include_folder( VI_WOO_CART_ALL_IN_ONE_ADMIN, 'VI_WOO_CART_ALL_IN_ONE_Admin_' );
villatheme_include_folder( VI_WOO_CART_ALL_IN_ONE_FRONTEND, 'VI_WOO_CART_ALL_IN_ONE_Frontend_' );
