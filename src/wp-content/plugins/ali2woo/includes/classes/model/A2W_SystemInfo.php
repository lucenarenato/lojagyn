<?php

/**
 * Description of A2W_SystemInfo
 *
 * @author Andrey
 */
if (!class_exists('A2W_SystemInfo')) {
    class A2W_SystemInfo {
        
        public static function server_ping(){
            $result = array();
            $ping_url = a2w_get_setting('api_endpoint').'ping.php?' . A2W_Account::getInstance()->build_params() . A2W_AliexpressLocalizator::getInstance()->build_params()."&r=".mt_rand();
            $request = a2w_remote_get($ping_url);
            if (is_wp_error($request)) {
                if(file_get_contents($ping_url)){
                    $result = A2W_ResultBuilder::buildError('a2w_remote_get error');
                }else{
                    $result = A2W_ResultBuilder::buildError($request->get_error_message());    
                }
            } else if (intval($request['response']['code']) != 200) {
                $result = A2W_ResultBuilder::buildError($request['response']['code'] . " " . $request['response']['message']);
            } else {
                $result = json_decode($request['body'], true);
            }
            
            return $result;
        }
        
        public static function php_check(){
            return A2W_ResultBuilder::buildOk();
        }
    }

}

