<?php

/**
 * Description of A2W_SearchPage
 *
 * @author andrey
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_SearchPageController')) {

    class A2W_SearchPageController extends A2W_AbstractAdminPage {

        private $loader;
        private $product_import_model;

        public function __construct() {
            parent::__construct(__('Search Products', 'ali2woo'), __('Search Products', 'ali2woo'), 'import', 'a2w_dashboard', 10);

            $this->loader = new A2W_Aliexpress();
            $this->localizator = A2W_AliexpressLocalizator::getInstance();
            $this->product_import_model = new A2W_ProductImport();

            add_action('wp_ajax_a2w_add_to_import', array($this, 'ajax_add_to_import'));
            add_action('wp_ajax_a2w_remove_from_import', array($this, 'ajax_remove_from_import'));
            add_action('wp_ajax_a2w_load_shipping_info', array($this, 'ajax_load_shipping_info'));
        }

        public function render($params = array()) {
            $filter = array();
            if (is_array($_GET) && $_GET) {
                $filter = array_merge($filter, $_GET);
                if (isset($filter['cur_page'])) {
                    unset($filter['cur_page']);
                }
                if (isset($filter['page'])) {
                    unset($filter['page']);
                }
            }

            $adv_search_field = array('min_price', 'max_price', 'min_feedback', 'max_feedback', 'volume_from', 'volume_to');
            $adv_search = false;
            foreach ($filter as $key => $val) {
                $new_key = preg_replace('/a2w_/', '', $key, 1);
                unset($filter[$key]);
                $filter[$new_key] = wp_unslash($val);
                if (in_array($new_key, $adv_search_field)) {
                    $adv_search = true;
                }
            }

            if (!isset($filter['sort'])) {
                $filter['sort'] = "volumeDown";
            }

            $page = isset($_GET['cur_page']) && intval($_GET['cur_page']) ? intval($_GET['cur_page']) : 1;
            $per_page = 20;
            
            if(!empty($_REQUEST['a2w_search'])){
                $load_products_result = $this->loader->load_products($filter, $page, $per_page);    
            }else {
                $load_products_result = A2W_ResultBuilder::buildError(__('Please enter some search keywords or select item from category list!', 'ali2woo'));
            }
            
            if ($load_products_result['state'] == 'error' || $load_products_result['state'] == 'warn') {
                add_settings_error('a2w_products_list', esc_attr('settings_updated'), $load_products_result['message'], 'error');
            }
            
            if($load_products_result['state'] != 'error'){
                $pages_list = array();
                $links = 4;
                $last = ceil($load_products_result['total'] / $per_page);
                $load_products_result['total_pages'] = $last;
                $start = ( ( $load_products_result['page'] - $links ) > 0 ) ? $load_products_result['page'] - $links : 1;
                $end = ( ( $load_products_result['page'] + $links ) < $last ) ? $load_products_result['page'] + $links : $last;
                if ($start > 1) {
                    $pages_list[] = 1;
                    $pages_list[] = '';
                }
                for ($i = $start; $i <= $end; $i++) {
                    $pages_list[] = $i;
                }
                if ($end < $last) {
                    $pages_list[] = '';
                    $pages_list[] = $last;
                }
                $load_products_result['pages_list'] = $pages_list;
                
                a2w_set_transient('a2w_search_result', $load_products_result['products']);
            }

            $countryModel = new A2W_Country();

            $this->model_put('filter', $filter);
            $this->model_put('adv_search', $adv_search);
            $this->model_put('categories', $this->get_categories());
            $this->model_put('countries', $countryModel->get_countries());

            $this->model_put('load_products_result', $load_products_result);
            $this->include_view('search.php');
        }

        public function ajax_add_to_import() {
            if (isset($_POST['id'])) {
                $product = array();
                $products = a2w_get_transient('a2w_search_result');

                if($products && is_array($products)){
                    foreach ($products as $p) {
                        if ($p['id'] == $_POST['id']) {
                            $product = $p;
                            break;
                        }
                    }
                }
                
                global $wpdb;
                $post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $_POST['id']));
                if (a2w_check_defined('A2W_DEBUG_PAGE') || !$post_id) {
                    $res = $this->loader->load_product($_POST['id']); 
                    if ($res['state'] !== 'error') {
                        $product = array_replace_recursive($product, $res['product']);

                        if ($product) {
                            $product = A2W_PriceFormula::apply_formula($product);

                            $this->product_import_model->add_product($product);

                            echo json_encode(A2W_ResultBuilder::buildOk());
                        } else {
                            echo json_encode(A2W_ResultBuilder::buildError("Product not found in serach result"));
                        }
                    }else{
                        echo json_encode($res);
                    }
                }else {
                    echo json_encode(A2W_ResultBuilder::buildError("Product already imported."));
                }
                
            } else {
                echo json_encode(A2W_ResultBuilder::buildError("add_to_import: waiting for ID..."));
            }
            wp_die();
        }
        
        public function ajax_remove_from_import() {
            if (isset($_POST['id'])) {
                $product = false;
                $products = a2w_get_transient('a2w_search_result');

                foreach ($products as $p) {
                    if ($p['id'] == $_POST['id']) {
                        $product = $p;
                        break;
                    }
                }
                if ($product) {
                    $this->product_import_model->del_product($product['id']);
                    echo json_encode(A2W_ResultBuilder::buildOk());
                } else {
                    echo json_encode(A2W_ResultBuilder::buildError("Product not found in serach result"));
                }
            } else {
                echo json_encode(A2W_ResultBuilder::buildError("remove_from_import: waiting for ID..."));
            }
            wp_die();
        }

        public function ajax_load_shipping_info() {
            if (isset($_POST['id'])) {
                $ids = is_array($_POST['id']) ? $_POST['id'] : array($_POST['id']);

                $product = false;
                $products = a2w_get_transient('a2w_search_result');
                $result = array();
                foreach ($ids as $id) {
                    foreach ($products as &$product) {
                        if ($product['id'] == $id) {
                            $product_country = isset($product['shipping_to_country']) && $product['shipping_to_country'] ? $product['shipping_to_country'] : '';
                            $country = isset($_POST['country']) ? $_POST['country'] : $product_country;
                            if ($country && (!isset($product['shipping_info']) || $country != $product_country)) {
                                $product['shipping_to_country'] = $country;
                                $res = $this->loader->load_shipping_info($product['id'], 1, $country);
                                if ($res['state'] !== 'error') {
                                    $product['shipping_info'] = $res['items'];
                                } else {
                                    $product['shipping_info'] = array();
                                }
                            }
                            $result[] = array('product_id' => $id, 'items' => isset($product['shipping_info']) ? $product['shipping_info'] : array());
                            break;
                        }
                    }
                }
                a2w_set_transient('a2w_search_result', $products);

                echo json_encode(A2W_ResultBuilder::buildOk(array('products' => $result)));
            } else {
                echo json_encode(A2W_ResultBuilder::buildError("load_shipping_info: waiting for ID..."));
            }
            wp_die();
        }

        protected function get_categories() {
            if (file_exists(A2W()->plugin_path . 'assets/data/user_aliexpress_categories.json')) {
                $result = json_decode(file_get_contents(A2W()->plugin_path . 'assets/data/user_aliexpress_categories.json'), true);
            } else {
                $result = json_decode(file_get_contents(A2W()->plugin_path . 'assets/data/aliexpress_categories.json'), true);
            }
            $result = $result["categories"];
            array_unshift($result, array("id" => "0", "name" => "All categories", "level" => 1));
            return $result;
        }
    }

}

