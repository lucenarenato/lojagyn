<?php 

// VC element: et_counter

vc_map( array(
	'name' => esc_html__('Counter', 'goya-core' ),
	'base' => 'et_counter',
	'icon' => 'et_counter',
	'category' => esc_html__('Goya', 'goya-core' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'goya-core' ),
			'param_name' => 'style',
			'std' => 'counter-top',
			'value' => array(
				__( 'Counter Top', 'goya-core' ) => 'counter-top',
				__( 'Counter Bottom', 'goya-core' ) => 'counter-bottom',
				__( 'Counter Left', 'goya-core' ) => 'counter-left',
				__( 'Counter Right', 'goya-core' ) => 'counter-right',
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __('Icon Type', 'goya-core' ),
			'param_name' => 'icon_type',
			'description' => __( 'Select icon type.', 'goya-core' ),
			'value' => array(
				__( 'Font Icon', 'goya-core' ) => 'icon',
				__( 'Image', 'goya-core' ) => 'image_id'
			),
			'std' => 'icon',
			'dependency' => array(
				'element' => 'style',
				'value' => array( 'counter-top','counter-bottom' )),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'goya-core' ),
			'value' => array(
				__( 'Pixeden 7 Stroke', 'goya-core' ) => 'pixeden',
				__( 'Font Awesome', 'goya-core' ) => 'fontawesome',
			),
			'admin_label' => true,
			'param_name' => 'icon_library',
			'description' => __( 'Select icon library.', 'goya-core' ),
			'std' => 'pixeden',
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'icon'
			)
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'goya-core' ),
			'param_name' => 'icon_pixeden',
			'description' => __( 'Select icon from library.', 'goya-core' ),
			'value' => 'pe-7s-close',
			'settings' => array(
				'type' => 'pixeden',
				'emptyIcon' => false,
				'iconsPerPage' => 3000
			),
			'dependency' => array(
				'element' => 'icon_library',
				'value' => 'pixeden'
			)
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'goya-core' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust',
			'settings' => array(
				'emptyIcon' => false,
				'iconsPerPage' => 4000,
			),
			'dependency' => array(
				'element' => 'icon_library',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'goya-core' ),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'goya-core' ),
			'param_name' => 'image_id',
			'description' => __( 'Select image from the media library.', 'goya-core' ),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array( 'image_id' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Image Style', 'goya-core' ),
			'param_name' => 'image_style',
			'description' => __( 'Select an image style.', 'goya-core' ),
			'value' => array(
				__( 'Default', 'goya-core' ) => 'default',
				__( 'Rounded', 'goya-core' ) => 'rounded'
			),
			'std' => 'default',
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array( 'image_id' )
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Image Width', 'goya-core' ),
			'param_name' => 'icon_image_width',
			'description' => esc_html__( 'If you are using an image, you can set custom width here. Default is 64 (pixels).', 'goya-core' ),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array( 'image_id' )),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Counter Color', 'goya-core' ),
			'param_name' => 'counter_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
        __( 'Dark', 'goya-core' ) => 'dark',
        __( 'Light', 'goya-core' ) => 'light',
        __( 'Accent Color', 'goya-core' ) => 'accent',
        __( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Counter Custom Color', 'goya-core' ),
			'param_name' => 'counter_color_custom',
			'dependency' => array(
				'element' => 'counter_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon Color', 'goya-core' ),
			'param_name' => 'icon_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
        __( 'Dark', 'goya-core' ) => 'dark',
        __( 'Light', 'goya-core' ) => 'light',
        __( 'Accent Color', 'goya-core' ) => 'accent',
        __( 'Custom', 'goya-core' ) => 'custom'
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array('icon')
			),
			'std' => '',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Icon Custom Color', 'goya-core' ),
			'param_name' => 'icon_color_custom',
			'dependency' => array(
				'element' => 'icon_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Color', 'goya-core' ),
			'param_name' => 'text_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
        __( 'Dark', 'goya-core' ) => 'dark',
        __( 'Light', 'goya-core' ) => 'light',
        __( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Text Custom Color', 'goya-core' ),
			'param_name' => 'text_color_custom',
			'dependency' => array(
				'element' => 'text_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Number to Count', 'goya-core' ),
			'param_name' => 'counter',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Speed of the counter animation', 'goya-core' ),
			'param_name' => 'speed',
			'value' => '2000',
			'description' => esc_html__('Speed of the counter animation, default 1500', 'goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Title', 'goya-core' ),
			'param_name' => 'title',
			'admin_label' => true
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Description', 'goya-core' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Include a small description for this counter', 'goya-core' ),
		),
	),
	'description' => esc_html__('Counters with icons', 'goya-core' )
) );
