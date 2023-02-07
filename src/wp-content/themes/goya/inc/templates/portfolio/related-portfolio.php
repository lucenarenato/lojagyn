<?php
	global $post;

	$p_page = get_theme_mod('portfolio_page', '');
	$category_navigation = get_theme_mod('portfolio_navigation', true);
	
	$portfolio_layout = 'grid'; // related items only in grid mode

	$columns = get_theme_mod('portfolio_columns', '4');
	$alternate_cols = get_theme_mod('portfolio_alternate', true);
	$item_style = get_theme_mod('portfolio_item_style', 'regular');
	$item_margins = get_theme_mod('portfolio_item_margin', 'regular-padding');
	$animation = get_theme_mod('portfolio_animation', 'animation bottom-to-top');
	$num_posts = get_option( 'posts_per_page' );
	$loadmore = 'true';
	$aspect = 'original';

	$category_filter = false;
	$categories = false;

	$classes[] = $item_margins;
	$classes[] = 'row';

	$classes[] = 'masonry et-loader';
	$classes[] = 'variable-height';
	$classes[] = 'et-portfolio';
	$classes[] = 'et-portfolio-style-'.$item_style;

	$rand = rand(0,1000);

	$postId = $post->ID;
	$query = goya_get_posts_related_by_category($postId);
?>
<?php if ($query->have_posts()) : ?>
<aside class="related-posts hide-on-print et-portfolio et-portfolio-style-regular regular-padding">
	<div class="container">
		<h3 class="related-title"><?php esc_html_e( 'Related Items', 'goya' ); ?></h3>
		<div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<?php 
				set_query_var( 'goya_port_layout', $portfolio_layout );
				set_query_var( 'goya_port_columns', $columns );
				set_query_var( 'goya_port_aspect', $aspect );
				set_query_var( 'goya_port_animation', $animation );

				get_template_part( 'inc/templates/portfolio/' . $item_style); ?>
			<?php endwhile; ?>
		</div>
	</div>
</aside>
<?php endif; ?>
<?php wp_reset_postdata(); ?>