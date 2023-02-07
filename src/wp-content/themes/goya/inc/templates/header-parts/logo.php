<?php
/**
 * Template part for displaying the logo
 *
 * @package Goya
 */

$wp_logo_id = get_theme_mod( 'custom_logo' ); // Default WordPress Customizer option

$logo = get_theme_mod( 'site_logo', get_template_directory_uri() . '/assets/img/logo-light.png' );
$logo_dark = get_theme_mod( 'site_logo_dark', get_template_directory_uri() . '/assets/img/logo-dark.png' );
$logo_alt = get_theme_mod( 'site_logo_alt', '' );
		
// Logo
if ( !empty( $wp_logo_id ) ) {
	$image = wp_get_attachment_image_src( $wp_logo_id , 'full' );
	$logo = $image[0];
}

// Dark Scheme Logo
if ( empty($logo_dark) ) {
	$logo_dark = $logo;
}

// Alternative Logo
$logo_alt_class =  get_theme_mod( 'site_logo_alt_use', '' );

?>

<div class="logo-holder">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logolink <?php echo esc_attr( $logo_alt_class ) ?>">
	<?php
		// Default Logo
		if ( !empty( $logo ) ) {
			goya_site_logo($logo,'light');
		} else { ?>
			<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
		<?php }
		// Dark Scheme Logo
		if ( !empty( $logo_dark ) ) {
			goya_site_logo($logo_dark,'dark');
		}
		// Alternative Logo
		if ( !empty( $logo_alt && $logo_alt_class != '') ) {
			goya_site_logo($logo_alt,'alt');
		} ?>

		<?php do_action( 'goya_logo_image' ); ?>

	</a>
</div>
