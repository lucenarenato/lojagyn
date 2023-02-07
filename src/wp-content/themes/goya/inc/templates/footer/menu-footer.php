<?php
/**
 * Template part for display footer menu
 *
 * @package Goya
 */
?>

<nav id="footer-bar-menu" class="footer-navigation navigation">
	<?php if (has_nav_menu('footer-menu')) { ?>
		<?php wp_nav_menu( array(
			'theme_location' => 'footer-menu',
			'depth' => 1,
			'container' => false,
			'menu_class' => 'menu',
		) ); ?>
	<?php } ?>
</nav>