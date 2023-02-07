<?php 
/**
 * The template for displaying the footer middle content
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */

$footer_middle = apply_filters( 'footer_extra_section', get_theme_mod('footer_middle',false) );
$middle_image = get_theme_mod( 'footer_middle_image', '' );
if ( strlen( $middle_image ) > 0 ) {
	$middle_image = ( is_ssl() ) ? str_replace( 'http://', 'https://', $middle_image ) : $middle_image;
}

if ( $footer_middle == true ) { ?>
	<div class="footer-middle footer-widgets">
		<div class="container">
			<div class="row">
				<div class="col-12">
				<?php echo do_shortcode( wp_kses_post( get_theme_mod('footer_middle_content','') ) ); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>