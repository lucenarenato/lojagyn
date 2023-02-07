<?php

/* Blog: Ajax load posts
---------------------------------------------------------- */

function goya_ajax_load_blog_posts() {
	$page = isset($_POST['page']) ? sanitize_key( wp_unslash($_POST['page']) ) : "1";  
	$ppp = get_option('posts_per_page');
	$blog_style = isset($_POST['blog_style']) ? sanitize_key( wp_unslash($_POST['blog_style']) ) : get_theme_mod('blog_style','masonry');
	$category_id = isset($_POST['category_id']) ? sanitize_key( wp_unslash($_POST['category_id']) ) : false;
	
	$args = array(
		'posts_per_page'	 => $ppp,
		'paged' => $page,
		'cat' => $category_id,
		'post_status' => 'publish'
	);

	$more_query = new WP_Query( apply_filters('goya_load_more_blog_args', $args) );
		
	if ($more_query->have_posts()) :  while ($more_query->have_posts()) : $more_query->the_post(); 
		echo '<h1>'.$category_id.'</h1>';
		get_template_part( 'inc/templates/blogbit/'.$blog_style); 
	endwhile; else : endif;
	wp_die();
}

add_action('wp_ajax_nopriv_goya_blog_ajax', 'goya_ajax_load_blog_posts');
add_action('wp_ajax_goya_blog_ajax', 'goya_ajax_load_blog_posts');


/* Portfolio: Ajax load portfolio
---------------------------------------------------------- */

function goya_ajax_load_portfolio() {
	$keyword = isset($_POST['keyword']) ? sanitize_key( wp_unslash($_POST['keyword']) ) : false;
	$aspect = isset($_POST['aspect']) ? sanitize_key( wp_unslash($_POST['aspect']) ) : false;
	$animation = isset($_POST['animation']) ? sanitize_key( wp_unslash($_POST['animation']) ) : false;
	$columns = isset($_POST['columns']) ? urldecode( wp_unslash($_POST['columns']) ) : false;
	$style = isset($_POST['style']) ? sanitize_key( wp_unslash($_POST['style']) ) : false;
	$masonry = isset($_POST['masonry']) ? sanitize_key( wp_unslash($_POST['masonry']) ) : false;
	$category = isset($_POST['category']) ? urldecode( wp_unslash($_POST['category']) ) : false;
	$count = isset($_POST['count']) ? sanitize_key( wp_unslash($_POST['count']) ) : false;
	$categories = $category ? explode(',',$category) : false;

	$page = isset($_POST['page']) ? sanitize_key( wp_unslash($_POST['page']) ) : "1";

	$args = array(
		's'              => $keyword,
		'post_status'    => 'publish',
		'post_type'      => 'portfolio',
		'posts_per_page' => intval($count),
		'paged'          => $page,
	);

	if($categories) {
		$args['tax_query'] = array(
			array(
				'taxonomy'       => 'portfolio-category',
				'field'          => 'term_id',
				'terms'          => $categories,
			)
		);
	 }

	$more_query = new WP_Query( $args );

	if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
		WPBMap::addAllMappedShortcodes();
	}

	if ($more_query->have_posts()) :  while ($more_query->have_posts()) : $more_query->the_post(); 

		set_query_var( 'goya_port_layout', $masonry );
		set_query_var( 'goya_port_aspect', $aspect );
		set_query_var( 'goya_port_columns', $columns );
		set_query_var( 'goya_port_animation', $animation );
		get_template_part( 'inc/templates/portfolio/'.$style );
		
	endwhile; else : endif;

	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_nopriv_goya_portfolio_ajax', 'goya_ajax_load_portfolio');
add_action('wp_ajax_goya_portfolio_ajax', 'goya_ajax_load_portfolio');


/* WooCommerce: Quick View
---------------------------------------------------------- */

function goya_ajax_load_product() {
	global $post;
	
	$post = get_post( wp_unslash( absint( $_POST['product_id'] ) ) );
	$output = '';
	
	setup_postdata( $post );
		
	ob_start();
		wc_get_template_part( 'quickview/content', 'quickview' );
	$output = ob_get_clean();
	
	wp_reset_postdata();
			
	echo esc_attr('') . $output;
			
	exit;
}

add_action( 'wp_ajax_nopriv_goya_product_ajax', 'goya_ajax_load_product' );
add_action( 'wc_ajax_goya_product_ajax', 'goya_ajax_load_product' );



/* Ajax Products Search
---------------------------------------------------------- */

function goya_ajax_search_products() {
	$search_keyword = wp_unslash( $_REQUEST['query'] );
	$time_start = microtime(true);
	$product_visibility_term_ids = wc_get_product_visibility_term_ids();
	$ordering_args = WC()->query->get_catalog_ordering_args( 'title', 'asc' );
	$suggestions = array();

	if ( get_theme_mod('search_categories', false) == true ) {
		$category_id = wp_unslash( $_REQUEST['category_slug'] );
	} else {
		$category_id = '0';
	}

	if ( $category_id != '0' ) {
		$operator = 'IN';
	} else {
		$operator = 'NOT IN';
	}
	
	$args = array(
		's'                   => $search_keyword,
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => 6,
		'orderby'             => 'relevance',
		'order'               => $ordering_args['order'],
		'suppress_filters' => false, // WPML only current language
		'tax_query' => array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			),
			
		),
	);

	if ( $category_id != '0' ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $category_id,
			'operator' => 'IN',
		);
	}

	if ( get_option('woocommerce_hide_out_of_stock_items') == 'yes' ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array('outofstock'),
			'operator' => 'NOT IN'
		);
	}

	$products = get_posts( $args );
	
	if ( ! empty( $products ) ) {	
		$counter = 0;
		foreach ( $products as $post ) {
			if ($counter == 5) {
				$suggestions[] = array(
					'id'    => -2,
					'value' => $search_keyword,
					'url'   => esc_html__( 'View All', 'goya' ),
					'thumbnail' => '',
					'price' => ''
				);
			} else {
				$product = wc_get_product( $post );

				$suggestions[] = array(
					'id'    => $product->get_id(),
					'value' => strip_tags( $product->get_title() ),
					'url'   => $product->get_permalink(),
					'thumbnail' => get_the_post_thumbnail( $product->get_id(), 'shop_catalog' ),
					'price' => $product->get_price_html()
				);
			}
			$counter++;
		}
	} else {
		$suggestions[] = array(
			'id'    => -1,
			'value' => '',
			'url'   => esc_html__( 'No results', 'goya' ),
			'thumbnail' => '',
			'price' => ''
		);
	}
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	$suggestions = array(
		'suggestions' => $suggestions,
		'time'        => $time
	);
	echo json_encode( $suggestions );
	wp_die();
}

add_action('wp_ajax_nopriv_goya_search_products_ajax', 'goya_ajax_search_products');
add_action('wp_ajax_goya_search_products_ajax', 'goya_ajax_search_products');

