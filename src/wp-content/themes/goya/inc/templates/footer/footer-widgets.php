<?php 
/**
 * The template for displaying the footer widgets
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$columns = get_theme_mod('footer_widgets_columns', 3);

$classes[] = 'footer-widgets';
$classes[] = ( get_theme_mod('footer_toggle_widgets', false) == true ) ? 'footer-toggle-widgets' : '';

$is_active = 0;

for ($i = 1; $i <= $columns ; $i++) {
	if ( is_active_sidebar( 'footer' . $i ) ) {
		$is_active = 1;
	}
}

if ( $is_active == 1 ) : ?>

<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="container">
		<div class="row">
			<?php do_action('goya_footer_columns'); ?>
		</div>
	</div>
</div>

<?php endif; ?>