<?php

require_once 'Eprolo_InstallIndicator.php';

class Eprolo_LifeCycle extends Eprolo_InstallIndicator {

	public function install() {

		//Initialization data
		$this->initOptions();

		// Call the parent method to record the installed version
		$this->saveInstalledVersion();

		// Calling parent tag installed
		$this->markAsInstalled();
	}

	 /**
	  * Upgrading
	  */
	public function upgrade() {
	}

	/**
	 * Activate
	 */
	public function activate() {
			 return '';
	}

	/**
	 * Deactivate
	 */
	public function deactivate() {
	}

	/**
	 * AddActionsAndFilters
	 */
	public function addActionsAndFilters() {
	}

	/**
	 * Add the page name of menu operation jump
	 */
	public function addSettingsSubMenuPage() {
		$this->addSettingsSubMenuPageToPluginsMenu();//Add settings submenu page to plug-in menu
		//$this->addSettingsSubMenuPageToSettingsMenu();//Add settings submenu page to settings menu
	}


	protected function requireExtraPluginFiles() {
		include_once ABSPATH . 'wp-includes/pluggable.php';
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	/**
	 *
	 * Returns the name of the setting page URL
	 *
	 * @return string Slug name for the URL to the Setting page
	 * (i.e. the page for setting options)
	 */
	protected function getSettingsSlug() {
		//  return get_class($this) . 'Settings';
		return 'eprolo';
	}


	/**
	 * Parse parameter information in url and return parameter array
	 */
	public function convertUrlQuery( $query, $paramname ) {
		$queryParts = explode( '&', $query );
		$params     = array();
		foreach ( $queryParts as $param ) {
			$item = explode( '=', $param );
			if ( $item[0] == $paramname ) {
				 return $item[1];
			}
		}

	}

	/**
	 * Retrieve the url of the plugin
	 *
	 * @return string
	 */
	public function getUrl() {
		return \plugin_dir_url( __FILE__ );
	}


	//Plugin menu
	protected function addSettingsSubMenuPageToPluginsMenu() {
		//Check header URL and insert token
		if ( isset( $_SERVER['QUERY_STRING'] ) ) {
			$url = sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) );
		}
		if ( isset( $_SERVER['HTTP_HOST'] ) ) {
			$eprolo_shop_url = sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) );
		}
		//$url                = $_SERVER['QUERY_STRING'];
		$page_str           = $this->convertUrlQuery( $url, 'page' );
		$success            = $this->convertUrlQuery( $url, 'success' );
		$user_id            = $this->convertUrlQuery( $url, 'user_id' );
		$eprolo_store_token = $this->convertUrlQuery( $url, 'eprolo_store_token' );
		//$eprolo_shop_url    = $_SERVER['HTTP_HOST'];

		if ( 'eprolo' == $page_str && 1 == $success ) {
							  //Get token based on user_id
			$url    = 'eprolo_get_token.html?user_id=' . $user_id;//
			$result = $this->curlPost( $url ); //URL
			$arr    = json_decode( $result );
			$code   = $arr->code;
			if ( '0' == $code ) {//Success-change token
				$token = $arr->data->token;
									 $this->updateOption( 'eprolo_store_token', $token );
									 $this->updateOption( 'eprolo_user_id', $user_id );
									$this->updateOption( 'eprolo_connected', '1' );
									$this->updateOption( 'eprolo_shop_url', 'https://' . $eprolo_shop_url );
			}
			header( 'location:admin.php?page=eprolo' );
		}

		$this->requireExtraPluginFiles();
		$displayName = $this->getPluginDisplayName();
		add_menu_page(
			$displayName,
			$displayName,
			'manage_options',
			$this->getSettingsSlug(),
			array( &$this, 'settingsPage' ),
			"{$this->getUrl()}images/eprolo.png",
			56
		);
	}

	//Settings submenu
	protected function addSettingsSubMenuPageToSettingsMenu() {
		$this->requireExtraPluginFiles();
		$displayName = $this->getPluginDisplayName();
		add_options_page(
			$displayName,
			$displayName,
			'manage_options',
			$this->getSettingsSlug(),
			array( &$this, 'settingsPage' )
		);
	}



}
