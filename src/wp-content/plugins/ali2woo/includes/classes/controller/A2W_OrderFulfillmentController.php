<?php

/**
 * Description of A2W_OrderFulfillmentController
 *
 * @author MA_GROUP
 * 
 * @autoload: true
 */
if (!class_exists('A2W_OrderFulfillmentController')) {

    class A2W_OrderFulfillmentController {

        public function __construct() {
            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'assets'));
            }

            add_action('wp_ajax_a2w_get_aliexpress_order_data', array($this, 'get_aliexpress_order_data'));
        }

        function assets() {
            wp_enqueue_script('a2w-ali-orderfulfill-js', A2W()->plugin_url . 'assets/js/orderfulfill.js', array(),  A2W()->version, true);
        }

        function get_aliexpress_order_data() {
  
            $result = array("state" => "ok", "data" => "", "action" => "");

            $post_id = isset($_POST['id']) ? $_POST['id'] : false;

            if (!$post_id) {
                $result['state'] = 'error';
                $result['error_message'] = 'Bad product ID';
                echo json_encode($result);
                wp_die();
            }


            $order = new WC_Order($post_id);

            $def_prefship = a2w_get_setting('fulfillment_prefship');
            $def_customer_note = a2w_get_setting('fulfillment_custom_note');
            $def_phone_number = a2w_get_setting('fulfillment_phone_number');
            $def_phone_code = a2w_get_setting('fulfillment_phone_code');

            $content = array('id' => $post_id,
                'defaultShipping' => $def_prefship,
                'note' => $def_customer_note !== "" ? $def_customer_note : $this->get_customer_note($order),
                'products' => array(),
                'countryRegion' => $this->get_country_region($order),
                'region' => $this->get_region($order),
                'city' => $this->get_city($order),
                'contactName' => $this->get_contactName($order),
                'address1' => $this->get_address1($order),
                'address2' => $this->get_address2($order),
                'mobile' => $def_phone_number !== "" ? $def_phone_number : $this->get_phone($order),
                'mobile_code' => $def_phone_code !== "" ? $def_phone_code : '',
                'zip' => $this->get_zip($order)
            );

            $items = $order->get_items();

            $k = 0;
            $total = 0;
            foreach ($items as $item) {

                $normalized_item = new A2W_WooCommerceOrderItem($item);
                $product_id = $normalized_item->getProductID();
                $variation_id = $normalized_item->getVariationID();
                $quantity = $normalized_item->getQuantity();

                $external_id = get_post_meta($product_id, '_a2w_external_id', true);


                if ($external_id) {

                    $skuArray = $this->getSkuArray($normalized_item);

                    if (empty($skuArray) && $variation_id && $variation_id > 0) {
                        $result['error_message'] = 'This order has variable product but doesn`t contain variable data for some reason. Try to fulfill it manually.';
                        $result['state'] = 'error';
                        echo json_encode($result);
                        wp_die();
                    };

                    $original_url = get_post_meta($product_id, '_a2w_product_url', true);

                    if (empty($original_url)) {
                        $result['error_message'] = 'This order doesn`t contain `product_url` field for some reason.Try to fulfill it manually.';
                        $result['state'] = 'error';
                        echo json_encode($result);
                        wp_die();
                    }

                    $content['products'][$k] = array(
                        'url' => $original_url,
                        'productId' => $external_id,
                        'qty' => $quantity,
                        'sku' => $skuArray
                    );

                    $k++;
                }
                $total++;
            }

            if ($k < 1) {
                $result['error_message'] = 'No Aliexpress products in selected order!';
                $result['state'] = 'error';
                echo json_encode($result);
                wp_die();
            }

            if ($k == $total) {
                $result['action'] = 'upd_ord_status';
            }

            $result['data'] = array('content' => $content, 'id' => $post_id);

            echo json_encode($result);
            wp_die();
        }

        private function format_field($str) {
            $str = trim($str);

            if (!empty($str))
                $str = ucwords(strtolower($str));

            return $str;
        }

        private function get_phone($order) {
            if (WC()->version < '3.0.0')
                $result = $order->billing_phone ? $order->billing_phone : $order->shipping_phone;
            else
                $result = $order->get_billing_phone();

            return $result;
        }

        private function get_customer_note($order) {
            if (WC()->version < '3.0.0')
                $result = $order->customer_note;
            else
                $result = $order->get_customer_note();

            return $result;
        }

        private function get_country_region($order) {
            if (WC()->version < '3.0.0')
                $result = $order->shipping_country ? $this->format_field_country($order->shipping_country) : $this->format_field_country($order->billing_country);
            else
                $result = $order->get_shipping_country() ? $this->format_field_country($order->get_shipping_country()) : $this->format_field_country($order->get_billing_country());

            return $result;
        }

        private function get_region($order) {
            if (WC()->version < '3.0.0')
                $result = $order->shipping_state ? $this->format_field_state($order->shipping_country, $order->shipping_state) : $this->format_field_state($order->billing_country, $order->billing_state);
            else
                $result = $order->get_shipping_state() ? $this->format_field_state($order->get_shipping_country(), $order->get_shipping_state()) : $this->format_field_state($order->get_billing_country(), $order->get_billing_state());

            return $result;
        }

        private function get_city($order) {

            if (WC()->version < '3.0.0')
                $result = $order->shipping_city ? $this->format_field($order->shipping_city) : $this->format_field($order->billing_city);
            else
                $result = $order->get_shipping_city() ? $this->format_field($order->get_shipping_city()) : $this->format_field($order->get_billing_city());

            return $result;
        }

        private function get_contactName($order) {

            if (WC()->version < '3.0.0')
                $result = $order->shipping_first_name ? $order->shipping_first_name . ' ' . $order->shipping_last_name : $order->billing_first_name . ' ' . $order->billing_last_name;
            else
                $result = $order->get_shipping_first_name() ? $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() : $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();

            return $result;
        }

        private function get_address1($order) {


            if (WC()->version < '3.0.0')
                $result = $order->shipping_address_1 ? $order->shipping_address_1 : $order->billing_address_1;
            else
                $result = $order->get_shipping_address_1() ? $order->get_shipping_address_1() : $order->get_billing_address_1();

            return $result;
        }

        private function get_address2($order) {

            if (WC()->version < '3.0.0')
                $result = $order->shipping_address_2 ? $order->shipping_address_2 : $order->billing_address_2;
            else
                $result = $order->get_shipping_address_2() ? $order->get_shipping_address_2() : $order->get_billing_address_2();

            return $result;
        }

        private function get_zip($order) {


            if (WC()->version < '3.0.0')
                $result = $order->shipping_postcode ? $order->shipping_postcode : $order->billing_postcode;
            else
                $result = $order->get_shipping_postcode() ? $order->get_shipping_postcode() : $order->get_billing_postcode();

            return $result;
        }

        private function format_field_country($str) {
            $str = trim($str);

            if (!empty($str))
                $str = strtoupper($str);

                
            if ($str === "GB") $str = "UK";
            if ($str == "RS") $str = "SRB";
            if ($str == "ME") $str = "MNE";
            
            return $str;
        }

        private function format_field_state($country_code, $state_code) {
            if (isset(WC()->countries->states[$country_code]) && isset(WC()->countries->states[$country_code][$state_code]))
                $result = $this->format_field(WC()->countries->states[$country_code][$state_code]);
            else
                $result = $state_code;
            return $result;
        }

        private function getSkuArray($item) {
            $sku = array();

            if ($item->getVariationID() !== 0) {

                $variation_id = $item->getVariationID();
                $sku = $this->getSkuArrayByVariationID($variation_id);
               
            } else {
                $product_id = $item->getProductID();
                $handle=new WC_Product_Variable($product_id);
                if ($handle){
                    $variations_ids=$handle->get_children();
                    if ($variations_ids && count($variations_ids) > 0){
                        $first_variation_id = $variations_ids[0];
                        $sku = $this->getSkuArrayByVariationID($first_variation_id);
                    }
                }
            }
            return $sku;
        }
        
        private function getSkuArrayByVariationID($variation_id){
            
            $sku = array();
            
            $external_var_data = get_post_meta($variation_id, '_aliexpress_sku_props', true);

            if (empty($external_var_data))
                return $sku;

            if ($external_var_data) {
                $items = explode(';', $external_var_data);

                foreach ($items as $item) {
                    list(, $sku[]) = explode(':', $item);
                }
            } 
            
            return $sku;   
        }

    }

}
