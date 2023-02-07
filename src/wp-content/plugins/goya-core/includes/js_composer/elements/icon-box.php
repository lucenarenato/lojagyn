<?php
	
// VC element: et_iconbox

vc_map( array(
	 'name'			=> __( 'Icon Box', 'goya-core' ),
	 'description'	=> __( 'Feature box with image or icon.', 'goya-core' ),
	 'category' => esc_html__('Goya', 'goya-core'),
	 'base'			=> 'et_iconbox',
	 'icon'			=> 'et_iconbox',
	 'params'			=> array(
		
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __('Icon Type', 'goya-core' ),
			'param_name' 	=> 'icon_type',
			'description'	=> __( 'Select icon type.', 'goya-core' ),
			'value' 		=> array(
				__( 'Font Icon', 'goya-core' )	=> 'icon',
				__( 'Image', 'goya-core' )		=> 'image_id',
				__( 'External Image', 'goya-core' )		=> 'external_img'
			),
			'std' 			=> 'icon',
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
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value'		=> 'icon'
			)
		),
		array(
			'type' 			=> 'iconpicker',
			'heading' 		=> __( 'Icon', 'goya-core' ),
			'param_name' 	=> 'icon_pixeden',
			'description' 	=> __( 'Select icon from library.', 'goya-core' ),
			'value' 		=> 'pe-7s-close',
			'settings' 		=> array(
				'type' 			=> 'pixeden',
				'emptyIcon' 	=> false,
				'iconsPerPage'	=> 500
			),
			'dependency'	=> array(
				'element'	=> 'icon_library',
				'value'		=> 'pixeden'
			)
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'goya-core' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust',
			'settings' => array(
				'emptyIcon' => false,
				'iconsPerPage' => 500,
			),
			'dependency' => array(
				'element' => 'icon_library',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'goya-core' ),
		),
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'External Image', 'goya-core' ),
			'param_name' 	=> 'image_url',
			'description'	=> __( 'Image Link', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value' 	=> array( 'external_img' )
			)
		),
		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Image', 'goya-core' ),
			'param_name' 	=> 'image_id',
			'description'	=> __( 'Select image from the media library.', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value' 	=> array( 'image_id' )
			)
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Image Style', 'goya-core' ),
			'param_name' 	=> 'image_style',
			'description'	=> __( 'Select an image style.', 'goya-core' ),
			'value' 		=> array(
				__( 'Default', 'goya-core' )	=> 'default',
				__( 'Rounded', 'goya-core' )	=> 'rounded'
			),
			'std' 			=> 'default',
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value' 	=> array( 'image_id' )
			)
		),
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Title', 'goya-core' ),
			'param_name' 	=> 'title',
			'description'	=> __( 'Enter a feature title.', 'goya-core' )
		),
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Sub-title', 'goya-core' ),
			'param_name' 	=> 'subtitle',
			'description'	=> __( 'Enter a sub-title.', 'goya-core' )
		),
		array(
			'type' 			=> 'textarea_html',
			'heading' 		=> __( 'Description', 'goya-core' ),
			'param_name' 	=> 'content', // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
			'description'	=> __( 'Enter a feature description.', 'goya-core' )
		),
		array(
			'type' 			=> 'vc_link',
			'heading' 		=> __( 'Link', 'goya-core' ),
			'param_name' 	=> 'link',
			'description' 	=> __( 'Add a link for the icon and title.', 'goya-core' )
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __('Layout', 'goya-core' ),
			'param_name' 	=> 'layout',
			'description'	=> __( 'Select a layout.', 'goya-core' ),
			'value' 		=> array(
				__( 'Default', 'goya-core' )		=> 'default',
				__( 'Centered', 'goya-core' )		=> 'centered',
				__( 'Icon Right', 'goya-core' )	=> 'icon_right',
				__( 'Icon Left', 'goya-core' )		=> 'icon_left'
			),
			'std' 			=> 'default',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Icon Style', 'goya-core' ),
			'param_name' 	=> 'icon_style',
			'value' 		=> array(
				__( 'Icon Only', 'goya-core' )		=> 'simple',
				__( 'Solid Background', 'goya-core' )	=> 'background',
				__( 'With Border', 'goya-core' )		=> 'border'
			),
			'std' 			=> 'simple',
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value' 	=> array( 'icon' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' 		=> __( 'Icon Color', 'goya-core' ),
			'param_name' => 'icon_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Accent Color', 'goya-core' ) => 'accent',
				__( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'dependency'	=> array(
				'element'	=> 'icon_type',
				'value' 	=> array( 'icon' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Icon Custom Color', 'goya-core' ),
			'param_name' 	=> 'icon_color_custom',
			'dependency'	=> array(
				'element'	=> 'icon_color',
				'value' 	=> array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Icon Background', 'goya-core' ),
			'param_name' 	=> 'icon_background_color_custom',
			'description' 	=> __( 'For "Solid Background" style only.', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'icon_color',
				'value' 	=> array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' 		=> __( 'Text Color Scheme', 'goya-core' ),
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
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Title Color', 'goya-core' ),
			'param_name' 	=> 'title_color',
			'dependency'	=> array(
				'element'	=> 'text_color',
				'value' 	=> array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'colorpicker',
			'heading' 		=> __( 'Subtitle Color', 'goya-core' ),
			'param_name' 	=> 'subtitle_color',
			'dependency'	=> array(
				'element'	=> 'text_color',
				'value' 	=> array( 'custom' )
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Animation', 'goya-core' ),
			'param_name' 	=> 'animation',
			'value' 		=> array(
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
			'std' 			=> 'animation bottom-to-top',
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __('Bottom Spacing', 'goya-core' ),
			'param_name' 	=> 'bottom_spacing',
			'value' 		=> array(
				__( 'None', 'goya-core' )	=> 'none',
				__( 'Small', 'goya-core' )		=> 'small',
				__( 'Medium', 'goya-core' )	=> 'medium',
				__( 'Large', 'goya-core' )		=> 'large'
			),
			'std' 			=> 'none',
			'group' => __( 'Styling','goya-core' ),
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