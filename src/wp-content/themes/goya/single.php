<?php
/**
 * The template for displaying all single posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Goya
 */

get_header(); ?>

<div class="blog-container">
	
	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
		<?php get_template_part( 'inc/templates/postbit/post-article'); ?>
	<?php endwhile; else : endif; ?>

	<?php $post_sidebar = goya_meta_config('post','sidebar',true); ?>

	<?php if ( $post_sidebar != true || !is_active_sidebar( 'single' ) ) {
		if ( get_theme_mod('single_post_related', true) == true ) {
			get_template_part( 'inc/templates/postbit/post-related');
		}
	} ?>

</div>

<?php get_footer(); ?>
