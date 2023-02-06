<?php

/**
 * Description of A2W_ImportPageController
 *
 * @author Andrey
 * 
 * @autoload: a2w_init
 */
if (!class_exists('A2W_ImportPageController')) {

    class A2W_ImportPageController extends A2W_AbstractAdminPage {

        private $product_import_model;
        private $woocommerce_model;

        public function __construct() {
            $this->product_import_model = new A2W_ProductImport();
            $this->woocommerce_model = new A2W_Woocommerce();
            
            $products_cnt = count($this->product_import_model->get_product_id_list());

            parent::__construct(__('Import List', 'ali2woo'), __('Import List', 'ali2woo') .' '. ($products_cnt ? ' <span class="update-plugins count-' . $products_cnt . '"><span class="plugin-count">' . $products_cnt . '</span></span>' : ''), 'import', 'a2w_import', 20);

            add_action('wp_ajax_a2w_push_product', array($this, 'ajax_push_product'));
            add_action('wp_ajax_a2w_delete_import_products', array($this, 'ajax_delete_import_products'));
            add_action('wp_ajax_a2w_update_product_info', array($this, 'ajax_update_product_info'));
            add_action('wp_ajax_a2w_update_variation_info', array($this, 'ajax_update_variation_info'));
            add_action('wp_ajax_a2w_link_to_category', array($this, 'ajax_link_to_category'));
            add_action('wp_ajax_a2w_get_all_products_to_import', array($this, 'ajax_get_all_products_to_import'));
            add_action('wp_ajax_a2w_import_images_action', array($this, 'ajax_import_images_action'));
            add_action('wp_ajax_a2w_import_cancel_images_action', array($this, 'ajax_import_cancel_images_action'));
            add_action('wp_ajax_a2w_search_tags', array($this, 'ajax_search_tags'));
            
            add_filter('tiny_mce_before_init', array($this, 'tiny_mce_before_init'));
        }

        public function before_admin_render() {
            if (isset($_REQUEST['delete_id']) && $_REQUEST['delete_id']) {
                if($product = $this->product_import_model->get_product($_REQUEST['delete_id'])){
                    foreach($product['tmp_edit_images'] as $edit_image){
                        if(isset($edit_image['attachment_id'])){
                            wp_delete_attachment($edit_image['attachment_id'], true);
                        }
                    }
                    $this->product_import_model->del_product($_REQUEST['delete_id']);
                }
                wp_redirect(admin_url('admin.php?page=a2w_import'));
            } else if ((isset($_REQUEST['action']) && $_REQUEST['action'] == "delete_all") || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == "delete_all")) {
                $product_ids = $this->product_import_model->get_product_id_list();
                
                foreach($product_ids as $product_id){
                    if($product = $this->product_import_model->get_product($product_id)){
                        foreach($product['tmp_edit_images'] as $edit_image){
                            if(isset($edit_image['attachment_id'])){
                                wp_delete_attachment($edit_image['attachment_id'], true);
                            }
                        }
                    }
                }
                
                $this->product_import_model->del_product($product_ids);

                wp_redirect(admin_url('admin.php?page=a2w_import'));
            } else if ((isset($_REQUEST['action']) && $_REQUEST['action'] == "push_all") || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == "push_all")) {
                // push all

                wp_redirect(admin_url('admin.php?page=a2w_import'));
            } else if (((isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") || (isset($_REQUEST['action2']) && $_REQUEST['action2'] == "delete")) && isset($_REQUEST['gi']) && is_array($_REQUEST['gi']) && $_REQUEST['gi']) {
                $this->product_import_model->del_product($_REQUEST['gi']);

                wp_redirect(admin_url('admin.php?page=a2w_import'));
            }
        }

        public function render($params = array()) {
            $serach_query = !empty($_REQUEST['s'])?$_REQUEST['s']:'';
            $sort_query = !empty($_REQUEST['o'])?$_REQUEST['o']:$this->product_import_model->default_sort();
            
            $product_list = $this->product_import_model->get_product_list(true, $serach_query, $sort_query);
            foreach ($product_list as &$product) {
                
                $tmp_all_images = A2W_Utils::get_all_images_from_product($product);

                if (empty($product['description'])) {
                    $product['description'] = '';
                }

                $product['gallery_images'] = array();
                $product['variant_images'] = array();
                $product['description_images'] = array();

                foreach ($tmp_all_images as $img_id => $img) {
                    if ($img['type'] === 'gallery') {
                        $product['gallery_images'][$img_id] = $img['image'];
                    } else if ($img['type'] === 'variant') {
                        $product['variant_images'][$img_id] = $img['image'];
                    } else if ($img['type'] === 'description') {
                        $product['description_images'][$img_id] = $img['image'];
                    }
                }
                foreach ($product['tmp_copy_images'] as $img_id => $source) {
                    if(isset($tmp_all_images[$img_id])){
                        $product['gallery_images'][$img_id] = $tmp_all_images[$img_id]['image'];
                    }
                }
                
                foreach ($product['tmp_move_images'] as $img_id => $source) {
                    if(isset($tmp_all_images[$img_id])){
                        $product['gallery_images'][$img_id] = $tmp_all_images[$img_id]['image'];
                    }
                }

                if (!isset($product['thumb_id']) && $product['gallery_images']) {
                    $k = array_keys($product['gallery_images']);
                    $product['thumb_id'] = $k[0];
                }

                if (empty($product['sku_products'])) {
                    $product['sku_products'] = array('variations' => array(), 'attributes' => array());
                }
            }

            $paginator = A2W_Paginator::build(count($product_list));
            $product_list = array_slice($product_list, $paginator['per_page'] * ($paginator['cur_page'] - 1), $paginator['per_page']);

            $this->model_put("paginator", $paginator);
            $this->model_put("serach_query", $serach_query);
            $this->model_put("sort_query", $sort_query);
            $this->model_put("sort_list", $this->product_import_model->sort_list());
            $this->model_put("product_list", $product_list);
            $this->model_put("localizator", A2W_AliexpressLocalizator::getInstance());
            $this->model_put("categories", $this->woocommerce_model->get_categories());
            
            $this->include_view("import.php");
        }

        function tiny_mce_before_init($initArray) {
            if ($this->is_current_page()) {
                $initArray['setup'] = 'function(ed) {ed.on("change", function(e) {var product = jQuery(".product[data-id=\'"+e.target.id+"\']");jQuery(product).attr("data-need-update-product", true);waitForFinalEvent(function () {update_product_info({id:e.target.id, description:encodeURIComponent(e.target.getContent())}, function() {jQuery(product).removeAttr("data-need-update-product");});}, 2000, "update_product_description");});}';
            }
            return $initArray;
        }

        public function ajax_push_product() {
            a2w_init_error_handler();

            $result = array("state" => "ok", "message" => "");
            try {
                if (isset($_POST['id']) && $_POST['id']) {
                    $result_objects = array();
                    $product = $this->product_import_model->get_product($_POST['id']);

                    if ($product) {
                        $exist_wc_product_id = $this->woocommerce_model->get_product_id_by_external_id($product['id']);
                        if($exist_wc_product_id){
                            $result = $this->woocommerce_model->upd_product($exist_wc_product_id, $product);
                        }else{
                            $result = $this->woocommerce_model->add_product($product);
                        }
                        
                        if ($result['state'] !== 'error') {
                            unset($product['html']);
                            
                            $result_objects["product"] = $product;

                            $this->product_import_model->del_product($product['id']);
                        
                            $result = A2W_ResultBuilder::buildOk($result_objects);
                        } else {
                            $result = A2W_ResultBuilder::buildError($result['message']);
                        }
                    } else {
                        $result = A2W_ResultBuilder::buildError("Product " . $_POST['id'] . " not find.");
                    }
                } else {
                    $result = A2W_ResultBuilder::buildError("import_product: waiting for ID...");
                }

                restore_error_handler();
            } catch (Exception $e) {
                error_log($e->getTraceAsString());
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }

            echo json_encode($result);

            wp_die();
        }

        public function ajax_delete_import_products() {
            a2w_init_error_handler();
            try {
                if (isset($_POST['ids']) && $_POST['ids']) {
                    $this->product_import_model->del_product($_POST['ids']);
                }
                $result = A2W_ResultBuilder::buildOk();
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            echo json_encode($result);
            wp_die();
        }

        public function ajax_update_product_info() {
            a2w_init_error_handler();
            try {
                if (isset($_POST['id']) && $_POST['id'] && ($product = $this->product_import_model->get_product($_POST['id']))) {
                    if (isset($_POST['title']) && $_POST['title']) {
                        $product['title'] = sanitize_text_field($_POST['title']);
                    }

                    if (isset($_POST['type']) && $_POST['type'] && in_array($_POST['type'], array('simple', 'external'))) {
                        $product['product_type'] = $_POST['type'];
                    }
                    
                    if (isset($_POST['status']) && $_POST['status'] && in_array($_POST['status'], array('publish', 'draft'))) {
                        $product['product_status'] = $_POST['status'];
                    }

                    if (isset($_POST['tags']) && $_POST['tags']) {
                        $product['tags'] = $_POST['tags']?array_map('sanitize_text_field', $_POST['tags']):array();
                    }

                    if (isset($_POST['categories'])) {
                        $product['categories'] = array();
                        if($_POST['categories']){
                            foreach ($_POST['categories'] as $cat_id) {
                                if (intval($cat_id)) {
                                    $product['categories'][] = intval($cat_id);
                                }
                            }
                        }
                        
                    }

                    if (isset($_POST['description'])) {
                        $product['description'] = trim(urldecode($_POST['description']));
                    }

                    if (isset($_POST['skip_vars']) && $_POST['skip_vars']) {
                        $product['skip_vars'] = $_POST['skip_vars'];
                    }

                    if (isset($_POST['skip_images']) && $_POST['skip_images']) {
                        $product['skip_images'] = $_POST['skip_images'];
                    }

                    if (!empty($_POST['no_skip'])) {
                        $product['skip_images'] = array();
                    }

                    if (isset($_POST['thumb'])) {
                        $product['thumb_id'] = $_POST['thumb'];
                    }

                    if (isset($_POST['disable_var_price_change'])) {
                        if (intval($_POST['disable_var_price_change'])) {
                            $product['disable_var_price_change'] = true;
                        } else {
                            $product['disable_var_price_change'] = false;
                        }
                    }
                    
                    if (isset($_POST['disable_var_quantity_change'])) {
                        if (intval($_POST['disable_var_quantity_change'])) {
                            $product['disable_var_quantity_change'] = true;
                        } else {
                            $product['disable_var_quantity_change'] = false;
                        }
                    }

                    $this->product_import_model->upd_product($product);
                    $result = A2W_ResultBuilder::buildOk();
                } else {
                    $result = A2W_ResultBuilder::buildError("update_product_info: waiting for ID...");
                }

                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            echo json_encode($result);
            wp_die();
        }

        public function ajax_update_variation_info() {
            a2w_init_error_handler();
            try {
                if (isset($_POST['id']) && $_POST['id'] && isset($_POST['variations']) && $_POST['variations'] && ($product = $this->product_import_model->get_product($_POST['id']))) {

                    $out_data = array('new_attr_mapping' => array());
                    foreach ($_POST['variations'] as $variation) {
                        foreach ($product['sku_products']['variations'] as &$v) {
                            if ($v['id'] == $variation['variation_id']) {
                                if (isset($variation['regular_price'])) {
                                    $v['calc_regular_price'] = floatval($variation['regular_price']);
                                }
                                if (isset($variation['price'])) {
                                    $v['calc_price'] = floatval($variation['price']);
                                }
                                if (isset($variation['quantity'])) {
                                    $v['quantity'] = intval($variation['quantity']);
                                }

                                if (isset($variation['sku']) && $variation['sku']) {
                                    $v['sku'] = sanitize_text_field($variation['sku']);
                                }

                                if (isset($variation['attributes']) && is_array($variation['attributes'])) {
                                    foreach ($variation['attributes'] as $a) {
                                        foreach ($v['attributes'] as $i => $av) {
                                            if ($av == $a['id']) {
                                                $_attr_id = explode(':', $av);
                                                $attr_id = $_attr_id[0];

                                                $new_name = sanitize_text_field($a['value']);
                                                $tmp_find_id = false;
                                                foreach ($product['sku_products']['attributes'] as $orig_attr) {
                                                    foreach ($orig_attr['value'] as $orig_value) {
                                                        if ($orig_value['name'] === $new_name) {
                                                            $tmp_find_id = $orig_value['id'];
                                                            break;
                                                        }
                                                    }
                                                    if ($tmp_find_id) {
                                                        break;
                                                    }
                                                }

                                                $new_attr_id = $tmp_find_id ? $tmp_find_id : $attr_id . ':' . md5($new_name);
                                                if ($av !== $new_attr_id) {
                                                    $out_data['new_attr_mapping'][] = array('variation_id' => $variation['variation_id'], 'old_attr_id' => $av, 'new_attr_id' => $new_attr_id);
                                                }
                                                foreach ($product['sku_products']['attributes'] as $ind => $orig_attr) {
                                                    if ($orig_attr['id'] == $attr_id) {
                                                        if (!isset($orig_attr['value'][$new_attr_id])) {
                                                            $product['sku_products']['attributes'][$ind]['value'][$new_attr_id] = $product['sku_products']['attributes'][$ind]['value'][$av];
                                                            if(!isset($product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['original_id'])){
                                                                $product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['original_id'] = $product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['id'];
                                                            }
                                                            $product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['id'] = $new_attr_id;
                                                            $product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['name'] = $new_name;
                                                            if (!isset($product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['src_id'])) {
                                                                $product['sku_products']['attributes'][$ind]['value'][$new_attr_id]['src_id'] = $av;
                                                            }
                                                        }
                                                        break;
                                                    }
                                                }

                                                $v['attributes'][$i] = $new_attr_id;
                                                $v['attributes_names'][$i] = sanitize_text_field($a['value']);
                                            }
                                        }
                                    }
                                }

                                break;
                            }
                        }
                    }

                    $this->product_import_model->upd_product($product);

                    $result = A2W_ResultBuilder::buildOk($out_data);
                } else {
                    $result = A2W_ResultBuilder::buildError("update_variation_info: waiting for ID...");
                }

                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            echo json_encode($result);
            wp_die();
        }

        public function ajax_link_to_category() {
            if (!empty($_POST['categories']) && !empty($_POST['ids'])) {
                $new_categories = is_array($_POST['categories']) ? array_map('intval', $_POST['categories']) : array(intval($_POST['categories']));
                $ids = (is_string($_POST['ids']) && $_POST['ids']==='all')?$this->product_import_model->get_product_id_list():(is_array($_POST['ids']) ? $_POST['ids'] : array($_POST['ids']));
                foreach ($ids as $id) {
                    if ($product = $this->product_import_model->get_product($id)) {
                        $product['categories'] = $new_categories;
                        $this->product_import_model->upd_product($product);
                    }
                }
                a2w_set_setting('remember_categories', $new_categories);
            } else if (empty($_POST['categories'])) {
                a2w_del_setting('remember_categories');
            }
            echo json_encode(A2W_ResultBuilder::buildOk());
            wp_die();
        }
        
        public function ajax_get_all_products_to_import() {
            echo json_encode(A2W_ResultBuilder::buildOk(array('ids' => $this->product_import_model->get_product_id_list())));
            wp_die();
        }
        
        public function ajax_import_images_action() {
            a2w_init_error_handler();
            try {
                if (isset($_POST['id']) && $_POST['id'] && ($product = $this->product_import_model->get_product($_POST['id'])) && !empty($_POST['source']) && !empty($_POST['type']) && in_array($_POST['source'], array("description", "variant")) && in_array($_POST['type'], array("copy", "move"))) {
                    if(!empty($_POST['images'])){
                        foreach($_POST['images'] as $image){
                            if($_POST['type'] == 'copy'){
                                $product['tmp_copy_images'][$image] = $_POST['source'];
                            } else if($_POST['type'] == 'move') {
                                $product['tmp_move_images'][$image] = $_POST['source'];
                            }
                        }
                        
                        $this->product_import_model->upd_product($product);    
                    }
                    
                    $result = A2W_ResultBuilder::buildOk();
                } else {
                    $result = A2W_ResultBuilder::buildError("Error in params");
                }
                
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            
            echo json_encode($result);
            wp_die();
        }
        
        public function ajax_import_cancel_images_action() {
            a2w_init_error_handler();
            try {
                if (isset($_POST['id']) && $_POST['id'] && ($product = $this->product_import_model->get_product($_POST['id'])) && !empty($_POST['image']) && !empty($_POST['source']) && !empty($_POST['type']) && in_array($_POST['source'], array("description", "variant")) && in_array($_POST['type'], array("copy", "move"))) {
                    if($_POST['type'] == 'copy'){
                        unset($product['tmp_copy_images'][$_POST['image']]);
                    } else if($_POST['type'] == 'move') {
                        unset($product['tmp_move_images'][$_POST['image']]);
                    }
                    
                    $this->product_import_model->upd_product($product);    
                    
                    $result = A2W_ResultBuilder::buildOk();
                } else {
                    $result = A2W_ResultBuilder::buildError("Error in params");
                }
                
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            
            echo json_encode($result);
            wp_die();
        }
        public function ajax_search_tags() {
            a2w_init_error_handler();
            try {
                $num_in_page = 50;
                $page = !empty($_REQUEST['page'])?intval($_REQUEST['page']):1;
                $search = !empty($_REQUEST['search'])?$_REQUEST['search']:'';
                $result = $this->woocommerce_model->get_product_tags($search);
                $total_count = count($result);
                $result = array_slice($result, $num_in_page*($page-1), $num_in_page);
                
                $result = array(
                    'results'=>array_map(function($o) {return array('id'=>$o, 'text'=>$o);}, $result),
                    'pagination'=>array('more'=>$num_in_page*($page-1)+$num_in_page<$total_count)
                );
                restore_error_handler();
            } catch (Exception $e) {
                $result = A2W_ResultBuilder::buildError($e->getMessage());
            }
            
            echo json_encode($result);
            wp_die();
        }
        

    }

}
