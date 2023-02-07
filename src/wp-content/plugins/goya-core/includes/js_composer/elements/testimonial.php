<?php

// VC element: et_testimonial
vc_map( array(
	'name' => esc_html__('Testimonial', 'goya-core'),
	'description' => esc_html__('Single Testimonial', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_testimonial',
	'icon' => 'et_testimonial',
	
	//'as_child' => array('only' => 'et_testimonial_slider'),
	'params'	=> array(
		array(
			'type'           => 'textarea',
			'heading'        => esc_html__( 'Quote', 'goya-core' ),
			'param_name'     => 'quote',
			'description'    => esc_html__( 'Quote you want to show', 'goya-core' ),
		),
		array(
		'type'           => 'textfield',
			'heading'        => esc_html__( 'Author', 'goya-core' ),
			'param_name'     => 'author_name',
			'admin_label'	 => true,
			'description'    => esc_html__( 'Name of the member.', 'goya-core' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => esc_html__( 'Author Title', 'goya-core' ),
			'param_name'     => 'author_title',
			'description'    => esc_html__( 'Title that will appear below author name.', 'goya-core' ),
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Show stars', 'goya-core' ),
			'param_name' 	=> 'show_stars',
			'description'	=> __( 'Display rating stars. WooCommerce must be active', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> '1'
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Number of stars', 'goya-core' ),
			'param_name' => 'stars',
			'value' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'std' => '5',
			'dependency' => array(
				'element' => 'show_stars',
				'value' => array( '1' )
			)
		),
		array(
			'type'           => 'attach_image',
			'heading'        => esc_html__( 'Author Image', 'goya-core' ),
			'param_name'     => 'author_image',
			'description'    => esc_html__( 'Add Author image here. Could be used depending on style.', 'goya-core' )
		)
	),
	
) );