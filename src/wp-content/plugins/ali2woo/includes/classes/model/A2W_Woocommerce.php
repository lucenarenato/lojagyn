<?php

/**
 * Description of A2W_Woocommerce
 *
 * @author andrey
 */
if (!class_exists('A2W_Woocommerce')) {

    class A2W_Woocommerce {

        private static $active_plugins;
        private $attachment_model;
        private $reviews_model;
        private $helper;

        public function __construct() {
            $this->attachment_model = new A2W_Attachment();
            $this->reviews_model = new A2W_Review();
            $this->helper = new A2W_Helper();
        }

        public static function is_woocommerce_installed() {
            if (!self::$active_plugins) {
                self::$active_plugins = (array) get_option('active_plugins', array());
                if (is_multisite()) {
                    self::$active_plugins = array_merge(self::$active_plugins, get_site_option('active_sitewide_plugins', array()));
                }
            }

            return in_array('woocommerce/woocommerce.php', self::$active_plugins) || array_key_exists('woocommerce/woocommerce.php', self::$active_plugins);
        }

        public function add_product($product, $params = array()) {
            if (!A2W_Woocommerce::is_woocommerce_installed()) {
                return A2W_ResultBuilder::buildError("Woocommerce is not installed");
            }

            global $wpdb;

            do_action('a2w_woocommerce_before_add_product', $product, $params);

            $product_type = (isset($product['product_type']) && $product['product_type']) ? $product['product_type'] : a2w_get_setting('default_product_type', 'simple');
            $product_status = (isset($product['product_status']) && $product['product_status']) ? $product['product_status'] : a2w_get_setting('default_product_status', 'publish');

            $tax_input = array('product_type' => $product_type);
            $categories = $this->build_categories($product);
            if ($categories) {
                $tax_input['product_cat'] = $categories;
            }

            $post = array(
                'post_title' => isset($product['title']) && $product['title'] ? $product['title'] : "Product " . $product['id'],
                'post_content' => '',
                'post_status' => $product_status,
                'post_name' => isset($product['title']) && $product['title'] ? $product['title'] : "Product " . $product['id'],
                'post_type' => 'product',
                'comment_status' => 'open',
                'tax_input' => $tax_input,
                'meta_input' => array('_stock_status' => 'instock',
                    '_sku' => $product['id'],
                    '_a2w_external_id' => $product['id'],
                    '_visibility' => 'visible', // for old woocomerce
                    '_product_url' => $product['affiliate_url'],
                    '_a2w_product_url' => $product['affiliate_url'],
                    '_a2w_original_product_url' => $product['url'],
                    '_a2w_seller_url' => (!empty($product['seller_url']) ? $product['seller_url'] : ''),
                    '_a2w_import_type' => 'a2w',
                    '_a2w_last_update' => time(),
                    '_a2w_skip_meta' => array('skip_vars' => $product['skip_vars'], 'skip_images' => $product['skip_images']),
                    '_a2w_disable_sync' => 0,
                    '_a2w_disable_var_price_change' => isset($product['disable_var_price_change']) && $product['disable_var_price_change'] ? 1 : 0,
                    '_a2w_disable_var_quantity_change' => isset($product['disable_var_quantity_change']) && $product['disable_var_quantity_change'] ? 1 : 0,
                    '_a2w_orders_count' => (!empty($product['ordersCount']) ? intval($product['ordersCount']) : 0),
                ),
            );

            $is_old_product = false;
            $tmp_product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $product['id']));
            if (!$tmp_product_id) {
                $product_id = wp_insert_post($post);
            } else {
                $is_old_product = true;
                $product_id = $tmp_product_id;
            }

            $first_ava_var = false;
            if (isset($product['sku_products']['variations'])) {
                foreach ($product['sku_products']['variations'] as $variation) {
                    if (intval($variation['quantity']) > 0) {
                        $first_ava_var = $variation;
                        break;
                    }
                }
            }

            if ($first_ava_var) {
                delete_post_meta($product_id, "_a2w_outofstock");
            } else {
                update_post_meta($product_id, "_a2w_outofstock", true);
            }

            if (get_option('woocommerce_manage_stock', 'no') === 'yes') {
                $tmp_quantity = $first_ava_var ? intval($first_ava_var['quantity']) : 0;
                update_post_meta($product_id, '_manage_stock', 'yes');
                update_post_meta($product_id, '_stock_status', $tmp_quantity ? 'instock' : 'outofstock');
                update_post_meta($product_id, '_stock', $tmp_quantity);
            } else {
                delete_post_meta($product_id, '_manage_stock');
                delete_post_meta($product_id, '_stock_status');
                delete_post_meta($product_id, '_stock');
            }


            $this->update_price($product_id, $first_ava_var);

            if (isset($product['attribute']) && $product['attribute'] && !a2w_get_setting('not_import_attributes', false)) {
                $this->set_attributes($product_id, $product['attribute']);
            }

            if (isset($product['tags']) && $product['tags']) {
                wp_set_object_terms($product_id, array_map('sanitize_text_field', $product['tags']), 'product_tag');
            }

            if (!a2w_check_defined('A2W_DO_NOT_IMPORT_VARIATIONS') && isset($product['sku_products']['variations']) && count($product['sku_products']['variations']) > 1) {
                foreach ($product['sku_products']['variations'] as &$var) {
                    $var['image'] = (!isset($var['image']) || in_array(md5($var['image']), $product['skip_images'])) ? '' : $var['image'];
                }
                $this->add_variation($product_id, $product, false);
            }

            $thumb_url = '';
            $tmp_all_images = A2W_Utils::get_all_images_from_product($product);

            if (isset($product['thumb_id'])) {
                foreach ($tmp_all_images as $img_id => $img) {
                    if ($img_id === $product['thumb_id']) {
                        $thumb_url = A2W_Utils::clear_url($img['image']);
                        break;
                    }
                }
                /*
                  disable select disable thumb... not use now. uncomment if need use.
                  if(!$thumb_url){
                  $thumb_url = 'empty';
                  }
                 */
            }

            if (isset($product['images'])) {
                $image_to_load = array();
                foreach ($product['images'] as $image) {
                    if (!in_array(md5($image), $product['skip_images'])) {
                        $image_to_load[md5($image)] = $image;
                    }
                }

                foreach ($product['tmp_copy_images'] as $img_id => $source) {
                    if (isset($tmp_all_images[$img_id]) && !in_array($img_id, $product['skip_images'])) {
                        $image_to_load[$img_id] = $tmp_all_images[$img_id]['image'];
                    }
                }

                foreach ($product['tmp_move_images'] as $img_id => $source) {
                    if (isset($tmp_all_images[$img_id]) && !in_array($img_id, $product['skip_images'])) {
                        $image_to_load[$img_id] = $tmp_all_images[$img_id]['image'];
                    }
                }

                // if not thumb not checked, check first available image
                if (!$thumb_url && !empty($image_to_load)) {
                    $tmp_images = array_values($image_to_load);
                    $thumb_url = array_shift($tmp_images);
                }

                $this->set_images($product, $product_id, $thumb_url, $image_to_load, true, $post['post_title']);
            }

            $post_arr = array('ID' => $product_id, 'post_content' => (isset($product['description']) ? $this->build_description($product_id, $product) : ''));

            if (a2w_get_setting('load_review')) {
                $this->reviews_model->load($product_id);
                //make sure that post comment status is 'open'
                $post_arr['comment_status'] = 'open';
            }

            wp_update_post($post_arr);

            wc_delete_product_transients($product_id);

            delete_transient('wc_attribute_taxonomies');

            do_action('a2w_add_product', $product_id);

            return apply_filters('a2w_woocommerce_after_add_product', A2W_ResultBuilder::buildOk(array('product_id' => $product_id)), $product_id, $product, $params);
        }

        public function upd_product($product_id, $product, $params = array()) {
            do_action('a2w_woocommerce_upd_product', $product_id, $product, $params);

            // first, update some meta
            if (!empty($product['affiliate_url']) && !a2w_check_defined('A2W_DISABLE_UPDATE_AFFILIATE_URL')) {
                update_post_meta($product_id, '_product_url', $product['affiliate_url']);
                update_post_meta($product_id, '_a2w_product_url', $product['affiliate_url']);
            }

            if (!empty($product['url'])) {
                update_post_meta($product_id, '_a2w_original_product_url', $product['url']);
            }

            if (!empty($product['ordersCount'])) {
                update_post_meta($product_id, '_a2w_orders_count', intval($product['ordersCount']));
            }

            if (!get_post_meta($product_id, '_a2w_import_type', true)) {
                update_post_meta($product_id, '_a2w_import_type', 'a2w');
            }

            $result = array("state" => "ok", "message" => "");
            $first_ava_var = false;
            if (isset($product['sku_products']['variations'])) {
                foreach ($product['sku_products']['variations'] as $variation) {
                    if (intval($variation['quantity']) > 0) {
                        $first_ava_var = $variation;
                        break;
                    }
                }
            }

            if ($first_ava_var) {
                delete_post_meta($product_id, "_a2w_outofstock");
            } else {
                update_post_meta($product_id, "_a2w_outofstock", true);
            }

            $not_available_product_status = a2w_get_setting('not_available_product_status');

            if (get_option('woocommerce_manage_stock', 'no') === 'yes') {
                if ($first_ava_var || $not_available_product_status === 'outofstock') {
                    $tmp_quantity = $first_ava_var ? intval($first_ava_var['quantity']) : 0;
                    update_post_meta($product_id, '_manage_stock', 'yes');
                    update_post_meta($product_id, '_stock_status', $tmp_quantity ? 'instock' : 'outofstock');

                    if (!$product['disable_var_quantity_change']) {
                        update_post_meta($product_id, '_stock', $tmp_quantity);
                    }
                }
            } else {
                delete_post_meta($product_id, '_manage_stock');
                delete_post_meta($product_id, '_stock_status');
                delete_post_meta($product_id, '_stock');
            }


            if (!$product['disable_var_price_change'] && ($first_ava_var || $not_available_product_status === 'outofstock')) {
                $this->update_price($product_id, $first_ava_var);
            }

            $wc_product = wc_get_product($product_id);
            if (!empty($product['sku_products']['variations'])) {
                if ($wc_product->is_type('external') && $first_ava_var) {
                    $init_status = get_post_meta($product_id, '_a2w_init_product_status', true);
                    if ($wc_product->get_status() !== $init_status) {
                        $wc_product->set_status($init_status);
                        $wc_product->save();
                    }
                    delete_post_meta($product_id, '_a2w_init_product_status');
                }

                if (!a2w_check_defined('A2W_DO_NOT_IMPORT_VARIATIONS') && count($product['sku_products']['variations']) > 1) {
                    foreach ($product['sku_products']['variations'] as &$var) {
                        $var['image'] = (!isset($var['image']) || in_array(md5($var['image']), $product['skip_images'])) ? '' : $var['image'];
                    }
                    $this->add_variation($product_id, $product, true);
                }
            } else {
                if ($not_available_product_status === 'trash') {
                    $wc_product->delete();
                } else if ($not_available_product_status === 'outofstock') {
                    $tmp_skip_meta = get_post_meta($product_id, "_a2w_skip_meta", true);

                    foreach ($wc_product->get_children() as $var_id) {
                        $var = wc_get_product($var_id);
                        A2W_Utils::delete_post_images($var_id);
                        $var->delete(true);
                    }

                    if ($wc_product->is_type('variable')) {
                        wp_set_object_terms($product_id, 'simple', 'product_type');
                    }

                    $cur_status = $wc_product->get_status();
                    if ($wc_product->is_type('external') && $cur_status !== 'draft') {
                        update_post_meta($product_id, '_a2w_init_product_status', $wc_product->get_status());
                        $wc_product->set_status('draft');
                        $wc_product->save();
                    }

                    update_post_meta($product_id, "_a2w_skip_meta", $tmp_skip_meta);
                }
            }

            //A2W_FIX_RELOAD_IMAGES - special flag (for update only), if product images is disapear, reload it.
            if (a2w_check_defined('A2W_FIX_RELOAD_IMAGES') && isset($product['images'])) {
                $old_thumb_id = get_post_thumbnail_id($product_id);
                if ($old_thumb_id) {
                    wp_delete_attachment($old_thumb_id, true);
                    delete_post_meta($product_id, '_thumbnail_id');
                }

                $old_image_gallery = get_post_meta($product_id, '_product_image_gallery', true);
                if ($old_image_gallery) {
                    $image_ids = explode(",", $old_image_gallery);
                    foreach ($image_ids as $image_id) {
                        wp_delete_attachment($image_id, true);
                    }
                    delete_post_meta($product_id, '_product_image_gallery');
                }

                $thumb_url = '';
                $image_to_load = array();
                foreach ($product['images'] as $image) {
                    if (!in_array(md5($image), $product['skip_images'])) {
                        $image_to_load[] = $image;

                        if (!$thumb_url) {
                            // if not thumb not checked, check first available image
                            $thumb_url = $image;
                        }
                    }
                }

                $this->set_images($product, $product_id, $thumb_url, $image_to_load, true, isset($product['title']) && $product['title'] ? $product['title'] : "Product " . $product['id']);
            }

            if (isset($params['manual_update']) && $params['manual_update'] && a2w_check_defined('A2W_FIX_RELOAD_DESCRIPTION') && !a2w_get_setting('not_import_description')) {
                $post_arr = array('ID' => $product_id, 'post_content' => (isset($product['description']) ? $this->build_description($product_id, $product) : ''));
                wp_update_post($post_arr);
            }

            wc_delete_product_transients($product_id);

            if (empty($params['skip_last_update'])) {
                update_post_meta($product_id, '_a2w_last_update', time());
            }

            do_action('a2w_after_upd_product', $product_id, $product, $params);

            delete_transient('wc_attribute_taxonomies');

            return apply_filters('a2w_woocommerce_after_upd_product', $result, $product_id, $product, $params);
        }

        public function build_description($product_id, $product) {
            $html = $product['description'];

            if (function_exists('mb_convert_encoding')) {
                $html = trim(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            } else {
                $html = htmlspecialchars_decode(utf8_decode(htmlentities($html, ENT_COMPAT, 'UTF-8', false)));
            }

            if (function_exists('libxml_use_internal_errors')) {
                libxml_use_internal_errors(true);
            }
            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $dom->formatOutput = true;

            $elements = $dom->getElementsByTagName('img');
            for ($i = $elements->length; --$i >= 0;) {
                $e = $elements->item($i);

                if (isset($product['tmp_move_images'])) {
                    foreach ($product['tmp_move_images'] as $img_id => $source) {
                        if (isset($tmp_all_images[$img_id]) && !in_array($img_id, $product['skip_images'])) {
                            $image_to_load[$img_id] = $tmp_all_images[$img_id]['image'];
                        }
                    }
                }


                $img_id = md5($e->getAttribute('src'));
                if (in_array($img_id, $product['skip_images']) || isset($product['tmp_move_images'][$img_id])) {
                    $e->parentNode->removeChild($e);
                } else if (!a2w_get_setting('use_external_image_urls')) {
                    $tmp_title = isset($product['title']) && $product['title'] ? $product['title'] : "Product " . $product['id'];

                    // if have edited image, than user initial url
                    $clear_image_url = !empty($product['tmp_edit_images'][$img_id]) ? $e->getAttribute('src') : A2W_Utils::clear_image_url($e->getAttribute('src'));

                    $attachment_id = $this->attachment_model->create_attachment($product_id, $clear_image_url, array('inner_post_id' => $product_id, 'title' => $tmp_title, 'alt' => $tmp_title, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                    $attachment_url = wp_get_attachment_url($attachment_id);
                    $e->setAttribute('src', $attachment_url);
                } else if (!empty($product['tmp_edit_images'][$img_id])) {
                    $e->setAttribute('src', $product['tmp_edit_images'][$img_id]['attachment_url']);
                }
            }

            $html = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());

            /* do {
              $tmp = $html;
              $html = preg_replace('#<([^ >]+)[^>]*>([[:space:]]|&nbsp;)*</\1>#', '', $html);
              } while ($html !== $tmp); */

            return html_entity_decode(trim($html), ENT_COMPAT, 'UTF-8');
        }

        public function set_images($product, $product_id, $thumb_url, $images, $update, $title = '') {

            if ($thumb_url && $thumb_url != 'empty' && (!get_post_thumbnail_id($product_id) || $update)) {
                try {
                    $tmp_title = !empty($title) ? $title : null;
                    $thumb_id = $this->attachment_model->create_attachment($product_id, $thumb_url, array('inner_post_id' => $product_id, 'title' => $tmp_title, 'alt' => $tmp_title, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                    set_post_thumbnail($product_id, $thumb_id);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }

            if ($images) {
                if (!get_post_meta($product_id, '_product_image_gallery', true) || $update) {
                    //$images_limit = intval(a2w_get_setting('import_product_images_limit'));

                    $image_gallery_ids = '';
                    $cnt = 0;
                    foreach ($images as $image_url) {
                        if ($image_url == $thumb_url) {
                            continue;
                        }

                        $cnt++;

                        //if (!$images_limit || ($cnt++) < $images_limit) {
                        try {
                            $tmp_title = !empty($title) ? ($title . ' ' . $cnt) : null;
                            $new_image_gallery_id = $this->attachment_model->create_attachment($product_id, $image_url, array('inner_post_id' => $product_id, 'title' => $tmp_title, 'alt' => $tmp_title, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                            $image_gallery_ids .= $new_image_gallery_id . ',';
                        } catch (Exception $e) {
                            error_log($e->getMessage());
                        }
                        //}
                    }
                    update_post_meta($product_id, '_product_image_gallery', $image_gallery_ids);
                }
            }
        }

        public function update_price($product_id, $variation) {
            if ($variation) {
                $price = isset($variation['price']) ? $variation['price'] : 0;
                $regular_price = isset($variation['regular_price']) ? $variation['regular_price'] : $price;

                update_post_meta($product_id, '_aliexpress_regular_price', $regular_price);
                update_post_meta($product_id, '_aliexpress_price', $price);

                if (isset($variation['calc_price'])) {
                    $price = $variation['calc_price'];
                    $regular_price = isset($variation['calc_regular_price']) ? $variation['calc_regular_price'] : $price;
                }

                update_post_meta($product_id, '_regular_price', $regular_price);
                if (round(abs($regular_price - $price), 2) == 0) {
                    update_post_meta($product_id, '_price', $regular_price);
                    delete_post_meta($product_id, '_sale_price');
                } else {
                    update_post_meta($product_id, '_price', $price);
                    update_post_meta($product_id, '_sale_price', $price);
                }
            } else {
                update_post_meta($product_id, '_price', 0);
                update_post_meta($product_id, '_regular_price', 0);
                delete_post_meta($product_id, '_sale_price');

                delete_post_meta($product_id, '_aliexpress_regular_price');
                delete_post_meta($product_id, '_aliexpress_price');
            }
        }

        private function set_attributes($product_id, $attributes) {
            if (defined('A2W_IMPORT_EXTENDED_ATTRIBUTE')) {
                $extended_attribute = filter_var(A2W_IMPORT_EXTENDED_ATTRIBUTE, FILTER_VALIDATE_BOOLEAN);
            } else {
                $extended_attribute = a2w_get_setting('import_extended_attribute');
            }

            $attributes = apply_filters('a2w_set_product_attributes', $attributes);

            if ($extended_attribute) {
                $this->helper->set_woocommerce_attributes($attributes, $product_id);
            } else {
                $tmp_product_attr = array();
                foreach ($attributes as $attr) {
                    if (!isset($tmp_product_attr[$attr['name']])) {
                        $tmp_product_attr[$attr['name']] = is_array($attr['value']) ? $attr['value'] : array($attr['value']);
                    } else {
                        $tmp_product_attr[$attr['name']] = array_merge($tmp_product_attr[$attr['name']], is_array($attr['value']) ? $attr['value'] : array($attr['value']));
                    }
                }

                $product_attributes = array();
                foreach ($tmp_product_attr as $name => $value) {
                    $product_attributes[str_replace(' ', '-', $name)] = array(
                        'name' => $name,
                        'value' => implode(', ', $value),
                        'position' => count($product_attributes),
                        'is_visible' => 1,
                        'is_variation' => 0,
                        'is_taxonomy' => 0
                    );
                }

                update_post_meta($product_id, '_product_attributes', $product_attributes);
            }
        }

        private function build_categories($product) {
            if (isset($product['categories']) && $product['categories']) {
                return is_array($product['categories']) ? array_map('intval', $product['categories']) : array(intval($product['categories']));
            } else if (isset($product['category_name']) && $product['category_name']) {
                $category_name = sanitize_text_field($product['category_name']);
                if ($category_name) {
                    $cat = get_terms('product_cat', array('name' => $category_name, 'hide_empty' => false));
                    if (empty($cat)) {
                        $cat = wp_insert_term($category_name, 'product_cat');
                        $cat_id = $cat['term_id'];
                    } else {
                        $cat_id = $cat->term_id;
                    }
                    return array($cat_id);
                }
            }
            return array();
        }

        private function add_variation($product_id, $product, $is_update = false) {
            global $wpdb;
            $result = array('state' => 'ok', 'message' => '');
            $variations = $product['sku_products'];
            if ($variations) {
                $tmp_product = wc_get_product($product_id);

                if ($variations && isset($variations['attributes']) && ($tmp_product->is_type('variable') || $tmp_product->is_type('simple'))) {
                    $variations_active_cnt = 0;
                    foreach ($variations['variations'] as $variation) {
                        if (!in_array($variation['id'], $product['skip_vars'])) {
                            $variations_active_cnt++;
                        }
                    }
                    
                    if(!a2w_check_defined('A2W_NOT_CHANGE_PRODUCT_TYPE')){
                        wp_set_object_terms($product_id, $variations_active_cnt > 1 ? 'variable' : 'simple', 'product_type');    
                    }

                    $localCurrency = strtoupper(a2w_get_setting('local_currency'));

                    $woocommerce_manage_stock = get_option('woocommerce_manage_stock', 'no');

                    if ($localCurrency === 'USD') {
                        $localCurrency = '';
                    }

                    if ($localCurrency) {
                        $currency_conversion_factor = 1;
                    } else {
                        $currency_conversion_factor = floatval(a2w_get_setting('currency_conversion_factor'));
                    }

                    if (a2w_check_defined('A2W_FIX_RELOAD_VARIATIONS')) {
                        delete_post_meta($product_id, '_a2w_original_variations_attributes');
                    }

                    $deleted_variations_attributes = get_post_meta($product_id, '_a2w_deleted_variations_attributes', true);
                    $deleted_variations_attributes = $deleted_variations_attributes && is_array($deleted_variations_attributes) ? $deleted_variations_attributes : array();

                    $original_variations_attributes = get_post_meta($product_id, '_a2w_original_variations_attributes', true);
                    $original_variations_attributes = $original_variations_attributes && is_array($original_variations_attributes) ? $original_variations_attributes : array();


                    $attributes = array();
                    $used_variation_attributes = array();

                    $tmp_attributes = get_post_meta($product_id, '_product_attributes', true);
                    if (!$tmp_attributes) {
                        $tmp_attributes = array();
                    }


                    $not_remove_variation_attr = a2w_check_defined('A2W_NOT_REMOVE_VARIATION_ATTR');
                    foreach ($tmp_attributes as $attr) {
                        if (!intval($attr['is_variation']) || $not_remove_variation_attr) {
                            $attributes[] = $attr;
                        }
                    }

                    $old_swatch_type_options = get_post_meta($product_id, '_swatch_type_options', true);
                    $old_swatch_type_options = $old_swatch_type_options ? $old_swatch_type_options : array();

                    $swatch_type_options = array();

                    //if names of variation attributes has been change, we need fix variation attribute names
                    foreach ($variations['attributes'] as $key => $attr) {
                        foreach ($original_variations_attributes as $ova_key => $ova_val) {
                            if (sanitize_title($attr['name']) === sanitize_title($ova_val['name']) && !empty($ova_val['current_name'])) {
                                $variations['attributes'][$key]['name'] = $ova_val['current_name'];

                                if(!empty($ova_val['values'])){
                                    foreach ($attr['value'] as $val_id => $val) {
                                        foreach ($ova_val['values'] as $ova_val_key => $ova_val_val) {
                                            if ($val['id'] == $ova_val_val['oroginal_id']) {
                                                $variations['attributes'][$key]['value'][$val_id]['name'] = $ova_val_val['name'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach ($variations['attributes'] as $key => $attr) {
                        $attribute_taxonomies = a2w_get_setting('import_extended_variation_attribute');

                        if (!$attribute_taxonomies) {
                            $attribute_taxonomies = $wpdb->get_var("SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '" . esc_sql($this->helper->cleanTaxonomyName($attr['name'], false)) . "'");
                        }

                        $attr_tax = $this->helper->cleanTaxonomyName($attr['name'], $attribute_taxonomies);
                        $swatch_id = md5(sanitize_title(($attribute_taxonomies ? 'pa_' : '') . $attr['name']));
                        $variations['attributes'][$key]['tax'] = $attr_tax;
                        $variations['attributes'][$key]['swatch_id'] = $swatch_id;
                        $variations['attributes'][$key]['attribute_taxonomies'] = $attribute_taxonomies;

                        $used_variation_attributes[$attr_tax] = array('original_attribute_id' => $attr['id'], 'attribute_taxonomies' => $attribute_taxonomies, 'values' => array());



                        //added 03.02.2018 ---
                        if (!empty($old_swatch_type_options) && isset($old_swatch_type_options[$swatch_id])) {
                            $swatch_type_options[$swatch_id] = $old_swatch_type_options[$swatch_id];
                        } /* end added */ else {
                            $swatch_type_options[$swatch_id]['type'] = 'radio';
                            $swatch_type_options[$swatch_id]['layout'] = 'default';
                            $swatch_type_options[$swatch_id]['size'] = 'swatches_image_size';

                            $swatch_type_options[$swatch_id]['attributes'] = array();
                        }


                        $attr_values = array();
                        foreach ($attr['value'] as $val_key => $val) {
                            $has_variation = false;
                            foreach ($variations['variations'] as $variation) {
                                if (!in_array($variation['id'], $product['skip_vars'])) {
                                    foreach ($variation['attributes'] as $va) {
                                        if ($va == $val['id']) {
                                            $has_variation = true;
                                        }
                                    }
                                }
                            }

                            if (!$has_variation) {
                                continue;
                            }

                            $attr_values[] = $val['name'];

                            $attr_image = "";
                            if (isset($val['thumb']) && $val['thumb']) {
                                $attr_image = $val['thumb'];
                            } else if (isset($val['image']) && $val['image']) {
                                $attr_image = $val['image'];
                            }

                            $swatch_value_id = md5(sanitize_title(strtolower($val['name'])));

                            $variations['attributes'][$key]['value'][$val_key]['swatch_value_id'] = $swatch_value_id;

                            $RELOAD_ATTR_IMAGES = a2w_check_defined('A2W_FIX_RELOAD_ATTR_IMAGES');

                            //added 03.02.2018
                            if (isset($swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]) && !$RELOAD_ATTR_IMAGES)
                                continue;
                            //end added 

                            if ($attr_image || !empty($val['color'])) {
                                $swatch_type_options[$swatch_id]['type'] = 'product_custom';
                            }

                            $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['type'] = 'color';
                            $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['color'] = empty($val['color']) ? '#FFFFFF' : $val['color'];
                            $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['image'] = 0;

                            if ($attr_image) {
                                $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['type'] = 'image';

                                $old_attachment_id = !empty($old_swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['image']) ? intval($old_swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['image']) : 0;
                                if ($RELOAD_ATTR_IMAGES) {
                                    if (intval($old_attachment_id) > 0) {
                                        wp_delete_attachment($old_attachment_id, true);
                                    }
                                    $attachment_id = $this->attachment_model->create_attachment($product_id, $attr_image, array('inner_post_id' => $product_id, 'title' => null, 'alt' => null, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                                } else {
                                    $attachment_id = $old_attachment_id ? $old_attachment_id : $this->attachment_model->create_attachment($product_id, $attr_image, array('inner_post_id' => $product_id, 'title' => null, 'alt' => null, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                                }
                                if (!empty($attachment_id)) {
                                    $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['image'] = $attachment_id; //+    
                                } else if (!empty($old_attachment_id)) {
                                    $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]['image'] = $old_attachment_id; //+    
                                }
                            }
                        }

                        $is_deleted_attr = false;
                        foreach ($deleted_variations_attributes as $key_del_attr => $del_attr) {
                            if (sanitize_title($del_attr['name']) == sanitize_title($attr['name']) || $key_del_attr == sanitize_title($attr['name'])) {
                                $is_deleted_attr = true;
                            }
                        }

                        if (!$is_deleted_attr) {
                            if ($attribute_taxonomies) {
                                $attributes[$attr_tax] = array(
                                    'name' => $attr_tax,
                                    'value' => '',
                                    'position' => count($attributes),
                                    'is_visible' => isset($tmp_attributes[$attr_tax]['is_visible']) ? $tmp_attributes[$attr_tax]['is_visible'] : '0',
                                    'is_variation' => '1',
                                    'is_taxonomy' => '1'
                                );
                                $this->helper->add_attribute($product_id, $attr['name'], $attr_values);
                            } else {
                                $new_attr_values = array_unique($attr_values);
                                asort($new_attr_values);

                                $attributes[$attr_tax] = array(
                                    'name' => $attr['name'],
                                    'value' => implode("|", $new_attr_values),
                                    'position' => count($attributes),
                                    'is_visible' => isset($tmp_attributes[$attr_tax]['is_visible']) ? $tmp_attributes[$attr_tax]['is_visible'] : '0',
                                    'is_variation' => '1',
                                    'is_taxonomy' => '0'
                                );
                            }
                        }
                    }
                    update_post_meta($product_id, '_product_attributes', $attributes);

                    if (a2w_check_defined('A2W_FIX_RELOAD_VARIATIONS')) {
                        $tmp_skip_meta = get_post_meta($product_id, "_a2w_skip_meta", true);

                        $wc_product = wc_get_product($product_id);
                        foreach ($wc_product->get_children() as $var_id) {
                            $var = wc_get_product($var_id);
                            A2W_Utils::delete_post_images($var_id);
                            $var->delete(true);
                        }

                        update_post_meta($product_id, "_a2w_skip_meta", $tmp_skip_meta);
                    }

                    $results = $wpdb->get_results($wpdb->prepare( "SELECT p.ID FROM $wpdb->posts p INNER JOIN $wpdb->postmeta pm ON (p.ID=pm.post_id AND pm.meta_key='external_variation_id') WHERE post_parent = %d and post_type='product_variation' GROUP BY p.ID ORDER BY p.post_date desc", $product_id), ARRAY_N);
                    $old_variations = array_map(function($v){return $v[0];}, $results);

                    $total_stock = 0;
                    $variation_images = array();

                    foreach ($variations['variations'] as $variation) {
                        $old_vid = $wpdb->get_row($wpdb->prepare( "SELECT p.ID, p.post_status FROM $wpdb->posts p INNER JOIN $wpdb->postmeta pm ON (p.ID=pm.post_id AND pm.meta_key='external_variation_id' AND pm.meta_value=%s) WHERE post_parent = %d and post_type='product_variation' order by post_date desc LIMIT 1", $variation['id'], $product_id), ARRAY_A);

                        if (!$old_vid) {
                            if (in_array($variation['id'], $product['skip_vars'])) {
                                continue;
                            }
                            $tmp_variation = array(
                                'post_title' => 'Product #' . $product_id . ' Variation',
                                'post_content' => '',
                                'post_status' => in_array($variation['id'], $product['skip_vars']) ? 'private' : 'publish',
                                'post_parent' => $product_id,
                                'post_type' => 'product_variation',
                                'meta_input' => array(
                                    'external_variation_id' => $variation['id'],
                                    '_sku' => $variation['sku'],
                                ),
                            );

                            $variation_id = wp_insert_post($tmp_variation);

                            $aliexpress_sku_props_id_arr = array();
                            foreach ($variation['attributes'] as $cur_var_attr) {
                                foreach ($variations['attributes'] as $attr) {
                                    if (isset($attr['value'][$cur_var_attr])) {
                                        $aliexpress_sku_props_id_arr[] = isset($attr['value'][$cur_var_attr]['original_id']) ? $attr['value'][$cur_var_attr]['original_id'] : $attr['value'][$cur_var_attr]['id'];
                                        break;
                                    }
                                }
                            }

                            $aliexpress_sku_props_id = $aliexpress_sku_props_id_arr ? implode(";", $aliexpress_sku_props_id_arr) : "";

                            if ($aliexpress_sku_props_id) {
                                update_post_meta($variation_id, '_aliexpress_sku_props', $aliexpress_sku_props_id);
                            }

                            $variation_attribute_list = array();
                            foreach ($variation['attributes'] as $va) {
                                $attr_tax = "";
                                $attr_value = "";
                                foreach ($variations['attributes'] as $attr_key => $attr) {
                                    $tmp_name = sanitize_title($attr['name']);

                                    foreach ($attr['value'] as $val) {
                                        if ($val['id'] == $va) {
                                            $attr_tax = $attr['tax'];
                                            $attr_value = $attr['attribute_taxonomies'] ? sanitize_title($this->helper->cleanTaxonomyName(htmlspecialchars($val['name'], ENT_NOQUOTES), false)) : $val['name'];
                                            // build original variations attributes
                                            if (!isset($original_variations_attributes[$tmp_name])) {
                                                $original_variations_attributes[$tmp_name] = array('original_attribute_id' => $attr['id'], 'current_name' => $attr['name'], 'name' => $attr['name'], 'values' => array());
                                            }
                                            $original_variations_attributes[$tmp_name]['values'][$val['id']] = array(
                                                'id' => $val['id'],
                                                'name' => $val['name'],
                                                'oroginal_id' => isset($val['src_id']) ? $variations['attributes'][$attr_key]['value'][$val['src_id']]['id'] : $val['id'],
                                                'oroginal_name' => isset($val['src_id']) ? $variations['attributes'][$attr_key]['value'][$val['src_id']]['name'] : $val['name'],
                                            );
                                            break;
                                        }
                                    }
                                    if ($attr_tax && $attr_value) {
                                        break;
                                    }
                                }

                                if ($attr_tax && $attr_value) {
                                    $variation_attribute_list[] = array('key' => ('attribute_' . $attr_tax), 'value' => $attr_value);

                                    // collect used variation attribute values
                                    if (isset($used_variation_attributes[$attr_tax])) {
                                        $used_variation_attributes[$attr_tax]['values'][] = $attr_value;
                                    }
                                }
                            }

                            foreach ($variation_attribute_list as $vai) {
                                update_post_meta($variation_id, sanitize_title($vai['key']), $vai['value']);
                            }

                            // upload set variation image
                            if (isset($variation['image']) && $variation['image']) {
                                $thumb_id = $this->attachment_model->create_attachment($product_id, $variation['image'], array('inner_post_id' => $variation_id, 'title' => null, 'alt' => null, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                                set_post_thumbnail($variation_id, $thumb_id);
                            }
                        } else {
                            $variation_id = $old_vid['ID'];
                            
                            if($old_vid['post_status'] === 'trash'){
                                wp_untrash_post($variation_id);
                            }

                            $aliexpress_sku_props_id = get_post_meta($variation_id, '_aliexpress_sku_props', true);
                            $aliexpress_sku_props_id_arr = $aliexpress_sku_props_id ? explode(";", $aliexpress_sku_props_id) : array();

                            foreach ($used_variation_attributes as $attr_tax => $v) {
                                $tmp_attr_name = 'attribute_' . sanitize_title($attr_tax);
                                if ($attr_value = get_post_meta($variation_id, $tmp_attr_name, true)) {
                                    // collect used variation attribute values
                                    $used_variation_attributes[$attr_tax]['values'][] = $attr_value;

                                    // if user change variation atrributes values, then need update swatch(if new swatch not exist)
                                    $curr_swatch_value_id = md5(sanitize_title(strtolower($attr_value)));
                                    foreach ($aliexpress_sku_props_id_arr as $var_attr_id) {
                                        foreach ($variations['attributes'] as $external_attr) {
                                            if ($external_attr['tax'] === $attr_tax && isset($external_attr['value'][$var_attr_id]) && isset($external_attr['value'][$var_attr_id]['swatch_value_id'])) {
                                                $swatch_id = $external_attr['swatch_id'];
                                                $swatch_value_id = $external_attr['value'][$var_attr_id]['swatch_value_id'];

                                                if ($curr_swatch_value_id != $swatch_value_id && !isset($swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id])) {
                                                    if (isset($old_swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id])) {
                                                        $swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id] = $old_swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id];
                                                        unset($swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]);
                                                    } else if (isset($old_swatch_type_options[$swatch_id]['attributes'][$swatch_value_id])) {
                                                        $swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id] = $old_swatch_type_options[$swatch_id]['attributes'][$swatch_value_id];
                                                        unset($swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]);
                                                    } else if (isset($swatch_type_options[$swatch_id]['attributes'][$swatch_value_id])) {
                                                        $swatch_type_options[$swatch_id]['attributes'][$curr_swatch_value_id] = $swatch_type_options[$swatch_id]['attributes'][$swatch_value_id];
                                                        unset($swatch_type_options[$swatch_id]['attributes'][$swatch_value_id]);
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    // build original variations attributes
                                    $tmp_name = (strpos($tmp_attr_name, 'attribute_pa_') === 0) ? substr($tmp_attr_name, 13) : substr($tmp_attr_name, 10);
                                    if (!isset($original_variations_attributes[$tmp_name])) {
                                        $original_variations_attributes[$tmp_name] = array('original_attribute_id' => $v['original_attribute_id'], 'current_name' => urldecode($tmp_name), 'name' => urldecode($tmp_name));
                                    } else {
                                        $original_variations_attributes[$tmp_name]['original_attribute_id'] = $v['original_attribute_id'];
                                    }
                                }
                            }

                            // A2W_FIX_RELOAD_IMAGES - special flag (for update only), if variation images is disapear, reload it.
                            if (a2w_check_defined('A2W_FIX_RELOAD_IMAGES') && isset($variation['image']) && $variation['image']) {
                                $old_thumb_id = get_post_thumbnail_id($variation_id);
                                if ($old_thumb_id) {
                                    wp_delete_attachment($old_thumb_id, true);
                                    delete_post_meta($variation_id, '_thumbnail_id');
                                }

                                $thumb_id = $this->attachment_model->create_attachment($product_id, $variation['image'], array('inner_post_id' => $variation_id, 'title' => null, 'alt' => null, 'check_duplicate' => true, 'edit_images' => !empty($product['tmp_edit_images']) ? $product['tmp_edit_images'] : array()));
                                set_post_thumbnail($variation_id, $thumb_id);
                            }
                        }

                        foreach ($old_variations as $k => $id) {
                            if (intval($id) == intval($variation_id)) {
                                unset($old_variations[$k]);
                            }
                        }

                        if (!empty($variation['country_code'])) {
                            update_post_meta($variation_id, '_a2w_country_code', $variation['country_code']);
                        }

                        $tmp_quantity = intval($variation['quantity']);

                        if ($woocommerce_manage_stock === 'yes') {
                            update_post_meta($variation_id, '_manage_stock', 'yes');
                            update_post_meta($variation_id, '_stock_status', $tmp_quantity ? 'instock' : 'outofstock');

                            if (!$old_vid || !$product['disable_var_quantity_change']) {
                                update_post_meta($variation_id, '_stock', $tmp_quantity);
                            }
                        } else {
                            update_post_meta($variation_id, '_stock_status', $tmp_quantity ? 'instock' : 'outofstock');
                            delete_post_meta($variation_id, '_manage_stock');
                            delete_post_meta($variation_id, '_stock');
                        }

                        $total_stock += $tmp_quantity;

                        if (!$old_vid || !$product['disable_var_price_change']) {
                            $this->update_price($variation_id, $variation);
                        }
                    }

                    update_post_meta($product_id, '_a2w_original_variations_attributes', $original_variations_attributes);

                    // update priduct swatches
                    update_post_meta($product_id, '_swatch_type_options', $swatch_type_options); //+
                    update_post_meta($product_id, '_swatch_type', 'pickers'); //+
                    update_post_meta($product_id, '_swatch_size', 'swatches_image_size'); //+
                    // delete old variations
                    $not_available_product_status = a2w_get_setting('not_available_product_status');
                    foreach ($old_variations as $variation_id) {
                        if ($not_available_product_status === 'trash') {
                            wp_delete_post($variation_id);
                        } else if ($not_available_product_status === 'outofstock') {
                            if ($woocommerce_manage_stock === 'yes') {
                                update_post_meta($variation_id, '_manage_stock', 'yes');
                                update_post_meta($variation_id, '_stock_status', 'outofstock');
                                delete_post_meta($variation_id, '_stock');
                            } else {
                                update_post_meta($variation_id, '_stock_status', 'outofstock');
                                delete_post_meta($variation_id, '_manage_stock');
                                delete_post_meta($variation_id, '_stock');
                            }
                        }
                    }

                    // for simple variations attributes, update atributes values (save only used values)
                    $need_update = false;
                    foreach ($used_variation_attributes as $attr_tax => $uva) {
                        if (!$uva['attribute_taxonomies'] && isset($attributes[$attr_tax])) {
                            $new_attr_values = array_unique($uva['values']);
                            asort($new_attr_values);
                            $attributes[$attr_tax]['value'] = implode("|", $new_attr_values);
                            if ($new_attr_values) {
                                $need_update = true;
                            }
                        }
                    }
                    if ($need_update) {
                        update_post_meta($product_id, '_product_attributes', $attributes);
                    }

                    // update total product stock
                    if ($woocommerce_manage_stock === 'yes') {
                        update_post_meta($product_id, '_manage_stock', 'yes');
                        update_post_meta($product_id, '_stock_status', intval($total_stock) ? 'instock' : 'outofstock');

                        if (!$product['disable_var_quantity_change']) {
                            update_post_meta($product_id, '_stock', intval($total_stock));
                        }
                    } else {
                        delete_post_meta($product_id, '_manage_stock');
                        delete_post_meta($product_id, '_stock_status');
                        delete_post_meta($product_id, '_stock');
                    }

                    WC_Product_Variable::sync($product_id);
                    WC_Product_Variable::sync_stock_status($product_id);
                }
            }
            return $result;
        }

        public function update_order($order_id, $data = array()) {
            $post = get_post($order_id);
            if ($post && $post->post_type === 'shop_order') {
                if (!empty($data['meta']) && is_array($data['meta'])) {
                    foreach ($data['meta'] as $key => $val) {
                        update_post_meta($order_id, $key, $val);
                    }
                }
            }
        }

        public function get_fulfilled_orders_data() {
            global $wpdb;
            $result = $wpdb->get_results("SELECT pm1.meta_value as ext_order_id, pm1.post_id as order_id FROM {$wpdb->postmeta} as pm1 LEFT JOIN (SELECT `post_id` FROM {$wpdb->postmeta} WHERE `meta_key` = '_a2w_tracking_code') as pm2 ON (pm1.post_id=pm2.post_id) WHERE pm1.meta_key = '_a2w_external_order_id' AND pm2.post_id is null AND pm1.meta_value <> '' ");
            return $result;
        }

        public function get_fulfilled_orders_count() {
            global $wpdb;
            $result = $wpdb->get_var("SELECT COUNT(*) as count FROM {$wpdb->postmeta} as pm1 LEFT JOIN (SELECT `post_id` FROM {$wpdb->postmeta} WHERE `meta_key` = '_a2w_tracking_code') as pm2 ON (pm1.post_id=pm2.post_id) WHERE pm1.meta_key = '_a2w_external_order_id' AND pm2.post_id is null AND pm1.meta_value <> '' ");
            return $result;
        }

        public function save_tracking_code($order_id, $tracking_codes) {
            $result = A2W_ResultBuilder::buildOk();

            try {
                $order = new WC_Order($order_id);
            } catch (Exception $e) {
                $order = false;
            }
            if (!$order) {
                $result = A2W_ResultBuilder::buildError(_x('Didn`t find the Woocommerce order №', 'Error text', 'ali2woo') . $order_id);
            } else {
                $curr_tracking_codes = get_post_meta($order_id, '_a2w_tracking_code');
                if (!empty($curr_tracking_codes)) {
                    $result = A2W_ResultBuilder::buildError(_x('The order has already tracking codes. Please check them on the Order Edit page', 'Error text', 'ali2woo'));
                } else {
                    foreach ($tracking_codes as $code_value) {
                        add_post_meta($order_id, '_a2w_tracking_code', trim(preg_replace('/\s+/', '', $code_value)));
                    }
                    $tracking_code_order_status = a2w_get_setting('tracking_code_order_status');
                    if ($tracking_code_order_status) {
                        $order->update_status($tracking_code_order_status);
                    }
                }
            }

            return $result;
        }

        public function get_sorted_products_ids($sort_type, $ids_count, $compare = false) {
            $result = array();

            $ids0 = get_posts(array(
                'post_type' => 'product',
                'fields' => 'ids',
                'numberposts' => $ids_count,
                'meta_query' => array(
                    array(
                        'key' => '_a2w_import_type',
                        'value' => 'a2w'
                    ),
                    array(
                        'key' => $sort_type,
                        'compare' => 'NOT EXISTS'
                    )
                )
            ));

            foreach ($ids0 as $id) {
                $result[] = $id;
            }

            if (($ids_count - count($result)) > 0) {

                $meta_query = array(
                    array(
                        'key' => '_a2w_import_type',
                        'value' => 'a2w'
                    )
                );

                if ($compare) {
                    if (is_array($compare)) {
                        if (isset($compare['value']) && isset($compare['compare'])) {
                            $meta_query[] = array('key' => $sort_type, 'value' => $compare['value'], 'compare' => $compare['compare']);
                        }
                    } else {
                        $meta_query[] = array('key' => $sort_type, 'value' => $compare);
                    }
                }

                $res = get_posts(array(
                    'post_type' => 'product',
                    'fields' => 'ids',
                    'numberposts' => ($ids_count - count($result)),
                    'meta_query' => $meta_query,
                    'order' => 'ASC',
                    'orderby' => 'meta_value',
                    'meta_key' => $sort_type,
                    'suppress_filters' => false
                ));

                foreach ($res as $id) {
                    $result[] = $id;
                }
            }
            return $result;
        }

        public function get_products_ids($page, $products_per_page) {
            $result = array();

            $ids0 = get_posts(array(
                'post_type' => 'product',
                'fields' => 'ids',
                'offset' => $page * $products_per_page,
                'posts_per_page' => $products_per_page,
                'meta_query' => array(
                    array(
                        'key' => '_a2w_import_type',
                        'value' => 'a2w'
                    )
                )
            ));
            foreach ($ids0 as $id) {
                $result[] = $id;
            }
            return $result;
        }

        public function get_products_count() {
            global $wpdb;
            return $wpdb->get_var("SELECT count(DISTINCT post_id) from $wpdb->postmeta WHERE meta_key = '_a2w_import_type' and meta_value='a2w'");
        }

        function get_product_external_id($post_id) {
            $external_id = '';
            $post = get_post($post_id);
            if ($post) {
                if ($post->post_type === 'product') {
                    $external_id = get_post_meta($post_id, "_a2w_external_id", true);
                } else if ($post->post_type === 'product_variation') {
                    $external_id = get_post_meta($post->post_parent, "_a2w_external_id", true);
                }
            }
            return $external_id;
        }

        function get_product_by_post_id($post_id, $with_vars = true) {
            $product = array();

            $external_id = get_post_meta($post_id, "_a2w_external_id", true);
            if ($external_id) {
                $woocommerce_manage_stock = get_option('woocommerce_manage_stock', 'no');

                $product = array(
                    'id' => $external_id,
                    'post_id' => $post_id,
                    'url' => get_post_meta($post_id, "_a2w_original_product_url", true),
                    'affiliate_url' => get_post_meta($post_id, "_a2w_product_url", true),
                    'seller_url' => get_post_meta($post_id, "_a2w_seller_url", true),
                    'import_type' => get_post_meta($post_id, "_a2w_import_type", true),
                );

                $cats = wp_get_object_terms($post_id, 'product_cat');
                if (!is_wp_error($cats) && $cats) {
                    $product['category_id'] = $cats[0]->term_id;
                }

                $price = get_post_meta($post_id, "_aliexpress_price", true);
                $regular_price = get_post_meta($post_id, "_aliexpress_regular_price", true);
                if ($price || $regular_price) {
                    $product['price'] = $price ? $price : $regular_price;
                    $product['regular_price'] = $regular_price ? $regular_price : $price;
                    $product['discount'] = 100 - round($product['price'] * 100 / $product['regular_price']);
                }

                $price = get_post_meta($post_id, "_price", true);
                $regular_price = get_post_meta($post_id, "_regular_price", true);
                if ($price || $regular_price) {
                    $product['calc_price'] = $price ? $price : $regular_price;
                    $product['calc_regular_price'] = $regular_price ? $regular_price : $price;
                }

                if ($woocommerce_manage_stock === 'yes') {
                    $product['quantity'] = get_post_meta($post_id, "_stock", true);
                } else {
                    $product['quantity'] = get_post_meta($post_id, '_stock_status', true) === 'outofstock' ? 0 : 1;
                }

                $original_product_url = get_post_meta($post_id, "_a2w_original_product_url", true);
                $product['original_product_url'] = $original_product_url ? $original_product_url : 'www.aliexpress.com/item//' . $product['id'] . '.html';

                $availability_meta = get_post_meta($post_id, "_a2w_availability", true);
                $product['availability'] = $availability_meta ? filter_var($availability_meta, FILTER_VALIDATE_BOOLEAN) : true;

                $a2w_skip_meta = get_post_meta($post_id, "_a2w_skip_meta", true);

                $product['skip_vars'] = $a2w_skip_meta && !empty($a2w_skip_meta['skip_vars']) ? $a2w_skip_meta['skip_vars'] : array();
                $product['skip_images'] = $a2w_skip_meta && !empty($a2w_skip_meta['skip_images']) ? $a2w_skip_meta['skip_images'] : array();


                $product['disable_sync'] = get_post_meta($post_id, "_a2w_disable_sync", true);
                $product['disable_var_price_change'] = get_post_meta($post_id, "_a2w_disable_var_price_change", true);
                $product['disable_var_quantity_change'] = get_post_meta($post_id, "_a2w_disable_var_quantity_change", true);

                $product['sku_products']['attributes'] = array();
                $product['sku_products']['variations'] = array();
                if ($with_vars) {
                    $args = array('post_parent' => $post_id, 'post_type' => 'product_variation', 'numberposts' => -1, 'post_status' => 'any');
                    $variations = get_children($args);

                    if ($variations) {
                        foreach ($variations as $variation) {
                            $var = array('id' => get_post_meta($variation->ID, "external_variation_id", true), 'attributes' => array());

                            $price = get_post_meta($variation->ID, "_aliexpress_price", true);
                            $regular_price = get_post_meta($variation->ID, "_aliexpress_regular_price", true);
                            if ($price || $regular_price) {
                                $var['price'] = $price ? $price : $regular_price;
                                $var['regular_price'] = $regular_price ? $regular_price : $price;
                                $var['discount'] = 100 - round($var['price'] * 100 / $var['regular_price']);
                            }

                            $price = get_post_meta($variation->ID, "_price", true);
                            $regular_price = get_post_meta($variation->ID, "_regular_price", true);
                            if ($price || $regular_price) {
                                $var['calc_price'] = $price ? $price : $regular_price;
                                $var['calc_regular_price'] = $regular_price ? $regular_price : $price;
                            }
                            if ($woocommerce_manage_stock === 'yes') {
                                $var['quantity'] = get_post_meta($variation->ID, "_stock", true);
                            } else {
                                $var['quantity'] = get_post_meta($variation->ID, '_stock_status', true) === 'outofstock' ? 0 : 1;
                            }

                            $product['sku_products']['variations'][] = $var;
                        }
                    } else {
                        $var = array('id' => $external_id . "-1", 'attributes' => array());
                        if (isset($product['price'])) {
                            $var['price'] = $product['price'];
                        }
                        if (isset($product['regular_price'])) {
                            $var['regular_price'] = $product['regular_price'];
                        }
                        if (isset($product['discount'])) {
                            $var['discount'] = $product['discount'];
                        }
                        if (isset($product['calc_price'])) {
                            $var['calc_price'] = $product['calc_price'];
                        }
                        if (isset($product['calc_regular_price'])) {
                            $var['calc_regular_price'] = $product['calc_regular_price'];
                        }
                        if (isset($product['quantity'])) {
                            $var['quantity'] = $product['quantity'];
                        }

                        $product['sku_products']['variations'][] = $var;
                    }
                }
            }

            return $product;
        }

        public function get_product_id_by_external_id($external_id) {
            global $wpdb;
            return $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $external_id));
        }

        public function get_product_tags($search = '') {
            $tags = get_terms('product_tag', array('search' => $search, 'hide_empty' => false));
            if (is_wp_error($tags)) {
                return array();
            } else {
                $result_tags = array();
                foreach ($tags as $tag) {
                    $result_tags[] = $tag->name;
                }
                return $result_tags;
            }
        }

        public function get_categories() {
            $categories = get_terms("product_cat", array('hide_empty' => 0, 'hierarchical' => true));
            if (is_wp_error($categories)) {
                return array();
            } else {
                $categories = json_decode(json_encode($categories), TRUE);
                $categories = $this->build_categories_tree($categories, 0);
                return $categories;
            }
        }

        private function build_categories_tree($all_cats, $parent_cat, $level = 1) {
            $res = array();
            foreach ($all_cats as $c) {
                if ($c['parent'] == $parent_cat) {
                    $c['level'] = $level;
                    $res[] = $c;
                    $child_cats = $this->build_categories_tree($all_cats, $c['term_id'], $level + 1);
                    if ($child_cats) {
                        $res = array_merge($res, $child_cats);
                    }
                }
            }
            return $res;
        }

    }

}
