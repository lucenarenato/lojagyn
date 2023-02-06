<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_CART_ALL_IN_ONE_Admin_Cart {
	protected $settings, $error;

	public function __construct() {
		$this->settings         = new VI_WOO_CART_ALL_IN_ONE_DATA();
		add_action( 'admin_menu', array( $this, 'admin_menu' ),10 );
		add_action( 'admin_init', array( $this, 'save_settings' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), PHP_INT_MAX );
	}

	public function admin_menu() {
		add_menu_page(
			esc_html__( 'Cart All In One For WooCommerce', 'woo-cart-all-in-one' ),
			esc_html__( 'Cart All In One', 'woo-cart-all-in-one' ),
			'manage_options',
			'woo-cart-all-in-one',
			array( $this, 'settings_callback' ),
			'dashicons-cart',
			2 );
	}
	public function save_settings() {
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
		if ( $page !== 'woo-cart-all-in-one' ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! isset( $_POST['_vi_wcaio_setting_cart'] ) || ! wp_verify_nonce( wc_clean($_POST['_vi_wcaio_setting_cart']), '_vi_wcaio_setting_cart_action' ) ) {
			return;
		}
		if ( ! isset( $_POST['vi-wcaio-save'] ) ) {
			return;
		}
		global $vi_wcaio_settings;
		$map_args_1 = array(
			'sc_enable',
			'sc_mobile_enable',
			'sc_empty_enable',
			'sc_assign_page',
			'mc_enable',
			'mc_mobile_enable',
			'mc_empty_enable',
			'ajax_atc',
			'ajax_atc_notice',
			'ajax_atc_pd_variable',
			'pd_variable_bt_atc_text_enable',
		);
		$map_args_2 = array(
			'pd_variable_bt_atc_text',
		);
		$map_args_3 = array(
			'mc_menu_display',
			'ajax_atc_pd_exclude',
		);
		$args       = array();
		foreach ( $map_args_1 as $item ) {
			$args[ $item ] = isset( $_POST[ $item ] ) ? sanitize_text_field( wp_unslash( $_POST[ $item ] ) ) : '';
		}
		foreach ( $map_args_2 as $item ) {
			$args[ $item ] = isset( $_POST[ $item ] ) ? wp_kses_post( wp_unslash( $_POST[ $item ] ) ) : '';
		}
		foreach ( $map_args_3 as $item ) {
			$args[ $item ] = isset( $_POST[ $item ] ) ? viwcaio_sanitize_fields( $_POST[ $item ] ) : array();
		}
		$args = wp_parse_args( $args, get_option( 'woo_cart_all_in_one_params', $vi_wcaio_settings ) );
		if ( is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ) ) {
			$cache = new WpFastestCache();
			$cache->deleteCache( true );
		}
		$vi_wcaio_settings = $args;
		update_option( 'woo_cart_all_in_one_params', $args );
	}

	public function settings_callback() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$admin          = 'VI_WOO_CART_ALL_IN_ONE_Admin_Settings';
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'Cart All In One For WooCommerce', 'woo-cart-all-in-one' ); ?></h2>
            <div id="vi-wcaio-wrap-message" class="error <?php echo esc_attr( $this->error ? '' : 'vi-wcaio-disabled' ); ?>">
                <p><?php echo esc_html( $this->error ); ?></p>
            </div>
            <div class="vi-ui raised">
                <form class="vi-ui form" method="post">
					<?php
					wp_nonce_field( '_vi_wcaio_setting_cart_action', '_vi_wcaio_setting_cart' );
					?>
                    <div class="vi-ui top tabular vi-ui-main attached menu">
                        <a class="item active" data-tab="sidebar_cart"><?php esc_html_e( 'Sidebar Cart', 'woo-cart-all-in-one' ); ?></a>
                        <a class="item" data-tab="menu_cart"><?php esc_html_e( 'Menu Cart', 'woo-cart-all-in-one' ); ?></a>
                        <a class="item" data-tab="atc_button"><?php esc_html_e( 'Add To Cart Button', 'woo-cart-all-in-one' ); ?></a>
                        <a class="item" data-tab="recently_viewed"><?php esc_html_e( 'Recently Viewed Products', 'woo-cart-all-in-one' ); ?></a>
                    </div>
                    <div class="vi-ui bottom attached tab segment active" data-tab="sidebar_cart">
						<?php
						$sc_enable        = $this->settings->get_params( 'sc_enable' );
						$sc_mobile_enable = $this->settings->get_params( 'sc_mobile_enable' );
						$sc_empty_enable  = $this->settings->get_params( 'sc_empty_enable' );
						$sc_assign_page   = $this->settings->get_params( 'sc_assign_page' );
						?>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="vi-wcaio-sc_enable-checkbox"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="sc_enable" id="vi-wcaio-sc_enable" value="<?php echo esc_attr( $sc_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-sc_enable-checkbox" class="vi-wcaio-sc_enable-checkbox"
											<?php checked( $sc_enable, 1 ); ?>><label></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-sc_mobile_enable-checkbox"><?php esc_html_e( 'Mobile enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="sc_mobile_enable" id="vi-wcaio-sc_mobile_enable" value="<?php echo esc_attr( $sc_mobile_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-sc_mobile_enable-checkbox" class="vi-wcaio-sc_mobile_enable-checkbox"
											<?php checked( $sc_mobile_enable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description"><?php esc_html_e('Display Sidebar Cart on Mobile', 'woo-cart-all-in-one'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label ><?php esc_html_e( 'Enable sidebar cart icon', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <a class="vi-ui button" href="https://1.envato.market/bW20B"
                                       target="_blank"><?php esc_html_e( 'Unlock This Feature', 'woo-cart-all-in-one' ); ?> </a>
                                    <p class="description">
				                        <?php
				                        esc_html_e('Show Sidebar Cart icon on your site', 'woo-cart-all-in-one');
				                        ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-sc_empty_enable-checkbox"><?php esc_html_e( 'Visible empty sidebar cart icon', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="sc_empty_enable" id="vi-wcaio-sc_empty_enable" value="<?php echo esc_attr( $sc_empty_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-sc_empty_enable-checkbox" class="vi-wcaio-sc_empty_enable-checkbox"
											<?php checked( $sc_empty_enable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description">
										<?php esc_html_e( 'Show Sidebar cart even when it is empty', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-sc_assign_page">
										<?php esc_html_e( 'Assign page', 'woo-cart-all-in-one' ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text" name="sc_assign_page" id="vi-wcaio-sc_assign_page" placeholder="<?php esc_html_e( 'Ex: !is_page(array(123,41,20))', 'woo-cart-all-in-one' ); ?>"
                                           value="<?php echo esc_attr( $sc_assign_page ); ?>">
                                    <p class="description"><?php esc_html_e( 'Set pages to display the sidebar cart using', 'woo-cart-all-in-one' ) ?>
                                        <a href="http://codex.wordpress.org/Conditional_Tags"><?php esc_html_e( 'WP\'s conditional tags.', 'woo-cart-all-in-one' ) ?></a>
	                                    <?php esc_html_e( ' The sidebar cart will not work on cart page and checkout page', 'woo-cart-all-in-one' ) ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label ><?php esc_html_e( 'Class/Id to open sidebar cart content', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <a class="vi-ui button" href="https://1.envato.market/bW20B"
                                       target="_blank"><?php esc_html_e( 'Unlock This Feature', 'woo-cart-all-in-one' ); ?> </a>
                                    <p class="description">
				                        <?php
				                        esc_html_e('Adding the 3rd class/id, which allows to open Sidebar Cart content when clicking', 'woo-cart-all-in-one');
				                        ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <h4><?php esc_html_e( 'Checkout on Sidebar Cart', 'woo-cart-all-in-one' ); ?></h4>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label ><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <a class="vi-ui button" href="https://1.envato.market/bW20B"
                                       target="_blank"><?php esc_html_e( 'Unlock This Feature', 'woo-cart-all-in-one' ); ?> </a>
                                    <p class="description">
					                    <?php
					                    esc_html_e('Allow checkout directly on Sidebar Cart without going to checkout page', 'woo-cart-all-in-one');
					                    ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php esc_html_e( 'Design', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
			                        <?php
			                        $url = admin_url( 'customize.php' ) . '?url=' . urlencode( get_site_url() ) . '&autofocus[panel]=vi_wcaio_design';
			                        ?>
                                    <a target="_blank" class="vi-wcaio-customize-url" href="<?php echo esc_attr( esc_url( $url ) ) ?>"><?php esc_html_e( 'Go to design', 'woo-cart-all-in-one' ) ?></a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="vi-ui bottom attached tab segment" data-tab="menu_cart">
						<?php
						$mc_enable        = $this->settings->get_params( 'mc_enable' );
						$mc_mobile_enable = $this->settings->get_params( 'mc_mobile_enable' );
						$mc_empty_enable  = $this->settings->get_params( 'mc_empty_enable' );
						$mc_menu_display  = $this->settings->get_params( 'mc_menu_display' );
						?>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="vi-wcaio-mc_enable-checkbox"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="mc_enable" id="vi-wcaio-mc_enable" value="<?php echo esc_attr( $mc_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-mc_enable-checkbox" <?php checked( $mc_enable, 1 ); ?>><label></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-mc_mobile_enable-checkbox"><?php esc_html_e( 'Mobile enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="mc_mobile_enable" id="vi-wcaio-mc_mobile_enable" value="<?php echo esc_attr( $mc_mobile_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-mc_mobile_enable-checkbox" <?php checked( $mc_mobile_enable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description"><?php esc_html_e('Display menu cart on Mobile mode', 'woo-cart-all-in-one'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-mc_empty_enable-checkbox"><?php esc_html_e( 'Visible empty menu cart', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="mc_empty_enable" id="vi-wcaio-mc_empty_enable" value="<?php echo esc_attr( $mc_empty_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-mc_empty_enable-checkbox" <?php checked( $mc_empty_enable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description">
										<?php esc_html_e( 'Show Menu Cart cart even when it is empty', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-mc_menu_display"><?php esc_html_e( 'Menus', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <select name="mc_menu_display[]" id="vi-wcaio-mc_menu_display" class="vi-ui fluid dropdown vi-wcaio-mc_menu_display" multiple>
										<?php
										$menus = wp_get_nav_menus();
										foreach ( $menus as $menu ) {
											$selected = in_array( $menu->term_id, $mc_menu_display ) ? 'selected="selected"' : '';
											echo sprintf( '<option value="%s" %s>%s</option>', $menu->term_id, $selected, $menu->name );
										}
										?>
                                    </select>
                                    <p class="description"><?php esc_html_e( 'Select menus to display the menu Cart.  Clicking on save button before "Go to Design"', 'woo-cart-all-in-one' ) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label><?php esc_html_e( 'Design', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
			                        <?php
			                        $url = admin_url( 'customize.php' ) . '?url=' . urlencode( get_site_url() ) . '&autofocus[section]=vi_wcaio_design_menu_cart';
			                        ?>
                                    <a target="_blank" class="vi-wcaio-customize-url" href="<?php echo esc_attr( esc_url( $url ) ) ?>"><?php esc_html_e( 'Go to design', 'woo-cart-all-in-one' ) ?></a>
                                    <p class="description">
				                        <?php esc_html_e( 'Go to design Menu Cart', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="vi-ui bottom attached tab segment" data-tab="atc_button">
						<?php
						$ajax_atc                       = $this->settings->get_params( 'ajax_atc' );
						$ajax_atc_pd_exclude            = $this->settings->get_params( 'ajax_atc_pd_exclude' );
						$ajax_atc_notice            = $this->settings->get_params( 'ajax_atc_notice' );
						$ajax_atc_pd_variable           = $this->settings->get_params( 'ajax_atc_pd_variable' );
						$pd_variable_bt_atc_text_enable = $this->settings->get_params( 'pd_variable_bt_atc_text_enable' );
						$pd_variable_bt_atc_text        = $this->settings->get_params( 'pd_variable_bt_atc_text' );
						?>
                        <h4><?php esc_html_e( 'AJAX Add to Cart', 'woo-cart-all-in-one' ); ?></h4>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="vi-wcaio-ajax_atc-checkbox"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="ajax_atc" id="vi-wcaio-ajax_atc" value="<?php echo esc_attr( $ajax_atc ); ?>">
                                        <input type="checkbox" id="vi-wcaio-ajax_atc-checkbox" class="vi-wcaio-ajax_atc-checkbox"
											<?php checked( $ajax_atc, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description"><?php esc_html_e( 'Add product to cart without reloading on single product pages and Quick View popup.', 'woo-cart-all-in-one' ); ?></p>
                                </td>
                            </tr>
                            <tr class="vi-wcaio-ajax_atc-enable <?php echo esc_attr($ajax_atc ? '' :  'vi-wcaio-disabled' ); ?>">
                                <th>
                                    <label for="vi-wcaio-ajax_atc_pd_exclude"><?php esc_html_e( 'Exclude products', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <select name="ajax_atc_pd_exclude[]" id="vi-wcaio-ajax_atc_pd_exclude" data-type_select2="product"
                                            class="vi-wcaio-search-select2 vi-wcaio-search-product vi-wcaio-ajax_atc_pd_exclude" multiple>
										<?php
										if ( $ajax_atc_pd_exclude && is_array( $ajax_atc_pd_exclude ) && count( $ajax_atc_pd_exclude ) ) {
											foreach ( $ajax_atc_pd_exclude as $product_id ) {
												$product = wc_get_product( $product_id );
												if ( $product ) {
													echo sprintf( '<option value="%s" selected>%s</option>', $product_id, $product->get_name() );
												}
											}
										}
										?>
                                    </select>
                                    <p class="description">
										<?php esc_html_e( 'Add the products which are not applied ajax add to cart', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-ajax_atc_notice-checkbox"><?php esc_html_e( 'Notification', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="ajax_atc_notice" id="vi-wcaio-ajax_atc_notice" value="<?php echo esc_attr( $ajax_atc_notice ); ?>">
                                        <input type="checkbox" id="vi-wcaio-ajax_atc_notice-checkbox" class="vi-wcaio-ajax_atc_notice-checkbox"
					                        <?php checked( $ajax_atc_notice, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description">
				                        <?php esc_html_e( 'Display the notification of adding products to cart successfully after adding to cart by Ajax', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <h4><?php esc_html_e( 'Add to Cart for variable products', 'woo-cart-all-in-one' ); ?></h4>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="vi-wcaio-ajax_atc_pd_variable-checkbox"><?php esc_html_e( 'Select variation pop-up', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="ajax_atc_pd_variable" id="vi-wcaio-ajax_atc_pd_variable" value="<?php echo esc_attr( $ajax_atc_pd_variable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-ajax_atc_pd_variable-checkbox" class="vi-wcaio-ajax_atc_pd_variable-checkbox"
											<?php checked( $ajax_atc_pd_variable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description">
										<?php esc_html_e( 'After click add to cart button, a pop-up will appear allowing select variations and add to cart without redirect to the single product page.', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="vi-wcaio-pd_variable_bt_atc_text_enable-checkbox"><?php esc_html_e( 'Add to Cart button label', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <div class="vi-ui checkbox toggle">
                                        <input type="hidden" name="pd_variable_bt_atc_text_enable" id="vi-wcaio-pd_variable_bt_atc_text_enable"
                                               value="<?php echo esc_attr( $pd_variable_bt_atc_text_enable ); ?>">
                                        <input type="checkbox" id="vi-wcaio-pd_variable_bt_atc_text_enable-checkbox" class="vi-wcaio-pd_variable_bt_atc_text_enable-checkbox"
											<?php checked( $pd_variable_bt_atc_text_enable, 1 ); ?>><label></label>
                                    </div>
                                    <p class="description">
										<?php esc_html_e( 'Change the label of the add to cart button with variable products', 'woo-cart-all-in-one' ); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr class="vi-wcaio-pd_variable_bt_atc_text_enable-enable <?php echo esc_attr($pd_variable_bt_atc_text_enable ? '' :  'vi-wcaio-disabled' ); ?>">
                                <th>
                                    <label for="vi-wcaio-pd_variable_bt_atc_text">
										<?php esc_html_e( 'Add to Cart button label', 'woo-cart-all-in-one' ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text" name="pd_variable_bt_atc_text" id="vi-wcaio-pd_variable_bt_atc_text" class="vi-wcaio-pd_variable_bt_atc_text"
                                           placeholder="<?php esc_attr_e( 'Add To Cart', 'woo-cart-all-in-one' ); ?>"
                                           value="<?php echo esc_attr( $pd_variable_bt_atc_text ); ?>">
                                    <p class="description"><?php esc_html_e( 'Enter you own label for the add to cart button of variable products', 'woo-cart-all-in-one' ); ?></p>
                                </td>
                            </tr>
                        </table>
                        <h4><?php esc_html_e( 'Sticky Add To Cart on single product page', 'woo-cart-all-in-one' ); ?></h4>
                        <table class="form-table">
                            <tr>
                                <th>
                                    <label for="vi-wcaio-sb_enable-checkbox"><?php esc_html_e( 'Enable', 'woo-cart-all-in-one' ); ?></label>
                                </th>
                                <td>
                                    <a class="vi-ui button" href="https://1.envato.market/bW20B"
                                       target="_blank"><?php esc_html_e( 'Unlock This Feature', 'woo-cart-all-in-one' ); ?> </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="vi-ui bottom attached tab segment" data-tab="recently_viewed">
                        <a class="vi-ui button" href="https://1.envato.market/bW20B"
                           target="_blank"><?php esc_html_e( 'Unlock This Feature', 'woo-cart-all-in-one' ); ?> </a>
                    </div>
                    <p class="vi-wcuf-save-wrap">
                        <button type="submit" class="vi-wcuf-save vi-ui primary button" name="vi-wcaio-save">
							<?php esc_html_e( 'Save', 'woo-cart-all-in-one' ); ?>
                        </button>
                    </p>
                </form>
				<?php do_action( 'villatheme_support_woo-cart-all-in-one' ); ?>
            </div>
        </div>
		<?php
	}

	public function admin_enqueue_scripts() {
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		if ( $page === 'woo-cart-all-in-one' ) {
			$admin = 'VI_WOO_CART_ALL_IN_ONE_Admin_Settings';
			$admin::remove_other_script();
			$admin::enqueue_style(
				array( 'semantic-ui-button', 'semantic-ui-checkbox', 'semantic-ui-dropdown', 'semantic-ui-form', 'semantic-ui-icon', 'semantic-ui-menu', 'semantic-ui-segment', 'semantic-ui-tab' ),
				array( 'button.min.css', 'checkbox.min.css', 'dropdown.min.css', 'form.min.css', 'icon.min.css', 'menu.min.css', 'segment.min.css', 'tab.css' )
			);
			$admin::enqueue_style(
				array( 'vi-wcaio-admin-settings', 'select2', 'transition', 'semantic-ui-message' ),
				array( 'admin-settings.css', 'select2.min.css', 'transition.min.css', 'message.min.css' )
			);
			$admin::enqueue_script(
				array( 'semantic-ui-address', 'semantic-ui-checkbox', 'semantic-ui-dropdown', 'semantic-ui-form', 'semantic-ui-tab' ),
				array( 'address.min.js', 'checkbox.min.js', 'dropdown.min.js', 'form.min.js', 'tab.js' )
			);
			$admin::enqueue_script(
				array( 'vi-wcaio-admin-settings', 'select2', 'transition' ),
				array( 'admin-settings.js', 'select2.js', 'transition.min.js' )
			);
		}
	}
}