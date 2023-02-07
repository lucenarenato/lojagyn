<?php 

// VC element: et_typeauto

vc_map( array(
	'base'  => 'et_typeauto',
	'name' => esc_html__('Auto Type', 'goya-core' ),
	'description' => esc_html__('Animated text typing', 'goya-core' ),
	'category' => esc_html__('Goya', 'goya-core' ),
	'icon' => 'et_typeauto',
	'params' => array(
		array(
			'type'       => 'textarea_safe',
			'heading'    => esc_html__( 'Content', 'goya-core' ),
			'param_name' => 'typed_text',
			'value'		 => '<h2>Your animated text *Goya;WordPress*</h2>',
			'description'=> __( 'Enter the content to display with typing text. <br />
			Text within <strong>*</strong> will be animated, for example: <strong>*Sample text*</strong>. <br />Text separator is <strong>;</strong> for example: <strong>*Goya;WordPress*</strong>', 'goya-core' ),
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
			'heading' => __( 'Animated Text Color', 'goya-core' ),
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
	    'type' => 'textfield',
	    'heading' => esc_html__('Type Speed', 'goya-core' ),
	    'param_name' => 'typed_speed',
	    'description' => esc_html__('Speed of the type animation. Default is 50', 'goya-core' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Cursor', 'goya-core' ),
			'param_name' => 'cursor',
			'value' => array(
				__( 'Yes', 'goya-core' ) => '1'
			),
			'description' => esc_html__('If enabled, the text will always animate, looping through the sentences used.', 'goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Loop', 'goya-core' ),
			'param_name' => 'loop',
			'value' => array(
				__( 'Yes', 'goya-core' ) => '1'
			),
			'description' => esc_html__('If enabled, the text will always animate, looping through the sentences used.', 'goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core' ),
			'param_name' => 'extra_class',
		),
	)
) );
