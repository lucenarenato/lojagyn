<?php
	
// VC element: et_posts
vc_map( array(
	 'name' => __( 'Blog Posts', 'goya-core' ),
	 'description' => __( 'Display posts from the blog Masonry,Grid../Slider', 'goya-core' ),
	 'base' => 'et_posts',
	 'icon' => 'et_posts',
	 'category' => __('Goya', 'goya-core'),
	 'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Posts', 'goya-core' ),
			'param_name' => 'num_posts',
			'description' => __( 'Enter max number of posts to display.', 'goya-core' ),
			'value' => '8'
		),
		array(
	    'type' 			=> 'dropdown',
	    'heading' 		=> __( 'Order By', 'goya-core' ),
	    'param_name' 	=> 'orderby',
	    'description'	=> __( 'Select posts order-by.', 'goya-core' ),
	    'value' 		=> array(
        'None'          => 'none',
        'ID'            => 'ID',
        'Author'        => 'author',
        'Title'         => 'title',
        'Name'          => 'name',
        'Date'          => 'date',
        'Random'        => 'rand',
        'Commen Count'  => 'comment_count',
        'Menu Order'    => 'menu_order',
        'IDs Option'    => 'post__in'
	    ),
	    'std' 			=> 'none'
	),
		array(
	    'type' 			=> 'dropdown',
	    'heading' 		=> __( 'Order', 'goya-core' ),
	    'param_name' 	=> 'order',
	    'description'	=> __( 'Select posts order.', 'goya-core' ),
	    'value'			=> array(
	    	'Descending'	=> 'desc',
	    	'Ascending'		=> 'asc'
	    ),
	    'std'			=> 'asc'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Categories to show', 'goya-core' ),
			'param_name' => 'category',
			'description' => esc_html__('Narrow posts by category or leave empty to show posts from all categories', 'goya-core' ),
			'value' => goya_get_post_categories(),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Tags', 'goya-core' ),
			'param_name' => 'tag',
			'description' => __( 'List separated by commas. If set, they will be used instead of the categories above.', 'goya-core' ),
			'value' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'goya-core' ),
			'param_name' => 'style',
			'description' => __( 'Posts style.', 'goya-core' ),
			'value' => array(
				__( 'Grid', 'goya-core' ) => 'grid',
				__( 'Masonry', 'goya-core' ) => 'masonry',
				__( 'Cards', 'goya-core' ) => 'cards',
				__( 'Classic', 'goya-core' ) => 'classic',
				__( 'List', 'goya-core' ) => 'list',
				__( 'Carousel', 'goya-core' ) => 'carousel',
			),
			'std' => 'grid'
		),
		array(
			'type' 			=> 'textfield',
			'heading' => __( 'Columns', 'goya-core' ),
			'param_name' => 'columns',
			'description' => __( 'Select number of carousel columns.', 'goya-core' ),
			'value' 		=> '3',
			'dependency' => array(
				'element' => 'style',
				'value' => array('carousel')
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Post Excerpt', 'goya-core' ),
			'param_name' => 'post_excerpt',
			'description' => __( 'Display post excerpt.', 'goya-core' ),
			'value' => array(
				__( 'Enable', 'goya-core' ) => '1'
			),
			'dependency' => array(
				'element' => 'style',
				'value' => 'carousel'
			),
		)
	 )
) );