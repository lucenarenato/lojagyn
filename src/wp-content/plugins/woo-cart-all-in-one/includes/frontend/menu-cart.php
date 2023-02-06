<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class VI_WOO_CART_ALL_IN_ONE_Frontend_Menu_Cart {
	protected $settings;

	public function __construct() {
		$this->settings = new VI_WOO_CART_ALL_IN_ONE_DATA();
		add_action( 'wp_enqueue_scripts', array( $this, 'viwcaio_wp_enqueue_scripts' ), 99 );
		add_filter( 'wp_nav_menu_items', array( $this, 'create_menu_cart' ), PHP_INT_MAX, 2 );
	}

	public function create_menu_cart( $items, $args ) {
		if ( ! is_customize_preview() && ! $this->settings->enable( 'mc_' ) ) {
			return $items;
		}
		$mc_menu_display = $this->settings->get_params( 'mc_menu_display' );
		if ( empty( $mc_menu_display ) ) {
			return $items;
		}
		$menu_id = $args->menu->term_id ?? $args->menu ?? '';
		if ( ! $menu_id || ! in_array( $menu_id, $mc_menu_display ) ) {
			return $items;
		}
		$is_wcaio_menu = strstr( $items, 'vi-wcaio-menu-cart' );
		if ( ! $is_wcaio_menu ) {
			$wc_cart            = WC()->cart;
			$mc_content         = $this->settings->get_params( 'mc_content' );
			$mc_display_style   = $this->settings->get_params( 'mc_display_style' );
			$mc_cart_total      = $this->settings->get_params( 'mc_cart_total' );
			$mc_empty_enable    = $this->settings->get_params( 'mc_empty_enable' );
			$nav_url            = get_permalink( wc_get_page_id( $mc_nav_page = $this->settings->get_params( 'mc_nav_page' ) ) );
			$nav_title          = $mc_nav_page === 'cart' ? esc_html__( 'View your shopping cart', 'woo-cart-all-in-one' ) : esc_html__( 'Quick checkout', 'woo-cart-all-in-one' );
			$cart_content_count = is_admin() || ! $wc_cart ? 0 : $wc_cart->get_cart_contents_count();
			if ( $mc_cart_total === 'total' ) {
				$cart_total = is_admin() || ! $wc_cart ? wc_price( 0 ) : $wc_cart->get_total();
			} else {
				$cart_total = is_admin() || ! $wc_cart ? wc_price( 0 ) : $wc_cart->get_cart_subtotal();
			}
			$class   = array(
				'vi-wcaio-menu-cart',
			);
			$class[] = is_rtl() ? 'vi-wcaio-menu-cart-rtl' : '';
			$class[] = $mc_content ? 'vi-wcaio-menu-cart-show' : '';
			$class[] = ( is_customize_preview() && ! $this->settings->enable( 'mc_' ) ) || ( ! $mc_empty_enable && $wc_cart && $wc_cart->is_empty() ) ? 'vi-wcaio-disabled' : '';
			$class   = trim( implode( ' ', $class ) );
			ob_start();
			?>
            <li class="<?php echo esc_attr( $class ); ?>" data-empty_enable="<?php echo esc_attr( $mc_empty_enable ?: '' ); ?>">
                <a href="<?php echo esc_attr( $nav_url ?: '#' ); ?>" title="<?php echo apply_filters( 'vi_wcaio_menu_nav_title', esc_attr( $nav_title ) ); ?>" class="vi-wcaio-menu-cart-nav-wrap">
                    <span class="vi-wcaio-menu-cart-icon">
                        <i class="<?php echo esc_attr( $this->settings->get_class_icon( $this->settings->get_params( 'mc_icon' ), 'cart_icons' ) ); ?>"></i>
                    </span>
                    <span class="vi-wcaio-menu-cart-text-wrap">
                        <?php
                        $this->get_menu_cart_text( $mc_display_style, $cart_total, $cart_content_count );
                        ?>
                    </span>
                </a>
				<?php
				if ( $wc_cart && ( is_customize_preview() || ( $mc_content && ! wp_is_mobile() && ! is_cart() && ! is_checkout() ) ) ) {
					?>
                    <div class="vi-wcaio-menu-cart-content-wrap">
                        <div class="widget woocommerce widget_shopping_cart">
                        <div class="widget_shopping_cart_content">
						<?php
						woocommerce_mini_cart();
						?>
                        </div>
                    </div>
					<?php
				}
				?>
            </li>
			<?php
			$html  = ob_get_clean();
			$items .= $html;
		}

		return $items;
	}

	public static function get_menu_cart_text( $display_style, $cart_total, $cart_content_count ) {
		if ( ! $display_style ) {
			return;
		}
		switch ( $display_style ) {
			case 'product_counter':
				$text = $cart_content_count;
				break;
			case 'price':
				$text = $cart_total;
				break;
			default:
				$text = $cart_content_count . ' - ' . $cart_total;
		}
		echo sprintf( '<span class="vi-wcaio-menu-cart-text vi-wcaio-menu-cart-text-%s">%s</span>', esc_attr( $display_style ), wp_kses_post( $text ) );
	}

	public function viwcaio_wp_enqueue_scripts() {
		if ( ! is_customize_preview() && ! $this->settings->enable( 'mc_' ) && empty( $mc_menu_display = $this->settings->get_params( 'mc_menu_display' ) ) ) {
			return;
		}
		wp_enqueue_style( 'vi-wcaio-cart-icons', VI_WOO_CART_ALL_IN_ONE_CSS . 'cart-icons.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		wp_enqueue_style( 'vi-wcaio-menu-cart', VI_WOO_CART_ALL_IN_ONE_CSS . 'menu-cart.min.css', array(), VI_WOO_CART_ALL_IN_ONE_VERSION );
		if ( WP_DEBUG ) {
			wp_enqueue_script( 'vi-wcaio-menu-cart', VI_WOO_CART_ALL_IN_ONE_JS . 'menu-cart.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		} else {
			wp_enqueue_script( 'vi-wcaio-menu-cart', VI_WOO_CART_ALL_IN_ONE_JS . 'menu-cart.min.js', array( 'jquery' ), VI_WOO_CART_ALL_IN_ONE_VERSION );
		}
		if ( ! is_customize_preview() ) {
			$css = $this->get_inline_css();
			wp_add_inline_style( 'vi-wcaio-menu-cart', $css );
		}
	}

	public function get_inline_css() {
		$css      = '';
		$frontend = 'VI_WOO_CART_ALL_IN_ONE_Frontend_Frontend';
		$css      .= $frontend::add_inline_style(
			array( '.vi-wcaio-menu-cart .vi-wcaio-menu-cart-icon i' ),
			array( 'mc_icon_color' ),
			array( 'color' ),
			array( '' )
		);
		$css      .= $frontend::add_inline_style(
			array( '.vi-wcaio-menu-cart .vi-wcaio-menu-cart-nav-wrap:hover .vi-wcaio-menu-cart-icon i' ),
			array( 'mc_icon_hover_color' ),
			array( 'color' ),
			array( '' )
		);
		$css      .= $frontend::add_inline_style(
			array( '.vi-wcaio-menu-cart .vi-wcaio-menu-cart-text-wrap *' ),
			array( 'mc_color' ),
			array( 'color' ),
			array( '' )
		);
		$css      .= $frontend::add_inline_style(
			array( '.vi-wcaio-menu-cart .vi-wcaio-menu-cart-nav-wrap:hover .vi-wcaio-menu-cart-text-wrap *' ),
			array( 'mc_hover_color' ),
			array( 'color' ),
			array( '' )
		);

		return $css;
	}
}