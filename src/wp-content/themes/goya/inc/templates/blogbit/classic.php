<?php 
$title_inside = ( goya_meta_config('blog','title_overlay', false ) == true ) ? ' post-blog-card' : false;

$classes[] = 'post post-classic blog-post';
$classes[] = $title_inside;
$inner_classes[] = get_theme_mod('blog_list_animation', 'animation bottom-to-top');

 ?>
<div <?php post_class(esc_attr(implode(' ', $classes))); ?>>
	<div class="<?php echo esc_attr(implode(' ', $inner_classes)); ?>">
		<?php if( $title_inside == false ) : ?>
    	<header class="post-title entry-header">
    		<div class="row justify-content-center">
    			<div class="col-lg-8">
    				<?php if ( get_theme_mod('blog_category', true) == true ) the_category(); ?>
						<?php the_title('<h3 class="entry-title" itemprop="name headline"><a class="entry-link" href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h3>'); ?>
						<?php get_template_part( 'inc/templates/postbit/post-meta' ); ?>
					</div>
				</div>
			</header>
		<?php endif ?>
	
		<?php if ( has_post_thumbnail() ) : ?>
		<figure class="post-gallery">
			<?php if( $title_inside == true ) : ?>
			<header class="post-title entry-header">
				<?php if ( get_theme_mod('blog_category', true) == true ) the_category(); ?>
				<?php the_title('<h3 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h3>'); ?>
				<?php get_template_part( 'inc/templates/postbit/post-meta' ); ?>
			</header>
			<?php endif ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php goya_post_format_icon( get_the_ID() ); ?>
				<?php the_post_thumbnail('full'); ?>
			</a>
		</figure>
		<?php endif; ?>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
