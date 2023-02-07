<?php

// VC element: et_lightbox
vc_map( array(
 'name' => esc_html__( 'Lightbox', 'goya-core' ),
 'description' => esc_html__( 'Lightbox modal with custom content', 'goya-core' ),
 'category' => esc_html__('Goya', 'goya-core'),
 'base' => 'et_lightbox',
 'icon' => 'et_lightbox',
 'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __('Link Type', 'goya-core' ),
			'param_name' => 'link_type',
			'description' => __( 'Select lightbox link type.', 'goya-core' ),
			'value' => array(
				__( 'Link', 'goya-core' ) => 'link',
				__( 'Button', 'goya-core' ) => 'btn',
				__( 'Image', 'goya-core' ) => 'image'
			),
			'std' => 'link'
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'goya-core' ),
			'param_name' => 'title',
			'description' => __( 'Enter a lightbox link/button title.', 'goya-core' )
		),
		// Dependency: link_type - btn
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Style', 'goya-core' ),
			'param_name' => 'button_style',
			'description' => __( 'Select button style.', 'goya-core' ),
			'value' => array(
				__( 'Solid', 'goya-core' ) => 'solid',
				__( 'Solid Rounded', 'goya-core' ) => 'solid rounded',
				__( 'Outlined', 'goya-core' ) => 'outlined',
				__( 'Outlined Rounded', 'goya-core' ) => 'outlined rounded',
				__( 'Link', 'goya-core' ) => 'link'
			),
			'std' => 'solid',
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'btn' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Align', 'goya-core' ),
			'param_name' => 'button_align',
			'value' => array(
				__( 'Left', 'goya-core' ) => 'left',
				__( 'Center', 'goya-core' ) => 'center',
				__( 'Right', 'goya-core' ) => 'right'
			),
			'std' => 'center',
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'btn' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Button Size', 'goya-core' ),
			'param_name' => 'button_size',
			'description' => __( 'Select button size.', 'goya-core' ),
			'value' => array(
				__( 'Mini', 'goya-core' ) => 'xs',
				__( 'Small', 'goya-core' ) => 'sm',
				__( 'Normal', 'goya-core' ) => 'md',
				__( 'Large', 'goya-core' ) => 'lg'
			),
			'std' => 'lg',
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'btn' )
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Button Color', 'goya-core' ),
			'param_name' => 'button_color',
			'description' => __( 'Select button color.', 'goya-core' ),
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'btn' )
			)
		),

		// Dependency: link_type - image
		array(
			'type' => 'attach_image',
			'heading' => __( 'Link Image', 'goya-core' ),
			'param_name' => 'link_image_id',
			'description' => __( 'Select image from the media library.', 'goya-core' ),
			'dependency' => array(
				'element' => 'link_type',
				'value' => array( 'image' )
			),
			'group' => __( 'Source','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __('Lightbox Type', 'goya-core' ),
			'param_name' => 'content_type',
			'description' => __( 'Select content type.', 'goya-core' ),
			'value' => array(
				__( 'Image', 'goya-core' ) => 'image',
				__( 'Video', 'goya-core' ) => 'iframe',
				__( 'HTML', 'goya-core' ) => 'inline'
			),
			'std' => 'image',
			'group' => __( 'Source','goya-core' ),
		),
		// Dependency: content_type - image
		array(
			'type' => 'attach_image',
			'heading' => __( 'Lightbox Image', 'goya-core' ),
			'param_name' => 'content_image_id',
			'description' => __( 'Select image from the media library.', 'goya-core' ),
			'dependency' => array(
				'element' => 'content_type',
				'value' => array( 'image' )
			),
			'group' => __( 'Source','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Lightbox Image Caption', 'goya-core' ),
			'param_name' => 'content_image_caption',
			'description' => __( 'Display image caption.', 'goya-core' ),
			'value' => array(
				__( 'Enable', 'goya-core' ) => '1'
			),
			'dependency' => array(
				'element' => 'content_type',
				'value' => array( 'image' )
			),
			'group' => __( 'Source','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Video URL', 'goya-core' ),
			'param_name' => 'content_url',
			'description' => __( 'Insert a Video URL. <strong>YouTube video:</strong> http://www.youtube.com/watch?v=xxxx', 'goya-core' ),
			'dependency' => array(
				'element' => 'content_type',
				'value' => array( 'iframe' )
			),
			'group' => __( 'Source','goya-core' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Source ID', 'goya-core' ),
			'param_name' => 'content_selector',
			'description' => __( 'If the content is in another element of this page use the ID of that element(# included):<strong>#lightbox-id</strong><br>Or use the editor below to add the content.', 'goya-core' ),
			'dependency' => array(
				'element' => 'content_type',
				'value' => array( 'inline' )
			),
			'group' => __( 'Source','goya-core' ),
		),
		array(
		  'type' => 'textarea_html',
		  'heading' => __( 'Custom Content', 'goya-core' ),
		  'param_name' => 'content',
		  'description' => __( 'Add the custom content for the ligthbox', 'goya-core' ),
		  'dependency' => array(
		  	'element' => 'content_type',
		  	'value' => array( 'inline' )
		  ),
		  'group' => __( 'Source','goya-core' ),
		),
	)
) );