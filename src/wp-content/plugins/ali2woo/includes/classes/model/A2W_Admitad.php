<?php

/**
 * Description of A2W_Admitad
 *
 * @author Andrey
 */
if (!class_exists('A2W_Admitad')) {

    class A2W_Admitad {
        private static $_instance = null;

        static public function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getDeeplink($hrefs) {
            $result = array();
            if ($hrefs) {
                $admitad_account = A2W_Account::getInstance()->get_admitad_account();
                if (!empty($admitad_account['cashback_url'])) {
                    $hrefs = is_array($hrefs) ? array_values($hrefs) : array(strval($hrefs));
                    foreach($hrefs as $href){
                        $result[] = array('url'=>$href, 'promotionUrl'=>$admitad_account['cashback_url'].'?ulp='.urlencode($href));
                    }
                }
            }
            return $result;
        }

    }

}
