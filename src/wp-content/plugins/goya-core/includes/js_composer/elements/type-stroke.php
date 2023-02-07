<?php 

// VC element: et_typestroke

vc_map( array(
	'base'  => 'et_typestroke',
	'name' => esc_html__('Stroke Type', 'goya-core' ),
	'description' => esc_html__('Text with Stroke style', 'goya-core' ),
	'category' => esc_html__('Goya', 'goya-core' ),
	'icon' => 'et_typestroke',
	'params' => array(
		array(
			'type'       => 'textarea_safe',
			'heading'    => esc_html__( 'Content', 'goya-core' ),
			'param_name' => 'slide_text',
			'value'		 => '<h2>Type Stroke</h2>',
			'description'=> 'Enter the content to display with stroke.',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Size', 'goya-core' ),
			'param_name' => 'text_size',
			'value' => array(
				__( 'Small (14 px)', 'goya-core' ) => 'small',
				__( 'Medium (24px)', 'goya-core' ) => 'medium',
				__( 'Large (32px)', 'goya-core' ) => 'large',
				__( 'X-Large (48px)', 'goya-core' ) => 'xlarge',
				__( 'XX-Large (72px)', 'goya-core' ) => 'xxlarge',
				__( 'Custom Size', 'goya-core' ) => 'custom',
			),
			'std' => 'medium',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Custom Text Size', 'goya-core' ),
			'param_name' => 'text_size_custom',
			'description' => esc_html__('Add the unit, for example: 28px. It will be scaled down on smaller devices.', 'goya-core' ),
			'dependency' => array(
				'element' => 'text_size',
				'value' => array( 'custom' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Color', 'goya-core' ),
			'param_name' => 'text_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Accent Color', 'goya-core' ) => 'accent',
				__( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Custom Text Color', 'goya-core' ),
			'param_name' => 'text_color_custom',
			'dependency' => array(
				'element' => 'text_color',
				'value' => array( 'custom' )
			),
		),
		array(
		  'type' 					=> 'textfield',
		  'heading' 			=> esc_html__('Stroke Width', 'goya-core' ),
		  'param_name' 		=> 'stroke_width',
		  'std'=> '',
		  'description' 	=> esc_html__('Enter the value for the stroke width (default: 1px) ', 'goya-core' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core' ),
			'param_name' => 'extra_class',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Animation', 'goya-core' ),
			'param_name' => 'animation',
			'value' => array(
				__( 'None', 'goya-core' )               => '',
				__( 'Right to Left', 'goya-core' )      => 'animation right-to-left',
				__( 'Left to Right', 'goya-core' )      => 'animation left-to-right',
				__( 'Right to Left - 3D', 'goya-core' ) => 'animation right-to-left-3d',
				__( 'Left to Right - 3D', 'goya-core' ) => 'animation left-to-right-3d',
				__( 'Bottom to Top', 'goya-core' )      => 'animation bottom-to-top',
				__( 'Top to Bottom', 'goya-core' )      => 'animation top-to-bottom',
				__( 'Bottom to Top - 3D', 'goya-core' ) => 'animation bottom-to-top-3d',
				__( 'Top to Bottom - 3D', 'goya-core' ) => 'animation top-to-bottom-3d',
				__( 'Scale', 'goya-core' )              => 'animation scale',
				__( 'Fade', 'goya-core' )               => 'animation fade',
			)
		),
	)
) );
