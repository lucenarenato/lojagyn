<?php

/**
 * Description of A2W_SynchProductController
 *
 * @author Andrey
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_SynchProductController')) {

    class A2W_SynchProductController extends A2W_AbstractController {

        private $woocommerce_model;
        private $loader;
        private $sync_model;
        private $reviews_model;

        public function __construct() {
            add_action('a2w_install', array($this, 'install'));
            add_action('a2w_uninstall', array($this, 'uninstall'));
            
            add_filter('cron_schedules', array($this, 'init_reccurences'));
            
            add_action('a2w_set_setting_auto_update', array($this, 'togle_auto_update'), 10, 3);

            add_action('a2w_set_setting_review_status', array($this, 'togle_update_reviews'), 10, 3);

            add_action('a2w_synch_event_check', array($this, 'a2w_synch_event_check_proc'));

            foreach (array('a2w_add_product', 'trashed_post', 'untrashed_post', 'before_delete_post') as $_act) {
                add_action($_act, array($this, 'sync_post_proc'));
            }

            if (a2w_get_setting('auto_update')) {
                add_action('a2w_auto_update_event', array($this, 'auto_update_event'));
            }

            if (a2w_get_setting('review_status')) {
                add_action('a2w_update_reviews_event', array($this, 'update_reviews_event'));
            }

            add_action('a2w_auto_synch_event', array($this, 'auto_synch_event'));

            $this->woocommerce_model = new A2W_Woocommerce();
            $this->loader = new A2W_Aliexpress();
            $this->sync_model = new A2W_Synchronize();
            $this->reviews_model = new A2W_Review();
        }
        
        public function init_reccurences($schedules) {
            $schedules['a2w_1_mins'] = array('interval' => 1 * 60, 'display' => __('Every Minute', 'ali2woo'));
            $schedules['a2w_5_mins'] = array('interval' => 5 * 60, 'display' => __('Every 5 Minutes', 'ali2woo'));
            $schedules['a2w_15_mins'] = array('interval' => 15 * 60, 'display' => __('Every 15 Minutes', 'ali2woo'));
            return $schedules;
        }

        public function a2w_synch_event_check_proc() {
            // hourly check: is a2w_auto_update_event and a2w_auto_synch_event exist. if no, create it.
            if (!wp_next_scheduled('a2w_auto_update_event') && a2w_get_setting('auto_update')) {
                $this->schedule_event();
            }

            if (!wp_next_scheduled('a2w_update_reviews_event') && a2w_get_setting('review_status')) {
                $this->schedule_reviews_event();
            }

            if (!wp_next_scheduled('a2w_auto_synch_event')) {
                $this->schedule_synch_event();
            }
        }

        public function install() {
            if (!wp_next_scheduled('a2w_synch_event_check')) {
                wp_schedule_event(time(), 'hourly', 'a2w_synch_event_check');
            }

            $this->unschedule_event();
            if (a2w_get_setting('auto_update')) {
                $this->schedule_event();
            }

            $this->unschedule_reviews_event();
            if (a2w_get_setting('review_status')) {
                $this->schedule_reviews_event();
            }

            $this->unschedule_synch_event();
            $this->schedule_synch_event();
        }

        public function uninstall() {
            $this->unschedule_event();
            $this->unschedule_reviews_event();
            $this->unschedule_synch_event();
        }

        public function togle_auto_update($old_value, $value, $option) {
            if($old_value !== $value){
                $this->unschedule_event();
                if ($value) {
                    $this->schedule_event();
                }
            }
        }

        public function togle_update_reviews($old_value, $value, $option) {
            if($old_value !== $value){
                $this->unschedule_reviews_event();
                if ($value) {
                    $this->schedule_reviews_event();
                }
            }
            
        }

        // Cron auto update event
        public function auto_update_event() {
            if (!a2w_get_setting('auto_update')) {
                return;
            }
            
            a2w_init_error_handler();
            try {
                $update_per_schedule = 100;
                $update_per_request = 5;
                $update_period_delay = 60 * 60 * 24;
                $product_ids = $this->woocommerce_model->get_sorted_products_ids("_a2w_last_update", $update_per_schedule, array('value' => time() - $update_period_delay, 'compare' => '<'));
                
                $a2w_sync_type = a2w_get_setting('sync_type');

                $product_map = array();
                foreach ($product_ids as $product_id) {
                    $product = $this->woocommerce_model->get_product_by_post_id($product_id, false);
                    if ($product && !$product['disable_sync']) {
                        if($a2w_sync_type === 'price'){
                            $product['disable_var_quantity_change'] = true;
                        }else if($a2w_sync_type === 'stock'){
                            $product['disable_var_price_change'] = true;
                        }else if($a2w_sync_type === 'no'){
                            $product['disable_var_price_change'] = true;
                            $product['disable_var_quantity_change'] = true;
                        }
                        $product_map[$product['id']] = $product;
                    }
                }

                while ($product_map) {
                    $tmp_product_map = array_slice($product_map, 0, $update_per_request, true);
                    $product_map = array_diff_key($product_map, $tmp_product_map);
                    
                    $result = $this->loader->sync_products(array_keys($tmp_product_map), array('pc'=>$this->sync_model->get_product_cnt()));
                    if ($result['state'] !== 'error') {
                        foreach ($result['products'] as $product) {
                            if (!empty($tmp_product_map[$product['id']])) {
                                $product = array_replace_recursive($tmp_product_map[$product['id']], $product);
                                $product = A2W_PriceFormula::apply_formula($product);
                                $this->woocommerce_model->upd_product($product['post_id'], $product);
                                if ($result['state'] !== 'ok') {
                                    error_log($result['message']);
                                }
                                unset($tmp_product_map[$product['id']]);
                            }
                        }
                        
                        // update meta for skiped products
                        foreach($tmp_product_map as $product){
                            update_post_meta($product['post_id'], '_a2w_last_update', time());
                        }
                    } else {
                        error_log($result['message']);
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }

            if (a2w_get_setting('auto_update')) {
                $this->schedule_event();
            } else {
                $this->unschedule_event();
            }
        }

        public function update_reviews_event() {
            if (!a2w_get_setting('review_status')) {
                return;
            }
            
            a2w_init_error_handler();
            try {
                $posts_by_time = $this->woocommerce_model->get_sorted_products_ids("_a2w_reviews_last_update", 20);
                foreach ($posts_by_time as $post_id) {
                    $this->reviews_model->load($post_id);
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
            }

            if (a2w_get_setting('review_status')) {
                $this->schedule_reviews_event();
            } else {
                $this->unschedule_reviews_event();
            }
        }

        // Cron auto synch event
        public function auto_synch_event() {
            a2w_init_error_handler();
            try {
                $this->sync_model->gloabal_sync_products();
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
            $this->schedule_synch_event();
        }

        public function sync_post_proc($post_ID) {
            $post = get_post($post_ID);
            if ($post && $post->post_type === 'product') {
                $id = get_post_meta($post_ID, '_a2w_external_id', true);
                if ($id) {
                    $this->sync_model->sync_products($id, $post->post_status === 'trash' ? 'remove' : 'add');
                }
            }
        }

        private function schedule_event() {
            if (!($timestamp = wp_next_scheduled('a2w_auto_update_event'))) {
                wp_schedule_single_event(time() + MINUTE_IN_SECONDS * 5, 'a2w_auto_update_event');
            }
        }

        private function unschedule_event() {
            wp_clear_scheduled_hook('a2w_auto_update_event');
        }

        private function schedule_synch_event() {
            if (!($timestamp = wp_next_scheduled('a2w_auto_synch_event'))) {
                wp_schedule_single_event(time() + HOUR_IN_SECONDS * 6, 'a2w_auto_synch_event');
                //wp_schedule_single_event(time() + 60*5, 'a2w_auto_synch_event');
            }
        }

        private function unschedule_synch_event() {
            wp_clear_scheduled_hook('a2w_auto_synch_event');
        }

        private function schedule_reviews_event() {
            if (!($timestamp = wp_next_scheduled('a2w_update_reviews_event'))) {
                wp_schedule_single_event(time() + MINUTE_IN_SECONDS * 30, 'a2w_update_reviews_event');
            }
        }

        private function unschedule_reviews_event() {
            wp_clear_scheduled_hook('a2w_update_reviews_event');
        }

    }

}
