<?php
	
// VC element: et_button
vc_map( array(
	 'name'			=> esc_html__( 'Button', 'goya-core' ),
	 'description'	=> esc_html__( 'Stylish button', 'goya-core' ),
	 'category' => esc_html__('Goya', 'goya-core'),
	 'base'			=> 'et_button',
	 'icon'			=> 'et_button',
	 'params'			=> array(
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Title', 'goya-core' ),
			'param_name' 	=> 'title',
			'description'	=> __( 'Add button title.', 'goya-core' ),
			'value' 		=> __( 'Button', 'goya-core' )
		),
		array(
			'type'			=> 'vc_link',
			'heading'		=> __( 'URL (Link)', 'goya-core' ),
			'param_name'	=> 'link',
			'description'	=> __( 'Add a button link.', 'goya-core' )
		),
		
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Add Arrow', 'goya-core'),
			'param_name' => 'add_arrow',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('If enabled, will show an arrow on hover.', 'goya-core'),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Size', 'goya-core' ),
			'param_name'	=> 'size',
			'description'	=> __( 'Select button size.', 'goya-core' ),
			'value'			=> array(
				__( 'Large', 'goya-core' )			=> 'lg',
				__( 'Medium', 'goya-core' )		=> 'md',
				__( 'Small', 'goya-core' ) 		=> 'sm',
			),
			'std' 			=> 'md'
		),
		array(
			'type'      => 'dropdown',
			'heading'     => __( 'Animation', 'goya-core' ),
			'param_name'  => 'animation',
			'value'     => array(
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
			),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Style', 'goya-core' ),
			'param_name'	=> 'style',
			'description'	=> __( 'Select button style.', 'goya-core' ),
			'value' 		=> array(
				__( 'Solid', 'goya-core' )			=> 'solid',
				__( 'Solid Rounded', 'goya-core' )	=> 'solid rounded',
				__( 'Outlined', 'goya-core' )			=> 'outlined',
				__( 'Outlined Rounded', 'goya-core' )	=> 'outlined rounded',
				__( 'Link', 'goya-core' )				=> 'link',
			),
			'std'			=> 'solid',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link/Button Color', 'goya-core' ),
			'description' => __( 'Also border color if "Outlined Button" is selected', 'goya-core' ),
			'param_name' => 'color',
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
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Custom Color', 'goya-core' ),
			'description'	=> __( 'Link/Button custom color.', 'goya-core' ),
			'param_name' 	=> 'color_custom',
			'group' => __( 'Styling','goya-core' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array('custom')
			),
		),
		array(
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Text Color (solid buttons)', 'goya-core' ),
			'description'	=> __( 'Text color for solid buttons.', 'goya-core' ),
			'param_name' 	=> 'text_color_custom',
			'group' => __( 'Styling','goya-core' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array('custom')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Add Shadow on Hover?', 'goya-core'),
			'param_name' => 'shadow',
			'group' => __( 'Styling','goya-core' ),
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'button-shadow'
			),
			'dependency' => array(
				'element' => 'style',
				'value' => array('solid', 'solid rounded')
			),
			'description' => esc_html__('If enabled, this will add a shadow to the button', 'goya-core'),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Align', 'goya-core' ),
			'param_name'	=> 'align',
			'description'	=> __( 'Select button alignment.', 'goya-core' ),
			'value'			=> array(
				__( 'Left', 'goya-core' ) 		=> 'left',
				__( 'Center', 'goya-core' )	=> 'center',
				__( 'Right', 'goya-core' ) 	=> 'right',
				__( 'Full Width', 'goya-core' ) 	=> 'full'
			),
			'group' => __( 'Styling','goya-core' ),
			'std' 			=> 'left'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class', 'goya-core' ),
			'description' => esc_html__('Add a class for more customization', 'goya-core' ),
			'param_name' => 'extra_class',
			'group' => __( 'Styling','goya-core' ),
		),
	)
) );
