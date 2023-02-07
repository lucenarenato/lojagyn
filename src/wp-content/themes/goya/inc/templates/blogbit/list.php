<?php 
	add_filter( 'excerpt_length', 'goya_short_excerpt_length' );
	if (is_sticky(get_the_ID()) ) {
		$class = 'col-lg-12';
		$class2 = 'col-lg-12';
		$img_size = 'full';
	} else {
		$class = 'col-lg-5';
		$class2 = 'col-lg-6';
		$img_size = 'medium_large';
	}

	$classes[] = 'post post-list blog-post';
	$classes[] = get_theme_mod('blog_list_animation', 'animation bottom-to-top');
?>
<div <?php post_class(esc_attr(implode(' ', $classes))); ?>>
	<div class="row">
		<div class="<?php echo esc_attr($class); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
			<figure class="post-gallery">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
					<?php goya_post_format_icon( get_the_ID() ); ?>
					<?php the_post_thumbnail($img_size); ?>
				</a>
			</figure>
			<?php endif; ?>
		</div>
		<div class="<?php echo esc_attr($class2); ?> post-list-excerpt">
			<div class="inner">
				<?php if ( get_theme_mod('blog_category', true) == true ) the_category(); ?>
				<header class="post-title entry-header">
					<?php the_title('<h3 class="entry-title" itemprop="name headline"><a class="entry-link" href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h3>'); ?>
				</header>
				<?php get_template_part( 'inc/templates/postbit/post-meta' ); ?>
				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
	</div>
</div>