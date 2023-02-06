<?php

/*
  Controller name: Core
  Controller description: Basic introspection methods
 */

class A2W_JSON_API_Core_Controller {

    private $product_import_model;
    private $loader;

    public function __construct() {
        $this->product_import_model = new A2W_ProductImport();
        $this->woocommerce_model = new A2W_Woocommerce();
        $this->loader = new A2W_Aliexpress();
    }

    public function info() {
        global $a2w_json_api;
        if (!empty($a2w_json_api->query->controller)) {
            return $a2w_json_api->controller_info($a2w_json_api->query->controller);
        } else {
            $active_controllers = explode(',', a2w_get_setting('json_api_controllers'));
            $controllers = array_intersect($a2w_json_api->get_controllers(), $active_controllers);
            return array(
                'json_api_version' => A2W_JSON_API_VERSION,
                'controllers' => array_values($controllers)
            );
        }
    }

    function add_product() {
        global $wpdb;
        global $a2w_json_api;
        $result = array();

        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $product_id = $_REQUEST['id'];
        if (empty($product_id)) {
            $a2w_json_api->error("No ID specified. Include 'id' var in your request.");
        } else {

            $product = array('id' => $product_id);

            if (!empty($_REQUEST['url'])) {
                $product['url'] = $_REQUEST['url'];
            }
            if (!empty($_REQUEST['thumb'])) {
                $product['thumb'] = $_REQUEST['thumb'];
            }
            if (!empty($_REQUEST['price'])) {
                $product['price'] = str_replace(",", ".", $_REQUEST['price']);
            }
            if (!empty($_REQUEST['price_min'])) {
                $product['price_min'] = str_replace(",", ".", $_REQUEST['price_min']);
            }
            if (!empty($_REQUEST['price_max'])) {
                $product['price_max'] = str_replace(",", ".", $_REQUEST['price_max']);
            }
            if (!empty($_REQUEST['title'])) {
                $product['title'] = $_REQUEST['title'];
            }
            if (!empty($_REQUEST['currency'])) {
                $product['currency'] = $_REQUEST['currency'];
            }
            
            $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $product['id']));
            if ((defined('A2W_DEBUG_PAGE') && A2W_DEBUG_PAGE) || !$post_id) {
                $result = $this->loader->load_product($product['id']);
                if ($result['state'] !== 'error') {
                    $product = array_replace_recursive($product, $result['product']);
                    $product = A2W_PriceFormula::apply_formula($product);

                    $result = $this->product_import_model->add_product($product);

                    if ($result) {
                        $result = array('status' => 'warning', 'warning' => 'Product already exist');
                    }
                } else {
                    $a2w_json_api->error($result['message']);
                }
            }else{
                $a2w_json_api->error('Product already imported.');
            }
        }

        return $result;
    }

    function upd_product() {
        global $a2w_json_api;

        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $product_id = $_REQUEST['id'];
        if (empty($product_id)) {
            $a2w_json_api->error("No ID specified. Include 'id' var in your request.");
        } else {

            $product = $this->product_import_model->get_product($product_id);
            if (!$product) {
                $product = array('id' => $product_id);
            }

            if (!empty($_REQUEST['url'])) {
                $product['url'] = $_REQUEST['url'];
            }
            if (!empty($_REQUEST['thumb'])) {
                $product['thumb'] = $_REQUEST['thumb'];
            }
            if (!empty($_REQUEST['price'])) {
                $product['price'] = str_replace(",", ".", $_REQUEST['price']);
            }
            if (!empty($_REQUEST['price_min'])) {
                $product['price_min'] = str_replace(",", ".", $_REQUEST['price_min']);
            }
            if (!empty($_REQUEST['price_max'])) {
                $product['price_max'] = str_replace(",", ".", $_REQUEST['price_max']);
            }
            if (!empty($_REQUEST['title'])) {
                $product['title'] = $_REQUEST['title'];
            }
            if (!empty($_REQUEST['currency'])) {
                $product['currency'] = $_REQUEST['currency'];
            }

            $this->product_import_model->upd_product($product);
        }

        return array();
    }

    function del_product() {
        global $a2w_json_api;


        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $product_id = $_REQUEST['id'];
        if (empty($product_id)) {
            $a2w_json_api->error("No ID specified. Include 'id' var in your request.");
        } else {
            $this->product_import_model->del_product($product_id);
        }
        return array();
    }

    function get_products() {
        global $a2w_json_api;


        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $tmp_products = $this->product_import_model->get_product_list();

        if (isset($_REQUEST['html'])) {
            return array('products' => $tmp_products);
        } else {
            $result = array();
            foreach ($tmp_products as $id => $p) {
                $result[$id] = array('id' => $id);
            }
            return array('products' => $result);
        }
    }
    
    function upd_order() {
      
        global $a2w_json_api;

        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $order_id = $_REQUEST['id'];
        if (empty($order_id)) {
            $a2w_json_api->error("No ID specified. Include 'id' var in your request.");
        } else {
            if ( wc_get_order($order_id) === false ){
                $a2w_json_api->error("Did not find the appropriate Woocommerce order.");    
            } else {
                $order_data = array('meta'=>array());
            
                if(!empty($_REQUEST['external_id'])){
                    $order_data['meta']['_a2w_external_order_id'] = $_REQUEST['external_id'];
                }
                
                $this->woocommerce_model->update_order($order_id, $order_data);
            }
            
           
        }

        return array();
    }

    function get_settings() {
        global $a2w_json_api;

        if (!$a2w_json_api->query->cookie) {
            $a2w_json_api->error("You must include a 'cookie' var in your request. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user_id = wp_validate_auth_cookie($a2w_json_api->query->cookie, 'logged_in');
        if (!$user_id) {
            $a2w_json_api->error("Invalid authentication cookie. Use the `generate_auth_cookie` Auth API method.");
            return array();
        }
        $user = get_userdata($user_id);


        $settings = array('a2w_fulfillment_prefship' => a2w_get_setting('fulfillment_prefship', 'ePacket'),
            'a2w_aliship_shipto' => a2w_get_setting('aliship_shipto', 'US'),
            'a2w_import_language' => a2w_get_setting('import_language', 'en'),
            'a2w_local_currency' => a2w_get_setting('local_currency', 'usd')
        );

        return array('settings' => $settings);
    }

}
