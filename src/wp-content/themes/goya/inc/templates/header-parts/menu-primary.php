<?php
/**
 * Template part for display primary menu
 *
 * @package Goya
 */
?>

<nav id="primary-menu" class="main-navigation navigation">
	<?php if (has_nav_menu('primary-menu')) { ?>
	  <?php wp_nav_menu( array(
	  	'theme_location' => 'primary-menu',
	  	'depth' => 4,
	  	'container' => false,
	  	'menu_class' => 'primary-menu et-header-menu',
	  ) ); ?>
	<?php } ?>
</nav>
