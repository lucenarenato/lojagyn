<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/includes
 */
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/includes
 * @author     xolluteon <developer@xolluteon.com>
 */
class Dropshipping_Xox_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'dropshipping-xox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
