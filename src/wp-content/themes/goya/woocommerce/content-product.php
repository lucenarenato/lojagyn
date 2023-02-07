<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $product, $woocommerce_loop;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$vars = $wp_query->query_vars;

$item_style = array_key_exists('goya_product_style', $vars) ? $vars['goya_product_style'] : false;
$item_animation = array_key_exists('goya_product_animation', $vars) ? $vars['goya_product_animation'] : false;
$item_hover_img = array_key_exists('goya_product_hover_image', $vars) ? $vars['goya_product_hover_image'] : false;
$item_quickview = array_key_exists('goya_product_quickview', $vars) ? $vars['goya_product_quickview'] : false;
$item_skip_lazy = array_key_exists('goya_product_skip_lazy', $vars) ? $vars['goya_product_skip_lazy'] : 0;
$item_column_large = array_key_exists('goya_product_columns_large', $vars) ? $vars['goya_product_columns_large'] : get_theme_mod('shop_columns', 4);
$item_column_mobile = array_key_exists('goya_product_columns_mobile', $vars) ? $vars['goya_product_columns_mobile'] : get_theme_mod('shop_columns_mobile', 2);


// Color/image Swatches
add_action( 'goya_woocommerce_after_shop_loop_item', 'goya_add_loop_variation_swatches', 9 );

// Columns large
if ( isset( $_GET['col'] ) ) {
	$columns_large = intval( sanitize_key( $_GET['col'] ) );
} else if ( ( isset( $woocommerce_loop['columns'] ) && $woocommerce_loop['columns'] != '' ) ) {
	$columns_large = $woocommerce_loop['columns'];
} else {
	$columns_large = $item_column_large;
}

// Calculate other numbers of columns
if ( intval( $columns_large ) == 1 ) {

	$columns_medium = $columns_small = $columns_xsmall = $columns_large;

} else {
	
	// Columns medium
	if ( intval( $columns_large ) < 3 ) {
	$columns_medium = '2';
	} else {
	$columns_medium = ( isset( $woocommerce_loop['columns_medium'] ) ) ? $woocommerce_loop['columns_medium'] : '3';
	}

	// Columns small
	$columns_small = ( isset( $woocommerce_loop['columns_small'] ) ) ? $woocommerce_loop['columns_small'] : '2';

	// Columns x-small
	$columns_xsmall = ( isset( $woocommerce_loop['columns_xsmall'] ) ) ? $woocommerce_loop['columns_xsmall'] : $item_column_mobile;
}


// Classes
$classes[] = 'item';
$classes[] = 'et-listing-'.$item_style;

// Animation
$inner_classes[] = 'product-inner';
$inner_classes[] = $item_animation;

// Masonry/Columns size
if (array_key_exists('goya_masonry_list', $vars)) {
	$masonry_size = get_post_meta($id, 'goya_product_masonry_size', true);
	$masonry_size = ($masonry_size) ? $masonry_size : 'small';
	$masonry_adjust = goya_get_masonry_size($masonry_size);
	$classes[] = $masonry_adjust['class'];
	$image_size = $masonry_adjust['image_size'];

	// If masonry get the product categories
	$terms = get_the_terms( $id, 'product_cat' );

	$cats = '';	
	if (!empty($terms)) {
		foreach ($terms as $term) { $cats .= ' cat-'.strtolower($term->slug); }
	}

	$classes[] = $cats;

} else {
	$classes[] = 'col-' . 12 / $columns_xsmall;
	$classes[] = 'col-sm-' . 12 / $columns_small;
	$classes[] = 'col-md-' . 12 / $columns_medium;
	
	if($columns_large != 5) {
		$classes[] = 'col-lg-' . 12 / $columns_large;
	} else {
		$classes[] = 'large_grid_5';
	}

	// Small grid class
	$classes[] = 'small_grid_' . ( $columns_large + 1 );
}

// Hover product image
$thumbnail_class = ( $item_hover_img ) ? 'et-image-hover' : '';

// Image class
$image_class = 'main-image';
if ($wp_query->current_post < $item_skip_lazy) {
	$image_class .= ' skip-lazy';
}

?>

<li <?php wc_product_class($classes, $product); ?>>
	<div class="<?php echo esc_attr(implode(' ', $inner_classes)); ?>">
	<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
	?>
	<figure class="product_thumbnail <?php echo esc_attr($thumbnail_class); ?>">  
		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php
				if ( has_post_thumbnail( $product->get_id() ) ) {   
					echo  get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => $image_class ) );
				} else {
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
				}
				// Alternative/hover image
				if ($item_hover_img == 1) {
					echo goya_product_thumbnail_alt( $product );
			} ?></a>
		<?php
			/**
			 * Hook: woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<div class="actions-wrapper">
			<div class="actions-inner">
				<?php if ($item_style != 'style1' ) { goya_wishlist_button('loop'); } ?>
				<?php if ($item_style == 'style2' || $item_style == 'style3' ) { woocommerce_template_loop_add_to_cart(); } ?>
				<?php 
				if ( $item_quickview == true ) {
					goya_loop_quick_view();
				} ?>
			</div>
		</div>
	</figure>
	<div class="caption">
		<div class="product-title">
			<h2><a class="product-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php if ($item_style === 'style1') { goya_wishlist_button('loop'); } ?>
		</div>
		<?php 
			/**
			 * Hook: woocommerce_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
		?>

		<div class="product_after_title">

			<div class="product_after_shop_loop_price">
				<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item_title.
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</div>

			<div class="product-excerpt">
				<?php the_excerpt(); ?>
			</div>

			<div class="after_shop_loop_actions">

				<?php 
					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
				 ?>
			</div>

		</div>

		<?php do_action( 'goya_woocommerce_after_shop_loop_item' ); ?>

	</div>

	</div>

</li>