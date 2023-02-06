<?php

require_once 'Eprolo_LifeCycle.php';

class Eprolo_Plugin extends Eprolo_LifeCycle {


	//Setting menu name
	public function getPluginDisplayName() {
		return ' EPROLO';
	}

	protected function getMainPluginFileName() {
		return 'eprolo.php';
	}

	public function upgrade() {
	}


	//Add menu
	public function addActionsAndFilters() {
		add_action( 'admin_menu', array( &$this, 'addSettingsSubMenuPage' ) );
	}

	//Get stored data
	protected function initOptions() {
				$options = $this->getOptionMetaData();
		if ( ! empty( $options ) ) {
			foreach ( $options as $key => $arr ) {
				if ( is_array( $arr ) && count( $arr > 1 ) ) {
					 $this->addOption( $key, $arr[1] );
				}
			}
		}
	}

}
