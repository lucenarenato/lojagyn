<?php function goya_shortcode_portfolio( $atts, $content = null ) {
  
  extract( shortcode_atts( array(
    'portfolio_layout' => 'grid',
    'alternate_cols' => '',
    'columns' => '4',
  	'item_style' => 'regular',
    'item_margins' => 'regular-padding',
    'aspect' => 'original', // Add element in elements/portfolio.php if needed
    'animation' => '',
  	'num_posts'			=> '6',
    'category_filter' => '',
  	'category_navigation' => '',
  	'loadmore' => '',
  ), $atts ) );

  $categories = $category_filter ? explode(',',$category_filter) : false;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

   $args = array(
    'post_status'     => 'publish',
    'post_type'     => 'portfolio',
    'posts_per_page'  => intval( $num_posts ),
		'paged'          => $paged,
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

  $posts = new WP_Query( $args );   
   
  $portfolio_id_array = array();

  if ( $posts->have_posts() ) {
  	while ( $posts->have_posts() ) : $posts->the_post();
  		$portfolio_id_array[] = get_the_ID();
  	endwhile;
  }
 	$rand = rand(0,1000);
 	ob_start();

  if ($portfolio_layout == 'list') {
    $item_style = 'list';
    $classes[] = 'post post-list';
    $classes[] = 'alternate-cols-'.$alternate_cols;
  } else {
    $classes[] = $item_margins;
    $classes[] = 'row';
  }

	if ($portfolio_layout == 'masonry' || $portfolio_layout == 'masonry-columns') {
  $classes[] = 'masonry et-loader';
	}
  $classes[] = 'variable-height';
 	$classes[] = 'et-portfolio';
	$classes[] = 'et-portfolio-layout-'.$portfolio_layout;
 	$classes[] = 'et-portfolio-style-'.$item_style;
 
 	?>
	<?php
	if ($portfolio_layout != 'list' && $portfolio_layout != 'grid') {
    if($category_navigation) {
     do_action('goya_render_filter', $categories, $rand, $portfolio_id_array );
    }
  ?>
	<div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>" data-filter="et-filter-<?php echo esc_attr($rand); ?>" <?php if ($portfolio_layout == 'masonry' || $portfolio_layout == 'masonry-columns') { ?>data-layoutmode="packery" <?php } ?>>
  <?php } else { ?>
  <div class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-loadmore="#loadmore-<?php echo esc_attr($rand); ?>">
  <?php } ?>
		<?php
			while ( $posts->have_posts() ) : $posts->the_post();
				set_query_var( 'goya_port_layout', $portfolio_layout );
        set_query_var( 'goya_port_columns', $columns );
        set_query_var( 'goya_port_aspect', $aspect );
        set_query_var( 'goya_port_animation', $animation );
				get_template_part( 'inc/templates/portfolio/'.$item_style );
		 	endwhile; // end of the loop. 
	 	?>
	</div>
	
	<?php 
	$total_pages = $posts->max_num_pages;
	 
	if ($loadmore && intval( $num_posts ) > 1 && $total_pages > 1) { 
		wp_localize_script( 'goya-app', esc_attr('goya_portfolio_ajax_'.$rand), array( 
			'masonry' => $portfolio_layout,
      'columns' => $columns,
      'aspect' => $aspect,
      'animation' => $animation,
			'style' => $item_style,
			'count' => intval( $num_posts ),
			'category' => urlencode($category_filter),
			'total_pages' => $total_pages,
		) );
	?>
	<div class="et-infload-controls et-portfolio-infload-controls et-masonry-infload-controls">
		<a href="#" class="et-portfolio-infload-btn et-infload-btn button outlined" id="loadmore-<?php echo esc_attr($rand); ?>" data-masonry-id="<?php echo esc_attr($rand); ?>"><?php esc_html_e( 'Load More', 'goya' ); ?></a>
		<a class="et-infload-to-top"><?php esc_html_e( 'All items loaded', 'goya' ); ?></a>
	</div>
	<?php }

   $out = ob_get_clean();
   
   wp_reset_postdata();
     
  return $out;
}
add_shortcode('et_portfolio', 'goya_shortcode_portfolio');