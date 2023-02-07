<?php

add_filter( 'rwmb_meta_boxes', 'goya_portfolio_register_meta_boxes' );

function goya_portfolio_register_meta_boxes( $meta_boxes ) {

	$prefix = 'goya_portfolio_';

	$meta_boxes[] = array(
		'id' => 'et-post-item',
		'title' => 'Archive Settings',
		'pages' => array( 'portfolio' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Hover Color', 'goya-core' ),
				'desc' => esc_html__('Set color for hover effect. Used on the Hover Card style.', 'goya-core' ),
				'id'   => $prefix . 'hover_color',
				'type' => 'color',
			),
			array(
				'name' => esc_html__('Masonry item size', 'goya-core' ),
				'desc' => esc_html__('Size of the item on the masonry portfolio mode.', 'goya-core' ),
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

	$meta_boxes[] = array(
		'id' => 'et-post-gallery',
		'title' => esc_html__('Portfolio Details', 'goya-core' ),
		'pages' => array( 'portfolio' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name'  => esc_html__('Featured Image', 'goya-core' ),
				'desc' => esc_html__('Add image to show on header. Used on the Parallax mode.', 'goya-core' ),
				'id' => $prefix . 'featured_gallery',
				'type' => 'image_advanced',
				'max_file_uploads' => 5,
			),
			array(
				'name'  => esc_html__('Date', 'goya-core' ),
				'id' => $prefix . 'date',
				'type' => 'date',
				'timestamp' => true,
			),
			array(
				'name'  => esc_html__('Author', 'goya-core' ),
				'id' => $prefix . 'author',
				'type' => 'text',
			),
			array(
				'name'  => esc_html__('Website', 'goya-core' ),
				'id' => $prefix . 'website',
				'type' => 'fieldset_text',
				'options' => array(
	        'text'    => 'Text',
	        'url' => 'URL',
		    ),
			),
		)
	);

	$meta_boxes[] = array(
		'id' => 'et-post-page',
		'title' => 'Page Settings',
		'pages' => array( 'portfolio' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Header', 'goya-core'),
		    'desc' => esc_html__('"Default" is the value defined in the Customizer.', 'goya-core' ),
			),
			array(
				'name' => esc_html__('Header Style', 'goya-core' ),
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
				'name' => esc_html__('Header Text Color', 'goya-core' ),
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
		    'name' => esc_html__('Title Options', 'goya-core'),
			),
			array(
				'name' => esc_html__('Title Layout', 'goya-core' ),
				'desc' => esc_html__('Override single portfolio layout.', 'goya-core' ),
				'id'   => $prefix . 'title_style',
				'class' => 'page-header-title',
				'type' => 'select',
				'options'  => array(
					false      => 'Default',
					'regular'  => 'Regular Title',
					'parallax' => 'Background Image',
					'hero'     => 'Hero Title',
					'hide'     => 'Hide Page Title'
				),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Title Text Color', 'goya-core' ),
				'id'   => $prefix . 'hero_title_style',
				'class' => 'page-header-field page-hero-title hidden',
				'type' => 'select',
				'options'  => array(
					'dark-title'  => esc_html__('Dark Text', 'goya-core'),
					'light-title' => esc_html__('Light Text', 'goya-core'),
				),
				'std'  => '',
			),
			array(
				'name' => esc_html__('Title Background', 'goya-core' ),
				'id'   => $prefix . 'hero_title_background',
				'class' => 'page-header-field page-hero-title hidden',
				'type' => 'color',
			),
			array(
		    'type' => 'heading',
		    'name' => esc_html__('Other options', 'goya-core'),
			),
			array(
				'name' => esc_html__('Page Background Color', 'goya-core' ),
				'desc' => esc_html__('Set background for the whole page.', 'goya-core' ),
				'id'   => $prefix . 'page_background',
				'type' => 'color',
			),

		)
	);

	return $meta_boxes;

}

?>