<?php

add_filter( 'rwmb_meta_boxes', 'goya_product_register_meta_boxes' );

function goya_product_register_meta_boxes( $meta_boxes ) {

	$prefix = 'goya_product_';

	$meta_boxes[] = array(
		'id' => 'et-product-content',
		'title' => 'Extra Content',
		'pages' => array( 'product' ),
		'context' => 'advanced',
		'priority' => 'high',
		'fields' => array(
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Video', 'goya-core'),
				'desc' => esc_html__('Local .mp4 video has priority', 'goya-core' ),
			),
			array(
				'name' => esc_html__('Remote video URL', 'goya-core' ),
				'desc' => esc_html__('Enter a YouTube, Vimeo or .mp4 URL', 'goya-core' ),
				'id'   => $prefix . 'featured_video',
				'type'  => 'text',
				'std' => '',
				'size' => '50'
			),
			array(
				'name' => esc_html__('Or upload .mp4 video', 'goya-core' ),
				'id'   => $prefix . 'featured_video_local',
				'type'  => 'video',
			),
			array(
				'name' => esc_html__('Vertical Video', 'goya-core' ),
				'desc' => esc_html__('100% height lightbox', 'goya-core' ),
				'id'   => $prefix . 'featured_video_vertical',
				'type'  => 'switch',
			),
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Size Guide', 'goya-core' ),
		    'desc' => esc_html__('Show the size guide on this product overriding global settings.', 'goya-core' ),
			),
			array(
				'name' => esc_html__('Link Page', 'goya-core' ),
				'id' => $prefix . 'sizing_guide',
				'type'        => 'post',
				'post_type'   => 'page',
				'field_type'  => 'select_advanced',
				'placeholder' => 'Select page',
				'query_args'  => array(
	        'post_status'    => 'publish',
	        'posts_per_page' => - 1,
		    ),
			),
	        
	  )
	);


	$meta_boxes[] = array(
		'id' => 'et-product-layout',
		'title' => 'Layout Settings',
		'pages' => array( 'product' ),
		'context' => 'advanced',
		'priority' => 'high',
		'fields' => array(
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Header', 'goya-core'),
			),
			array(
				'name' => esc_html__('Transparent Header', 'goya-core' ),
				'id'   => $prefix . 'transparent_header',
				'class' => 'page-header-layout',
				'type' => 'select',
				'options'  => array(
					false         => esc_html__('Default', 'goya-core'),
					'transparent' => esc_html__('Transparent', 'goya-core'),
				),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Main Header Color', 'goya-core' ),
				'desc' => esc_html__('Select header color mode for this page (if the header is transparent).', 'goya-core' ),
				'id'   => $prefix . 'header_style',
				'class' => 'page-header-field page-header-style hidden',
				'type' => 'select',
				'options'  => array(
					'dark-title'  => esc_html__('Dark Text', 'goya-core'),
					'light-title' => esc_html__('Light Text', 'goya-core'),
				),
				'std'  => '',
			),
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Product Info', 'goya-core'),
		    'desc' => esc_html__('Area on top with gallery, name and cart button', 'goya-core'),
			),
			array(
				'name' => esc_html__('Product Info Background', 'goya-core' ),
				'desc' => esc_html__('Override background for product info (Globally defined in Customizer).', 'goya-core' ),
				'id'   => $prefix . 'showcase_background',
				'type' => 'color',
			),
			array(
				'name' => esc_html__('Product Info Color Style', 'goya-core' ),
				'desc' => esc_html__('Select header color mode for Product Info.', 'goya-core' ),
				'id'   => $prefix . 'showcase_style',
				'type' => 'select',
				'options'  => array(
					false        => esc_html__('Default', 'goya-core'),
					'dark-text'  => esc_html__('Dark Text', 'goya-core'),
					'light-text' => esc_html__('Light Text', 'goya-core'),
				),
				'std'  => '',
			),
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Layout', 'goya-core'),
		    'desc' => esc_html__('"Default" is the value defined in the Customizer.', 'goya-core' ),
			),
			array(
				'name' => esc_html__('Product Layout', 'goya-core' ),
				'desc' => esc_html__('Override layout style.', 'goya-core' ),
				'id'   => $prefix . 'layout_single',
				'type' => 'select',
				'options'  => array(
					false        => esc_html__('Default', 'goya-core'),
					'regular'    => esc_html__('Regular', 'goya-core'),
					'showcase'   => esc_html__('Showcase', 'goya-core'),
					'no-padding' => esc_html__('No Padding', 'goya-core'),
					'full-width' => esc_html__('Full Width', 'goya-core'),
				),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Gallery Style', 'goya-core' ),
				'desc' => esc_html__('Override gallery style.', 'goya-core' ),
				'id'   => $prefix . 'gallery_style',
				'type' => 'select',
				'options'  => array(
					false      => esc_html__('Default', 'goya-core'),
					'carousel' => esc_html__('Carousel', 'goya-core'),
					'column'   => esc_html__('Column', 'goya-core'),
					'grid'     => esc_html__('Grid', 'goya-core'),
				),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Details Style', 'goya-core' ),
				'id'   => $prefix . 'details_style',
				'desc' => esc_html__('Override product details style.', 'goya-core' ),
				'type' => 'select',
				'options'  => array(
					false       => esc_html__('Default', 'goya-core'),
					'tabs'      => esc_html__('Tabs', 'goya-core'),
					'accordion' => esc_html__('Accordion', 'goya-core'),
					'vertical'  => esc_html__('Vertical', 'goya-core'),
		    ),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Description Width', 'goya-core' ),
				'id'   => $prefix . 'description_layout',
				'type' => 'select',
				'options'  => array(
					false   => esc_html__('Default', 'goya-core'),
					'boxed' => esc_html__('Boxed', 'goya-core'),
					'full'  => esc_html__('Full Width', 'goya-core'),
		    ),
				'std'  => '',
			),
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Item Style', 'goya-core'),
		    'desc' => esc_html__('Style for Masonry Products element', 'goya-core' ),
			),
			array(
				'name' => esc_html__('Masonry item size', 'goya-core' ),
				'desc' => esc_html__('Used in some views with masonry layout.', 'goya-core' ),
				'id'   => $prefix . 'masonry_size',
				'type' => 'image_select',
				'options'  => array(
					'small'  => get_template_directory_uri() . '/assets/img/admin/options/masonry-small.png',
					'large'  => get_template_directory_uri() . '/assets/img/admin/options/masonry-large.png',
					'horizontal' => get_template_directory_uri() . '/assets/img/admin/options/masonry-horizontal.png',
					'vertical'  => get_template_directory_uri() . '/assets/img/admin/options/masonry-vertical.png',
				),
				'std'  => '',
			),
	        
	  )
	);

return $meta_boxes;

}

?>