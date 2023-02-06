<?php

/**
 * Description of A2W_ShippingMethod
 * woocommerce_shipping_init
 * @author MA Group
 * 
 * @include_action: plugins_loaded
 */
    
    if ( A2W_Woocommerce::is_woocommerce_installed() ) :
        if ( ! class_exists( 'A2W_ShippingMethod' ) ) :
        
            class A2W_ShippingMethod extends WC_Shipping_Method {
                
                 private $woocommerce_model;
                 private $shipping_loader;
                
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {
               
                    $this->id                 = 'a2w'; 
                    $this->method_title       = __( 'Ali2Woo Shipping', 'ali2woo' );  
            
                    $this->method_description = __( 'Custom Shipping Method for Ali2Woo', 'ali2woo' ); 
 
                    // Availability & Countries
                    $this->availability = 'excluding';
                    $this->countries = array();
                     
                    $this->init();
                    
                    //todo: here we can check our option
                    $this->enabled = 'yes';
                    
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Ali2Woo Shipping', 'ali2woo' );
               
                    $this->use_title = isset( $this->settings['use_title'] ) ? $this->settings['use_title'] : "yes";
                    
                    $this->woocommerce_model = new A2W_Woocommerce();
                    $this->shipping_loader = new A2W_ShippingLoader();
                
                }                       

                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package = array() ) {
                    $cost = array();
                    $country = $package["destination"]["country"];
                    $default_tariff_code = a2w_get_setting('fulfillment_prefship', 'EMS_ZX_ZX_US'); //ePacket
               
                    foreach ( $package['contents'] as $item_id => $values ) 
                    { 
                       $_product = $values['data'];
                       $ext_id = $this->woocommerce_model->get_product_external_id($_product->get_id());
                       
                       
                       if ($ext_id){
                     
                            $response = $this->shipping_loader->load( new A2W_ShippingMeta($_product->get_id(), $ext_id, $country, $values['quantity']) );
                           
                            $tariff_list = $response['data']['ways'];
                            
                            if ( !empty($tariff_list) && is_array($tariff_list) ){
                                
                                $search_tariff_code = isset($values['a2w_shipping_method'] ) ? $values['a2w_shipping_method'] : $default_tariff_code;
                                $was_found = false;
                                foreach ($tariff_list as $tariff){
                                    if ($tariff['serviceName'] == $search_tariff_code){
                                        $was_found = true;
                                        $cost[] = $tariff['price'];
                                    }
                                        
                                }
                            
                                if (!$was_found) {
                                    $cost[] = $tariff_list[0]['price'];                                   
                                } 
                            }
                                
                            else {
                                //throw error
                                return false;
                               
                            }
                       }
                        
                    
                    }
                    
                    if (!empty($cost)) {
                        $rate = array(
                            'id' => $this->id,
                           'label' => $this->title,
                            'cost' => $cost
                        );
                    
                        $this->add_rate( $rate );
                    }
               
                 
                    
                }
                
                  /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                public function init() {
                    // Load the settings API
                    $this->init_form_fields(); 
                    $this->init_settings(); 

                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                /**
                 * Define settings field for this shipping
                 * @return void 
                 */
              
                public function init_form_fields() { 
 
                    $this->form_fields = array(
                            
                     'title' => array(
                        'title' => __( 'Shipping Label', 'ali2woo' ),
                          'type' => 'text',
                          'description' => __( 'Shipping Label to be display on site', 'ali2woo' ),
                          'default' => __( 'Ali2Woo Shipping', 'ali2woo' )
                          ),
                          
                     'use_title' => array(
                        'title' => __( "Disable Label in Cart", 'ali2woo'),
                        'type' => 'checkbox',
                        'description' => __( 'Remove shipping method label in Shopping Cart ', 'ali2woo'),
                        'default' => 'yes'
                     )
             
                     );
             
                }
            }
            
        endif;
        
        if ( a2w_get_setting('aliship_frontend') ) :
            add_filter( 'woocommerce_shipping_methods', 'add_a2w_shipping_method' );
         
            function add_a2w_shipping_method( $methods ) {
               
                $methods[] = 'A2W_ShippingMethod';
                return $methods;
            }
        endif;
         
    endif;