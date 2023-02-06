<?php
/**
 * Description of A2W_ShippingMeta
 *
 * @author MA_GROUP
 * 
 */
  
if (!class_exists('A2W_ShippingMeta')):

	class A2W_ShippingMeta {
        
        private $external_id = "";
        private $to_country = "";
        private $quantity = 1;
        private $data = "";
  
        private $product_id;
        
        private $loaded = false;
        
        public function __construct($product_id, $external_id, $to_country, $quantity=1) {
                  
            $this->external_id = $external_id;
            $this->to_country = $to_country;
            $this->from_country = get_post_meta($product_id, '_a2w_country_code', true );
            $this->quantity = $quantity;
            $this->product_id = $product_id;
        }
        
        public function getExternalID(){
            return $this->external_id;    
        }
        
        public function getData(){
            return $this->data;    
        }
        
        public function getQuantity(){
            return $this->quantity;
        }
        
        public function getShippingCountry(){
            return $this->to_country;
        }
        
        public function getShippingFromCountry(){
            return $this->from_country;
        }
        
        public function load($quantity=false) {
       
            $this->loaded = false;
       
            $meta_data = get_post_meta($this->product_id, '_a2w_shipping_data', true );
            
            $quantity = $quantity  ? $quantity : $this->quantity;
            
            $meta_key = $this->from_country.$this->to_country;
            
            if ($meta_data && isset($meta_data[$meta_key]) && isset($meta_data[$meta_key][$quantity]) ){
                $this->data = $meta_data[$meta_key][$quantity]; 
                $this->loaded = true;   
            }
        
            return $this->loaded;
        }
        
        
        public function save_data($data) {

            $meta_data = get_post_meta($this->product_id, '_a2w_shipping_data', true );
            
            if (!$meta_data) $meta_data = array(); 
            
            $meta_key = $this->from_country.$this->to_country;
            
            if (!isset($meta_data[$meta_key])) $meta_data[$meta_key] = array();
            
            $meta_data[$meta_key]{$this->quantity} = $data;
                
            $this->data = $data;
            
            update_post_meta($this->product_id, '_a2w_shipping_data', $meta_data);
            
        }
     	
        public static function clear_in_all_product(){
        
            $products = get_posts(array(
                'post_type' => 'product',
                'post_status' => 'any',
                'meta_query' => array(
                    array(
                        'key' => '_a2w_import_type',
                        'value' => 'a2w'
            ))));

            foreach( $products as $postinfo) {
                delete_post_meta( $postinfo->ID, '_a2w_shipping_data');
            }    
        }
	}

	endif;
