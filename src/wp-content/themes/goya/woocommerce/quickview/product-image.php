<?php
/**
 *	ET: Quickview Product Image
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();
$transition = get_theme_mod('product_gallery_transition','slide');

$slider_disabled_class = ( count( $attachment_ids ) == 0 ) ? ' et-carousel-disabled' : ' slick-slider slick-arrows-small slick-dots-inside carousel slick';
?>

<div class="images">
	<div id="et-quickview-slider" class="et-quickview-gallery-slider product-images <?php echo esc_attr( $slider_disabled_class ); ?>" data-navigation="true" data-pagination="true" data-autoplay="false" data-columns="1" data-fade="<?php echo ($transition == 'fade') ?  'true' : 'false' ?>">
		<?php
		// Featured image
		if ( has_post_thumbnail() ) {
			$image = '<div class="woocommerce-product-gallery__image">' . get_the_post_thumbnail( $post->ID, apply_filters( 'goya_quickview_thumbnail_size', 'medium_large' ) ) . '</div>';
			echo apply_filters( 'goya_quickview_single_product_image_html', '<div>' . $image . '</div>', $post->ID );
		} else {
			echo apply_filters( 'goya_quickview_single_product_image_html', sprintf( '<div><img src="%s" alt="%s" /></div>', wc_placeholder_img_src(), '' ), $post->ID );
		}

		// Gallery images
		if ( $attachment_ids ) {
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
								
				if ( ! $image_link ) {
					continue;
				}
			
				$image = '<div class="woocommerce-product-gallery__image">' . wp_get_attachment_image( $attachment_id, apply_filters( 'goya_quickview_thumbnail_size', 'medium_large' ) ) . '</div>';
		
				echo apply_filters( 'goya_quickview_single_product_image_html', '<div>' . $image .'</div>', $post->ID );
			}
		}
	?>
	</div>
</div>