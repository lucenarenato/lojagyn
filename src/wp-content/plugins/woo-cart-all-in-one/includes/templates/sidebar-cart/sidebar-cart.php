<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$class           = array(
	'vi-wcaio-sidebar-cart',
	'vi-wcaio-sidebar-cart-' . $sc_display_type = $sidebar_cart->get_params( 'sc_display_type' ),
	'vi-wcaio-sidebar-cart-' . $sc_position = $sidebar_cart->get_params( 'sc_position' ),
);
$class[]         = is_rtl() ? 'vi-wcaio-sidebar-cart-rtl' : '';
$sc_empty_enable = $sidebar_cart::$settings->get_params( 'sc_empty_enable' );
if ( ! $sidebar_cart->is_customize ) {
	$class[] = ! $sc_empty_enable && WC()->cart->is_empty() ? 'vi-wcaio-disabled' : '';
}
$class = trim( implode( ' ', $class ) );
?>
<div class="vi-wcaio-sidebar-cart-wrap" data-empty_enable="<?php echo esc_attr( $sc_empty_enable ?: '' ); ?>"
     data-effect_after_atc="<?php echo esc_attr( $sidebar_cart::$settings->get_params( 'sc_effect_after_atc' ) ?: '' ); ?>"
     data-fly_to_cart="<?php echo esc_attr( $sidebar_cart::$settings->get_params( 'sc_fly_to_cart' ) ?: '' ); ?>">
    <div class="vi-wcaio-sidebar-cart-overlay vi-wcaio-disabled"></div>
    <div class="<?php echo esc_attr( $class ); ?>" data-type="<?php echo esc_attr( $sc_display_type ); ?>" data-old_position=""
         data-position="<?php echo esc_attr( $sc_position ); ?>"
         data-effect="<?php echo esc_attr( $sidebar_cart::$settings->get_params( 'sc_trigger_style' ) ); ?>">
		<?php
		do_action( 'vi_wcaio_get_sidebar_cart_content' );
		?>
    </div>
</div>