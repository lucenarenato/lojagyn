<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Goya
 */

	$post = get_post();
	$vc = class_exists('WPBakeryVisualComposerAbstract');
	$vc_enabled =  $post && preg_match( '/vc_row/', $post->post_content );
	
	$header_layout = get_post_meta(get_queried_object_id(), 'goya_page_header_layout', true);
	$title_style = get_post_meta(get_the_ID(), 'goya_page_title_style', true);
	$featured_image = get_post_meta(get_the_ID(), 'goya_page_hero_featured_image', true);
	$sidebar_status = get_post_meta(get_queried_object_id(), 'goya_page_sidebar_position', true);
	if (empty($sidebar_status)) {
		$sidebar_status = 'disable';
	}

	$enable_pagepadding = ($header_layout == 'transparent') ? true : false;

	$inline_bg = '' ;

	if ($title_style ==  'hero') {
		$classes[] = 'hero-header';
		
		$title_class[] = 'hero-title';

		if ($featured_image) {
			$classes[] = 'hero-title';
			$classes[] = 'header-parallax';

			if ( has_post_thumbnail() ) {
			$title_class[] = 'post-featured';
			$title_class[] = 'parallax_image';
			$title_class[] = 'vh-height';

				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id, 'full'); 

				$inline_bg = 'background-image: url('. $image_url[0] .')';
			}

		}

	} else {
		$title_class[] = 'regular-title';
	}
	
	$classes[] = ($enable_pagepadding || $title_style == 'hero' ) ? 'page-transparent' :  'page-padding';

?>
<?php get_header(); ?>

<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
	
	<?php
	 
	 // WooCommerce pages
	 if (goya_is_woocommerce()){
	 	
	 	// Hero title
	 	$header_bg = get_theme_mod('shop_hero_title', 'none');
	 	$header_class[] = 'hero-header';
	 	$title_class_woo = ( $header_bg == 'all-hero' ) ? 'hero-title' : 'regular-title';

	 	if ($header_bg != 'all-hero') {
	 		$header_class[] = 'page-padding';
	 	}

	 	?>
		<div <?php post_class($header_class); ?>>
			<div class="<?php echo esc_attr($title_class_woo); ?>" style="<?php echo esc_attr($inline_bg); ?>">
				<div class="container hero-header-container">
					<div class="row">
						<header class="col-lg-8 woocommerce-products-header">
							<?php the_title('<h1 class="page-title" itemprop="name headline">', '</h1>' ); ?>
						</header>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="post-content no-vc">
				<?php the_content();?>
			</div>
		</div>

	<?php }

	// All other pages
	else { ?>

		<div <?php post_class($classes); ?>>
			<?php if ( $title_style != 'hide' ) { ?>
				<div class="<?php echo esc_attr(implode(' ', $title_class)); ?>" style="<?php echo esc_attr($inline_bg); ?>">
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
			
			<?php if ($vc && $vc_enabled && ( !is_active_sidebar( 'page' ) || $sidebar_status == 'disable' ) ) { ?>
				<?php the_content();?>
			<?php } else { ?>
				<div class="container">
					<div class="row justify-content-md-center sidebar-<?php echo esc_attr($sidebar_status); ?>">
						<div class="col-lg-8 main-content">
							<?php if ($vc && $vc_enabled) { ?>
								<?php the_content();?>
							<?php } else { ?>
							<div class="post-content entry-content no-vc">
								<?php the_content();?>
							</div>
							<?php } ?>

							<?php
							wp_link_pages(
								array(
									'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'goya' ) . '"><span class="label">' . esc_html__( 'Pages:', 'goya' ) . '</span>',
									'after'       => '</nav>',
									'link_before' => '<span class="page-number">',
									'link_after'  => '</span>',
								)
							); ?>
						</div>
						<?php if ( is_active_sidebar( 'page' ) && $sidebar_status != 'disable' ) {
							get_sidebar('page');
						} ?>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
	<?php comments_template('', true); ?>
	<?php endif; ?>

<?php endwhile; else : endif; ?>
<?php get_footer(); ?>