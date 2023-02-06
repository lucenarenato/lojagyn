<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 *
 *
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin
 * @author     xolluteon <developer@xolluteon.com>
 */
class xDropShipConnect {
	private $apiUrl;
	private $apiUrl2;
	private $public;
	private $private;
	private $domain;
	private $source;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() 
	{
		// Our main api url for all the actions.
		$this->apiUrl = DROPSHIX_URL.'/dropshix/api/v1/';
		$this->apiUrl2 = DROPSHIX_URL.'/dropshix/api/v2/';
		$options = get_option( 'dropshix_opt' );
		// we'll save all the credentials here for future connect activity
		$this->public = isset($options['dropshix_API_public']) ? ($options['dropshix_API_public']) : '' ;
		$this->private = isset($options['dropshix_API_private']) ? ($options['dropshix_API_private']) : '' ;
		$this->domain = $this->setupDomain();
		$this->source = $options['x_tool_source'];
	}

	public function setupDomain() {
		$domain = $_SERVER['SERVER_NAME'];

		if($domain = '_' || $domain = ''){
			$domain = get_site_url();
		}

		$return = str_replace('http://', '', $domain);
		$return = str_replace('https://', '', $return);
		// $return = str_replace('www.', '', $return);

		return $return;
	}

	public function loadSearchUri()
	{
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		switch($this->source){
			case 'ae' : 
				$url = DROPSHIX_URL.'/dropshix/ali/search/'.$auth;
			break;
			case 'amus' : 
				$url = DROPSHIX_URL.'/dropshix/amus/search/'.$auth;
			break;
			case 'bg' : 
				$url = DROPSHIX_URL.'/dropshix/banggood/search/'.$auth;
			break;
			default : $url = ''; 
		}
		return $url;
	}

	public function getSupplierURL($source)
	{
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		switch($source){
			case 'ae' :
				$url = DROPSHIX_URL.'/dropshix/ali/search/'.$auth;
			break;
			case 'amus' : 
				$url = DROPSHIX_URL.'/dropshix/amus/search/'.$auth;
			break;
			case 'bg' : 
				$url = DROPSHIX_URL.'/dropshix/banggood/search/'.$auth;
			break;
			default : $url = ''; 
		}
		if(DROPSHIX_DEBUG){
			dropshix_log('Loading supplier URL: '.$url);
		}
		return $url;
	}
	
	public function getQueuedListings($type)
	{
		$params = array(
			'command' => 'list',
			'type' => $type
		);
		$return = $this->postRequest($params);
		return $return;
	}
	
	private function postRequest($params)
	{
		$urlparams = http_build_query($params);
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 . $auth . '/?' . $urlparams;

		// $post = $action == 'post' ? 1 : 0; // need to check whether GET is available using 0.
		$$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['postRequest' => $content]);
		}
		return $content;
	}
	
	function createOrUpdateSetting( $params )
	{
		$urlparams = http_build_query($params);
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl . $auth . '/update-setting/?' . $urlparams;
			
		// $post = $action == 'post' ? 1 : 0; // need to check whether GET is available using 0.
		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['createOrUpdateSetting' => $content]);
		}
		return $content;
	}
	
	function actionProduct( $action, $id, $source, $wooid = null)
	{
		$wooid = ($wooid == null ) ? '': $wooid;

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 . $auth . '/'.$action . '/' . $source.'/' . $id . '/' . $wooid;

		if($wooid == NULL)
			$url = $this->apiUrl2 . $auth . '/'.$action . '/' . $source.'/' . $id;
		// var_dump($url); exit;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['actionProduct' => $content]);
		}
		return $content;
	}

	private function remove_utf8_bom($text)
	{
		// This will remove unwanted characters.
		// Check http://www.php.net/chr for details
		for ($i = 0; $i <= 31; ++$i) { 
			$text = str_replace(chr($i), "", $text); 
		}
		$text = str_replace(chr(127), "", $text);

		// This is the most common part
		// Some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
		// here we detect it and we remove it, basically it's the first 3 characters 
		if (0 === strpos(bin2hex($text), 'efbbbf')) {
			$text = substr($text, 3);
		}
		/*$bom = pack('H*','EFBBBF');
		$text = preg_replace("/^$bom/", '', $text);*/
		$text = stripslashes($text);
		$text = html_entity_decode((string) $text);

		return $text;
	}
	
	function getListingProduct( $id )
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl . $auth . '/detail/' . $id;
		
		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['getListingProduct' => $content]);
		}
		return $content;
	}

	function xoxBulkAction( $action, $item )
	{
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl . $auth . '/bulkaction/'.$action.'/' . $item;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['xoxBulkAction' => $content]);
		}
		return $content;
	}

	function sendingAnalytics( $action, $item )
	{


		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl . $auth . '/record/'.$action.'/' . $item;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['sendingAnalytics' => $content]);
		}
		return $content;
	}

	function sendingOrders( $var )
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl .'pass/'. $auth . '/orders';

		$var = json_encode($var, true);

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
			'body' => ['orders' => $var]
		];
		$response = wp_remote_post($url, $args);
		if ( is_wp_error( $response ) ) {
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			$content = [
				'status' => 'ERROR',
				'errorCode' => $error_code . ' (' . $error_message . ')',
			];
			$content = json_decode(json_encode($content));
			if(DROPSHIX_DEBUG){
				dropshix_log(['sendingOrders' => $content]);
			}
		} else {
			$content = $response['body'];
			$content = json_decode($content, false);
		}

		return $content;
	}

	function getOrderList( $order_id )
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl .'pass/'. $auth . '/order/'.$order_id;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['getOrderList' => $content]);
		}
		return $content;
	}

	function checkAttr($woo_id)
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl .'attr/'. $auth . '/check/'.$woo_id;
		if(DROPSHIX_DEBUG){
			dropshix_log(['checkAttr URL' => $url]);
		}

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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

		if(DROPSHIX_DEBUG){
			dropshix_log(['checkAttr' => $content]);
		}
		return $content;
	}

	function importAttr($woo_id)
	{
		# The maximum execution time, in seconds. If set to zero, no time limit is imposed.
		set_time_limit(300);
		ini_set('max_execution_time', 300);

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl .'attr/'. $auth . '/import/'.$woo_id;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['importAttr' => $content]);
		}
		return $content;
	}

	function importAttrVar($woo_id)
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 .'attr/'. $auth . '/import/'.$woo_id;
		// var_dump($url); exit;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['importAttrVar' => $content]);
		}
		return $content;
	}

	function recordAttrVar($sku, $parent_id, $var_id)
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 .'attr/'. $auth . '/record/'.$sku.'/'.$parent_id.'/'.$var_id;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['recordAttrVar' => $content]);
		}
		return $content;
	}

	public function dshixSetMode( $object, $mode, $post_id )
	{
		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 . $auth . '/mode/' . $object . '/set/' . $post_id . '/' . $mode;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['dshixSetMode' => $content]);
		}
		return $content;
	}

	function getScanAttrURL($woo_id)
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 .'attr/'. $auth . '/browse/'.$woo_id;

		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['getScanAttrURL' => $content]);
		}
		return $content;
	}

	function getProfile()
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl . $auth . '/getProfile';
		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
		$response = wp_remote_get($url, $args);
		if ( is_wp_error( $response ) ) {
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			$content = [
				'status' => 'ERROR',
				'errorCode' => $error_code . ' (' . $error_message . ')',
				'product' => [
						'status' => 'false',
						'type' => $error_code . ' (' . $error_message . ')',
						'limit' => 'N/A',
						'activelistings' => 'N/A'
					]
			];
			$content = json_decode(json_encode($content));
		} else {
			$content = wp_remote_retrieve_body($response);
			$content = json_decode($content, false);
		}
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['getProfile' => $content]);
		}
		return $content;
	}

	function getUserProfile()
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 . $auth . '/profile';
		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
		$response = wp_remote_get($url, $args);
		if ( is_wp_error( $response ) ) {
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			$content = [
				'status' => 'ERROR',
				'errorCode' => $error_code . ' (' . $error_message . ')',
				'product' => [
						'status' => 'false',
						'type' => $error_code . ' (' . $error_message . ')',
						'limit' => 'N/A',
						'activelistings' => 'N/A'
					]
			];
			$content = json_decode(json_encode($content));
		} else {
			$content = wp_remote_retrieve_body($response);
			$content = json_decode($content, false);
		}
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['getUserProfile' => $content]);
		}

		return $content;
	}

	function checkConn()
	{

		$auth = base64_encode($this->public.'|'.$this->private.'|'.$this->domain);
		$url = $this->apiUrl2 . $auth . '/profile';
		// var_dump($url); exit;
		$args = [
			'timeout' => 300,
			'sslverify' => DROPSHIX_IS_LOCAL ? false : true,
		];
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
		$content->url = $url;

		if(DROPSHIX_DEBUG){
			dropshix_log(['checkConn' => $content]);
		}
		
		return $content;
	}
}