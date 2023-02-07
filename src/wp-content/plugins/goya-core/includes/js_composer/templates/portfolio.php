<?php 

function goya_vc_templates_portfolio($template_list) {

	$template_list['portfolio_01'] = array(
		'name' => esc_html__( 'Portfolio', 'goya-core' ) . ' - 01',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/portfolio/portfolio-p1.jpg",
		'cat' => array( 'Portfolio' ),
		'sc' => '[vc_row css=".vc_custom_1573104001055{padding-top: 40px !important;}"][vc_column][vc_column_text]
			<h5 style="text-align: center;"><span class="fancy-tag accent-color">v1</span></h5>
			<h1 style="text-align: center;">LookBook</h1>
			[/vc_column_text][et_portfolio portfolio_layout="list" alternate_cols="true" loadmore="true"][/vc_column][/vc_row]',
	);
	$template_list['portfolio_02'] = array(
		'name' => esc_html__( 'Portfolio', 'goya-core' ) . ' - 02',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/portfolio/portfolio-p2.jpg",
		'cat' => array( 'Portfolio' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" css=".vc_custom_1573103166876{padding-top: 140px !important;padding-bottom: 80px !important;background-color: #f9f2cf !important;}"][vc_column][vc_row_inner][vc_column_inner][vc_column_text]
			<h5 style="text-align: center;"><span class="fancy-tag accent-color">v2</span></h5>
			<h1 style="text-align: center;">LookBook</h1>
			[/vc_column_text][et_portfolio columns="3" item_style="overlay" animation="animation bottom-to-top" item_margins="no-padding" loadmore="true" category_navigation="true"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['portfolio_03'] = array(
		'name' => esc_html__( 'Portfolio', 'goya-core' ) . ' - 03',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/portfolio/portfolio-p3.jpg",
		'cat' => array( 'Portfolio' ),
		'sc' => '[vc_row css=".vc_custom_1573104160543{padding-top: 40px !important;}"][vc_column][vc_column_text]
			<h5><span class="fancy-tag accent-color">v3</span></h5>
			<h1>LookBook</h1>
			[/vc_column_text][et_portfolio portfolio_layout="masonry" item_style="hover-card" animation="animation bottom-to-top" loadmore="true" category_navigation="true"][/vc_column][/vc_row]',
	);
	$template_list['portfolio_04'] = array(
		'name' => esc_html__( 'Portfolio Single', 'goya-core' ) . ' - 04',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/portfolio/portfolio-p4.jpg",
		'cat' => array( 'Portfolio', 'page' ),
		'sc' => '[vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1573187171262{padding-top: 80px !important;padding-bottom: 80px !important;}"][vc_column animation="animation bottom-to-top" offset="vc_col-lg-offset-1 vc_col-lg-4" css=".vc_custom_1573187307217{padding-top: 160px !important;}"][vc_column_text el_class="preline-large" css=".vc_custom_1555605359722{margin-bottom: 80px !important;}"]
			<h1>Spring Blossom</h1>
			<h4>Spring/Summer 2019</h4>
			[/vc_column_text][et_image image="1400"][/et_image][/vc_column][vc_column et_column_color="et-light-column" animation="animation top-to-bottom" offset="vc_col-lg-offset-1 vc_col-lg-5"][et_banner text_position="h_center-v_bottom" text_color_scheme="light" hover_effect="hover-zoom" title="Mustache poutine chillwave cloud bread leggings sustainable." image_id="1395" text_padding="10"][/vc_column][/vc_row][vc_row et_row_padding="true" content_placement="middle" css=".vc_custom_1573185825319{margin-bottom: 80px !important;background-color: #578499 !important;}"][vc_column animation="animation left-to-right" offset="vc_col-lg-6"][et_image image="1397"][/et_image][/vc_column][vc_column et_column_color="et-light-column" animation="animation right-to-left" offset="vc_col-lg-offset-1 vc_col-lg-3" css=".vc_custom_1555606234336{padding-top: 160px !important;padding-bottom: 160px !important;}"][vc_column_text el_class="preline-large"]
			<h2>Mustache poutine chillwave cloud bread leggings sustainable.</h2>
			[/vc_column_text][/vc_column][/vc_row][vc_row et_full_width="true" et_row_padding="true" content_placement="bottom" css=".vc_custom_1555604844953{background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column offset="vc_col-lg-6"][et_image alignment="aligncenter" image="1402"][/et_image][/vc_column][vc_column offset="vc_col-lg-6"][et_banner text_position="h_center-v_bottom" text_color_scheme="light" hover_effect="hover-zoom" title="Mustache poutine chillwave cloud bread leggings sustainable." image_id="1403" text_padding="10"][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550614288{margin-top: 80px !important;margin-bottom: 80px !important;}" el_class="align-center"][vc_column offset="vc_col-lg-3"][vc_column_text css=".vc_custom_1555606366543{padding-left: 20% !important;}"]
			<h2>Mustache poutine chillwave cloud bread leggings sustainable.</h2>
			[/vc_column_text][/vc_column][vc_column width="1/2" animation="animation bottom-to-top" offset="vc_col-lg-offset-1 vc_col-lg-7"][et_image image="1399"][/et_image][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550285743{margin-top: 80px !important;margin-bottom: 80px !important;}"][vc_column animation="animation bottom-to-top" offset="vc_col-lg-4"][et_image image="1398"][/et_image][/vc_column][vc_column et_column_color="et-light-column" parallax="content-moving" animation="animation top-to-bottom" offset="vc_col-lg-offset-1 vc_col-lg-6" css=".vc_custom_1573185905585{padding-top: 80px !important;padding-bottom: 80px !important;}"][et_banner text_position="h_center-v_bottom" text_color_scheme="light" hover_effect="hover-zoom" title="Mustache poutine chillwave cloud bread leggings sustainable." image_id="1396" text_padding="10"][/vc_column][/vc_row][vc_row et_full_width="true" et_row_padding="true" parallax="content-moving" css=".vc_custom_1573186352095{background: #c4c4cd url(https://goya.everthemes.com/demo-fashion/wp-content/uploads/sites/3/2019/04/look-country8.jpg?id=1402);}"][vc_column animation="animation bottom-to-top"][vc_row_inner content_placement="bottom" css=".vc_custom_1555559817958{padding-top: 400px !important;padding-bottom: 80px !important;}"][vc_column_inner et_column_color="et-light-column" offset="vc_col-md-6"][vc_column_text el_class="preline-large"]
			<h2>Man bun helvetica palo santo vape organic iPhone mlkshk vinyl.</h2>
			[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550614288{margin-top: 80px !important;margin-bottom: 80px !important;}" el_class="align-center"][vc_column width="1/2" animation="animation bottom-to-top" offset="vc_col-lg-offset-1 vc_col-lg-6"][et_image image="1442"][/et_image][/vc_column][vc_column offset="vc_col-lg-3"][vc_column_text css=".vc_custom_1555606366543{padding-left: 20% !important;}"]
			<h2>Mustache poutine chillwave cloud bread leggings sustainable.</h2>
			[/vc_column_text][/vc_column][/vc_row][vc_row et_full_width="true" et_row_padding="true" content_placement="middle" css=".vc_custom_1573186039325{margin-top: 80px !important;margin-bottom: 80px !important;background-color: #67924b !important;}"][vc_column animation="animation left-to-right" offset="vc_col-lg-6"][et_image image="1395"][/et_image][/vc_column][vc_column et_column_color="et-light-column" animation="animation right-to-left" offset="vc_col-lg-offset-1 vc_col-lg-3" css=".vc_custom_1555606234336{padding-top: 160px !important;padding-bottom: 160px !important;}"][vc_column_text]
			<h2>Mustache poutine chillwave cloud bread leggings sustainable.</h2>
			[/vc_column_text][et_button title="But the look" style="outlined rounded" add_arrow="true" size="lg" animation="animation bottom-to-top" link="url:https%3A%2F%2Fgoya.everthemes.com%2Fdemo%2Fshop%2F|title:Shop||" color="#ffffff"][/vc_column][/vc_row][vc_row][vc_column][et_product_slider product_sort="latest-products" item_count="6"][/vc_column][/vc_row]',
	);
	$template_list['portfolio_05'] = array(
		'name' => esc_html__( 'Portfolio Single', 'goya-core' ) . ' - 05',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/portfolio/portfolio-p5.jpg",
		'cat' => array( 'Portfolio', 'page' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" parallax="content-moving" css=".vc_custom_1573183598907{background: #fff18a url(https://goya.everthemes.com/demo-fashion/wp-content/uploads/sites/3/2019/04/look-natural1.jpg?id=1319);background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner css=".vc_custom_1555563750524{padding-top: 100vh !important;padding-bottom: 160px !important;}"][vc_column_text el_class="preline-large"]
			<h1>Natural Colors</h1>
			<h4>Spring/Summer 2019</h4>
			[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550285743{margin-top: 80px !important;margin-bottom: 80px !important;}"][vc_column animation="animation left-to-right" offset="vc_col-lg-7"][et_image animation="animation bottom-to-top" image="1310"][/et_image][/vc_column][vc_column animation="animation right-to-left" offset="vc_col-lg-5"][et_image animation="animation bottom-to-top" image="1309"][/et_image][vc_empty_space][vc_column_text css=".vc_custom_1555550157042{padding-right: 20% !important;}"]
			<h4>Vice enamel pin hot chicken pop-up, mustache poutine chillwave cloud bread leggings XOXO sustainable.</h4>
			[/vc_column_text][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550285743{margin-top: 80px !important;margin-bottom: 80px !important;}"][vc_column animation="animation left-to-right" offset="vc_col-lg-offset-1 vc_col-lg-6"][et_image animation="animation bottom-to-top" image="1308"][/et_image][/vc_column][vc_column animation="animation right-to-left" offset="vc_col-lg-5"][vc_column_text css=".vc_custom_1555550736259{padding-right: 20% !important;}" el_class="preline-large"]
			<h4>Vice enamel pin hot chicken pop-up, mustache poutine chillwave cloud bread leggings XOXO sustainable.</h4>
			[/vc_column_text][vc_empty_space][et_product_slider product_sort="by-category" cat="men" item_count="2" columns="2" scroll="1"][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550285743{margin-top: 80px !important;margin-bottom: 80px !important;}"][vc_column animation="animation right-to-left" offset="vc_col-lg-5"][et_image animation="animation bottom-to-top" image="1312"][/et_image][vc_empty_space][vc_column_text css=".vc_custom_1555550157042{padding-right: 20% !important;}"]
			<h4>Vice enamel pin hot chicken pop-up, mustache poutine chillwave cloud bread leggings XOXO sustainable.</h4>
			[/vc_column_text][/vc_column][vc_column animation="animation left-to-right" offset="vc_col-lg-7"][et_image animation="animation bottom-to-top" image="1307"][/et_image][/vc_column][/vc_row][vc_row et_full_width="true" et_row_padding="true" css=".vc_custom_1555564042192{padding-top: 80px !important;padding-bottom: 80px !important;background-color: #fffbe0 !important;}"][vc_column][vc_row_inner][vc_column_inner][et_product_slider product_sort="latest-products" item_count="6"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row et_full_width="true" content_placement="middle" css=".vc_custom_1555550614288{margin-top: 80px !important;margin-bottom: 80px !important;}" el_class="align-center"][vc_column animation="animation bottom-to-top" offset="vc_col-lg-7"][et_image animation="animation bottom-to-top" image="1311"][/et_image][/vc_column][/vc_row]',
	);
	
	return $template_list;
}