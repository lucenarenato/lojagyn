<?php
function goya_register_sidebars() {

	/* Blog Sidebar */

	register_sidebar(array(
		'id' => 'blog',
		'name' => esc_html__('Blog Sidebar', 'goya' ),
		'description' => esc_html__('Blog home/category sidebar', 'goya' ),
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));
		
	/* Single Post Sidebar */

	register_sidebar(array(
		'id' => 'single',
		'name' => esc_html__('Post Sidebar', 'goya' ),
		'description'   => esc_html__('Single post sidebar', 'goya' ),
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));

	/* Page Sidebar */

	register_sidebar(array(
		'id' => 'page',
		'name' => esc_html__('Page Sidebar', 'goya' ),
		'description'   => esc_html__('Must be enabled per page. Otherwise, pages don\'t display the sidebar', 'goya' ),
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));

	/* Mobile Sidebar */

	register_sidebar(array(
		'id' => 'offcanvas-menu', 
		'name' => esc_html__('Off-Canvas Menu Panel', 'goya' ),
		'description'   => esc_html__('Displayed under menu in off canvas panel', 'goya' ),
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));

	/* Shop Sidebar */
	if ( goya_wc_active() ) {

		register_sidebar(array(
			'id' => 'widgets-shop',
			'name' => esc_html__( 'Shop Sidebar', 'goya' ),
			'description' => esc_html__('Shop sidebar (top, side, offcanvas)', 'goya' ),
			'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
			'after_widget' => '</div>',
		));
	}

	/* Footer Widgets Sidebar */

	register_sidebar(array(
		'name' => esc_html__('Footer - Column 1', 'goya'),
		'id' => 'footer1',
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));
	
	register_sidebar(array(
		'name' => esc_html__('Footer - Column 2', 'goya'),
		'id' => 'footer2',
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer - Column 3', 'goya'),
		'id' => 'footer3',
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));

	register_sidebar(array(
		'name' => esc_html__('Footer - Column 4', 'goya'),
		'id' => 'footer4',
		'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
		'after_widget' => '</div>',
	));
	
}

add_action( 'widgets_init', 'goya_register_sidebars' );