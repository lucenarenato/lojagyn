<?php 
	// Column classes
	$columns_large = get_theme_mod('blog_grid_columns', 3);
	$columns_medium = ( intval( $columns_large ) > 3 ) ? '3' : '2';

	if (is_sticky(get_the_ID()) ) {
		$base_grid = '24';
		$img_size = 'full';
	} else {
		$base_grid = '12';
		$img_size = 'medium_large';
	}
	
	$classes[] = 'col-md-' . $base_grid / $columns_medium;
	$classes[] = 'col-lg-' . $base_grid / $columns_large;
	$classes[] = 'post post-cards item blog-post';
	$inner_classes[] = 'overlay-inner';
	$inner_classes[] = get_theme_mod('blog_list_animation', 'animation bottom-to-top');
?>

<div <?php post_class(esc_attr(implode(' ', $classes))); ?>>
	<div class="<?php echo esc_attr(implode(' ', $inner_classes)); ?>">
		<figure class="post-gallery">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php goya_post_format_icon( get_the_ID() ); ?>
				<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail($img_size); ?>
				<?php endif; ?>
			</a>
		</figure>
		<header class="post-title entry-header">
			<?php if ( get_theme_mod('blog_category', true) == true ) the_category(); ?>
			<?php the_title('<h3 class="entry-title" itemprop="name headline"><a class="entry-link" href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h3>'); ?>
			<?php get_template_part( 'inc/templates/postbit/post-meta' ); ?>
		</header>
	</div>
</div>
