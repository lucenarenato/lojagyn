<?php
/**
Post Types init
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Goya_Portfolio {
	
	/* Init */
	function init() {

		define( 'GOYA_PORTFOLIO_VERSION', '1.0' );
		// Post type and taxonomy hooks
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );

	}

	/* Register categories taxonomy */
	
	function register_taxonomy() {
	 	global $et_theme_opt;

	  $portfolio_taxonomy_permalink = _x( 'portfolio-category', 'portfolio category permalink slug', 'goya-core' );
	  
	  $args = array(
	  	'label'              => _x( 'Portfolio Categories', 'category label', 'goya-core' ),
	  	'public'             => true,
	  	'show_ui'            => true,
	  	'show_in_nav_menus'	 => false,
	  	'hierarchical'       => true,
	  	'query_var'          => true,
	  	'show_in_rest'        => true,
	  	'rewrite'            => array(
	  	'slug'               => $portfolio_taxonomy_permalink,
	  	'with_front' 	       => false,
	  	'hierarchical'	      => true
	  	)
	  );

	  register_taxonomy( 'portfolio-category', 'portfolio', $args );
	}

	/* Register post type */
	
	function register_post_type() {
		global $et_theme_opt;

		$portfolio_slug = ( strlen( get_theme_mod( 'portfolio_permalink', 'portfolio' ) ) > 0 ) ? get_theme_mod( 'portfolio_permalink', 'portfolio' ) : _x( 'portfolio', 'portfolio permalink slug', 'goya-core' );
		$labels = array(
			'name'               => _x( 'Portfolio', 'post type general name', 'goya-core' ),
			'singular_name'      => esc_html__( 'Portfolio Item','goya-core' ),
			'rewrite'            => array('slug' => esc_html__( 'portfolios','goya-core' )),
			'add_new'            => _x('Add New', 'portfolio item', 'goya-core'),
			'add_new_item'       => esc_html__('Add New Portfolio Item','goya-core'),
			'edit_item'          => esc_html__('Edit Portfolio Item','goya-core'),
			'new_item'           => esc_html__('New Portfolio Item','goya-core'),
			'view_item'          => esc_html__('View Portfolio Item','goya-core'),
			'all_items'          => esc_html__('All Portfolio','goya-core'),
			'search_items'       => esc_html__('Search Portfolio','goya-core'),
			'not_found'          => esc_html__('No Portfolio items found','goya-core'),
			'not_found_in_trash' => esc_html__('Nothing found in Trash','goya-core'),
			'parent_item_colon'  => ''
	  );
	  
	  $args = array(
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-schedule',
			'menu_position'       => null,
			'supports'            => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
			'show_in_rest'        => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'taxonomies'          => array( 'portfolio-category' ),
			'has_archive'         => ( get_theme_mod( 'portfolio_main_page', 'automatic' ) == 'automatic' ) ? true : false,
			'rewrite'             => array(
			'slug'                => untrailingslashit( $portfolio_slug ),
			'with_front'          => false
			),
			'capability_type'     => 'post',
	  ); 
	  
	  register_post_type('portfolio',$args);

	}

}

$Goya_Portfolio = new Goya_Portfolio();
$Goya_Portfolio->init();
