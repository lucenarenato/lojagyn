<?php
/**
 * Template part for displaying the sign-in
 *
 * @package Goya
 */

if( ! goya_wc_active() ) {
	return;
}
?>

<?php do_action( 'goya_get_myaccount_link', true ); ?>