<?php

/**
 * Description of A2W_Account
 *
 * @author Andrey
 */
if (!class_exists('A2W_Account')) {

    class A2W_Account {
        private static $_instance = null;
        
        public $account_type = '';
        public $custom_account = false;
        
        public $account_data = array('aliexpress'=>array('appkey'=>'', 'trackingid'=>''), 'admitad'=>array('cashback_url'=>''));
        
        
        static public function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        protected function __construct() {
            $this->account_type = a2w_get_setting('account_type');
            $this->custom_account = a2w_get_setting('use_custom_account');
            $this->account_data = a2w_get_setting('account_data');
        }
        
        public function set_account_type($account_type) {
            $this->account_type = $account_type;
            a2w_set_setting('account_type', $this->account_type);
        }

        public function use_custom_account($use_custom_account = false) {
            $this->custom_account = $use_custom_account;
            a2w_set_setting('use_custom_account', $this->custom_account);
        }
        
        public function get_aliexpress_account() {
            return !empty($this->account_data['aliexpress'])?$this->account_data['aliexpress']:array('appkey'=>'', 'trackingid'=>'');
        }
        
        public function get_admitad_account() {
            return !empty($this->account_data['admitad'])?$this->account_data['admitad']:array('cashback_url'=>'');
        }
        

        public function save_aliexpress_account($appkey, $trackingid) {
            $this->account_data['aliexpress']['appkey']=$appkey;
            $this->account_data['aliexpress']['trackingid']=$trackingid;
            a2w_set_setting('account_data', $this->account_data);
        }
        
        public function save_admitad_account($cashback_url) {
            $this->account_data['admitad']['cashback_url']=$cashback_url;
            
            a2w_set_setting('account_data', $this->account_data);
        }
        
        public function build_params(){
            if (a2w_check_defined('A2W_ITEM_PURCHASE_CODE')) {
                $item_purchase_code = A2W_ITEM_PURCHASE_CODE;
            }else{
                $item_purchase_code = a2w_get_setting('item_purchase_code');
            }
            $result="token=".urlencode($item_purchase_code)."&version=".A2W()->version;
            
            if(!empty( $this->account_data['admitad']['cashback_url'])){
                $result.="&cashback_url=". urlencode($this->account_data['admitad']['cashback_url']);
            }
            
            return $result;
        }
    }

}