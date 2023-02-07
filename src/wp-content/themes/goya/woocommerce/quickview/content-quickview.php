<?php
/**
 *	ET: Quick view product content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

if (get_theme_mod('shop_catalog_mode', false) == true) {

	if ( !$product->is_type( 'variable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	} else {
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
	}
}

// Remove breadcrumbs
remove_action('woocommerce_single_product_summary', 'goya_show_breadcrumbs', 1);

// Remove Sizing Guide
remove_action('woocommerce_single_product_summary', 'goya_sizing_guide_link', 29);

// Remove featured video
remove_action( 'woocommerce_single_product_summary', 'goya_woocommerce_featured_video',22 );
;

if ( get_theme_mod('product_reviews', true) == false ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
}

if ( get_theme_mod('product_quickview_atc', true) == false ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'goya_qv_product_summary_open', 1 );
add_action( 'woocommerce_single_product_summary', 'goya_qv_product_summary_divider', 15 );
add_action( 'woocommerce_single_product_summary', 'goya_extra_div_close', 100 );


$cart_layout = get_theme_mod( 'product_cart_buttons_layout','mixed');
$classes[] = 'et-cart-' . $cart_layout;

// Main wrapper class
$classes[] = 'et-product-detail';
$classes[] = 'product' . ' product-' . $product->get_type();

// Ajax Add to Cart 
$ajax_atc = apply_filters('goya_ajax_atc_single_product', get_theme_mod( 'product_single_ajax_addtocart', true ));
if ($ajax_atc) {
	$classes[] = 'single-ajax-atc';	
}

// Options style
$classes[] = 'et-variation-style-' . get_theme_mod('product_variations_style','table');

/* Product color mode */
$showcase_text = get_post_meta($product->get_id(), 'goya_product_showcase_style', true);
$classes[] = 'product-showcase-' . $showcase_text;

do_action( 'goya_quickview_woocommerce_before_single_product' );

?>

<?php if ( !post_password_required() ) : ?>

	<div id="product-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
		<div class="row">
			<div class="et-qv-product-image product-gallery col-lg-7">
				<?php 
				if ( (class_exists('Woo_Variation_Gallery') || class_exists('WooProductVariationGallery') ) && $product->is_type( 'variable' ) ) {
					woocommerce_show_product_images();
				} else {
					goya_quick_view_show_product_images();
				}
				 ?>
			</div>
				
			<div class="et-qv-summary col-lg-5">
				<div id="et-qv-product-summary" class="summary custom_scroll">
						<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked goya_qv_product_summary_open - 1
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked goya_qv_product_summary_divider - 15
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_rating - 21
									 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked goya_qv_product_summary_actions - 30
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked goya_qv_product_summary_open - 100
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
				</div>
			</div>
		</div>
	</div>

<?php else: ?>

	<div class="row">
		<div class="col-9 justify-content-center">
			<?php echo get_the_password_form(); ?>
		</div>
	</div>	

<?php endif; ?>