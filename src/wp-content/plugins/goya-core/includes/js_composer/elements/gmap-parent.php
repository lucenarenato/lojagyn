<?php

// VC element: et_gmap_parent
vc_map( array(
	'name' => __('Google Map', 'goya-core'),
	'description'	=> esc_html__( 'Add a Google map with markers', 'goya-core' ),
	'category' => __('Goya', 'goya-core'),
	'base' => 'et_gmap_parent',
	'icon' => 'et_gmap_parent',
	'as_parent' => array('only' => 'et_gmap'),
	'controls' => 'full',
	'content_element' => true,
	'show_settings_on_create' => false,
	'js_view' => 'VcColumnView',
	'params' => array(
		array(
		  'type' => 'textfield',
		  'heading' => __('Map Height', 'goya-core'),
		  'param_name' => 'height',
		  'admin_label' => true,
		  'value' => 50,
		  'description' => __('Height of the map in vh (0-100). For example, 50 will be 50% of viewport height and 100 will be full height. <small>Add your Google Maps API in Appearance > Customize > General Settings.</small>', 'goya-core')
		),
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Map Zoom', 'goya-core' ),
			'param_name'     => 'zoom',
			'value'			 		 => '0',
			'description'    => __( 'Set map zoom level. Leave 0 to automatically fit to bounds.', 'goya-core' )
		),
		array(
			'type'           => 'checkbox',
			'heading'        => __( 'Map Controls', 'goya-core' ),
			'param_name'     => 'map_controls',
			'std'            => 'panControl, zoomControl, mapTypeControl, scaleControl',
			'value'          => array(
				__('Pan Control', 'goya-core')             => 'panControl',
				__('Zoom Control', 'goya-core')            => 'zoomControl',
				__('Map Type Control', 'goya-core')        => 'mapTypeControl',
				__('Scale Control', 'goya-core')           => 'scaleControl',
				__('Street View Control', 'goya-core')     => 'streetViewControl'
			),
			'description'    => __( 'Toggle map options.', 'goya-core' )
		),

		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Map Type', 'goya-core' ),
			'param_name'     => 'map_type',
			'std'            => 'roadmap_custom',
			'value'          => array(
				__('Custom Roadmap', 'goya-core')   => 'roadmap_custom',
				__('Default Roadmap (no custom styles)', 'goya-core')   => 'roadmap',
				__('Satellite', 'goya-core') => 'satellite',
				__('Hybrid', 'goya-core')    => 'hybrid',
			),
			'description' => __( 'Choose map style.', 'goya-core' ),
			'group' => __( 'Map Styling','goya-core' ),
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Map Style', 'goya-core' ),
			'param_name' => 'map_style',
			'description' => __( 'Select a custom map style.', 'goya-core' ),
			'value' => array(
				__( 'Paper', 'goya-core' ) => 'paper',
				__( 'Light', 'goya-core' ) => 'light',
				__( 'Dark', 'goya-core' ) => 'dark',
				__( 'Grayscale', 'goya-core' ) => 'grayscale',
				__( 'Countries', 'goya-core' ) => 'countries'
			),
			'std' => 'paper',
			'dependency'	=> array(
				'element'	=> 'map_type',
				'value'		=> 'roadmap_custom'
			),
			'group' => __( 'Map Styling','goya-core' ),
		),

		array(
			'type' => 'textarea_raw_html',
			'heading' => __( 'Use Your Own Map Style', 'goya-core' ),
			'param_name' => 'custom_map_style',
			'description'    => sprintf(__( 'Paste your own style code here. Browse map styles or create your own in %s SnazzyMaps %s.', 'goya-core' ),'<a href="https://snazzymaps.com/" target="_blank">','</a>', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'map_type',
				'value'		=> 'roadmap_custom'
			),
			'group' => __( 'Map Styling','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Locations List', 'goya-core' ),
			'param_name' => 'locations_list',
			'description' => __( 'Show a list with locations.', 'goya-core' ),
			'value' => array(
				__( 'Enable', 'goya-core' ) => '1'
			),
			'group' => __( 'Locations List','goya-core' ),
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Locations list style', 'goya-core' ),
			'param_name'     => 'locations_layout',
			'std'            => 'horizontal',
			'value'          => array(
				__('Horizontal', 'goya-core')   => 'horizontal',
				__('Vertical', 'goya-core') => 'vertical',
			),
			'description' => __( 'Choose locations list layout.', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'locations_list',
				'value'		=> '1'
			),
			'group' => __( 'Locations List','goya-core' ),
		),
		array(
			'type'           => 'dropdown',
			'heading'        => __( 'Locations rows/columns style', 'goya-core' ),
			'param_name'     => 'locations_columns',
			'std'            => '4',
			'value'          => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'description' => __( 'Number of columns(horizontal) or rows(vertical).', 'goya-core' ),
			'dependency'	=> array(
				'element'	=> 'locations_list',
				'value'		=> '1'
			),
			'group' => __( 'Locations List','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Autoselect first location', 'goya-core' ),
			'param_name' => 'autoselect_first',
			'description' => __( 'Center the first location on load. Otherwise, it will load in the middle of all locations.', 'goya-core' ),
			'std'            => '1',
			'value' => array(
				__( 'Enable', 'goya-core' ) => '1'
			),
			'group' => __( 'Locations List','goya-core' ),
		),

	),
) );

// Extend element with the WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_ET_Gmap_Parent extends WPBakeryShortCodesContainer { }
}