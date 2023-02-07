<?php

// Portfolio Masonry/Grid
vc_map( array(
	'name' => esc_html__('Portfolio', 'goya-core' ),
	'description' => esc_html__('Display your Portfolio items', 'goya-core' ),
	'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_portfolio',
	'icon' => 'et_portfolio',
	'params'	=> array(
		array(
	    'type' => 'dropdown',
	    'heading' => esc_html__('Portfolio Layout', 'goya-core' ),
	    'param_name' => 'portfolio_layout',
	    'std'=> 'grid',
	    'value' => array(
	    	__( 'List', 'goya-core' ) => 'list',
	    	__( 'Grid Columns', 'goya-core' ) => 'grid',
	    	__( 'Masonry - Packery (filterable)', 'goya-core' ) => 'masonry',
	    	__( 'Masonry - Columns Only (filterable)', 'goya-core' ) => 'masonry-columns',
	    ),
	    'admin_label' => true,
	    'description' => esc_html__('Select Portfolio Layout', 'goya-core' )
		),
		array(
      'type' => 'checkbox',
      'heading' => esc_html__('Alternate columns', 'goya-core' ),
      'param_name' => 'alternate_cols',
      'value' => array(
    		__( 'Yes', 'goya-core' ) => 'true'
    	),
      'description' => esc_html__('Alternate image/text columns in List view', 'goya-core' ),
      'dependency'	=> array(
	    	'element'	=> 'portfolio_layout',
	    	'value' 	=> 'list'
	    ),
	  ),
		array(
	    'type' => 'dropdown',
	    'heading' => esc_html__('Columns', 'goya-core' ),
	    'param_name' => 'columns',
	    'std'=> '4',
	    'value' => array(
	    	__( '6 Columns', 'goya-core' ) => '6',
	    	__( '4 Columns', 'goya-core' ) => '4',
	    	__( '3 Columns', 'goya-core' ) => '3',
	    	__( '2 Columns', 'goya-core' ) => '2'
	    ),
	    'admin_label' => true,
	    'description' => esc_html__('Colums in Grid layout', 'goya-core' ),
	    'dependency'	=> array(
	    	'element'	=> 'portfolio_layout',
	    	'value' 	=> array( 'grid', 'masonry-columns' )
	    ),
		),
		array(
	    'type' => 'dropdown',
	    'heading' => esc_html__('Items Style', 'goya-core' ),
	    'param_name' => 'item_style',
	    'group' => __( 'Styling','goya-core' ),
	    'std'=> 'regular',
	    'value' => array(
	    	__( 'Regular', 'goya-core' ) => 'regular',
	    	__( 'Overlay', 'goya-core' ) => 'overlay',
	    	__( 'Hover Card', 'goya-core' ) => 'hover-card'
	    ),
	    'admin_label' => true,
	    'description' => esc_html__('Select Items Style', 'goya-core' ),
	    'dependency'	=> array(
	    	'element'	=> 'portfolio_layout',
	    	'value' 	=> array( 'grid', 'masonry', 'masonry-columns' )
	    ),
		),
		array(
      'type'      => 'dropdown',
      'heading'     => __( 'Animation', 'goya-core' ),
      'param_name'  => 'animation',
      'group' => __( 'Styling','goya-core' ),
      'value'     => array(
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
      'dependency'	=> array(
      	'element'	=> 'portfolio_layout',
      	'value' 	=> array( 'grid', 'masonry', 'masonry-columns' )
      ),
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
      'description' => esc_html__('Adjust the space between items', 'goya-core' ),
      'dependency'	=> array(
	    	'element'	=> 'portfolio_layout',
	    	'value' 	=> array( 'grid', 'masonry', 'masonry-columns' )
	    ),
	  ),
	  array(
      'type' => 'checkbox',
      'heading' => esc_html__('Categories to show', 'goya-core' ),
      'param_name' => 'category_filter',
      'value' => goya_get_portfolio_categories(),
      'description' => esc_html__('Narrow items by category or leave empty to show items from all categories', 'goya-core' )
	  ),
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Post count', 'goya-core' ),
			'param_name' 	=> 'num_posts',
			'description'	=> __( 'How many items to show. Use -1 to show all.', 'goya-core' ),
			'std'=> '6',
		),
	  array(
      'type' => 'checkbox',
      'heading' => esc_html__('Load More Button', 'goya-core' ),
      'param_name' => 'loadmore',
      'value' => array(
    		__( 'Yes', 'goya-core' ) => 'true'
    	),
      'description' => esc_html__('Add "Load More" button at the bottom. Only if Post Count > 1', 'goya-core' ),
	  ),
	  array(
      'type' => 'checkbox',
      'heading' => esc_html__('Category navigation', 'goya-core' ),
      'param_name' => 'category_navigation',
      'value' => array(
    		__( 'Yes', 'goya-core' ) => 'true'
    	),
      'description' => esc_html__('Show category navigation filter on top', 'goya-core' ),
      'dependency'	=> array(
	    	'element'	=> 'portfolio_layout',
	    	'value' 	=> array( 'masonry', 'masonry-columns' )
	    ),
	  ),
	  
	),
	
) );