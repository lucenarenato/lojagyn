<?php

// VC element: et_gmap
vc_map( array(
	'name' => esc_html__('Map Marker', 'goya-core'),
	'description' => esc_html__('Add location markers to map', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_gmap',
	'icon' => 'et_gmap',
	'as_child' => array('only' => 'et_gmap_parent'),
	'params' => array(
	array(
		'type'           => 'attach_image',
		'heading'        => esc_html__( 'Marker Image', 'goya-core' ),
		'param_name'     => 'marker_image',
		'description'    => esc_html__( 'Add your Custom marker image or use default one.', 'goya-core' )
	),
	array(
		'type'           => 'checkbox',
		'heading'        => esc_html__( 'Retina Marker', 'goya-core' ),
		'param_name'     => 'retina_marker',
		'value'          => array(
			esc_html__('Yes', 'goya-core') => 'yes',
		),
		'description'    => esc_html__( 'Enabling this option will reduce the size of marker for 50%, example if marker is 32x32 it will be 16x16.', 'goya-core' )
	),
	array(
		'type'           => 'textfield',
		'heading'        => esc_html__( 'Latitude', 'goya-core' ),
		'param_name'     => 'latitude',
		'description'    => esc_html__( 'Enter latitude coordinate. To select map coordinates, use http://www.latlong.net/convert-address-to-lat-long.html', 'goya-core' ),
	),
	array(
		'type'           => 'textfield',
		'heading'        => esc_html__( 'Longitude', 'goya-core' ),
		'param_name'     => 'longitude',
		'description'    => esc_html__( 'Enter longitude coordinate.', 'goya-core' ),
	),
	array(
		'type'           => 'textfield',
		'heading'        => esc_html__( 'Marker Title', 'goya-core' ),
		'admin_label'    => true,
		'param_name'     => 'marker_title'
	),
	array(
		'type'           => 'textarea',
		'heading'        => esc_html__( 'Marker Description', 'goya-core' ),
		'param_name'     => 'marker_description'
	)
	),
	
));
