<?php 
/**
 * The template for displaying the footer bottom bar
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$classes[] = ( goya_meta_config('','footer_bar_full_width',true) == true ) ? 'footer-full' : 'footer-normal';
$classes[] = get_theme_mod('footer_bar_mode', 'light');
$classes[] = 'footer-bar-border-' . get_theme_mod('footer_bar_border', false);
$classes[] = 'custom-color-'.get_theme_mod('footer_bar_custom', false);

$groups = array(
	'left'   => goya_meta_config('','footer_main_left', array( array( 'item' => 'copyright' )) ),
	'center'   => goya_meta_config('','footer_main_center', array() ),
	'right'   => goya_meta_config('','footer_main_right', array() ),
);

?>

<div id="footer-bar" class="footer-bar footer-main <?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="container">
		<?php foreach ( $groups as $group => $items ) : ?>
			<div class="footer-items footer-<?php echo esc_attr( $group ); ?>">
				<?php
				foreach ( $items as $item ) {
					$item['item'] = $item['item'] ? $item['item'] : key( goya_footer_elements_list() );
					goya_footer_elements( $item['item'] );
				} ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>