<?php 

// VC element: et_hovercard

vc_map( array(
	'name' => esc_html__('Hover Card', 'goya-core' ),
	'base' => 'et_hovercard',
	'icon' => 'et_hovercard',
	'category' => esc_html__('Goya', 'goya-core' ),
	'params' => array(
		 array(
			'type'           => 'vc_link',
			'heading'        => esc_html__( 'Box link', 'goya-core' ),
			'param_name'     => 'link',
			'description'    => esc_html__( 'Add a URL (optional)', 'goya-core' ),
		),
		array(
		  'type' => 'textfield',
		  'heading' => esc_html__('Min Height', 'goya-core' ),
		  'param_name' => 'min_height',
		  'description' => esc_html__('Please enter the minimum height you would like for you box. Enter in number of pixels - Don\'t enter \'px\', default is \'300\'', 'goya-core' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core' ),
			'param_name' => 'extra_class',
		),
    array(
			'type'  => 'textfield',
			'heading' => esc_html__('Title', 'goya-core' ),
			'param_name' => 'normal_title',
			'group' => esc_html__('Normal', 'goya-core' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Title Color', 'goya-core' ),
			'param_name' => 'normal_title_color',
			'group' => esc_html__('Normal', 'goya-core' )
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Background Image', 'goya-core' ),
			'param_name' => 'normal_bg_image',
			'group' => esc_html__('Normal', 'goya-core' )
		),
		array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Background Color', 'goya-core' ),
      'param_name'     => 'normal_bg_color',
      'group' => esc_html__('Normal', 'goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
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
      'std'       => ''
    ),
    array(
      'type'      => 'dropdown',
      'heading'     => __('Icon', 'goya-core' ),
      'param_name'  => 'icon_type',
      'description' => __( 'Select icon type.', 'goya-core' ),
      'value'     => array(
      	__( 'No Icon', 'goya-core' )  => 'no_icon',
        __( 'Font Icon', 'goya-core' ) => 'icon',
        __( 'Image', 'goya-core' )   => 'image_id'
      ),
      'std'       => 'no_icon',
      'group' => esc_html__('Hover', 'goya-core' )
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
      'dependency'  => array(
        'element' => 'icon_type',
        'value'   => 'icon'
      ),
      'group' => esc_html__('Hover', 'goya-core' )
    ),
    array(
      'type'      => 'iconpicker',
      'heading'     => __( 'Icon', 'goya-core' ),
      'param_name'  => 'icon_pixeden',
      'description'   => __( 'Select icon from library.', 'goya-core' ),
      'value'     => 'pe-7s-close',
      'settings'    => array(
        'type'      => 'pixeden',
        'emptyIcon'   => false,
        'iconsPerPage'  => 3000
      ),
      'dependency'  => array(
        'element' => 'icon_library',
        'value'   => 'pixeden'
      ),
      'group' => esc_html__('Hover', 'goya-core' )
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
      'group' => esc_html__('Hover', 'goya-core' )
    ),
    array(
      'type'      => 'attach_image',
      'heading'     => __( 'Image', 'goya-core' ),
      'param_name'  => 'image_id',
      'description' => __( 'Select image from the media library.', 'goya-core' ),
      'dependency'  => array(
        'element' => 'icon_type',
        'value'   => array( 'image_id' )
      ),
      'group' => esc_html__('Hover', 'goya-core' )
    ),
		array(
			'type'  => 'textfield',
			'heading' => esc_html__('Title', 'goya-core' ),
			'param_name' => 'hover_title',
			'group' => esc_html__('Hover', 'goya-core' )
		),
		array(
			'type' => 'textarea_safe',
			'heading' => esc_html__('Content', 'goya-core' ),
			'param_name' => 'hover_content',
			'group' => esc_html__('Hover', 'goya-core' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Icon Color', 'goya-core' ),
			'param_name' => 'hover_icon_color',
			 'dependency'  => array(
        'element' => 'icon_type',
        'value'   => 'icon'
      ),
			'group' => esc_html__('Hover', 'goya-core' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Title Color', 'goya-core' ),
			'param_name' => 'hover_title_color',
			'group' => esc_html__('Hover', 'goya-core' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Content Color', 'goya-core' ),
			'param_name' => 'hover_content_color',
			'group' => esc_html__('Hover', 'goya-core' )
		),
		array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Background Color', 'goya-core' ),
      'param_name'     => 'hover_bg_color',
      'group' => esc_html__('Hover', 'goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
	),
	'description' => esc_html__('Add a Hover Card', 'goya-core' )
) );