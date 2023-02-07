<?php 
/**
 * The template for displaying all single portfolio
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Goya
 */


$portfolio_layout = goya_meta_config('portfolio','title_style','parallax');

$gallery = array();
if ( rwmb_meta( 'goya_portfolio_featured_gallery') !== '' ) {
	$gallery = rwmb_meta( 'goya_portfolio_featured_gallery', array( 'size' => 'full' ) );
}
$multiple_gallery = ( !empty($gallery) && count($gallery) > 1 ) ? true :  false; 

$transparent_header = get_post_meta(get_queried_object_id(), 'goya_portfolio_transparent_header', true);
$transparent_header = goya_meta_config('portfolio','transparent_header',false);

$post = get_post();
$vc = class_exists('WPBakeryVisualComposerAbstract');
$vc_enabled =  $post && preg_match( '/vc_row/', $post->post_content );

$enable_pagepadding = get_post_meta(get_the_ID(), 'goya_portfolio_transparent_header', true);

$hero_title = $parallax_single = false;

if ($portfolio_layout == 'parallax' || $portfolio_layout == 'hero'  ) {
	$hero_title = true;
	$classes[] = 'hero-header';
	$classes[] = 'hero-title';
	$header_bg_class = 'hero-title';
	
	if ($portfolio_layout == 'parallax') {
		$classes[] = 'featured-gallery';

		if( $multiple_gallery == true ) {
			$classes[] = 'post_format-post-format-gallery format-gallery';
		} else {
			$classes[] = 'single-image';
			$parallax_single = true;
		}
	}

} else {
	$header_bg_class = 'regular-title';
}


if ( $transparent_header || $portfolio_layout == 'parallax' ) {
	$classes[] = 'page-transparent';
} else {
	$classes[] = 'page-padding';
}

$classes[] = 'header-' . $portfolio_layout;
$classes[] = ( $portfolio_layout == 'parallax' ) ? 'featured-gallery': '';
$classes[] = 'sidebar-disabled';
$classes[] = ($enable_pagepadding || $hero_title) ? 'page-transparent' :  'page-padding';
$classes[] = 'post post-detail';

$title_class[] = 'post-featured';
?>
<?php get_header(); ?>

<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>

	<article <?php post_class($classes); ?>>

		<?php 

		if ( $portfolio_layout == 'parallax' ) {

			if ( !empty($gallery) && count($gallery) > 1 ) {
				get_template_part( 'inc/templates/portfolio/portfolio-gallery' ); ?>

				<div class="<?php echo esc_attr(implode(' ', $title_class)); ?>">
					<?php get_template_part( 'inc/templates/portfolio/portfolio-title'); ?>
				</div>

			<?php } else {
				get_template_part( 'inc/templates/portfolio/portfolio-standard' );
			}
		} else if ( $portfolio_layout != 'hide' ) {
			$title_class[] = 'title-wrap'; ?>

			<div class="<?php echo esc_attr(implode(' ', $title_class)); ?>">
				<?php get_template_part( 'inc/templates/portfolio/portfolio-title'); ?>
			</div>

		<?php } ?>

		<?php if ($vc && $vc_enabled) { ?>
			
			<?php the_content(); ?>
			
			<div class="container">
				
				<?php do_action( 'goya_social_share' ); ?>
			
			</div>

		<?php } else { ?>

			<div class="container">
				<div class="row justify-content-md-center">
					<div class="col-lg-9">
						<div class="post-content entry-content no-vc">
							<?php get_template_part( 'inc/templates/portfolio/portfolio-meta-single'); ?>
							<?php the_content();?>
						</div>
							
						<?php do_action( 'goya_social_share' ); ?>

					</div>
				</div>
			</div>
			
		<?php } ?>
	</article>

	<div class="post-navigation">
		<?php
		if ( get_theme_mod('portfolio_navigation', 'simple') != '' ) :
		do_action('goya_post_navigation');
		endif;
		?>
	</div>
	
	<?php if ( comments_open() || get_comments_number() ) { comments_template('', true); } ?>
	<?php
		if ( get_theme_mod('portfolio_related', false) == true ) :
		get_template_part( 'inc/templates/portfolio/related-portfolio');
		endif;
	?>

<?php endwhile; else : endif; ?>
<?php get_footer(); ?>
