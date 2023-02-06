<?php

class Eprolo_OptionsManager {

	public function getOptionNamePrefix() {
		return get_class( $this ) . '_';
	}

	public function getOptionMetaData() {
		return array();
	}

	/**
	 * Array of string name of options
	 */
	public function getOptionNames() {
		return array_keys( $this->getOptionMetaData() );
	}

	/**
	 * Override this method to initialize options to default values and save to the database with add_option
	 */
	protected function initOptions() {
	}

	public function addOption( $optionName, $value ) {
		$prefixedOptionName = $this->prefix( $optionName ); // how it is stored in DB
		return add_option( $prefixedOptionName, $value );
	}

	/**
	 * Just returns the class name. Override this method to return something more readable
	 */
	public function getPluginDisplayName() {
		return get_class( $this );
	}

	/**
	 * Get the prefixed version input $name suitable for storing in WP options
	 * Idempotent: if $optionName is already prefixed, it is not prefixed again, it is returned without change
	 */
	public function prefix( $name ) {
		$optionNamePrefix = $this->getOptionNamePrefix();
		if ( strpos( $name, $optionNamePrefix ) === 0 ) {
			return $name; // already prefixed
		}
		return $optionNamePrefix . $name;
	}

	/**
	 * Remove the prefix from the input $name.
	 * Idempotent: If no prefix found, just returns what was input.
	 */
	public function &unPrefix( $name ) {
		$optionNamePrefix = $this->getOptionNamePrefix();
		if ( strpos( $name, $optionNamePrefix ) === 0 ) {
			$val = substr( $name, strlen( $optionNamePrefix ) );
			return $val;
		}
		return $name;
	}

	/**
	 * A wrapper function delegating to WP get_option() but it prefixes the input $optionName
	 * To enforce "scoping" the options in the WP options table thereby avoiding name conflicts
	 * if option is not set.
	 */
	public function getOption( $optionName, $default = null ) {

		$retVal = get_option( $optionName );
		if ( ! $retVal && $default ) {
			$retVal = $default;
		}
		return $retVal;
	}

	public function get_eprolo_version() {
		return $this->getOption( 'eprolo__version' );
	}

	/**
	 * A wrapper function delegating to WP delete_option() but it prefixes the input $optionName
	 * To enforce "scoping" the options in the WP options table thereby avoiding name conflicts
	 */
	public function deleteOption( $optionName ) {
		return delete_option( $optionName );
	}



	public function getRoleOption( $optionName ) {
		$roleAllowed = $this->getOption( $optionName );
		if ( ! $roleAllowed || '' == $roleAllowed ) {
			$roleAllowed = 'Administrator';
		}
		return $roleAllowed;
	}


	/**
	 * Retrieve the url of the plugin
	 */
	public function getUrl() {
		return \plugin_dir_url( __FILE__ );
	}

	public function updateOption( $optionName, $value ) {
		return update_option( $optionName, $value );
	}



	public function registerSettings() {
		$settingsGroup  = get_class( $this ) . '-settings-group';
		$optionMetaData = $this->getOptionMetaData();
		foreach ( $optionMetaData as $aOptionKey => $aOptionMeta ) {
			register_setting( $settingsGroup, $aOptionMeta );
		}
	}
	public function curlPost( $url ) {
		//      $ch = curl_init();
		//      $params[ CURLOPT_URL ] = 'https://app.eprolo.com/' . $url;    //Request URL
		//      //   $params[CURLOPT_URL] = "https://woocommerce.eprolo.com/".$url;
		//      $params[ CURLOPT_HEADER ]         = false; //Whether to return response headers
		//      $params[ CURLOPT_SSL_VERIFYPEER ] = false;
		//      $params[ CURLOPT_SSL_VERIFYHOST ] = false;
		//      $params[ CURLOPT_RETURNTRANSFER ] = true; //Whether to return the result
		//       // $params[CURLOPT_POSTFIELDS] = $data;
		//      curl_setopt_array( $ch, $params ); //Pass in curl parameters
		//      $content = curl_exec( $ch ); //carried out
		//      curl_close( $ch ); //Close connection
		//      return $content;
		$argc     = array( 'sslverify' => false );
		$response = wp_remote_get( 'https://app.eprolo.com/' . $url, $argc );
		$body     = wp_remote_retrieve_body( $response );
		// var_dump($body);
		return $body;
	}


	/**
	 * Creates HTML for the Administration page to set options for this plugin.
	 * Override this method to create a customized page.
	 */
	public function settingsPage() {
		$aplugin = new Eprolo_OptionsManager();
		wp_enqueue_script( 'startup', $aplugin->getUrl() . 'js/startup.js', array( 'jquery' ), $aplugin->get_eprolo_version(), true );
		wp_localize_script( 'startup', 'ajax_startup', array( 'ajaxUrl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'bootstrap', $aplugin->getUrl() . 'js/bootstrap.min.js', array( 'jquery' ), $aplugin->get_eprolo_version(), true );
		wp_enqueue_style( 'bootstrapCss', $aplugin->getUrl() . 'css/bootstrap.min.css', '', $aplugin->get_eprolo_version(), 'all' );
		wp_enqueue_style( 'custom', $aplugin->getUrl() . 'css/main.css', '', $aplugin->get_eprolo_version(), 'all' );
		$eprolo_store_token = $aplugin->getOption( 'eprolo_store_token' );
		$eprolo_connected   = $aplugin->getOption( 'eprolo_connected' );
		$eprolo_shop_url    = $aplugin->getOption( 'eprolo_shop_url' );
		$eprolo_user_id     = $aplugin->getOption( 'eprolo_user_id' );
		$url                = $aplugin->getUrl();

		?>
		
			<input type="hidden" id="eprolo_store_token" value="<?php echo esc_attr( $eprolo_store_token ); ?>" />
			  <input type="hidden" id="eprolo_connected" value="<?php echo esc_attr( $eprolo_connected ); ?>" />
			<input type="hidden" id="eprolo_shop_url" value="<?php echo esc_attr( $eprolo_shop_url ); ?>" />
			<input type="hidden" id="eprolo_user_id" value="<?php echo esc_attr( $eprolo_user_id ); ?>" />
			<input type="hidden" id="eprolo_file_url" value="<?php echo esc_attr( $url ); ?>" />
		
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding-top:10px">
			<img  width="200px" src="<?php echo esc_attr( $url ) . '/images/eprolo_logo.png'; ?>" >
			</ul>
			
			<ul class="nav nav-pills mb-3" id="Go_to_EPROLODIV" role="tablist" style="padding-top:10px;display: none;">
				<p id="Go_to_EPROL_tip" style="width: 100%;">Your store has been successfully connected to your EPROLO account.
				<br>
				<a style="margin-top:10px;margin-bottom:20px" href="https://www.eprolo.com/project/fix-errors-when-installing-eprolo-to-woocommerce-store/" target="_blank">How to fix errors like 'Consumer key is invalid' or 'Logistics tracking number synchronization error' when installing EPROLO to WooCommerce store?</a>
				</p>
				<li class="nav-item">
					  <a class="nav-link active" id="go_to_url" href="https://app.eprolo.com/WAuthToken.html?token=<?php echo esc_attr( $eprolo_store_token ); ?>&domain=<?php echo esc_attr( $eprolo_shop_url ); ?>  " target="_blank" aria-selected="true">Go to EPROLO</a>
				</li>
			</ul>
			
			<ul class="nav nav-pills mb-3"  id="DisconnectIV"  role="tablist" style="padding-top:20px">
				<li class="nav-item">
					<a class="nav-link active"  href="javascript:void(0);"  onClick="eprolo_disconnect()" aria-selected="true">Disconnect from  EPROLO</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="javascript:void(0);"   onClick="eprolo_reflsh()">Refresh</a>
				</li>
		   </ul> 
		   
           
		  <div  id="eprolo_connect_keyDIV" style="display: none;" >
			 <ul class="nav nav-pills mb-3"  role="tablist" style="padding-top:10px;margin-top:30px;">
				<li class="nav-item">
					 <a class="nav-link active"   id="Connect_to_EPROLO"  href=""  target="_blank"  >Connect to EPROLO</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="javascript:void(0);"   onClick="eprolo_reflsh()">Refresh</a>
				</li>
			 </ul>
			
			 <ul class="nav nav-pills mb-3"  role="tablist" style="padding-top:10px;margin-top:30px;" >
				  <div style="width: 100%;">Before connect to EPROLO, the following conditions must be met:</div>
                  <div style="width: 100%;">(1) WooCommerce plugin has been installed and activated;</div>
                  <div style="width: 100%;">(2) Set permalinks to anything other than "Plain" in Settings > Permalinks;</div>
                  <div style="width: 100%;">(3) Your website must be an SSL connection.</div><br>
                <a style="margin-top:10px;margin-bottom:20px" href="https://www.eprolo.com/project/install-eprolo-app-to-woocommerce-store/" target="_blank">How to install EPROLO APP to your Woocommerce store?</a>
				<br>
			 </ul>
		   </div>
			
		<?php

	}
}
