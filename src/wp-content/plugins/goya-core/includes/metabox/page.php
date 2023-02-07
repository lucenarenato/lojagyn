<?php

add_filter( 'rwmb_meta_boxes', 'goya_page_register_meta_boxes' );

function goya_page_register_meta_boxes( $meta_boxes ) {

	$prefix = 'goya_page_';

	$meta_boxes[] = array(
		'id' => 'et-post-page',
		'title' => 'Page Settings',
		'pages' => array( 'page' ),
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
				'name' => esc_html__('Page Title', 'goya-core' ),
				'id'   => $prefix . 'title_style',
				'class' => 'page-header-title',
				'type' => 'select',
				'options'  => array(
					'regular' => esc_html__('Regular Title', 'goya-core'),
					'hero'    => esc_html__('Hero Title', 'goya-core'),
					'hide'    => esc_html__('Hide Page Title', 'goya-core'),
				),
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
				'name' => esc_html__('Show Featured Image', 'goya-core' ),
				'desc' => esc_html__('Set featured image as title background.', 'goya-core' ),
				'class' => 'page-header-field page-hero-title hidden',
				'id'   => $prefix . 'hero_featured_image',
				'type' => 'switch',
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
				'name' => esc_html__('Page Sidebar Position/Status', 'goya-core' ),
				'id'   => $prefix . 'sidebar_position',
				'type' => 'select',
				'options'  => array(
					'disable'  => esc_html__('Disable on this page', 'goya-core'),
					'right' => esc_html__('Right', 'goya-core'),
					'left'  => esc_html__('Left', 'goya-core'),
				),
			),
			array(
				'name' => esc_html__('Page Background Color', 'goya-core' ),
				'desc' => esc_html__('Set background for the whole page.', 'goya-core' ),
				'id'   => $prefix . 'page_background',
				'type' => 'color',
			),
			array(
				'name' => esc_html__('Disable Footer', 'goya-core' ),
				'id'   => $prefix . 'disable_footer',
				'type' => 'switch',
			),
		)
	);

	return $meta_boxes;

}

?>