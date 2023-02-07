<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Goya
 */

// Categories menu
$blog_style = goya_meta_config('','blog_style','classic');
$classes[] = 'blog-style-' . $blog_style;

// Categories menu
$show_categories = ( get_theme_mod('blog_categories', false) == true ) ? true : false;
$classes[] = ( $show_categories ) ? '' : ' et-blog-categories-disabled';

$classes[] = 'hero-header';

// Hero title
$hero_title = goya_meta_config('blog','hero_title',false);

if ( is_home() && ! is_front_page() ) {
	$image = get_theme_mod('blog_header_bg_image', '');
} else if (is_category()) {
	$term = get_queried_object();
	$term_id = $term->term_id;
	$header_id = get_term_meta( $term_id, 'header_id', true );
	$image = wp_get_attachment_url($header_id, 'full');
}

if (! empty($image)) {
	$header_bg_class[] = 'parallax_image';
	$header_bg_class[] = 'vh-height';
}

if ($hero_title == true) {
	$header_bg_class[] = 'hero-title';
} else {
	$header_class[] = 'page-padding';
	$header_bg_class[] = 'regular-title';
}

// Sidebar
$blog_sidebar = goya_meta_config('blog','sidebar',true);
if ( $blog_sidebar == true && is_active_sidebar( 'blog' ) && have_posts() ) {
	$sidebar = true;
	$content = 'col-lg-8';
	$classes[] = 'blog-sidebar-active';
} else {
	$sidebar = false;
	$content = 'col-lg-12';
	$classes[] = 'blog-sidebar-disabled';
}

// Call header before the script
get_header();

// Pass values on load more
$cat = get_queried_object();

if ($cat) {
	$cat_id = $cat->term_id;
} else {
	$cat_id = false;
}

wp_localize_script( 'goya-app', esc_attr('goya_blog_ajax_params'), array( 
	'blog_style' => $blog_style,
	'category_id' => $cat_id,
) );

?>
<div class="et-blog <?php echo esc_attr(implode(' ', $classes)); ?>">
	
	<div class="<?php echo esc_attr(implode(' ', $header_bg_class)); ?>">

		<header class="page-header post-title entry-header container">
			<div class="row justify-content-md-center">
				<div class="col-lg-8">
					<div class="title_outer">
					<h1 class="page-title"><?php 
						if (is_archive()) {
							single_term_title();
						} else if (is_search()) {
							esc_html_e('Search Results for: ', 'goya');
							the_search_query();
						} else {
							single_post_title();
						}
					?></h1>

					<?php if (is_archive()) {
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					} ?>

					<?php if ( $show_categories ) { ?>
						<div class="et-blog-categories">
							<?php echo goya_blog_category_menu(); ?>
						</div>
					<?php } ?>
			</div>
		</div>
	</div>
		</header>

	</div>

	<div class="container">

		<div class="row content-area <?php if ( get_theme_mod('blog_sidebar_position', 'right') == 'left') { ?>flex-row-reverse<?php } ?>">
			
			<div class="<?php echo esc_attr($content); ?>">
				<?php
				get_template_part( 'inc/templates/blog/' . $blog_style);
				?>
			</div>

			<?php if ( $sidebar == true ) {
				get_sidebar('blog');
			} ?>
			
		</div>

	</div>
		
</div>
<?php get_footer(); ?>