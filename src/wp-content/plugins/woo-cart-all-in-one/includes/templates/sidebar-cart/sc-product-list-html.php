<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!$wc_cart || $wc_cart->is_empty() ){
	echo sprintf( '<li class="vi-wcaio-sidebar-cart-pd-empty">%s</li>',
		apply_filters( 'vi_wcaio_get_cart_empty_text', esc_html__( 'No products in the cart.', 'woo-cart-all-in-one' ) ) );
	return;
}
$settings = $sidebar_cart::$settings;
$delete_icon       = $sidebar_cart->get_params( 'sc_pd_delete_icon' );
$delete_icon_class = $settings->get_class_icon( $delete_icon, 'delete_icons' );
foreach ( $wc_cart->get_cart() as $cart_item_key => $cart_item ) {
	$product    = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	if ( $product && $product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $product->is_visible() && $settings->get_params('sc_pd_name_link') ? $product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		$product_thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image(), $cart_item, $cart_item_key );
		?>
		<li class="vi-wcaio-sidebar-cart-pd-wrap" data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>">
			<div class="vi-wcaio-sidebar-cart-pd-img-wrap">
				<?php echo $product_permalink ? sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product_thumbnail ) : wp_kses_post( $product_thumbnail ); ?>
			</div>
			<div class="vi-wcaio-sidebar-cart-pd-info-wrap">
				<div class="vi-wcaio-sidebar-cart-pd-name-wrap">
					<?php
					if ( ! $product_permalink ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<div class="vi-wcaio-sidebar-cart-pd-name">%s</div>', $product->get_name() ), $cart_item, $cart_item_key ) );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="vi-wcaio-sidebar-cart-pd-name">%s</a>', esc_url( $product_permalink ), $product->get_name() ), $cart_item, $cart_item_key ) );
					}
					?>
					<div class="vi-wcaio-sidebar-cart-pd-remove-wrap">
						<?php
						echo apply_filters( 'vi_wcaio_mini_cart_pd_remove',
							sprintf( '<a href="%s" class="vi-wcaio-sidebar-cart-pd-remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="%s"></i></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove this item', 'woo-cart-all-in-one' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $product->get_sku() ),
								$delete_icon_class
							), $cart_item, $cart_item_key );
						?>
					</div>
				</div>
				<div class="vi-wcaio-sidebar-cart-pd-meta">
					<?php echo wp_kses_post( wc_get_formatted_variation( $cart_item['variation'] ??'',true )); ?>
				</div>
				<div class="vi-wcaio-sidebar-cart-pd-desc">
					<?php
					if ( $product->is_sold_individually() ) {
						echo apply_filters( 'vi_wcaio_mini_cart_pd_qty',
							sprintf( '<div class="vi-wcaio-sidebar-cart-pd-quantity vi-wcaio-hidden"><input type="hidden" name="viwcaio_cart[%s][qty]" value="1"></div>', $cart_item_key ),
							$cart_item_key, $cart_item, [] );
					} else {
						$quantity_args = apply_filters( 'viwcaio_quantity_input_args', array(
							'input_name'   => "viwcaio_cart[{$cart_item_key}][qty]",
							'input_value'  => $cart_item['quantity'],
							'max_value'    => $product->get_max_purchase_quantity(),
							'min_value'    => '0',
							'classes'      => [ 'vi_wcaio_qty' ],
							'product_name' => $product->get_name()
						), $product );
						echo apply_filters( 'vi_wcaio_mini_cart_pd_qty', $sidebar_cart::get_sc_pd_quantity_html( $quantity_args ), $cart_item_key, $cart_item, $quantity_args );
					}
					?>
					<div class="vi-wcaio-sidebar-cart-pd-price">
						<?php
						echo wp_kses( $sidebar_cart::get_sc_pd_price_html( $wc_cart, $cart_item, $cart_item_key, $product, $sc_pd_price_style ?? $settings->get_params( 'sc_pd_price_style' ) ), VI_WOO_CART_ALL_IN_ONE_DATA::extend_post_allowed_html() );
						?>
					</div>
				</div>
			</div>
		</li>
		<?php
	}
}
?>