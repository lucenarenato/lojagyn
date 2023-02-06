<?php
/* * class
 * Description of A2W_WooCommerceOrderListController
 *
 * @author MA_GROUP
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_WooCommerceOrderListController')) :

    class A2W_WooCommerceOrderListController {

        private $woocommerce_model;

        public function __construct() {
            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'assets'));

                add_action('a2w_install', array($this, 'install'));

                add_filter('woocommerce_admin_order_actions', array($this, 'admin_order_actions'), 2, 100);

                add_action('wp_ajax_a2w_order_info', array($this, 'ajax_order_info'));

                add_action('wp_ajax_a2w_get_fulfilled_orders', array($this, 'ajax_get_fulfilled_orders'));

                add_action('manage_posts_extra_tablenav', array($this, 'add_bulk_order_sunc_button'));

                add_action('wp_ajax_a2w_save_tracking_code', array($this, 'ajax_save_tracking_code'));
                
                 if ( !A2W_Utils::wcae_strack_active() ) {
                    add_action('manage_shop_order_posts_custom_column',  array($this, 'manage_columns_data'));
                    
                    add_filter('manage_edit-shop_order_columns', array($this, 'manage_columns_headers'));
                }

                $this->woocommerce_model = new A2W_Woocommerce();
            }
        }

        public function install() {
            $user = wp_get_current_user();
            $page = "edit-shop_order";
            $hidden = array("billing_address");
            update_user_option($user->ID, "manage{$page}columnshidden", $hidden, true);
        }

        function add_bulk_order_sunc_button() {
            if (isset($_GET['post_type']) && $_GET['post_type'] == "shop_order") :
                $fulfilled_order_count = $this->woocommerce_model->get_fulfilled_orders_count();
                if ($fulfilled_order_count > 0) :
                    ?>
                    <div class="alignleft actions">
                        <?php submit_button(__("Tracking Sync All", 'ali2woo'), 'primary', 'a2w_bulk_order_sync_manual', false); ?>
                    </div>
                    <?php
                endif;
            endif;
        }

        function ajax_get_fulfilled_orders() {
            $result = A2W_ResultBuilder::buildOk();

            try {
                $result = A2W_ResultBuilder::buildOk(array('data' => $this->woocommerce_model->get_fulfilled_orders_data()));
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);
            wp_die();
        }

        function ajax_save_tracking_code() {
            try {
                $order_id = intval($_POST['id']);
                $tracking_codes = is_array($_POST['tracking_codes']) ? $_POST['tracking_codes'] : array(strval($_POST['tracking_codes']));
                
                $result = $this->woocommerce_model->save_tracking_code($order_id, $tracking_codes);
                
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);
            wp_die();
        }

        function ajax_order_info() {

            $result = array("state" => "ok", "data" => "");

            $post_id = isset($_POST['id']) ? $_POST['id'] : false;

            if (!$post_id) {
                $result['state'] = 'error';
                echo json_encode($result);
                wp_die();
            }

            $content = array();

            $order = new WC_Order($post_id);

            $items = $order->get_items();

            $external_order_id = get_post_meta($order->get_id(), '_a2w_external_order_id', true);
            $order_tracking_codes = get_post_meta($order->get_id(), '_a2w_tracking_code');

            $k = 1;

            foreach ($items as $item) {

                $normalized_item = new A2W_WooCommerceOrderItem($item);

                $product_name = $normalized_item->getName();
                $product_id = $normalized_item->getProductID();

                $tmp = '';

                if ($product_id > 0) {
                    $product_url = get_post_meta($product_id, '_a2w_product_url', true);
                    $seller_url = get_post_meta($product_id, '_a2w_seller_url', true);



                    if ($product_url)
                        $tmp = $k . '). <a title="' . $product_name . '" href="' . $product_url . '" target="_blank" class="link_to_source product_url">' . _x('Product page', 'hint', 'ali2woo') . '</a>';

                    if ($seller_url)
                        $tmp .= "<span class='seller_url_block'> | <a href='" . $seller_url . "' target='_blank' class='seller_url'>" . _x('Seller', 'hint', 'ali2woo') . "</a></span>";
                } else {
                    $tmp .= $k . '). <span style="color:red;">' . _x('The product has been deleted', 'hint', 'ali2woo') . '</span>';
                }

                $content[] = $tmp;
                $k++;
            }

            if (!empty($external_order_id) && trim($external_order_id)) {
                $content[] = "AliExpress order id: <span class='seller_url_block'>" . (is_array($external_order_id) ? implode(", ", $external_order_id) : strval($external_order_id)) . "</span>";
            }

            if (!empty($order_tracking_codes)) {
                $content[] = "Tracking codes: <span class='seller_url_block'>" . (is_array($order_tracking_codes) ? implode(", ", $order_tracking_codes) : strval($order_tracking_codes)) . "</span>";
            }


            $content = apply_filters('a2w_get_order_content', $content, $post_id);
            $result['data'] = array('content' => $content, 'id' => $post_id);

            echo json_encode($result);
            wp_die();
        }

        function assets() {


            wp_enqueue_style('a2w-wc-ol-style', A2W()->plugin_url . 'assets/css/wc_ol_style.css', array(), A2W()->version);
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('a2w-wc-ol-script', A2W()->plugin_url . 'assets/js/wc_ol_script.js', array(), A2W()->version);

            $lang_data = array(
                'aliexpress_info' => _x('AliExpress Info', 'Dialog title', 'ali2woo'),
                'please_wait_data_loads' => _x('Please wait, data loads...', 'Status', 'ali2woo'),
                'please_wait' => _x('Please wait...', 'Status', 'ali2woo'),
                'sync_process' => _x('Sync process', 'Status', 'ali2woo'),
                'sync_done' => _x('Sync done!', 'Button text', 'ali2woo'),
                'error' => _x('Error!', 'Button text', 'ali2woo'),
                'error_please_install_new_extension' => _x('Error! Please install the latest Chrome extension.', 'Error text', 'ali2woo'),
                'error_cant_do_tracking_sync' => _x('Can`t do Tracking Sync. Unknown error in the Chrome extension. Please contact with the support.', 'Error text', 'ali2woo'),
                'try_again' => _x('Try again?', 'Button text', 'ali2woo'),
                'error_didnt_do_find_alix_order_num' => _x('Didn`t find the AliExpress order №', 'Error text', 'ali2woo'),
                'error_cant_do_tracking_sync_login_to_account' => _x('Can`t do Tracking Sync. Please log-in to your AliExpress account first.', 'Error text', 'ali2woo'),
                'no_tracking_codes_for_order' => _x('No tracking codes for given order on AliExpress.', 'Status', 'ali2woo'),
                'tracking_sync' => _x('Tracking Sync All', 'Button text', 'ali2woo'),
                'error_403_code' => _x('The error with 403 code occured for the AliExpress order №', 'Error text', 'ali2woo'),
                'tracking_sync_done' => _x('The Tracking Sunc has been done!', 'Status', 'ali2woo'),
            );

            wp_localize_script('a2w-wc-ol-script', 'a2w_script_data', array('lang' => $lang_data));
        }

        public function manage_columns_data($name) {
            global $post;

            switch ($name) {
                case 'tracking_code':
                     $order_tracking_codes = get_post_meta( $post->ID, '_a2w_tracking_code');
                     if ($order_tracking_codes) {
                         foreach ($order_tracking_codes as $k => $tracking_code) {
                            echo $tracking_code;
                            if ($k < count($order_tracking_codes)-1) echo ", ";  
                         }
                     }
                     else _e('Not available yet', 'ali2woo');
                    break;
            }
        }
        
        public function manage_columns_headers($columns) {
            $new_columns = array();

            foreach ( $columns as $column_name => $column_info ) {

                $new_columns[ $column_name ] = $column_info;

                if ( 'order_total' === $column_name ) {
                    $new_columns['tracking_code'] = __( 'Tracking number', 'ali2woo' );
                }
            }

            return $new_columns;
        }

        function admin_order_actions($actions, $object) {

            $actions['a2w_order_fulfillment'] = array(
                'url' => '#' . $object->get_id(),
                'name' => __('Order fulfillment', 'ali2woo'),
                'action' => 'a2w_aliexpress_order_fulfillment',
            );

            $actions['a2w-order-info'] = array(
                'url' => '#' . $object->get_id(),
                'name' => __('AliExpress Info', 'ali2woo'),
                'action' => 'a2w-order-info',
            );


            $order_external_id = get_post_meta($object->get_id(), '_a2w_external_order_id', true);
            $order_tracking_codes = get_post_meta($object->get_id(), '_a2w_tracking_code');

            if ($order_external_id && (is_null($order_tracking_codes) || empty($order_tracking_codes)))
                $actions['a2w-aliexpress-sync'] = array(
                    'url' => '#' . $order_external_id,
                    'name' => __('Tracking Sync', 'ali2woo'),
                    'action' => 'a2w-aliexpress-sync',
                );

            return $actions;
        }

    }

    
	
 endif;
