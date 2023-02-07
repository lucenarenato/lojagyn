<?php
/**
Post Types init
*/

// Do Shortcodes inside widgets
add_filter('widget_text', 'do_shortcode');

// Tag Cloud Size
function tag_cloud_filter($args = array()) {
   $args['smallest'] = 1;
   $args['largest'] = 1;
   $args['unit'] = 'em';
   $args['format']= 'list';
   return $args;
}

add_filter('widget_tag_cloud_args', 'tag_cloud_filter', 90);
add_filter('woocommerce_product_tag_cloud_widget_args', 'tag_cloud_filter', 90);


function goya_widgets_init() {

	// Latest Posts with Images
	include_once ( __DIR__ . '/latest-posts-images.php');
	register_widget( 'Goya_Widget_Latest_Images' );

	include_once ( __DIR__ . '/social-media.php');
	register_widget( 'Goya_Widget_Social_Media' );

	// Custom WooCommerce widgets
	if ( class_exists( 'WC_Widget' ) ) {

	}
	
}

add_action( 'widgets_init', 'goya_widgets_init' ); // Register widget sidebars
