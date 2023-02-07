<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( get_theme_mod('shop_catalog_mode', false) == true ) {
	if ( !$product->is_type( 'variable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	} else {
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
	}
}

add_action( 'woocommerce_single_product_summary', 'goya_product_summary_open', 1 );
add_action( 'woocommerce_single_product_summary', 'goya_product_summary_divider', 21 );
add_action( 'woocommerce_single_product_summary', 'goya_extra_div_close', 100 );

// Action: woocommerce_before_single_product
remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

// Action: woocommerce_single_product_summary
add_action( 'woocommerce_single_product_summary', 'goya_single_product_price_clearfix', 11 );

$classes[] = 'et-product-detail';

// Single Product Layout
$product_layout = goya_meta_config('product','layout_single','regular');
$classes[] = 'et-product-layout-'.$product_layout;

$transparent_header = goya_meta_config('product','transparent_header',false);
$is_showcase = ($product_layout == 'showcase') ? true : false;

if ($is_showcase) {
	$classes[] = 'et-product-layout-no-padding';

	$transparent_header = apply_filters( 'goya_showcase_transparent_header', true );

	// Move product meta
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 12 );
}

// Transparent header
if ($transparent_header == false) {
	$classes[] = 'page-padding';
} else {
	$classes[] = 'product-header-transparent';
}

$cart_layout = get_theme_mod( 'product_cart_buttons_layout','mixed');

$classes[] = ($is_showcase) ? 'et-cart-horizontal' : 'et-cart-' . $cart_layout;

if ( defined( 'YITH_WCWL_PREMIUM' ) && !$is_showcase ) {
	add_action('woocommerce_single_product_summary', 'goya_wishlist_button_product', 31);
} else {
	// Remove YITH Wishlist default button
	remove_action('woocommerce_single_product_summary', 'yith_wcwl_add_to_wishlist', 31);
	// Add custom Wishlist shortcode
	add_action('woocommerce_after_add_to_cart_button', 'goya_wishlist_button_product', 1);
}

// Add video link after product summary
if ( get_theme_mod('featured_video', 'gallery') == 'summary' || ( get_theme_mod('featured_video', 'gallery') == 'gallery' && $is_showcase == 1 ) ) {
	add_action( 'woocommerce_single_product_summary', 'goya_woocommerce_featured_video',20 );	
}

// If accordion mode move description to right section
$details_style = goya_meta_config('product','details_style','tabs');

$classes[] = 'product-details-' . $details_style;

// Ajax Add to Cart 
$ajax_atc = apply_filters('goya_ajax_atc_single_product', get_theme_mod( 'product_single_ajax_addtocart', true ));
if ($ajax_atc) {
	$classes[] = 'single-ajax-atc';	
}


if ($details_style == 'accordion' && !$is_showcase) {
	
	// Move tabs section to right
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
	add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 36);

	// Move rating stars
	if( get_theme_mod('product_reviews', true) == true && get_theme_mod('shop_catalog_mode', false) == false ) {
		add_action( 'woocommerce_after_single_product_summary', 'comments_template', 13 );
	}

	// Remove reviews and description from tabs
	add_filter( 'woocommerce_product_tabs', 'goya_woocommerce_remove_tabs', 98 );

	// Remove short description
	$swap_description = get_theme_mod('product_accordion_swap_description', true);
	
	if( $swap_description == true ) {

		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);	

		// Add full description to original position
	$show_full_desc = apply_filters( 'goya_show_full_description_accordion', true );
	if ($show_full_desc == true) {
		add_action( 'woocommerce_after_single_product_summary', 'goya_full_description_product', 10 );
	}

	}

	$classes[] =  (get_theme_mod('product_short_desc_open', true) == true ) ? 'first-tab-open' : false;	
}

// Options style
$classes[] = 'et-variation-style-' . get_theme_mod('product_variations_style','table');

// Gallery Style
$gallery_style = goya_meta_config('product','gallery_style','carousel');

$classes[] = 'et-product-gallery-'.$gallery_style;


// Navigation Thumbnails only with Carousel gallery
if($gallery_style == 'carousel') {

	$product_thumbnails_position = goya_meta_config('product','thumbnails_position','side');
	$swap_hover = get_theme_mod('product_thumbnails_swap_hover', false);
	
	if ( $product_thumbnails_position == 'side' && $product_layout != 'full-width' ) {
		$classes[] = 'thumbnails-vertical';
	} else {
		$classes[] = 'thumbnails-horizontal';
	}

	if ($swap_hover == true) {
		$classes[] = 'thumbnails-hover-swap';	
	}

}

// Thumbnails/dots on mobiles
$classes[] = 'thumbnails-mobile-' . get_theme_mod('product_thumbnails_mobile','dots');

// Sold individually
if ( $product->is_sold_individually() ) {
	$classes[] = 'sold-individually';
}


$sticky_section = goya_meta_config('product','sticky_section','summary');

if ($sticky_section != 'none') {
	if ($gallery_style == 'carousel' && $product_layout != 'full-width' ) {
		$classes[] = 'sticky-section sticky-' . $sticky_section;
	} else {
		$classes[] = 'sticky-section sticky-summary';
	}	
}


// Sizing guide: If position is changed also update content-quickview.php */
add_action('woocommerce_single_product_summary', 'goya_sizing_guide', 29);

// Breadcrumbs
$has_breadcrumbs = get_theme_mod('product_breadcrumbs', true);
if ($has_breadcrumbs == true) {
	$classes[] = 'has-breadcrumbs';
}


?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class($classes, $product); ?>>

	<?php
		/**
		 * Hook: woocommerce_before_single_product.
		 *
		 * @hooked wc_print_notices - 10
		 */
		 do_action( 'woocommerce_before_single_product' );

		 if ( post_password_required() ) {
		 	echo get_the_password_form(); // WPCS: XSS ok.
		 	return;
		 }
	?>

	<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php goya_wc_print_notices(); ?>

		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php get_template_part( 'inc/templates/header/header','product-bar'); ?>