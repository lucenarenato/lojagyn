<?php
/**
 * Template file for displaying mobile header
 *
 * @package Goya
 */
?>

<?php do_action( 'goya_hamburger', 'mobile' ); ?>

<?php get_template_part( 'inc/templates/header-parts/logo' ); ?>

<div class="mobile-header-icons">
	<?php do_action( 'goya_mobile_header_icons', 'mobile_header' ); ?>
</div>