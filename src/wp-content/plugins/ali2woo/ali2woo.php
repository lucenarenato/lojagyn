<?php
/*
  Plugin Name: Aliexpress Dropship for Woocommerce
  Plugin URI: https://codecanyon.net/user/ma-group/portfolio
  Description: Aliexpress Dropship for Woocommerce is a WordPress plugin created for AliExpress Drop Shipping and Affiliate marketing
  Text Domain: ali2woo
  Domain Path: /languages
  Version: 1.4.7
  Author: MA-Group
  Author URI: https://codecanyon.net/user/ma-group
  License: GPLv2+
  WC tested up to: 3.4
  WC requires at least: 2.6
 */

if (!class_exists('A2W_Main')) {

    class A2W_Main {
        /**
	 * @var The single instance of the class		 
	 */
	protected static $_instance = null;
        
        /**
	 * @var string Ali2Woo plugin version
	 */
	public $version ;
        
        /**
	 * @var string Ali2Woo plugin version
	 */
	public $plugin_name;
        
        /**
	 * @var string path to Ali2Woo plugin root url
	 */
        public $plugin_url;
        
        /**
	 * @var string path to Ali2Woo plugin root dir
	 */
        public $plugin_path;
        
        /**
	 * @var string chrome extension url
	 */
        public $chrome_url = 'https://chrome.google.com/webstore/detail/faieahckjkcpljkaedbjidlhhcigddal';
        
        public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

        private function __construct() {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            $plugin_data = get_plugin_data(__FILE__);
            
            $this->version = $plugin_data['Version'];
            $this->plugin_name = plugin_basename(__FILE__);
            $this->plugin_url = plugin_dir_url(__FILE__);
            $this->plugin_path = plugin_dir_path(__FILE__);
            
            include_once(dirname(__FILE__) . '/includes/settings.php');
            include_once(dirname(__FILE__) . '/includes/functions.php');

            include_once(dirname(__FILE__) . '/includes/init.php');
            A2W_Init::init_classes($this->plugin_path . 'includes/classes', 'a2w_init');
            A2W_Init::init_addons($this->plugin_path . 'addons');

            include_once(dirname(__FILE__) . "/includes/libs/a2w_json_api/a2w_json_api.php");
            A2W_Json_Api_Configurator::init('a2w_dashboard');

            if (!class_exists('Requests')) {
                include_once (dirname(__FILE__) . '/includes/libs/Requests/Requests.php');
                Requests::register_autoloader();
            }
            
            register_activation_hook(__FILE__, array($this, 'install'));
            register_deactivation_hook(__FILE__, array($this, 'uninstall'));

            add_action('admin_menu', array($this, 'admin_menu'));

            add_action('admin_enqueue_scripts', array($this, 'admin_assets'));

            add_action('wp_enqueue_scripts', array($this, 'assets'));
        }
        
        function install() {
            do_action('a2w_install');
        }

        function uninstall() {
            do_action('a2w_uninstall');
        }

        public function assets($page) {
            do_action('a2w_assets', $page);
        }

        public function admin_assets($page) {
            do_action('a2w_admin_assets', $page);
        }

        public function admin_menu() {
            do_action('a2w_before_admin_menu');

            add_menu_page(__('Ali2Woo', 'ali2woo'), __('Ali2Woo', 'ali2woo'), 'import', 'a2w_dashboard', '', plugins_url('assets/img/icon.png', __FILE__));

            do_action('a2w_init_admin_menu', 'a2w_dashboard');
        }
    }

}

/**
 * Returns the main instance of A2W_Main to prevent the need to use globals.
 *
 * @return A2W_Main
 */
if (!function_exists('A2W')) {
    function A2W() {
            return A2W_Main::instance();
    }
}

$ali2woo = A2W();

/**
 * Ali2Woo global init action
 */
do_action('a2w_init');
