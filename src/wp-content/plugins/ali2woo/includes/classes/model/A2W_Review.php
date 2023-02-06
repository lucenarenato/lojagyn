<?php

/**
 * Description of A2W_Review
 *
 * @author MA_GROUP
 */
if (!class_exists('A2W_Review')) {

    class A2W_Review {

        private $aliexpress_loader;
        private $allowed_countries;
        private $attachment_model;
        private $review_translated;
        private $review_load_attributes;
        private $raiting_from;
        private $raiting_to;
        private $max_number_reviews_per_product;

        public function __construct() {
            $this->aliexpress_loader = new A2W_Aliexpress();
            $this->attachment_model = new A2W_Attachment();

            $this->allowed_countries = a2w_get_setting('review_allow_country');
            if (!empty($this->allowed_countries)) {
                $this->allowed_countries = explode(',', $this->allowed_countries);
            }

            $this->review_translated = a2w_get_setting('review_translated');
            $this->review_load_attributes = a2w_get_setting('review_load_attributes');

            $this->raiting_from = intval(a2w_get_setting('review_raiting_from', 1));
            $this->raiting_to = intval(a2w_get_setting('review_raiting_to', 5));

            $tmp = intval(a2w_get_setting('review_max_per_product'));
            $this->max_number_reviews_per_product = ($tmp > 0) ? $tmp : 20;
        }

        /**
         * Get reviews and save in Woocommerce
         * 
         * @param mixed $post_id
         */
        public function load($post_id) {
            $external_id = get_post_meta($post_id, "_a2w_external_id", true);
            if (!$external_id) {
                return false;
            }

            $comment_number = get_comments(array('post_id' => $post_id, 'meta_key' => 'rating', 'count' => true));
            $remaining_comment_number = $this->max_number_reviews_per_product - $comment_number;

            if ($remaining_comment_number > 0) {
                $pageNumber = intval(get_post_meta($post_id, '_a2w_review_page', true));
                $pageNumber = ($pageNumber > 0) ? $pageNumber : 1;

                $res = $this->aliexpress_loader->load_reviews($external_id, $pageNumber, 100);

                if ($res['state'] !== 'error' && !empty($res['reviews'])) {
                    //remove these meta fields from the post to recalculate review values for the product
                    delete_post_meta($post_id, '_wc_average_rating');
                    delete_post_meta($post_id, '_wc_review_count');
                    delete_post_meta($post_id, '_wc_rating_count');

                    $nextPageNumber = ($remaining_comment_number < count($res['reviews'])) ? $pageNumber : ($pageNumber + 1);

                    foreach ($res['reviews'] as $item) {
                        if ($remaining_comment_number === 0) {
                            break;
                        }

                        $rating = $item['buyerEval'] / 20;
                        if ($rating < $this->raiting_from || $rating > $this->raiting_to) {
                            continue;
                        }

                        if (!$this->check_review_country($item)) {
                            continue;
                        }

                        $review_cash = md5($external_id . $item['buyerName'] . $item['buyerFeedback'] . $item['evalDate']);
                        if (get_comments(array('meta_key' => 'a2w_cash', 'meta_value' => $review_cash, 'count' => true)) > 0) {
                            continue;
                        }

                        $tmp_text = ($this->review_translated && isset($item['buyerTranslationFeedback'])) ? $item['buyerTranslationFeedback'] : $item['buyerFeedback'];
                        $tmp_text = trim(str_replace("\\u0000", '', $tmp_text));
                        if ($this->review_load_attributes && isset($item['skuInfo'])) {
                            $tmp_text = $tmp_text . "<br/><br/>" . preg_replace('#([\w\-]+:)#', '<b>$1</b>', str_replace(':', ': ', A2W_PhraseFilter::apply_filter_to_text($item['skuInfo'])));
                            //$tmp_text = $tmp_text . "<br/><br/>" . str_replace(':', ': ', A2W_PhraseFilter::apply_filter_to_text($item['skuInfo']));
                        }
                        $review_text = A2W_PhraseFilter::apply_filter_to_text($tmp_text);

                        $author = A2W_PhraseFilter::apply_filter_to_text($item['buyerName']);

                        $date = date('Y-m-d H:i:s', strtotime($item['evalDate']));

                        $data = array(
                            'comment_post_ID' => $post_id,
                            'comment_author' => $author,
                            'comment_content' => wp_slash($review_text),
                            'comment_date' => $date,
                            'comment_date_gmt' => $date,
                            'comment_approved' => 1,
                        );


                        $comment_id = wp_insert_comment($data);

                        add_comment_meta($comment_id, 'rating', (int) esc_attr($rating), true);
                        add_comment_meta($comment_id, 'a2w_cash', $review_cash, true);
                        add_comment_meta($comment_id, 'a2w_country', $item['buyerCountry'], true);

                        if (a2w_get_setting('review_avatar_import')) {
                            $author_photo = isset($item['buyerHeadPortrait']) ? $item['buyerHeadPortrait'] : false;
                            if ($author_photo !== false) {
                                $photo_id = $this->attachment_model->create_attachment($comment_id, $author_photo);
                                if ($photo_id) {
                                    add_comment_meta($comment_id, 'a2w_avatar', $photo_id, true);
                                }
                            }
                        }

                        $photo_ids = array();

                        if (a2w_get_setting('review_show_image_list')) {
                            $photo_list = !empty($item['images']) ? (is_array($item['images']) ? $item['images'] : array($item['images'])) : array();

                            foreach ($photo_list as $photo) {
                                if ($photo_id = $this->attachment_model->create_attachment($post_id, $photo)) {
                                    $photo_ids[] = $photo_id;
                                }
                            }
                            if ($photo_ids) {
                                add_comment_meta($comment_id, 'a2w_photo_list', $photo_ids, true);
                            }
                        }

                        $remaining_comment_number--;
                    }

                    if ($remaining_comment_number === 0) {
                        update_post_meta($post_id, '_a2w_reviews_last_update', time() + WEEK_IN_SECONDS);
                        update_post_meta($post_id, '_a2w_review_page', 1);
                    } else {
                        update_post_meta($post_id, '_a2w_reviews_last_update', time());
                        update_post_meta($post_id, '_a2w_review_page', $nextPageNumber);
                    }
                } else {
                    if (!empty($res['message'])) {
                        error_log('load_reviews error: ' . $res['message']);
                    }
                    update_post_meta($post_id, '_a2w_reviews_last_update', time() + WEEK_IN_SECONDS);
                    update_post_meta($post_id, '_a2w_review_page', 1);
                }
            }
        }

        private function check_review_country($item) {
            if (empty($this->allowed_countries))
                return true;

            $value = strtoupper($item['flag']);
            if (array_search($value, $this->allowed_countries) !== false)
                return true;

            return false;
        }

        public static function get_all_review_ids() {
            global $wpdb;

            $comments = $wpdb->get_results("SELECT cm.comment_id as comment_id FROM {$wpdb->commentmeta} cm WHERE cm.meta_key = 'a2w_country'");

            return $comments;
        }

        public static function get_product_review_ids($id) {
            global $wpdb;
            $comments = $wpdb->get_results("SELECT c.comment_ID as comment_id FROM {$wpdb->comments} c WHERE c.comment_post_ID = " . intval($id));
            return $comments;
        }

        public static function remove_reviews_by_ids($comments) {
            $comments_count = count($comments);

            if ($comments_count > 0) {

                $comment_ids = '';

                for ($i = 0; $i <= $comments_count - 1; $i++) {

                    $comment_ids .= $comments[$i]->comment_id;
                    if ($i < $comments_count - 1)
                        $comment_ids .= ',';
                }

                global $wpdb;

                //delete reviews
                $query_result = $wpdb->query("DELETE FROM {$wpdb->comments} WHERE comment_ID IN ({$comment_ids})");

                //delete reviews meta
                $query_result = $wpdb->query("DELETE FROM {$wpdb->commentmeta} WHERE comment_id IN ({$comment_ids})");


                //delete product meta related with review
                $query_result = $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_a2w_reviews_last_update' OR  meta_key = '_a2w_review_page' OR meta_key = '_wc_average_rating'");

                //reset review count meta in posts
                $query_result = $wpdb->query("UPDATE {$wpdb->postmeta} SET meta_value = 0 WHERE meta_key = '_wc_review_count'");

                WC_Comments::delete_comments_count_cache();
            }
        }

        public static function get_comment_photos($comment_id) {
            $photos = array();
            if ($photos_meta = get_comment_meta($comment_id, 'a2w_photo_list', true)) {
                if (is_array($photos_meta)) {
                    foreach ($photos_meta as $photo_id) {
                        $full_img = wp_get_attachment_image_src($photo_id, 'full');
                        if ($full_img) {
                            $thumb_img = wp_get_attachment_image_src($photo_id, 'thumbnail');
                            $photos[] = array('image' => $full_img[0], 'thumb' => $thumb_img ? $thumb_img[0] : $full_img[0], 'photo_id' => $photo_id);
                        }
                    }
                } else {
                    $photos = json_decode($photos_meta);
                }
            }
            return $photos;
        }

        public static function save_comment_photos($comment_id, $photo_list) {
            update_comment_meta($comment_id, 'a2w_photo_list', $photo_list);
        }

    }

}

