<?php function goya_shortcode_gmap_parent( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'height'		=> '50',
		'zoom'		=> '0',
		'map_controls'		=> 'panControl, zoomControl, mapTypeControl, scaleControl',
		'map_type'		=> 'roadmap_custom',
		'map_style'		=> 'paper',
		'custom_map_style'		=> '',
		'locations_list'		=> '0',
		'locations_columns'		=> '4',
		'locations_layout'		=> 'horizontal',
		'autoselect_first'		=> '1',
	), $atts ) );

	$api_version = 'v=3';
	$google_api_key = get_theme_mod('google_api_key', '');
	$api_key = ( strlen( $google_api_key ) > 0 ) ? '&key=' . $google_api_key : '';

	// Enqueue Google Map scripts
	wp_enqueue_script( 'google-maps-api', '//maps.google.com/maps/api/js?' . $api_version . $api_key . '', FALSE, NULL, TRUE );
	wp_enqueue_script( 'goya-google-maps', GOYA_THEME_URI . '/assets/js/dev/goya-google-maps.js', array( 'jquery', 'google-maps-api' ), GOYA_THEME_VERSION, TRUE );
	
	$map_type = ($map_type == 'roadmap_custom') ? 'roadmap' : $map_type;
	$custom_map_style = rawurldecode( goya_decode( strip_tags( $custom_map_style ) ) );
	$map_controls = explode( ',', $map_controls );
	
	$location_title = $location_description = '';
	preg_match_all( '/marker_title=\"(.*?)\"\smarker_description=\"(.*?)\"/is', $content, $matches, PREG_OFFSET_CAPTURE );
	
	$locations = [];
	if (isset($matches[1])) {
		for ($i = 0; $i < sizeof($matches[1]); ++$i) {
			$locations[] = [
				'title' 				=> $matches[1][$i][0],
				'description' => $matches[2][$i][0],
			];
		}
	}
	$element_id = 'et-map-parent-' . mt_rand(10, 999);

	$locations_class = $locations_layout;
	$data_vertical = $map_width = $row_width = '';

	if ($locations_list == 1) {
		if ($locations_layout == 'vertical') {
			$data_vertical = 'true';

			$map_width = 'col-md-7 col-lg-8';
			$row_width = 'row max_width flex-row-reverse';
			$locations_class .= ' col-md-5 col-lg-4 slick slick-slider ';
		} else {
			$locations_class .= ' row max_width slick slick-slider ';
		}

		if($autoselect_first == 1) {
			$locations_class .= ' autoselect_first';
		}
	} else {
		$locations_class = 'list-hidden';
	}

	ob_start(); ?>

	<div class="et_map_group <?php echo esc_attr($row_width); ?>">

		<div class="et_map_parent <?php echo esc_attr($map_width); if ( $api_key === '' ) { ?> disabled<?php } ?>"
			style="height:<?php echo esc_attr($height); ?>vh" 
			data-map-style="<?php echo esc_attr($map_style); ?>" 
			data-custom-map-style="<?php echo esc_attr($custom_map_style); ?>" 
			data-map-zoom="<?php echo esc_attr($zoom); ?>" 
			data-map-type="<?php echo esc_attr($map_type); ?>" 
			data-pan-control="<?php echo esc_attr(in_array( 'panControl', $map_controls )); ?>" 
			data-zoom-control="<?php echo esc_attr(in_array( 'zoomControl', $map_controls )); ?>" 
			data-maptype-control="<?php echo esc_attr(in_array( 'mapTypeControl', $map_controls )); ?>" 
			data-scale-control="<?php echo esc_attr(in_array( 'scaleControl', $map_controls )); ?>" 
			data-streetview-control="<?php echo esc_attr(in_array( 'streetViewControl', $map_controls )); ?>">
			<?php if ( $api_key !== '' ) { ?>
				<?php echo wpb_js_remove_wpautop($content, false); ?>
			<?php } else { ?>
				<?php esc_html_e('Please fill out Google Maps API Key', 'goya-core'); ?>
			<?php } ?>
		</div>

		<?php if (sizeof($locations)) { ?>
			<div id="<?php echo esc_attr($element_id); ?>" class="et_location_list <?php echo esc_attr($locations_class); ?>" data-columns="<?php echo esc_attr($locations_columns); ?>" data-autoplay="false" data-vertical="<?php echo esc_attr($data_vertical); ?>" data-adaptive-height="false" data-pagination="true" data-navigation="true" data-infinite="false">
				<?php $i = 1; foreach ($locations as $location) { ?>
					<div class="et_location_outer">
						<div class="et_location">
							<h5><?php echo esc_attr($i); ?>. <?php echo esc_html($location['title']); ?></h5>
							<?php echo wp_kses_post(goya_remove_p($location['description'])); ?>
						</div>
					</div>
				<?php $i++; } ?>
			</div>
		<?php } ?>
	
	</div>

	<?php 

	$out = ob_get_clean();
	return $out;
}
add_shortcode('et_gmap_parent', 'goya_shortcode_gmap_parent');