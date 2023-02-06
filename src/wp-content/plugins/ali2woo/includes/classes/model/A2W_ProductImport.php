<?php

/**
 * Description of A2W_ProductImport
 *
 * @author andrey
 */
if (!class_exists('A2W_ProductImport')) {

    class A2W_ProductImport {

        private $order;
        private $order_dir;

        public function add_product($product) {
            $result = "";
            $product_id_list = $this->get_product_id_list();
            if (in_array($product['id'], $product_id_list)) {
                $result = "exist";
                $product = array_merge($this->get_product($product['id']), $product);
            }

            if (!isset($product['is_affiliate'])) {
                $aliexpress_loader = new A2W_Aliexpress();
                $check_result = $aliexpress_loader->check_affiliate($product['id']);
                $product['is_affiliate'] = $check_result['affiliate'];
            }
            
            if (!isset($product['date_add'])) {
                $product['date_add'] = date('Y-m-d H:i:s');
            }

            $this->save_product($product['id'], $product);
            return $result;
        }

        public function upd_product($product) {

            $product_id_list = $this->get_product_id_list();

            if (in_array($product['id'], $product_id_list)) {
                $product = array_merge($this->get_product($product['id']), $product);

                $this->save_product($product['id'], $product);
            }

            return $product;
        }

        public function del_product($product_id) {
            if (!is_array($product_id)) {
                $to_del = array($product_id);
            } else {
                $to_del = $product_id;
            }

            if ($to_del) {
                foreach ($to_del as $did) {
                    a2w_delete_transient('a2w_product#' . strval($did));
                }
            }
        }

        public function get_product_list($with_html = true, $search = '', $sort = '') {
            $product_id_list = $this->get_product_id_list();
            $products = array();

            foreach ($product_id_list as $product_id) {
                $product = $this->get_product($product_id);
                if ($product) {
                    if (isset($product['html']) && $product['html']) {
                        if (!$with_html) {
                            $product['html'] = "#hidden#";
                        }
                    } else {
                        $product['html'] = "#needload#";
                    }

                    if (empty($search) || strpos($product['title'], strval($search)) !== false || strpos($product['id'], strval($search)) !== false) {
                        $products[$product_id] = $product;
                    }
                }
            }

            $this->init_sort($sort);
            uasort($products, array($this, 'custom_sort'));

            return $products;
        }

        public function get_product_id_list() {
            global $wpdb;
            if (a2w_check_defined('A2W_SAVE_TRANSIENT_AS_OPTION')) {
                $results = $wpdb->get_results("select option_name from {$wpdb->options} where option_name like 'a2w_product#%'", ARRAY_A);
            } else {
                $results = $wpdb->get_results("select option_name from {$wpdb->options} where option_name like '_transient_a2w_product#%'", ARRAY_A);
            }
            $ids = array();
            foreach ($results as $r) {
                $tmp = explode("#", $r['option_name']);
                if (count($tmp) == 2) {
                    $ids[] = $tmp[1];
                }
            }
            return $ids;
        }

        public function get_product($product_id) {
            $product = a2w_get_transient('a2w_product#' . strval($product_id));
            if ($product) {
                /*
                  if(!isset($product['description'])){
                  $product['description'] = '';
                  }
                 */

                if (!isset($product['product_type'])) {
                    $product['product_type'] = a2w_get_setting('default_product_type');
                }
                if (!isset($product['product_status'])) {
                    $product['product_status'] = a2w_get_setting('default_product_status');
                }
                if (!isset($product['tags'])) {
                    $product['tags'] = array();
                }
                if (!isset($product['categories'])) {
                    $product['categories'] = array();
                }
                if (!isset($product['skip_images'])) {
                    $product['skip_images'] = array();
                }
                if (!isset($product['skip_vars'])) {
                    $product['skip_vars'] = array();
                }
                if (empty($product['images'])) {
                    $product['images'] = array();
                }
                if (empty($product['original_attr_cache'])) {
                    $product['original_attr_cache'] = array();
                }
                if (!isset($product['disable_sync'])) {
                    $product['disable_sync'] = false;
                }
                if (!isset($product['disable_var_price_change'])) {
                    $product['disable_var_price_change'] = false;
                }
                if (!isset($product['disable_var_quantity_change'])) {
                    $product['disable_var_quantity_change'] = false;
                }
                if (!isset($product['date_add'])) {
                    $product['date_add'] = date('1981-12-29');
                }
                if (!isset($product['tmp_move_images'])) {
                    $product['tmp_move_images'] = array();
                }
                if (!isset($product['tmp_copy_images'])) {
                    $product['tmp_copy_images'] = array();
                }
                if (!isset($product['tmp_edit_images'])) {
                    $product['tmp_edit_images'] = array();
                }

                return $product;
            }
            return false;
        }

        public function save_product($product_id, $product) {
            a2w_set_transient('a2w_product#' . strval($product_id), $product);
        }

        public function default_sort() {
            return 'date_add-asc';
        }
        
        public function sort_list() {
            return array('id-asc'=>__('Sort by External Id', 'ali2woo'),'title-asc'=>__('Sort by Product title', 'ali2woo'),'date_add-asc'=>__('Sort by Date add (old first)', 'ali2woo'),'date_add-desc'=>__('Sort by Date add (new first)', 'ali2woo'));
        }

        public function init_sort($sort) {
            if (empty($sort)) {
                $sort = $this->default_sort();
            }
            
            if (in_array($sort, array_keys($this->sort_list()))) {
                $sv = explode("-", strtolower($sort));
                $this->order = $sv[0];
                $this->order_dir = $sv[1];
            }
        }

        private function custom_sort($a, $b) {
            if ($a[$this->order] == $b[$this->order]) {
                return 0;
            }
            return (($a[$this->order] < $b[$this->order]) ? -1 : 1) * ($this->order_dir == 'asc' ? 1 : -1);
        }

    }

}