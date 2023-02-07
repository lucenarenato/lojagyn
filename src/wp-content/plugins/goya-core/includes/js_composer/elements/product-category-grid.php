<?php

// VC element: et_product_category_grid
vc_map( array(
	'name' => esc_html__('Product Category Masonry', 'goya-core'),
	'description' => esc_html__('Display Product Categories in Masonry layout', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_product_category_grid',
	'icon' => 'et_product_category_grid',
	'params'	=> array(
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Product Category', 'goya-core'),
			'param_name' => 'cat',
			'value' => goya_product_categories_array(),
			'description' => esc_html__('Select the categories you would like to display', 'goya-core')
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Order by', 'goya-core'),
			'param_name' => 'order_by',
			'value' => array(
				__( 'Name', 'goya-core' ) => 'name',
				__( 'Id', 'goya-core' ) => 'id',
				__( 'Slug', 'goya-core' ) => 'slug',
				__( 'Menu Order', 'goya-core' ) => 'menu_order'
			),
			'std' => 'name'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Sort Order', 'goya-core'),
			'param_name' => 'sort_order',
			'value' => array(
				__( 'Ascending', 'goya-core' ) => 'ASC',
				__( 'Descending', 'goya-core' ) => 'DESC',
			),
			'std' => 'ASC'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Style', 'goya-core'),
			'param_name' => 'style',
			'admin_label' => true,
			'value' => array(
				__( 'Style 1', 'goya-core' ) => 'style1',
				__( 'Style 2', 'goya-core' ) => 'style2',
				__( 'Style 3', 'goya-core' ) => 'style3'
			),
			'description' => esc_html__('This applies different grid structures', 'goya-core')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Rounded Corners', 'goya-core'),
			'param_name' => 'rounded_corners',
		  'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
		),
	),
	
) );