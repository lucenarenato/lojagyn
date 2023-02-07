<?php
/**
 * Template part for displaying the cart icon
 *
 * @package Goya
 */
if( ! goya_wc_active() ) {
	return;
}
?>

<?php do_action( 'goya_quick_cart' ); ?>
