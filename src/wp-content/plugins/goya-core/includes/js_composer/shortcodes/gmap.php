<?php function goya_shortcode_gmap( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'marker_image'		=> '',
		'retina_marker'		=> '',
		'latitude'		=> '',
		'longitude'		=> '',
		'marker_title'		=> '',
		'marker_description'			=> '',
	), $atts ) );
	
	if ($marker_image) {
		$marker = wp_get_attachment_image_src( $marker_image, 'full' );
		$marker_image = $marker[0];
		$marker_size = array($marker[1],$marker[2]);
		$retina_marker = $retina_marker;
	} else {
		$marker_image = GOYA_THEME_URI . '/assets/img/pin.png';
		$marker_size = array(80,108);
		$retina_marker = true;
	}
	
	$options = array(
		'marker_image' => $marker_image,
		'marker_title' => esc_attr($marker_title),
		'marker_description' => esc_attr($marker_description),
		'marker_size' => $marker_size,
		'retina_marker' => esc_attr($retina_marker),
		'latitude' => esc_attr($latitude),
		'longitude' => esc_attr($longitude),	
	);
	
	ob_start(); ?>
	
	<input class="et-location-data" type="hidden" data-option="<?php echo esc_attr(json_encode($options)); ?>" />
	
	<?php 
	$out = ob_get_clean();
	return $out;
}
add_shortcode('et_gmap', 'goya_shortcode_gmap');