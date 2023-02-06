<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
class VI_WOO_CART_ALL_IN_ONE_Frontend_Sidebar_Cart_Icon {
	protected $settings;
	protected $is_customize, $customize_data;
	public function __construct() {
		$this->settings    = new VI_WOO_CART_ALL_IN_ONE_DATA();
		add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ) ,9);
		add_action( 'vi_wcaio_get_sidebar_cart_icon', array( $this, 'get_sidebar_cart_icon' ) );
	}
	public function viwcaio_wp_enqueue_scripts() {
		if ( (is_checkout() || is_cart()) && !is_product() ) {
			return;
		}
		if (!isset(WC()->cart)){
		    return;
        }
		$this->is_customize = is_customize_preview();
		if ( ! $this->is_customize && ! $this->assign_page() ) {
			return;
		} else {
			global $wp_customize;
			$this->customize_data = $wp_customize;
		}
		wp_enqueue_style( 'vi-wcaio-cart-icons', VI_WOO_CART_ALL_IN_ONE_CSS . 'cart-icons.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		$suffix = WP_DEBUG ? '' : 'min.';
		wp_enqueue_style( 'vi-wcaio-sidebar-cart-icon', VI_WOO_CART_ALL_IN_ONE_CSS . 'sidebar-cart-icon.' . $suffix . 'css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		if ( ! $this->is_customize ) {
			$css = $this->get_inline_css();
			wp_add_inline_style( 'vi-wcaio-sidebar-cart-icon', $css );
		}
		add_action( 'wp_footer', array( $this, 'frontend_html' ) );
	}
	public function frontend_html() {
		$class = array(
			'vi-wcaio-sidebar-cart-icon-wrap',
			'vi-wcaio-sidebar-cart-icon-wrap-'.$this->get_params( 'sc_position' ),
			'vi-wcaio-sidebar-cart-icon-wrap-'.$sc_trigger_type = $this->get_params( 'sc_trigger_type' ) ,
		);
		$sc_empty_enable = $this->settings->get_params( 'sc_empty_enable' );
		if ( ! $this->is_customize ) {
			$class[] = ! $sc_empty_enable && WC()->cart->is_empty() ? 'vi-wcaio-disabled' : '';
		}elseif (!$this->get_params('sc_enable') ){
			$class[] = 'vi-wcaio-disabled' ;
        }
		$class = trim( implode( ' ', $class ) );
		?>
		<div class="<?php echo esc_attr( $class); ?>"
		     data-trigger="<?php echo esc_attr( $sc_trigger_type ); ?>">
			<?php
			do_action( 'vi_wcaio_get_sidebar_cart_icon' );
			?>
		</div>
		<?php
	}

	public function get_sidebar_cart_icon() {
		$sc_icon_style        = $this->get_params( 'sc_icon_style' );
		$sc_icon_default_icon = $this->get_params( 'sc_icon_default_icon' );
		$icon_class           = $this->settings->get_class_icon( $sc_icon_default_icon, 'cart_icons' );
		$wrap_class           = array(
			'vi-wcaio-sidebar-cart-icon',
			'vi-wcaio-sidebar-cart-icon-' . $sc_icon_style,
		);
		$wrap_class           = trim( implode( ' ', $wrap_class ) );
		switch ( $sc_icon_style ) {
			case '1':
			case '2':
			case '3':
			case '5':
				?>
                <div class="<?php echo esc_attr( $wrap_class ); ?>" data-display_style="<?php echo esc_attr( $sc_icon_style ); ?>">
                    <i class="<?php echo esc_attr( $icon_class ); ?>"></i>
                    <div class="vi-wcaio-sidebar-cart-count-wrap">
                        <div class="vi-wcaio-sidebar-cart-count">
							<?php echo wp_kses_post( WC()->cart->get_cart_contents_count() ); ?>
                        </div>
                    </div>
                </div>
				<?php
				break;
			default:
				?>
				<div class="<?php echo esc_attr( $wrap_class ); ?>">
					<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
				</div>
			<?php
		}
	}
	public function get_inline_css() {
		$css      = '';
		$frontend = 'VI_WOO_CART_ALL_IN_ONE_Frontend_Frontend';
		$sc_horizontal = $this->settings->get_params( 'sc_horizontal' ) ?: 0;
		$css                  .= '.vi-wcaio-sidebar-cart-icon-wrap-top_left, .vi-wcaio-sidebar-cart-icon-wrap-bottom_left{';
		$css                  .= 'left: ' . $sc_horizontal . 'px ;';
		$css                  .= '}';
		$css                  .= '.vi-wcaio-sidebar-cart-icon-wrap-top_right, .vi-wcaio-sidebar-cart-icon-wrap-bottom_right{';
		$css                  .= 'right: ' . $sc_horizontal . 'px ;';
		$css                  .= '}';
		$sc_vertical = $this->settings->get_params( 'sc_vertical' ) ?: 0;
		$css                  .= '.vi-wcaio-sidebar-cart-icon-wrap-top_left, .vi-wcaio-sidebar-cart-icon-wrap-top_right{';
		$css                  .= 'top: ' . $sc_vertical . 'px ;';
		$css                  .= '}';
		$css                  .= '.vi-wcaio-sidebar-cart-icon-wrap-bottom_right, .vi-wcaio-sidebar-cart-icon-wrap-bottom_left{';
		$css                  .= 'bottom: ' . $sc_vertical . 'px ;';
		$css                  .= '}';
		if ( $this->settings->get_params( 'sc_icon_box_shadow' ) ) {
			$css .= '.vi-wcaio-sidebar-cart-icon-wrap{
                box-shadow: inset 0 0 2px rgba(0,0,0,0.03), 0 4px 10px rgba(0,0,0,0.17);
            }';
		}
		if ( $sc_icon_scale = $this->settings->get_params( 'sc_icon_scale' ) ) {
			$css .= '.vi-wcaio-sidebar-cart-icon-wrap {
                transform: scale(' . $sc_icon_scale . ') ;
            }
            @keyframes vi-wcaio-cart-icon-slide_in_left {
                from {
                    transform: translate3d(-100%, 0, 0) scale(' . $sc_icon_scale . ');
                    visibility: hidden;
                }
                to {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_scale . ');
                }
            }
            @keyframes vi-wcaio-cart-icon-slide_out_left {
                from {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_scale . ');
                    visibility: visible;
                    opacity: 1;
                }
                to {
                    transform: translate3d(-100%, 0, 0) scale(' . $sc_icon_scale . ');
                    visibility: hidden;
                    opacity: 0;
                }
            }
            @keyframes vi-wcaio-cart-icon-shake_horizontal {
               0% {
		            transform: scale(' . $sc_icon_scale . ');
	            }
	           10%, 20% {
		            transform: scale(' . $sc_icon_scale . ') translateX(-10%);
	           }
	           30%, 50%, 70%, 90% {
		            transform: scale(' . $sc_icon_scale . ') translateX(10%);
	           }
	           40%, 60%, 80% {
		            transform: scale(' . $sc_icon_scale . ') translateX(-10%);
	           }
            	100% {
            		transform: scale(' . $sc_icon_scale . ');
            	}
            }
            @keyframes vi-wcaio-cart-icon-shake_vertical {
               0% {
		            transform: scale(' . $sc_icon_scale . ');
	            }
	           10%, 20% {
	                transform: scale(' . ( $sc_icon_scale * 0.9 ) . ') rotate3d(0, 0, 1, -3deg);
	           }
	           30%, 50%, 70%, 90% {
		            transform: scale(' . ( $sc_icon_scale * 1.1 ) . ') rotate3d(0, 0, 1, 3deg);
	           }
	           40%, 60%, 80% {
		            transform: scale(' . ( $sc_icon_scale * 1.1 ) . ') rotate3d(0, 0, 1, -3deg);
	           }
            	100% {
            		transform: scale(' . $sc_icon_scale . ');
            	}
            }';
		}
		if ( $sc_icon_hover_scale = $this->settings->get_params( 'sc_icon_hover_scale' ) ) {
			$css .= '@keyframes vi-wcaio-cart-icon-mouseenter {
                from {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_scale . ');
                }
                to {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_hover_scale . ');
                }
            }
            @keyframes vi-wcaio-cart-icon-mouseleave {
                from {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_hover_scale . ');
                }
                to {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_scale . ');
                }
            }
            @keyframes vi-wcaio-cart-icon-slide_out_left {
                from {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_hover_scale . ');
                    visibility: visible;
                    opacity: 1;
                }
                to {
                    transform: translate3d(-100%, 0, 0) scale(' . $sc_icon_hover_scale . ');
                    visibility: hidden;
                    opacity: 0;
                }
            }
            @keyframes vi-wcaio-cart-icon-slide_out_right {
                from {
                    transform: translate3d(0, 0, 0) scale(' . $sc_icon_hover_scale . ');
                    visibility: visible;
                    opacity: 1;
                }
                to {
                    transform: translate3d(100%, 0, 0) scale(' . $sc_icon_hover_scale . ');
                    visibility: hidden;
                    opacity: 0;
                }
            }';
		}
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart-icon-wrap' ),
			array( 'sc_icon_border_radius', 'sc_icon_bg_color' ),
			array( 'border-radius', 'background' ),
			array( 'px', '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart-icon-wrap .vi-wcaio-sidebar-cart-icon i' ),
			array( 'sc_icon_color' ),
			array( 'color' ),
			array( '' )
		);
		$css .= $frontend::add_inline_style(
			array( '.vi-wcaio-sidebar-cart-icon-wrap .vi-wcaio-sidebar-cart-count-wrap' ),
			array( 'sc_icon_count_bg_color', 'sc_icon_count_color', 'sc_icon_count_border_radius' ),
			array( 'background', 'color', 'border-radius' ),
			array( '', '', 'px' )
		);
		$css = str_replace( array( "\r", "\n", "\t" ,'\r', '\n' , '\t'), ' ', $css );
		return $css;
	}
	public function assign_page() {
		if ( ! $this->settings->enable( 'sc_' )  ) {
			return false;
		}
		$assign_page = $this->settings->get_params( 'sc_assign_page' );
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
				return false;
			}
		}

		return true;
	}

	private function get_params( $name = '') {
		if ( $this->customize_data && $name && $setting = $this->customize_data->get_setting( 'woo_cart_all_in_one_params[' . $name . ']' ) ) {
			return $this->customize_data->post_value( $setting, $this->settings->get_params( $name ) );
		} else {
			return $this->settings->get_params( $name );
		}
	}
}