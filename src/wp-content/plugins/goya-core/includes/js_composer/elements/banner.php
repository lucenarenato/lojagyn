<?php
	
// VC element: et_banner
vc_map( array(
	'name' => __( 'Banner', 'goya-core' ),
	'description' => __( 'Responsive banner', 'goya-core' ),
	'base' => 'et_banner',
	'icon' => 'et_banner',
	'category' => esc_html__('Goya', 'goya-core'),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Content Layout', 'goya-core' ),
			'param_name' => 'layout',
			'description' => __( 'Select content layout. "Inherit" matches the site global container width', 'goya-core' ),
			'value' => array(
				__( 'Full Width', 'goya-core' ) => 'full',
				__( 'Inherit', 'goya-core' ) => 'boxed',
			),
			'std' => 'full',
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'goya-core' ),
			'param_name' => 'image_id',
			'description' => __( 'Add a banner image.', 'goya-core' )
		),
		array(
			'type'      => 'attach_image',
			'heading'     => __( 'Image - Tablet/Mobile', 'goya-core' ),
			'param_name'  => 'alt_image_id',
			'description'   => __( 'Set an optional banner image to display on smaller screens (max-width: 767px).', 'goya-core' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Image Type', 'goya-core' ),
			'param_name' => 'image_type',
			'description' => __( '1. Fluid: the image size determines the banner height. 2) Background image: you can set your preferred height.', 'goya-core' ),
			'value' => array(
				__( 'Fluid Image', 'goya-core' ) => 'fluid',
				__( 'CSS Background Image', 'goya-core' ) => 'css'
			),
			'std' => 'fluid'
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Banner Height', 'goya-core' ),
			'param_name' => 'height',
			'description' => __( 'Proportional to screen height', 'goya-core' ),
			'value' => array(
				'10%' => '10',
				'20%' => '20',
				'30%' => '30',
				'40%' => '40',
				'50%' => '50',
				'60%' => '60',
				'70%' => '70',
				'80%' => '80',
				'90%' => '90',
				'100%' => '100',
				__( 'Custom Height', 'goya-core' ) => 'custom',
			),
			'std' => '50',
			'dependency' => array(
				'element' => 'image_type',
				'value' => array( 'css' )
			),
			'group' => __( 'Size','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Custom Banner Height', 'goya-core' ),
			'param_name' => 'custom_height',
			'description' => __( 'Enter banner height with unit (eg. 300px).', 'goya-core' ),
			'dependency' => array(
				'element' => 'height',
				'value' => array( 'custom' )
			),
			'group' => __( 'Size','goya-core' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Banner Height  - Mobiles', 'goya-core' ),
			'param_name' => 'height_mobile',
			'description' => __( 'Proportional to screen height', 'goya-core' ),
			'value' => array(
				__( 'Same as desktop', 'goya-core' ) => '',
				'10%' => '10',
				'20%' => '20',
				'30%' => '30',
				'40%' => '40',
				'50%' => '50',
				'60%' => '60',
				'70%' => '70',
				'80%' => '80',
				'90%' => '90',
				'100%' => '100',
				__( 'Custom Height', 'goya-core' ) => 'custom',
			),
			'std' => '',
			'dependency' => array(
				'element' => 'image_type',
				'value' => array( 'css' )
			),
			'group' => __( 'Size','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Custom Banner Height - Mobiles', 'goya-core' ),
			'param_name' => 'custom_height_mobile',
			'description' => __( 'Enter banner height with unit (eg. 300px).', 'goya-core' ),
			'dependency' => array(
				'element' => 'height_mobile',
				'value' => array( 'custom' )
			),
			'group' => __( 'Size','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Image size', 'goya-core'),
			'param_name' => 'img_size',
			'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Leave empty to use "full" image size.', 'goya-core'),
			'group' => __( 'Size','goya-core' ),
		),
		array(
		  'type' => 'textfield',
		  'heading' => esc_html__('"Sizes" attribute', 'goya-core'),
		  'param_name' => 'img_sizes',
		  'description' => esc_html__('Enter image \'sizes\' attribute for responsive image loading. Leave empty if unsure.', 'goya-core'),
		  'group' => __( 'Size','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Default Color Scheme', 'goya-core' ),
			'param_name' => 'text_color_scheme',
			'description' => __( 'This is the Default banner text color. You can override the color of each element.', 'goya-core' ),
			'value' => array(
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light'
			),
			'std' => 'dark',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Banner Background', 'goya-core' ),
			'param_name' => 'background_color',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Hover Effect', 'goya-core' ),
			'param_name' => 'hover_effect',
			'description' => __( 'Animation on hover.', 'goya-core' ),
			'value' => array(
				__( 'None', 'goya-core' ) => '',
				__( 'Border', 'goya-core' ) => 'hover-border',
				__( 'Zoom', 'goya-core' ) => 'hover-zoom',
				__( 'Border & Zoom', 'goya-core' ) => 'hover-border hover-zoom'
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Hover Border Color', 'goya-core' ),
			'param_name' => 'border_color',
			'description' => __( 'Border color used on hover effect.', 'goya-core' ),
			'dependency' => array(
				'element' => 'hover_effect',
				'value' => array( 'hover-border', 'hover-border hover-zoom' )
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class', 'goya-core' ),
			'description' => esc_html__('Add a class for more customization', 'goya-core' ),
			'param_name' => 'extra_class',
		),
		array(
			'type' => 'vc_link',
			'heading' => __( 'Link (URL)', 'goya-core' ),
			'param_name' => 'link',
			'description' => __( 'Set a banner link.', 'goya-core' ),
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link Type', 'goya-core' ),
			'param_name' => 'link_type',
			'description' => __( 'Full banner link (text/button not visible) or text/button link only', 'goya-core' ),
			'value' => array(
				__( 'Banner Link', 'goya-core' ) => 'banner_link',
				__( 'Text/Button Link', 'goya-core' ) => 'text_link'
			),
			'std' => 'banner_link',
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link Style', 'goya-core' ),
			'param_name' => 'link_style',
			'value' => array(
				__( 'Solid Button', 'goya-core' ) => 'solid',
				__( 'Outlined Button', 'goya-core' ) => 'outlined',
				__( 'Text Link', 'goya-core' ) => 'link'
			),
			'std' => 'link_style',
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'text_link' )
			),
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text/Button Link Color', 'goya-core' ),
			'description' => __( 'Also border color if "Outlined Button" is selected', 'goya-core' ),
			'param_name' => 'link_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Accent Color', 'goya-core' ) => 'accent',
				__( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Text/Button Link Color', 'goya-core' ),
			'param_name' => 'link_color_custom',
			'dependency' => array(
				'element' => 'link_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Button Background', 'goya-core' ),
			'param_name' => 'link_background_custom',
			'dependency' => array(
				'element' => 'link_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Link','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'goya-core' ),
			'param_name' => 'title',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Size', 'goya-core' ),
			'param_name' => 'title_size',
			'value' => array(
				__( 'Small', 'goya-core' ) => 'small',
				__( 'Medium', 'goya-core' ) => 'medium',
				__( 'Large', 'goya-core' ) => 'large',
				__( 'X-Large', 'goya-core' ) => 'xlarge',
				__( 'XX-Large', 'goya-core' ) => 'xxlarge',
			),
			'std' => 'medium',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Tag', 'goya-core' ),
			'param_name' => 'title_tag',
			'description' => __( 'Select a title HTML tag.', 'goya-core' ),
			'value' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6'
			),
			'std' => 'h2',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Color', 'goya-core' ),
			'param_name' => 'title_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Accent Color', 'goya-core' ) => 'accent',
				__( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Title Color', 'goya-core' ),
			'param_name' => 'title_color_custom',
			'dependency' => array(
				'element' => 'title_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Subtitle/Label', 'goya-core' ),
			'param_name' => 'subtitle',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Subtitle Type', 'goya-core' ),
			'param_name' => 'subtitle_type',
			'description' => __( 'Text only or Label style', 'goya-core' ),
			'group' => __( 'Content','goya-core' ),
			'value' => array(
				__( 'Text', 'goya-core' ) => 'text_style',
				__( 'Label', 'goya-core' ) => 'tag_style'
			),
			'std' => 'text_style'
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Subtitle Tag', 'goya-core' ),
			'param_name' => 'subtitle_tag',
			'description' => __( 'Select a subtitle HTML tag.', 'goya-core' ),
			'value' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
				'p'    => 'p',
				'div'  => 'div'
			),
			'std' => 'h4',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Subtitle/Label Color', 'goya-core' ),
			'param_name' => 'subtitle_color',
			'value' => array(
				__( 'Default', 'goya-core' ) => '',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Accent Color', 'goya-core' ) => 'accent',
				__( 'Custom', 'goya-core' ) => 'custom'
			),
			'std' => '',
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Subtitle/Label Color', 'goya-core' ),
			'param_name' => 'subtitle_color_custom',
			'dependency' => array(
				'element' => 'subtitle_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Subtitle/Label Background', 'goya-core' ),
			'description' => __( 'Used for Label style', 'goya-core' ),
			'param_name' => 'subtitle_background_custom',
			'dependency' => array(
				'element' => 'subtitle_color',
				'value' => array( 'custom' )
			),
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'textarea',
			'heading' => __( 'Extra Content', 'goya-core' ),
			'param_name' => 'paragraph',
			'description' => __( 'For tablet/desktop screens only.', 'goya-core' ),
			'group' => __( 'Content','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Animation (Banner Slider)', 'goya-core' ),
			'param_name' => 'text_animation',
			'description' => __( 'Select a text animation (used by the Banner Slider).', 'goya-core' ),
			'value' => array(
				__( 'None', 'goya-core' ) => '',
				'fadeIn' => 'fadeIn',
				'fadeInDown' => 'et-fadeInDown',
				'fadeInLeft' => 'et-fadeInLeft',
				'fadeInRight' => 'et-fadeInRight',
				'fadeInUp' => 'et-fadeInUp' 
			),
			'group' => __( 'Text Layout','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Position', 'goya-core' ),
			'param_name' => 'text_position',
			'value' => array(
				__( 'Center', 'goya-core' ) => 'h_center-v_center',
				__( 'Top Left', 'goya-core' ) => 'h_left-v_top',
				__( 'Top Center', 'goya-core' ) => 'h_center-v_top',
				__( 'Top Right', 'goya-core' ) => 'h_right-v_top',
				__( 'Center Left', 'goya-core' ) => 'h_left-v_center',
				__( 'Center Right', 'goya-core' ) => 'h_right-v_center',
				__( 'Bottom Left', 'goya-core' ) => 'h_left-v_bottom',
				__( 'Bottom Center', 'goya-core' ) => 'h_center-v_bottom',
				__( 'Bottom Right', 'goya-core' ) => 'h_right-v_bottom'
			),
			'std' => 'h_center-v_center',
			'group' => __( 'Text Layout','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Text Alignment', 'goya-core' ),
			'param_name' => 'text_alignment',
			'value' => array(
				__( 'Left', 'goya-core' ) => 'align_left',
				__( 'Center', 'goya-core' ) => 'align_center',
				__( 'Right', 'goya-core' ) => 'align_right'
			),
			'std' => 'align_left',
			'group' => __( 'Text Layout','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Text Width', 'goya-core' ),
			'param_name' => 'text_width',
			'description' => __( 'Default is 50%', 'goya-core' ),
			'group' => __( 'Text Layout','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Text Padding', 'goya-core' ),
			'param_name' => 'text_padding',
			'description' => __( 'Default is 15% (relative to "Text Width" value above)', 'goya-core' ),
			'group' => __( 'Text Layout','goya-core' ),
		),
	 )
) );
