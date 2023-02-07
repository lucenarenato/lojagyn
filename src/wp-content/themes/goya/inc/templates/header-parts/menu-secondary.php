<?php
/**
 * Template part for display secondary menu
 *
 * @package Goya
 */
?>

<nav id="secondary-menu" class="secondary-navigation navigation">
	<?php if (has_nav_menu('secondary-menu')) { ?>
		<?php wp_nav_menu( array(
			'theme_location' => 'secondary-menu',
			'depth' => 3,
			'container' => false,
			'menu_class' => 'secondary-menu et-header-menu',
		) ); ?>
	<?php } ?>
</nav>