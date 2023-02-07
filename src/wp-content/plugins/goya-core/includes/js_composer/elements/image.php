<?php // Image shortcode
vc_map( array(
	'name' => 'Image',
	'description' => esc_html__('Add an animated image', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_image',
	'icon' => 'et_image',
	'params' => array(
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Select Image', 'goya-core'),
			'param_name' => 'image'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Display Caption?', 'goya-core'),
			'param_name' => 'caption',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('If selected, the image caption will be displayed.', 'goya-core'),
			'group' => __( 'Text','goya-core' ),
		),
		array(
			'type'           => 'textarea_html',
			'heading'        => esc_html__( 'Text Below Image', 'goya-core' ),
			'param_name'     => 'content',
			'group' => __( 'Text','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Full Width?', 'goya-core'),
			'param_name' => 'full_width',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('If selected, the image will always fill its container', 'goya-core')
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
      'group' => __( 'Styling','goya-core' ),
    ),
		array(
		  'type' => 'textfield',
		  'heading' => esc_html__('Image size', 'goya-core'),
		  'param_name' => 'img_size',
		  'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Leave empty to use "full" size.', 'goya-core')
		),
		array(
		  'type' => 'dropdown',
		  'heading' => esc_html__('Image alignment', 'goya-core'),
		  'param_name' => 'alignment',
		  'value' => array(
		  	__( 'Align left', 'goya-core' ) => 'alignleft',
		  	__( 'Align right', 'goya-core' ) => 'alignright',
		  	__( 'Align center', 'goya-core' ) => 'aligncenter'
		  ),
		  'description' => esc_html__('Select image alignment.', 'goya-core')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Link to Full-Width Image?', 'goya-core'),
			'param_name' => 'lightbox',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			)
		),
		array(
		  'type' => 'vc_link',
		  'heading' => esc_html__('Image link', 'goya-core'),
		  'param_name' => 'img_link',
		  'description' => esc_html__('Enter url if you want this image to have link.', 'goya-core'),
		  'dependency' => array(
		  	'element' => 'lightbox',
		  	'is_empty' => true
		  )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core'),
			'param_name' => 'extra_class',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Border Radius', 'goya-core'),
			'param_name' => 'border_radius',
			'group' => __( 'Styling','goya-core' ),
			'description' => esc_html__('You can add your own border-radius code here. For ex: 2px 2px 4px 4px', 'goya-core')
		),
		array(
			'type' 						=> 'dropdown',
			'heading' 				=> esc_html__('Box Shadow', 'goya-core'),
			'param_name' 			=> 'box_shadow',
			'value' 						=> array(
				__( 'No Shadow', 'goya-core' ) => '',
				__( 'Small', 'goya-core' ) => 'small-shadow',
				__( 'Medium', 'goya-core' ) => 'medium-shadow',
				__( 'Large', 'goya-core' ) => 'large-shadow',
				__( 'X-Large', 'goya-core' ) => 'xlarge-shadow',
			),
			'dependency' => array(
				'element' => 'style',
				'value' => array('lightbox-style2')
			),
			'group' => __( 'Styling','goya-core' ),
		),
		array(
			'type' 						=> 'dropdown',
			'heading' 				=> esc_html__('Image Max Width', 'goya-core'),
			'param_name' 			=> 'max_width',
			'value' 						=> array(
				'100%' => 'size_100',
				'125%' => 'size_125',
				'150%' => 'size_150',
				'175%' => 'size_175',
				'200%' => 'size_200',
				'225%' => 'size_225',
				'250%' => 'size_250',
				'275%' => 'size_275',
			),
			'std' => 'size_100',
			'group' => __( 'Styling','goya-core' ),
			'description' => esc_html__('By default, image is contained within the columns, by setting this, you can extend the image over the container', 'goya-core')
		),
	),
	
) );
