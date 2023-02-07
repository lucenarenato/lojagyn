<?php
/**
 * The template for displaying the post title
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$format = get_post_format();
$feat_gallery = goya_meta_config('post','featured_image','below');
$title_class = 'title_outer';

$post_sidebar = goya_meta_config('post','sidebar',true);

if ( $post_sidebar == true && is_active_sidebar( 'single' ) ) {
	$title_width = 'col-lg-12';
} else {
	$title_width = 'col-lg-8';
}
?>

<header class="post-title entry-header container">
	<div class="row justify-content-md-center">
		<div class="<?php echo esc_attr( $title_width ); ?>">
			<div class="<?php echo esc_attr( $title_class ); ?>">
				<div class="single-post-categories">
					<?php the_category(); ?>
				</div>
				<?php the_title('<h1 class="entry-title" itemprop="name headline">', '</h1>'); ?>
				<?php get_template_part( 'inc/templates/postbit/post-meta-single'); ?>
			</div>
		</div>
	</div>
</header>