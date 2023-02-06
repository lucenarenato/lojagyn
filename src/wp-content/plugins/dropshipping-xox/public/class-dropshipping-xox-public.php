<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/public
 * @author     xolluteon <developer@xolluteon.com>
 */

class Dropshipping_Xox_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dropshipping-xox-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dropshipping-xox-public.js', array( 'jquery' ), $this->version, false );
	}

	public function enqueue_tracking_shipping($order_id, $auth)
	{
		$dshix_token = get_post_meta($order_id, '_dshix_tracking_token');
		if(isset($dshix_token[0]) && $dshix_token[0] != ''){
			$token = $dshix_token[0];
			$content_raw = $this->get_tracking($auth, $token);
			$content = '';
			
			if($content_raw->status == 'success' && (count($content_raw->content) < 1 || null !== $content_raw->content)){
				$content_obj = $content_raw->content;
				$content .= '<div>';
				$content .= '<p><strong>Carrier:</strong> '.$content_obj->carrier_code.'</p>';
				$content .= '<p><strong>Route:</strong> '.$content_obj->original_country.' to '.$content_obj->destination_country.'</p>';
				$content .= '<p><strong>Status:</strong> '.$content_obj->status.'</p>';
				$content .= '<div id="track-details"><strong>Details:</strong><br>';
				$content .= '<ul style="margin: 0; padding: 0 0 0 15px;">';
				if(is_array($content_obj->destination_info->trackinfo)){
					foreach($content_obj->destination_info->trackinfo as $detail){
						$content .= '<li>'.$detail->Date.' : '.$detail->StatusDescription.'<br>('.$detail->Details.')<br>&nbsp;</li>';
					}
				}
				if(is_array($content_obj->origin_info->trackinfo)){
					foreach($content_obj->origin_info->trackinfo as $detail){
						$content .= '<li>'.$detail->Date.' : '.$detail->StatusDescription.'<br>('.$detail->Details.')<br>&nbsp;</li>';
					}
				}else{
					$content .= '<li>No tracking record has been found. Your tracking may have expired.</li>';
				}
				$content .= '</ul></div>';
				$content .= '</div>';
			}
			
			// var_dump($content); exit;
			$this->output($content);
		}
	}

	private function output($content){
		?>
		<section class="woocommerce-order-details" style="float: left; width: 100%;">
			<h2 class="woocommerce-order-details__title">Shipment Tracking</h2>
			<?php echo $content; ?>
		</section>
		<?php
	}

	private function get_tracking($auth, $token)
	{
		$content = null;
		$$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
		$url = 'https://www.dropshix.com/dropshix/api/v2/order/'.$auth.'/track/get/'.$token;
		$response = wp_remote_get($url, $args);
		if ( is_wp_error( $response ) ) {
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			$content = [
				'status' => 'ERROR',
				'errorCode' => $error_code . ' (' . $error_message . ')',
			];
			$content = json_decode(json_encode($content));
		} else {
			$content = wp_remote_retrieve_body($response);
			$content = json_decode($content, false);
		}

		return $content;
	}
}
