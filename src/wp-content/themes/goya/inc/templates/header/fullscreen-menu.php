<?php 

/**
 * The template for displaying the full screen menu
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$menu_mode = ( get_theme_mod('menu_fullscreen_mode', 'light') == 'dark' ) ? 'dark' : 'light';
$menu_style = apply_filters( 'goya_menu_style', $menu_mode );

$classes[] = $menu_style;
$classes[] = (get_theme_mod('vertical_bar',true) == true) ? 'has-bar' : 'no-bar';

?>

<nav id="fullscreen-menu" class="side-panel side-menu side-fullscreen-menu <?php echo esc_attr(implode(' ', $classes)); ?>">

	<?php do_action( 'goya_vertical_panel_bar' ); ?>
	
	<div class="side-panel-content side-panel-mobile custom_scroll">
		<div class="container">

			<?php do_action( 'goya_before_fullscreen_menu' ); ?>

			<?php
			$has_menu = goya_load_menu_location('fullscreen-menu');

			if( $has_menu) {
			  wp_nav_menu( array(
					'theme_location' => $has_menu,
					'depth' => 4,
					'container' => false,
					'menu_class' => 'mobile-menu big-menu',
					'after' => '<span class="et-menu-toggle"></span>',
				) );
			}
			?>

			<div class="bottom-extras">

				<?php do_action( 'goya_after_fullscreen_menu' ); ?>

	      <?php if (get_theme_mod('menu_fullscreen_widget', true) == true ) { 
	      	dynamic_sidebar( 'offcanvas-menu' );
	      }

			  echo '<div class="divider"></div>';

				if (get_theme_mod('menu_fullscreen_currency', true) == true ) {
					do_action( 'goya_currency_switcher' );
				}

				if (get_theme_mod('menu_fullscreen_language', true) == true ) {
					do_action( 'goya_language_switcher' );
				}				

				if (get_theme_mod('menu_fullscreen_social', true) == true ) {
					echo '<div class="fullscreen-menu__divider divider"></div>';
					echo goya_social_profiles( 'mobile-social-icons' ); 
				}

				?>

			</div>

		</div>
	</div>
	
</nav>