<?php
include( GOYA_VC_DIR . '/templates/about.php');
include( GOYA_VC_DIR . '/templates/blogs.php');
include( GOYA_VC_DIR . '/templates/counters.php');
include( GOYA_VC_DIR . '/templates/cta.php');
include( GOYA_VC_DIR . '/templates/hero.php');
include( GOYA_VC_DIR . '/templates/homepage.php');
include( GOYA_VC_DIR . '/templates/icons.php');
include( GOYA_VC_DIR . '/templates/maps.php');
include( GOYA_VC_DIR . '/templates/pages.php');
include( GOYA_VC_DIR . '/templates/portfolio.php');
include( GOYA_VC_DIR . '/templates/services.php');
include( GOYA_VC_DIR . '/templates/sliders.php');

/* Render Templates Page */
add_filter( 'vc_templates_render_category', 'goya_vc_template_block', 10 );
function goya_vc_template_block( $category ) {
	
	$Goya_Panel_Editor = new Vc_Templates_Panel_Editor;
	if ( 'et_templates' === $category['category'] ) {
		ob_start();
		?>
		<div class="et_templates_container vc_column vc_col-sm-12">
			<div class="et_notice">
				<h3><?php esc_html_e('Append template elements to your page', 'goya-core' ); ?></h3>
				<ul class="vc_description">
					<li><?php esc_html_e('Elements may show placeholders and need further configuration. Fonts and colors are taken from your customizer settings.', 'goya-core' ); ?></li>
					</ul>
			</div>
			<div class="theme-browser wp-clearfix">
			<?php foreach ($category['templates'] as $key => $template) { ?>
				<div class="et_template theme <?php echo strtolower(implode(' ', $template['cat'])); ?>">
					<div class="theme-screenshot">
						<img src="<?php echo esc_url($template['thumbnail']); ?>" alt="<?php echo esc_attr($template['name']); ?>"/>
					</div>
					<h2 class="theme-name template_name"><?php echo esc_attr($template['name']); ?></h2>
					<div class="theme-actions">
		 					<a class="button button-primary et_template_import" data-et-id="<?php echo esc_attr($key); ?>"><?php esc_html_e('Add', 'goya-core' ); ?></a>
		 			</div>
				</div>
			<?php } ?>
			</div>
		</div>
		<div class="et_templates_cat">
			<ul>
				<li data-sort="all" class="active">All<span class="count">-</span></li>
				<li data-sort="homepage">Home Pages<span class="count">-</span></li>
				<li data-sort="page" class="">Full Pages<span class="count">-</span></li>
				<li data-sort="about" class="">About<span class="count">-</span></li>
				<li data-sort="blogs" class="">Blog<span class="count">-</span></li>
				<li data-sort="counters" class="">Counters<span class="count">-</span></li>
				<li data-sort="cta" class="">CTA<span class="count">-</span></li>
				<li data-sort="hero" class="">Hero<span class="count">-</span></li>
				<li data-sort="icons" class="">Icons<span class="count">-</span></li>
				<li data-sort="maps" class="">Maps<span class="count">-</span></li>
				<li data-sort="portfolio" class="">Portfolios<span class="count">-</span></li>
				<li data-sort="services" class="">Services<span class="count">-</span></li>
				<li data-sort="sliders" class="">Sliders<span class="count">-</span></li>
			</ul>
		</div>
		<?php
		$category['output'] = ob_get_clean();
	}
	
	return $category;
}

/* Add Template Category & its templates */
add_filter( 'vc_get_all_templates', 'goya_vc_templates' );
function goya_vc_templates( $data ) {
	$et_template_category = array(
		'category' => 'et_templates',
		'category_name' => 	esc_html__('Goya', 'goya-core' ),
		'category_description' => esc_html__('Goya specific demo layouts', 'goya-core' ),
		'category_weight' => 1,
		'templates' => goya_template_get_list()
	);
	$data[] = $et_template_category;
	return $data;
}

/* Ajax Action */
function goya_load_vc_template() {
	$id = isset($_POST['template_unique_id']) ? wp_unslash($_POST['template_unique_id']) : false;
	
  $template = goya_template_get_list($id);
  echo wp_kses_post( $template['sc'] );
	wp_die();
}

/* Template List */
function goya_template_get_list( $id = false) {
	$template_list = array();
	
	$template_list = goya_vc_templates_homepage($template_list);
	$template_list = goya_vc_templates_pages($template_list);
	$template_list = goya_vc_templates_portfolio($template_list);
	$template_list = goya_vc_templates_about($template_list);
	$template_list = goya_vc_templates_blogs($template_list);
	$template_list = goya_vc_templates_counters($template_list);
	$template_list = goya_vc_templates_cta($template_list);
	$template_list = goya_vc_templates_hero($template_list);
	$template_list = goya_vc_templates_icons($template_list);
	$template_list = goya_vc_templates_maps($template_list);
	$template_list = goya_vc_templates_services($template_list);
	$template_list = goya_vc_templates_sliders($template_list);
	
	if ( $id ) {
		return $template_list[$id];
	}
	return $template_list;
}