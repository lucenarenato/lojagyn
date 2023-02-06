<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
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
				$quantity_args = apply_filters( 'viwcaio_quantity_input_args', array(
					'input_name'   => "quantity",
					'input_value'  => 1,
					'max_value'    => $product->get_max_purchase_quantity(),
					'min_value'    => '0',
					'classes'      => [ 'vi-wcaio-va-qty-input' ],
					'product_name' => $product_name
				), $product );
				echo apply_filters( 'vi_wcaio_va_qty', VI_WOO_CART_ALL_IN_ONE_Frontend_Frontend::product_get_quantity_html( $quantity_args ), $product, $quantity_args );
				?>
			</div>
			<div class="vi-wcaio-va-action-wrap">
				<button class="vi-wcaio-product-bt-atc vi-wcaio-va-product-bt-atc button alt"
				        data-quantity="1"
				        data-product_id="<?php echo esc_attr( $product_id ); ?>">
					<?php esc_html_e( 'Add To Cart', 'woo-cart-all-in-one' ); ?>
				</button>
				<input type="hidden" name="add-to-cart" class="vi-wcaio-add-to-cart"
				       value="<?php echo esc_attr( $product_id ); ?>"/>
				<input type="hidden" name="product_id" class="vi-wcaio-product_id"
				       value="<?php echo esc_attr( $product_id ); ?>"/>
				<input type="hidden" name="variation_id" class="variation_id" value="0"/>
			</div>
			<?php do_action( 'vi_wcaio_after_add_to_cart_button' ); ?>
			<span class="vi-wcaio-va-product-bt-atc-cancel">x</span>
		</div>
	</div>
	<div class="vi-wcaio-va-cart-form-overlay"></div>
</div>