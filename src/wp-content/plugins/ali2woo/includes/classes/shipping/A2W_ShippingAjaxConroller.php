<?php

/**
 * Description of A2W_ShippingAjaxConroller
 *
 * @author MA_GROUP
 * @autoload: true
 */
if (!class_exists('A2W_ShippingAjaxConroller')):

    class A2W_ShippingAjaxConroller extends A2W_AbstractController {

        private $woocommerce_model;
        private $shipping_loader;

        function __construct() {
            $this->woocommerce_model = new A2W_Woocommerce();
            $this->shipping_loader = new A2W_ShippingLoader();

            add_action('wp_ajax_a2w_update_shipping_method_in_cart_item', array($this, 'update_shipping_method_in_cart_item'));

            add_action('wp_ajax_nopriv_a2w_update_shipping_method_in_cart_item', array($this, 'update_shipping_method_in_cart_item'));

            //backend only: 
            add_action('wp_ajax_a2w_aliship_get_products_by_filter', array($this, 'get_products_by_filter'));

            add_filter('a2w_ajax_product_info', array($this, 'product_info'), 4, 9000);
        }


        public function update_shipping_method_in_cart_item() {

            $cart_item_key = $_POST['id'];
            $tariff_code = $_POST['value'];

            global $woocommerce;
            $cart = $woocommerce->cart->cart_contents;

            foreach ($cart as $key => $item) {
                if ($key == $cart_item_key) {
                    $woocommerce->cart->cart_contents[$key]['a2w_shipping_method'] = $tariff_code;
                    $woocommerce->cart->maybe_set_cart_cookies();
              
                     A2W_ShippingFrontendPageController::update_shipping_and_totals_in_cart();
                     
                     $result = A2W_ResultBuilder::buildOk();
                     echo json_encode($result);
                     wp_die();
                }
            }
        }

        public function product_info($content, $post_id, $external_id) {
            return $content;
        }

        public function get_products_by_filter() {
            $result = array("state" => "ok");

            $filter = array();
            parse_str($_POST['filter'], $filter);

            $current_page = (isset($_POST['page']) && intval($_POST['page'])) ? intval($_POST['page']) : 1;
            $page_on_query = 2;

            $loader = (isset($filter['type']) && $filter['type']) ? a2w_get_loader($filter['type']) : false;

            if ($loader) {
                $upload_dir = wp_upload_dir();
                $file_url = $upload_dir['basedir'] . "/a2w_aliship_import.csv";

                if ($current_page == 1 && file_exists($file_url)) {
                    unlink($file_url);
                }

                $result['type'] = $loader->api->get_type();

                $filter = $loader->prepare_filter($filter);
                $result['filter'] = $filter;

                for ($i = 0; $i < $page_on_query; $i++) {
                    $link_category_id = (isset($filter['link_category_id']) && IntVal($filter['link_category_id'])) ? IntVal($filter['link_category_id']) : 0;

                    $data = $loader->load_list_proc($filter, $current_page);
                    if (!$data["error"]) {
                        $total_items = IntVal($data['total']);
                        $per_page = IntVal($data['per_page']);
                        $pages = IntVal($total_items / $per_page) + IntVal($total_items % $per_page > 0 ? 1 : 0);

                        $result['pages'] = $pages;
                        $result['pages_loaded'] = $current_page;

                        $items = "";
                        foreach ($data["items"] as $item) {
                            $items.=$item->external_id . ";" . $link_category_id . PHP_EOL;
                        }
                        file_put_contents($file_url, $items, FILE_APPEND | LOCK_EX);

                        $current_page++;
                    }
                }
            }
            echo json_encode($result);
            wp_die();
        }

    }

    

	
endif;