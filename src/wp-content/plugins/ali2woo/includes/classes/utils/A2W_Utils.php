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
                'ъ' => '-', 'Ь' => '-', 'Ъ' => '-', 'ь' => '-',
                'Ă' => 'A', 'Ą' => 'A', 'À' => 'A', 'Ã' => 'A', 'Á' => 'A', 'Æ' => 'A', 'Â' => 'A', 'Å' => 'A', 'Ä' => 'Ae',
                'Þ' => 'B',
                'Ć' => 'C', 'ץ' => 'C', 'Ç' => 'C',
                'È' => 'E', 'Ę' => 'E', 'É' => 'E', 'Ë' => 'E', 'Ê' => 'E',
                'Ğ' => 'G',
                'İ' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Í' => 'I', 'Ì' => 'I',
                'Ł' => 'L',
                'Ñ' => 'N', 'Ń' => 'N',
                'Ø' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe',
                'Ş' => 'S', 'Ś' => 'S', 'Ș' => 'S', 'Š' => 'S',
                'Ț' => 'T',
                'Ù' => 'U', 'Û' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
                'Ý' => 'Y',
                'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z',
                'â' => 'a', 'ǎ' => 'a', 'ą' => 'a', 'á' => 'a', 'ă' => 'a', 'ã' => 'a', 'Ǎ' => 'a', 'а' => 'a', 'А' => 'a', 'å' => 'a', 'à' => 'a', 'א' => 'a', 'Ǻ' => 'a', 'Ā' => 'a', 'ǻ' => 'a', 'ā' => 'a', 'ä' => 'ae', 'æ' => 'ae', 'Ǽ' => 'ae', 'ǽ' => 'ae',
                'б' => 'b', 'ב' => 'b', 'Б' => 'b', 'þ' => 'b',
                'ĉ' => 'c', 'Ĉ' => 'c', 'Ċ' => 'c', 'ć' => 'c', 'ç' => 'c', 'ц' => 'c', 'צ' => 'c', 'ċ' => 'c', 'Ц' => 'c', 'Č' => 'c', 'č' => 'c', 'Ч' => 'ch', 'ч' => 'ch',
                'ד' => 'd', 'ď' => 'd', 'Đ' => 'd', 'Ď' => 'd', 'đ' => 'd', 'д' => 'd', 'Д' => 'D', 'ð' => 'd',
                'є' => 'e', 'ע' => 'e', 'е' => 'e', 'Е' => 'e', 'Ə' => 'e', 'ę' => 'e', 'ĕ' => 'e', 'ē' => 'e', 'Ē' => 'e', 'Ė' => 'e', 'ė' => 'e', 'ě' => 'e', 'Ě' => 'e', 'Є' => 'e', 'Ĕ' => 'e', 'ê' => 'e', 'ə' => 'e', 'è' => 'e', 'ë' => 'e', 'é' => 'e',
                'ф' => 'f', 'ƒ' => 'f', 'Ф' => 'f',
                'ġ' => 'g', 'Ģ' => 'g', 'Ġ' => 'g', 'Ĝ' => 'g', 'Г' => 'g', 'г' => 'g', 'ĝ' => 'g', 'ğ' => 'g', 'ג' => 'g', 'Ґ' => 'g', 'ґ' => 'g', 'ģ' => 'g',
                'ח' => 'h', 'ħ' => 'h', 'Х' => 'h', 'Ħ' => 'h', 'Ĥ' => 'h', 'ĥ' => 'h', 'х' => 'h', 'ה' => 'h',
                'î' => 'i', 'ï' => 'i', 'í' => 'i', 'ì' => 'i', 'į' => 'i', 'ĭ' => 'i', 'ı' => 'i', 'Ĭ' => 'i', 'И' => 'i', 'ĩ' => 'i', 'ǐ' => 'i', 'Ĩ' => 'i', 'Ǐ' => 'i', 'и' => 'i', 'Į' => 'i', 'י' => 'i', 'Ї' => 'i', 'Ī' => 'i', 'І' => 'i', 'ї' => 'i', 'і' => 'i', 'ī' => 'i', 'ĳ' => 'ij', 'Ĳ' => 'ij',
                'й' => 'j', 'Й' => 'j', 'Ĵ' => 'j', 'ĵ' => 'j', 'я' => 'ja', 'Я' => 'ja', 'Э' => 'je', 'э' => 'je', 'ё' => 'jo', 'Ё' => 'jo', 'ю' => 'ju', 'Ю' => 'ju',
                'ĸ' => 'k', 'כ' => 'k', 'Ķ' => 'k', 'К' => 'k', 'к' => 'k', 'ķ' => 'k', 'ך' => 'k',
                'Ŀ' => 'l', 'ŀ' => 'l', 'Л' => 'l', 'ł' => 'l', 'ļ' => 'l', 'ĺ' => 'l', 'Ĺ' => 'l', 'Ļ' => 'l', 'л' => 'l', 'Ľ' => 'l', 'ľ' => 'l', 'ל' => 'l',
                'מ' => 'm', 'М' => 'm', 'ם' => 'm', 'м' => 'm',
                'ñ' => 'n', 'н' => 'n', 'Ņ' => 'n', 'ן' => 'n', 'ŋ' => 'n', 'נ' => 'n', 'Н' => 'n', 'ń' => 'n', 'Ŋ' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'Ň' => 'n', 'ň' => 'n',
                'о' => 'o', 'О' => 'o', 'ő' => 'o', 'õ' => 'o', 'ô' => 'o', 'Ő' => 'o', 'ŏ' => 'o', 'Ŏ' => 'o', 'Ō' => 'o', 'ō' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'ǒ' => 'o', 'ò' => 'o', 'Ǿ' => 'o', 'Ǒ' => 'o', 'ơ' => 'o', 'ó' => 'o', 'Ơ' => 'o', 'œ' => 'oe', 'Œ' => 'oe', 'ö' => 'oe',
                'פ' => 'p', 'ף' => 'p', 'п' => 'p', 'П' => 'p',
                'ק' => 'q',
                'ŕ' => 'r', 'ř' => 'r', 'Ř' => 'r', 'ŗ' => 'r', 'Ŗ' => 'r', 'ר' => 'r', 'Ŕ' => 'r', 'Р' => 'r', 'р' => 'r',
                'ș' => 's', 'с' => 's', 'Ŝ' => 's', 'š' => 's', 'ś' => 's', 'ס' => 's', 'ş' => 's', 'С' => 's', 'ŝ' => 's', 'Щ' => 'sch', 'щ' => 'sch', 'ш' => 'sh', 'Ш' => 'sh', 'ß' => 'ss',
                'т' => 't', 'ט' => 't', 'ŧ' => 't', 'ת' => 't', 'ť' => 't', 'ţ' => 't', 'Ţ' => 't', 'Т' => 't', 'ț' => 't', 'Ŧ' => 't', 'Ť' => 't', '™' => 'tm',
                'ū' => 'u', 'у' => 'u', 'Ũ' => 'u', 'ũ' => 'u', 'Ư' => 'u', 'ư' => 'u', 'Ū' => 'u', 'Ǔ' => 'u', 'ų' => 'u', 'Ų' => 'u', 'ŭ' => 'u', 'Ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'ű' => 'u', 'Ű' => 'u', 'Ǖ' => 'u', 'ǔ' => 'u', 'Ǜ' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'У' => 'u', 'ǚ' => 'u', 'ǜ' => 'u', 'Ǚ' => 'u', 'Ǘ' => 'u', 'ǖ' => 'u', 'ǘ' => 'u', 'ü' => 'ue',
                'в' => 'v', 'ו' => 'v', 'В' => 'v',
                'ש' => 'w', 'ŵ' => 'w', 'Ŵ' => 'w',
                'ы' => 'y', 'ŷ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ÿ' => 'y', 'Ŷ' => 'y',
                'Ы' => 'y', 'ž' => 'z', 'З' => 'z', 'з' => 'z', 'ź' => 'z', 'ז' => 'z', 'ż' => 'z', 'ſ' => 'z', 'Ж' => 'zh', 'ж' => 'zh'
            );
            return strtr($s, $replace);
        }

    }

}
