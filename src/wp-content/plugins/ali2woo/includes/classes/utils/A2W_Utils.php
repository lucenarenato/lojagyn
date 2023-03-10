<?php

/**
 * Description of A2W_Utils
 *
 * @author Andrey
 */
if (!class_exists('A2W_Utils')) {

    class A2W_Utils {

        public static function wcae_strack_active(){
            return in_array( 'woocommerce_aliexpress_shipment_tracking/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ); 
        }
        
        public static function clear_url($url) {
            if ($url) {
                $parts = parse_url($url);
                $res = '';
                if (isset($parts['scheme'])) {
                    $res .= $parts['scheme'] . '://';
                }
                if (isset($parts['host'])) {
                    $res .= $parts['host'];
                }
                if (isset($parts['path'])) {
                    $res .= $parts['path'];
                }
                return $res;
            }
            return '';
        }

        /**
         * Get size information for all currently-registered image sizes.
         * List available image sizes with width and height following
         *
         * @global $_wp_additional_image_sizes
         * @uses   get_intermediate_image_sizes()
         * @return array $sizes Data for all currently-registered image sizes.
         */
        public function get_image_sizes() {
            global $_wp_additional_image_sizes;

            $sizes = array();

            foreach (get_intermediate_image_sizes() as $_size) {
                if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
                    $sizes[$_size]['width'] = get_option("{$_size}_size_w");
                    $sizes[$_size]['height'] = get_option("{$_size}_size_h");
                    $sizes[$_size]['crop'] = (bool) get_option("{$_size}_crop");
                } elseif (isset($_wp_additional_image_sizes[$_size])) {
                    $sizes[$_size] = array(
                        'width' => $_wp_additional_image_sizes[$_size]['width'],
                        'height' => $_wp_additional_image_sizes[$_size]['height'],
                        'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                    );
                }
            }

            return $sizes;
        }

        /**
         * Get size information for a specific image size.
         *
         * @uses   get_image_sizes()
         * @param  string $size The image size for which to retrieve data.
         * @return bool|array $size Size data about an image size or false if the size doesn't exist.
         */
        public function get_image_size($size) {
            $sizes = get_image_sizes();

            if (isset($sizes[$size])) {
                return $sizes[$size];
            }

            return false;
        }

        /**
         * Get the width of a specific image size.
         *
         * @uses   get_image_size()
         * @param  string $size The image size for which to retrieve data.
         * @return bool|string $size Width of an image size or false if the size doesn't exist.
         */
        public function get_image_width($size) {
            if (!$size = get_image_size($size)) {
                return false;
            }

            if (isset($size['width'])) {
                return $size['width'];
            }

            return false;
        }

        /**
         * Get the height of a specific image size.
         *
         * @uses   get_image_size()
         * @param  string $size The image size for which to retrieve data.
         * @return bool|string $size Height of an image size or false if the size doesn't exist.
         */
        public function get_image_height($size) {
            if (!$size = get_image_size($size)) {
                return false;
            }

            if (isset($size['height'])) {
                return $size['height'];
            }

            return false;
        }

        public static function delete_post_images($post_id) {
            global $wpdb;
            $external_id = get_post_meta($post_id, '_a2w_external_id', true);
            if ($external_id || get_post_type($post_id) == 'product_variation') {
                $args = array('post_parent' => $post_id, 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => 'any');
                $childrens = get_children($args);
                if ($childrens) {
                    foreach ($childrens as $attachment) {
                        wp_delete_attachment($attachment->ID, true);
                        $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id = " . $attachment->ID);
                        wp_delete_post($attachment->ID, true);
                    }
                }
                $thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true);
                if ($thumbnail_id && get_post_type($post_id) != 'product_variation') {
                    wp_delete_attachment($thumbnail_id);
                    $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id = " . $thumbnail_id);
                    wp_delete_post($thumbnail_id, true);
                }
            }
        }

        public static function clear_image_url($img_url, $param_str = '') {
            if(substr($img_url, 0, 4) !== "http"){
                $new_src = "https:".$img_url;
            }else{
                $new_src = $img_url;    
            }
            
            $parsed_url = parse_url($img_url);

            if (!empty($parsed_url['scheme']) && !empty($parsed_url['host']) && !empty($parsed_url['path'])) {
                $new_src = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'] . $param_str;
            } else if (empty($parsed_url['scheme']) && empty($parsed_url['host']) && !empty($parsed_url['path'])) {
                $new_src = $parsed_url['path'] . $param_str;
            }
            return $new_src;
        }

        public static function get_all_images_from_product($product) {
            $tmp_all_images = array();

            foreach ($product['images'] as $img) {
                $img_id = md5($img);
                if (!isset($tmp_all_images[$img_id])) {
                    $tmp_all_images[$img_id] = array('image' => $img, 'type' => 'gallery');
                }
            }

            if (!empty($product['sku_products']['variations'])) {
                foreach ($product['sku_products']['variations'] as $var) {
                    if (isset($var['image'])) {
                        $img_id = md5($var['image']);
                        if (!isset($tmp_all_images[$img_id])) {
                            $tmp_all_images[$img_id] = array('image' => $var['image'], 'type' => 'variant');
                        }
                    }
                }
            }

            if (!empty($product['description'])) {
                $desc_images = A2W_Utils::get_images_from_description($product['description']);
                foreach ($desc_images as $img_id => $img) {
                    if (!isset($tmp_all_images[$img_id])) {
                        $tmp_all_images[$img_id] = array('image' => $img, 'type' => 'description');
                    }
                }
            }

            return $tmp_all_images;
        }

        public static function get_images_from_description($description) {
            $description = htmlspecialchars_decode(utf8_decode(htmlentities($description, ENT_COMPAT, 'UTF-8', false)));

            if (function_exists('libxml_use_internal_errors')) { libxml_use_internal_errors(true); }
            $dom = new DOMDocument();
            @$dom->loadHTML($description);
            $dom->formatOutput = true;
            $tags = $dom->getElementsByTagName('img');

            $src_result = array();
            foreach ($tags as $tag) {
                $src_result[md5($tag->getAttribute('src'))] = $tag->getAttribute('src');
            }

            return $src_result;
        }

        public static function normalizeChars($s) {
            $replace = array(
                '??' => '-', '??' => '-', '??' => '-', '??' => '-',
                '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'Ae',
                '??' => 'B',
                '??' => 'C', '??' => 'C', '??' => 'C',
                '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E',
                '??' => 'G',
                '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I',
                '??' => 'L',
                '??' => 'N', '??' => 'N',
                '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'Oe',
                '??' => 'S', '??' => 'S', '??' => 'S', '??' => 'S',
                '??' => 'T',
                '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'Ue',
                '??' => 'Y',
                '??' => 'Z', '??' => 'Z', '??' => 'Z',
                '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'ae', '??' => 'ae', '??' => 'ae', '??' => 'ae',
                '??' => 'b', '??' => 'b', '??' => 'b', '??' => 'b',
                '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'ch', '??' => 'ch',
                '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'D', '??' => 'd',
                '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e',
                '??' => 'f', '??' => 'f', '??' => 'f',
                '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g',
                '??' => 'h', '??' => 'h', '??' => 'h', '??' => 'h', '??' => 'h', '??' => 'h', '??' => 'h', '??' => 'h',
                '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'ij', '??' => 'ij',
                '??' => 'j', '??' => 'j', '??' => 'j', '??' => 'j', '??' => 'ja', '??' => 'ja', '??' => 'je', '??' => 'je', '??' => 'jo', '??' => 'jo', '??' => 'ju', '??' => 'ju',
                '??' => 'k', '??' => 'k', '??' => 'k', '??' => 'k', '??' => 'k', '??' => 'k', '??' => 'k',
                '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l',
                '??' => 'm', '??' => 'm', '??' => 'm', '??' => 'm',
                '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n',
                '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'oe', '??' => 'oe', '??' => 'oe',
                '??' => 'p', '??' => 'p', '??' => 'p', '??' => 'p',
                '??' => 'q',
                '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r', '??' => 'r',
                '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 's', '??' => 'sch', '??' => 'sch', '??' => 'sh', '??' => 'sh', '??' => 'ss',
                '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '??' => 't', '???' => 'tm',
                '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'ue',
                '??' => 'v', '??' => 'v', '??' => 'v',
                '??' => 'w', '??' => 'w', '??' => 'w',
                '??' => 'y', '??' => 'y', '??' => 'y', '??' => 'y', '??' => 'y', '??' => 'y',
                '??' => 'y', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 'zh', '??' => 'zh'
            );
            return strtr($s, $replace);
        }

    }

}
