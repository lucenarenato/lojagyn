<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop, $wp_query;;

$vars = $wp_query->query_vars;

// Product style
if ( (is_shop() || is_tax()) && isset( $_GET['product_style'] ) ) {
	$item_style = sanitize_key( $_GET['product_style'] );
} else {
	$item_style = get_theme_mod('shop_product_listing', 'style1');
}

// Hover image
$item_hover_img = goya_meta_config('shop','product_img_hover',true);

// Hover animation
$item_hover_animation = goya_meta_config('shop','product_animation_hover','zoom-jump');

// Loading animation
$item_animation = goya_meta_config('shop','product_animation','animation bottom-to-top');

// Quick view
$item_quickview = get_theme_mod('product_quickview', true);

// Skip lazyload
if ( apply_filters('goya_do_lazyload', get_theme_mod('lazy_load',false)) == true ) {
	$item_skip_lazy = get_theme_mod('lazy_load_skip', 6);
} else {
	$item_skip_lazy = 0;
}

// Add to cart always visible
$atc_visible = implode( '-', get_theme_mod('shop_addtocart_visible', array() ) );
if ($atc_visible != '') {
	$classes[] = 'atc-visible-' . $atc_visible;
}

$classes[] = 'et-main-products';
$classes[] = 'hover-animation-' . $item_hover_animation;

// Variations in archive
$swatches = get_theme_mod('archive_show_swatches', false);
if ($swatches) $classes[] = 'et-shop-show-variations';

// Hover images
if ( $item_hover_img == true ) {
	$classes[] = 'et-shop-hover-images';
}

// Rating
if ( get_theme_mod('rating_listing', true) == true ) {
	$classes[] = 'show-rating';
}

if ( ( get_theme_mod('archive_swatches_position', 'bottom') == 'side') && ( $item_style == 'style1' || $item_style == 'style2' ) ) {
	$classes[] = 'swatches-position-side';
}

// Masonry
$item_masonry = apply_filters('shop_masonry_layout', ''); // deprecated
$item_masonry = apply_filters('goya_shop_masonry_layout', $item_masonry);

if (!empty($item_masonry && !is_product()) ) {
	$classes[] = $item_masonry;
	//set_query_var( 'goya_masonry_list', $item_masonry );
}

if ( isset($woocommerce_loop['shop_archive']) && $woocommerce_loop['shop_archive'] == true ) {
	$classes[] = 'main-shop-archive';
}

// Columns
if ( ( isset( $woocommerce_loop['columns'] ) && $woocommerce_loop['columns'] != '' ) ) {
	$columns = $woocommerce_loop['columns'];
} else {
	$columns = ( isset( $_GET['col'] ) ) ? intval( sanitize_key( $_GET['col'] ) ) : 4;
}

$columns_large = get_theme_mod('shop_columns', 4);
$columns_mobile = get_theme_mod('shop_columns_mobile', 2);


// Set query vars
set_query_var( 'goya_product_style', $item_style );
set_query_var( 'goya_product_animation', $item_animation );
set_query_var( 'goya_product_hover_image', $item_hover_img );
set_query_var( 'goya_product_quickview', $item_quickview );
set_query_var( 'goya_product_skip_lazy', $item_skip_lazy );
set_query_var( 'goya_product_columns_large', $columns_large );
set_query_var( 'goya_product_columns_mobile', $columns_mobile );
set_query_var( 'goya_is_shortcode', false );

?>

<ul class="products row <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" data-mobile-columns="<?php echo esc_attr( $columns_mobile ); ?>" data-navigation="true" data-pagination="true" data-layoutmode="packery">