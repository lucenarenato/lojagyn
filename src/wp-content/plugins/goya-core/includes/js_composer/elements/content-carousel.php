<?php

// Content Carousel Shortcode
vc_map( array(
	'name' => esc_html__('Content Carousel', 'goya-core'),
	'description' => esc_html__('Display your content in a carousel', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_content_carousel',
	'icon' => 'et_content_carousel',
	'as_parent' => array('except' => 'et_content_carousel'),	
	
	'show_settings_on_create' => true,
	'content_element' => true,
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns', 'goya-core'),
			'param_name' => 'columns',
			'value' => array(
				__( '1 Column', 'goya-core' ) => '1',
				__( '2 Columns', 'goya-core' ) => '2',
				__( '3 Columns', 'goya-core' ) => '3',
				__( '4 Columns', 'goya-core' ) => '4'
			),
			'std' => '1',
			'description' => esc_html__('Select the layout.', 'goya-core' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Animation', 'goya-core'),
			'param_name' => 'animation',
			'value' => array(
				__( 'Slide', 'goya-core' ) => 'slide',
				__( 'Fade', 'goya-core' ) => 'fade',
			),
			'std' => 'slide',
		),
		
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Infinite', 'goya-core'),
			'param_name' => 'infinite',
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('Infinite loop sliding.', 'goya-core'),
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Auto Play', 'goya-core'),
			'param_name' => 'autoplay',
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('If enabled, the carousel will autoplay.', 'goya-core'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Speed of the AutoPlay', 'goya-core'),
			'param_name' => 'autoplay_speed',
			'value' => '4000',
			'description' => esc_html__('Speed of the autoplay, default 4000 (4 seconds)', 'goya-core'),
			'dependency' => array(
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
		array(
			'type' => 'checkbox',
			'heading' => __('Center Slides', 'goya-core'),
			'param_name' => 'center',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Margins between items', 'goya-core'),
			'param_name' => 'margins',
			'std'=> 'regular-padding',
			'value' => array(
				__( 'Regular', 'goya-core' ) => 'regular-padding',
				__( 'Mini', 'goya-core' ) => 'mini-padding',
				__( 'Pixel', 'goya-core' ) => 'pixel-padding',
				__( 'None', 'goya-core' ) => 'no-padding'
			),
			'description' => esc_html__('This will change the margins between items', 'goya-core' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Navigation Dots', 'goya-core'),
			'param_name' => 'pagination',
			'value' => array(
				__( 'Enable', 'goya-core' )	=> 'true'
			),
			'group' => __( 'Navigation','goya-core' ),
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Arrows', 'goya-core' ),
			'param_name' 	=> 'arrows',
			'description'	=> __( 'Display "prev" and "next" arrows.', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> 'true'
			),
			'group' => __( 'Navigation','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Overflow Visible?', 'goya-core'),
			'param_name' => 'overflow',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'overflow-visible'
			),
			'std' => '',
			'description' => esc_html__('Show semi-transparent previous and next slides', 'goya-core' ),
			'group' => __( 'Navigation','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core'),
			'param_name' => 'extra_class',
		),
	),
	'js_view' => 'VcColumnView',
) );

class WPBakeryShortCode_ET_Content_Carousel extends WPBakeryShortCodesContainer { }