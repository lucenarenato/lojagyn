<?php
	$vars = $wp_query->query_vars;
	$port_layout = array_key_exists('goya_port_layout', $vars) ? $vars['goya_port_layout'] : false;
	$port_columns = array_key_exists('goya_port_columns', $vars) ? $vars['goya_port_columns'] : false;
	$port_aspect = array_key_exists('goya_port_aspect', $vars) ? $vars['goya_port_aspect'] : false;
	$port_animation = array_key_exists('goya_port_animation', $vars) ? $vars['goya_port_animation'] : false;
	
	$id = get_the_ID();

	$port_columns = goya_get_portfolio_columns($port_columns);

	//Image
	$image_id = get_post_thumbnail_id($id);
	
	// Categories
	$categories = get_the_term_list( $id, 'portfolio-category', '', ', ', '' ); 
	if ($categories !== '' && !empty($categories)) {
		$categories = strip_tags($categories);
	}
	
	$terms = get_the_terms( $id, 'portfolio-category' );
	
	$cats = '';	
	if (!empty($terms)) {
		foreach ($terms as $term) { $cats .= ' cat-'.strtolower($term->slug); }
	}
	
	// Classes
	$class[] = 'item';
	$class[] = 'type-portfolio';
	$class[] = 'aspect-ratio-'.$port_aspect;
	$class[] = $cats;
	
	// Image sizes
	if ($port_layout == 'masonry') {
		$masonry_size = get_post_meta($id, 'goya_portfolio_masonry_size', true);	
		$masonry_adjust = goya_get_masonry_size($masonry_size);
		$class[] = $masonry_adjust['class'];
		$image_size = $masonry_adjust['image_size'];
	} else {
		$class[] = $port_columns;
		$image_size = 'medium_large';
	}

?>
<div <?php post_class($class); ?> id="portfolio-<?php the_ID(); ?>">	
	<div class="portfolio-holder masonry-items-holder <?php echo esc_attr( $port_animation ); ?>">
		<div class="et-portfolio-image">
			<?php the_post_thumbnail($image_size); ?>
			<div class="et-portfolio-hover"></div>
		</div>
		<a href="<?php echo esc_url(get_the_permalink()); ?>" class="et-portfolio-link"></a>
		<div class="et-portfolio-content">
			<aside class="et-portfolio-categories post-categories"><?php echo esc_html($categories); ?></aside>
			<h3><?php the_title(); ?></h3>
		</div>
	</div>
</div>