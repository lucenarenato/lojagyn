<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$class   = array(
	'vi-wcaio-sidebar-cart-content-close',
	'vi-wcaio-sidebar-cart-content-wrap',
);
$is_customize = $sidebar_cart::is_customize_preview();
$class[] = $is_customize ? 'vi-wcaio-sidebar-cart-content-wrap-customize' : '';
$class[] = is_user_logged_in() ? 'vi-wcaio-sidebar-cart-content-wrap-logged' : '';
$class   = trim( implode( ' ', $class ) );
$wc_cart = WC()->cart;
do_action( 'vi_wcaio_before_mini_cart' );
$last_applied_coupon   = '';
if ( wc_coupons_enabled() && $wc_cart && ! $wc_cart->is_empty() ) {
	$applied_coupons = method_exists( $wc_cart, 'get_applied_coupons' ) ? $wc_cart->get_applied_coupons() : '';
	if ( ! empty( $applied_coupons ) ) {
		$last_applied_coupon   = $applied_coupons[ count( $applied_coupons ) - 1 ];
	}
}
?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <div class="vi-wcaio-sidebar-cart-header-wrap">
            <div class="vi-wcaio-sidebar-cart-header-title-wrap">
				<?php echo wp_kses_post( $sidebar_cart->get_params( 'sc_header_title' ) ); ?>
            </div>
			<?php
			if ( $is_customize || $sidebar_cart::$settings->get_params( 'sc_header_coupon_enable' ) ) {
			    if ($last_applied_coupon){
				    $last_applied_coupon_t= $last_applied_coupon;
                }else{
				    $last_applied_coupon_t= esc_attr__( 'Coupon code', 'woo-cart-all-in-one' );
                }
				?>
                <div class="vi-wcaio-sidebar-cart-header-coupon-wrap">
                    <input type="text" name="coupon_code" id="coupon_code" class="vi-wcaio-coupon-code"
                           placeholder="<?php echo esc_attr( $last_applied_coupon_t ); ?>">
                    <button type="submit" class="button vi-wcaio-bt-coupon-code" name="apply_coupon">
						<?php echo sprintf( '%s', apply_filters( 'vi_wcaio_get_bt_coupon_text', esc_html__( 'Apply', 'woo-cart-all-in-one' ) ) ); ?>
                    </button>
                </div>
				<?php
			}
			?>
            <div class="vi-wcaio-sidebar-cart-close-wrap">
                <i class="vi_wcaio_cart_icon-clear-button"></i>
            </div>
        </div>
        <div class="vi-wcaio-sidebar-cart-content-wrap1 vi-wcaio-sidebar-cart-products-wrap">
			<?php
			do_action( 'vi_wcaio_before_mini_cart_content' );
			?>
            <ul class="vi-wcaio-sidebar-cart-products">
				<?php
				$sidebar_cart::get_sidebar_content_pd_html( $wc_cart );
				?>
            </ul>
			<?php
			do_action( 'vi_wcaio_after_mini_cart_content' );
			?>
        </div>
        <div class="vi-wcaio-sidebar-cart-footer-wrap">
            <div class="vi-wcaio-sidebar-cart-footer vi-wcaio-sidebar-cart-footer-products">
				<?php
				$sc_footer_cart_total       = $sidebar_cart->get_params( 'sc_footer_cart_total' ) ?: 'total';
				$sc_footer_cart_total_title = $sidebar_cart->get_params( 'sc_footer_cart_total_text' );
				$sc_footer_button           = $sidebar_cart->get_params( 'sc_footer_button' ) ?: 'cart';
				if ( $is_customize ) {
					?>
                    <div class="vi-wcaio-sidebar-cart-footer-cart_total-wrap">
                        <div class="vi-wcaio-sidebar-cart-footer-cart_total vi-wcaio-sidebar-cart-footer-total<?php echo esc_attr( $sc_footer_cart_total === 'total' ? '' : ' vi-wcaio-disabled' ); ?>"
                             data-cart_total="<?php echo esc_attr( $cart_total = $wc_cart->get_total() ); ?>">
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total-title"><?php echo wp_kses_post( $sc_footer_cart_total_title ); ?></div>
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total1">
								<?php echo wp_kses_post( $cart_total ); ?>
                            </div>
                        </div>
                        <div class="vi-wcaio-sidebar-cart-footer-cart_total vi-wcaio-sidebar-cart-footer-subtotal<?php echo esc_attr( $sc_footer_cart_total !== 'total' ? '' : ' vi-wcaio-disabled' ); ?>"
                             data-cart_total="<?php echo esc_attr( $cart_subtotal = $wc_cart->get_cart_subtotal() ); ?>">
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total-title"><?php echo wp_kses_post( $sc_footer_cart_total_title ); ?></div>
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total1">
								<?php echo wp_kses_post( $cart_subtotal ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="vi-wcaio-sidebar-cart-footer-action">
                        <button class="vi-wcaio-sidebar-cart-bt vi-wcaio-sidebar-cart-bt-update button">
	                        <?php echo wp_kses_post( apply_filters( 'vi_wcaio_get_bt_update_text', esc_html__( 'Update Cart', 'woo-cart-all-in-one' ) ) ); ?>
                        </button>
                        <a href="<?php echo esc_attr( esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ) ); ?>"
                           class="button vi-wcaio-sidebar-cart-bt vi-wcaio-sidebar-cart-bt-nav vi-wcaio-sidebar-cart-bt-nav-cart<?php echo  esc_attr($sc_footer_button === 'cart' ? '' : ' vi-wcaio-disabled' ); ?>">
							<?php echo wp_kses_post( $sidebar_cart->get_params( 'sc_footer_bt_cart_text' ) ); ?>
                        </a>
                        <a href="#" data-href="<?php echo esc_attr( esc_url( get_permalink( wc_get_page_id( 'checkout' ) ) ) ); ?>"
                           class="button vi-wcaio-sidebar-cart-bt vi-wcaio-sidebar-cart-bt-nav vi-wcaio-sidebar-cart-bt-nav-checkout<?php echo esc_attr($sc_footer_button === 'checkout' ? '' :  ' vi-wcaio-disabled' ); ?>">
							<?php echo wp_kses_post( $sidebar_cart->get_params( 'sc_footer_bt_checkout_text' ) ); ?>
                        </a>
                    </div>
					<?php
				} else {
					?>
                    <div class="vi-wcaio-sidebar-cart-footer-cart_total-wrap">
                        <div class="vi-wcaio-sidebar-cart-footer-cart_total vi-wcaio-sidebar-cart-footer-<?php echo esc_attr( $sc_footer_cart_total ); ?>">
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total-title"><?php echo wp_kses_post( $sc_footer_cart_total_title ); ?></div>
                            <div class="vi-wcaio-sidebar-cart-footer-cart_total1">
								<?php echo $sc_footer_cart_total === 'total' ? wp_kses_post( $wc_cart->get_cart_total() ) : wp_kses_post( $wc_cart->get_cart_subtotal() ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="vi-wcaio-sidebar-cart-footer-action">
                        <button class="vi-wcaio-sidebar-cart-bt vi-wcaio-sidebar-cart-bt-update vi-wcaio-disabled button">
							<?php echo wp_kses_post( apply_filters( 'vi_wcaio_get_bt_update_text', esc_html__( 'Update Cart', 'woo-cart-all-in-one' ) ) ); ?>
                        </button>
                        <a href="<?php echo esc_attr( esc_url( get_permalink( wc_get_page_id( $sc_footer_button ) ) ) ); ?>"
                           class="button vi-wcaio-sidebar-cart-bt vi-wcaio-sidebar-cart-bt-nav vi-wcaio-sidebar-cart-bt-nav-<?php echo esc_attr( $sc_footer_button ); ?>">
		                    <?php echo wp_kses_post( $sidebar_cart::$settings->get_params( 'sc_footer_bt_' . $sc_footer_button . '_text' ) ); ?>
                        </a>
                    </div>
					<?php
				}
				?>
            </div>
            <div class="vi-wcaio-sidebar-cart-footer-message-wrap">
				<?php
				$sidebar_cart::get_sc_footer_message_html( $sidebar_cart->get_params( 'sc_footer_message' ) );
				?>
            </div>
        </div>
        <div class="vi-wcaio-sidebar-cart-loading-wrap vi-wcaio-disabled">
			<?php
			$sc_loading = $sidebar_cart::$settings->get_params( 'sc_loading' );
			if ( $is_customize ) {
				$loading = array(
					'default',
					'dual_ring',
					'animation_face_1',
					'animation_face_2',
					'ring',
					'roller',
					'loader_balls_1',
					'loader_balls_2',
					'loader_balls_3',
					'ripple',
					'spinner'
				);
				foreach ( $loading as $item ) {
					$sidebar_cart->get_sidebar_loading( $item );
				}
			} elseif ( $sc_loading ) {
				$sidebar_cart->get_sidebar_loading( $sc_loading );
			}
			?>
        </div>
    </div>
<?php do_action( 'vi_wcaio_after_mini_cart' ); ?>