<?php

/* * class
 * Description of A2W_WooCommerceProductEditController
 *
 * @author andrey
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_WooCommerceProductEditController')) {

    class A2W_WooCommerceProductEditController extends A2W_AbstractController {

        private $attachment_model;
        private $product_import_model;

        public function __construct() {
            parent::__construct();
            $this->attachment_model = new A2W_Attachment();
            $this->product_import_model = new A2W_ProductImport();

            //add_action('current_screen', array($this, 'current_screen'));
            //add_action('edit_form_advanced', array($this, 'edit_form_advanced'));
            //add_action('a2w_after_import', array($this, 'edit_form_advanced'));
            //add_action('wp_ajax_a2w_save_image', array($this, 'ajax_save_image'));
            //add_action('wp_ajax_a2w_upload_sticker', array($this, 'ajax_upload_sticker'));
        }

        function current_screen($current_screen) {
            if ($current_screen->in_admin() && ($current_screen->id == 'product' || $current_screen->id == 'ali2woo_page_a2w_import')) {
                wp_enqueue_style('a2w-wc-spectrum-style', A2W()->plugin_url . 'assets/js/spectrum/spectrum.css', array(), A2W()->version);
                wp_enqueue_script('a2w-wc-spectrum-script', A2W()->plugin_url . 'assets/js/spectrum/spectrum.js', array(), A2W()->version);

                wp_enqueue_script('tui-image-editor-fabric', A2W()->plugin_url . 'assets/js/image-editor/fabric.js', array('jquery'), A2W()->version);
                wp_enqueue_script('tui-code-snippet', A2W()->plugin_url . 'assets/js/image-editor/tui-code-snippet.min.js', array('jquery'), A2W()->version);
                wp_enqueue_script('tui-image-editor-FileSaver', A2W()->plugin_url . 'assets/js/image-editor/FileSaver.min.js', array('jquery'), A2W()->version);
                wp_enqueue_script('tui-image-editor', A2W()->plugin_url . 'assets/js/image-editor/tui-image-editor.js', array('jquery'), A2W()->version);

                wp_enqueue_script('a2w-wc-pe-script', A2W()->plugin_url . 'assets/js/wc_pe_script.js', array(), A2W()->version);
                wp_enqueue_style('a2w-wc-pe-style', A2W()->plugin_url . 'assets/css/wc_pe_style.css', array(), A2W()->version);

                $data = array(
                    'a2w_cdn_url' => A2W()->plugin_url . 'includes/cdn.php',
                );

                wp_localize_script('a2w-wc-pe-script', 'a2w_wc_pe_script_data', $data);
            }
        }

        function edit_form_advanced($post) {
            $current_screen = get_current_screen();
            if ($current_screen && $current_screen->in_admin() && ($current_screen->id == 'product' || $current_screen->id == 'ali2woo_page_a2w_import')) {
                $this->include_view('product_edit_photo.php');
            }
        }

        function ajax_save_image() {
            $result = A2W_ResultBuilder::buildOk();
            if (empty($_POST['view']) || !in_array($_POST['view'], array('product', 'import'))) {
                $result = A2W_ResultBuilder::buildError("waiting view...");
            } else if ($_POST['view'] == 'import' && (empty($_POST['product_id']) || !($product = $this->product_import_model->get_product($_POST['product_id'])))) {
                $result = A2W_ResultBuilder::buildError("waiting product_id...");
            } else if (empty($_POST['attachment_id'])) {
                $result = A2W_ResultBuilder::buildError("waiting for attachment_id...");
            } else if (empty($_POST['data'])) {
                $result = A2W_ResultBuilder::buildError("Need data!");
            } else {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                $view = $_POST['view'];

                if ($view == 'product') {
                    $attachment_id = intval($_POST['attachment_id']);
                    $attachment_parent_id = wp_get_post_parent_id($attachment_id);

                    $new_attachment_id = $this->attachment_model->create_attachment_from_data($attachment_parent_id, $_POST['data'], array('inner_post_id' => $attachment_parent_id));
                    if (is_wp_error($new_attachment_id)) {
                        $result = A2W_ResultBuilder::buildError($new_attachment_id->get_error_message($new_attachment_id->get_error_code()));
                    } else {
                        $external_image_url = get_post_meta($attachment_id, '_a2w_external_image_url', true);
                        if ($external_image_url) {
                            update_post_meta($new_attachment_id, '_a2w_external_image_url', $external_image_url);
                        }

                        global $wpdb;
                        $wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value=%d WHERE meta_key='_thumbnail_id' and meta_value=%d", $new_attachment_id, $attachment_id));
                        $rows = $wpdb->get_results("SELECT meta_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key='_product_image_gallery' && meta_value like '%" . intval($attachment_id) . "%'", ARRAY_A);
                        foreach ($rows as $row) {
                            $ids = array_map("intval", explode(",", $row['meta_value']));
                            if (in_array($attachment_id, $ids)) {
                                array_splice($ids, array_search($attachment_id, $ids), 1, $new_attachment_id);
                                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value=%s WHERE meta_id=%d", implode(",", $ids), $row['meta_id']));
                            }
                        }
                        wp_delete_attachment($attachment_id, true);
                    }
                } else if ($view == 'import') {
                    $attachment_id = $_POST['attachment_id'];

                    $new_attachment_id = $this->attachment_model->create_attachment_from_data(0, $_POST['data']);
                    if (is_wp_error($new_attachment_id)) {
                        $result = A2W_ResultBuilder::buildError($new_attachment_id->get_error_message($new_attachment_id->get_error_code()));
                    } else {
                        if (!isset($product['tmp_edit_images'][$attachment_id])) {
                            $product['tmp_edit_images'][$attachment_id] = array();
                        }

                        if (isset($product['tmp_edit_images'][$attachment_id]['attachment_id'])) {
                            wp_delete_attachment($product['tmp_edit_images'][$attachment_id]['attachment_id'], true);
                        }

                        $tmp_all_images = A2W_Utils::get_all_images_from_product($product);

                        $product['tmp_edit_images'][$attachment_id]['attachment_id'] = $new_attachment_id;
                        $product['tmp_edit_images'][$attachment_id]['attachment_url'] = wp_get_attachment_url($new_attachment_id);
                        $product['tmp_edit_images'][$attachment_id]['external_image_url'] = $tmp_all_images[$attachment_id]['image'];

                        $this->product_import_model->save_product($_POST['product_id'], $product);

                        $result = A2W_ResultBuilder::buildOk(array('attachment_url' => $product['tmp_edit_images'][$attachment_id]['attachment_url']));
                    }
                }
            }

            echo json_encode($result);
            wp_die();
        }

        function ajax_upload_sticker() {
            $result = A2W_ResultBuilder::buildOk();

            if ($_FILES) {
                foreach ($_FILES as $file => $array) {
                    if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                        $result = A2W_ResultBuilder::buildError("upload_sticker_error : " . $_FILES[$file]['error']);
                    }else{
                        $movefile = wp_handle_upload($array, array('test_form' => false));
                        if ($movefile && !isset($movefile['error'])) {
                            $result = A2W_ResultBuilder::buildOk(array('sticker_url' => $movefile['url']));
                        } else {
                            $result = A2W_ResultBuilder::buildError("upload_sticker_error: " . $movefile['error']);
                        }
                    }
                }
            }

            echo json_encode($result);
            wp_die();
        }

    }

}

