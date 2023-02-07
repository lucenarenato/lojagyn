<?php
/**
 * Template Name: Wide Layout (Gutenberg)
 *
 * The template for wide layout pages
 * Used with Gutemberg builder
 *
 * @package Goya
 */

$post = get_post();
$vc = class_exists('WPBakeryVisualComposerAbstract');
$vc_enabled =  $post && preg_match( '/vc_row/', $post->post_content );

$header_layout = get_post_meta(get_queried_object_id(), 'goya_page_header_layout', true);
$title_style = get_post_meta(get_the_ID(), 'goya_page_title_style', true);
$featured_image = get_post_meta(get_the_ID(), 'goya_page_hero_featured_image', true);

$enable_pagepadding = ($header_layout == 'transparent') ? true : false;

$image_id = $image_url = '';


if ($title_style ==  'hero') {
	$classes[] = 'hero-header';
	
	$title_class[] = 'hero-title';

	if ($featured_image) {
		$classes[] = 'hero-title';
		$classes[] = 'header-parallax';

		$title_class[] = 'post-featured';
		$title_class[] = 'parallax_image';
		$title_class[] = 'vh-height';
	
		if ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id, 'full'); 
		}

	}

} else {
	$title_class[] = 'regular-title';
}

$classes[] = ($enable_pagepadding || $title_style == 'hero' ) ? 'page-transparent' :  'page-padding';

?>
<?php get_header(); ?>

<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>

	<div <?php post_class($classes); ?>>
		<?php if ( $title_style != 'hide' ) { ?>
			<div class="<?php echo esc_attr(implode(' ', $title_class)); ?>" style="<?php if ( $featured_image && has_post_thumbnail() ) { ?>background-image: url(<?php echo esc_html($image_url[0]); ?>); <?php } ?>">
				<header class="page-header post-title entry-header container">
					<div class="row justify-content-md-center">
						<div class="col-lg-8">
							<div class="title_outer">
								<?php the_title('<h1 class="page-title" itemprop="name headline">', '</h1>' ); ?>
							</div>
						</div>
					</div>
				</header>
			</div>
		<?php } ?>

		<?php if ($vc && $vc_enabled) { ?>
			<?php the_content();?>
		<?php } else { ?>
			<div class="container">
				<div class="post-content entry-content no-vc">
					<?php the_content();?>
				</div>
			</div>
		<?php } ?>
	
	</div>
	
	<?php if ( comments_open() || get_comments_number() ) : ?>
	<?php comments_template('', true); ?>
	<?php endif; ?>
	
<?php endwhile; else : endif; ?>
<?php get_footer(); ?>
