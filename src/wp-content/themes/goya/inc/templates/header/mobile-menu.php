<?php 

/**
 * The template for displaying the mobile menu
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$menu_type = get_theme_mod('mobile_menu_type', 'sliding');
$menu_mode = ( get_theme_mod('menu_mobile_mode', 'light') == 'dark' ) ? 'dark' : 'light';
$menu_style = apply_filters( 'goya_menu_style', $menu_mode );

$classes[] = $menu_style;
$classes[] = (get_theme_mod('vertical_bar',true) == true) ? 'has-bar' : 'no-bar';

if (get_theme_mod('menu_fullscreen_override',false) == true) {
	$classes[] = 'desktop-active';
	$classes[] = (get_theme_mod('menu_fullscreen_account', false) == false ) ? 'hide-desktop-account' : '';
	$classes[] = (get_theme_mod('menu_fullscreen_currency', true) == false ) ? 'hide-desktop-currency' : '';
	$classes[] = (get_theme_mod('menu_fullscreen_language', true) == false ) ? 'hide-desktop-language' : '';
	$classes[] = (get_theme_mod('menu_fullscreen_social', true) == false ) ? 'hide-desktop-social' : '';
}

?>

<nav id="mobile-menu" class="side-panel side-menu side-mobile-menu <?php echo esc_attr(implode(' ', $classes)); ?>">

	<?php do_action( 'goya_vertical_panel_bar' ); ?>
	
	<div class="side-panel-content side-panel-mobile custom_scroll">
		<div class="container">

			<div class="mobile-top-extras">
				<?php do_action( 'goya_before_mobile_menu' ); ?>
			</div>
		
			<?php if (get_theme_mod('menu_mobile_search', true) == true ) { ?>
				<div class="side-panel search-panel mobile-search">
					<?php goya_search_box(); ?>
				</div>
			<?php } ?>

			<?php
			$has_menu = goya_load_menu_location('mobile-menu');
			
			if( $has_menu) {
				wp_nav_menu( array(
					'theme_location' => $has_menu,
					'depth' => 4,
					'container' => 'div',
					'container_id' => 'mobile-menu-container',
					'menu_class' => 'mobile-menu small-menu menu-'. $menu_type,
					'after' => '<span class="et-menu-toggle"></span>',
				) );
			} else {
				esc_attr_e( 'No menu assigned', 'goya' );
			}
			?>

			<div class="bottom-extras">
				<?php do_action( 'goya_after_mobile_menu' ); ?>
			</div>

		</div>
	</div>
	
</nav>