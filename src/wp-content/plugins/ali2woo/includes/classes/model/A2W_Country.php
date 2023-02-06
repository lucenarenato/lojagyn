<?php

/**
 * Description of A2W_Country
 *
 * @author Andrey
 */
if (!class_exists('A2W_Country')) {

    class A2W_Country {

        public function get_countries() {
            $result = json_decode(file_get_contents(A2W()->plugin_path . 'assets/data/countries.json'), true);
            $result = $result["countries"];
            array_unshift($result, array('c' => '', 'n' => 'N/A'));
            return $result;
        }

    }

}