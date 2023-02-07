<?php function goya_shortcode_content_carousel( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'columns'        => '1',
		'pagination'     => '',
		'arrows'         => '',
		'infinite'       => '',
		'animation'      => 'slide',
		'autoplay'       => '',
		'autoplay_speed' => '',
		'pause'          => '',
		'margins'        => 'regular-padding',
		'center'			   => '',
		'overflow'       => '',
		'extra_class'    => '',
	), $atts ) );

	$element_id = 'et-content-carousel-' . mt_rand(10, 999);
	
	$classes[] = 'row';
	$classes[] = 'et-content-carousel slick';
	$classes[] = $margins;
	$classes[] = $overflow;
	$classes[] = $extra_class;

	$fade = ( $animation != 'slide' ) ? 'true' : 'false';
	$infinite = (strlen( $infinite ) > 0 ) ? 'true' : 'false';
	
	$out ='';
	ob_start();

	?>
	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-center="<?php echo esc_attr($center); ?>" data-columns="<?php echo esc_attr($columns); ?>" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-fade="<?php echo esc_attr($fade); ?>" data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>" data-pause="<?php echo esc_attr($pause); ?>" data-navigation="<?php echo esc_attr($arrows); ?>" data-pagination="<?php echo esc_attr($pagination); ?>" data-infinite="<?php echo esc_attr($infinite); ?>">
		<?php echo do_shortcode($content); ?>
	</div>
		
	<?php

	$out = ob_get_clean();
	
	wp_reset_query();
	wp_reset_postdata();
		 
	return $out;
}
add_shortcode('et_content_carousel', 'goya_shortcode_content_carousel');