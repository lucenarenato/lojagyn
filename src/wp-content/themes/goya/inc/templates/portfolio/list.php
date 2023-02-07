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
	$image_size = 'medium_large';

	$animation = array(
		'animation right-to-left',
		'animation left-to-right',
		'animation right-to-left-3d',
		'animation left-to-right-3d',
		'animation bottom-to-top',
		'animation top-to-bottom',
		'animation bottom-to-top-3d',
		'animation top-to-bottom-3d',
		'animation scale',
		'animation fade-in'
);

?>

<div <?php post_class($class); ?> id="portfolio-<?php the_ID(); ?>">
	<?php $rand = rand(5,7); ?>
	<div class="row portfolio-holder masonry-items-holder">
		<div class="col-md-<?php echo esc_attr( $rand + 1 ); ?> col-lg-<?php echo esc_attr( $rand ); ?>">
			<div class="et-portfolio-image post-gallery <?php echo esc_attr( $animation[array_rand($animation)] ); ?>">
				<a href="<?php echo esc_url(get_the_permalink()); ?>" class="et-portfolio-list-link">
					<?php the_post_thumbnail($image_size); ?>
				</a>
			</div>
		</div>
		<div class="col-md-4 col-lg-3 post-list-excerpt">
			<div class="inner animation right-to-left">
				<aside class="et-portfolio-categories post-categories"><?php echo esc_html($categories); ?></aside>
				<header class="entry-header">
					<?php the_title('<h3 class="entry-title" itemprop="name headline"><a class="entry-link" href="'.get_the_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h3>'); ?>
				</header>
			</div>
		</div>
	</div>
</div>
