<?php 

/* Excerpt filters
---------------------------------------------------------- */

add_filter( 'excerpt_length', 'goya_default_excerpt_length' );
add_filter( 'excerpt_more', 'goya_excerpt_more');


function goya_default_excerpt_length( $length ) {
	return 50;
}
function goya_short_excerpt_length() {
	return 28;
}
function goya_mini_excerpt_length() {
	return 10;
}
function goya_excerpt_more($more) {
	return '&hellip;';
}

function goya_excerpt($excerpt_length, $added = false) {
	$text = get_the_excerpt();
	$text = str_replace('[...]', '', $text );
	$text = mb_substr($text,0,$excerpt_length, "utf-8");
	$text = $text.$added;
	$text = apply_filters( 'the_excerpt', $text );
	return $text;
}


/* Content filters
---------------------------------------------------------- */

/* Remove Empty P tags */
function goya_remove_p($content){   
	$to_remove = array(
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);
	
	$content = strtr($content, $to_remove);
	return $content;
}
add_filter('the_content', 'goya_remove_p');


/* Parse video embeds */
function goya_video_embed($embed) {
	global $wp_embed;
	$html = '';

	if ($embed !='') {
		$html = $wp_embed->run_shortcode('[embed]'.$embed.'[/embed]');
	}

	return $html;
}
add_filter( 'goya_post_video_embed', 'goya_video_embed' );


/* Post categories
---------------------------------------------------------- */

function goya_the_category_list( $categories, $post_id ) {
  return array_slice( $categories, 0, 3, true );
}
add_filter( 'the_category_list', 'goya_the_category_list', 10, 2 );



/* Blog categories menu
---------------------------------------------------------- */

function goya_blog_category_menu() {
	global $wp_query;

	$current_cat = ( is_category() ) ? $wp_query->queried_object->cat_ID : '';
	
	// Categories order
	$orderby = 'slug';
	$order = 'asc';
	$orderby = get_theme_mod('blog_categories_orderby', 'name');
	$order = get_theme_mod('blog_categories_order', 'asc');
	
	$args = array(
		'type'			=> 'post',
		'orderby'		=> $orderby,
		'order'			=> $order,
		'hide_empty'	=> ( get_theme_mod('blog_categories_hide_empty', true ) == true ) ? 1 : 0,
		'hierarchical'	=> 1,
		'taxonomy'		=> 'category'
	); 
	
	$categories = get_categories( $args );
	
	$current_class_set = false;
	$categories_output = '';
	
	foreach ( $categories as $category ) {
		if ( $current_cat == $category->cat_ID ) {
			$current_class_set = true;
			$current_class = ' class="current-cat"';
		} else {
			$current_class = '';
		}
		$category_link = get_category_link( $category->cat_ID );
		
		$categories_output .= '<li' . $current_class . '><a href="' . esc_url( $category_link ) . '">' . esc_attr( $category->name ) . '</a></li>';
	}
	
	$categories_count = count( $categories );
	
	// "All" category class attr
	$current_class = ( $current_class_set ) ? '' : ' class="current-cat"';
	
	$output = '<div class="et-blog-categories-wrap">';
	$output .= '<ul id="et-blog-categories-list" class="et-blog-categories-list"><li' . $current_class . '><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'All', 'goya' ) . '</a></li>' . $categories_output . '</ul>';
	$output .= '</div>';
	
	return $output;
}


/* Blog Pagination
---------------------------------------------------------- */

function goya_blog_pagination() {
	
	$blog_pagination_style = get_theme_mod('blog_pagination_style','button');

	if ($blog_pagination_style == 'regular') {
	?>
		<div class="row align-center">
			<div class="col-12 col-md-10 col-lg-9">
				<?php the_posts_pagination(array(
					'prev_text' 	=> '<span>&larr; '.esc_html__( "Prev", 'goya' ).'</span>',
					'next_text' 	=> '<span>'.esc_html__( "Next", 'goya' ).' &rarr;</span>',
					'mid_size'		=> 1
				)); ?>
			</div>
		</div>
	<?php
	} else {
	?>
	<div class="row pagination-space et-infload-controls et-blog-infload-controls <?php echo esc_attr( $blog_pagination_style ); ?>-mode">
		<div class="col-12">
			<a href="#" class="et-infload-btn et-blog-infload-btn button outlined" title="<?php esc_attr_e('Load More', 'goya'); ?>"><?php esc_html_e( 'Load More', 'goya' ); ?></a>
			<a class="et-infload-to-top et-blog-infload-to-top"><?php esc_html_e( 'All posts loaded.', 'goya' ); ?></a>
		</div>
	</div>
	<?php
	}
}
add_action( 'goya_blog_pagination', 'goya_blog_pagination',3 );


function goya_pagination_style () {
	$pagination_style = get_theme_mod('blog_pagination_style','button');
	$infload = ($pagination_style !== 'regular') ? 'blog-infload' : '';
	$pagination_style = 'pagination-'.$pagination_style. ' '. $infload;

	return $pagination_style;
}



/* Posts Prev/Next
---------------------------------------------------------- */

function goya_post_navigation() {
	$prev = get_previous_post();
	$next = get_next_post();
	$class = ($prev && $next) ? 'col-md-6' : 'col-12';
	$post_type = get_post_type( get_the_ID() );
	$nav_style = goya_meta_config($post_type,'navigation','simple');

	?>
	<div class="et_post_nav nav-style-<?php echo esc_attr( $nav_style ); ?>">
		<div class="row">
			<div class="nav-item <?php echo esc_attr( $class ); ?>">
				<?php
					if ($prev) {
						$image_id = get_post_thumbnail_id($prev->ID);
						$image_link = wp_get_attachment_image_src($image_id, 'medium_large');
					?>
					<a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" class="post_nav_link prev">
						<?php if ($image_id && $nav_style == 'image') { ?><div class="nav_post_bg" style="background-image: url(<?php echo esc_attr($image_link[0]); ?>);"></div><?php } ?>
						<?php get_template_part( 'assets/img/svg/arrow-left.svg' ); ?>
						<div class="text">
							<strong>
								<?php esc_html_e('Previous', 'goya'); ?>
							</strong>
							<h3><?php echo apply_filters( 'post_navigation', $prev->post_title); ?></h3>
						</div>
					</a>
				<?php } ?>
			</div>
			<div class="nav-item <?php echo esc_attr( $class ); ?>">
				<?php
				if ($next) {
					$image_id = get_post_thumbnail_id($next->ID);
					$image_link = wp_get_attachment_image_src($image_id, 'medium_large');
				?>
					<a href="<?php echo esc_url(get_permalink($next->ID)); ?>" class="post_nav_link next">
						<?php if ($image_id && $nav_style == 'image') { ?><div class="nav_post_bg" style="background-image: url(<?php echo esc_attr($image_link[0]); ?>);"></div><?php } ?>
						<?php get_template_part( 'assets/img/svg/arrow-right.svg' ); ?>
						<div class="text">
							<strong>
								<?php esc_html_e('Next', 'goya'); ?>
							</strong>
							<h3><?php echo apply_filters( 'post_navigation', $next->post_title); ?></h3>
						</div>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'goya_post_navigation', 'goya_post_navigation' );


/* Post Author
---------------------------------------------------------- */

function goya_author_info($id) {
	$id = $id ? $id : get_the_author_meta( 'ID' );
	?>
	<div id="authorpage" class="author_info">
		<?php echo get_avatar( $id , '140'); ?>
		<div class="author-content">
			<div class="author_name"><a href="<?php echo esc_url(get_author_posts_url( $id )); ?>" class="author-link"><?php the_author_meta('display_name', $id ); ?></a></div>
			<?php if(get_the_author_meta('description', $id ) != '') { ?>
			<div class="author_description"><?php the_author_meta('description', $id ); ?></div>
			<?php } ?>
			<?php if(get_the_author_meta('url', $id ) != '') { ?>
				<a href="<?php echo esc_url(get_the_author_meta('url', $id )); ?>" class="auhor-icon" target="_blank"><span class="et-icon et-link"></span></a>
			<?php } ?>
			<?php if(get_the_author_meta('twitter', $id ) != '') { ?>
				<a href="<?php echo esc_url(get_the_author_meta('twitter', $id )); ?>" class="auhor-icon twitter" target="_blank"><span class="et-icon et-twitter"></span></a>
			<?php } ?>
			<?php if(get_the_author_meta('facebook', $id ) != '') { ?>
				<a href="<?php echo esc_url(get_the_author_meta('facebook', $id )); ?>" class="auhor-icon facebook" target="_blank"><span class="et-icon et-facebook"></span></a>
			<?php } ?>
			<?php if(get_the_author_meta('googleplus', $id ) != '') { ?>
				<a href="<?php echo esc_url(get_the_author_meta('googleplus', $id )); ?>" class="auhor-icon google-plus" target="_blank"><span class="et-icon et-google-plus"></span></a>
			<?php } ?>
		</div>
	</div>
<?php
}
add_action( 'goya_author_info', 'goya_author_info',3 );


/* Blog slider on blog home/archive
---------------------------------------------------------- */

add_filter( 'goya_get_blog_slider_output', 'goya_get_blog_slider' );
function goya_get_blog_slider( $post_id, $image_size ) {
	$slider = get_post_gallery( $post_id, false );
	
	if ( $slider ) {
					
		$slider_id = "et-blog-slider-{$post_id}";
		$image_ids = explode( ',', $slider['ids'] );
		$post_permalink = get_permalink();
		
		$slider = "<div id='$slider_id' class='et-wp-gallery et-blog-slider carousel slick slick-slider slick-controls-gray slick-dots-inside slick-dots-centered slick-dots-active-small' data-columns='1' data-navigation='true' data-pagination='true'>";
	
		foreach ( $image_ids as $image_id ) {
			$image_src = wp_get_attachment_image_src( $image_id, $image_size );
			$slider .= '<div><a href="' . esc_url( $post_permalink ) . '"><img src="' . esc_url( $image_src[0] ) . '" width="' . esc_attr( $image_src[1] ) . '" height="' . esc_attr( $image_src[2] ) . '" /></a></div>';
		}
				
		$slider .= "</div>\n";
	}
	
	return $slider;
}

/* Post format icons
---------------------------------------------------------- */

function goya_post_format_icon( $post_id ) {

	$format = get_post_format( $post_id );
	$count = 0;
	$gallery = array();
	
	if ( $format == 'video' ) {
		$icon = 'play';
	} else if ( $format == 'gallery' || $format == 'image') {
		$icon = 'camera';
		if ( rwmb_meta( 'goya_post_featured_gallery') !== '' ) {
			$gallery = rwmb_meta( 'goya_post_featured_gallery', array( 'size' => 'full' ) );
			if (!empty($gallery) ) {
				$count = count($gallery);	
			}
		}
	} else {
		$icon = '';
	}

	if ( $icon != '' ) {
		echo '<span class="post-format-icon">';
		if ($count > 0 ) {
			echo '<span class="count">'. esc_attr($count) . '</span>';
		}
		get_template_part('assets/img/svg/'. $icon .'.svg');
		echo '</span>';
	}
	
}

/* Check if Metabox is active
---------------------------------------------------------- */

if ( ! function_exists( 'rwmb_meta' ) ) {
  function rwmb_meta( $key, $args = '', $post_id = null ) {
  	return false;
  }
}

/*  Convert WP Gallery to slider
 *	WP gallery (override via action)
 *	Note: Code inside "// WP default" comments is located in: "../wp-includes/media.php" ("gallery_shortcode()" function)
 */
function goya_wp_gallery( $val, $attr ) {
	
	$post = get_post();
	
	static $instance = 0;
	$instance++;
	
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => '',
		'icontag'    => '',
		'captiontag' => '',
		'columns'    => 2,
		'size'       => 'goya-rectangle-x2',
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery' );
	
	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}
	
	$gallery_id = "et-wp-gallery-{$instance}";
	$slider_settings_data = ' data-pagination="true" data-navigation="true" data-autoplay="true" data-columns="' . intval( $atts['columns'] ) . '"';
	
	$output = "<div id='$gallery_id' class='et-wp-gallery et-blog-slider slick slick-slider slick-controls-gray slick-dots-inside'" . $slider_settings_data . ">";
	
	foreach ( $attachments as $id => $attachment ) {
		$image_src = wp_get_attachment_image_src( $id, $atts['size'] );
		$output .= '<div><img src="' . esc_url( $image_src[0] ) . '" width="' . esc_attr( $image_src[1] ) . '" height="' . esc_attr( $image_src[2] ) . '" /></div>';
	}
			
	$output .= "</div>\n";

	return $output;
}


/* Related Posts
---------------------------------------------------------- */

// Related Blog Posts

function goya_get_blog_posts_related_by_taxonomy($post_id, $args=array()) {
  $tags = wp_get_post_tags($post_id);
  $query = new WP_Query();
  if (count($tags)) {
	  $tagIDs = array();
	  $tagcount = count($tags);
	  for ($i = 0; $i < $tagcount; $i++) {
	    $tagIDs[$i] = $tags[$i]->term_id;
	  }
	  $args = wp_parse_args($args,array(
	    'tag__in' => $tagIDs,
	    'post__not_in' => array($post_id),
	    'ignore_sticky_posts'=> 1,
	  	'posts_per_page' => get_theme_mod('single_post_related_per_page', 3),
	  	'no_found_rows' => true
	  ));
	  $query = new WP_Query($args);
	  wp_reset_postdata();
	}
  return $query;
}


// Related Posts by Category
function goya_get_posts_related_by_category($post_id, $args=array()) {
	$post_type = get_post_type( $post_id );
	
  $args = wp_parse_args($args,array(
  	'post_type' 		=> $post_type,
    'post__not_in' => array($post_id),
    'ignore_sticky_posts'=> 1,
    'orderby' => 'rand',
  	'posts_per_page' => get_theme_mod('single_post_related_per_page', 3),
  	'no_found_rows' => true
  ));

  if ($post_type == 'portfolio') {
  	$terms = get_the_terms( $post_id, 'portfolio-category');
  	if (!empty($terms)) {
  		foreach ($terms as $term) { 
  			$post_categories[] = $term->slug;
  		}
  		$args['tax_query'] = array(array(
	      'taxonomy' => 'portfolio-category',
	      'field'    => 'slug',
	      'terms'    =>  $post_categories,
	    ));
  	}
  } else {
  	$post_categories = wp_get_post_categories( $post_id );
  	$args['category__in'] = $post_categories;
  }

  $query = new WP_Query($args);
	wp_reset_postdata();
  return $query;
}


/* Portfolio */

// Portfolio: number of columns
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

/* Register Elementor Locations */
function goya_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );

}
add_action( 'elementor/theme/register_locations', 'goya_register_elementor_locations' );


/* Translatable strings filters */

add_filter( 'portfolio_all_translation', function(){ 
	return $text = esc_html__('All', 'goya' );
});

add_filter( 'share_translation', function(){ 
	return $text = esc_html__('Share', 'goya' );
});

/* WC Ajax Product Filter
 * Added here to make it easier to translate from goya.pot
 * instead of creating a new file for the plugin
*/

add_filter( 'wcapf_min_price_text', function(){ 
	return $text = esc_html__('Min Price:', 'goya' );
});

add_filter( 'wcapf_max_price_text', function(){ 
	return $text = esc_html__('Max Price:', 'goya' );
});

add_filter( 'wcapf_search_for_text', function(){ 
	return $text = esc_html__('Search For:', 'goya' );
});

add_filter( 'wcapf_order_by_text', function(){ 
	return $text = esc_html__('Order By:', 'goya' );
});

add_filter( 'wcapf_order_by_values', function(){ 
	return $val = array(
	  'popularity' => esc_html__( 'popularity', 'goya' ),
	  'rating'     => esc_html__( 'rating', 'goya' ),
	  'date'       => esc_html__( 'latest', 'goya' ),
	  'price'      => esc_html__( 'price low to high', 'goya' ),
	  'price-desc' => esc_html__( 'price high to low', 'goya' ),
	); 
});
