<?php

/**
 * Description of A2W_Aliexpress
 *
 * @author Andrey
 */
if (!class_exists('A2W_Aliexpress')) {

    class A2W_Aliexpress {

        private $product_import_model;
        private $account;

        function __construct() {
            $this->product_import_model = new A2W_ProductImport();
            $this->account = A2W_Account::getInstance();
        }

        public function load_products($filter, $page = 1, $per_page = 20, $params = array()) {
            /** @var wpdb $wpdb */
            global $wpdb;

            $products_in_import = $this->product_import_model->get_product_id_list();

            $request_url = A2W_RequestHelper::build_request('get_products', array_merge(array('page' => $page, 'per_page' => $per_page), $filter));
            $request = a2w_remote_get($request_url);

            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else if (intval($request['response']['code']) != 200) {
                $result = A2W_ResultBuilder::buildError($request['response']['code'] . " " . $request['response']['message']);
            } else {
                $result = json_decode($request['body'], true);

                if (isset($result['state']) && $result['state'] !== 'error') {
                    $default_type = a2w_get_setting('default_product_type');
                    $default_status = a2w_get_setting('default_product_status');

                    $tmp_urls = array();

                    foreach ($result['products'] as &$product) {
                        $product['post_id'] = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $product['id']));
                        $product['import_id'] = in_array($product['id'], $products_in_import) ? $product['id'] : 0;
                        $product['product_type'] = $default_type;
                        $product['product_status'] = $default_status;
                        $product['is_affiliate'] = true;

                        if (isset($filter['country']) && $filter['country']) {
                            $product['shipping_to_country'] = $filter['country'];
                        }

                        $tmp_urls[] = $product['url'];
                    }

                    if ($this->account->custom_account) {
                        try {
                            $promotionUrls = $this->get_affiliate_urls($tmp_urls);
                            if (!empty($promotionUrls) && is_array($promotionUrls)) {
                                foreach ($result["products"] as $i => $product) {
                                    foreach ($promotionUrls as $pu) {
                                        if ($pu['url'] == $product['url']) {
                                            $result["products"][$i]['affiliate_url'] = $pu['promotionUrl'];
                                            break;
                                        }
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            foreach ($result['products'] as &$product) {
                                $product['affiliate_url'] = $product['url'];
                            }
                            error_log($e->getMessage());
                        }
                    }
                }
            }
            return $result;
        }

        public function load_reviews($product_id, $page, $page_size = 20, $params = array()) {
            $request_url = A2W_RequestHelper::build_request('get_reviews', array('lang' => A2W_AliexpressLocalizator::getInstance()->language, 'product_id' => $product_id, 'page' => $page, 'page_size' => $page_size));

            $request = a2w_remote_get($request_url);

            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else {
                $result = json_decode($request['body'], true);

                if ($result['state'] !== 'error') {
                    $result = A2W_ResultBuilder::buildOk(array('reviews' => isset($result['reviews']['evaViewList']) ? $result['reviews']['evaViewList'] : array(), 'totalNum' => isset($result['reviews']['totalNum']) ? $result['reviews']['totalNum'] : 0));
                }
            }

            return $result;
        }

        public function load_product($product_id, $params = array()) {
            /** @var wpdb $wpdb */
            global $wpdb;
            $products_in_import = $this->product_import_model->get_product_id_list();

            $request_url = A2W_RequestHelper::build_request('get_product', array('product_id' => $product_id));

            $request = a2w_remote_get($request_url);

            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else {
                $result = json_decode($request['body'], true);

                if ($result['state'] !== 'error') {
                    $result['product']['post_id'] = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_a2w_external_id' AND meta_value='%s' LIMIT 1", $result['product']['id']));
                    $result['product']['import_id'] = in_array($result['product']['id'], $products_in_import) ? $result['product']['id'] : 0;

                    if ($this->account->custom_account) {
                        try {
                            $promotionUrls = $this->get_affiliate_urls($result['product']['url']);
                            if (!empty($promotionUrls) && is_array($promotionUrls)) {
                                $result['product']['affiliate_url'] = $promotionUrls[0]['promotionUrl'];
                            }
                        } catch (Exception $e) {
                            $result['product']['affiliate_url'] = $result['product']['url'];
                            error_log($e->getMessage());
                        }
                    }
                    if (a2w_get_setting('use_random_stock')) {
                        $result['product']['disable_var_quantity_change'] = true;
                        foreach ($result['product']['sku_products']['variations'] as &$variation) {
                            $variation['original_quantity'] = intval($variation['quantity']);
                            $tmp_quantity = rand(intval(a2w_get_setting('use_random_stock_min')), intval(a2w_get_setting('use_random_stock_max')));
                            $tmp_quantity = ($tmp_quantity > $variation['original_quantity']) ? $variation['original_quantity'] : $tmp_quantity;
                            $variation['quantity'] = $tmp_quantity;
                        }
                    }

                    $request_url = 'https://m.aliexpress.com/ajaxapi/productItemDescripitonAjax.do?productId=' . $result['product']['id'] . '&lang=' . A2W_AliexpressLocalizator::getInstance()->language;
                    $response = a2w_remote_get($request_url, array('cookies' => A2W_AliexpressLocalizator::getInstance()->getLocaleCookies()));
                    if (!is_wp_error($response)) {
                        try {
                            $item = json_decode($response['body'], true);
                            if (!empty($item['descResult']['props'])) {
                                $split_attribute_values = a2w_get_setting('split_attribute_values');
                                $attribute_values_separator = a2w_get_setting('attribute_values_separator');

                                $result['product']['attribute'] = array();
                                foreach ($item['descResult']['props'] as $prop) {
                                    if ($split_attribute_values) {
                                        $result['product']['attribute'][] = array('name' => $prop['attrName'], 'value' => array_map('a2w_phrase_apply_filter_to_text', array_map('trim', explode($attribute_values_separator, $prop['attrValue']))));
                                    } else {
                                        $result['product']['attribute'][] = array('name' => $prop['attrName'], 'value' => a2w_phrase_apply_filter_to_text($prop['attrValue']));
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            error_log($e->getMessage());
                        }
                    } else {
                        error_log("Load product attribute error: " . $response->get_error_message($response->get_error_code()));
                    }

                    $result['product']['description'] = '';
                    if (a2w_check_defined('A2W_SAVE_ATTRIBUTE_AS_DESCRIPTION')) {
                        if ($result['product']['attribute'] && count($result['product']['attribute']) > 0) {
                            $result['product']['description'] .= '<table class="shop_attributes"><tbody>';
                            foreach ($result['product']['attribute'] as $attribute) {
                                $result['product']['description'] .= '<tr><th>' . $attribute['name'] . '</th><td><p>' . (is_array($attribute['value']) ? implode(", ", $attribute['value']) : $attribute['value']) . "</p></td></tr>";
                            }
                            $result['product']['description'] .= '</tbody></table>';
                        }
                        // Uncoment if need empty attribute list
                        //$result['product']['attribute'] = array();
                    }

                    if (!a2w_get_setting('not_import_description')) {
                        // alternativ method
                        //https://m.ru.aliexpress.com/item-desc/32797801052.html

                        $request_url = "https://" . (A2W_AliexpressLocalizator::getInstance()->language === 'en' ? "www" : A2W_AliexpressLocalizator::getInstance()->language) . ".aliexpress.com/getDescModuleAjax.htm?productId=" . $result['product']['id'] . "&t=" . (round(microtime(true), 3) * 1000);
                        $response = a2w_remote_get($request_url, array('cookies' => A2W_AliexpressLocalizator::getInstance()->getLocaleCookies()));
                        if (!is_wp_error($response)) {
                            $body = $response['body'];
                            $desc_content = str_replace(array("window.productDescription='", "';"), '', $body);
                            $result['product']['description'] .= $this->clean_description($desc_content);
                        } else {
                            error_log("Load product description error: " . $response->get_error_message($response->get_error_code()));
                        }
                    }

                    $result['product']['description'] = A2W_PhraseFilter::apply_filter_to_text($result['product']['description']);


                    $tmp_all_images = A2W_Utils::get_all_images_from_product($result['product']);

                    $not_import_gallery_images = false;
                    $not_import_variant_images = false;
                    $not_import_description_images = a2w_get_setting('not_import_description_images');

                    $result['product']['skip_images'] = array();
                    foreach ($tmp_all_images as $img_id => $img) {
                        if (!in_array($img_id, $result['product']['skip_images']) && (($not_import_gallery_images && $img['type'] === 'gallery') || ($not_import_variant_images && $img['type'] === 'variant') || ($not_import_description_images && $img['type'] === 'description'))) {
                            $result['product']['skip_images'][] = $img_id;
                        }
                    }
                }
            }

            return $result;
        }

        public function check_affiliate($product_id) {
            $request_url = A2W_RequestHelper::build_request('check_affiliate', array('product_id' => $product_id));
            $request = a2w_remote_get($request_url);
            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else {
                $result = json_decode($request['body'], true);
            }
            return $result;
        }

        public function sync_products($product_ids, $params = array()) {
            $request_params = array('product_id' => implode(',', is_array($product_ids) ? $product_ids : array($product_ids)));
            if (!empty($params['manual_update'])) {
                $request_params['manual_update'] = 1;
            }
            if (!empty($params['pc'])) {
                $request_params['pc'] = $params['pc'];
            }
            $request_url = A2W_RequestHelper::build_request('sync_products', $request_params);
            $request = a2w_remote_get($request_url);
            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else {
                $result = json_decode($request['body'], true);

                $use_random_stock = a2w_get_setting('use_random_stock');
                if ($use_random_stock) {
                    $random_stock_min = intval(a2w_get_setting('use_random_stock_min'));
                    $random_stock_max = intval(a2w_get_setting('use_random_stock_max'));

                    foreach ($result['products'] as &$product) {
                        foreach ($product['sku_products']['variations'] as &$variation) {
                            $variation['original_quantity'] = intval($variation['quantity']);
                            $tmp_quantity = rand($random_stock_min, $random_stock_max);
                            $tmp_quantity = ($tmp_quantity > $variation['original_quantity']) ? $variation['original_quantity'] : $tmp_quantity;
                            $variation['quantity'] = $tmp_quantity;
                        }
                    }
                }

                if ($this->account->custom_account) {
                    $tmp_urls = array();

                    foreach ($result['products'] as $product) {
                        if (!empty($product['url'])) {
                            $tmp_urls[] = $product['url'];
                        }
                    }

                    try {
                        $promotionUrls = $this->get_affiliate_urls($tmp_urls);
                        if (!empty($promotionUrls) && is_array($promotionUrls)) {
                            foreach ($result["products"] as &$product) {
                                foreach ($promotionUrls as $pu) {
                                    if ($pu['url'] == $product['url']) {
                                        $product['affiliate_url'] = $pu['promotionUrl'];
                                        break;
                                    }
                                }
                            }
                        }
                    } catch (Exception $e) {
                        foreach ($result['products'] as &$product) {
                            $product['affiliate_url'] = ''; //set empty to disable update!
                        }
                        error_log($e->getMessage());
                    }
                }

                if (isset($params['manual_update']) && $params['manual_update'] && a2w_check_defined('A2W_FIX_RELOAD_DESCRIPTION') && !a2w_get_setting('not_import_description')) {

                    foreach ($result["products"] as &$product) {
                        $request_url = "https://" . (A2W_AliexpressLocalizator::getInstance()->language === 'en' ? "www" : A2W_AliexpressLocalizator::getInstance()->language) . ".aliexpress.com/getDescModuleAjax.htm?productId=" . $product['id'] . "&t=" . (round(microtime(true), 3) * 1000);
                        $response = a2w_remote_get($request_url, array('cookies' => A2W_AliexpressLocalizator::getInstance()->getLocaleCookies()));
                        if (!is_wp_error($response)) {
                            $body = $response['body'];
                            $desc_content = str_replace(array("window.productDescription='", "';"), '', $body);
                            $product['description'] .= $this->clean_description($desc_content);
                        } else {
                            error_log("Load product description error: " . $response->get_error_message($response->get_error_code()));
                        }

                        $product['description'] = A2W_PhraseFilter::apply_filter_to_text($product['description']);
                    }
                }
            }

            return $result;
        }

        public function load_shipping_info($product_id, $quantity, $country_code, $country_code_form = '') {

            $request_url = A2W_RequestHelper::build_request('get_shipping_info', array('product_id' => $product_id, 'quantity' => $quantity, 'country_code' => $country_code, 'country_code_from' => $country_code_form));
            //error_log($request_url);
            $request = a2w_remote_get($request_url);
            if (is_wp_error($request)) {
                $result = A2W_ResultBuilder::buildError($request->get_error_message());
            } else {
                if (intval($request['response']['code']) == 200) {
                    $result = json_decode($request['body'], true);
                } else {
                    $result = A2W_ResultBuilder::buildError($request['response']['code'] . ' - ' . $request['response']['message']);
                }
            }

            return $result;
        }

        public static function clean_description($description) {
            $html = $description;

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

            $tags = apply_filters('a2w_clean_description_tags', array('script', 'head', 'meta', 'style', 'map', 'noscript', 'object', 'iframe'));

            foreach ($tags as $tag) {
                $elements = $dom->getElementsByTagName($tag);
                for ($i = $elements->length; --$i >= 0;) {
                    $e = $elements->item($i);
                    if ($tag == 'a') {
                        while ($e->hasChildNodes()) {
                            $child = $e->removeChild($e->firstChild);
                            $e->parentNode->insertBefore($child, $e);
                        }
                        $e->parentNode->removeChild($e);
                    } else {
                        $e->parentNode->removeChild($e);
                    }
                }
            }

            if (!in_array('img', $tags)) {
                $elements = $dom->getElementsByTagName('img');
                for ($i = $elements->length; --$i >= 0;) {
                    $e = $elements->item($i);
                    $e->setAttribute('src', add_query_arg('descimg', '1', A2W_Utils::clear_image_url($e->getAttribute('src'))));
                }
            }



            $html = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());

            $html = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $html);
            $html = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $html);
            $html = preg_replace('/(<[^>]+) width=".*?"/i', '$1', $html);
            $html = preg_replace('/(<[^>]+) height=".*?"/i', '$1', $html);
            $html = preg_replace('/(<[^>]+) alt=".*?"/i', '$1', $html);
            $html = preg_replace('/^<!DOCTYPE.+?>/', '$1', str_replace(array('<html>', '</html>', '<body>', '</body>'), '', $html));
            $html = preg_replace("/<\/?div[^>]*\>/i", "", $html);

            $html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', $html);
            $html = preg_replace('/<a[^>]*><\/a>/iU', '', $html); //delete empty A tags
            $html = preg_replace("/<\/?h1[^>]*\>/i", "", $html);
            $html = preg_replace("/<\/?strong[^>]*\>/i", "", $html);
            $html = preg_replace("/<\/?span[^>]*\>/i", "", $html);

            //$html = str_replace(' &nbsp; ', '', $html);
            $html = str_replace('&nbsp;', ' ', $html);
            $html = str_replace('\t', ' ', $html);
            $html = str_replace('  ', ' ', $html);


            $html = preg_replace("/http:\/\/g(\d+)\.a\./i", "https://ae$1.", $html);

            $html = preg_replace("/<[^\/>]*[^td]>([\s]?|&nbsp;)*<\/[^>]*[^td]>/", '', $html); //delete ALL empty tags
            $html = preg_replace('/<td[^>]*><\/td>/iU', '', $html); //delete empty TD tags

            $html = str_replace(array('<img', '<table'), array('<img class="img-responsive"', '<table class="table table-bordered'), $html);
            $html = force_balance_tags($html);

            return html_entity_decode($html, ENT_COMPAT, 'UTF-8');
        }

        public function get_affiliate_urls($urls) {
            if ($this->account->account_type == 'admitad') {
                return A2W_Admitad::getInstance()->getDeeplink($urls);
            } else {
                if (!empty($this->account->account_data['aliexpress']['appkey'])) {
                    $urls_str = "";
                    if (is_array($urls)) {
                        $urls_str = implode(',', $urls);
                    } else {
                        $urls_str = strval($urls);
                    }
                    $request_url = "http://gw.api.alibaba.com/openapi/param2/2/portals.open/api.getPromotionLinks/{$this->account->account_data['aliexpress']['appkey']}?fields=&trackingId={$this->account->account_data['aliexpress']['trackingid']}&urls={$urls_str}";

                    $request = a2w_remote_get($request_url);

                    if (is_wp_error($request)) {
                        throw new Exception($request->get_error_message());
                    } else {
                        $data = json_decode($request['body'], true);
                        if (isset($data['errorCode']) && $data['errorCode'] == 20010000) {
                            return $data['result']['promotionUrls'];
                        } else if (isset($data['errorCode']) && $data['errorCode'] == 20030060) {
                            throw new Exception('Tracking ID input parameter error. Please input correct Tracking ID in the WooImporter Settings.');
                        } else {
                            throw new Exception('get_affiliate_goods: error ' . $data['errorCode']);
                        }
                    }
                } else {
                    /* $urls = is_array($urls) ? $urls : array(strval($urls));
                      $result = array();
                      foreach ($urls as $url) {
                      $result[] = array('url' => $url, 'promotionUrl' => $url);
                      }
                      return $result; */
                    return array();
                }
            }
        }

        public function links_to_affiliate($content) {
            $hrefs = array();
            if (function_exists('libxml_use_internal_errors')) {
                libxml_use_internal_errors(true);
            }
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            $dom->formatOutput = true;
            $tags = $dom->getElementsByTagName('a');
            foreach ($tags as $tag) {
                $hrefs[] = $tag->getAttribute('href');
            }

            try {
                if ($hrefs) {
                    $promotionUrls = $this->get_affiliate_urls($hrefs);
                    if (!empty($promotionUrls) && is_array($promotionUrls)) {
                        foreach ($promotionUrls as $link) {
                            $content = str_replace($link['url'], $link['promotionUrl'], $content);
                        }
                    }
                }
            } catch (Exception $e) {
                
            }
            return $content;
        }

    }

}