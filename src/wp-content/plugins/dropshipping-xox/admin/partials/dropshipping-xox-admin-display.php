<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://xolluteon.com
 * @since      1.0.0
 *
 * @package    Dropshipping_Xox
 * @subpackage Dropshipping_Xox/admin/partials
 */

function webApplicationDisplay($project_id)
{
	?>
	<style type="text/css">
		#wpcontent{
			padding-left: 5px;
		}
	</style>
	<div class="wrap">
		<div class="container-fluid">
			<div class="row">
				<div class="page-header">
					<h3>DROPSHIX™ <small>Web Application</small></h3>
					<p class="pull-right" style="position: relative; top: -10px; right: 5px;">Version <?php echo DROPSHIX_VERSION; ?></p>
				</div>
				<div class="col-sm-12">
					<a href="<?php echo DROPSHIX_URL; ?>/app/<?php echo $project_id; ?>" target="_BLANK">Click here to access DROPSHIX WEB APPLICATION</a>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function dropshix_section_developers_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'dropshix' ); ?></p>
    <?php
}

function dropshix_field_pill_cb( $args ) {
    $options = get_option( 'dropshix_opt' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb2( $args ) {
    $options = get_option( 'dropshix_opt' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb3( $args ) {
    $options = get_option( 'dropshix_opt_mp' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt_mp[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb4( $args ) {
    $options = get_option( 'dropshix_opt_mp' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt_mp[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_section_dev_cb( $args ) {
    ?>
    
    <?php
}

function dropshix_section_dev_api_ali_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>">
    	How to get API from AliExpress ?<br> 
        please visit the documentation <a target="_BLANK" href="https://portals.aliexpress.com/" >here.</a>
    </p>
    <?php
}

function dropshix_admin_option_display()
{
	if ( !current_user_can( 'manage_options' ) ) {
	    return false;
	}

	if ( isset( $_GET['settings-updated'] )) {
	    add_settings_error( 'dropshix_messages', 'dropshix_message', __( 'Settings Saved', 'dropshix' ), 'updated' );
	}

	settings_errors( 'dropshix_messages' );
	?>
	<style type="text/css">
		#wpfooter {
			position: relative !important;
		}
	</style>
	<div class="wrap">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 page-header">
					<h3 class="float-left">DROPSHIX™ <small>Active Products</small></h3>
					<p class="float-right" style="position: relative; top: -10px; right: 5px;">Version <?php echo DROPSHIX_VERSION; ?></p>
				</div>
				<div style="display: none;" id="APIKeysForm">
					<form action="options.php" class="inline-form" method="post">
					    <?php
					    settings_fields( 'dropshix' );
					    do_settings_sections( 'dropshix' );
					    submit_button( 'Save Settings' );
					    ?>
					</form>
				</div>
				<?php
				$isUsingPolylang = is_plugin_active( 'polylang/polylang.php' );
				$val = get_option('dropshix_opt');
				if($val['dropshix_API_public'] == '' || $val['dropshix_API_private'] == '' || $val['x_tool_source'] == ''): 
					?>
					<div class="alert alert-warning text-left">
						<h3>You're not registered yet, or you have not yet input your API key.</h3>
						<h4>Register to get your API key by clicking the button below</h4>
						<p><a href="<?php echo DROPSHIX_URL; ?>/register" class="btn btn-danger" target="_blank"><i class="glyphicon glyphicon-cog"></i> REGISTER NOW</a></p>
						<p>&nbsp;</p>
						<h4>If you already have your API Keys, please submit them to connect with DROPSHIX server by clicking the button below.</h4>
						<p><a data-fancybox data-src="#APIKeysForm" class="btn btn-success" href="javascript:;"><i class="glyphicon glyphicon-record"></i> Submit API Keys</a></p>
					</div>
				<?php else: ?>
					<?php 
					if( isset($val) && ($val['dropshix_API_public'] != '' || $val['dropshix_API_private'] != '')){
						$plugin = new Dropshipping_Xox();
						$url = $plugin->getProfitUrlSetup();
						$check_url = $plugin->getCheckApiURL();
						$myaccount = $plugin->myAccount();
						$profile = $plugin->getUserProfile();
						$chr = $plugin->getKeys();
					}
					?>
					<div class="col-sm-12">
						<a data-fancybox data-src="#APIKeysForm" class="btn btn-primary" href="javascript:;"><i class="glyphicon glyphicon-record"></i> Update API Keys</a>&nbsp;
					    <?php if(isset($check_url)): ?>
						<a data-fancybox data-type="iframe" data-src="<?= $check_url ?>" data-height="" href="javascript:;" class="fancybox-xox btn btn-outline-danger"><i class="glyphicon glyphicon-refresh"></i> Check Dropshix API Keys</a>&nbsp;   	
						<?php endif; ?>
					    <?php if(isset($url)): ?>
						<a data-fancybox data-type="iframe" data-src="<?= $url ?>" data-height="" href="javascript:;" class="fancybox-xox btn btn-warning"><i class="glyphicon glyphicon-cog"></i> Dropshix Configuration</a>
						<?php endif; ?>
					</div>
					<div class="col-sm-12" style="margin-top: 15px;">
						<?php
						if(isset($myaccount)):
							$stat = null;
							if(isset($profile)){
								$stat = isset($profile->product) ? $profile->product : null;
							}
							// var_dump($myaccount);
							if (isset($myaccount->isfree) && $myaccount->isfree) {
								$class = 'alert alert-warning';
							}elseif(!isset($myaccount->isfree) || null === $myaccount->api){
								$class = 'alert alert-danger';
							}else{
								$class = 'alert alert-info';
							}
							// var_dump($stat);
							?>
							<div class="<?php echo $class; ?> text-left">
								<?php if(null !== $stat && $stat->limit > 15): ?>
									<p>Package: <?php echo $stat->type; ?></p>
								<?php endif; ?>
								<?php if (isset($myaccount->isfree) && $myaccount->isfree): ?>
									<p><span style="font-size: 10px; font-style: italic;">You are in free package, upgrade to <a href="<?php echo DROPSHIX_URL; ?>/register/services/<?php echo $myaccount->project_id; ?>/application-plugins/dropshix-basic-package" class="text-danger">Basic Package</a> to have more features open.</span></p>
								<?php elseif(!isset($myAccount->isfree) && null === $stat): ?>
									<p class="text-danger"><span style="font-size: 10px; font-style: italic;">Something is wrong with your API Keys or There is a misconfiguration on your hosting setup (FAILED TO CONNECT).</span></p>
								<?php endif ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				</div>
				<div class="row">
					
				</div>
				<div class="row" style="margin-top: 15px;">
			        <div class="col-sm-12">
					    <table class="table table-condensed table-responsive">
					    	<tbody>
					    		<?php if(isset($chr)): ?>
					    		<tr>
					    			<td style="width: 40%;">
					    				<p><strong>DROPSHIX Chrome Extension Key</strong><br><span style="font-size: 10px; font-style: italic;">Input this key to your Dropshix Chrome extension to connect betweeen system.</span></p>
					    			</td>
					    			<td style="width: 60%;">
					    				<?php if(isset($myaccount->isfree) && !$myaccount->isfree) : ?>
					    					<div class="alert alert-success">
					    						<input type="text" readonly="readonly" style="width: 100%; cursor: text;" value="<?php echo $chr; ?>">
					    					</div>
					    				<?php else: ?>
					    					<div class="alert alert-success">
					    						<input type="text" readonly="readonly" style="width: 100%; cursor: text;" value="<?php echo $chr; ?>">
					    						<p><span style="font-size: 10px; font-style: italic;">You are in free package, upgrade to <a href="<?php echo DROPSHIX_URL; ?>/register/services/<?php echo $myaccount->project_id; ?>/application-plugins/dropshix-basic-package" class="text-danger">Basic Package</a> to have more features open.</span></p>
					    					</div>
					    				<?php endif; ?>
					    			</td>
					    		</tr>
					    		<?php endif; ?>
					    	</tbody>
					    </table>
					    <h3>Pre Requisite Check-list.</h3>
					    <table class="table table-bordered table-responsive">
					    	<thead>
					    		<tr>
					    			<th style="width: 40%;">Item to check</th>
					    			<th>Status</th>
					    		</tr>
					    	</thead>
					    	<tbody>
					    		<tr>
					    			<td>
					    				<p><strong>CURL module status.</strong><br><span style="font-size: 10px; font-style: italic;">CURL is a method to connect data between Dropshix server and your woocommerce store.</span></p>
					    			</td>
					    			<td>
					    				<?php if(dropshix_is_curl_installed()) : ?>
					    					<div class="alert alert-success">
					    						<p style="font-size: 12px;width:100%;display: block;">You have CURL installed.</p>
					    					</div>
					    				<?php else: ?>
					    					<div class="alert alert-danger">
					    						<p style="font-size: 12px;width:100%;display: block;">You don't have CURL installed!</p>
					    					</div>
					    				<?php endif; ?>
					    			</td>
					    		</tr>
					    		<?php if(isset($plugin)): ?>
					    		<tr>
					    			<td>
					    				<p><strong>Connection check.</strong><br><span style="font-size: 10px; font-style: italic;">Test connection from your server to Dropshix server using CURL module.</span></p>
					    			</td>
					    			<td>
					    				<?php $dconn = $plugin->checkConn(); ?>
					    				<?php if($dconn->status == 'SUCCESS') : ?>
					    					<div class="alert alert-success">
					    						<p style="font-size: 12px;width:100%;display: block;"><?php echo $dconn->status.'! - '.$dconn->errorCode; ?>. Connection is made and return OK.</p>
					    					</div>
					    				<?php else: ?>
					    					<div class="alert alert-danger">
					    						<p style="font-size: 12px;width:100%;display: block;"><?php echo $dconn->status.'! - '.$dconn->errorCode; ?>. Connection to DROPSHIX server cannot be made!</p>
					    					</div>
					    				<?php endif; ?>
					    			</td>
					    		</tr>
					    		<?php endif; ?>
					    		<tr>
					    			<td>
					    				<p><strong>Capability check.</strong><br><span style="font-size: 10px; font-style: italic;">Checking current user capability.</span></p>
					    			</td>
					    			<td>
					    				<?php if(current_user_can('administrator')) : ?>
					    					<div class="alert alert-success">
					    						<p style="font-size: 12px;width:100%;display: block;">User capability is Admin (OK).</p>
					    					</div>
					    				<?php else: ?>
					    					<div class="alert alert-danger">
					    						<p style="font-size: 12px;width:100%;display: block;">Current user is not an Admin (ERROR).</p>
					    					</div>
					    				<?php endif; ?>
					    			</td>
					    		</tr>
					    		<?php if($isUsingPolylang): ?>
				    			<tr>
				    				<td colspan="2">
				    					<div class="alert alert-warning">
				    						<p style="font-size: 12px;width:100%;display: block;"><strong>You are using Polylang plugin.</strong><br><span style="font-size: 10px; font-style: italic;">Dropshix is aware that there several features that are not working when you use Polylang plugin.</span></p>
				    					</div>
				    				</td>
				    			</tr>
				    			<?php endif; ?>
					    	</tbody>
					    </table>
			        </div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function dropshix_queued_product_display()
{
	global $woocommerce;

	$plugin = new Dropshipping_Xox();
	$dshixajaxurl = $plugin->setupAjaxUrl('pending');
	$profile = $plugin->getUserProfile();
	// set nonce.
	$ajax_nonce = wp_create_nonce( "dropshix-security-nonce" );

	$stat = $profile->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 page-header">
				<h3 class="float-left">DROPSHIX™ <small>Active Products</small></h3>
				<p class="float-right" style="position: relative; top: -10px; right: 5px;">Version <?php echo DROPSHIX_VERSION; ?></p>
			</div>
			<div class="col-12" id="xoxStat">
				<h4>Queued Products <span class="pull-right"><?php echo $profile->status; ?> - <?php echo $profile->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					Current active items: <span id="itemActive"><?php echo $stat->activelistings; ?></span>
					<span class="d-none"><?php echo $profile->url; ?></span>
					<input type="hidden" id="dshix_url" name="dshix_url" value="<?php echo plugins_url( '',  __FILE__ ); ?>">
					<input type="hidden" name="dlevel" id="dlevel" value="<?php echo $stat->limit; ?>">
					<input type="hidden" name="dshixajaxurl" id="dshixajaxurl" value="<?php echo $dshixajaxurl; ?>">
					<input type="hidden" name="ajax_nonce" id="ajax_nonce" value="<?php echo $ajax_nonce; ?>">
					<!-- <a class="btn btn-primary pull-right" href="#" onclick="DTreload($('#tblPending'))" style="margin-top: -7px;">Refresh</a> -->
				</p>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div id="dshixModal" class="modal" role="dialog" style="z-index: 99999;">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Product has been imported</h4>
						</div>
						<div class="modal-body">
							<p id="message-box"></p>
							<p>
								<a id="btn-edit-dropshix" class="btn btn-warning" target="_blank" href="">Edit Imported Product</a>&nbsp;|&nbsp;
								<a id="btn-view-dropshix" class="btn btn-success" target="_blank" href="">View Imported Product</a>
							</p>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<div id="result" class="col-12"></div>
			<div class="col-12" id="tablePendingHolder">
				<table id="tblPending" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th style="width: 60px;">Source ID</th>
							<th style="width: 100px;">Date</th>
							<th style="width: 230px;">Title</th>
							<th>Source</th>
							<th>Image</th>
							<th style="width: 90px;">Price</th>
							<th style="width: 90px;">Sale</th>
							<th>Vol</th>
							<th>Action</th>
						</tr>
					</thead>
					<tfoot style="display: table-header-group;">
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php
}

function dropshix_active_product_display()
{
	global $woocommerce;
	$plugin = new Dropshipping_Xox();
	$dshixajaxurl = $plugin->setupAjaxUrl('active');
	$profile = $plugin->getUserProfile();
	// set nonce.
	$ajax_nonce = wp_create_nonce( "dropshix-security-nonce" );

	$stat = $profile->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 page-header">
				<h3 class="float-left">DROPSHIX™ <small>Active Products</small></h3>
				<p class="float-right" style="position: relative; top: -10px; right: 5px;">Version <?php echo DROPSHIX_VERSION; ?></p>
			</div>
			<div class="col-12" id="xoxStat">
				<h4>Active Products <span class="pull-right"><?php echo $profile->status; ?> - <?php echo $profile->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					Current active items: <span id="itemActive"><?php echo $stat->activelistings; ?></span>
					<span class="d-none"><?php echo $profile->url; ?></span>
					<input type="hidden" id="dshix_url" name="dshix_url" value="<?php echo plugins_url( '',  __FILE__ ); ?>">
					<input type="hidden" name="dlevel" id="dlevel" value="<?php echo $stat->limit; ?>">
					<input type="hidden" name="dshixajaxurl" id="dshixajaxurl" value="<?php echo $dshixajaxurl; ?>">
					<input type="hidden" name="ajax_nonce" id="ajax_nonce" value="<?php echo $ajax_nonce; ?>">
				</p>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12" id="tablePendingHolder">
				<table id="tblActive" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th rowspan="2" style="width: 60px;">Source</th>
							<th rowspan="2" style="width: 100px;">Post #</th>
							<th rowspan="2" style="width: 100px;">Date</th>
							<th rowspan="2" style="width: 230px;">Title</th>
							<th rowspan="2">Image</th>
							<th colspan="2">Original Price</th>
							<th colspan="2">Your Price</th>
							<th rowspan="2" style="width: 180px;">Action</th>
						</tr>
						<tr>
							<th style="width: 90px;">Reguler</th>
							<th style="width: 90px;">Sale</th>
							<th style="width: 90px;">Reguler</th>
							<th style="width: 90px;">Sale</th>
						</tr>
					</thead>
					<tfoot style="display: table-header-group;">
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php
}

function dropshix_inactive_product_display()
{
	global $woocommerce;
	$currency_code = get_woocommerce_currency();
	$currency_symbol = get_woocommerce_currency_symbol();
	$plugin = new Dropshipping_Xox();
	$queues = $plugin->listQueued('xox-inactive');

	$stat = $queues->result->product;
	$diff = $stat->limit - $stat->activelistings;
	if($diff <= 10 && $diff > 5){
		$alert = 'alert alert-warning';
	}elseif($diff <= 5){
		$alert = 'alert alert-danger';
	}else{
		$alert = 'alert alert-success';
	}
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="page-header">
				<h3>DROPSHIX™ <small>Inactive Products</small></h3>
				<p class="pull-right" style="position: relative; top: -10px; right: 5px;">Version <?php echo DROPSHIX_VERSION; ?></p>
			</div>
			<div class="col-12" id="xoxStat">
				<h4>Inactive Products <span class="pull-right"><?php echo $queues->status; ?> - <?php echo $queues->errorCode; ?></span></h4>
				<p class="<?php echo $alert; ?>">
					<span style="margin-right: 10px;">Package: <strong><?php echo $stat->type; ?></strong></span>
					<span style="margin-right: 10px;">Active items limit: <?php echo $stat->limit; ?></span>
					<span id="itemActive">Current active items: <?php echo $stat->activelistings; ?></span>
					<span class="d-none"><?php echo $queues->url; ?></span>
				</p>
			</div>
		</div>
	</div>
	<?php $listings = $queues->result->listings; ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12" id="tablePendingHolder">
				<table id="tblInActive" class="table table-striped table-hovered table-bordered">
					<thead>
						<tr>
							<th>Product ID</th>
							<th>Source</th>
							<th>Last Recorded Original Price</th>
							<th>Last Recorded Your Price</th>
							<th>Last Recorded Profit</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(is_array($listings) && count($listings) > 0):
							foreach ($listings as $key => $val) {
								$reporturl = $plugin->getReportUrl();
								if(isset($val->result)){
									$item = $val->result;
								}else{
									$item = $val;
								}
								switch ($item->source) {
									case 'ae':
										$source = '[AliExpress]';
										$url = 'https://www.aliexpress.com/item//'.$item->product_id.'.html';
										break;

									case 'amus':
										$source = '[Amazon US]';
										$url = 'https://www.amazon.com/dp/'.$item->product_id.'/';
										break;
									
									default:
										$source = '[AliExpress]';
										$url = 'https://www.aliexpress.com/item//'.$item->product_id.'.html';
										break;
								}
								$profit = $item->price - $item->originalPrice;
								?>
								<tr id="ic-<?php echo $item->product_id; ?>">
									<td><a target="_blank" href="<?php echo $url; ?>"><?php echo $item->product_id; ?></a></td>
									<td><?php echo $source; ?></td>
									<td><?php echo $currency_symbol . floatval(str_replace('US $', '', $item->originalPrice)) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($item->price) . ' ' . $currency_code; ?></td>
									<td><?php echo $currency_symbol . floatval($profit) . ' ' . $currency_code; ?></td>
									<td id="action-<?php echo $item->productId; ?>" class="text-center">
										<p>
											<a href="javascript:;" data-id="<?php echo $item->product_id; ?>" data-source="<?php echo $item->source; ?>" class="xox-archivethisfa xox-archivethisfa-<?php echo $item->product_id; ?> btn btn-default xox-archive">Archive</a>
										</p>
									</td>
								</tr>
								<?php
							}
						endif;
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}
?>