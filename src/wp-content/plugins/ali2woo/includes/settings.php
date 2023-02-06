<?php
/**
 * Description of A2W_Settings
 *
 * @author andrey
 */

if (!class_exists('A2W_Settings')) {

    class A2W_Settings {
        private $settings;
        private $auto_commit = true;
        
        private $default_settings = array(
            'api_endpoint'=>'http://ma-group5.com/api/v1/',
            'item_purchase_code'=>'',
            'envato_personal_token'=>'',
            'account_type'=> 'aliexpress',
            'use_custom_account'=>false,
            'account_data'=> array('aliexpress'=>array('appkey'=>'', 'trackingid'=>''), 'admitad'=>array('cashback_url'=>'')),
            
            'import_language'=> 'en',
            'local_currency'=> 'usd',
            'default_product_type'=> 'simple',
            'default_product_status'=> 'publish',
            'not_import_attributes'=> false,
            'not_import_description'=> false,
            'not_import_description_images'=> false,
            'import_extended_attribute'=> false,
            'import_extended_variation_attribute'=> true,
            'import_product_images_limit'=> 0,
            'use_external_image_urls'=> true,
            'use_cdn'=> false,
            'use_random_stock'=> false,
            'use_random_stock_min'=> 5,
            'use_random_stock_max'=> 15,
            'split_attribute_values'=> true,
            'attribute_values_separator'=> ',',
            'currency_conversion_factor'=> 1,
            'auto_update'=> false,
            'not_available_product_status'=> 'trash',
            'sync_type'=> 'price_and_stock',
            'fulfillment_prefship'=> 'EMS_ZX_ZX_US',
            'fulfillment_phone_code'=> '',
            'fulfillment_phone_number'=> '',
            'fulfillment_custom_note'=> '',
            
            'use_extended_price_markup'=> false,
            'use_compared_price_markup'=> false,
            'price_cents'=> -1,
            'price_compared_cents'=> -1,
            'default_formula'=> false,
            'formula_list'=> array(),
            
            'phrase_list'=> array(),
            
            'load_review'=> false,
            'review_status'=> false,
            'review_translated'=> false,
            'review_avatar_import'=> false,
            'review_max_per_product'=> 20,
            'review_raiting_from'=> 1,
            'review_raiting_to'=> 5,
            'review_noavatar_photo'=>'',
            'review_load_attributes'=> false,
            'review_show_image_list'=> false,
            'review_allow_country'=> '',
            
            'aliship_frontend'=> false,
            'aliship_shipto'=> 'US',
            
            'json_api_base'=> 'a2w_api',
            'json_api_controllers'=> 'core,auth',
            
            
            'system_message_last_update'=> 0,
            
            'image_editor_srickers'=> array(
                'https://static.alidropship.com/stickers/stick-001.png',
                'https://static.alidropship.com/stickers/stick-002.png',
                'https://static.alidropship.com/stickers/stick-003.png',
                'https://static.alidropship.com/stickers/stick-004.png',
                'https://static.alidropship.com/stickers/stick-005.png',
                'https://static.alidropship.com/stickers/stick-006.png',
                'https://static.alidropship.com/stickers/stick-007.png',
                'https://static.alidropship.com/stickers/stick-008.png',
                'https://static.alidropship.com/stickers/stick-009.png',
                'https://static.alidropship.com/stickers/stick-010.png',
                'https://static.alidropship.com/stickers/stick-011.png',
                'https://static.alidropship.com/stickers/stick-012.png',
                'https://static.alidropship.com/stickers/stick-013.png',
                'https://static.alidropship.com/stickers/stick-014.png',
                'https://static.alidropship.com/stickers/stick-015.png',
                'https://static.alidropship.com/stickers/stick-016.png',
                'https://static.alidropship.com/stickers/stick-017.png',
                'https://static.alidropship.com/stickers/stick-018.png',
                'https://static.alidropship.com/stickers/stick-019.png',
                'https://static.alidropship.com/stickers/stick-020.png',
                'https://static.alidropship.com/stickers/stick-021.png',
                'https://static.alidropship.com/stickers/stick-022.png')
        );

        private static $_instance = null;

        protected function __construct() {
            $this->load();
        }

        protected function __clone() {
            
        }

        static public function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function auto_commit($auto_commit = true){
            $this->auto_commit = $auto_commit;
        }
        
        public function load(){
            $this->settings = array_merge($this->default_settings, get_option('a2w_settings', array()));
        }
        
        public function commit(){
            update_option('a2w_settings', $this->settings);
        }
        
        public function to_string() { }
        
        public function from_string($str) { }


        public function get($setting, $default=''){
            return isset($this->settings[$setting])?$this->settings[$setting]:$default;
        }
        
        public function set($setting, $value){
            $old_value = isset($this->settings[$setting])?$this->settings[$setting]:'';
            
            do_action('a2w_pre_set_setting_'.$setting, $old_value, $value, $setting);
            
            $this->settings[$setting] = $value;
            
            if($this->auto_commit){
                $this->commit();
            }
            
            do_action('a2w_set_setting_'.$setting, $old_value, $value, $setting);
        }
        
        public function del($setting){
            if(isset($this->settings[$setting])){
                unset($this->settings[$setting]);
                
                if($this->auto_commit){
                    $this->commit();
                }
            }
        }
    }
}

if (!function_exists('a2w_settings')) {
    function a2w_settings() {
        return A2W_Settings::instance();
    }
}

if (!function_exists('a2w_get_setting')) {
    function a2w_get_setting($setting, $default='') {
        return a2w_settings()->get($setting, $default);
    }
}

if (!function_exists('a2w_set_setting')) {
    function a2w_set_setting($setting, $value) {
        if (a2w_check_defined('A2W_DEMO_MODE') && in_array($setting, array('use_external_image_urls'))) {
            return;
        }
        
        return a2w_settings()->set($setting, $value);
    }
}

if (!function_exists('a2w_del_setting')) {
    function a2w_del_setting($setting) {
        return a2w_settings()->del($setting);
    }
}