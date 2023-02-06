<?php

/**
 * Description of A2W_ShippingLoader
 *
 * @author MA_GROUP
 * 
 */
if (!class_exists('A2W_ShippingLoader')):

	class A2W_ShippingLoader {
   
        private function normalize_country($country){
            if ($country == "GB") $country = "UK"; 
            if ($country == "RS") $country = "SRB";
            if ($country == "ME") $country = "MNE";
            return $country;  
        }
        
        public function load($shipping){
            $response_body = "";
            
            $to_country = $this->normalize_country( $shipping->getShippingCountry() ); 
            $from_country = $this->normalize_country( $shipping->getShippingFromCountry() ); 
            
            
            $result_data = array('data' =>array('ways'=>array(), 'to_country_code'=>''), 'html'=>'');
            
            $cur_a2w_local_currency = a2w_get_setting('local_currency');
      
            if ( $shipping->load()){
                $response_body = $shipping->getData();
            }
            else { 
                
                $external_id = $shipping->getExternalID(); 
                       
                $AliexpressLoader = new A2W_Aliexpress();
                
                $res = $AliexpressLoader->load_shipping_info($external_id, $shipping->getQuantity(), $to_country, $from_country);
                if ($res['state'] !== 'error') {
                   
                     $response_body = $res['items'];
                    
                    //Internal shipping table keeps shipping rate for items
                    $shipping->save_data($response_body);
                    
                } else {
                    $response_body = array();
                }
                              
            } 
            
            $ship_data = array();    
            $result_data['data']['to_country_code'] = $to_country;
            
            if ($response_body) {
                foreach ($response_body as $ship_way){
                 
                    $local_values = A2W_ShippingPostType::get_item($ship_way['company']);
                    
                    //skip disabled items
                    if ( $local_values === false) continue;
                    
                    //if no such item yet, let`s add it and then get it
                    if (!$local_values) {
                        A2W_ShippingPostType::add_item($ship_way['company'], $ship_way['serviceName']); 
                        $local_values = A2W_ShippingPostType::get_item($ship_way['company']);
                    }
                  
                    $ship_way = A2W_ShippingPriceFormula::apply_formula($ship_way, $local_values);
                                
                    // TODO:
                    if(function_exists('a2w_ali_forbidden_words')){
                        $ship_way->company = a2w_ali_forbidden_words($ship_way['company']);
                    } 
                            
                    $result_data['html'] .= "<strong>" .  $ship_way['company'] . "</strong>";
            
                    $ship_data['company'] = $local_values['title'];
                    
                    $ship_data['serviceName'] = $ship_way['serviceName'];
                    
                    $ship_price = $ship_way['freightAmount']['value'];

                        
                    $result_data['html'] .= " " . $ship_price . " " . get_woocommerce_currency_symbol();
                    
                    $ship_data['price'] = $ship_price;
                    $ship_data['currency'] = get_woocommerce_currency_symbol();
                
                    if ($ship_price == 0)
                        $result_data['html'] .= " " . __("free", 'ali2woo');
                                       
                                                                                                                                              
                    $result_data['html'] .= " ({$ship_way['time']} " . __("days", 'ali2woo') . ")<br/>"; 
                    $ship_data['time'] = $ship_way['time'];
                                        
                    $result_data['data']['ways'][] = $ship_data;
                                   
                }
            }
            
            return $result_data; 
        }
        
			
	}

	endif;
