<?php

// VC element: et_team_member
vc_map( array(
	'name' => esc_html__('Team Member', 'goya-core'),
	'description' => esc_html__('Display your team members in a stylish way', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_team_member',
	'icon' => 'et_team',
	'params' => array(
		array(
			'type' => 'attach_image', //attach_images
			'heading' => esc_html__('Select Team Member Image', 'goya-core'),
			'param_name' => 'image',
			'description' => esc_html__('Minimum size is 270x270 pixels', 'goya-core')
		),
		array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Image Style', 'goya-core' ),
			'param_name' 	=> 'style',
			'description'	=> __( 'Select image style.', 'goya-core' ),
			'value' 		=> array(
				__( 'Default', 'goya-core' )  => 'default',
				__( 'Rounded', 'goya-core' ) => 'rounded'
			),
			'std' 			=> 'default'
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
			'type' => 'textfield',
			'heading' => esc_html__('Name', 'goya-core'),
			'param_name' => 'name',
			'admin_label' => true,
			'description' => esc_html__('Enter name of the team member', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Position', 'goya-core'),
			'param_name' => 'position',
			'description' => esc_html__('Enter position/title of the team member', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Facebook', 'goya-core'),
			'param_name' => 'facebook',
			'description' => esc_html__('Enter Facebook Link', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Twitter', 'goya-core'),
			'param_name' => 'twitter',
			'description' => esc_html__('Enter Twitter Link', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Pinterest', 'goya-core'),
			'param_name' => 'pinterest',
			'description' => esc_html__('Enter Pinterest Link', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Linkedin', 'goya-core'),
			'param_name' => 'linkedin',
			'description' => esc_html__('Enter Linkedin Link', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Instagram', 'goya-core'),
			'param_name' => 'instagram',
			'description' => esc_html__('Enter Instagram Link', 'goya-core')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('VK', 'goya-core'),
			'param_name' => 'vk',
			'description' => esc_html__('Enter VK Link', 'goya-core')
		),
	),
	
) );