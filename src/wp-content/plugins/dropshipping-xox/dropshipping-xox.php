<?php
/**
 *
 * @link              https://dropshix.com
 * @since             0.0.1
 * @package           Dropshipping_Xox
 *
 * @wordpress-plugin
 * Plugin Name:       Dropshipping Xox
 * Plugin URI:        https://dropshix.com
 * Description:       WooCommerce Dropshipping tool plugin, autopilotting your dropshipping to get you more profit.
 * Version:           4.0.14
 * Author:            xolluteon
 * Author URI:        https://profiles.wordpress.org/dedong/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dropshix
 * Domain Path:       /languages
 * WC requires at least: 3.5.1
 * WC tested up to:   3.6.4
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-autoupdate.php';
require_once plugin_dir_path( __FILE__ ) . 'dropshipping-xox-config.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dropshipping-xox-activator.php
 */

function activate_dropshipping_xox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-activator.php';
	Dropshipping_Xox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dropshipping-xox-deactivator.php
 */
function deactivate_dropshipping_xox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox-deactivator.php';
	Dropshipping_Xox_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_dropshipping_xox' );
register_deactivation_hook( __FILE__, 'deactivate_dropshipping_xox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dropshipping-xox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dropshipping_xox() {
	$plugin = new Dropshipping_Xox();
	$plugin->run();
	$plugin->optionSetting();
}
run_dropshipping_xox();

function menu_init_dropshix(){
	add_menu_page( 
		__( 'DROPSHIX™ General Option', 'dropshix' ),
		'Dropshix™', 
		'manage_options', 
		'dropshix-opt', 
		'dropshix_admin_option_display',
		'dashicons-cart',
		88 );
	add_submenu_page( 'dropshix-opt', 'Search Product', 'Search Product', 'manage_woocommerce', 'dropshix-search-product', 'searchProductdropshix');
	add_submenu_page( 'dropshix-opt', 'Web Application', 'Web Application', 'manage_woocommerce', 'dropshix-web-app', 'webAppdropshix');
	add_submenu_page( 'dropshix-opt', 'Queued Products', 'Queued Products', 'manage_woocommerce', 'dropshix-queued-page', 'dropshix_queued_product_display');
	add_submenu_page( 'dropshix-opt', 'Active Products', 'Active Products', 'manage_woocommerce', 'dropshix-active-page', 'dropshix_active_product_display');
	// add_submenu_page( 'dropshix-opt', 'Inactive Listings', 'Inactive Listings', 'manage_woocommerce', 'dropshix-inactive-page', 'dropshix_inactive_product_display');
	// add_submenu_page( 'dropshix-opt', 'Report', 'Report Chart', 'manage_options', 'dropshix-report-page', 'reportPagedropshix');
}
add_action( 'admin_menu', 'menu_init_dropshix' );

add_action( 'woocommerce_product_options_general_product_data', 'woocommerceXoxCustomFieldProductMeta' ); 
add_action( 'woocommerce_process_product_meta', 'woocommerceXoxCustomFieldProductMeta_save' );

function woocommerceXoxCustomFieldProductMeta() {
	global $woocommerce, $post;
	echo '<div class="product_custom_field">';
	woocommerce_wp_text_input(
		array(
			'id' => '_product_url',
			'placeholder' => 'Http://',
			'label' => __('Product Url', 'woocommerce'),
			'desc_tip' => 'true'
		)
	);
	echo '</div>'; 
}

function woocommerceXoxCustomFieldProductMeta_save( $post_id ){
	$product_url = sanitize_text_field( strval( $_POST['_product_url'] ) );
	if (!empty($product_url))
		update_post_meta($post_id, '_custom_product_text_field', esc_attr($product_url)); 
}

function dropshix_settings_init() {
	register_setting( 'dropshix', 'dropshix_opt');
	add_settings_section(
		'dropshix_section_developers',
		__( 'DROPSHIX™ API', 'dropshix' ),
		'dropshix_section_dev_cb',
		'dropshix'
	);
	add_settings_field(
		'dropshix_API_public',
		__( 'Public', 'dropshix' ),
		'dropshix_field_pill_cb',
		'dropshix',
		'dropshix_section_developers',
		[
			'label_for' => 'dropshix_API_public',
			'class' => 'dropshix_row',
			'dropshix_custom_data' => 'custom',
		]
	);
	add_settings_field(
		'dropshix_API_private',
		__( 'Secret', 'dropshix' ),
		'dropshix_field_pill_cb2',
		'dropshix',
		'dropshix_section_developers',
		[
			'label_for' => 'dropshix_API_private',
			'class' => 'dropshix_row',
			'dropshix_custom_data' => 'custom',
		]
	);
	add_settings_field("dropshix_tool_source", __( 'Select Default Supplier', 'dropshix' ), "dropshix_tool_select", "dropshix", "dropshix_section_developers");

}

function dropshix_tool_select()
{
	$value = get_option('dropshix_opt');
	?>
		<select name="dropshix_opt[x_tool_source]" id="dropshix_tool_source" class="dropshix_row">
			<option value="" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "") : '' ; ?>>Select Source</option>
			<option value="ae" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "ae") : '' ; ?>>AliExpress</option>
			<option value="amus" <?php isset($value['x_tool_source']) ? selected($value['x_tool_source'], "amus") : '' ; ?>>Amazon US</option>
		</select>
	<?php
}

add_action( 'admin_init', 'dropshix_settings_init' );

/**
 * Polylang meta filter, if true meta item will not be synchronized.
 *
 *
 * @param string      $meta_key Meta key
 * @param string|null $meta_type
 * @return bool True if the key is protected, false otherwise.
 */
function ignoreDropshixMeta($protected, $meta_key, $meta_type)
{
	if ( ! function_exists( 'is_plugin_active' ) )
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	
	if(is_admin() && is_plugin_active( 'polylang/polylang.php' )){
		$meta_prefix = array(
			'_dshix_price',
			'_dshix_regular_price',
			'_dshix_sale_price',
			'_dropshix_init_price',
			'_dropshix_init_regular_price',
			'_dropshix_init_sale_price',
			'_dropshix_init_var_regular_price',
			'_dropshix_init_var_sale_price',
		);
		
		if (in_array($meta_key, $meta_prefix)){
			return true;
		} else {
			return $protected;
		}
	}
}
add_filter( 'is_protected_meta', 'ignoreDropshixMeta', 10, 3);

function dropshix_is_curl_installed()
{
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else {
		return false;
	}
}

function dropshix_check_disk_size()
{
	$ds = disk_total_space("/home");
	$exp = $ds/(1024);
}

function searchProductdropshix(){
	$plugin = new Dropshipping_Xox();
	$plugin->searchPage();
}

function webAppdropshix(){
	$plugin = new Dropshipping_Xox();
	$profile = $plugin->getUserProfile();
	// var_dump($profile); exit;
	$plugin->webApplication($profile->product->project_id);
}

// new Inactive product page
function inActivePagedropshix()
{
	
}

add_action( 'wp_ajax_AutoScanAttr', 'AutoScanAttr' );
add_action( 'wp_ajax_nopriv_AutoScanAttr', 'AutoScanAttr' );

function AutoScanAttr()
{
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		$wooid = sanitize_text_field( strval( $inputs['wooid'] ));
		$plugin = new Dropshipping_Xox();
		$curl = $plugin->getScanAttrURL( $wooid );
		$return = json_encode($curl['result']);
	}
	echo $return;
	wp_die();
}

function dropshix_ImportItem() {
	//global $wpdb; // this is how you get access to the database
	check_ajax_referer( 'dropshix-security-nonce', 'security' );

	if(current_user_can( 'manage_woocommerce' )){
		// var_dump(current_user_can( 'manage_woocommerce' )); exit;
		if( isset( $_POST['title'] ) && isset( $_POST['description'] ) && isset( $_POST['id'] ) ) {
			$data['title'] = sanitize_text_field( strval( $_POST['title'] ));
			$data['description'] = wp_kses_post( $_POST['description'] );
			$data['source'] = sanitize_text_field( strval( $_POST['source'] ));
			$id = sanitize_text_field( strval( $_POST['id'] ));
			$plugin = new Dropshipping_Xox();
			$return = $plugin->importProduct( $id, $data );
			echo $return;
		}else{
			$data['status'] = false;
			$data['msg'] = 'Error: Missing important data!';
			return json_encode( $data );
		}
	}else{
		// var_dump(current_user_can( 'manage_woocommerce' )); exit;
		$data['status'] = false;
		$data['msg'] = 'Error: Unauthorized access!';
		return json_encode( $data );
	}
	
	wp_die();
}

function dropshix_ResetItem() {
	//global $wpdb; // this is how you get access to the database
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can( 'manage_woocommerce' )){
		$plugin = new Dropshipping_Xox();
		$id = strval( $_POST['id'] );
		$source = strval( $_POST['source'] );
		$return = $plugin->resetProduct( $id, $source );
		echo $return;
	}else{
		echo 'Unauthorized access!';
	}
	
	wp_die(); 
}

function dropshix_DeleteItem() {
	//global $wpdb; // this is how you get access to the database
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can( 'manage_woocommerce' )){
		$plugin = new Dropshipping_Xox();
		$id = strval( $_POST['id'] );
		$source = strval( $_POST['source'] );
		$return = $plugin->deleteProduct( $id, $source );
		echo $return;
	}else{
		echo 'Unauthorized access!';
	}
	
	wp_die(); 
}

add_action( 'wp_ajax_Xox_Import_Item', 'dropshix_ImportItem' );
add_action( 'wp_ajax_nopriv_Xox_Import_Item', 'dropshix_ImportItem' );
add_action( 'wp_ajax_Xox_Load_Ajax_Item', 'dropshix_LoadItem' );
add_action( 'wp_ajax_nopriv_Xox_Load_Ajax_Item', 'dropshix_LoadItem' );
add_action( 'wp_ajax_Xox_Delete_Item', 'dropshix_DeleteItem' );
add_action( 'wp_ajax_nopriv_Xox_Delete_Item', 'dropshix_DeleteItem' );
add_action( 'wp_ajax_DshixResetItem', 'dropshix_ResetItem' );
add_action( 'wp_ajax_nopriv_DshixResetItem', 'dropshix_ResetItem' );
add_action( 'wp_ajax_Xox_Archive_Item', 'dropshix_ArchiveItem' );
add_action( 'wp_ajax_nopriv_Xox_Archive_Item', 'dropshix_ArchiveItem' );

add_action( 'wp_ajax_Xox_SendAnalytics', 'dropshix_SendAnalytics' );
add_action( 'wp_ajax_nopriv_Xox_SendAnalytics', 'dropshix_SendAnalytics' );

add_action( 'woocommerce_after_single_product_summary', 'dropshix_Analytics');

function dropshix_Analytics($argument){
	global $post;
	$ajax_nonce = wp_create_nonce( "dropshix-security-nonce" );
	?>
		<script type="text/javascript" >
		jQuery(document).ready(function($) {
			//load ajax
			xoxSendAnalytics('<?php echo $post->ID; ?>');
			function xoxSendAnalytics( id ){
				ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				$.ajax({
					url : ajaxurl,
					type : 'post',
					data : {
						action: "Xox_SendAnalytics",
						security: '<?php echo $ajax_nonce; ?>',
						typedata: 'watch',
						item: id,
					}
				})
				.fail(function(r,status,jqXHR) {
					console.log('error send data');
				})
				.done(function(r,status,jqXHR) {
					console.log('200, send Analytics');
				});
			}
		});

	</script>
	<?php
}

function dropshix_SendAnalytics(){
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	$plugin = new Dropshipping_Xox();
	$typedata = sanitize_text_field( strval( $_POST['typedata'] ));
	$item = sanitize_text_field( strval( $_POST['item'] ));
	$plugin->sendAnalytics( $typedata, $item );
	wp_die();
}

add_action( 'woocommerce_payment_complete', 'dropshix_AnalyticsOrder' );
// add_action( 'woocommerce_order_status_processing', 'dropshix_AnalyticsOrder', 10, 1 );

function dropshix_AnalyticsOrder( $order_id ){

	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	$data = [];
	$product = [];
	foreach ($items as $item) {
		$product['orderId'] = $order_id;
		$product['productId'] = $item['product_id'];
		$product['qty'] = $item['qty'];
		$product['subtotal'] = $item['line_subtotal'];
		$product['total'] = $item['line_total'];
		
		$details = new WC_Product($item['product_id']);

		// Get SKU
		$sku = $details->get_sku();
		$product['sku'] = $sku;

		$data[] = $product;
	}
	$plugin = new Dropshipping_Xox();
	//$plugin->debug($data);
	$plugin->orders($data);
}

// Order AliExpress buttons
add_action( 'add_meta_boxes', 'dropshix_add_meta_boxes' );
if ( ! function_exists( 'dropshix_add_meta_boxes' ) )
{
	function dropshix_add_meta_boxes()
	{
		add_meta_box( 'dropshix_order_fields', __('Dropshix Order Products','woocommerce'), 'dropshix_add_other_fields_for_packaging', 'shop_order', 'side', 'low', 'core' );
	}
}

//
//adding Meta field in the meta container admin shop_order pages
//
if ( ! function_exists( 'dropshix_add_other_fields_for_packaging' ) )
{
	function dropshix_add_other_fields_for_packaging()
	{
		global $post;       
		$post_id = $post->ID;
		$plugin = new Dropshipping_Xox();
		$key = $plugin->getKeys();
		$shippingURL = DROPSHIX_URL.'/dropshix/api/v2/order/'.$key.'/track/'.$post_id;
		$token_meta = get_post_meta($post_id, '_dshix_tracking_token');
		$token_exists = isset($token_meta[0]) && $token_meta[0] != '' ? true : false;
		$ajax_nonce = wp_create_nonce( "dropshix-security-nonce" );
		?>
		<div style="text-align: center;">
			<div class="dshix-track-shipping" style="padding: 12.5px 0;">
				<p><strong>Track this order shipping.</strong></p>
				<?php if(!$token_exists){ ?>
				<div id="tokenHolder">
					<input type="hidden" name="ajax_nonce" id="ajax_nonce" value="<?php echo $ajax_nonce; ?>">
					<p><input type="text" name="dshixTrackToken" id="dshixTrackToken" placeholder="Insert token here." style="width: 100%;"><br><button id="saveTrackToken" data-post-id="<?php echo $post_id; ?>">Save Token</button></p>
					<p>Don't have the token yet?<br>Use the link below.</p>
				</div>
				<?php } ?>
				<p><a data-fancybox data-type="iframe" data-src="<?php echo $shippingURL; ?>" href="javascript:;" class="report-fancybox-xox"><?php echo $token_exists ? 'Check Shipping' : 'Get token!' ?></a></p>
			</div>
		</div>
	<?php
	}
}

// enable/disable Sale price.
add_action( 'wp_ajax_saveTrackToken', 'saveTrackToken' );
add_action( 'wp_ajax_nopriv_saveTrackToken', 'saveTrackToken' );

function saveTrackToken()
{
	$resp = array();
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);

		$token = sanitize_text_field( strval( $inputs['token'] ));
		$post_id = sanitize_text_field( intval( $inputs['post_id'] ));
		
		if(update_post_meta($post_id, '_dshix_tracking_token', $token)){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'error';
		}
	}
	echo json_encode($resp);
	wp_die();
}

add_action( 'woocommerce_view_order', 'dropshix_shipping_tracking', 15 );
function dropshix_shipping_tracking($order_id){
	$plugin = new Dropshipping_Xox();
	$plugin->dshix_tracking_order($order_id);
}

add_action( 'wp_ajax_dropshixSync', 'dropshixSync' );
add_action( 'wp_ajax_nopriv_dropshixSync', 'dropshixSync' );

function dropshixSync()
{
	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		if($inputs['process'] == 'update'){
			// we need to stop any action preventing price changes.
			$post_id = sanitize_text_field( intval( $inputs['id'] ));
			update_post_meta($post_id, '_dropshix_sync', 'on');

			$price = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['price'] )));
			update_post_meta($post_id, '_price', $price);
			// delete_post_meta($post_id, '_regular_price');
			update_post_meta($post_id, '_regular_price', $price);

			if(isset($inputs['salePrice'])){
				$salePrice = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['salePrice'] )));
				update_post_meta($post_id, '_sale_price', $salePrice);
			}else{
				$salePrice = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['price'] )));
				update_post_meta($post_id, '_sale_price', $salePrice);
			}

			if(isset($inputs['originalPrice'])){
				$sourcePrice = sanitize_text_field( floatval( str_replace( 'US $', '', $inputs['originalPrice'] )));
				update_post_meta($post_id, '_source_price', $sourcePrice);
			}
			
			if(isset($inputs['stock'])){
				$stock = sanitize_text_field( intval( $inputs['stock'] ));
				update_post_meta($post_id, '_stock', $stock );
			} 

			$product = wc_get_product( $post_id );
			$_price = get_post_meta($post_id, '_price');
			$_regular_price = get_post_meta($post_id, '_regular_price');
			$_sale_price = get_post_meta($post_id, '_sale_price');
			// var_dump($_regular_price); exit;

		}elseif($inputs['process'] == 'remove'){
			$id = sanitize_text_field( intval( $inputs['id'] ) );
			$product = wc_get_product( $id );
			if( $product->is_type('variable') ){
				$variations = $product->get_available_variations();
				if(is_array($variations) && count($variations) > 0)
				{
					foreach($variations as $var)
					{
						wp_delete_post($var['variation_id']);
					}
				}
			}
			
			wp_delete_post($id);
		}elseif($inputs['process'] == 'draft'){
			$id = sanitize_text_field( intval( $inputs['id'] ) );
			$myproduct = array(
				'ID' => $id,
				'post_status' => 'draft'
			);
			wp_update_post( $myproduct);
		}
		
	}

	echo 1;
	wp_die();
}

// Populate price if product is variable product
add_action( 'added_post_meta', 'dshix_populate_variations_price', 10, 4 );
add_action( 'updated_post_meta', 'dshix_populate_variations_price', 10, 4 );
// Fix - Set woocommerce_hide_invisible_variations to true so disabled variation attributes are hidden on product pages. WooCommerce 3.3.2
add_filter( 'woocommerce_hide_invisible_variations', '__return_false', 10);

function dshix_populate_variations_price( $meta_id, $post_id, $meta_key, $meta_value )
{
	$save_btn = true;

	if (null !== filter_input_array(INPUT_POST)) {
		$inputs = filter_input_array(INPUT_POST);
		if(isset($inputs['action']) && $inputs['action'] == 'dshixDisableSale'){
			$save_btn = false;
		}elseif(isset($inputs['action']) && $inputs['action'] == 'Xox_Import_Item'){
			$save_btn = false;
		}elseif(isset($inputs['action']) && $inputs['action'] == 'importAtrrVar'){
			$save_btn = false;
		}elseif(!isset($inputs['action'])){
			$save_btn = true;
		}
	}else{
		$save_btn = true;
	}

	if (get_post_type($post_id) == 'product') {
		$_dropshix_price_is_manual = get_post_meta( $post_id, '_dropshix_price_is_manual' );
		// var_dump($_dropshix_price_is_manual);
		$price_is_manual = isset($_dropshix_price_is_manual[0]) && $_dropshix_price_is_manual[0] == 'yes' ? true : false;
		// var_dump('checkpoint #1: '.$price_is_manual); exit;

		if(!$price_is_manual){
			$plugin = new Dropshipping_Xox();
			$_no_sale_price = get_post_meta($post_id, '_no_sale_price');
			$_dropshix_sync = get_post_meta($post_id, '_dropshix_sync');
			
			if(!isset($_no_sale_price[0]) || $_no_sale_price[0] == ''){ 
				// listing has just been created.
				// var_dump($save_btn); exit;
				if($save_btn){
					$plugin->initDistributePricing( $post_id );
				}
			}else{ 
				// the disable sale price is initiated.
				// the world is new now.
				$is_sale = $_no_sale_price[0] == 'no' ? false : true;
				if(!$is_sale && $save_btn){
					$plugin->preserveInitPrice( $post_id );

					// now that we save everything let's start destroying the pricing.
					$plugin->disableSalePrice( $post_id );
				}elseif($is_sale && $save_btn){

					// re-enable sale pricing.
					$plugin->reEnableSalePrice( $post_id );
				}
			}
		}
	}
}

add_action( 'add_meta_boxes', 'dropshix_attr_meta_boxes' );
if ( ! function_exists( 'dropshix_attr_meta_boxes' ) )
{
	function dropshix_attr_meta_boxes()
	{
		add_meta_box( 'dropshix_attributes_import', __('DROPSHIX Panel','woocommerce'), 'dropshix_import_attr', 'product', 'side', 'high', 'core' );
	}
}
if ( ! function_exists( 'dropshix_import_attr' ) ) {
	function dropshix_import_attr()
	{
		global $post;
		$post_id = $post->ID;

		$prepared = 'no';

		if (null !== filter_input_array(INPUT_GET)) {
			$inputs = filter_input_array(INPUT_GET);

			if(isset($inputs['dsprepared']) && $inputs['dsprepared'] == 'yes')
				$prepared = 'yes';
		}

		$product = new WC_Product_Variable($post->ID);
		$plugin = new Dropshipping_Xox();
		$key = $plugin->getKeys();
		$account = $plugin->myAccount();
		$curl = $plugin->checkAttr($post->ID);
		$check = $curl['result'];
		$attributes = $product->get_attributes();
		$monitorUrl = $plugin->getMonitorUrl();
		$ajax_nonce = wp_create_nonce( "dropshix-security-nonce" );
		
		$not_sale_product = get_post_meta($post_id, '_no_sale_price');
		$is_not_sale = count($not_sale_product) > 0 && $not_sale_product[0] == 'no' ? ' checked="checked"' : '';
		$_dropshix_price_is_manual = get_post_meta( $post_id, '_dropshix_price_is_manual' );
		if(DROPSHIX_DEBUG) var_dump($_dropshix_price_is_manual);
		$price_is_manual = isset($_dropshix_price_is_manual[0]) && $_dropshix_price_is_manual[0] == 'yes' ? true : false;
		if(DROPSHIX_DEBUG) var_dump('checkpoint #2: '.$price_is_manual);
		$_dropshix_stock_is_manual = get_post_meta($post_id, '_dropshix_stock_is_manual');
		$stock_is_manual = isset($_dropshix_stock_is_manual[0]) && $_dropshix_stock_is_manual[0] == 'yes' ? true : false;
		?>
		<div id="DXAttrWrapper">
			<div id="dxImporter">
				<div class="dshix-monitoring">
					<div style="display: none;">
						<input type="hidden" name="dshix_woo_id" id="dshix_woo_id" value="<?php echo $post_id; ?>">
						<input type="hidden" name="prepared" id="prepared" value="<?php echo $prepared; ?>">
						<input type="hidden" name="ajax_nonce" id="ajax_nonce" value="<?php echo $ajax_nonce; ?>">
					</div>
					<h4 style="font-size: 16px; font-style: underline;">PRODUCT MONITORING.</h4>
					<p>
						<label for="not_sale_product"><input type="checkbox" name="not_sale_product" id="not_sale_product" value="yes"<?php echo $is_not_sale; ?>> <strong>Disable "Sale" price.</strong></label>
					</p>
					<p id="saleResult" class="alert alert-warning" style="display: none;"></p>
					<p>
						<label for="dsPriceMode"><strong>Price control:</strong>&nbsp;</label>
						<select name="dsPriceMode" id="dsPriceMode">
							<option value="auto">Automatic</option>
							<option value="manual"<?php echo $price_is_manual ? 'selected="selected"' : ''; ?>>Manual</option>
						</select>
					</p>
					<p id="priceResult" class="alert alert-warning" style="display: none;"></p>
					<p>
						<label for="dsStockMode"><strong>Stock control:</strong>&nbsp;</label>
						<select name="dsStockMode" id="dsStockMode">
							<option value="auto">Automatic</option>
							<option value="manual" <?php echo $stock_is_manual ? 'selected="selected"' : ''; ?>>Manual</option>
						</select>
					</p>
					<p id="stockResult" class="alert alert-warning" style="display: none;"></p>
				</div>
			</div>
		</div>
		<?php
	}
}

// enable/disable Sale price.
add_action( 'wp_ajax_dshixDisableSale', 'dshixDisableSale' );
add_action( 'wp_ajax_nopriv_dshixDisableSale', 'dshixDisableSale' );

function dshixDisableSale()
{
	$resp = '';
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can('manage_woocommerce')){
		if (null !== filter_input_array(INPUT_POST)) {
			$inputs = filter_input_array(INPUT_POST);

			$disable = sanitize_text_field( strval( $inputs['sale'] ));
			$post_id = sanitize_text_field( intval( $inputs['post'] ));
			$plugin = new Dropshipping_Xox();
			$resp = $plugin->resetPriceMeta($disable, $post_id);
		}
	}else{
		$resp = 'Unauthorized access!';
	}
	
	echo $resp;
	wp_die();
}

// enable/disable manual pricing.
add_action( 'wp_ajax_dshixSetPriceMode', 'dshixSetPriceMode' );
add_action( 'wp_ajax_nopriv_dshixSetPriceMode', 'dshixSetPriceMode' );

function dshixSetPriceMode()
{
	$resp = '';
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can('manage_woocommerce')){
		if (null !== filter_input_array(INPUT_POST)) {
			$inputs = filter_input_array(INPUT_POST);

			$mode = sanitize_text_field( strval( $inputs['mode'] ));
			$post_id = sanitize_text_field( intval( $inputs['post'] ));
			$plugin = new Dropshipping_Xox();
			$resp = $plugin->dshixSetPriceMode($mode, $post_id);
		}
	}else{
		$resp = 'Unauthorized access!';
	}
	
	echo $resp;
	wp_die();
}

// enable/disable manual stockage.
add_action( 'wp_ajax_dshixSetStockMode', 'dshixSetStockMode' );
add_action( 'wp_ajax_nopriv_dshixSetStockMode', 'dshixSetStockMode' );

function dshixSetStockMode()
{
	$resp = '';
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can('manage_woocommerce')){
		if (null !== filter_input_array(INPUT_POST)) {
			$inputs = filter_input_array(INPUT_POST);

			$mode = sanitize_text_field( strval( $inputs['mode'] ));
			$post_id = sanitize_text_field( intval( $inputs['post'] ));
			$plugin = new Dropshipping_Xox();
			$resp = $plugin->dshixSetStockMode($mode, $post_id);
		}
	}else{
		$resp = 'Unauthorized access!';
	}
	
	echo $resp;
	wp_die();
}

// changing source supplier.
// need more check if this function is currently obselete.

// add_action( 'wp_ajax_Xox_Switch_URL', 'Xox_Switch_URL' );
// add_action( 'wp_ajax_nopriv_Xox_Switch_URL', 'Xox_Switch_URL' );

// function Xox_Switch_URL()
// {
// 	$url = '';

// 	if (null !== filter_input_array(INPUT_POST)) {
// 		$inputs = filter_input_array(INPUT_POST);
// 		$source = sanitize_text_field( strval( $inputs['source'] ));
// 		$plugin = new Dropshipping_Xox();
// 		$url = $plugin->getSourceStore($source);
// 	}
// 	$url = str_replace('<!-- This file should primarily consist of HTML with a little bit of PHP. -->', '', $url);
// 	echo $url;
// 	wp_die();
// }

add_action( 'wp_ajax_importAtrrVar', 'importAtrrVar' );
add_action( 'wp_ajax_nopriv_importAtrrVar', 'importAtrrVar' );

function importAtrrVar()
{
	$output = array();
	check_ajax_referer( 'dropshix-security-nonce', 'security' );
	if(current_user_can('manage_woocommerce')){
		if (null !== filter_input_array(INPUT_POST)) {
			$inputs = filter_input_array(INPUT_POST);
			$plugin = new Dropshipping_Xox();
			$curl = $plugin->importAttrVar($inputs['wooid']);
			if(DROPSHIX_DEBUG){
				dropshix_log(['check if curl is different' => $curl]);
			}

			$imports = $curl;
			if(DROPSHIX_DEBUG){
				dropshix_log(['variation result from server' => $imports]);
			}
			// var_dump($imports); exit;
			if(count($imports->variations) > 0){
				wp_set_object_terms($inputs['wooid'], 'variable', 'product_type');
				$output = $plugin->distributeAttrVar( $inputs['wooid'], $imports );
			}else{
				$output['status'] = 'error';
				$output['message'] = 'does not have variations';
			}
		}
	}else{
		$output['status'] = 'error';
		$output['message'] = 'Unauthorized access!';
	}

	echo json_encode($output);
	wp_die();
}

add_action( 'wp_ajax_dropshixImportAtrr', 'dropshixImportAtrr' );
add_action( 'wp_ajax_nopriv_dropshixImportAtrr', 'dropshixImportAtrr' );

function dropshixImportAtrr()
{
	check_ajax_referer( 'dropshix-security-nonce', 'security' );

	if(current_user_can('manage_woocommerce')){
		if (null !== filter_input_array(INPUT_POST)) {
			$inputs = filter_input_array(INPUT_POST);
			$plugin = new Dropshipping_Xox();
			$curl = $plugin->importAttr($inputs['wooid']);

			$imports = $curl['result'];
			$error = 0;
			foreach($imports as $key => $i){
				$_product_attributes[$i->the_title] = array(
					'name' => $i->the_label,
					'value' => $i->the_value,
					'position' => 0,
					'is_visible' => 1,
					'is_variation' => 1,
					'is_taxonomy' => 0
				);
				$insertAttr = update_post_meta($inputs['wooid'], '_product_attributes', $_product_attributes);
				if($insertAttr){
					$error = 0;
				}else{
					$error= $error+1;
				}
			}
		}
	}else{
		$error = 1;
	}
	
	if($error > 0){
		echo 0;
	}else{
		echo 1;
	}
	wp_die();
}

function dropshix_log( $message ) 
{ 
	if(is_array($message)) { 
		$message = json_encode($message, JSON_UNESCAPED_SLASHES); 
	}
	
	$file = fopen(DROPSHIX_LOG_FILE, "a"); 
	fwrite($file, date('Y-m-d h:i:s') . " :: " . $message ."\n"); 
	fclose($file); 
}