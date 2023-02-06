<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
class VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Content {
	public static $settings, $cache;
	public  $is_customize, $customize_data;
	protected static $instance = null;
	public function __construct() {
		self::$settings    = new VI_WOO_CART_ALL_IN_ONE_DATA();
		add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ) );
	}
	public function viwcaio_wp_enqueue_scripts() {
		if ( (is_checkout() || is_cart()) && !is_product() ) {
			return;
		}
		$this->is_customize = is_customize_preview();
		if ( ! $this->is_customize && ! $this->assign_page() ) {
			return;
		}
		if ($this->is_customize){
			global $wp_customize;
			$this->customize_data = $wp_customize;
		}
		$sc_footer_message = self::$settings->get_params( 'sc_footer_message' );
		$has_product_plus  = strpos( $sc_footer_message, '{product_plus}' );
		wp_enqueue_style( 'vi-wcaio-loading', VI_WOO_CART_ALL_IN_ONE_CSS . 'loading.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		$suffix = WP_DEBUG ? '' : 'min.';
		wp_enqueue_style( 'vi-wcaio-sidebar-cart-content', VI_WOO_CART_ALL_IN_ONE_CSS . 'sidebar-cart-content.' . $suffix . 'css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_enqueue_script( 'vi-wcaio-sidebar-cart', VI_WOO_CART_ALL_IN_ONE_JS . 'sidebar-cart.' . $suffix . 'js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_enqueue_style( 'vi-wcaio-cart-icons', VI_WOO_CART_ALL_IN_ONE_CSS . 'cart-icons.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		if ( ( $has_product_plus !== false ) || $this->is_customize ) {
			wp_enqueue_style( 'vi-wcaio-nav-icons', VI_WOO_CART_ALL_IN_ONE_CSS . 'nav-icons.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_style( 'vi-wcaio-flexslider', VI_WOO_CART_ALL_IN_ONE_CSS . 'sc-flexslider.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
			wp_enqueue_script( 'vi-wcaio-flexslider', VI_WOO_CART_ALL_IN_ONE_JS . 'flexslider.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}
		if ( ! $this->is_customize ) {
			$args = array(
				'wc_ajax_url'                      => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			);
			wp_localize_script( 'vi-wcaio-sidebar-cart', 'viwcaio_sc_params', $args );
			$css = $this->get_inline_css();
			wp_add_inline_style( 'vi-wcaio-sidebar-cart-content', $css );
		}
		add_action( 'wp_footer', array( $this, 'frontend_html' ) );
	}
	public function frontend_html(){
		wc_get_template( 'sidebar-cart.php', array('sidebar_cart'=>$this),
			'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR. 'sidebar-cart' . DIRECTORY_SEPARATOR,
			VI_WOO_CART_ALL_IN_ONE_TEMPLATES . 'sidebar-cart' . DIRECTORY_SEPARATOR);
    }
	public function get_inline_css() {
		$css      = '';
		$frontend = 'VI_WOO_CART_ALL_IN_ONE_Frontend_Frontend';
		if ( $sc_horizontal = self::$settings->get_params( 'sc_horizontal' ) ) {
			$sc_horizontal_mobile = $sc_horizontal > 20 ? 20 - $sc_horizontal : 0;
			$css                  .= '.vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_left,
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_left{
                left: ' . $sc_horizontal . 'px ;
            }
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_right,
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_right{
                right: ' . $sc_horizontal . 'px ;
            }
            @media screen and (max-width: 768px) {
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_left .vi-wcaio-sidebar-cart-content-wrap,
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_left .vi-wcaio-sidebar-cart-content-wrap{
                    left: ' . $sc_horizontal_mobile . 'px ;
                }
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_right .vi-wcaio-sidebar-cart-content-wrap,
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_right .vi-wcaio-sidebar-cart-content-wrap{
                    right: ' . $sc_horizontal_mobile . 'px ;
                }
            }
            ';
		}
		if ( $sc_vertical = self::$settings->get_params( 'sc_vertical' ) ) {
			$sc_vertical_mobile = $sc_vertical > 20 ? 20 - $sc_vertical : 0;
			$css                .= '.vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_left,
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_right{
                top: ' . $sc_vertical . 'px ;
            }
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_right,
            .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_left{
                bottom: ' . $sc_vertical . 'px ;
            }
            @media screen and (max-width: 768px) {
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_left .vi-wcaio-sidebar-cart-content-wrap,
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-top_right .vi-wcaio-sidebar-cart-content-wrap{
                    top: ' . $sc_vertical_mobile . 'px ;
                }
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_right .vi-wcaio-sidebar-cart-content-wrap,
                .vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-1.vi-wcaio-sidebar-cart-bottom_left .vi-wcaio-sidebar-cart-content-wrap{
                    bottom: ' . $sc_vertical_mobile . 'px ;
                }
            }';
		}
		if ( $sc_loading_color = self::$settings->get_params( 'sc_loading_color' ) ) {
			$css .= '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-dual_ring:after {
                border-color: ' . $sc_loading_color . '  transparent ' . $sc_loading_color . '  transparent;
            }
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-ring div{
                border-color: ' . $sc_loading_color . '  transparent transparent transparent;
            }
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-ripple  div{
                border: 4px solid ' . $sc_loading_color . ' ;
            }
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-default div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-animation_face_1 div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-animation_face_2 div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-roller div:after,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-loader_balls_1 div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-loader_balls_2 div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-loader_balls_3 div,
            .vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-loading-spinner div:after{
                background: ' . $sc_loading_color . ' ;
            }';
		}
		if ( self::$settings->get_params( 'sc_pd_img_box_shadow' ) ) {
			$css .= '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-img-wrap img{
                box-shadow: 0 4px 10px rgba(0,0,0,0.07);
            }';
		}
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-content-wrap' ),
			array( 'sc_radius' ),
			array( 'border-radius' ),
			array( 'px' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap' ),
			array( 'sc_header_bg_color', 'sc_header_border_style', 'sc_header_border_color' ),
			array( 'background', 'border-style', 'border-color' ),
			array( '', '', '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-title-wrap' ),
			array( 'sc_header_title_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-coupon-wrap .vi-wcaio-coupon-code' ),
			array( 'sc_header_coupon_input_radius' ),
			array( 'border-radius' ),
			array( 'px' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-coupon-wrap button.vi-wcaio-bt-coupon-code',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-coupon-wrap .vi-wcaio-bt-coupon-code.button'
			),
			array( 'sc_header_coupon_button_bg_color', 'sc_header_coupon_button_color', 'sc_header_coupon_button_border_radius' ),
			array( 'background', 'color', 'border-radius' ),
			array( '', '', 'px' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-coupon-wrap button.vi-wcaio-bt-coupon-code:hover',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-header-wrap .vi-wcaio-sidebar-cart-header-coupon-wrap .vi-wcaio-bt-coupon-code.button:hover'
			),
			array( 'sc_header_coupon_button_bg_color_hover', 'sc_header_coupon_button_color_hover' ),
			array( 'background', 'color' ),
			array( '', '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap' ),
			array( 'sc_footer_bg_color', 'sc_footer_border_type', 'sc_footer_border_color' ),
			array( 'background', 'border-style', 'border-color' ),
			array( '', '', '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-footer-cart_total > div:nth-child(1)' ),
			array( 'sc_footer_cart_total_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-footer-cart_total > div:nth-child(2)' ),
			array( 'sc_footer_cart_total_color1' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap button.vi-wcaio-sidebar-cart-bt-nav',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-bt-nav.button'
			),
			array( 'sc_footer_button_bg_color', 'sc_footer_button_color', 'sc_footer_button_border_radius' ),
			array( 'background', 'color', 'border-radius' ),
			array( '', '', 'px' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap button.vi-wcaio-sidebar-cart-bt-nav:hover',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-bt-nav.button:hover'
			),
			array( 'sc_footer_button_hover_bg_color', 'sc_footer_button_hover_color' ),
			array( 'background', 'color' ),
			array( '', '' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap button.vi-wcaio-sidebar-cart-bt-update',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-bt-update.button'
			),
			array( 'sc_footer_bt_update_bg_color', 'sc_footer_bt_update_color', 'sc_footer_bt_update_border_radius' ),
			array( 'background', 'color', 'border-radius' ),
			array( '', '', 'px' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap button.vi-wcaio-sidebar-cart-bt-update:hover',
				'.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-bt-update.button:hover'
			),
			array( 'sc_footer_bt_update_hover_bg_color', 'sc_footer_bt_update_hover_color' ),
			array( 'background', 'color' ),
			array( '', '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-footer-wrap .vi-wcaio-sidebar-cart-footer-pd-plus-title' ),
			array( 'sc_footer_pd_plus_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products-wrap' ),
			array( 'sc_pd_bg_color' ),
			array( 'background' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-img-wrap img' ),
			array( 'sc_pd_img_border_radius' ),
			array( 'border-radius' ),
			array( 'px' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-info-wrap .vi-wcaio-sidebar-cart-pd-name-wrap .vi-wcaio-sidebar-cart-pd-name, .vi-wcaio-sidebar-cart-footer-pd-name *' ),
			array( 'sc_pd_name_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-info-wrap .vi-wcaio-sidebar-cart-pd-name-wrap .vi-wcaio-sidebar-cart-pd-name:hover, .vi-wcaio-sidebar-cart-footer-pd-name *:hover' ),
			array( 'sc_pd_name_hover_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-info-wrap .vi-wcaio-sidebar-cart-pd-price *, .vi-wcaio-sidebar-cart-footer-pd-price *' ),
			array( 'sc_pd_price_color' ),
			array( 'color' ),
			array( '' )
		);
		if ( $sc_pd_qty_border_color = self::$settings->get_params( 'sc_pd_qty_border_color' ) ) {
			$css .= '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi-wcaio-sidebar-cart-pd-quantity{
                 border: 1px solid ' . $sc_pd_qty_border_color . ' ;
            }';
			$css .= '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi_wcaio_minus{
                 border-right: 1px solid ' . $sc_pd_qty_border_color . ' ;
            }';
			$css .= '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi_wcaio_plus{
                 border-left: 1px solid ' . $sc_pd_qty_border_color . ' ;
            }';
			$css .= '.vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-rtl .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi_wcaio_minus{
			     border-right: unset;
                 border-left: 1px solid ' . $sc_pd_qty_border_color . ' ;
            }';
			$css .= '.vi-wcaio-sidebar-cart.vi-wcaio-sidebar-cart-rtl .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi_wcaio_plus{
			     border-left: unset;
                 border-right: 1px solid ' . $sc_pd_qty_border_color . ' ;
            }';
		}
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-desc .vi-wcaio-sidebar-cart-pd-quantity' ),
			array( 'sc_pd_qty_border_radius' ),
			array( 'border-radius' ),
			array( 'px' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-remove-wrap i' ),
			array( 'sc_pd_delete_icon_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-remove-wrap i:before' ),
			array( 'sc_pd_delete_icon_font_size' ),
			array( 'font-size' ),
			array( 'px' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart .vi-wcaio-sidebar-cart-products .vi-wcaio-sidebar-cart-pd-remove-wrap i:hover' ),
			array( 'sc_pd_delete_icon_hover_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart button.vi-wcaio-pd_plus-product-bt-atc',
				'.vi-wcaio-sidebar-cart .button.vi-wcaio-pd_plus-product-bt-atc',
			),
			array( 'sc_footer_pd_plus_bt_atc_bg_color', 'sc_footer_pd_plus_bt_atc_color' ),
			array( 'background', 'color' ),
			array( '', '' )
		);
		$css .= $frontend::add_inline_style(
			array(
				'.vi-wcaio-sidebar-cart button.vi-wcaio-pd_plus-product-bt-atc:hover',
				'.vi-wcaio-sidebar-cart .button.vi-wcaio-pd_plus-product-bt-atc:hover',
			),
			array( 'sc_footer_pd_plus_bt_atc_hover_bg_color', 'sc_footer_pd_plus_bt_atc_hover_color' ),
			array( 'background', 'color' ),
			array( '', '' )
		);
		$css = str_replace( array( "\r", "\n", '\r', '\n' ), ' ', $css );
		return $css;
	}
    public function assign_page(){
	    if ( isset( self::$cache['assign_page'] ) ) {
		    return self::$cache['assign_page'];
	    }
	    if (!self::$settings->enable('sc_')) {
		    return self::$cache['assign_page'] = false;
	    }
	    $assign_page = self::$settings->get_params( 'sc_assign_page' );
	    if ( $assign_page ) {
		    if ( stristr( $assign_page, "return" ) === false ) {
			    $assign_page = "return (" . $assign_page . ");";
		    }
		    try {
			    $logic_show = eval( $assign_page);
		    }
		    catch ( \Error $e ) {
			    trigger_error( $e->getMessage(), E_USER_WARNING );

			    $logic_show = false;
		    }catch ( \Exception $e ) {
			    trigger_error( $e->getMessage(), E_USER_WARNING );

			    $logic_show = false;
		    }
		    if ( !$logic_show ) {
			    return self::$cache['assign_page'] = false;
		    }
	    }
	    return self::$cache['assign_page'] = true;
    }
	public function get_params( $name = '') {
		if ( $this->customize_data && $name && $setting = $this->customize_data->get_setting( 'woo_cart_all_in_one_params[' . $name . ']' ) ) {
			return $this->customize_data->post_value( $setting, self::$settings->get_params( $name ) );
		} else {
			return self::$settings->get_params( $name );
		}
	}
	public static function is_customize_preview() {
		if ( isset( self::$cache['is_customize_preview'] ) ) {
			return self::$cache['is_customize_preview'];
		}
		return self::$cache['is_customize_preview']=is_customize_preview();
	}
	public static function get_instance( $new = false ) {
		if ( $new || null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	public static function get_sidebar_content_pd_html($wc_cart, $sc_pd_price_style = null){
		wc_get_template( 'sc-product-list-html.php',
			array(
				'sidebar_cart'=> self::get_instance(),
				'wc_cart' => $wc_cart,
				'sc_pd_price_style' => $sc_pd_price_style,
			),
			'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR. 'sidebar-cart' . DIRECTORY_SEPARATOR,
			VI_WOO_CART_ALL_IN_ONE_TEMPLATES . 'sidebar-cart' . DIRECTORY_SEPARATOR);
    }
    public static function get_sc_pd_quantity_html( $args = array(), $echo=false){
	    if ($echo){
		    wc_get_template( 'vicaio-product-quantity-html.php', array('args'=>$args),
			    'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR,
			    VI_WOO_CART_ALL_IN_ONE_TEMPLATES . DIRECTORY_SEPARATOR);
	    }else{
		    ob_start();
		    wc_get_template( 'vicaio-product-quantity-html.php', array('args'=>$args),
			    'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR,
			    VI_WOO_CART_ALL_IN_ONE_TEMPLATES . DIRECTORY_SEPARATOR);
		    $html = ob_get_clean();
		    return $html;
	    }
    }
	public static function get_sc_pd_price_html( $wc_cart, $cart_item, $cart_item_key, $product, $style = 'price' ) {
		if ( ! $wc_cart || ! $product ) {
			return '';
		}
		switch ( $style ) {
			case 'qty':
				$html = $product->is_sold_individually() ? 1 : ( $cart_item['quantity'] ?? 1 );
				$html .= ' &#215; ' . apply_filters( 'woocommerce_cart_item_price', $wc_cart->get_product_price( $product ), $cart_item, $cart_item_key );
				break;
			case 'subtotal':
				$html = apply_filters( 'woocommerce_cart_item_subtotal', $wc_cart->get_product_subtotal( $product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
				break;
			default:
				$html = apply_filters( 'woocommerce_cart_item_price', $wc_cart->get_product_price( $product ), $cart_item, $cart_item_key );
		}
		return $html;
	}
	public static function get_sc_footer_coupon_html( $coupons ) {
		if ( empty( $coupons ) ) {
			return apply_filters( 'vi_wcaio_footer_coupon_html', '' );
		}
		ob_start();
		foreach ( $coupons as $code => $coupon ) {
			?>
			<tr class="vi-wcaio-coupon vi-wcaio-coupon-<?php echo esc_attr( $code ) ?>">
				<td><?php wc_cart_totals_coupon_label( $coupon ); ?></td>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?> </td>
			</tr>
			<?php
		}
		$html = ob_get_clean();
		$html = '<table cellspacing="0" >' . $html . '</table>';
		return apply_filters( 'vi_wcaio_footer_coupon_html', $html );
	}
	public static function get_sc_footer_message_html($text){
		if ( ! $text ) {
			return '';
		}
		$shortcodes = array();
		preg_match_all( '/' . get_shortcode_regex() . '/', $text, $matches, PREG_SET_ORDER );
		if ( ! empty( $matches ) ) {
			foreach ( $matches as $shortcode ) {
				$shortcodes[] = $shortcode[0];
			}
		}
		if ( count( $shortcodes ) ) {
			foreach ( $shortcodes as $shortcode ) {
				$text = str_replace( $shortcode, do_shortcode( $shortcode ), $text );
			}
		}
		$text = str_replace( '{product_plus}', self::get_product_plus(), $text );
		echo wp_kses( $text, VI_WOO_CART_ALL_IN_ONE_DATA::extend_post_allowed_html() );
	}
	public static function get_product_plus( $type=false){
		$settings           = self::$settings;
		$sc_footer_pd_plus  = $type !== false ? $type : $settings->get_params( 'sc_footer_pd_plus' );
		$product_plus_limit = $settings->get_params( 'sc_footer_pd_plus_limit' );
		$out_of_stock       = $settings->get_params( 'sc_footer_pd_plus_out_of_stock' );
		$product_plus       = self::get_sidebar_pd_plus( $settings,$sc_footer_pd_plus, $product_plus_limit, $out_of_stock );
		if ( empty( $product_plus ) || ! is_array( $product_plus ) ) {
			return '<div class="vi-wcaio-sidebar-cart-footer-pd-wrap-wrap vi-wcaio-disabled"></div>';
		}
		ob_start();
		?>
		<div class="vi-wcaio-sidebar-cart-footer-pd-wrap-wrap vi-wcaio-sidebar-cart-footer-pd-<?php echo esc_attr( $sc_footer_pd_plus ); ?>">
			<div class="vi-wcaio-sidebar-cart-footer-pd-plus-title">
				<?php echo wp_kses_post( $settings->get_params( 'sc_footer_pd_plus_title' ) ); ?>
			</div>
			<div class="vi-wcaio-sidebar-cart-footer-pd-wrap">
				<?php
				foreach ( $product_plus as $product_id ) {
					wc_get_template( 'sc-product-plus-html.php',
                        array('product_id'=>$product_id,'settings'=>$settings),
						'woocommerce-cart-all-in-one' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR. 'sidebar-cart' . DIRECTORY_SEPARATOR,
						VI_WOO_CART_ALL_IN_ONE_TEMPLATES . 'sidebar-cart' . DIRECTORY_SEPARATOR);
				}
				?>
			</div>
		</div>
		<?php
		$html = ob_get_clean();
		return $html;
	}
	public static function get_sidebar_pd_plus($settings, $type='' , $limit = 5, $out_of_stock = false ) {
		if ( ! $type || ! $limit ) {
			return false;
		}
		$limit                     = $limit > 15 ? 15 : $limit;
		$product_visibility_hidden = apply_filters( 'vi_wcaio_sc_pd_plus_visibility_hidden', 1 );
		switch ( $type ) {
			case 'best_selling':
				$args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'meta_key'       => 'total_sales',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'posts_per_page' => $limit
				);
				if ( $product_visibility_hidden ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_visibility',
							'terms'    => array( 'exclude-from-catalog', 'exclude-from-search' ),
							'field'    => 'name',
							'operator' => 'NOT IN'
						)
					);
				}
				if ( ! $out_of_stock ) {
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'     => '_stock_status',
							'value'   => 'instock',
							'compare' => 'EQUAL'
						)
					);
				}
				$product_ids = array();
				$the_query   = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$product_ids[] = get_the_ID();
					}
				}
				wp_reset_postdata();
				break;
			case 'viewed_product':
				$viewed_products = is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) ? ( $_COOKIE['woocommerce_recently_viewed'] ?? '' ) : '';
				$viewed_products = $viewed_products ?: ( $_COOKIE['viwcaio_recently_viewed'] ?? '' );
				$product_ids_t   = $viewed_products ? explode( '|', wp_unslash( $viewed_products ) ) : array();
				if ( $product_visibility_hidden ) {
					$product_ids_t1 = $product_ids_t;
					$product_ids_t  = array();
					foreach ( $product_ids_t1 as $id ) {
						$product = wc_get_product( $id );
						if ( $product->get_catalog_visibility() === 'hidden' ) {
							continue;
						}
						$product_ids_t[] = $id;
					}
				}
				if ( empty( $product_ids_t ) ) {
					break;
				}
				if ( ! $out_of_stock ) {
					$product_ids = array();
					foreach ( $product_ids_t as $id ) {
						if ( ! $limit ) {
							break;
						}
						$product = wc_get_product( $id );
						if ( ! $product->is_in_stock() ) {
							continue;
						}
						$product_ids[] = $id;
					}
				} else {
					$product_ids = $product_ids_t;
					if ( $limit < count( $product_ids_t ) ) {
						$product_ids = array_slice( $product_ids_t, 0, $limit );
					}
				}
				break;
			case 'product_rating':
				$args = array(
					'post_type'      => 'product',
					'meta_key'       => '_wc_average_rating',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'posts_per_page' => $limit
				);
				if ( $product_visibility_hidden ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_visibility',
							'terms'    => array( 'exclude-from-catalog', 'exclude-from-search' ),
							'field'    => 'name',
							'operator' => 'NOT IN'
						)
					);
				}
				if ( ! $out_of_stock ) {
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'     => '_stock_status',
							'value'   => 'instock',
							'compare' => 'EQUAL'
						)
					);
				}
				$product_ids = array();
				$the_query   = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$product_ids[] = get_the_ID();
					}
				}
				wp_reset_postdata();
				break;
		}
		return $product_ids ?? false;
	}
	public function get_sidebar_loading( $type ) {
		if ( ! $type ) {
			return;
		}
		$class   = array(
			'vi-wcaio-sidebar-cart-loading vi-wcaio-sidebar-cart-loading-' . $type
		);
		$class[] = $this->is_customize ? 'vi-wcaio-disabled' : '';
		$class   = trim( implode( ' ', $class ) );
		switch ( $type ) {
			case 'spinner':
			case 'default':
				?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
				<?php
				break;
			case 'dual_ring':
				?>
                <div class="<?php echo esc_attr( $class ); ?>"></div>
				<?php
				break;
			case 'animation_face_1':
				?>
            <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div></div><?php
				break;
			case 'animation_face_2':
			case 'ring':
				?>
            <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div></div><?php
				break;
			case 'roller':
				?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
				<?php
				break;
			case 'loader_balls_1':
				?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
				<?php
				break;
			case 'loader_balls_2':
			case 'loader_balls_3':
				?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
				<?php
				break;
			case 'ripple':
				?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <div></div>
                    <div></div>
                </div>
				<?php
				break;
		}
	}
}