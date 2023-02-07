<?php function goya_shortcode_product_category_grid( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'cat' 			=> '',
		'order_by'		=> 'name',
		'sort_order'		=> 'ASC',
		'style'		=> 'style1',
		'rounded_corners'		=> '',
	), $atts ) );

	$args = $product_categories = $category_ids = array();
	$cats = explode(",", $cat);
	
	foreach ($cats as $cat) {
		$c = get_term_by('slug', $cat ,'product_cat');
		
		if($c) {
			array_push($category_ids, $c->term_id);
		}
	}
	
	$args = array(
	'orderby'    => $order_by,
	'order'      => $sort_order,
	'hide_empty' => '0',
	'include'	=> $category_ids
	);
	$product_categories = get_terms( 'product_cat', $args );
	ob_start();
	$i = 1;

	$classes[] = "row products et-product-category-grid masonry et-loader";
	$classes[] = ($rounded_corners) ? 'rounded-corners' :  'sharp-corners';
	$classes[] = $style;

	if ( $product_categories ) { 
	?>
		<ul class="<?php echo implode(' ', $classes); ?>" data-layoutmode="packery">
			<?php 
				foreach ( $product_categories as $category ) {
					
					$article_size = goya_get_product_cat_grid_size($style, $i);
					wc_get_template( 'content-product_cat.php', array(
	          'category' => $category,
	          'class' => 'item '.$article_size
	        ) ); 
	        
					$i++;
				} 
			?>
		</ul>
		<?php 
	}
	     
	$out = ob_get_clean();
	 
	return $out;
}
add_shortcode('et_product_category_grid', 'goya_shortcode_product_category_grid');