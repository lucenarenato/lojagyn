<?php

/**
 * Description of A2W_SettingPage
 *
 * @author Andrey
 * 
 * @autoload: a2w_init 
 */
if (!class_exists('A2W_SettingPageController')) {


    class A2W_SettingPageController extends A2W_AbstractAdminPage {

        private $product_import_model;
        private $woocommerce_model;

        public function __construct() {
            parent::__construct(__('Settings', 'ali2woo'), __('Settings', 'ali2woo'), 'import', 'a2w_setting', 30);

            $this->product_import_model = new A2W_ProductImport();
            $this->woocommerce_model = new A2W_Woocommerce();

            add_action('wp_ajax_a2w_update_price_rules', array($this, 'ajax_update_price_rules'));

            add_action('wp_ajax_a2w_apply_pricing_rules', array($this, 'ajax_apply_pricing_rules'));

            add_action('wp_ajax_a2w_update_phrase_rules', array($this, 'ajax_update_phrase_rules'));

            add_action('wp_ajax_a2w_apply_phrase_rules', array($this, 'ajax_apply_phrase_rules'));

            add_action('wp_ajax_a2w_get_status_apply_phrase_rules', array($this, 'ajax_get_status_apply_phrase_rules'));


            add_action('wp_ajax_a2w_calc_external_images_count', array($this, 'ajax_calc_external_images_count'));
            add_action('wp_ajax_a2w_calc_external_images', array($this, 'ajax_calc_external_images'));
            add_action('wp_ajax_a2w_load_external_image', array($this, 'ajax_load_external_image'));

            add_filter('a2w_setting_view', array($this, 'setting_view'));

            add_filter('a2w_configure_lang_data', array($this, 'configure_lang_data'));
        }

        function configure_lang_data($lang_data) {
            if ($this->is_current_page()) {
                $lang_data = array(
                    'process_loading_d_of_d_erros_d' => _x('Process loading %d of %d. Errors: %d.', 'Status', 'ali2woo'),
                    'load_button_text' => _x('Load %d images', 'Status', 'ali2woo'),
                    'all_images_loaded_text' => _x('All images loaded', 'Status', 'ali2woo'),
                );
            }
            return $lang_data;
        }

        public function render($params = array()) {
            $current_module = isset($_REQUEST['subpage']) ? $_REQUEST['subpage'] : 'common';

            $this->model_put("modules", $this->getModules());
            $this->model_put("current_module", $current_module);

            $this->include_view(array("settings/settings_head.php", apply_filters('a2w_setting_view', $current_module), "settings/settings_footer.php"));
        }

        public function getModules() {
            return apply_filters('a2w_setting_modules', array(
                array('id' => 'common', 'name' => __('Common settings', 'ali2woo')),
                array('id' => 'account', 'name' => __('Account settings', 'ali2woo')),
                array('id' => 'price_formula', 'name' => __('Pricing Rules', 'ali2woo')),
                array('id' => 'reviews', 'name' => __('Reviews settings', 'ali2woo')),
                array('id' => 'shipping', 'name' => __('Shipping settings', 'ali2woo')),
                array('id' => 'phrase_filter', 'name' => __('Phrase Filtering', 'ali2woo')),
                array('id' => 'system_info', 'name' => __('System Info', 'ali2woo')),
            ));
        }

        public function setting_view($current_module) {
            $view = "";
            switch ($current_module) {
                case 'common':
                    $view = $this->common_handle();
                    break;
                case 'account':
                    $view = $this->account_handle();
                    break;
                case 'price_formula':
                    $view = $this->price_formula();
                    break;
                case 'reviews':
                    $view = $this->reviews();
                    break;
                case 'shipping':
                    $view = $this->shipping();
                    break;
                case 'phrase_filter':
                    $view = $this->phrase_filter();
                    break;
                case 'system_info':
                    $view = $this->system_info();
                    break;
            }
            return $view;
        }

        private function common_handle() {
            global $a2w_settings;
            if (isset($_POST['setting_form'])) {
                a2w_settings()->auto_commit(false);
                a2w_set_setting('item_purchase_code', isset($_POST['a2w_item_purchase_code']) ? wp_unslash($_POST['a2w_item_purchase_code']) : '');
                a2w_set_setting('envato_personal_token', isset($_POST['a2w_envato_personal_token']) ? wp_unslash($_POST['a2w_envato_personal_token']) : '');

                a2w_set_setting('import_language', isset($_POST['a2w_import_language']) ? wp_unslash($_POST['a2w_import_language']) : 'en');
                a2w_set_setting('local_currency', isset($_POST['a2w_local_currency']) ? wp_unslash($_POST['a2w_local_currency']) : 'usd');
                a2w_set_setting('default_product_type', isset($_POST['a2w_default_product_type']) ? wp_unslash($_POST['a2w_default_product_type']) : 'simple');
                a2w_set_setting('default_product_status', isset($_POST['a2w_default_product_status']) ? wp_unslash($_POST['a2w_default_product_status']) : 'publish');
                a2w_set_setting('tracking_code_order_status', isset($_POST['a2w_tracking_code_order_status']) ? wp_unslash($_POST['a2w_tracking_code_order_status']) : '');

                //remove saved shipping meta
                A2W_ShippingMeta::clear_in_all_product();

                a2w_set_setting('currency_conversion_factor', isset($_POST['a2w_currency_conversion_factor']) ? wp_unslash($_POST['a2w_currency_conversion_factor']) : '1');
                a2w_set_setting('import_product_images_limit', isset($_POST['a2w_import_product_images_limit']) && intval($_POST['a2w_import_product_images_limit']) ? intval($_POST['a2w_import_product_images_limit']) : '');
                a2w_set_setting('import_extended_attribute', isset($_POST['a2w_import_extended_attribute']) ? 1 : 0);
                a2w_set_setting('import_extended_variation_attribute', isset($_POST['a2w_import_extended_variation_attribute']) ? 1 : 0);
                
                a2w_set_setting('use_external_image_urls', isset($_POST['a2w_use_external_image_urls']));
                a2w_set_setting('use_cdn', isset($_POST['a2w_use_cdn']));
                a2w_set_setting('not_import_attributes', isset($_POST['a2w_not_import_attributes']));
                a2w_set_setting('not_import_description', isset($_POST['a2w_not_import_description']));
                a2w_set_setting('not_import_description_images', isset($_POST['a2w_not_import_description_images']));

                a2w_set_setting('use_random_stock', isset($_POST['a2w_use_random_stock']));
                if (isset($_POST['a2w_use_random_stock'])) {
                    $min_stock = (!empty($_POST['a2w_use_random_stock_min']) && intval($_POST['a2w_use_random_stock_min']) > 0) ? intval($_POST['a2w_use_random_stock_min']) : 1;
                    $max_stock = (!empty($_POST['a2w_use_random_stock_max']) && intval($_POST['a2w_use_random_stock_max']) > 0) ? intval($_POST['a2w_use_random_stock_max']) : 1;

                    if ($min_stock > $max_stock) {
                        $min_stock = $min_stock + $max_stock;
                        $max_stock = $min_stock - $max_stock;
                        $min_stock = $min_stock - $max_stock;
                    }
                    a2w_set_setting('use_random_stock_min', $min_stock);
                    a2w_set_setting('use_random_stock_max', $max_stock);
                }

                a2w_set_setting('auto_update', isset($_POST['a2w_auto_update']));
                a2w_set_setting('not_available_product_status', isset($_POST['a2w_not_available_product_status']) ? wp_unslash($_POST['a2w_not_available_product_status']) : 'trash');
                a2w_set_setting('sync_type', isset($_POST['a2w_sync_type']) ? wp_unslash($_POST['a2w_sync_type']) : 'price_and_stock');
                
                a2w_set_setting('fulfillment_prefship', isset($_POST['a2w_fulfillment_prefship']) ? wp_unslash($_POST['a2w_fulfillment_prefship']) : 'ePacket');
                a2w_set_setting('fulfillment_phone_code', isset($_POST['a2w_fulfillment_phone_code']) ? wp_unslash($_POST['a2w_fulfillment_phone_code']) : '');
                a2w_set_setting('fulfillment_phone_number', isset($_POST['a2w_fulfillment_phone_number']) ? wp_unslash($_POST['a2w_fulfillment_phone_number']) : '');
                a2w_set_setting('fulfillment_custom_note', isset($_POST['a2w_fulfillment_custom_note']) ? wp_unslash($_POST['a2w_fulfillment_custom_note']) : '');
                
                a2w_settings()->commit();
                a2w_settings()->auto_commit(true);
            }
            
            $this->model_put("custom_currency", A2W_AliexpressLocalizator::getCustomCurrency());
            $this->model_put("order_statuses", function_exists('wc_get_order_statuses')?wc_get_order_statuses():array());
            
            return "settings/common.php";
        }

        private function account_handle() {
            $account = A2W_Account::getInstance();

            if (isset($_POST['setting_form'])) {
                $account->set_account_type(isset($_POST['a2w_account_type']) && in_array($_POST['a2w_account_type'], array('aliexpress','admitad'))?$_POST['a2w_account_type']:'aliexpress');
                $account->use_custom_account(isset($_POST['a2w_use_custom_account']));
                if ($account->custom_account && isset($_POST['a2w_account_type'])) {
                    if($_POST['a2w_account_type']=='aliexpress'){
                        $account->save_aliexpress_account(isset($_POST['a2w_appkey']) ? $_POST['a2w_appkey'] : '', isset($_POST['a2w_trackingid']) ? $_POST['a2w_trackingid'] : '');    
                    }else if($_POST['a2w_account_type']=='admitad'){
                        $account->save_admitad_account(isset($_POST['a2w_cashback_url']) ? $_POST['a2w_cashback_url'] : '');
                    }
                }
            }

            $this->model_put("account", $account);

            return "settings/account.php";
        }

        private function price_formula() {
            $formulas = A2W_PriceFormula::load_formulas();

            if ($formulas) {
                $add_formula = new A2W_PriceFormula();
                $add_formula->min_price = floatval($formulas[count($formulas) - 1]->max_price) + 0.01;
                $formulas[] = $add_formula;
                $this->model_put("formulas", $formulas);
            } else {
                $this->model_put("formulas", A2W_PriceFormula::get_default_formulas());
            }

            $this->model_put("default_formula", A2W_PriceFormula::get_default_formula());

            $this->model_put('cents', a2w_get_setting('price_cents'));
            $this->model_put('compared_cents', a2w_get_setting('price_compared_cents'));

            return "settings/price_formula.php";
        }

        private function reviews() {
            if (isset($_POST['setting_form'])) {
                a2w_settings()->auto_commit(false);
                a2w_set_setting('load_review', isset($_POST['a2w_load_review']));
                a2w_set_setting('review_status', isset($_POST['a2w_review_status']));
                a2w_set_setting('review_translated', isset($_POST['a2w_review_translated']));
                a2w_set_setting('review_avatar_import', isset($_POST['a2w_review_avatar_import']));

                a2w_set_setting('review_schedule_load_period', 'a2w_15_mins');

                a2w_set_setting('review_max_per_product', isset($_POST['a2w_review_max_per_product']) ? wp_unslash($_POST['a2w_review_max_per_product']) : '');

                //todo:
                if (isset($_POST['a2w_review_allow_country'])) {
                    $value = trim($_POST['a2w_review_allow_country']);
                    if (!empty($value)) {
                        $value = str_replace(" ", "", $_POST['a2w_review_allow_country']);
                        $value = strtoupper($value);
                    }

                    a2w_set_setting('review_allow_country', $value);
                }

                //raiting fields
                $raiting_from = 1;
                $raiting_to = 5;
                if (isset($_POST['a2w_review_raiting_from']))
                    $raiting_from = intval($_POST['a2w_review_raiting_from']);

                if (isset($_POST['a2w_review_raiting_to']))
                    $raiting_to = intval($_POST['a2w_review_raiting_to']);

                if ($raiting_from >= 5)
                    $raiting_from = 5;
                if ($raiting_from < 1 || $raiting_from > $raiting_to)
                    $raiting_from = 1;

                if ($raiting_to >= 5)
                    $raiting_to = 5;
                if ($raiting_to < 1)
                    $raiting_to = 1;

                a2w_set_setting('review_raiting_from', $raiting_from);
                a2w_set_setting('review_raiting_to', $raiting_to);


                //update more field
                a2w_set_setting('review_load_attributes', isset($_POST['a2w_review_load_attributes']));
                a2w_set_setting('review_show_image_list', isset($_POST['a2w_review_show_image_list']));

                if (isset($_FILES) && isset($_FILES['a2w_review_noavatar_photo']) && 0 === $_FILES['a2w_review_noavatar_photo']['error']) {

                    if (!function_exists('wp_handle_upload'))
                        require_once( ABSPATH . 'wp-admin/includes/file.php' );

                    $uploadedfile = $_FILES['a2w_review_noavatar_photo'];
                    $upload_overrides = array('test_form' => false);
                    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
                    if ($movefile) {
                        a2w_set_setting('review_noavatar_photo', $movefile['url']);
                    } else {
                        echo "Possible file upload attack!\n";
                    }
                }
                
                a2w_settings()->commit();
                a2w_settings()->auto_commit(true);
            }
            return "settings/reviews.php";
        }

        private function shipping() {
            if (isset($_POST['setting_form'])) {
        
                a2w_set_setting('aliship_shipto', isset($_POST['a2w_aliship_shipto']) ? wp_unslash($_POST['a2w_aliship_shipto']) : 'US');
                a2w_set_setting('aliship_frontend', isset($_POST['a2w_aliship_frontend']));
             
                if (isset($_POST['a2w_aliship_frontend'])){
                      if (isset($_POST['default_rule'])) {
                    A2W_ShippingPriceFormula::set_default_formula(new A2W_ShippingPriceFormula($_POST['default_rule']));
                }    
                }
            }

            $countryModel = new A2W_Country();

            $this->model_put("shipping_countries", $countryModel->get_countries());
       
            $this->model_put("default_formula", A2W_ShippingPriceFormula::get_default_formula());

            return "settings/shipping.php";
        }

        private function phrase_filter() {
            $phrases = A2W_PhraseFilter::load_phrases();

            if ($phrases) {
                $this->model_put("phrases", $phrases);
            } else {
                $this->model_put("phrases", array());
            }

            return "settings/phrase_filter.php";
        }

        private function system_info() {
            
            
            $server_ip = '-';
            if(array_key_exists('SERVER_ADDR', $_SERVER))
                $server_ip =  $_SERVER['SERVER_ADDR'];
            elseif(array_key_exists('LOCAL_ADDR', $_SERVER))
                $server_ip =  $_SERVER['LOCAL_ADDR'];
            elseif(array_key_exists('SERVER_NAME', $_SERVER))
                $server_ip =  gethostbyname($_SERVER['SERVER_NAME']);
            else {
                // Running CLI
                if(stristr(PHP_OS, 'WIN')) {
                    $server_ip =  gethostbyname(php_uname("n"));
                } else {
                    $ifconfig = shell_exec('/sbin/ifconfig eth0');
                    preg_match('/addr:([\d\.]+)/', $ifconfig, $match);
                    $server_ip = $match[1];
                }
            }

            $this->model_put("server_ip", $server_ip);

            return "settings/system_info.php";
        }

        public function ajax_update_phrase_rules() {
            a2w_init_error_handler();

            $result = A2W_ResultBuilder::buildOk();
            try {

                A2W_PhraseFilter::deleteAll();

                if (isset($_POST['phrases'])) {
                    foreach ($_POST['phrases'] as $phrase) {
                        $filter = new A2W_PhraseFilter($phrase);
                        $filter->save();
                    }
                }

                $result = A2W_ResultBuilder::buildOk(array('phrases' => A2W_PhraseFilter::load_phrases()));

                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);

            wp_die();
        }

        public function ajax_apply_phrase_rules() {
            a2w_init_error_handler();

            $result = A2W_ResultBuilder::buildOk();
            try {

                $type = isset($_POST['type']) ? $_POST['type'] : false;
                $scope = isset($_POST['scope']) ? $_POST['scope'] : false;

                if ($type === 'products' || $type === 'all_types') {
                    if ($scope === 'all' || $scope === 'import') {
                        $products = $this->product_import_model->get_product_list(false);

                        foreach ($products as $product) {

                            $product = A2W_PhraseFilter::apply_filter_to_product($product);
                            $this->product_import_model->upd_product($product);
                        }
                    }

                    if ($scope === 'all' || $scope === 'shop') {
                        //todo: update attributes as well
                        A2W_PhraseFilter::apply_filter_to_products();
                    }
                }

                if ($type === 'all_types' || $type === 'reviews') {

                    A2W_PhraseFilter::apply_filter_to_reviews();
                }

                if ($type === 'all_types' || $type === 'shippings') {
                    
                }
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);

            wp_die();
        }

        public function ajax_update_price_rules() {
            a2w_init_error_handler();

            $result = A2W_ResultBuilder::buildOk();
            try {
                a2w_settings()->auto_commit(false);
                $use_extended_price_markup = isset($_POST['use_extended_price_markup']) ? filter_var($_POST['use_extended_price_markup'], FILTER_VALIDATE_BOOLEAN) : false;
                $use_compared_price_markup = isset($_POST['use_compared_price_markup']) ? filter_var($_POST['use_compared_price_markup'], FILTER_VALIDATE_BOOLEAN) : false;

                a2w_set_setting('price_cents', isset($_POST['cents']) && intval($_POST['cents']) > -1 && intval($_POST['cents']) <= 99 ? intval(wp_unslash($_POST['cents'])) : -1);
                if ($use_compared_price_markup)
                    a2w_set_setting('price_compared_cents', isset($_POST['compared_cents']) && intval($_POST['compared_cents']) > -1 && intval($_POST['compared_cents']) <= 99 ? intval(wp_unslash($_POST['compared_cents'])) : -1);
                else
                    a2w_set_setting('price_compared_cents', -1);

                a2w_set_setting('use_extended_price_markup', $use_extended_price_markup);
                a2w_set_setting('use_compared_price_markup', $use_compared_price_markup);
                
                a2w_settings()->commit();
                a2w_settings()->auto_commit(true);

                if (isset($_POST['rules'])) {
                    A2W_PriceFormula::deleteAll();
                    foreach ($_POST['rules'] as $rule) {
                        $formula = new A2W_PriceFormula($rule);
                        $formula->save();
                    }
                }

                if (isset($_POST['default_rule'])) {
                    A2W_PriceFormula::set_default_formula(new A2W_PriceFormula($_POST['default_rule']));
                }

                $result = A2W_ResultBuilder::buildOk(array('rules' => A2W_PriceFormula::load_formulas(), 'default_rule' => A2W_PriceFormula::get_default_formula(), 'use_extended_price_markup' => $use_extended_price_markup, 'use_compared_price_markup' => $use_compared_price_markup));

                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);

            wp_die();
        }

        public function ajax_apply_pricing_rules() {
            a2w_init_error_handler();

            $result = A2W_ResultBuilder::buildOk(array('done'=>0));
            try {

                $type = isset($_POST['type']) ? $_POST['type'] : false;
                $scope = isset($_POST['scope']) ? $_POST['scope'] : false;
                $page = isset($_POST['page']) ? $_POST['page'] : 0;

                if ($page ==0 && ($scope === 'all' || $scope === 'import')) {
                    $products = $this->product_import_model->get_product_list(false);

                    foreach ($products as $product) {

                        if (!isset($product['disable_var_price_change']) || !$product['disable_var_price_change']) {
                            $product = A2W_PriceFormula::apply_formula($product, 2, $type);
                            $this->product_import_model->upd_product($product);
                        }
                    }
                    $result = A2W_ResultBuilder::buildOk(array('done'=>1));
                }
                if ($scope === 'all' || $scope === 'shop') {
                    $update_per_request = 50;
                    
                    $products_count = $this->woocommerce_model->get_products_count();
                    if(($page*$update_per_request+$update_per_request)>=$products_count){
                        $result = A2W_ResultBuilder::buildOk(array('done'=>1));
                    }else{
                        $result = A2W_ResultBuilder::buildOk(array('done'=>0));
                    }
                    
                    $product_ids = $this->woocommerce_model->get_products_ids($page, $update_per_request);
                    foreach ($product_ids as $product_id) {
                        $product = $this->woocommerce_model->get_product_by_post_id($product_id);
                        if (!isset($product['disable_var_price_change']) || !$product['disable_var_price_change']) {
                            $product = A2W_PriceFormula::apply_formula($product, 2, $type);
                            if (isset($product['sku_products']['variations']) && count($product['sku_products']['variations']) > 0) {
                                $this->woocommerce_model->update_price($product_id, $product['sku_products']['variations'][0]);

                                foreach ($product['sku_products']['variations'] as $var) {
                                    $variation_id = get_posts(array('post_type' => 'product_variation', 'fields' => 'ids', 'numberposts' => 100, 'post_parent' => $product_id, 'meta_query' => array(array('key' => 'external_variation_id', 'value' => $var['id']))));
                                    $variation_id = $variation_id ? $variation_id[0] : false;
                                    if ($variation_id) {
                                        $this->woocommerce_model->update_price($variation_id, $var);
                                    }
                                }
                                wc_delete_product_transients($product_id);
                            }
                        }
                    }
                }

                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);

            wp_die();
        }

        public function ajax_calc_external_images_count() {
            echo json_encode(A2W_ResultBuilder::buildOk(array('total_images' => A2W_Attachment::calc_total_external_images())));
            wp_die();
        }

        public function ajax_calc_external_images() {
            $page_size = isset($_POST['page_size']) && intval($_POST['page_size']) > 0 ? intval($_POST['page_size']) : 1000;
            $result = A2W_ResultBuilder::buildOk(array('ids' => A2W_Attachment::find_external_images($page_size)));
            echo json_encode($result);
            wp_die();
        }

        public function ajax_load_external_image() {
            global $wpdb;

            a2w_init_error_handler();

            $attachment_model = new A2W_Attachment('local');

            $image_id = isset($_POST['id']) && intval($_POST['id']) > 0 ? intval($_POST['id']) : 0;

            if ($image_id) {
                try {
                    $attachment_model->load_external_image($image_id);

                    $result = A2W_ResultBuilder::buildOk();
                } catch (Exception $e) {
                    $result = A2W_ResultBuilder::buildError($e->getMessage());
                }
            } else {
                $result = A2W_ResultBuilder::buildError("load_external_image: waiting for ID...");
            }


            echo json_encode($result);
            wp_die();
        }

    }

}
