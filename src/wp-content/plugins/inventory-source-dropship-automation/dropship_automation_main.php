<?php if ( ! defined( 'ABSPATH' ) ) exit; 
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		// Put your plugin code here
		echo '<div style="padding:7px;font-weight:700;" id="frm_install_message" class="error">Please Install/Activate Woocommerce plugin under installed plugins to use the dropship automation service</div>';
	}else{
		
	
	global $current_user,$wpdb;
	get_currentuserinfo();
	$user_info = get_userdata($current_user->ID);
	$dsapktblne = $wpdb->prefix . 'dropshipapikey';
	/*** App Generation*/
	$return_url = admin_url('admin.php?page=inventory-source-dropship-automation/dropship_automation_main.php');
	$callback_url = 'https://www.inventorysource.com/InventorySourcev2/admin/wpcommerceWelcome?storeurl='.get_site_url().'&user_email='.$user_info->user_email.'&user_firstname='.$user_info->first_name.'&user_lastname='.$user_info->last_name;
	$store_url = get_site_url();
	$endpoint = '/wc-auth/v1/authorize';
	$params = [
		'app_name' => 'Dropship Woocommerce App',
		'scope' => 'read_write',
		'user_id' => $current_user->ID,
		'return_url' => $return_url,
		'callback_url' => $callback_url
	];
	$query_string = http_build_query( $params );
	$permissionirl = $store_url . $endpoint . '?' . $query_string;
	/**/	
	$sqlchk = $wpdb->prepare("SELECT * FROM $dsapktblne WHERE user_id = %d",$current_user->ID);
	$reschk = $wpdb->get_results($sqlchk);
	if(count($reschk) == 0){
		$sqlinsert = $wpdb->prepare("INSERT INTO $dsapktblne SET user_id = %d, active= %s",$current_user->ID,'0');
		$wpdb->query($sqlinsert);
		$dsapktblconf = $wpdb->prefix . 'options';
		$sqlupdconf = $wpdb->prepare("UPDATE $dsapktblconf SET option_value = %s, autoload=%s WHERE option_name=%s",'yes','yes','woocommerce_api_enabled');
		$wpdb->query($sqlupdconf);
	}
	if(isset($_REQUEST['success']) && $_REQUEST['success']!=""){
		$sqlupd = $wpdb->prepare("UPDATE $dsapktblne SET active=%s WHERE user_id = %d",$_REQUEST['success'],$_REQUEST['user_id']);
		$wpdb->query($sqlupd);
	}
	$sqlget = $wpdb->prepare("SELECT active FROM $dsapktblne WHERE user_id = %d limit 1",$current_user->ID);
	$resultget = $wpdb->get_results($sqlget);
	foreach ( $resultget as $resultdata ){
		$dsapk_active = $resultdata->active;
	}
	
	$datavar = '<div class="wrap">';
	$datavar .= '<div class="container" style="width: 100%; max-width: 989px;text-align: center;">
			<a href="http://www.inventorysource.com" border="0" target="_blank">
				<img src="'.plugins_url( 'inventory_logo.png', __FILE__ ).'" />
			</a>
			<br />';
	$datavar .= '<br />
		   <section>
			<div class="icons-control">';
	$datavar .=	"<img src='".plugins_url( 'WooCommerce-Plugin.png', __FILE__ )."' border='0' width='76%'/>";
	$datavar .=		'</div>
				<h2 style="font-size: 26px;">Inventory Source + WooCommerce = Automated Dropshipping</h2>
				<h3 class="title-is" style="font-size: 20px;font-weight: normal;">Add dropship ready products to your Wordpress blog and start monetizing your traffic today!</h3>
				<div class="checkboxes" style="text-align: left;width: 86%;margin:0 auto;">
					<ul>
							<li style="font-size:14px;line-height:1.5"><img src="'.plugins_url( 'check.png', __FILE__ ).'" border="0" align="absmiddle"  style="margin-right:4px;"/> Automatically load dropship ready products (with images, pricing & details) from our 100+ 
							supplier network into your Wordpress Website</li>
							<li style="font-size:14px;line-height:1.5"><img src="'.plugins_url( 'check.png', __FILE__ ).'" border="0" align="absmiddle" style="margin-right:4px;"/> Receive daily quantity updates to never sell products that are out of stock</li>
							<li style="font-size:14px;line-height:1.5"><img src="'.plugins_url( 'check.png', __FILE__ ).'" border="0" align="absmiddle" style="margin-right:4px;"/> Easily convert your Wordpress blog into an eCommerce revenue stream with very little 
							setup & management</li>
					</ul>
			 </div>';
			 if($dsapk_active==0){
	$datavar .= "<div style='clear:both;height:20px;'></div><div style=' text-align: center;text-decoration: none;margin-bottom:20px;'><a href='".$permissionirl."' style='background-color: #ad6ea1;border-radius: 3px;padding: 8px 10px 8px 10px;color: #fff;text-decoration: none;border:none;margin-top:-20px;cursor:pointer;'>Authenticate with WooCommerce</a>&nbsp;&nbsp;</div>";	
	}else{
		$datavar .= "<div style='display: inline-block;    margin-bottom: 15px;    margin-top: 40px;    text-align: center;    text-decoration: none;'><form name='frm' id='frm' method='post' target='_blank' action='https://inventorysource.com/InventorySourcev2/admin/wpcommerceWelcome'>
			<input type='hidden' name='user_email' id='user_email' value='".$user_info->user_email."'/>
			<input type='hidden' name='user_firstname' id='user_firstname' value='".$user_info->first_name."'/>
			<input type='hidden' name='user_lastname' id='user_lastname' value='".$user_info->last_name."'/>
	<input type='submit' style='background-color: #e71823;border-radius: 3px;padding: 8px 10px 8px 10px;color: #fff;text-decoration: none;border:none;float:right;margin-top:-20px;cursor:pointer;' name='sub' id='sub' value='Access Your Inventory Source Account'/>
			</form></div>";
	}
	$datavar .= '<div class="smaller-text">
			<strong>Inventory Source</strong> provides the eCommerce automation tools that allow you to automatically load product images, categories, pricing, & details from multiple dropship suppliers. Our daily monitoring updates your store with quantity, pricing, status, and any new products that come available. Our automation tools allow you to control price markup, map custom categories, and create product filters by price, category, shipping weight, SKU, and more
		  </div>
		  <br />
		  </section>
		 </div>';
	$datavar .= '</div><div style="clear:both;height:1px;">&nbsp;</div><style>#wpfooter{position:relative!important}#wpcontent{background:#fff;}</style>';
	echo $datavar;
}
	?>
