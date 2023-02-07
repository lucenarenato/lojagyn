<?php 
/**
 * Template file for displaying product sticky bar
 *
 * @package Goya
 */

global $product;		

$bar_status = get_theme_mod('product_sticky_bar', true);
$catalog_mode = get_theme_mod('shop_catalog_mode', false);

remove_all_actions('woocommerce_before_add_to_cart_form');
remove_all_actions('woocommerce_after_add_to_cart_form');

remove_all_actions('woocommerce_before_variations_form');
remove_all_actions('woocommerce_before_single_variation');
remove_all_actions('woocommerce_after_single_variation');
remove_all_actions('woocommerce_after_variations_form');

remove_all_actions('woocommerce_before_add_to_cart_button');

remove_all_actions('woocommerce_before_add_to_cart_quantity');
remove_all_actions('woocommerce_after_add_to_cart_quantity');
remove_all_actions('woocommerce_after_add_to_cart_button');

// Wrapper for quantity and add to cart button
if ( $product->is_type( 'grouped' ) ) {
	add_action('woocommerce_before_add_to_cart_button', 'goya_wishlist_div_open', 1);
} else {
	add_action('woocommerce_before_add_to_cart_quantity', 'goya_wishlist_div_open', 1);
}
add_action('woocommerce_after_add_to_cart_button', 'goya_extra_div_close', 2);

$trigger_only = apply_filters('goya_sticky_atc_trigger_only', get_theme_mod('product_sticky_bar_trigger_only', false) );

// Exclude some product types
$product_types = array(
	'mix-and-match',
	'bundle',
);
$exclusions = apply_filters( 'goya_product_bar_exclusions', $product_types );

?>

<?php if ( is_product() && $bar_status == true && $catalog_mode == false  && !in_array($product->get_type(), $exclusions) )  { ?>
	<div class="sticky-product-bar <?php if ($trigger_only == true) { echo esc_attr( 'trigger-only' ); } ?>">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sticky-product-bar-content sticky-product-type-<?php echo esc_attr( $product->get_type() ); ?>">

						<div class="sticky-product-bar-image">
							<?php if ( has_post_thumbnail() ) {
								$image = get_the_post_thumbnail( $post->ID, apply_filters( 'goya_sticky_product_thumbnail_size', 'thumbnail' ) );
								echo apply_filters( 'goya_sticky_product_details_html', $image, $post->ID ); } ?>
						</div>

						<div class="sticky-product-bar-title"><h4><?php echo esc_attr( $product->get_title() ); ?></h4></div>

						<?php if ( $product->is_type( 'grouped' ) || $product->is_type( 'variable' ) || $trigger_only == true && !$product->is_type( 'external' )) { ?>
							
							<a href="#" class="sticky_add_to_cart add_to_cart add_to_cart_button button"><?php esc_html_e( 'Add to cart', 'woocommerce' ); ?></a>

						<?php } ?>

						<?php if ( !$product->is_type( 'grouped' ) && !$trigger_only == true ) { ?>

							<?php if ( !$product->is_type( 'variable' ) ) {
								echo '<span class="price">'. $product->get_price_html() . '</span>';
							} ?>

							<?php woocommerce_template_single_add_to_cart() ?>
						
						<?php } ?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }