<?php

/**
 * Description of A2W_ProductServiceController
 *
 * @author Andrey
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_ProductServiceController')) {

    class A2W_ProductServiceController {

        private $helper;

        public function __construct() {
            $this->helper = new A2W_Helper();

            add_action("before_delete_post", array($this, 'delete_post_action'), 10, 1);
            add_action("woocommerce_save_product_variation", array($this, 'save_product_variation'), 10, 2);

            add_action('wp_ajax_woocommerce_save_attributes', array($this, 'woocommerce_save_attributes'), 5);
        }

        public function delete_post_action($post_id) {
            // first, delete all post images
            A2W_Utils::delete_post_images($post_id);

            //second, mark variation as skip
            if (get_post_type($post_id) == 'product_variation') {
                $variation = new WC_Product_Variation($post_id);
                $parent_id = $variation->get_parent_id();
                $a2w_skip_meta = get_post_meta($parent_id, "_a2w_skip_meta", true);
                $a2w_skip_meta = $a2w_skip_meta?$a2w_skip_meta:array('skip_vars' => array(), 'skip_images' => array());
                
                $external_variation_id = get_post_meta($post_id, "external_variation_id", true);
                if (!in_array($external_variation_id, $a2w_skip_meta['skip_vars'])) {
                    $a2w_skip_meta['skip_vars'][] = $external_variation_id;
                }
                update_post_meta($parent_id, "_a2w_skip_meta", $a2w_skip_meta);
            }
        }

        public function save_product_variation($variation_id, $i) {
            $variation = new WC_Product_Variation($variation_id);
            $parent_id = $variation->get_parent_id();
            $a2w_skip_meta = get_post_meta($parent_id, "_a2w_skip_meta", true);
            $a2w_skip_meta = $a2w_skip_meta?$a2w_skip_meta:array('skip_vars' => array(), 'skip_images' => array());
            
            $external_variation_id = get_post_meta($variation_id, "external_variation_id", true);
            if (in_array($variation->get_status(), array('publish', false))) {
                $a2w_skip_meta['skip_vars'] = array_diff($a2w_skip_meta['skip_vars'], array($external_variation_id));
            } else {
                if (!in_array($external_variation_id, $a2w_skip_meta['skip_vars'])) {
                    $a2w_skip_meta['skip_vars'][] = $external_variation_id;
                }
            }
            update_post_meta($parent_id, "_a2w_skip_meta", $a2w_skip_meta);
        }

        public function woocommerce_save_attributes() {
            check_ajax_referer('save-attributes', 'security');

            if (!current_user_can('edit_products')) {
                wp_die(-1);
            }

            $product_id = absint($_POST['post_id']);

            $original_variations_attributes = get_post_meta($product_id, '_a2w_original_variations_attributes', true);

            if ($original_variations_attributes) {
                parse_str($_POST['data'], $data);
                $attributes = WC_Meta_Box_Product_Data::prepare_attributes($data);

                $product_type = !empty($_POST['product_type']) ? wc_clean($_POST['product_type']) : 'simple';
                $classname = WC_Product_Factory::get_product_classname($product_id, $product_type);
                $product = new $classname($product_id);
                $product_attributes = $product->get_attributes();

                // update old simple variation attributes names (if it changed)
                $need_update = false;
                foreach ($product_attributes as $pa) {
                    $pa->get_position();
                    if ($pa->get_variation() && !$pa->is_taxonomy()) {
                        foreach ($attributes as $a) {
                            if ($pa->get_position() === $a->get_position() && $pa->get_name() !== $a->get_name()) {
                                $new_name = sanitize_title($a->get_name());
                                $old_name = sanitize_title($pa->get_name());
                                if (isset($original_variations_attributes[$old_name])) {
                                    $original_variations_attributes[$new_name] = $original_variations_attributes[$old_name];
                                    $original_variations_attributes[$new_name]['current_name'] = $a->get_name();
                                    unset($original_variations_attributes[$old_name]);
                                }

                                global $wpdb;
                                $wpdb->query("update $wpdb->postmeta pm, $wpdb->posts p SET pm.meta_key='" . esc_sql("attribute_" . $new_name) . "' WHERE p.ID = pm.post_id AND p.post_parent='" . $product->get_id() . "' AND pm.meta_key='" . esc_sql("attribute_" . $old_name) . "'");

                                $need_update = true;
                                break;
                            }
                        }
                    }
                }

                if ($need_update) {
                    update_post_meta($product_id, '_a2w_original_variations_attributes', $original_variations_attributes);
                }

                // buld deletete variation attributes array
                foreach ($attributes as $product_attr) {
                    if ($product_attr->get_variation()) {
                        foreach ($original_variations_attributes as $key => $values) {
                            if (sanitize_title($product_attr->get_name()) == (($product_attr->is_taxonomy() ? 'pa_' : '') . $key)) {
                                unset($original_variations_attributes[$key]);
                                break;
                            }
                        }
                    }
                }

                update_post_meta($product_id, '_a2w_deleted_variations_attributes', $original_variations_attributes);
            }
        }

    }

}
