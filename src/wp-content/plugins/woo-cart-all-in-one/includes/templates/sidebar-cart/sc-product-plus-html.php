<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $product_id || ! $product = wc_get_product( $product_id ) ) {
	return;
}
$product_permalink = $product->get_permalink();
$product_name      = $product->get_name();
$img_url           = wp_get_attachment_image_url( get_post_thumbnail_id( $product_id ), 'woocommerce_gallery_thumbnail' ) ?? wc_placeholder_img_src( 'woocommerce_gallery_thumbnail' );
?>
<div class="vi-wcaio-sidebar-cart-footer-pd vi-wcaio-sidebar-cart-footer-pd-type-1">
	<div class="vi-wcaio-sidebar-cart-footer-pd-desc-wrap">
		<div class="vi-wcaio-sidebar-cart-footer-pd-img">
			<?php
			echo $product_permalink ? sprintf( '<a href="%s"><img src="" data-src="%s" class="vi-wcaio-sidebar-cart-footer-pd-img1" alt="%s"></a>', esc_url( $product_permalink ), esc_url( $img_url ), $product_name ) :
				sprintf( '<img src="" data-src="%s" class="vi-wcaio-sidebar-cart-footer-pd-img1" alt="%s">', esc_url( $img_url ), $product_name );
			?>
		</div>
		<div class="vi-wcaio-sidebar-cart-footer-pd-desc">
			<div class="vi-wcaio-sidebar-cart-footer-pd-name">
				<?php
				if ( $product_permalink ) {
					echo sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_attr( $product_name ) );
				} else {
					echo wp_kses_post( $product_name );
				}
				?>
			</div>
			<div class="vi-wcaio-sidebar-cart-footer-pd-price">
				<?php echo wp_kses( $product->get_price_html(), VI_WOO_CART_ALL_IN_ONE_DATA::extend_post_allowed_html() ); ?>
			</div>
		</div>
	</div>
	<div class="vi-wcaio-sidebar-cart-footer-pd-control">
		<?php
		do_action( 'vi_wcaio_sc_pd_plus_' . $product->get_type() . '_atc', $product, $settings );
		?>
	</div>
</div>