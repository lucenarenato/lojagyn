<?php

// VC element: et_testimonial_slider
vc_map( array(
	'name' => esc_html__('Testimonial Slider', 'goya-core'),
	'description' => __( 'Create a testimonials slider', 'goya-core' ),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_testimonial_slider',
	'icon' => 'et_testimonial_slider',
	'content_element'	=> true,
	
	'js_view' => 'VcColumnView',
	'as_parent' => array('only' => 'et_testimonial'),
	'params'	=> array(
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Arrows', 'goya-core' ),
			'param_name' 	=> 'arrows',
			'description'	=> __( 'Display "prev" and "next" arrows.', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> 'true'
			)
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Pagination', 'goya-core' ),
			'param_name' 	=> 'pagination',
			'description'	=> __( 'Display pagination.', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> 'true'
			)
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Animation Type', 'goya-core' ),
			'param_name' 	=> 'animation',
			'description'	=> __( 'Select animation type.', 'goya-core' ),
			'value' 		=> array(
				__( 'Fade', 'goya-core' )  => 'fade',
				__( 'Slide', 'goya-core' ) => 'slide'
			),
			'std' 			=> 'slide'
		),
		array(
			'type'      => 'textfield',
			'heading'     => __( 'Animation Speed', 'goya-core' ),
			'param_name'  => 'speed',
			'description' => __( 'Enter animation speed in milliseconds (1 second = 1000 milliseconds). Default is 600.', 'goya-core' )
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Autoplay', 'goya-core' ),
			'param_name' 	=> 'autoplay',
			'description'	=> __( 'Change slides automatically.', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> 'true'
			)
		),
		array(
			'type'      => 'textfield',
			'heading'     => __( 'Autoplay Speed', 'goya-core' ),
			'param_name'  => 'autoplay_speed',
			'description' => __( 'Enter autoplay in milliseconds (1 second = 1000 milliseconds). Default is 2500.', 'goya-core' ),
			'dependency'  => array(
        'element' => 'autoplay',
        'value' => array('true')
      )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Pause on hover', 'goya-core'),
			'param_name' => 'pause',
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('Pause autoplay on hover.', 'goya-core'),
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array('true')
      )
		),
	)
) );

// Extend element with the WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_ET_Testimonial_Slider extends WPBakeryShortCodesContainer {}
}