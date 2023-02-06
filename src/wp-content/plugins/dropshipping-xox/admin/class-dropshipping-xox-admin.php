<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 * @author     xolluteon <developer@xolluteon.com>
 */

class Dropshipping_Xox_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = array('dropshix-opt', 'dropshix-search-product','dropshix-inactive-page','dropshix-report-page','dropshix-queued-page','dropshix-active-page','dropshix-web-app');

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dropshipping_Xox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dropshipping_Xox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( $this->plugin_name.'-fancybox', plugin_dir_url( __FILE__ ) . 'css/fancybox/jquery.fancybox.min.css', array(), '3.0', 'all' );
		if(isset($_GET['page']) && in_array($_GET['page'], $this->options)){
			wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( 'datatables', plugin_dir_url( __FILE__ ) . 'js/DataTables/datatables.min.css', array(), $this->version, 'all' );
			// wp_enqueue_style( 'bootstrap-theme', plugin_dir_url( __FILE__ ) . 'css/bootstrap/bootstrap-theme.min.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dropshipping-xox-admin.css', array(), $this->version, 'all' );
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dropshipping_Xox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dropshipping_Xox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'-fancybox', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.min.js', array( 'jquery' ), '3.0', false );
		if(isset($_GET['page']) && in_array($_GET['page'], $this->options)){
			// wp_enqueue_script( 'bootstrap', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'datatables', plugin_dir_url( __FILE__ ) . 'js/DataTables/datatables.min.js', array( 'jquery' ), $this->version, true );
		}
		// arung - moved here, or else fancybox not working
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dropshipping-xox-admin.js', array( 'jquery' ), $this->version, false );
	}
}
