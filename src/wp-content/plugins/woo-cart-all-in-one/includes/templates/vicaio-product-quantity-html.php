<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty( $args ) ) {
	return '';
}
extract( $args );
if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="vi-wcaio-sidebar-cart-pd-quantity vi-wcaio-hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>">
	</div>
	<?php
} else {
	?>
	<div class="vi-wcaio-sidebar-cart-pd-quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<span class="vi_wcaio_change_qty vi_wcaio_minus">-</span>
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
		<span class="vi_wcaio_change_qty vi_wcaio_plus">+</span>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}
?>