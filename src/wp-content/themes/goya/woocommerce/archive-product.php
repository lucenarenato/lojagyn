<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $woocommerce_loop, $wp_query;

$is_sale_page = $wp_query->is_sale_page;
$is_latest_page = $wp_query->is_latest_page;
$is_main_shop = is_shop();

// OnSale page plugin
if ( $is_sale_page || $is_latest_page ) {
	$is_main_shop = false;	
}

$show_filters_sidebar = $show_filters_popup = $show_filters_header = false;
$shop_class[] = 'shop-container';

// Full Width Catalog
$shop_full_width = goya_meta_config('','shop_full_width', false );
$shop_class[] = ($shop_full_width) ? 'shop-full-width' : '';

$filter_scroll = ( get_theme_mod( 'shop_filters_scrollbar', true ) == true) ? 'shop-widget-scroll' : '';

// Sidebar/Filters
$filters = get_theme_mod('shop_filters', true);
$filter_position = goya_meta_config('shop','filter_position','header');

if ( $filters ) {
	if ( $filter_position == 'sidebar' ) {	
		$show_filters_sidebar  = true;
		$shop_class[] = 'shop-sidebar-' . $filter_position . ' shop-sidebar-position-' . get_theme_mod('shop_filters_sidebar_position', 'left');
	} else {
		$shop_class[] = 'shop-sidebar-' . $filter_position;
		
		if ( $filter_position == 'popup' ) {     
			$show_filters_popup = true;
		}
		if ( $filter_position == 'header' ) {
			$show_filters_header = true;
		}
	}
}

// Get category ID
$cate = get_queried_object();
$cateID = ( ! is_shop() ) ? $cate->term_id : false;

// Shop Header Style
$shop_hero_title = goya_meta_config('shop','hero_title','none');
$shop_header_bg = get_theme_mod( 'shop_header_bg', array() );

$header_class[] = 'hero-header';
$header_bg_class = array();

if ( $shop_hero_title != 'none') {
	
	if ( $is_main_shop && ! is_search() ) {
		if (! empty (get_theme_mod('shop_header_bg_image', '') ) ) {
			$header_bg_class[] = 'parallax_image';
			$header_bg_class[] = 'vh-height';
		}
		$header_bg_class[] = 'hero-title';
	} else if ( is_tax() ) { 
		$term = get_queried_object();
		$term_id = $term->term_id;
		$header_id = get_term_meta( $term_id, 'header_id', true );
		$image = wp_get_attachment_url($header_id, 'full');

		if (! empty($image)) {
			$header_bg_class[] = 'parallax_image';
			$header_bg_class[] = 'vh-height';
		}

		if ($shop_hero_title != 'main-hero') {
			$header_bg_class[] = 'hero-title';
		} else {
			$header_class[] = 'page-padding';
			$header_bg_class[] = 'regular-title';
		}
	} else if ( $is_sale_page || $is_latest_page) {
		$image_url = get_the_post_thumbnail_url(get_queried_object_id(), 'full');
		if ($image_url) {
			$header_bg_class[] = 'parallax_image';
			$header_bg_class[] = 'vh-height';
		}
		if ($shop_hero_title != 'main-hero') {
			$header_bg_class[] = 'hero-title';
		} else {
			$header_class[] = 'page-padding';
			$header_bg_class[] = 'regular-title';
		}
	} else if ($shop_hero_title != 'main-hero') {
		$header_bg_class[] = 'hero-title';
	} else {
		$header_class[] = 'page-padding';
		$header_bg_class[] = 'regular-title';
	}
} else {
	$header_class[] = 'page-padding';
	$header_bg_class[] = 'regular-title';
}

get_header( 'shop' ); ?>

	<div class="<?php echo esc_attr(implode(' ', $header_class)); ?>">
		<div class="<?php echo esc_attr(implode(' ', $header_bg_class)); ?>">
			<div class="container hero-header-container">
				<header class="row woocommerce-products-header">
					<div class="col-lg-8">
						<?php if ( $is_main_shop && !is_search() && get_theme_mod( 'shop_homepage_title_hide', false ) == true) {
							add_filter( 'woocommerce_show_page_title', function() { return false; });
						} ?>
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1 class="et-shop-title woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>
						<?php
						/**
						 * Hook: woocommerce_archive_description.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description' );
						?>

						<?php if ( ( $is_main_shop || is_product_category() ) && !is_search() && get_theme_mod('shop_categories_list', true) == true ) {
							goya_subcategories_by_id( apply_filters( 'goya_shop_header_subcategories', $cateID ) );
						} ?>
					</div>
				</header>
			</div>
		</div>
	</div>

	<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 * @hooked WC_Structured_Data::generate_website_data() - 30
	 */
	do_action( 'woocommerce_before_main_content' );
	?>

	<div class="<?php echo esc_attr(implode(' ', $shop_class)); ?>">
					
		<div id="shop-products" class="shop-products container">
			<div class="row">

				<?php 
					if ( $show_filters_sidebar ) { 
						/**
						 * woocommerce_sidebar hook.
						 *
						 * @hooked woocommerce_get_sidebar - 10
						 */ ?>

						<div class="shop-sidebar-col col <?php echo esc_attr( $filter_scroll ) ?>">
							<?php
							// Otherwise, display sidebar filters
							do_action( 'goya_shop_filters' ); ?>
						</div>
					 <?php }
				?>
				
				<div class="shop-products-col col">

					<?php do_action( 'goya_shop_toolbar' ); ?>

					<?php 
					if ( woocommerce_product_loop() ) {

						/**
						 * Hook: woocommerce_before_shop_loop.
						 *
						 * @hooked woocommerce_output_all_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );

						global $woocommerce_loop;
						
						// Set column sizes (large column is set via theme setting)
						$woocommerce_loop['columns_small'] = '2';
						$woocommerce_loop['columns_medium'] = '3';

						$woocommerce_loop['shop_archive'] = true;
						
						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
						} else {
							/**
							 * Hook: woocommerce_no_products_found.
							 *
							 * @hooked wc_no_products_found - 10
							 */
							do_action( 'woocommerce_no_products_found' );
						} 
						?>
				</div>

			</div>
			
			<?php
				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
			?>
			
		</div>
		
	</div>

<?php get_footer('shop'); ?>
