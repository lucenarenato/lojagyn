<?php
/**
 * The header area 
 *
 * This is the template that displays all of the <head> section and everything up until <div class="site-content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */
 ?>

 <!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php 
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head(); 

	?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'goya_before_site' ) ?>

<div id="wrapper" class="open">
	
	<div class="click-capture"></div>
	
	<?php do_action( 'goya_before_header' ) ?>

	<div class="page-wrapper-inner">

		<?php 
		// Elementor header or default
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
			do_action( 'goya_header' );
		} ?>

		<div role="main" class="site-content">

			<div class="header-spacer"></div>

			<?php do_action( 'goya_after_header_spacer' ); ?>