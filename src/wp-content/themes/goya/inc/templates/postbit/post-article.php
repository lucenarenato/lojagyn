<?php
/**
 * The template for displaying the post content
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$post_id = get_the_ID();
$feat_gallery = goya_meta_config('post','featured_image','below');
$transparent_header = goya_meta_config('post','transparent_header',false);
$hero_title = goya_meta_config('blog','hero_title',false);
$nav_style = goya_meta_config('post','navigation','simple');
$post_sidebar = goya_meta_config('post','sidebar',true);

if ( $post_sidebar == true && is_active_sidebar( 'single' ) ) {
	$class[] = 'sidebar-enabled';
} else {
	$class[] = 'sidebar-disabled';
}

$class[] = 'post post-detail';

// Show sidebar?
$class[] = ( $post_sidebar == true && is_active_sidebar( 'single' ) ) ? 'sidebar-enabled': 'sidebar-disabled';
$class[] = ( ($hero_title == true && $feat_gallery == 'regular') || $feat_gallery == 'parallax' ) ? 'hero-title': 'regular-title';

// Featured image on header
$class[] = $feat_gallery;
$class[] = ( $feat_gallery == 'parallax' ) ? 'featured-gallery': '';
$class[] = ( $feat_gallery == 'parallax' || ( $feat_gallery == 'parallax' && $hero_title == true ) ) ? 'header-parallax': 'header-normal';

// WP Gallery custom lightbox
if ( get_theme_mod('wp_gallery_popup', false) == true )  $class[] = 'gallery-popup';

$title_class[] = 'post-featured';

if ( $transparent_header == true && ( ($hero_title == true && $feat_gallery == 'regular') || $feat_gallery == 'parallax' ) ) {
	$class[] = 'page-transparent';
} else {
	$class[] = 'page-padding';
}

// Post Format
$format = get_post_format();
$video = get_post_meta($post_id , 'goya_post_featured_video', true);
$gallery = rwmb_meta( 'goya_post_featured_gallery', array( 'size' => 'full' ) );

if ( $format == 'gallery' && !empty($gallery) && count($gallery) > 0 ) {
	$format = 'gallery';
} else if ( $format == 'video' && $video !== '' ) {
	$format = 'video';
} else if ( $format == 'image' ) {
	$format = 'image';
} else {
	$format = 'standard';
}

?>

<div <?php post_class($class); ?>>

	<?php
	
	if ( $feat_gallery == 'parallax' ) {
		if (in_array($format, array('gallery', 'video'))) {
			get_template_part( 'inc/templates/postformats/'.$format );
		} else {
			get_template_part( 'inc/templates/postformats/standard' );
		}
	}

	if ( $feat_gallery != 'parallax' || ( $feat_gallery == 'parallax' && in_array($format, array('gallery', 'video')) ) ) {
		
		if ( $feat_gallery != 'parallax' ) {
			$title_class[] = 'title-wrap';
		}
		?>

		<div class="<?php echo esc_attr(implode(' ', $title_class)); ?>">
			<?php get_template_part( 'inc/templates/postbit/post-title'); ?>
		</div>

	<?php } ?>

	<div class="container article-body">
		<div class="row justify-content-md-center">
			<div class="col-lg-8 main-content">
				
				<div class="post-content entry-content">
					
					<?php if ( $feat_gallery == 'below' && ( in_array($format, array('gallery', 'video')) || has_post_thumbnail() ) ) { ?>
						<div class="featured-media alignwide">
							<?php if (in_array($format, array('gallery', 'video'))) {
								get_template_part( 'inc/templates/postformats/'.$format );
							} else if ( has_post_thumbnail() ) {
								the_post_thumbnail('full');
							} ?>
						</div>
					<?php } ?>
					
					<?php the_content(); ?>

				</div>

				<?php
				wp_link_pages(
					array(
						'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'goya' ) . '"><span class="label">' . esc_html__( 'Pages:', 'goya' ) . '</span>',
						'after'       => '</nav>',
						'link_before' => '<span class="page-number">',
						'link_after'  => '</span>',
					)
				); ?>

				<?php if (get_theme_mod('post_meta_bar', true) == true) { ?> 				

				<?php
					$has_meta = false;
					$meta_output = '';
					$categories_list = get_the_category_list( ', ' );
					$tag_list = get_the_tag_list( '', ', ' );

					if ( $categories_list || $tag_list) { ?>

						<div class="single-post-meta">
							<?php if ( $categories_list ) {
								echo '<span class="posted_in"><span>' . esc_html__( 'Posted in:', 'goya' ) . '</span>' .  $categories_list . '</span>';
							}

							if ( $tag_list ) {
								echo '<span class="tagged_as"><span>' . esc_html__( 'Tagged:', 'goya' ) .  '</span>' . $tag_list . '</span>';
							} ?>
						</div>

					<?php } ?>

				<?php } ?>
				
				<?php if (get_theme_mod('post_author', false) == true) { ?> 
					<?php do_action('goya_author_info'); ?>
				<?php } ?>
				
				<?php do_action( 'goya_social_share' ); ?>

				<?php if ( $post_sidebar == true && is_active_sidebar( 'single' ) ) { ?>
					
					<?php if ( $nav_style != '' ) {
						do_action('goya_post_navigation');
					} ?>

					<?php if ( comments_open() || get_comments_number() ) {
						comments_template('', true);
					} ?>

					<?php if ( get_theme_mod('single_post_related', true) == true ) {
						get_template_part( 'inc/templates/postbit/post-related');
					} ?>
					
				<?php } ?>

			</div>
			<?php
			if ( $post_sidebar == true && is_active_sidebar( 'single' ) ) {
				get_sidebar('single');
			}
			?>
		</div>

	</div>

	<?php if ( $post_sidebar != true || !is_active_sidebar( 'single' ) ) { ?>

		<?php if ( $nav_style != '' ) {
			do_action('goya_post_navigation');
		} ?>

		<?php if ( comments_open() || get_comments_number() ) {
			comments_template('', true);
		} ?>

	<?php } ?>

</div>

