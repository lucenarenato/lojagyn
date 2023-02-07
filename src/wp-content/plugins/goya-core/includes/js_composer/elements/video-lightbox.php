<?php 

// VC element: et_video_lightbox

vc_map( array(
	'name' => esc_html__('Video Lightbox', 'goya-core'),
	'description' => esc_html__('With icon or image link', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_video_lightbox',
	'icon' => 'et_video_lightbox',
	
	'params'	=> array(
	  array(
	  	'type' 					=> 'dropdown',
	  	'heading' 			=> esc_html__('Style', 'goya-core'),
	  	'param_name' 		=> 'style',
	  	'value'					=> array(
	  		__( 'Just Icon', 'goya-core' ) 	=> 'lightbox-icon',
	  		__( 'With Image', 'goya-core' ) 	=> 'lightbox-image',
	  		__( 'With Text', 'goya-core' ) 	=> 'lightbox-text',
	  	)
	  ),
	  array(
	  	'type'           => 'textfield',
	  	'heading'        => esc_html__( 'Video Link', 'goya-core' ),
	  	'param_name'     => 'video',
	  	'admin_label'	 	 => true,
	  	'description'    => esc_html__( 'URL of the video Youtube, Vimeo, etc.', 'goya-core' ),
	  ),
	  array(
	  	'type'           => 'textfield',
	  	'heading'        => esc_html__( 'Text for the link', 'goya-core' ),
	  	'param_name'     => 'video_text',
	  	'admin_label'	 	 => true,
	  	'description'    => esc_html__( 'Text you want to show next to the icon', 'goya-core' ),
	  	'dependency' 		 => array(
	  		'element' => 'style',
	  		'value' => array('lightbox-text')
	  	)
	  ),
	  array(
	  	'type' 					=> 'dropdown',
	  	'heading' 			=> esc_html__('Icon Style', 'goya-core'),
	  	'param_name' 		=> 'icon_style',
	  	'value'					=> array(
	  		__( 'Pulse', 'goya-core' ) 	=> 'pulse',
	  		__( 'Simple', 'goya-core' ) 	=> 'simple',
	  	),
	  	'std'						=> 'pulse',
	  	'group' => __( 'Styling','goya-core' ),
	  ),
	  array(
	  	'type' 					=> 'dropdown',
	  	'heading' 			=> esc_html__('Icon Size', 'goya-core'),
	  	'param_name' 		=> 'icon_size',
	  	'value'					=> array(
	  		__( 'Small', 'goya-core' ) 	=> 'small',
	  		__( 'Medium', 'goya-core' ) 	=> 'medium',
	  		__( 'Large', 'goya-core' ) 	=> 'large',
	  	),
	  	'std'						=> 'medium',
	  	'group' => __( 'Styling','goya-core' ),
	  ),
	  array(
	  	'type' => 'dropdown',
	  	'heading' => __( 'Icon Color', 'goya-core' ),
	  	'description' 	=> esc_html__( 'Color of the Play Icon', 'goya-core' ),
	  	'param_name' => 'icon_color',
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
	  	'type' 					=> 'colorpicker',
	  	'heading' 			=> esc_html__( 'Icon Custom Color', 'goya-core' ),
	  	'param_name' 		=> 'icon_color_custom',
	  	'dependency' 		 => array(
	  		'element' => 'icon_color',
	  		'value' => array('custom')
	  	),
	  	'group' => __( 'Styling','goya-core' ),
	  ),
	  array(
	  	'type'           => 'attach_image',
	  	'heading'        => esc_html__( 'Select Image', 'goya-core' ),
	  	'param_name'     => 'image',
	  	'description'    => esc_html__( 'Select image from media library.', 'goya-core' ),
	  	'dependency' 		 => array(
	  		'element' => 'style',
	  		'value' => array('lightbox-image')
	  	)
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
			'std' 			=> 'animation bottom-to-top'
		),
	  array(
	  	'type' 						=> 'dropdown',
	  	'heading' 				=> esc_html__('Image Hover Style', 'goya-core'),
	  	'param_name' 			=> 'hover_style',
	  	'value' 						=> array(
	  		__( 'No Animation', 'goya-core' )	=> '',
	  		__( 'Image Zoom', 'goya-core' )		=> 'hover-zoom',
	  	),
	  	'dependency' 			=> array(
	  		'element' => 'style',
	  		'value' => array('lightbox-image')
	  	),
	  	'group' => __( 'Styling','goya-core' ),
	  )
	),
	
) );
