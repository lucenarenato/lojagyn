<?php

// VC element: et_product
vc_map( array(
	'name' => esc_html__('Products Grid/Carousel', 'goya-core'),
	'description' => esc_html__('Add WooCommerce products', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_product_slider',
	'icon' => 'et_product_slider',
	'admin_label' => true,
	'params'	=> array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Products', 'goya-core'),
			'param_name' => 'product_sort',
			'value' => array(
				__( 'Latest Products', 'goya-core' ) => 'latest-products',
				__( 'Best Sellers', 'goya-core' ) => 'best-sellers',
				__( 'Top Rated', 'goya-core' ) => 'top-rated',
				__( 'Featured Products', 'goya-core' ) => 'featured-products',
				__( 'Sale Products', 'goya-core' ) => 'sale-products',
				__( 'By Category', 'goya-core' ) => 'by-category',
				__( 'By Tag', 'goya-core' ) => 'by-tag',
				__( 'By Product ID', 'goya-core' ) => 'by-id',
				),
			'admin_label' => true,
			'description' => esc_html__('Select the batch of products to show.', 'goya-core')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Product Category', 'goya-core'),
			'param_name' => 'cat',
			'value' => goya_product_categories_array(),
			'description' => esc_html__('Choose categories to show.', 'goya-core'),
			'dependency' => array(
				'element' => 'product_sort', 
				'value' => array('by-category')
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Product IDs', 'goya-core'),
			'param_name' => 'product_ids',
			'description' => esc_html__('Enter the product IDs separated by comma', 'goya-core'),
			'dependency' => array(
				'element' => 'product_sort',
				'value' => array('by-id')
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Product Tags', 'goya-core'),
			'param_name' => 'product_tag',
			'description' => esc_html__('Enter the product tags separated by comma', 'goya-core'),
			'dependency' => array(
				'element' => 'product_sort',
				'value' => array('by-tag')
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'js_composer' ),
			'param_name' => 'orderby',
			'description' => sprintf( __( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			'value' 		=> array(
				__( 'Date', 'js_composer' ) => 'date',
				__( 'ID', 'js_composer' ) => 'ID',
				__( 'Author', 'js_composer' ) => 'author',
				__( 'Title', 'js_composer' ) => 'title',
				__( 'Modified', 'js_composer' ) => 'modified',
				__( 'Random', 'js_composer' ) => 'rand',
				__( 'Comment count', 'js_composer' ) => 'comment_count',
				__( 'Menu order', 'js_composer' ) => 'menu_order'
			),
			'std' => 'date',
			'save_always' 	=> true,
			'dependency' => array(
				'element' => 'product_sort', 
				'value' => array(
					'by-category',
					'by-tag',
					'sale-products',
					'featured-products'
				)
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Sort order', 'js_composer' ),
			'param_name' => 'order',
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
			'value' 		=> array(
				__( 'Descending', 'js_composer' )	=> 'DESC',
				__( 'Ascending', 'js_composer' )	=> 'ASC'
			),
			'std' => 'DESC',
			'save_always' 	=> true,
			'dependency' => array(
				'element' => 'product_sort', 
				'value' => array(
					'by-category',
					'by-tag',
					'sale-products',
					'featured-products'
				)
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Per page', 'goya-core'),
			'param_name' => 'item_count',
			'value' => '4',
			'description' => esc_html__('The number of products to show.', 'goya-core'),
			'dependency' => array(
				'element' => 'product_sort', 
				'value' => array(
					'by-category',
					'by-tag',
					'sale-products',
					'top-rated',
					'latest-products',
					'best-sellers',
					'featured-products'
				)
			)
		),
		array(
	    'type' => 'dropdown',
	    'heading' => esc_html__('Product Style', 'goya-core' ),
	    'param_name' => 'item_style',
	    'group' => __( 'Styling','goya-core' ),
	    'std'=> 'style1', 
	    'value' => array(
	    	__( 'Style 1', 'goya-core' ) => 'style1',
	    	__( 'Style 2', 'goya-core' ) => 'style2',
	    	__( 'Style 3', 'goya-core' ) => 'style3',
	    	__( 'Style 4', 'goya-core' ) => 'style4'
	    ),
	    'description' => esc_html__('Select Items Style', 'goya-core' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns', 'goya-core'),
			'param_name' => 'columns',
			'value' => array(
				__( '5 Columns', 'goya-core' ) => '5',
				__( '4 Columns', 'goya-core' ) => '4',
				__( '3 Columns', 'goya-core' ) => '3',
				__( '2 Columns', 'goya-core' ) => '2',
				__( '1 Columns', 'goya-core' ) => '1'
			),
			'description' => esc_html__('Select the layout of the products.', 'goya-core'),
			'std' 			=> '4'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Carousel', 'goya-core'),
			'param_name' => 'carousel',
			'admin_label' => true,
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'yes',
				__( 'No', 'goya-core' ) => 'no'
			),
			'description' => esc_html__('Select yes to display the products in a carousel.', 'goya-core'),
			'std' 			=> 'yes',
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Columns to scroll', 'goya-core'),
			'param_name' => 'scroll',
			'value' => array(
				__( 'Same as columns', 'goya-core' ) => 'columns',
				'1' => '1'
			),
			'description' => esc_html__('Number of columns to scroll.', 'goya-core'),
			'std' 			=> 'columns',
			'dependency'	=> array(
				'element'	=> 'carousel',
				'value'   => array( 'yes' ),
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Infinite Loop', 'goya-core' ),
			'param_name' 	=> 'infinite',
			'description'	=> __( 'Infinite loop sliding.', 'goya-core' ),
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> 'true'
			),
			'dependency' => array(
				'element' => 'carousel',
				'value' => 'yes'
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' 			=> 'checkbox',
			'heading' 		=> __( 'Autoplay', 'goya-core' ),
			'param_name' 	=> 'autoplay',
			'value'			=> array(
				__( 'Enable', 'goya-core' )	=> '1'
			),
			'dependency' => array(
				'element' => 'carousel',
				'value' => 'yes'
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type'      => 'textfield',
			'heading'     => __( 'Autoplay Speed', 'goya-core' ),
			'param_name'  => 'autoplay_speed',
			'description' => __( 'Enter autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'goya-core' ),
			'std' 			=> '2500',
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( '1' )
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Pause on hover', 'goya-core'),
			'param_name' => 'pause',
			'description' => esc_html__('Pause autoplay on hover.', 'goya-core'),
			'value' => array(
				__( 'Enable', 'goya-core' )	=> '1'
			),
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( '1' )
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' 		=> __( 'Navigation Dots', 'goya-core' ),
			'param_name' => 'pagination',
			'description'	=> __( 'Display pagination dots.', 'goya-core' ),
			'value' => array(
				__( 'Enable', 'goya-core' ) => 'true'
			),
			'dependency'	=> array(
				'element'	=> 'carousel',
				'value'   => array( 'yes' ),
			),
			'group' => __( 'Carousel','goya-core' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __('Hide Out of Stock', 'goya-core'),
			'param_name' => 'hide_out_of_stock',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'yes'
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Show Variations', 'goya-core'),
			'param_name' => 'show_variations',
			'value' => array(
				__( 'Yes', 'goya-core' ) => 'true'
			),
			'description' => esc_html__('Show variations (requires "WooCommerce Variation Swatches" plugin) .', 'goya-core'),
		),
	),
	
) );