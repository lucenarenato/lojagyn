<?php
/**
 * The template for displaying the portfolio home/archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Goya
 */

$p_page = goya_meta_config('portfolio','page', '');
$category_navigation = goya_meta_config('portfolio','categories_nav', true);
$portfolio_layout = goya_meta_config('portfolio','layout_main', 'masonry');
$columns = goya_meta_config('portfolio','columns', '4');
$alternate_cols = goya_meta_config('portfolio','list_alternate', true);
$item_style = goya_meta_config('portfolio','item_style', 'regular');
$item_margins = goya_meta_config('portfolio','item_margin', 'regular-padding');
$animation = goya_meta_config('portfolio','animation', 'animation bottom-to-top');
$keyword = isset($_GET['s']) ? $_GET['s'] : false;
$num_posts = get_option( 'posts_per_page' );
$loadmore = 'true';
$aspect = 'original';

$category_filter = false;
$categories = false;

if ($portfolio_layout == 'list') {
 $item_style = 'list';
 $classes[] = 'post post-list';
 $classes[] = 'alternate-cols-'.$alternate_cols;
} else {
 $classes[] = $item_margins;
 $classes[] = 'row';
}

$classes[] = 'masonry et-loader';
$classes[] = 'variable-height';
$classes[] = 'et-portfolio';
$classes[] = 'et-portfolio-layout-'.$portfolio_layout;
$classes[] = 'et-portfolio-style-'.$item_style;

$rand = rand(0,1000);

$header_bg_class[] = 'regular-title';

$outer_classes[] = 'page-padding';

get_header();

$portfolio_id_array = array();

if (have_posts()) :  while (have_posts()) : the_post();
	$portfolio_id_array[] = get_the_ID();
endwhile; endif;

?>

<div class="<?php echo esc_attr(implode(' ', $outer_classes)); ?>">

	<div class="<?php echo esc_attr(implode(' ', $header_bg_class)); ?>">
		<div class="container hero-header-container">
			<div class="row">
				<?php if ( have_posts() ) : ?>
					<div class="col-lg-9">
						<header class="page-header woocommerce-products-header">
							<h1 class="page-title"><?php 
								if (is_search()) {
									esc_html_e('Search Results for: ', 'goya');
									the_search_query();
								} else if (is_archive()) {
									esc_html_e('Portfolio', 'goya');
								} else {
									single_post_title();
								}
							?></h1>
						</header>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="container">
		
		<div class="post-content entry-content no-vc">
			<?php if ($portfolio_layout != 'list') { ?>
		    <?php if($category_navigation) {
		     do_action('goya_render_filter', $categories, $rand, $portfolio_id_array );
		    } ?>
				<div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>" data-filter="et-filter-<?php echo esc_attr($rand); ?>" data-layoutmode="packery">
		  <?php } else { ?>
			  <div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>">
			<?php } ?>

			<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
				
				<?php 
				set_query_var( 'goya_port_layout', $portfolio_layout );
        set_query_var( 'goya_port_columns', $columns );
        set_query_var( 'goya_port_aspect', $aspect );
        set_query_var( 'goya_port_animation', $animation );

				get_template_part( 'inc/templates/portfolio/' . $item_style); ?>
			
			<?php endwhile; else : ?>
			  
			  <?php get_template_part( 'inc/templates/not-found' ); ?>
			
			<?php endif; ?>

				</div>

			<?php
			global $wp_query;
			$total_pages = $wp_query->max_num_pages; 
			
			if ($loadmore && $total_pages > 1) { 
				$ajax_data = array( 
					'masonry' => $portfolio_layout,
		      'columns' => $columns,
		      'aspect' => $aspect,
		      'animation' => $animation,
					'style' => $item_style,
					'count' => intval( $num_posts ),
					'category' => $category_filter,
					'keyword' => $keyword,
					'total_pages' => $total_pages,
				);

				wp_localize_script( 'goya-app', esc_attr('goya_portfolio_ajax_'.$rand), $ajax_data );
				?>
				<?php get_template_part( 'pagination' ); ?>
				<div class="et-infload-controls et-portfolio-infload-controls et-masonry-infload-controls">
					<a href="#" class="et-portfolio-infload-btn et-infload-btn button outlined" id="loadmore-<?php echo esc_attr($rand); ?>" data-masonry-id="<?php echo esc_attr($rand); ?>"><?php esc_html_e( 'Load More', 'goya' ); ?></a>
					<a class="et-infload-to-top"><?php esc_html_e( 'All items loaded', 'goya' ); ?></a>
				</div>
			<?php } ?>
			
		</div>
		
	</div>

</div>

<?php get_footer();
