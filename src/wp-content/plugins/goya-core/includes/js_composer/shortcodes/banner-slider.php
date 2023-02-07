<?php
	
	// Shortcode: et_banner_slider
	function goya_shortcode_banner_slider( $atts, $content = NULL ) {
		
		extract( shortcode_atts( array(
			'adaptive_height'	=> '',
			'arrows' 			=> '',
			'pagination'		=> '',
			'pagination_color'	=> 'gray',
			'infinite'			=> '',
			'animation'			=> 'slide',
			'speed'				=> '',
			'autoplay'			=> '',
			'autoplay_speed'			=> '4000',
			'pause'			=> '',
			'background_color'	=> ''
		), $atts ) );

		$element_id = uniqid('et-banner-slider-');
		
		$slider_class = 'et-banner-slider slick slick-slider slick-controls-' . esc_attr( $pagination_color );
		
		$slider_settings_data = ' ';
		
		// Adaptive Height
		if ( strlen( $adaptive_height ) > 0 ) { $slider_settings_data .= 'data-adaptive-height="true" '; }
		
		// Arrows
		if ( strlen( $arrows ) > 0 ) { $slider_settings_data .= 'data-navigation="true" '; }
		
		// Pagination
		if ( strlen( $pagination ) > 0 ) {
			$slider_class .= ' slick-dots-inside';
			$slider_settings_data .= 'data-pagination="true" ';
		} else {
			$slider_class .= ' slick-dots-disabled';
		}
		
		// Animation
		if ( $animation != 'slide' ) { $slider_settings_data .= 'data-fade="true" '; }
        
		// Speed
		if ( strlen( $speed ) > 0 ) { $slider_settings_data .= 'data-speed="' . intval( $speed ) . '" '; }
		
		// Autoplay
		if ( strlen( $autoplay ) > 0 ) { $slider_settings_data .= 'data-autoplay="true" data-autoplay-speed="' . intval( $autoplay_speed ) . '" '; }
		
		// Infinite loop
		if ( strlen( $infinite ) > 0 ) { $slider_settings_data .= 'data-infinite="true" '; }

		// Pause on hover
		if ( strlen( $pause ) > 0 ) { $slider_settings_data .= 'data-pause="true"'; }

				
		$output = '<div id="' . $element_id . '" class="' . $slider_class . '"' . $slider_settings_data . ' data-columns="1" >' . do_shortcode( $content ) . '</div>';
						
		return $output;
	}
	
	add_shortcode( 'et_banner_slider', 'goya_shortcode_banner_slider' );
	