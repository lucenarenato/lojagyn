<?php 

function goya_vc_templates_counters($template_list) {
	$template_list['counters_section_01'] = array(
		'name' => esc_html__( 'Counters Section', 'goya-core' ) . ' - 01',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/counters/counter-c1.jpg",
		'cat' => array( 'counters' ),
		'sc' => '[vc_row et_full_width="true" css=".vc_custom_1581102090030{margin-top: 120px !important;margin-bottom: 120px !important;padding-top: 80px !important;padding-bottom: 80px !important;background: #594e29 url(https://goyacdn.everthemes.com/demo-decor/wp-content/uploads/sites/2/2019/09/banner-harbour-chair.jpg?id=695) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][vc_row_inner][vc_column_inner et_column_color="et-light-column" width="1/3"][vc_empty_space height="30px"][et_counter icon_pixeden="pe-7s-map-marker" counter_color="#ffffff" counter="120" title="Stores" description="Number of stores around the world"][vc_empty_space height="30px"][/vc_column_inner][vc_column_inner et_column_color="et-light-column" width="1/3"][vc_empty_space height="30px"][et_counter icon_pixeden="pe-7s-gift" counter_color="#ffffff" icon_color="#ffffff" counter="450" title="Transactions" description="Completed orders per minute"][vc_empty_space height="30px"][/vc_column_inner][vc_column_inner et_column_color="et-light-column" width="1/3"][vc_empty_space height="30px"][et_counter icon_pixeden="pe-7s-user" counter_color="#ffffff" counter="12000" title="Customers" description="Happy customers"][vc_empty_space height="30px"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['counters_section_02'] = array(
		'name' => esc_html__( 'Counters Section', 'goya-core' ) . ' - 02',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/counters/counter-c2.jpg",
		'cat' => array( 'counters' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" parallax="content-moving" css=".vc_custom_1572985205014{padding-top: 100px !important;padding-bottom: 100px !important;background: #534737 url(https://goyacdn.everthemes.com/demo-decor/wp-content/uploads/sites/2/revslider/home-5/guy_and_leaves.jpg?id=673);background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column et_column_color="et-light-column"][vc_row_inner content_placement="middle" el_class="specialties"][vc_column_inner width="7/12"][vc_column_text]</p>
			<h5 class="fancy-tag accent-color">Designers</h5>
			<h2>Cornhole craft beer authentic,<br />
			hoodie hot chicken iceland</h2>
			<p>[/vc_column_text][et_button title="Apply Now" add_arrow="true" shadow="button-shadow" link="||" color="#ffffff" text_color="#000000"][/vc_column_inner][vc_column_inner width="5/12"][et_counter style="counter-left" counter="24" title="Locations" description="Selvage mlkshk health goth cred fanny pack banjo, tousled food truck fashion axe." counter_color="#ffffff"][et_counter style="counter-left" counter="2300" title="Orders" description="Poke DIY thundercats schlitz freegan tofu pok pok readymade." counter_color="#ffffff"][et_counter style="counter-left" counter="365" title="Up-Time" description="Kale chips jianbing four dollar toast activated charcoal, try-hard unicorn affogato" counter_color="#ffffff"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	$template_list['counters_section_03'] = array(
		'name' => esc_html__( 'Counters Section', 'goya-core' ) . ' - 03',
		'thumbnail' => GOYA_THEME_URI . "/assets/img/visual-composer/templates/counters/counter-c3.jpg",
		'cat' => array( 'counters' ),
		'sc' => '[vc_row et_full_width="true" et_row_padding="true" css=".vc_custom_1579745009383{padding-top: 60px !important;padding-bottom: 60px !important;}"][vc_column][vc_row_inner content_placement="middle" el_class="align-center"][vc_column_inner animation="animation left-to-right" offset="vc_col-md-7"][et_video_lightbox style="lightbox-image" box_shadow="large-shadow" video="https://youtu.be/1KahlicghaE" border_radius="3px" image="3832"][/vc_column_inner][vc_column_inner animation="animation right-to-left" offset="vc_col-md-5" css=".vc_custom_1578532669392{padding-top: 40px !important;}"][vc_column_text]
			<h5 class="fancy-title">Our History</h5>
			<h2>Setting Industry Standards</h2>
			Portland meggings chartreuse plaid palo santo, gluten-free ramps iPhone etsy salvia cray kombucha copper mug single-origin coffee.[/vc_column_text][et_counter style="counter-left" counter_color="dark" counter="12346" title="Customers" description="Satisfied customers worldwide and growing"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]',
	);
	return $template_list;
}