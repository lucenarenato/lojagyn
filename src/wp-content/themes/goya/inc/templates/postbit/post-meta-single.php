<?php
/**
 * The template for displaying the meta on single posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */
?>

<aside class="post-meta">
	<span class="post-author"><?php esc_html_e('By', 'goya'); ?> <?php the_author_posts_link(); ?> <?php esc_html_e( 'on', 'goya' ); ?></span>
	<time class="time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
</aside>