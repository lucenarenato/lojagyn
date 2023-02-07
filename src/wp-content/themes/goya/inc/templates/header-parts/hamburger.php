<?php
/**
 * Template part for displaying the hamburger menu icon
 *
 * @package Goya
 */
?>

<div class="hamburger-menu">
	<button class="menu-toggle fullscreen-toggle" data-target="hamburger-fullscreen"><span class="bars"><?php get_template_part('assets/img/svg/menu.svg'); ?></span> <span class="name"><?php esc_attr_e( 'Menu', 'goya' ); ?></span></button>
</div>
