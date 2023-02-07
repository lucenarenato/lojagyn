<?php

/**
 * Goya functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Goya
 */

// Constants: Folder directories/uri's
define( 'GOYA_THEME_DIR', get_template_directory() );
define( 'GOYA_DIR', get_template_directory() . '/inc' );
define( 'GOYA_THEME_URI', get_template_directory_uri() );
define( 'GOYA_URI', get_template_directory_uri() . '/inc' );

// Constant: Framework namespace
define( 'GOYA_NAMESPACE', 'goya' );

// Constant: Theme version
define( 'GOYA_THEME_VERSION', '1.0.7.5' );


// Theme setup
if (! apply_filters('goya_disable_setup_wizard', false) == true) {

  // TGM Plugin Activation Class
  require GOYA_DIR .'/admin/plugins/plugins.php';

  // Imports
  require GOYA_DIR .'/admin/imports/import.php';

  // Theme Wizard
  require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
  require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );
  require_once get_parent_theme_file_path( '/inc/admin/setup/merlin-config.php' );
  require_once get_parent_theme_file_path( '/inc/admin/setup/merlin-filters.php' );

}

// Frontend Functions
require GOYA_DIR .'/misc.php';
require GOYA_DIR .'/frontend/header.php';
require GOYA_DIR .'/frontend/footer.php';
require GOYA_DIR .'/frontend/panels.php';
require GOYA_DIR .'/frontend/entry.php';

// Script Calls
require GOYA_DIR .'/script-calls.php';

// Ajax
require GOYA_DIR .'/ajax.php';

// Add Menu Support
require GOYA_DIR .'/mega-menu.php';

// Enable Sidebars
require GOYA_DIR .'/sidebar.php';

// Language/Currency switchers
require GOYA_DIR .'/switchers.php';

// WooCommerce related functions
require GOYA_DIR .'/woocommerce/wc-functions.php';
require GOYA_DIR .'/woocommerce/wc-elements.php';
require GOYA_DIR .'/woocommerce/category-image.php';

// Gutenberg related functions
require GOYA_DIR .'/gutenberg.php';

// CSS Output of Theme Options
require GOYA_DIR .'/custom-styles.php';

// Kirki: Load Config options
require GOYA_DIR .'/admin/settings/kirki.config.php';
