<?php 
/**
 * The template for displaying the post meta
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$blog_author = get_theme_mod('blog_author', false);
$blog_date = get_theme_mod('blog_date', true);
if ($blog_author == true || $blog_date == true) {
?>
	<aside class="post-meta">
		<?php if ($blog_author == true) { ?> 
			<span class="post-author"><?php esc_html_e('By', 'goya'); ?> <?php the_author_posts_link(); ?></span> <?php esc_html_e( 'on', 'goya' ); ?> 
		<?php } ?>
		<?php if ($blog_date == true) { ?> 
			<a href="<?php esc_url( the_permalink() ); ?>" class="date-link"><time class="time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time></a>
		<?php } ?>
	</aside>
<?php } ?>