<?php

// VC element: et_product
vc_map( array(
	'name' => esc_html__('Product Masonry', 'goya-core'),
	'description' => esc_html__('Add WooCommerce products', 'goya-core'),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_product_masonry',
	'icon' => 'et_product_masonry',
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
			'description' => esc_html__('Enter the products IDs you would like to display separated by comma', 'goya-core'),
			'dependency' => array(
				'element' => 'product_sort',
				'value' => array('by-id')
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
					'sale-products',
					'top-rated',
					'latest-products',
					'best-sellers',
					'featured-products'
				)
			)
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
	    'type' => 'dropdown',
	    'heading' => esc_html__('Product Style', 'goya-core' ),
	    'param_name' => 'item_style',
	    'group' => __( 'Styling','goya-core' ),
	    'std'=> 'style4',
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
      'heading' => esc_html__('Margins between items', 'goya-core' ),
      'param_name' => 'item_margins',
      'group' => __( 'Styling','goya-core' ),
      'std'=> 'regular-padding',
      'value' => array(
      	__( 'Regular', 'goya-core' ) => 'regular-padding',
      	__( 'No Margins', 'goya-core' ) => 'no-padding'
      ),
      'description' => esc_html__('Adjust the space between items', 'goya-core' )
	  ),
		array(
      'type' => 'checkbox',
      'heading' => esc_html__('Category navigation', 'goya-core' ),
      'param_name' => 'category_navigation',
      'value' => array(
    		__( 'Yes', 'goya-core' ) => 'true'
    	),
      'description' => esc_html__('Show category navigation filter on top', 'goya-core' ),
      'dependency' => array(
      	'element' => 'product_sort', 
      	'value' => array('by-category')
      )
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