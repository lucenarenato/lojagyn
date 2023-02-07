<?php 

function goya_vc_templates_blogs($template_list) {
	$template_list['blog_section_01'] = array(
		'name' => esc_html__( 'Blog 1 - Grid', 'goya-core' ),
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/blog/blog-b1.jpg",
		'cat' => array( 'blogs' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" css=".vc_custom_1581055311709{padding-top: 60px !important;padding-bottom: 60px !important;background-color: #fdf2ed !important;}"][vc_column][vc_column_text animation="animation fade-in"]
			<h2 style="text-align: center;">Latest Articles</h2>
			<p style="text-align: center;">In an age when we have come to rely on our smartphones to tell us the time a renaissance of the classic wall clock.</p>
			[/vc_column_text][vc_row_inner][vc_column_inner][et_posts num_posts="6" animation="animation right-to-left"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner el_class="text-center"][et_button title="View All Posts" add_arrow="true" animation="animation bottom-to-top" style="outlined" align="center" link="title:View%20All%20Posts||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['blog_section_02'] = array(
		'name' => esc_html__( 'Blog 2 - Carousel', 'goya-core' ),
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/blog/blog-b2.jpg",
		'cat' => array( 'blogs' ),
		'sc' => '[vc_row css=".vc_custom_1581055122371{padding-top: 80px !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]
			<h2>Latest Articles</h2>
			[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1581055146832{margin-bottom: 40px !important;}"][vc_column_inner offset="vc_col-lg-8"][vc_column_text]
			<h4>Quisque tortor nulla, sollicitudin quis venenatis et, tincidunt placerat eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h4>
			[/vc_column_text][/vc_column_inner][vc_column_inner offset="vc_col-lg-4"][et_button title="View All" add_arrow="true" align="right" link="title:View%20All||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1581055114361{padding-bottom: 80px !important;}"][vc_column][et_posts style="carousel" columns="4" post_excerpt="1" animation="animation bottom-to-top"][/vc_column][/vc_row]',
	);
	$template_list['blog_section_03'] = array(
		'name' => esc_html__( 'Blog 3 - Masonry', 'goya-core' ),
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/blog/blog-b3.jpg",
		'cat' => array( 'blogs' ),
		'sc' => '[vc_row et_full_width="true" css=".vc_custom_1581100452801{padding-top: 80px !important;padding-bottom: 50px !important;background-color: #f2f2f2 !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]
			<h5 style="text-align: center;"><span class="fancy-title accent-color">Journal</span></h5>
			<h2 style="text-align: center;">Latest Fashion Trends</h2>
			<p style="text-align: center;">Quisque tortor nulla, sollicitudin quis venenatis et, tincidunt placerat eros.</p>
			[/vc_column_text][vc_empty_space height="20px"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][et_posts style="cards" animation="animation bottom-to-top"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['blog_section_04'] = array(
		'name' => esc_html__( 'Blog 4 - List', 'goya-core' ),
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/blog/blog-b4.jpg",
		'cat' => array( 'blogs' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" css=".vc_custom_1581183191293{padding-top: 80px !important;padding-bottom: 40px !important;background-color: #f7f3de !important;}"][vc_column][vc_row_inner et_column_align="align-center"][vc_column_inner el_class="text-center" offset="vc_col-lg-6 vc_col-md-9"][vc_column_text el_class="fancy-tag accent-color"]
			<h4 style="text-align: center;">The Blog</h4>
			[/vc_column_text][vc_column_text]
			<h2 style="text-align: center;">Quisque tortor nulla, sollicitudin quis venenatis</h2>
			[/vc_column_text][vc_empty_space height="20px"][/vc_column_inner][/vc_row_inner][vc_row_inner et_column_align="align-center" el_class="align-center"][vc_column_inner offset="vc_col-lg-9"][et_posts style="list"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['blog_section_05'] = array(
		'name' => esc_html__( 'Blog 5 - Dark', 'goya-core' ),
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/blog/blog-b5.jpg",
		'cat' => array( 'blogs' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" et_column_align="align-center" css=".vc_custom_1580664584309{padding-top: 80px !important;padding-bottom: 50px !important;background-color: #141414 !important;}"][vc_column et_column_color="et-light-column"][vc_row_inner et_column_align="align-center"][vc_column_inner][vc_column_text]
			<h1>Blog butcher master cleanse
			air plant vaporware.</h1>
			Leggings slow-carb bespoke cornhole kickstarter microdosing, forage kogi migas vice cronut man bun.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][et_posts style="cards"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	
	return $template_list;
}