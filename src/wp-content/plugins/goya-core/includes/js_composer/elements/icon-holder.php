<?php
	
// VC element: et_icon_holder
vc_map( array(
	'name' => __( 'Icon Holder', 'goya-core' ),
	'description' => __( 'Container for Icon Box elements', 'goya-core' ),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_icon_holder',
	'icon' => 'et_icon_holder',
	'as_parent' => array( 'only' => 'et_iconbox' ),
	'controls' => 'full',
	'content_element' => true,
	'show_settings_on_create' => false,
	'js_view' => 'VcColumnView',
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns Large', 'goya-core'),
			'description' => esc_html__('1200px and up', 'goya-core'),
			'param_name' => 'columns_large',
			'value' => array(
				__( '1 Column', 'goya-core' ) => '1',
				__( '2 Columns', 'goya-core' ) => '2',
				__( '3 Columns', 'goya-core' ) => '3',
				__( '4 Columns', 'goya-core' ) => '4',
				__( '5 Columns', 'goya-core' ) => '5'
			),
			'std' => '3',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns Medium', 'goya-core'),
			'description' => esc_html__('max-width: 1199px', 'goya-core'),
			'param_name' => 'columns_medium',
			'value' => array(
				__( '1 Column', 'goya-core' ) => '1',
				__( '2 Columns', 'goya-core' ) => '2',
				__( '3 Columns', 'goya-core' ) => '3',
				__( '4 Columns', 'goya-core' ) => '4',
				__( '5 Columns', 'goya-core' ) => '5'
			),
			'std' => '2',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns Mobile', 'goya-core'),
			'description' => esc_html__('max-width: 767px', 'goya-core'),
			'param_name' => 'columns_small',
			'value' => array(
				__( '1 Column', 'goya-core' ) => '1',
				__( '2 Columns', 'goya-core' ) => '2',
			),
			'std' => '1',
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Center Columns', 'goya-core'),
			'param_name' => 'center',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Extra Class Name', 'goya-core'),
			'param_name' => 'extra_class',
		),
	)
) );

// Extend element with the WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_ET_Icon_Holder extends WPBakeryShortCodesContainer {}
}