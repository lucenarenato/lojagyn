<?php // Image shortcode
vc_map( array(
	'name' => __('Image Slider', 'goya-core'),
	'description' => __('Add Slider with your images', 'goya-core'),
	'category' => __('Goya', 'goya-core'),
	'base' => 'et_image_slider',
	'icon' => 'et_image_slider',
	'params'	=> array(
		array(
			'type' => 'attach_images',
			'heading' => __('Select Images', 'goya-core'),
			'param_name' => 'images'
		),
		array(
		  'type' => 'textfield',
		  'heading' => esc_html__('Image size', 'goya-core'),
		  'param_name' => 'img_size',
		  'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'goya-core')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Display Caption?', 'goya-core'),
			'param_name' => 'caption',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('If selected, the image caption will be displayed.', 'goya-core'),
		),
		array(
			'type' 			=> 'textfield',
			'heading' => __( 'Columns', 'goya-core' ),
			'param_name' => 'columns',
			'description' => __( 'Select number of columns to show.', 'goya-core' ),
			'value' 		=> '1',
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
			'heading' 		=> __( 'Infinite Loop', 'goya-core' ),
			'param_name' => 'infinite',
			'description'	=> __( 'Infinite loop sliding.', 'goya-core' ),
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __('Use lightbox?', 'goya-core'),
			'param_name' => 'lightbox',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'yes',
				__( 'No', 'goya-core' ) => 'no',
			),
			'std' => 'no',
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Center Images', 'goya-core'),
			'param_name' => 'center',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Arrows', 'goya-core'),
			'param_name' => 'arrows',
			'description'	=> __( 'Display "prev" and "next" arrows.', 'goya-core' ),
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'dependency' => array(
				'element' => 'lightbox',
				'value' => array('no')
			),
			'group' => __( 'Navigation','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Navigation Dots', 'goya-core'),
			'param_name' => 'pagination',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'group' => __( 'Navigation','goya-core' ),
		),
		
		array(
			'type' => 'checkbox',
			'heading' => __('Overflow Visible?', 'goya-core'),
			'param_name' => 'overflow',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'overflow-visible'
			),
			'description' => __('Show semi-transparent previous and next slides', 'goya-core' ),
			'group' => __( 'Navigation','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Auto Play', 'goya-core'),
			'param_name' => 'autoplay',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'group' => __( 'Navigation','goya-core' ),
			'description' => __('If enabled, the carousel will autoplay.', 'goya-core'),
		),
		array(
			'type' => 'textfield',
			'heading' => __('Speed of the AutoPlay', 'goya-core'),
			'param_name' => 'autoplay_speed',
			'value' => '4000',
			'group' => __( 'Navigation','goya-core' ),
			'description' => __('Speed of the autoplay, default 4000 (4 seconds)', 'goya-core'),
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array('true')
			)
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Pause on hover', 'goya-core'),
			'param_name' => 'pause',
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
			'group' => __( 'Navigation','goya-core' ),
			'description' => __('Pause autoplay on hover.', 'goya-core'),
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array('true')
			)
		),
		array(
			'type' => 'textfield',
			'heading' => __('Extra Class Name', 'goya-core'),
			'param_name' => 'extra_class',
		),
	),
) );