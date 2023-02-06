<?php
/**
 * Description of A2W_ServiceController
 *
 * @author Andrey
 * 
 * @autoload: a2w_init
 */

if (!class_exists('A2W_ServiceController')) {

    class A2W_ServiceController {

        private $system_message_update_period = 7200; //60*60*2;

        public function __construct() {

            $system_message_last_update = intval(a2w_get_setting('system_message_last_update'));
            if (!$system_message_last_update || $system_message_last_update < time()) {
                a2w_set_setting('system_message_last_update', time() + $this->system_message_update_period);

                $request = a2w_remote_get(a2w_get_setting('api_endpoint').'system_message.php');
                if (!is_wp_error($request) && intval($request['response']['code']) == 200) {
                    $system_message = json_decode($request['body'], true);
                    a2w_set_setting('system_message', $system_message);
                }
            }
        }

    }

}