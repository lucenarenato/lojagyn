<?php

/* * class
 * Description of A2W_AbstractPage
 *
 * @author andrey
 * 
 * @position: 2
 */

if (!class_exists('A2W_AbstractAdminPage')) {

    abstract class A2W_AbstractAdminPage extends A2W_AbstractController {

        private $page_title;
        private $menu_title;
        private $capability;
        private $menu_slug;
        private $menu_as_link;

        public function __construct($page_title, $menu_title, $capability, $menu_slug, $priority = 10, $menu_as_link=false) {
            parent::__construct(A2W()->plugin_path . '/view/');
            
            if(is_admin()){
                $this->init($page_title, $menu_title, $capability, $menu_slug, $priority, $menu_as_link);

                add_action('a2w_admin_assets', array($this, 'admin_register_assets'), 1);

                add_action('a2w_admin_assets', array($this, 'admin_enqueue_assets'), 2);

                add_action('wp_loaded', array($this, 'before_render_action'));

                if ($this->is_current_page() && !A2W_Woocommerce::is_woocommerce_installed() && !has_action('admin_notices', array($this, 'woocomerce_check_error'))) {
                    add_action('admin_notices', array($this, 'woocomerce_check_error'));
                }

                if ($this->is_current_page() && !has_action('admin_notices', array($this, 'global_system_message'))) {
                    add_action('admin_notices', array($this, 'global_system_message'));
                }    
            }
        }
        
        function woocomerce_check_error() {
            echo '<div id="message2222" class="notice error is-dismissible"><p>'.__('Ali2Woo notice! Please install the <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> plugin first.', 'ali2woo').'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
        
        function global_system_message() {
            $system_message = a2w_get_setting('system_message');
            if($system_message && !empty($system_message['message'])){
                $message_class='updated';
                if($system_message['type'] == 'error'){
                    $message_class='error';
                }
                echo '<div id="a2w-system-message" class="notice '.$message_class.' is-dismissible"><p>'.$system_message['message'].'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            }
        }
        

        protected function init($page_title, $menu_title, $capability, $menu_slug, $priority, $menu_as_link) {
            $this->page_title = $page_title;
            $this->menu_title = $menu_title;
            $this->capability = $capability;
            $this->menu_slug = $menu_slug;
            $this->menu_as_link = $menu_as_link;
            add_action('a2w_init_admin_menu', array($this, 'add_submenu_page'), $priority);
        }

        public function add_submenu_page($parent_slug) {
            if($this->menu_as_link){
                add_submenu_page($parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug);
            } else {
                add_submenu_page($parent_slug, $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'render'));
            }
            
        }

        public function before_render_action() {
            if ($this->is_current_page()) {
                $this->before_admin_render();
            }
        }

        public function before_admin_render() {
            
        }

        abstract public function render($params = array());

        public function admin_register_assets() {
            if ($this->is_current_page()) {
                if (!wp_style_is('a2w-admin-style', 'registered')) {
                    wp_register_style('a2w-admin-style', A2W()->plugin_url . 'assets/css/admin_style.css', array(), A2W()->version);
                }
                if (!wp_style_is('a2w-admin-style-new', 'registered')) {
                    wp_register_style('a2w-admin-style-new', A2W()->plugin_url . 'assets/css/admin_style_new.css', array(),  A2W()->version);
                }
                if (!wp_script_is('a2w-admin-script', 'registered')) {
                    wp_register_script('a2w-admin-script', A2W()->plugin_url . 'assets/js/admin_script.js', array('jquery'),  A2W()->version);
                    $lang_data = array();
                    wp_localize_script('a2w-admin-script', 'a2w_common_data', array('baseurl' => A2W()->plugin_url,'lang' => apply_filters('a2w_configure_lang_data', $lang_data), 'lang_cookies'=>A2W_AliexpressLocalizator::getInstance()->getLocaleCookies(false)));
                }
                if (!wp_script_is('a2w-admin-svg', 'registered')) {
                    wp_register_script('a2w-admin-svg', A2W()->plugin_url . 'assets/js/svg.min.js', array('jquery'),  A2W()->version);
                }
                
                /* select2 */
                if (!wp_style_is('a2w-select2-style', 'registered')) {
                    wp_register_style('a2w-select2-style', A2W()->plugin_url . 'assets/js/select2/css/select2.min.css', array(),  A2W()->version);
                }
                if (!wp_script_is('a2w-select2-js', 'registered')) {
                    wp_register_script('a2w-select2-js', A2W()->plugin_url . 'assets/js/select2/js/select2.min.js', array('jquery'),  A2W()->version);
                }
                
                /*jquery.lazyload*/
                if (!wp_script_is('a2w-lazyload-js', 'registered')) {
                    wp_register_script('a2w-lazyload-js', A2W()->plugin_url . 'assets/js/jquery/jquery.lazyload.js', array('jquery'),  A2W()->version);
                }
                
                /* bootstrap */
                if (!wp_style_is('a2w-bootstrap-style', 'registered')) {
                    wp_register_style('a2w-bootstrap-style', A2W()->plugin_url . 'assets/js/bootstrap/css/bootstrap.min.css', array(),  A2W()->version);
                }
                if (!wp_script_is('a2w-bootstrap-js', 'registered')) {
                    wp_register_script('a2w-bootstrap-js', A2W()->plugin_url . 'assets/js/bootstrap/js/bootstrap.min.js', array('jquery'),  A2W()->version);
                }
            }
        }

        public function admin_enqueue_assets($page) {
            if ($this->is_current_page()) {
             
                wp_enqueue_script('jquery-effects-core');
                
                if (!wp_style_is('a2w-admin-style', 'enqueued')) {
                    wp_enqueue_style('a2w-admin-style');
                    wp_style_add_data( 'a2w-admin-style', 'rtl', 'replace' );
                }
                if (!wp_style_is('a2w-admin-style-new', 'enqueued')) {
                    wp_enqueue_style('a2w-admin-style-new');
                }
                if (!wp_script_is('a2w-admin-script', 'enqueued')) {
                    wp_enqueue_script('a2w-admin-script');
                }
                if (!wp_script_is('a2w-admin-svg', 'enqueued')) {
                    wp_enqueue_script('a2w-admin-svg');
                }
                
                /* select2 */
                if (!wp_style_is('a2w-select2-style', 'enqueued')) {
                    wp_enqueue_style('a2w-select2-style');
                }
                if (!wp_script_is('a2w-select2-js', 'enqueued')) {
                    wp_enqueue_script('a2w-select2-js');
                }
                
                /*jquery.lazyload*/
                if (!wp_script_is('a2w-lazyload-js', 'enqueued')) {
                    wp_enqueue_script('a2w-lazyload-js');
                }
                
                /* bootstrap */
                if (!wp_style_is('a2w-bootstrap-style', 'enqueued')) {
                    wp_enqueue_style('a2w-bootstrap-style');
                }
                if (!wp_script_is('a2w-bootstrap-js', 'enqueued')) {
                    wp_enqueue_script('a2w-bootstrap-js');
                }

            }
        }
        
        protected function is_current_page(){
            return /*strpos($_SERVER['REQUEST_URI'], 'wp-admin/admin.php') !== false*/is_admin() && isset($_REQUEST['page']) && $_REQUEST['page'] && $this->menu_slug == $_REQUEST['page'];
        }

    }

}
