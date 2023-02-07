<?php
/**
 * Plugin Name: Goya Core
 * Description: This plugin adds necessary functionality to Goya theme.
 * Version: 1.0.6.4
 * Author: Everthemes
 * Author URI: http://themeforest.net/user/everthemess
 * Text Domain:     goya-core
 * Domain Path:     /languages
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Goya Core.
 * Main class.
 */
final class Goya_Core {
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init();
	}

	/**
	 * Defines constants
	 */
	public function define_constants() {
		define( 'GOYA_CORE_VER', '1.0.6.4' );
		define( 'GOYA_CORE_DIR', plugin_dir_path( __FILE__ ) );
		define( 'GOYA_CORE_URL', plugin_dir_url( __FILE__ ) );
		define( 'GOYA_VC_DIR', GOYA_CORE_DIR . 'includes/js_composer/' );
	}

	/**
	 * Load files
	 */
	public function includes() {
		
		include_once( GOYA_CORE_DIR . 'includes/functions.php' );

		// Portfolio
		include_once( GOYA_CORE_DIR . 'includes/types/portfolio.php' );
		include_once( GOYA_CORE_DIR . 'includes/types/portfolio-functions.php' );
		include_once( GOYA_CORE_DIR . 'includes/metabox/portfolio.php' );

		// WPB
		include_once( GOYA_CORE_DIR . 'includes/js_composer/js_composer.php' );

		// Widgets
		include_once( GOYA_CORE_DIR . 'includes/widgets/widgets-init.php' );

		// Metaboxes
		include_once( GOYA_CORE_DIR . 'includes/metabox/page.php' );
		include_once( GOYA_CORE_DIR . 'includes/metabox/post.php' );
		include_once( GOYA_CORE_DIR . 'includes/metabox/product.php' );

		// Other shortcodes
		include_once( GOYA_CORE_DIR . 'includes/shortcodes.php' );

	}

	/**
	 * Initialize
	 */
	public function init() {
		//add_action( 'vc_before_init', 'vc_set_as_theme' );

		// WP Bakery
		add_action( 'vc_after_init', array( 'Goya_Core_JS_Composer', 'init' ) );
		add_action( 'vc_after_init', array( 'Goya_Core_JS_Composer', 'customize_elements' ) );
		add_action( 'vc_after_init', array( 'Goya_Core_JS_Composer', 'map_shortcodes' ) );
		add_action( 'vc_after_init_base', array( 'Goya_Core_JS_Composer', 'add_templates' ) );

		add_action( 'init', array( 'Goya_Core_JS_Composer', 'init_shortcodes' ), 50 );
		add_action( 'init', array( $this, 'load_vc_translation' ) );

	}

	/**
	 * Load translations
	 */
	public function load_vc_translation() {
		load_plugin_textdomain( 'goya-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

}

new Goya_Core();
