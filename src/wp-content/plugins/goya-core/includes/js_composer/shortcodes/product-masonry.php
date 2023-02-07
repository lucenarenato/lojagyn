<?php function goya_shortcode_product_masonry( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'product_sort'        => '',
		'cat'                 => '',
		'category_navigation' => '',
		'product_ids'         => '',
		'hide_out_of_stock'   => '',
		'item_count'          => '4',
		'columns'             => '4',
		'orderby'	            => 'date',
		'order'		            => 'DESC',
		'item_style'          => 'style4',
		'item_margins'        => 'regular-padding',
		'show_variations'     => '',
	), $atts ) );

	$categories = $cat ? explode(',',$cat) : false;

	global $woocommerce, $woocommerce_loop;
			
	$args = array();
	
	if ($product_sort == 'featured-products') {
		$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
		);
	} else if ($product_sort == 'top-rated') {
		$ordering_args = WC()->query->get_catalog_ordering_args( 'rating', 'asc' );
				
		$args = array(
			'meta_key' 				=> $ordering_args['meta_key'],
			'orderby' 				=> $ordering_args['orderby'],
			'order' 				=> $ordering_args['order'],
		);
	} else if ($product_sort == 'sale-products') {
		$args = array(
	    'meta_query'        => WC()->query->get_meta_query(),
	    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
		);
	} else if ($product_sort == 'by-category'){
		$args = array(
			'product_cat' => $cat,
		);
	} else if ($product_sort == 'by-id'){
		$product_id_array = explode(',', $product_ids);
		$args = array(
			'post__in'		=> $product_id_array
		);	    
	} else if ($product_sort == 'best-sellers') {
		$args = array(
			'meta_key' 		=> 'total_sales',
			'orderby' 		=> 'meta_value_num',
			'order' => 'DESC',
		);
	} else {
		$product_sort = "latest-products";
	}

	$args['tax_query'][] = array(
		'taxonomy' => 'product_visibility',
		'field'    => 'name',
		'terms'    => array('exclude-from-catalog'),
		'operator' => 'NOT IN'
	);

	if ($hide_out_of_stock == 'yes') {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array('outofstock'),
			'operator' => 'NOT IN'
		);
	}

	$args['post_type'] = 'product';
	$args['post_status'] = 'publish';
	
	if ($product_sort != 'best-sellers' && $product_sort != 'top-rated' && $product_sort != 'latest-products') {
		$args['orderby'] = $orderby;
		$args['order'] = $order;
	}

	if ($product_sort != 'by-id') {
		$args['ignore_sticky_posts'] = 1;
		$args['posts_per_page'] = $item_count;
		$args['no_found_rows'] = 1;
	} else {
		$args['posts_per_page'] = -1;
	}
	
	$args['meta_query'] = WC()->query->get_meta_query();
	
	ob_start();
	
	$products = new WP_Query( apply_filters('goya_core_product_masonry_args', $args) );

	// Products ID's
	$products_id_array = array();

	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) : $products->the_post();
			$products_id_array[] = $products->post->ID;
		endwhile;
	}

	// Hover image
	$item_hover_img = get_theme_mod('shop_product_img_hover',true);

	// Hover animation
	$item_hover_animation = get_theme_mod('shop_product_animation_hover','zoom-jump');

	// Loading animation
	$item_animation = get_theme_mod('shop_product_animation','animation bottom-to-top');	

	// Quick view
	$item_quickview = get_theme_mod('product_quickview', true);

	$rand = rand(0,1000);
	ob_start();

	$classes[] = 'et-product et-main-products products masonry row';
	$classes[] = 'variable-height et-loader';
	$classes[] = $item_margins;
	$classes[] = 'et-product-style-'.$item_style;

	// Product variations
	$classes[] = ($show_variations) ? 'et-shop-show-variations' : 'et-no-variations';

	// Hover images
	if ( goya_core_meta_config('shop','product_img_hover', true) == true ) $classes[] = 'et-shop-hover-images';

	// Category filter
	if($categories && $category_navigation) {
	 do_action('et-products-filter', $categories, $rand, $products_id_array );
	}

	/* Indicate it's a masonry element to content-product.php */
	$item_masonry = 'masonry';
	
	if ( $products->have_posts() ) { 

		$woocommerce_loop['columns'] = $columns; 
		$columns_large = get_theme_mod('shop_columns', 4);
		$columns_mobile = get_theme_mod('shop_columns_mobile', 2);

		?>
			
		<ul class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>" data-filter="et-filter-<?php echo esc_attr($rand); ?>">
				
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php 
				set_query_var( 'goya_is_shortcode', true );
				set_query_var( 'goya_product_style', $item_style );
				set_query_var( 'goya_masonry_list', $item_masonry );
				set_query_var( 'goya_product_swatches', $show_variations );

				set_query_var( 'goya_product_animation', $item_animation );
				set_query_var( 'goya_product_hover_image', $item_hover_img );
				set_query_var( 'goya_product_hover_animation', $item_hover_animation );
				set_query_var( 'goya_product_quickview', $item_quickview );
				set_query_var( 'goya_product_skip_lazy', 0 );
				set_query_var( 'goya_product_columns_large', $columns_large );
				set_query_var( 'goya_product_columns_mobile', $columns_mobile );

				$product = wc_get_product( $products->post->ID ); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile; // end of the loop. ?>
									
		</ul>
		 
	<?php }
			 
	 $out = ob_get_contents();
	 if (ob_get_contents()) ob_end_clean();
	 
	 wp_reset_query();
	 wp_reset_postdata();
	 unset($args);
		 
	return $out;
}
add_shortcode('et_product_masonry', 'goya_shortcode_product_masonry');