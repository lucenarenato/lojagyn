<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_Frontend {
	protected $settings;

	public function __construct() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		if (! $this->settings->enable( 'sc_' ) && ! $this->settings->enable( 'mc_' ) ) {
			if ( ! $this->settings->get_params( 'ajax_atc_pd_variable' ) ) {
				return;
			}
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'viwcaio_woocommerce_add_to_cart_fragments' ), PHP_INT_MAX, 1 );
		add_action( 'template_redirect', array( $this, 'viwcaio_recently_viewed' ) );
		add_action( 'wp_ajax_vi_wcaio_get_class_icon', array( $this, 'viwcaio_get_class_icon' ) );
		add_action( 'wp_ajax_vi_wcaio_get_menu_cart_text', array( $this, 'viwcaio_get_menu_cart_text' ) );
		add_action( 'wp_ajax_vi_wcaio_change_sc_pd_price_style', array( $this, 'viwcaio_change_sc_pd_price_style' ) );
		add_action( 'wp_ajax_vi_wcaio_get_sc_footer_pd_plus_html', array( $this, 'viwcaio_get_sc_footer_pd_plus_html' ) );
		add_action( 'wp_ajax_viwcaio_get_cart_fragments', array( __CLASS__, 'viwcaio_get_cart_fragments' ) );
		self::add_ajax_events();
		add_filter('viwcaio_quantity_input_args',array(__CLASS__,'viwcaio_quantity_input_args'), 10, 2);
		add_action( 'vi_wcaio_get_sidebar_cart_content', array( $this, 'get_sidebar_cart_content' ) );
	}
	public function get_sidebar_cart_content(){
		wc_get_template( 'sc-content.php', array('sidebar_cart'=>VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Content::get_instance()),
			'woo-cart-all-in-one' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR. 'sidebar-cart' . DIRECTORY_SEPARATOR,
			VI_WOO_CART_ALL_IN_ONE_TEMPLATES . 'sidebar-cart' . DIRECTORY_SEPARATOR);
	}

	public function viwcaio_wp_enqueue_scripts() {
		if ( WP_DEBUG ) {
			wp_enqueue_style( 'vi-wcaio-frontend', VI_WOO_CART_ALL_IN_ONE_CSS . 'frontend.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		} else {
			wp_enqueue_style( 'vi-wcaio-frontend', VI_WOO_CART_ALL_IN_ONE_CSS . 'frontend.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}
		wp_add_inline_style( 'vi-wcaio-frontend', wp_unslash( $this->settings->get_params( 'custom_css' ) ) );
	}

	public static function add_ajax_events() {
		$ajax_events = array(
			'viwcaio_change_quantity'   => true,
			'viwcaio_remove_item'       => true,
			'viwcaio_apply_coupon'      => true,
			'viwcaio_add_to_cart'       => true,
			'viwcaio_show_variation'    => true,
			'viwcaio_get_cart_fragments' => true,
		);
		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				// WC AJAX can be used for frontend ajax requests
				add_action( 'wc_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	public static function viwcaio_add_to_cart() {
		$notices = WC()->session->get( 'wc_notices', array() );
		if ( ! empty( $notices['error'] ) ) {
			wp_send_json( array( 'error' => true ) );
		}
		$settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		if ( ! empty( $notices ) && ! $settings->get_params( 'ajax_atc_notice' ) ) {
			unset( $notices['success'] );
			WC()->session->set( 'wc_notices', $notices );
		}
		WC_AJAX::get_refreshed_fragments();
		die();
	}

	public static function viwcaio_show_variation() {
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$result     = array(
			'status' => '',
			'url'    => '',
			'html'   => '',
		);
		if ( $product_id && $product_t = wc_get_product( $product_id ) ) {
			if ( $product_t->is_type( 'variable' ) ) {
				global $product;
				$product    = $product_t;
				if ( $product_t->is_in_stock() ) {
					ob_start();
					wc_get_template( 'variation-popup.php', array(),
						'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
						VI_WOO_CART_ALL_IN_ONE_TEMPLATES );
					$html             = ob_get_clean();
					$result['status'] = 'success';
					$result['html']   = $html;
					wp_send_json( $result );
				} else {
					$result['status'] = 'error';
					$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
					wp_send_json( $result );
				}
				if ( $product_t->is_in_stock() ) {
					global $product;
					$product    = $product_t;
					$attributes = $product->get_variation_attributes();
					if ( empty( $attributes ) ) {
						$result['status'] = 'error';
						$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
						wp_send_json( $result );
					}
					$variation_count     = count( $product->get_children() );
					$get_variations      = $variation_count <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
					$selected_attributes = $product->get_default_attributes();
					if ( $get_variations ) {
						$available_variations = $product->get_available_variations();
						if ( empty( $available_variations ) ) {
							$result['status'] = 'error';
							$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
							wp_send_json( $result );
						}
						$variations_json = wp_json_encode( $available_variations );
						$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
					} else {
						$variations_attr = false;
					}
					$product_id   = $product->get_id();
					$product_name = $product->get_name();
					ob_start();
					?>
                    <div class="vi-wcaio-va-cart-form-wrap-wrap">
                        <div class="vi-wcaio-va-cart-form-wrap">
                            <div class="vi-wcaio-va-cart-form vi-wcaio-va-cart-swatches vi-wcaio-cart-swatches-wrap variations_form"
                                 data-product_id="<?php echo esc_attr( $product_id ); ?>"
                                 data-product_name="<?php echo esc_attr( $product_name ); ?>"
                                 data-variation_count="<?php echo esc_attr( $variation_count ); ?>"
                                 data-product_variations="<?php echo esc_attr( $variations_attr ); ?>">
                                <div class="vi-wcaio-va-swatches-wrap-wrap vi-wcaio-swatches-wrap-wrap">
									<?php
									foreach ( $attributes as $attribute_name => $options ) {
										$selected = $selected_attributes[ $attribute_name ] ?? $product->get_variation_default_attribute( $attribute_name );
										?>
                                        <div class="vi-wcaio-va-swatches-wrap vi-wcaio-swatches-wrap">
                                            <div class="vi-wcaio-va-swatches-attr-name vi-wcaio-swatches-attr-name">
                                                <label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
													<?php echo wp_kses_post( wc_attribute_label( $attribute_name ) ); ?>
                                                </label>
                                            </div>
                                            <div class="vi-wcaio-va-swatches-value vi-wcaio-swatches-value value">
												<?php
												wc_dropdown_variation_attribute_options( apply_filters( 'vi_wcaio_dropdown_variation_attribute_options', array(
													'options'   => $options,
													'attribute' => $attribute_name,
													'product'   => $product,
													'selected'  => $selected,
													'class'     => 'vi-wcaio-attribute-options vi-wcaio-va-attribute-options',
												), $attribute_name, $product ) );
												?>
                                            </div>
                                        </div>
										<?php
									}
									?>
                                </div>
	                            <?php do_action( 'vi_wcaio_before_add_to_cart_button' ); ?>
                                <div class="vi-wcaio-va-qty-wrap">
	                                <?php
	                                $quantity_args =apply_filters('viwcaio_quantity_input_args', array(
		                                'input_name'   => "quantity",
		                                'input_value'  => 1,
		                                'max_value'    => $product->get_max_purchase_quantity(),
		                                'min_value'    => '0',
		                                'classes'    => ['vi-wcaio-va-qty-input'],
		                                'product_name' => $product_name
	                                ), $product);
	                                echo apply_filters('vi_wcaio_va_qty', self::product_get_quantity_html( $quantity_args),$product,$quantity_args );
	                                ?>
                                </div>
                                <div class="vi-wcaio-va-action-wrap">
                                    <button class="vi-wcaio-product-bt-atc vi-wcaio-va-product-bt-atc button alt" data-quantity="1"
                                            data-product_id="<?php echo esc_attr( $product_id ); ?>">
										<?php esc_html_e( 'Add To Cart', 'woo-cart-all-in-one' ); ?>
                                    </button>
                                    <input type="hidden" name="add-to-cart" class="vi-wcaio-add-to-cart" value="<?php echo esc_attr( $product_id ); ?>"/>
                                    <input type="hidden" name="product_id" class="vi-wcaio-product_id" value="<?php echo esc_attr( $product_id ); ?>"/>
                                    <input type="hidden" name="variation_id" class="variation_id" value="0"/>
                                </div>
	                            <?php do_action( 'vi_wcaio_after_add_to_cart_button' ); ?>
                                <span class="vi-wcaio-va-product-bt-atc-cancel">x</span>
                            </div>
                        </div>
                        <div class="vi-wcaio-va-cart-form-overlay"></div>
                    </div>
					<?php
					$html             = ob_get_clean();
					$result['status'] = 'success';
					$result['html']   = $html;
					wp_send_json( $result );
				} else {
					$result['status'] = 'error';
					$result['url']    = esc_attr( esc_url( $product->get_permalink() ) );
					wp_send_json( $result );
				}
			}
		}
		wp_send_json( $result );
		die();
	}
	public static function product_get_quantity_html( $args=array()){
		if (empty($args)){
			return '';
		}
		extract($args);
		ob_start();
		if ( $max_value && $min_value === $max_value ) {
			?>
            <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>"  name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>">
			<?php
		}else{
			do_action( 'woocommerce_before_quantity_input_field' );
			?>
            <div class="vi-wcaio-va-change-qty vi-wcaio-va-qty-subtract">
                <span class="viwcaio_nav_icons-pre"></span>
            </div>
            <div>
                <input type="number" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woo-cart-all-in-one' ); ?>"
                       placeholder="<?php echo esc_attr( $placeholder ); ?>"
                       id="<?php echo esc_attr( $input_id ); ?>"
                       class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
                       name="<?php echo esc_attr( $input_name ); ?>"
                       inputmode="<?php echo esc_attr( $inputmode ); ?>"
                       min="<?php echo esc_attr( $min_value ); ?>"
                       max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
                       step="<?php echo esc_attr( $step ); ?>"
                       value="<?php echo esc_attr( $input_value ); ?>">
            </div>
            <div class="vi-wcaio-va-change-qty vi-wcaio-va-qty-add">
                <span class="viwcaio_nav_icons-next"></span>
            </div>
			<?php
			do_action( 'woocommerce_after_quantity_input_field' );
		}
		$html = ob_get_clean();
		return $html;
	}

	public static function viwcaio_apply_coupon() {
		$coupon_code = isset( $_POST['vi_wcaio_coupon_code'] ) ? sanitize_text_field( $_POST['vi_wcaio_coupon_code'] ) : '';
		if ( $coupon_code ) {
			WC()->cart->add_discount( wc_format_coupon_code( $coupon_code ) );
		} else {
			wc_add_notice( WC_Coupon::get_generic_coupon_error( WC_Coupon::E_WC_COUPON_PLEASE_ENTER ), 'error' );
		}
		wp_send_json( array( wc_print_notices( true ) ) );
		die();
	}

	public static function viwcaio_change_quantity() {
		$viwcaio_cart = isset( $_POST['viwcaio_cart'] ) ? wc_clean( $_POST['viwcaio_cart'] ) : '';
		if ( empty( $viwcaio_cart ) ) {
			wp_send_json( array( 'error' => true) );
		}
		$cart = WC()->cart->get_cart();
		foreach ( $viwcaio_cart as $cart_item_key => $qty ) {
			$qty = $qty['qty'] ?? 0;
			$qty = $qty < 0 ? 0 : $qty;
			if ( '' === $qty || $qty == ($cart[$cart_item_key]['quantity'] ?? '') ) {
				continue;
			}
			$qty = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( '/[^0-9\.]/', '', $qty ) ), $cart_item_key );
			WC()->cart->set_quantity( strval( $cart_item_key ), floatval( $qty ), true );
		}
		WC()->cart->calculate_totals();
		WC_AJAX:: get_refreshed_fragments();
		die();
	}

	public static function viwcaio_remove_item() {
		$cart_item_key = isset( $_POST['cart_item_key'] ) ? sanitize_text_field( $_POST['cart_item_key'] ) : '';
		if ( $cart_item_key && false !== WC()->cart->remove_cart_item( $cart_item_key ) ) {
			WC_AJAX::get_refreshed_fragments();
		} else {
			wp_send_json_error();
		}
		die();
	}

	public static function viwcaio_get_cart_fragments(){
	    if (!isset($_REQUEST['viwcaio_get_cart_fragments'])){
	        wp_die();
        }
		$fragments = self::viwcaio_woocommerce_add_to_cart_fragments(array());
		wp_send_json(array('fragments'=>$fragments));
		die();
    }

	public static function viwcaio_woocommerce_add_to_cart_fragments( $fragments ) {
		$wc_cart              = WC()->cart;
		$cart_total           = $wc_cart->get_total();
		$cart_subtotal        = $wc_cart->get_cart_subtotal();
		$cart_content_count   = $wc_cart->get_cart_contents_count();
		$settings             = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$mc_display_style     = $settings->get_params( 'mc_display_style' );
		$mc_cart_total        = $settings->get_params( 'mc_cart_total' );
		$sc_footer_cart_total = $settings->get_params( 'sc_footer_cart_total' );
		ob_start();
		?>
        <span class="vi-wcaio-menu-cart-text-wrap">
	        <?php
	        VI_WOO_CART_ALL_IN_ONE_Frontend_Menu_Cart::get_menu_cart_text( $mc_display_style, $mc_cart_total === 'total' ? $cart_total : $cart_subtotal, $cart_content_count );
	        ?>
		</span>
		<?php
		$menu_text                                  = ob_get_clean();
		$fragments['.vi-wcaio-menu-cart-text-wrap'] = $menu_text;
		ob_start();
		?>
        <ul class="vi-wcaio-sidebar-cart-products">
			<?php
			VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Content::get_sidebar_content_pd_html( $wc_cart );
			?>
        </ul>
		<?php
		$sidebar_content_pd_html = ob_get_clean();
		ob_start();
		?>
        <div class="vi-wcaio-sidebar-cart-count">
			<?php echo wp_kses_post( $cart_content_count ); ?>
        </div>
		<?php
		$sidebar_count_pd_html = ob_get_clean();
		ob_start();
		?>
        <div class="vi-wcaio-sidebar-cart-footer-cart_total1">
			<?php echo wp_kses_post($sc_footer_cart_total === 'total' ?  $cart_total : $cart_subtotal ); ?>
        </div>
		<?php
		$sidebar_cart_total_html                                = ob_get_clean();
		$fragments['.vi-wcaio-menu-cart-text-wrap']             = $menu_text;
		$fragments['.vi-wcaio-sidebar-cart-count']              = $sidebar_count_pd_html;
		$fragments['.vi-wcaio-sidebar-cart-footer-cart_total1'] = $sidebar_cart_total_html;
		$fragments['.vi-wcaio-sidebar-cart-products']           = $sidebar_content_pd_html;

		return $fragments;
	}
	public static function viwcaio_quantity_input_args($args=array(), $product=null){
		if ( is_null( $product ) ) {
			$product = $GLOBALS['product'];
		}

		$defaults = array(
			'input_id'     => uniqid( 'quantity_' ),
			'input_name'   => 'quantity',
			'input_value'  => '1',
			'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' ), $product ),
			'max_value'    => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
			'min_value'    => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
			'step'         => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
			'pattern'      => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
			'inputmode'    => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
			'product_name' => $product ? $product->get_title() : '',
			'placeholder'  => apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
		);
		$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

		// Apply sanity to min/max args - min cannot be lower than 0.
		$args['min_value'] = max( $args['min_value'], 0 );
		$args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

		// Max cannot be lower than min if defined.
		if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
			$args['max_value'] = $args['min_value'];
		}
		return $args;
	}
	public function viwcaio_change_sc_pd_price_style() {
		$result         = array(
			'status'  => '',
			'message' => '',
		);
		$style = isset( $_POST['style'] ) ? sanitize_text_field( wp_unslash( $_POST['style'] ) ) : '';
		if ( $style ) {
			ob_start();
			VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Content::get_sidebar_content_pd_html( WC()->cart,$style );
			$html              = ob_get_clean();
			$result['status']  = $html ? 'success' : '';
			$result['message'] = $html;
		}
		wp_send_json( $result );
	}

	public function viwcaio_get_sc_footer_pd_plus_html() {
		$result = array(
			'status'  => '',
			'message' => '',
		);
		$type   = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		if ( $type ) {
			$html              = VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Content::get_product_plus( $type );
			$result['status']  = $html ? 'success' : '';
			$result['message'] = $html;
		}
		wp_send_json( $result );
	}


	public function viwcaio_get_menu_cart_text() {
		$result          = array(
			'status'  => '',
			'message' => '',
		);
		$display_type    = isset( $_POST['display_type'] ) ? sanitize_text_field( $_POST['display_type'] ) : '';
		$cart_total_type = isset( $_POST['cart_total_type'] ) ? sanitize_text_field( $_POST['cart_total_type'] ) : '';
		if ( $display_type && $cart_total_type ) {
			if ( isset( WC()->cart ) ) {
				$wc_cart            = WC()->cart;
				$cart_content_count = $wc_cart->get_cart_contents_count();
				$cart_total         = $cart_total_type === 'total' ? $wc_cart->get_total() : $wc_cart->get_cart_subtotal();
			} else {
				$cart_total = $cart_content_count = 0;
			}
			ob_start();
			VI_WOO_CART_ALL_IN_ONE_Frontend_Menu_Cart::get_menu_cart_text( $display_type, $cart_total, $cart_content_count );
			$html = ob_get_clean();
			if ( $html ) {
				$result['status']  = 'success';
				$result['message'] = $html;
			}
		}
		wp_send_json( $result );
	}

	public function viwcaio_get_class_icon() {
		$result   = array(
			'status'  => '',
			'message' => '',
		);
		$settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$icon_id  = isset( $_POST['icon_id'] ) ? sanitize_text_field( $_POST['icon_id'] ) : '';
		$type     = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
		if ( is_numeric( $icon_id ) && $type && $class = $settings->get_class_icon( $icon_id, $type ) ) {
			$result['status']  = 'success';
			$result['message'] = $class;
		}
		wp_send_json( $result );
	}

	public function viwcaio_recently_viewed() {
		$check = false;
		if ( $this->settings->enable( 'sc_' ) && $this->settings->get_params( 'sc_footer_pd_plus' ) === 'viewed_product' ) {
			$check = true;
		}
		if ( ! $check ) {
			return;
		}
		if ( ! is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) && is_single() && is_product() ) {
			$product_id        = get_the_ID();
			$recent_viewed_ids = ! empty( $_COOKIE['viwcaio_recently_viewed'] ) ? explode( '|', wp_unslash( $_COOKIE['viwcaio_recently_viewed'] ) ) : array();
			$key               = array_search( $product_id, $recent_viewed_ids );
			if ( $key !== false ) {
				unset( $recent_viewed_ids[ $key ] );
			}
			$recent_viewed_ids[] = $product_id;
			if ( count( $recent_viewed_ids ) > 15 ) {
				array_shift( $recent_viewed_ids );
			}
			$recent_viewed_ids = implode( '|', $recent_viewed_ids );
			wc_setcookie( 'viwcaio_recently_viewed', $recent_viewed_ids );
		}
	}

	public static function add_inline_style( $element, $name, $style, $suffix = '' ) {
		if ( ! $element || ! is_array( $element ) ) {
			return '';
		}
		$settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		$element  = implode( ',', $element );
		$return   = $element . '{';
		if ( is_array( $name ) && count( $name ) ) {
			foreach ( $name as $key => $value ) {
				$get_value  = $settings->get_params( $value );
				$get_suffix = $suffix[ $key ] ?? '';
				$return     .= $style[ $key ] . ':' . $get_value . $get_suffix . ';';
			}
		}
		$return .= '}';

		return $return;
	}
}