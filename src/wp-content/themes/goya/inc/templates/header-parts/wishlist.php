<?php
/**
 * Template part for displaying the wishlist icon
 *
 * @package Goya
 */

if( ! goya_wc_active() ) {
	return;
}

do_action( 'goya_quick_wishlist' );
