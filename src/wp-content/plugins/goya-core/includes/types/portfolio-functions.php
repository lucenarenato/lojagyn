<?php

// Change Posts Per Page for Portfolio Archive
add_filter( 'pre_get_posts', 'goya_set_portfolio_posts_per_page' );

function goya_set_portfolio_posts_per_page( $query ) {
	$ppp = get_option( 'posts_per_page' ); // Default posts per page

	if ( $query->is_post_type_archive( 'portfolio' ) && ! is_admin() && $query->is_main_query() ) {
		$query->set( 'posts_per_page', apply_filters('goya_porfolio_posts_per_page', $ppp) );
	}
	return $query;
}


function goya_portfolio_default($content) {
	$page_id = get_queried_object_id();
	$p_main = goya_core_meta_config('portfolio','main_page', 'automatic');
	$p_page = goya_core_meta_config('portfolio','page_custom', '');

	if ($p_main == 'custom' && $page_id == $p_page ) {
	
		$p_navigation = goya_core_meta_config('portfolio','categories_nav', 'true');
		$p_layout = goya_core_meta_config('portfolio','layout_main', 'masonry');
		$p_columns = goya_core_meta_config('portfolio','columns', 'col-12 col-md-4 col-lg-3');
		$p_alternate = goya_core_meta_config('portfolio','list_alternate', 'true');
		$p_item_style = goya_core_meta_config('portfolio','item_style', 'regular');
		$p_margin = goya_core_meta_config('portfolio','item_margin', 'regular-padding');
		$p_animation = goya_core_meta_config('portfolio','animation', 'animation bottom-to-top');
		$p_numpost = get_option( 'posts_per_page' );
		$p_loadmore = 'true';
		$p_aspect = 'original';

		$et_portfolio = '[et_portfolio 
			portfolio_layout    = "'.$p_layout.'" 
			alternate_cols      = "'.$p_alternate.'" 
			item_style          = "'.$p_item_style.'" 
			item_margins        = "'.$p_margin.'" 
			animation           = "'.$p_animation.'" 
			category_navigation = "'.$p_navigation.'" 
			num_posts           = "'.$p_numpost.'" 
			columns             = "'.$p_columns.'" 
			loadmore            = "true" 
			source              = "size:all|post_type:portfolio" 
		]';

		$content .= $et_portfolio;

	}

  return $content;

}
add_filter( 'the_content', 'goya_portfolio_default' );

if (! function_exists('goya_get_portfolio_columns')) {
	function goya_get_portfolio_columns($columns = 3) {
		switch($columns) {
			case '6':
				$columns = 'col-12 col-md-4 col-lg-2';
				break;
			case '4':
				$columns = 'col-12 col-md-4 col-lg-3';
				break;
			case '3':
				$columns = 'col-12 col-lg-4';
				break;
			case '2':
				$columns = 'col-12 col-lg-6';
				break;
			default:
				break;
		}
		return $columns;
	}
}

function goya_get_masonry_size($size = '') {
	$class_image = array();
	$columns = apply_filters( 'goya_set_masonry_columns', $col = 4 );
	$col_lg = 'col-lg-' . 12/$columns;
	switch($size) {
		case 'large':
			$class_image['class'] = 'col-12 col-md-6 col-lg-6 masonry-large';
			$class_image['image_size'] = 'large';
			break;
		case 'horizontal':
			$class_image['class'] = 'col-12 col-md-6 col-lg-6 masonry-horizontal';
			$class_image['image_size'] = 'large';
			break;
		case 'vertical':
			$class_image['class'] = 'col-12 col-md-6 '. $col_lg .' masonry-vertical';
			$class_image['image_size'] = 'large';
			break;
		case 'small':
		default:
			$class_image['class'] = 'col-12 col-md-6 '. $col_lg .' masonry-small';
			$class_image['image_size'] = 'medium_large';
			break;
	}
	return $class_image;
}

/* Portfolio Categories Array */
function goya_get_portfolio_categories() {
	$portfolio_categories = get_terms('portfolio-category', array('hide_empty' => false));
	$out = array();
	if (empty($portfolio_categories->errors)) {
		foreach($portfolio_categories as $portfolio_category) {
			$name = '[id' . $portfolio_category->term_id . '] ' . $portfolio_category->name;
			$out[$name] = $portfolio_category->term_id;
		}
	}
	return $out;
}

/* Header Filter */
function goya_portfolio_categories($categories, $id, $portfolio_id_array = false) {
	
	if (empty($categories) || !$categories){
		$args = array(
			'type'			=> 'post',
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 1,
			'taxonomy'		=> 'portfolio-category'
		);

		$categories = get_categories( apply_filters('goya_portfolio_categories_args', $args) );
	} 

	$portfolio_id_array = $portfolio_id_array ? $portfolio_id_array : array();

	?>
	<nav class="et-portfolio-filter" id="et-filter-<?php echo esc_attr($id); ?>">

		<ul>
			<li class="active"><a class="tab-link"><?php echo apply_filters( 'portfolio_all_translation',  esc_html('All', 'goya-core' ) ); ?></a></li>
			<?php 
				foreach ($categories as $cat) {
					$term = get_term($cat);
					echo '<li class="' . esc_attr($term->slug) . '"><a class="tab-link" data-filter="cat-' . esc_attr($term->slug) . '" data-term-id="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</a></li>';
				}
			?>
		</ul>
	</nav>
	<?php

}
add_action( 'goya_render_filter', 'goya_portfolio_categories', 1, 4 );


/* Disable GIF Sizes */
function goya_disable_gif_sizes( $sizes, $metadata ) {

	// Get filetype data.
	$filetype = wp_check_filetype($metadata['file']);

	// Check if is gif. 
	if($filetype['type'] == 'image/gif') {
		$sizes = array();// Unset sizes if file is gif.
	}

	// Return sizes you want to create from image (None if image is gif.)
	return $sizes;
}   
add_filter('intermediate_image_sizes_advanced', 'goya_disable_gif_sizes', 10, 2); 