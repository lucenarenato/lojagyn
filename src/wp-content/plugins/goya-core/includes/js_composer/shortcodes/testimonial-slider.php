<?php function goya_shortcode_testimonial_slider( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'arrows'         => '',
		'pagination'     => '',
		'animation'      => 'slide',
		'speed'          => '',
		'autoplay'       => '',
		'autoplay_speed' => '',
		'pause'          => '',
	), $atts ) );

	$autoplay = ( $autoplay == true ) ? $autoplay : 'false';
	$speed = ( $speed > 0 ) ? $speed : false;
	$autoplay_speed = ( $autoplay_speed > 0 ) ? $autoplay_speed : false;
	
	$element_id = 'et-testimonials-' . mt_rand(10, 99);

	if ( strlen( $pagination ) > 0 ) { $classes[] = 'slick-dots-centered'; }
	$classes[] = 'et-testimonials-slider';
	$classes[] = 'slick';

	$out ='';
	ob_start();
	?>
	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo implode(' ', $classes); ?>" data-pagination="<?php echo esc_attr($pagination); ?>" data-navigation="<?php echo esc_attr($arrows); ?>" data-infinite="true"  data-columns="1" data-adaptive-height="true" <?php if ( $speed > 0 ) { ?> data-speed="<?php echo esc_attr( $speed ); ?>"<?php } ?>  data-autoplay="<?php echo esc_attr( $autoplay ); ?>" data-autoplay-speed="<?php echo esc_attr( intval( $autoplay_speed ) ); ?>" data-pause="<?php echo esc_attr($pause); ?>" <?php if ( $animation == 'fade' ) { ?> data-fade="true"<?php } ?>>
		<?php echo wpb_js_remove_wpautop($content, false); ?>
	</div>
	<?php
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	return $out;
}
add_shortcode('et_testimonial_slider', 'goya_shortcode_testimonial_slider');