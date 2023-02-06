<?php
/* * class
 * Description of A2W_OrderDataTabController
 *
 * @author MA_GROUP
 * 
 * @autoload: a2w_init
 */
 if (!class_exists('A2W_OrderDataTabController') ) {

    class A2W_OrderDataTabController {

        private $bulk_actions = array();
        private $bulk_actions_text = array();
        private $woocommerce_model;

        public function __construct() {
            
            if ( !A2W_Utils::wcae_strack_active() ) {

                add_action('admin_enqueue_scripts', array($this, 'assets'));
                add_action( 'woocommerce_admin_order_data_after_order_details', array($this, 'add_tab'));
                add_action( 'woocommerce_process_shop_order_meta', array($this, 'save_tab_data'));    
                add_action('wp_ajax_a2w_delete_tracking_codes', array($this, 'ajax_delete_tracking_codes'));
                add_action('wp_ajax_a2w_add_tracking_codes_manually', array($this, 'ajax_add_tracking_codes_manually'));
                

                $this->woocommerce_model = new A2W_Woocommerce();
            
            }
        }
        
        public function assets() {
            if ( isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] === 'edit') {
                    wp_enqueue_script('a2w-wc-order-edit-script', A2W()->plugin_url . 'assets/js/wc_order_edit.js', array(), A2W()->version);                             
            }
        
         
        }
        
        public function ajax_delete_tracking_codes(){
            $result = A2W_ResultBuilder::buildOk();  
         
            try {   
                $order_id = (int)$_POST['id'];
                
                if (get_post($order_id)) {          
                       delete_post_meta($order_id, '_a2w_tracking_code');
                       
                       $order = wc_get_order( $order_id );
                       $order->add_order_note( __( 'The order`s tracking codes have been deleted.', 'ali2woo' ), false, true );
                }
                else 
                $result = A2W_ResultBuilder::buildError('did not find the order id: №' . $order_id);
                      
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            
            echo json_encode($result);
            wp_die();         
        }
        
        public function ajax_add_tracking_codes_manually(){
            $result = A2W_ResultBuilder::buildOk();  
         
            try {   
                $order_id = (int)$_POST['id'];
                $tracking_codes = $_POST['tracking_codes'];
                
                if (get_post($order_id))  
                    if ($tracking_codes){
                        $tracking_codes = explode(',', $tracking_codes);
                        $this->add_tracking_codes($order_id, $tracking_codes);
                        
                        $order = wc_get_order( $order_id );
                        $order->add_order_note( __( 'The tracking codes have been added to the order.', 'ali2woo' ), false, true );
                    
                    }         
                        
                else 
                $result = A2W_ResultBuilder::buildError('did not find the order id: №' . $order_id);
                      
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            
            echo json_encode($result);
            wp_die();             
        }
        
       
        
        public function add_tab( $order ){ ?>
            <br class="clear" />
            <h4><?php _e('A2W Data', 'ali2woo') ?><a href="#" class="edit_address"><?php _e('Edit') ?></a></h4>
            <?php
                $order_external_id = get_post_meta( $order->get_id(), '_a2w_external_order_id', true );
                $order_tracking_codes = get_post_meta( $order->get_id(), '_a2w_tracking_code');
            ?>
            <div class="address">
            <p><strong><?php _e('AliExpress order id', 'ali2woo') ?>:</strong> <?php echo $order_external_id ?></p>
            <?php if ($order_tracking_codes) : ?>
          
            <strong><?php _e('AliExpress tracking codes', 'ali2woo') ?>:</strong>
            <div class="a2w_tracking_code_data">
            <?php foreach ($order_tracking_codes as $k => $tracking_code) : ?>
            <?php echo $tracking_code ?><?php if ($k < count($order_tracking_codes)-1) : ?>,<?php endif;?>
            <?php endforeach; ?>
            </div>
            <a role="button" class="a2w_delete_codes" href="#"><?php _e('Delete tracking codes', 'ali2woo') ?></a><br/>
          
        
            <?php endif; ?>
              <a role="button" class="a2w_codes_manually" href="#"><?php _e('Add tracking codes manually', 'ali2woo') ?></a>
            </div>
            <div class="edit_address"><?php
            
                woocommerce_wp_text_input( array(
                    'id' => 'a2w_external_order_id',
                    'label' => __('AliExpress Order ID', 'ali2woo'),
                    'value' => $order_external_id,
                    'wrapper_class' => 'form-field-wide'
                ) );
            
                
                foreach ($order_tracking_codes as $k => $tracking_code) : 
                
                woocommerce_wp_text_input( array(
                    'id' => 'a2w_tracking_code',
                    'name' => 'a2w_tracking_code[]',
                    'label' => __('Tracking code', 'ali2woo') . ' ' . ($k+1) ,
                    'value' => $tracking_code,
                    'wrapper_class' => 'form-field-wide a2w_tracking_code_data'
                ) );
                
                endforeach; ?>
            </div>
            <?php
        }
        
        public function save_tab_data($ord_id){
            if (isset($_POST[ 'a2w_external_order_id' ]))
                update_post_meta( $ord_id, '_a2w_external_order_id', wc_clean( $_POST[ 'a2w_external_order_id' ] ) ); 
            
            if (isset($_POST[ 'a2w_tracking_code' ])){
                delete_post_meta($ord_id, '_a2w_tracking_code');
                $this->add_tracking_codes($ord_id, $_POST[ 'a2w_tracking_code' ]);
            } else {
                delete_post_meta($ord_id, '_a2w_tracking_code');
            }
        }
        
        private function add_tracking_codes($order_id, $tracking_codes){
            if (is_array($tracking_codes) && count($tracking_codes) > 0) {
                foreach ($tracking_codes as $code_value) {
                    $code_value = trim($code_value);
                    if (!empty ( $code_value )) add_post_meta($order_id, '_a2w_tracking_code', $code_value);
                }
            }    
        }


    }

}
