<?php

// Customizer / WP Methods

function goya_kirki_config_style( $config ) {
	return wp_parse_args( array(
		'disable_loader' => true,
	), $config );
}
add_filter( 'kirki_config', 'goya_kirki_config_style' );

$sep = 0;

// Animations array
$goya_animations_list = array(
	''                           => esc_html__('None', 'goya'),
	'animation right-to-left'    => esc_html__('Right to Left', 'goya'),
	'animation left-to-right'    => esc_html__('Left to Right', 'goya'),
	'animation right-to-left-3d' => esc_html__('Right to Left - 3D', 'goya'),
	'animation left-to-right-3d' => esc_html__('Left to Right - 3D', 'goya'),
	'animation bottom-to-top'    => esc_html__('Bottom to Top', 'goya'),
	'animation top-to-bottom'    => esc_html__('Top to Bottom', 'goya'),
	'animation bottom-to-top-3d' => esc_html__('Bottom to Top - 3D', 'goya'),
	'animation top-to-bottom-3d' => esc_html__('Top to Bottom - 3D', 'goya'),
	'animation scale'            => esc_html__('Scale', 'goya'),
	'animation fade'             => esc_html__('Fade', 'goya'),
);

// Replace bundled Jost with Google version
$main_font = get_theme_mod( 'main_font', array() );
$main_font_family = isset($main_font['font-family']) ? $main_font['font-family'] : '';

$second_font = get_theme_mod( 'second_font', array() );
$second_font_family = isset($second_font['font-family']) ? $second_font['font-family'] : '';

if ($main_font_family == 'Jost, sans-serif') {
	set_theme_mod( 'main_font' , array(
		'font-family'    => 'Jost',
		)
	);	
}
if ($second_font_family == 'Jost, sans-serif') {
	set_theme_mod( 'second_font' , array(
		'font-family'    => 'Jost',
		)
	);	
}

// Migrate campaign to new version
/*$old_campaign = get_theme_mod( 'campaign_bar_content', '' );
if (!empty($old_campaign)) {
	set_theme_mod( 'campaign_bar_items' , array(
			array(
				'campaign_text'    => strip_tags($old_campaign),
			)
		)
	);	
}*/

// Google fonts lists
function goya_main_font_choices() {
	return apply_filters( 'goya_main_font_choices', array(
		'fonts' => array(
			'google'  => array( 'popularity', 700 ),
		),
	) );
}

function goya_second_font_choices() {
	return apply_filters( 'goya_second_font_choices', array(
		'fonts' => array(
			'google'  => array( 'popularity', 700 ),
		),
	) );
}


function goya_social_media_icons() {
	return apply_filters( 'goya_social_media_icons', array(
		''           => esc_html__( '', 'goya' ),
		'facebook'   => esc_html__( 'Facebook', 'goya' ),
		'twitter'    => esc_html__( 'Twitter', 'goya' ),
		'instagram'  => esc_html__( 'Instagram', 'goya' ),
		'googleplus' => esc_html__( 'Google+', 'goya' ),
		'pinterest'  => esc_html__( 'Pinterest', 'goya' ),
		'linkedin'   => esc_html__( 'LinkedIn', 'goya' ),
		'rss'        => esc_html__( 'RSS', 'goya' ),
		'email'      => esc_html__( 'Email', 'goya' ),
		'tumblr'     => esc_html__( 'Tumblr', 'goya' ),
		'youtube'    => esc_html__( 'Youtube', 'goya' ),
		'vimeo'      => esc_html__( 'Vimeo', 'goya' ),
		'behance'    => esc_html__( 'Behance', 'goya' ),
		'dribbble'   => esc_html__( 'Dribbble', 'goya' ),
		'flickr'     => esc_html__( 'Flickr', 'goya' ),
		'github'     => esc_html__( 'GitHub', 'goya' ),
		'skype'      => esc_html__( 'Skype', 'goya' ),
		'whatsapp'   => esc_html__( 'WhatsApp', 'goya' ),
		'telegram'   => esc_html__( 'Telegram', 'goya' ),
		'snapchat'   => esc_html__( 'Snapchat', 'goya' ),
		'wechat'     => esc_html__( 'WeChat', 'goya' ),
		'weibo'      => esc_html__( 'Weibo', 'goya' ),
		'foursquare' => esc_html__( 'Foursquare', 'goya' ),
		'soundcloud' => esc_html__( 'Soundcloud', 'goya' ),
		'vk'         => esc_html__( 'VK', 'goya' ),
		'tiktok'     => esc_html__( 'TikTok', 'goya' ),
		'phone'      => esc_html__( 'Phone', 'goya' ),
		'map-marker' => esc_html__( 'Map Pin', 'goya' ),
		'spotify'    => esc_html__( 'Spotify', 'goya' ),
	) );
}

function goya_topbar_elements_list() {
	return apply_filters( 'goya_topbar_elements_list', array(
		'menu'     => esc_html__( 'Menu Top Bar', 'goya' ),
		'currency' => esc_html__( 'Currency Selector', 'goya' ),
		'language' => esc_html__( 'Language Selector', 'goya' ),
		'social'   => esc_html__( 'Social Icons', 'goya' ),
		'text'     => esc_html__( 'Text 1', 'goya' ),
		'text2'    => esc_html__( 'Text 2', 'goya' ),
		'text3'    => esc_html__( 'Text 3', 'goya' ),
		'search'         => esc_html__( 'Search Icon', 'goya' ),
		'search-box'     => esc_html__( 'Search Box', 'goya' ),	
		'cart'           => esc_html__( 'Cart Icon', 'goya' ),
		'hamburger'      => esc_html__( 'Hamburger Icon', 'goya' ),
		'wishlist'       => esc_html__( 'Wishlist Icon', 'goya' ),
		'account'       => esc_html__( 'Account Link', 'goya' ),
	) );
}

function goya_header_elements_list() {
	return apply_filters( 'goya_header_elements_list', array(
		'logo'           => esc_html__( 'Logo', 'goya' ),
		'account'        => esc_html__( 'Account Link', 'goya' ),
		'cart'           => esc_html__( 'Cart Icon', 'goya' ),
		'currency'       => esc_html__( 'Currency Selector', 'goya' ),
		'hamburger'      => esc_html__( 'Hamburger Icon', 'goya' ),
		'language'       => esc_html__( 'Language Selector', 'goya' ),
		'menu-primary'   => esc_html__( 'Menu Primary', 'goya' ),
		'menu-secondary' => esc_html__( 'Menu Secondary', 'goya' ),
		'search'         => esc_html__( 'Search Icon', 'goya' ),
		'search-box'     => esc_html__( 'Search Box', 'goya' ),	
		'social'         => esc_html__( 'Social Icons', 'goya' ),
		'text'           => esc_html__( 'Text 1', 'goya' ),
		'text2'          => esc_html__( 'Text 2', 'goya' ),
		'text3'          => esc_html__( 'Text 3', 'goya' ),
		'wishlist'       => esc_html__( 'Wishlist Icon', 'goya' ),
	) );
}

function goya_footer_elements_list() {
	return apply_filters( 'goya_footer_elements_list', array(
		'copyright'         => esc_html__( 'Copyright', 'goya' ),
		'currency'          => esc_html__( 'Currency Selector', 'goya' ),
		'currency_language' => esc_html__( 'Currency & Language Selector', 'goya' ),
		'language'          => esc_html__( 'Language Selector', 'goya' ),
		'menu'              => esc_html__( 'Menu Footer', 'goya' ),
		'social'            => esc_html__( 'Social Icons', 'goya' ),
		'text'              => esc_html__( 'Text 1', 'goya' ),
		'text2'             => esc_html__( 'Text 2', 'goya' ),
	) );
}
function goya_mobile_header_elements_list() {
	return apply_filters( 'goya_mobile_header_elements_list', array(
		'cart'     => esc_html__( 'Cart', 'goya' ),
		'account'  => esc_html__( 'Account', 'goya' ),
		'search'   => esc_html__( 'Search', 'goya' ),
		'wishlist' => esc_html__( 'Wishlist', 'goya' ),
		'currency' => esc_html__( 'Currency Selector', 'goya' ),
		'language' => esc_html__( 'Language Selector', 'goya' ),
		'text'     => esc_html__( 'Text 1', 'goya' ),
	) );
}

function goya_vertical_bar_elements_list() {
	return apply_filters( 'goya_vertical_bar_elements_list', array(
		'cart'     => esc_html__( 'Cart', 'goya' ),
		'account'  => esc_html__( 'Account', 'goya' ),
		'search'   => esc_html__( 'Search', 'goya' ),
		'wishlist' => esc_html__( 'Wishlist', 'goya' ),
	) );
}

function goya_mobile_menu_elements_list() {
	return apply_filters( 'goya_mobile_menu_elements_list', array(
		'cart'     => esc_html__( 'Cart', 'goya' ),
		'account'  => esc_html__( 'Account', 'goya' ),
		'currency' => esc_html__( 'Currency Selector', 'goya' ),
		'language' => esc_html__( 'Language Selector', 'goya' ),
		'social'   => esc_html__( 'Social Icons', 'goya' ),
		'wishlist' => esc_html__( 'Wishlist', 'goya' ),
		'text'           => esc_html__( 'Text 1', 'goya' ),
		'text2'          => esc_html__( 'Text 2', 'goya' ),
		'text3'          => esc_html__( 'Text 3', 'goya' ),
		'divider1' => '––––––',
		'divider2' => '––––––',
		'divider3' => '––––––',
		'divider4' => '––––––',
	) );
}

add_action( 'customize_register','goya_customizer' );
function goya_customizer( $wp_customize ) {

	// Add Panels
	$wp_customize->add_panel( 'panel_general', array(
		'title'          => esc_html__( 'General', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_style', array(
		'title'          => esc_html__( 'Theme Styles', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_header', array(
		'title'          => esc_html__( 'Header', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_footer', array(
		'title'          => esc_html__( 'Footer', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_shop', array(
		'title'          => esc_html__( 'Shop', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_product', array(
		'title'          => esc_html__( 'Single Product', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_blog', array(
		'title'          => esc_html__( 'Blog', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	$wp_customize->add_panel( 'panel_portfolio', array(
		'title'          => esc_html__( 'Portfolio', 'goya' ),
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
	) );
	
}


if ( class_exists( 'Kirki' ) ) {

	/* Configs */

	Kirki::add_config( 'goya_config', array(
		'gutenberg_support' => true,
		'capability'        => 'edit_theme_options',
		'option_type'       => 'theme_mod',
	) );

	
	/* Sections */

	Kirki::add_section( 'general_settings', array(
		'title'          => esc_html__('General Settings', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_general',
	) );

	Kirki::add_section( 'social_media', array(
		'title'          => esc_html__( 'Social Media', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_general',
	) );

	Kirki::add_section( 'popup', array(
		'title'          => esc_html__( 'Popup', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_general',
	) );

	Kirki::add_section( 'apis', array(
		'title'          => esc_html__( 'Keys & APIs', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_general',
	) );

	Kirki::add_section( 'language_selector', array(
		'title'          => esc_html__( 'Language Selector', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_general',
	) );

	Kirki::add_section( 'header_layout', array(
		'title'          => esc_html__('Header Layout', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_logo', array(
		'title'          => esc_html__( 'Logo', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_logo_size', array(
		'title'          => esc_html__('Header/Logo Size', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_elements', array(
		'title'          => esc_html__( 'Header Icons', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'top_bar', array(
		'title'          => esc_html__( 'Top Bar', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'campaign', array(
		'title'          => esc_html__( 'Campaign Bar', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_main_menu', array(
		'title'          => esc_html__('Main Menu Options', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_offcanvas_desktop', array(
		'title'          => esc_html__('Off-canvas Desktop', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_vertical_bar', array(
		'title'          => esc_html__('Vertical Icons Bar', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_mobile', array(
		'title'          => esc_html__( 'Mobile Header', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'header_menu_mobile', array(
		'title'          => esc_html__('Mobile Menu', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_header',
	) );

	Kirki::add_section( 'footer_setting', array(
		'title'          => esc_html__( 'Footer Main', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_footer',
	) );

	Kirki::add_section( 'footer_extra', array(
		'title'          => esc_html__( 'Footer Extra', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_footer',
	) );

	Kirki::add_section( 'footer_bottom', array(
		'title'          => esc_html__( 'Footer Bottom', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_footer',
	) );

	Kirki::add_section( 'footer_colors', array(
		'title'          => esc_html__( 'Footer Colors', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_footer',
	) );

	Kirki::add_section( 'footer_mobile', array(
		'title'          => esc_html__( 'Mobile', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_footer',
	) );

	Kirki::add_section( 'blog_list', array(
		'title'          => esc_html__( 'Blog Main', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_blog',
	) );

	Kirki::add_section( 'blog_categories', array(
		'title'          => esc_html__( 'Categories Menu', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_blog',
	) );

	Kirki::add_section( 'blog_single', array(
		'title'          => esc_html__( 'Single Post', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_blog',
	) );

	Kirki::add_section( 'blog_related', array(
		'title'          => esc_html__( 'Related Posts', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_blog',
	) );

	Kirki::add_section( 'shop_general', array(
		'title'          => esc_html__( 'Shop General', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_header', array(
		'title'          => esc_html__( 'Shop Header', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_listing', array(
		'title'          => esc_html__( 'Products Catalog', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_filters', array(
		'title'          => esc_html__( 'Sidebar Filters', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_variations', array(
		'title'          => esc_html__( 'Variations/Swatches', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'minicart_panel', array(
		'title'          => esc_html__( 'Mini Cart', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_quickview', array(
		'title'          => esc_html__( 'Quick View', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'checkout', array(
		'title'          => esc_html__( 'Cart / Checkout', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_progress_bar', array(
		'title'          => esc_html__( 'Progress Bar', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'shop_mobile', array(
		'title'          => esc_html__( 'Mobile', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_shop',
	) );

	Kirki::add_section( 'product_layout', array(
		'title'          => esc_html__( 'Product Layout', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );
	
	Kirki::add_section( 'product_gallery', array(
		'title'          => esc_html__( 'Product Gallery', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );

	Kirki::add_section( 'product_elements', array(
		'title'          => esc_html__( 'Product Page Elements', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );

	Kirki::add_section( 'product_size', array(
		'title'          => esc_html__( 'Size Guide', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );

	Kirki::add_section( 'product_related', array(
		'title'          => esc_html__( 'Related Products', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );

	Kirki::add_section( 'product_mobile', array(
		'title'          => esc_html__( 'Mobile', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_product',
	) );

	Kirki::add_section( 'portfolio_main', array(
		'title'          => esc_html__( 'Portfolio Main', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_portfolio',
	) );

	Kirki::add_section( 'portfolio_single', array(
		'title'          => esc_html__( 'Single Portfolio', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_portfolio',
	) );

	Kirki::add_section( 'styling', array(
		'title'          => esc_html__( 'Global Colors', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_style',
	) );

	Kirki::add_section( 'header_styles', array(
		'title'          => esc_html__('Header Colors', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_style',
	) );

	Kirki::add_section( 'shop_styles', array(
		'title'          => esc_html__( 'Shop Colors', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_style',
	) );

	Kirki::add_section( 'form_styles', array(
		'title'          => esc_html__( 'Form styles', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_style',
	) );

	Kirki::add_section( 'fonts', array(
		'title'          => esc_html__( 'Typography', 'goya' ),
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'panel'          => 'panel_style',
	) );



	// **************************************
	// Fields
	// **************************************

	/**
	 * GENERAL SETTINGS
	 */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'site_global_layout',
				'label'       => esc_html__( 'Global Site Layout', 'goya' ),
				'description' => esc_html__( '1.Regular, 2. Framed', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'general_settings',
				'default'     => 'regular',
				'priority'    => 10,
				'choices'     => array(
					'regular' => get_template_directory_uri() . '/assets/img/admin/options/layout-normal.png',
					'framed' => get_template_directory_uri() . '/assets/img/admin/options/layout-framed.png',
				),
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'et-site-layout-regular',
						'value'    => 'regular',
					),
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'et-site-layout-framed',
						'value'    => 'framed',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'general_settings',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'page_transition',
				'label'       => esc_html__( 'Page preload Transition', 'goya' ),
				'description'		=> sprintf( '<span class="attention">%s</span>',
					esc_html__( '* Warning: It may affect your Google Page Speed score if your server is not fast enough', 'goya' )
				), 
				'section'     => 'general_settings',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'page_transition_style',
				'label'       => esc_html__( 'Transition loader icon', 'goya' ),
				'section'     => 'general_settings',
				'default' 	  => 'dot3-loader',
				'priority'    => 10,
				'choices'	  => 
					array(
						'dot3-loader'   => esc_attr__('Dots', 'goya'),
						'line-loader' => esc_attr__('Line', 'goya'),
						'custom-loader' => esc_attr__('Custom', 'goya'),
					),
				'required' => array(
					array(
						'setting' => 'page_transition', 
						'operator' => '==', 
						'value' => true
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'page_transition_icon',
				'label'       => esc_html__( 'Use custom Page Load icon', 'goya' ),
				'section'     => 'general_settings',
				'priority'    => 10,
				'default'	  	=> '',
				'required' => array(
					array(
						'setting' => 'page_transition', 
						'operator' => '==', 
						'value' => true
					),
					array(
						'setting' => 'page_transition_style', 
						'operator' => '==', 
						'value' => 'custom-loader'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'general_settings',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'lazy_load',
				'label'       => esc_html__( 'Use lazy load', 'goya' ),
				'description' => esc_html__( 'Load images only when visible to improve loading time. DISABLE if you are using a Lazyload plugin', 'goya' ),
				'section'     => 'general_settings',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'lazy_load_skip',
				'label'       => esc_html__( 'Skip lazy load', 'goya' ),
				'description' => esc_html__( 'For products catalog you can skip the first images from lazy loading. Choose the number of products to skip.', 'goya' ),
				'section'     => 'general_settings',
				'default'     => 6,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 0,
					'max'	=> 10,
					'step'	=> 1
				),
				'required' => array(
					array(
						'setting' => 'lazy_load', 
						'operator' => '==', 
						'value' => true
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'general_settings',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'login_two_columns',
				'label'       => esc_html__( 'Login/Register form in two columns', 'goya' ),
				'description' => esc_html__( 'For desktop size and only on the regular login/register page', 'goya' ),
				'section'     => 'general_settings',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'general_settings',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'wp_gallery_popup',
				'label'       => esc_html__( 'WordPress Gallery - Lightbox', 'goya' ),
				'description' => esc_html__( 'Open WordPress Gallery Images in Lightbox', 'goya' ),
				'section'     => 'general_settings',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'general_settings',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'js_composer_standalone',
				'label'       => esc_html__( 'Standalone WP Bakery', 'goya' ),
				'description' => esc_html__( 'If you have your own WP Bakery Page Builder license, enable this option and add your license in the plugin settings', 'goya' ),
				'section'     => 'general_settings',
				'default'     => false,
				'priority'    => 10,
			));


	/**
	 * POPUP
	 */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'popup_modal',
				'label'       => esc_html__( 'Enable Popup', 'goya' ),
				'section'     => 'popup',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'popup',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'popup_layout',
				'label'       => esc_html__( 'Popup layout', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'popup',
				'default'     => '2-col',
				'priority'    => 10,
				'choices'	    => array(
					'1-col'			=> esc_attr__('1 column', 'goya'),
					'2-col'		  => esc_attr__('2 columns', 'goya')
				),
				'js_vars'     => array(
					array(
						'element'  => '#goya-popup',
						'function' => 'toggleClass',
						'class'    => 'popup-layout-1-col',
						'value'    => '1-col',
					),
					array(
						'element'  => '#goya-popup',
						'function' => 'toggleClass',
						'class'    => 'popup-layout-2-col',
						'value'    => '2-col',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'popup_color_style',
				'label'       => esc_html__( 'Color Scheme', 'goya' ),
				'description' => esc_html__( 'The image will be used as background.', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'popup',
				'default'     => '',
				'priority'    => 10,
				'choices'	  => array(
					''		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya')
				),
				'js_vars'     => array(
					array(
						'element'  => '#goya-popup',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'popup',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'popup_image',
				'label'       => esc_html__( 'Popup Image', 'goya' ),
				'section'     => 'popup',
				'priority'    => 10,
				'default'	  	=> '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'popup_content',
				'label'       => esc_html__( 'Popup Content', 'goya' ),
				'description'	=> esc_html__( 'You can use shortcodes like Mailchimp sign up shortcode.', 'goya' ),
				'transport'       => 'postMessage',
				'section'     => 'popup',
				'priority'    => 10,
				'default' 	  => '',
				'partial_refresh' => array(
					'popup_content' => array(
						'selector'        => '#goya-popup .content-wrapper',
						'render_callback' => function() {
							echo do_shortcode( get_theme_mod( 'popup_content','' ) );
						},
					),
				),
			));			

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'popup',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'popup_frequency',
				'label'       => esc_html__( 'Frequency', 'goya' ),
				'description' => esc_html__( 'Do NOT show the popup to the same visitor again until:', 'goya' ),
				'section'     => 'popup',
				'priority'    => 10,
				'choices'     => array(
					'0'	  => esc_attr__( '0 - For Testing', 'goya' ),
					'1'	  => esc_attr__( '1 Day', 'goya' ),
					'2'	  => esc_attr__( '2 Days', 'goya' ),
					'3'	  => esc_attr__( '3 Days', 'goya' ),
					'7'	  => esc_attr__( '1 Week', 'goya' ),
					'14'	=> esc_attr__( '2 Weeks', 'goya' ),
					'21'	=> esc_attr__( '3 Weeks', 'goya' ),
					'30'	=> esc_attr__( '1 Month', 'goya' ),
				),
				'default'	  	=> '1',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'number',
				'settings'    => 'popup_delay',
				'label'       => esc_html__( 'Delay', 'goya' ),
				'description'     => esc_html__( 'Seconds until the popup is displayed after page load.', 'goya' ),
				'section'     => 'popup',
				'default'     => 3,
				'priority'    => 10,
				'choices'         => array(
					'min'  => 0,
					'step' => 1,
				),
			));

	/**
	 * APIs
	 */

	Kirki::add_field( 'goya_config', array(
		'type'        => 'text',
		'settings'    => 'google_api_key',
		'label'       => esc_html__( 'Google API key', 'goya' ),
		'description' => sprintf( __( 'Enter your %sGoogle Maps API key%s.', 'goya' ), '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key">', '</a>' ),
		'section'     => 'apis',
		'default'     => '',
		'priority'    => 10,
	));


	/**
	 * Language Selector
	 */

	if ( function_exists('pll_the_languages') || function_exists('icl_get_languages')) {
	
		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'language_selector',
			'default'     => '<div class="kirki-separator"><h3>' . 
				esc_html__( 'For WPML/Polylang', 'goya' ) . '</h3><p>' . 
				esc_html__( 'Add the selector manually in the customizer in Header > Layout and other positions.', 'goya' ) . 
				'</p></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'ls_default_layout',
			'label'       => esc_html__( 'Default Layout', 'goya' ),
			'section'     => 'language_selector',
			'default'     => 'dropdown',
			'priority'    => 10,
			'choices'	    => array(
				'dropdown'		=> esc_attr__('Drop-down', 'goya'),
				'inline'		  => esc_attr__('Inline', 'goya')
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'           => 'multicheck',
			'settings'       => 'ls_default',
			'label'          => esc_html__( 'General Display', 'goya' ),
			'description'    => esc_html__( 'The default layout for language selector', 'goya' ),
			'section'        => 'language_selector',
			'default'        => array('name'),
			'priority'       => 10,
			'multiple'       => 1,
			'choices'        => array(
				'flag'       => esc_attr__('Flag', 'goya'),
				'code' 		 => esc_attr__('Code', 'goya'),
				'name' 		 => esc_attr__('Name', 'goya'),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'language_selector',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'           => 'multicheck',
			'settings'       => 'ls_mobile_header',
			'label'          => esc_html__( 'Mobile header/top bar', 'goya' ),
			'description'    => esc_html__( 'For mobiles in dropdown mode only.', 'goya' ),
			'section'        => 'language_selector',
			'default'        => array('code'),
			'priority'       => 10,
			'multiple'       => 1,
			'choices'        => array(
				'flag'       => esc_attr__('Flag', 'goya'),
				'code' 		 => esc_attr__('Code', 'goya'),
				'name' 		 => esc_attr__('Name', 'goya'),
			),
		));

	}



	/**
	 * HEADER
	 */

		/* Header Styles */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'header_sticky',
				'label'       => esc_html__( 'Sticky Header', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'header-sticky',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'header_sticky_sections',
				'label'       => esc_html__( 'Section to display on sticky header', 'goya' ),
				'description'       => esc_html__( 'For desktop size only', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'     => 'top',
				'priority'    => 10,
				'choices'     => array(
					'both'   => esc_html__( 'Both', 'goya' ),
					'top' => esc_html__( 'Top', 'goya' ),
					'bottom'   => esc_html__( 'Bottom', 'goya' ),
				),
				'required' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'js_vars'     => array(
					array(
						'element'  => '.site-header',
						'function' => 'toggleClass',
						'class'    => 'sticky-display-top',
						'value'    => 'top',
					),
					array(
						'element'  => '.site-header',
						'function' => 'toggleClass',
						'class'    => 'sticky-display-bottom',
						'value'    => 'bottom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'header_full_width',
				'label'       => esc_html__( 'Header Full Width', 'goya' ),
				'description' => esc_html__('This also applies to the "Top Bar" if visible.', 'goya'),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'     => false,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'header-full-width',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'header_layout',
				'label'       => esc_html__( 'Header Layout', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'     => 'prebuild',
				'priority'    => 10,
				'choices'     => array(
					'prebuild' => esc_html__( 'Preset', 'goya' ),
					'custom'   => esc_html__( 'Custom', 'goya' ),
				),
				'partial_refresh' => array(
					'header_layout' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'            => 'select',
				'settings'    => 'header_version',
				'label'           => esc_html__( 'Header version', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'         => 'v6',
				'priority'    => 11,
				'choices'         => array(
					'v1'  => esc_html__( 'Header V1', 'goya' ),
					'v2'  => esc_html__( 'Header V2', 'goya' ),
					'v3'  => esc_html__( 'Header V3', 'goya' ),
					'v4'  => esc_html__( 'Header V4', 'goya' ),
					'v5'  => esc_html__( 'Header V5', 'goya' ),
					'v6'  => esc_html__( 'Header V6', 'goya' ),
					'v7'  => esc_html__( 'Header V7', 'goya' ),
					'v8'  => esc_html__( 'Header V8', 'goya' ),
					'v9'  => esc_html__( 'Header V9', 'goya' ),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'prebuild',
					),
				),
				'partial_refresh' => array(
					'header_version' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Header Top', 'goya' ) . '</h3><p>' . esc_html__( 'Custom elements for top section of the header', 'goya' ) . '</p></div>',
				'priority'    => 12,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_main_left',
				'label'           => esc_html__( 'Top - Left Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 13,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_left' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_main_center',
				'label'           => esc_html__( 'Top - Center Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 14,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_center' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_main_right',
				'label'           => esc_html__( 'Top - Right Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 15,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_right' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Header Bottom', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Custom elements for bottom section of the header', 'goya' ) . 
					'</p></div>',
				'priority'    => 16,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'header_show_bottom',
				'label'       => esc_html__( 'Show bottom section', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_layout',
				'default'     => true,
				'priority'    => 17,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 18,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_bottom_left',
				'label'           => esc_html__( 'Bottom - Left Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 19,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'partial_refresh' => array(
					'header_bottom_left' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_bottom_center',
				'label'           => esc_html__( 'Bottom - Center Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 20,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'partial_refresh' => array(
					'header_bottom_center' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'header_bottom_right',
				'label'           => esc_html__( 'Bottom - Right Section', 'goya' ),
				'section'     => 'header_layout',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 21,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_header_elements_list(),
					),
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'partial_refresh' => array(
					'header_bottom_right' => array(
						'selector'        => '#header',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/header', 'default' );
						},
					),
				),

			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_layout',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Text Fields', 'goya' ) . '</h3><p>' . 
					esc_html__( 'To be used with the customizer above: Text 1, Text 2, Text 3', 'goya' ) . 
					'</p></div>',
				'priority'    => 22,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'header_custom_text',
				'label'       => esc_html__( 'Text 1', 'goya' ),
				'section'     => 'header_layout',
				'priority'    => 22,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'header_custom_text2',
				'label'       => esc_html__( 'Text 2', 'goya' ),
				'section'     => 'header_layout',
				'priority'    => 22,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'header_custom_text3',
				'label'       => esc_html__( 'Text 3', 'goya' ),
				'section'     => 'header_layout',
				'priority'    => 22,
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default' 	  => '',
			));



		/* Header Icons */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_elements',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Account', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));


			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'main_header_login_popup',
				'label'       => esc_html__( 'Login/Register Lightbox', 'goya' ),
				'section'     => 'header_elements',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'main_header_login_icon',
				'label'         => esc_html__( 'Display mode', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'header_elements',
				'default'       => 'text',
				'priority'      => 10,
				'choices'	      => array(
					'icon'		=> esc_attr__('Icon', 'goya'),
					'text'		=> esc_attr__('Text', 'goya'),
				),
				'js_vars'     => array(
					array(
						'element'  => '.et-menu-account-btn',
						'function' => 'toggleClass',
						'class'    => 'account-icon',
						'value'    => 'icon',
					),
					array(
						'element'  => '.et-menu-account-btn',
						'function' => 'toggleClass',
						'class'    => 'account-text',
						'value'    => 'text',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_elements',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Wishlist', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'ajax_wishlist_counter',
				'label'       => esc_html__( 'Ajax update Wishlist counter', 'goya' ),
				'description' => esc_html__( 'Update the counter on cached pages - it creates a new Ajax request.', 'goya' ),
				'section'     => 'header_elements',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'wishlist_account_dashboard',
				'label'       => esc_html__( 'Wishlist in My Account dashboard', 'goya' ),
				'description'		=> sprintf( '<span class="attention">%s</span><br>%s',
					esc_html__( 'Re-save "Settings > Permalinks" after any change', 'goya' ), 
					esc_html__( 'The header icon will point to the new tab. DON\'T delete the Wishlist page! It\'s still required.', 'goya' )
				),
				'section'     => 'header_elements',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_elements',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Search', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'ajax_search',
				'label'       => esc_html__( 'Use Ajax Product Search', 'goya' ),
				'description' => esc_html__( 'Only if WooCommerce is installed', 'goya' ),
				'section'     => 'header_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'search_categories',
				'label'       => esc_html__( 'Narrow by Category', 'goya' ),
				'section'     => 'header_elements',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_elements',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Mini Cart', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Moved to Shop > Minicart in customizer.', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));


		/* Header Logo */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'site_logo',
				'label'       => esc_html__( 'Logo - General', 'goya' ),
				'description'		=> sprintf( '<span class="attention">%s <strong>%s</strong></span>',
					esc_html__( '* Leave empty ', 'goya' ),
					esc_html__( 'Site Identity > Logo', 'goya' )
				), 
				'transport'   => 'auto',
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  	=> get_template_directory_uri() . '/assets/img/logo-light.png',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'site_logo_dark',
				'label'       => esc_html__( 'Logo - Dark', 'goya' ),
				'description' => esc_html__( 'Logo for dark background transparent header', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  	=> get_template_directory_uri() . '/assets/img/logo-dark.png',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'site_logo_alt_use',
				'label'       => esc_html__( 'Alternative Logo', 'goya' ),
				'description' => esc_html__( 'This will override the Logo - Dark in some cases', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_logo',
				'priority'    => 10,
				'choices'     => array(
					'' => esc_html__( 'Disable', 'goya' ),
					'alt-logo-sticky' => esc_html__( 'Show in Sticky Header + Mobiles', 'goya' ),
					'alt-logo-tablet' => esc_html__( 'Show in Tablets + Mobiles', 'goya' ),
					'alt-logo-mobile' => esc_html__( 'Show in Mobiles only', 'goya' ),
				),
				'default'	  	=> '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'site_logo_alt',
				'label'       => esc_html__( 'Alternative Logo Upload', 'goya' ),
				'section'     => 'header_logo',
				'priority'    => 10,
				'default'	  	=> '',
				'required' => array(
					array(
						'setting' => 'site_logo_alt_use', 
						'operator' => '!=', 
						'value' => ''
					)
				),
			));


			/* Header/Logo Size */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo_size',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Header Height', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'header_height',
				'label'       => esc_html__( 'Header Height (px)', 'goya' ),
				'description'       => esc_html__( 'This is the full header height (including bottom section if enabled)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 90,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 50,
					'max'	=> 250,
					'step'	=> 1
				),
				'output'      => array(
					array(
						'element'  => '.header,.header-spacer,.product-header-spacer',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'header_height_bottom',
				'label'       => esc_html__( 'Header Bottom (px)', 'goya' ),
				'description'       => esc_html__( 'The height of the bottom section only', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 40,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 30,
					'max'	=> 150,
					'step'	=> 1
				),
				'required' => array(
					array(
						'setting'  => 'header_layout',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_show_bottom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => '.header .header-bottom',
						'property' => 'height',
						'units'    => 'px',
					),
					array(
						'element'  => '.header .header-bottom',
						'property' => 'max-height',
						'units'    => 'px',
					),
					array(
						'element'  => '.header .header-bottom',
						'property' => 'min-height',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'header_height_sticky',
				'label'       => esc_html__( 'Sticky Header (px)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 70,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 50,
					'max'	=> 250,
					'step'	=> 1
				),
				'required'    => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => '.header_on_scroll:not(.megamenu-active) .header',
						'property' => 'height',
						'units'    => 'px',
						'media_query' => '@media only screen and (min-width: 992px)'
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'header_height_mobile',
				'label'       => esc_html__( 'Mobile Header (px)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 60,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 40,
					'max'	=> 120,
					'step'	=> 1
				),
				'output'      => array(
					array(
						'element'  => array('.header', '.header_on_scroll .header', '.sticky-product-bar', '.header-spacer', '.product-header-spacer'),
						'property' => 'height',
						'units'    => 'px',
						'media_query' => '@media only screen and (max-width: 991px)',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_logo_size',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Logo Height', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'logo_height',
				'label'       => esc_html__( 'Logo Height (px)', 'goya' ),
				'description' => esc_html__( 'Maximum Logo Height', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 24,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 15,
					'max'	=> 200,
					'step'	=> 1
				),
				'output'      => array(
					array(
						'element'  => array('.header .logolink img'),
						'property' => 'max-height',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'logo_height_sticky',
				'label'       => esc_html__( 'Logo Height - Sticky Header (px)', 'goya' ),
				'description' => esc_html__( 'Maximum Logo Height in sticky header (when scrolling down)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 24,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 15,
					'max'	=> 200,
					'step'	=> 1
				),
				'output'      => array(
					array(
						'element'  => array('.header_on_scroll:not(.megamenu-active) .header .logolink img, .header_on_scroll.megamenu-active .header .alt-logo-sticky img'),
						'property' => 'max-height',
						'units'    => 'px',
						'media_query' => '@media only screen and (min-width: 992px)',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'logo_height_mobile',
				'label'       => esc_html__( 'Logo Height - Mobile (px)', 'goya' ),
				'description' => esc_html__( 'Maximum Logo Height for Mobiles', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_logo_size',
				'default'     => 24,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 15,
					'max'	=> 100,
					'step'	=> 1
				),
				'output'      => array(
					array(
						'element'  => array('.header .logolink img'),
						'property' => 'max-height',
						'units'    => 'px',
						'media_query' => '@media only screen and (max-width: 991px)',
					),
				),
			));


		/* Top Bar */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'top_bar',
				'label'       => esc_html__( 'Show Top Bar', 'goya' ),
				'section'     => 'top_bar',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'top_bar',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'     => 'multicheck',
				'settings' => 'top_bar_mobiles',
				'label'    => esc_html__( 'Mobile visibility', 'goya' ),
				'description' => esc_html__( 'Select the sections to display on mobiles', 'goya' ),
				'section'  => 'top_bar',
				'default'  => array(),
				'priority' => 10,
				'multiple' => 1,
				'choices'  => array(
					'left'     => esc_attr__('Left', 'goya'),
					'center'   => esc_attr__('Center', 'goya'),
					'right'    => esc_attr__('Right', 'goya'),
				),
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'top_bar',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Elements', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'top_bar_left',
				'label'       => esc_html__( 'Left Section', 'goya' ),
				'section'     => 'top_bar',
				'transport'   => 'postMessage',
				'default'     => array( array( 'item' => 'social' ) ),
				'priority'    => 11,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_topbar_elements_list(),
					),
				),
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'partial_refresh' => array(
					'top_bar_left' => array(
						'selector'        => '.top-bar',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header-parts/top-bar' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'top_bar_center',
				'label'       => esc_html__( 'Center Section', 'goya' ),
				'section'     => 'top_bar',
				'transport'   => 'postMessage',
				'default'     => array(),
				'priority'    => 12,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_topbar_elements_list(),
					),
				),
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'partial_refresh' => array(
					'top_bar_center' => array(
						'selector'        => '.top-bar',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header-parts/top-bar' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'top_bar_right',
				'label'       => esc_html__( 'Right Section', 'goya' ),
				'section'     => 'top_bar',
				'transport'   => 'postMessage',
				'default'     => array(),
				'priority'    => 13,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_topbar_elements_list(),
					),
				),
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'partial_refresh' => array(
					'top_bar_right' => array(
						'selector'        => '.top-bar',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header-parts/top-bar' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'top_bar',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Text Fields', 'goya' ) . '</h3><p>' . 
					esc_html__( 'To be used with the customizer above', 'goya' ) . 
					'</p></div>',
				'priority'    => 14,
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'top_bar_text',
				'label'       => esc_html__( 'Custom Text 1', 'goya' ),
				'section'     => 'top_bar',
				'priority'    => 14,
				'default' 	  => '',
				/*'required' => array(
					array(
						'setting' => 'top_bar',
						'operator' => '==',
						'value' => true
					)
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'top_bar_text2',
				'label'       => esc_html__( 'Custom Text 2', 'goya' ),
				'section'     => 'top_bar',
				'priority'    => 14,
				'default' 	  => '',
				/*'required' => array(
					array(
						'setting' => 'top_bar',
						'operator' => '==',
						'value' => true
					)
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'top_bar_text3',
				'label'       => esc_html__( 'Custom Text 3', 'goya' ),
				'section'     => 'top_bar',
				'priority'    => 14,
				'default' 	  => '',
				/*'required' => array(
					array(
						'setting' => 'top_bar',
						'operator' => '==',
						'value' => true
					)
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'top_bar',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Styles', 'goya' ) . '</h3></div>',
				'priority'    => 14,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'top_bar_height',
				'label'       => esc_html__( 'Height (px)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'top_bar',
				'default'     => 40,
				'priority'    => 14,
				'choices'	  => array(
					'min'	=> 30,
					'max'	=> 60,
					'step'	=> 1
				),
				/*'required' => array(
					array(
						'setting' => 'top_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'output'      => array(
					array(
						'element'  => array('.top-bar .search-field, .top-bar .search-button-group select'),
						'property' => 'height',
						'units'    => 'px',
					),
					array(
						'element'  => array('.top-bar'),
						'property' => 'min-height',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'top_bar',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 14,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'top_bar_font_color',
				'label'       => esc_html__( 'Top Bar Text Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'top_bar',
				'default'     => '#eeeeee',
				'priority'    => 14,
				/*'required'    => array(
					array(
						'setting'  => 'top_bar',
						'operator' => '==',
						'value'    => true,
					),
				),*/
				'output'      => array(
					array(
						'element'  => array('.top-bar, .top-bar a, .top-bar button, .top-bar .selected'),
						'property' => 'color',
					),
					array(
						'element'  => array('.search-button-group .search-clear:before, .search-button-group .search-clear:after'),
						'property' => 'background-color',
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'top_bar_background_color',
				'label'       => esc_html__( 'Top Bar Background Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'top_bar',
				'default'     => '#282828',
				'priority'    => 14,
				/*'required'    => array(
					array(
						'setting'  => 'top_bar',
						'operator' => '==',
						'value'    => true,
					),
				),*/
				'output'      => array(
					array(
						'element'  => array('.top-bar'),
						'property' => 'background-color',
					),
				),
			));


			/* Campaign */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'campaign_bar',
				'label'       => esc_html__( 'Show Campaign Bar', 'goya' ),
				'section'     => 'campaign',
				'default'     => false,
				'priority'    => 10,
			));

			if (get_theme_mod('campaign_bar_content', '') != '') {

				Kirki::add_field( 'goya_config', array(
					'type'        => 'custom',
					'settings'    => 'separator_' . $sep++,
					'section'     => 'campaign',
					'default'     => '<div class="kirki-separator"></div>',
					'priority'    => 10,
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'textarea',
					'settings'    => 'campaign_bar_content',
					'label'       => esc_html__( 'Old Content', 'goya' ),
					'description'		=> sprintf( '<p class="attention">%s <strong>%s</strong></p><p>%s</p>',
						esc_html__( '* Warning: This field is deprecated and it will be removed. Leave this field empty and use the new options under', 'goya' ),
						esc_html__( 'Campaign Content', 'goya' ),
						esc_html__( 'For multilanguage sites translate the strings again.', 'goya' )
					), 
					'section'     => 'campaign',
					'default' 	  => '',
					'priority'    => 10,
					/*'required' => array(
						array(
							'setting' => 'campaign_bar', 
							'operator' => '==', 
							'value' => true
						)
					),*/
				));

			}

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Contents', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'            => 'repeater',
				'settings'    => 'campaign_bar_items',
				'label'           => esc_html__( 'Campaign Content', 'goya' ),
				'section'     => 'campaign',
				'transport'       => 'postMessage',
				'default'         => array(),
				'priority'    => 11,
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Campaign', 'goya' ),
				),
				'fields'          => array(
					'campaign_text' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Text', 'goya' ),
						'default' => ''
					),
					'campaign_link' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'URL', 'goya' ),
						'default' => ''
					),
					'campaign_button' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Button Text', 'goya' ),
						'description'   => esc_html__( 'Only used if Link Mode is Button', 'goya' ),
						'default' => ''
					),
				),
				/*'required' => array(
					array(
						'setting' => 'campaign_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'partial_refresh' => array(
					'campaign_items' => array(
						'selector'        => '.et-global-campaign',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header-parts/campaigns' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Layout', 'goya' ) . '</h3></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'campaign_layout',
				'label'         => esc_html__( 'Layout', 'goya' ),
				'section'       => 'campaign',
				'default'       => 'slider',
				'priority'      => 12,
				'choices'	      => array(
					'inline'		=> esc_attr__('Inline', 'goya'),
					'slider'		=> esc_attr__('Slider', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'campaign_slider_transition',
				'label'         => esc_html__( 'Slider Transition', 'goya' ),
				'section'       => 'campaign',
				'default'       => 'slide',
				'priority'      => 12,
				'choices'	      => array(
					'slide'		=> esc_attr__('Slide', 'goya'),
					'fade'		=> esc_attr__('Fade', 'goya'),
				),
				/*'required'    => array(
					array(
						'setting'  => 'campaign_layout',
						'operator' => '==',
						'value'    => 'slider',
					),
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'text',
				'settings'      => 'campaign_autoplay_speed',
				'label'         => esc_html__( 'Autoplay Speed', 'goya' ),
				'description'   => __( 'Enter autoplay interval in milliseconds (1 second = 1000 milliseconds).', 'goya' ),
				'section'       => 'campaign',
				'default'       => 2500,
				'priority'      => 12,
				/*'required'    => array(
					array(
						'setting'  => 'campaign_layout',
						'operator' => '==',
						'value'    => 'slider',
					),
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'campaign_links_mode',
				'label'         => esc_html__( 'Link Mode', 'goya' ),
				'description'   => esc_html__( 'Full Text: click anywhere on the text, the button is not visible', 'goya' ),
				'section'       => 'campaign',
				'default'       => 'button',
				'priority'      => 12,
				'choices'	      => array(
					'button'		=> esc_attr__('Button', 'goya'),
					'cover'		=> esc_attr__('Full Text', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'campaign_bar_dismissible',
				'label'       => esc_html__( 'Show close button', 'goya' ),
				'description' => esc_html__( 'Campaign area is reactivated after 24hr.', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'campaign',
				'default'     => true,
				'priority'    => 12,
				/*'required'    => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),*/
				'js_vars'     => array(
					array(
						'element'  => '.et-global-campaign .remove',
						'function' => 'toggleClass',
						'class'    => 'dismissible',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'campaign_bar_height',
				'label'       => esc_html__( 'Min Height (px)', 'goya' ),
				'transport' => 'auto',
				'section'     => 'campaign',
				'default'     => 40,
				'priority'    => 12,
				'choices'	  => array(
					'min'	=> 30,
					'max'	=> 60,
					'step'	=> 1
				),
				/*'required' => array(
					array(
						'setting' => 'campaign_bar', 
						'operator' => '==', 
						'value' => true
					)
				),*/
				'output'      => array(
					array(
						'element'  => array('.et-global-campaign'),
						'property' => 'min-height',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'campaign',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Colors', 'goya' ) . '</h3></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'campaign_bar_font_color',
				'label'       => esc_html__( 'Campaign - Text Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'campaign',
				'default'     => '#ffffff',
				'priority'    => 12,
				/*'required'    => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),*/
				'output'      => array(
					array(
						'element'  => array('.et-global-campaign'),
						'property' => 'color',
					),
					array(
						'element'  => array('.et-global-campaign .et-close:before, .et-global-campaign .et-close:after, .no-touch .et-global-campaign .et-close:hover:before, .no-touch .et-global-campaign .et-close:hover:after'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'campaign_bar_background_color',
				'label'       => esc_html__( 'Campaign - Background Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'campaign',
				'default'     => '#e97a7e',
				'priority'    => 12,
				/*'required'    => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),*/
				'output'      => array(
					array(
						'element'  => array('.et-global-campaign'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'campaign_button_text_color',
				'label'       => esc_html__( 'Button Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'campaign',
				'default'     => '#ffffff',
				'priority'    => 12,
				'required'    => array(
					/*array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),*/
					array(
						'setting'  => 'campaign_links_mode',
						'operator' => '==',
						'value'    => 'button',
					)
				),
				'output'      => array(
					array(
						'element'  => array('.campaign-inner .link-button'),
						'property' => 'color',
					),
				),
			));


		/* Header Styles */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'vertical_bar',
				'label'       => esc_html__( 'Show Vertical Bar', 'goya' ),
				'description'	=> esc_html__( 'Vertical icons bar in Toggle/Mobile menu panel', 'goya' ),
				'section'     => 'header_vertical_bar',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'sortable',
				'settings'    => 'vertical_bar_icons',
				'label'       => esc_html__( 'Vertical Bar Icons', 'goya' ),
				'section'     => 'header_vertical_bar',
				'transport'   => 'postMessage',
				'default'     => array( 'account', 'wishlist' ),
				'choices'   => goya_vertical_bar_elements_list(),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_vertical_bar',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'vertical_bar_mode',
				'label'         => esc_html__( 'Color scheme', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'header_vertical_bar',
				'default'       => 'light',
				'priority'      => 10,
				'choices'	      => array(
					'light'		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya'),
				),
				'js_vars'     => array(
					array(
						'element'  => '.side-panel .mobile-bar',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
					array(
						'element'  => '.side-panel .mobile-bar',
						'function' => 'toggleClass',
						'class'    => 'light',
						'value'    => 'light',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'vertical_bar_background',
				'label'       => esc_html__( 'Bar background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_vertical_bar',
				'default'     => '#f8f8f8',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.side-panel .mobile-bar','.side-panel .mobile-bar.dark'),
						'property' => 'background-color',
					),
				),
			));

			/* Main Menu Settings */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'megamenu_fullwidth',
				'label'       => esc_html__( 'Full width Mega Menu', 'goya' ),
				'description' => esc_html__( 'Megamenu fills the entire page width', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_main_menu',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'megamenu-fullwidth',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_main_menu',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'megamenu_column_animation',
				'label'       => esc_html__( 'Animate Megamenu Columns', 'goya' ),
				'description' => esc_html__( 'Add delayed animation to megamenu dropdown columns', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_main_menu',
				'default'     => false,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'megamenu-column-animation',
						'value'    => true,
					),
				),
			));


			/* Off Canvas Desktop Menu */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_override',
				'label'       => esc_html__( 'Override with mobile?', 'goya' ),
				'description'   => esc_html__( 'Show mobile panel on desktops too', 'goya' ),
				'section'     => 'header_offcanvas_desktop',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_offcanvas_desktop',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'menu_fullscreen_override',
						'operator' => '!=',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'menu_fullscreen_mode',
				'label'         => esc_html__( 'Panel color scheme', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'header_offcanvas_desktop',
				'default'       => 'light',
				'priority'      => 10,
				'choices'	      => array(
					'light'		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'menu_fullscreen_override',
						'operator' => '!=',
						'value'    => true,
					),
				),
				'js_vars'     => array(
					array(
						'element'  => '#fullscreen-menu',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
					array(
						'element'  => '#fullscreen-menu',
						'function' => 'toggleClass',
						'class'    => 'light',
						'value'    => 'light',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'menu_fullscreen_background_color',
				'label'       => esc_html__( 'Panel Background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_offcanvas_desktop',
				'default'     => '#ffffff',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'menu_fullscreen_override',
						'operator' => '!=',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => array('.side-fullscreen-menu','.side-fullscreen-menu.dark'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_offcanvas_desktop',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Additional Elements', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_widget',
				'label'       => esc_html__( 'Widget Area', 'goya' ),
				'section'     => 'header_offcanvas_desktop',
				'default'     => true,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'menu_fullscreen_override',
						'operator' => '!=',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_account',
				'label'       => esc_html__( 'Account links', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_offcanvas_desktop',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'menu_fullscreen_override',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_currency',
				'label'       => esc_html__( 'Currency Selector', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_offcanvas_desktop',
				'default'     => true,
				'priority'    => 10,
				'partial_refresh' => array(
					'menu_fullscreen_currency' => array(
						'selector'        => '#fullscreen-menu',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/fullscreen-menu' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_language',
				'label'       => esc_html__( 'Language Selector', 'goya' ),
				'section'     => 'header_offcanvas_desktop',
				'default'     => true,
				'priority'    => 10,
				'partial_refresh' => array(
					'menu_fullscreen_language' => array(
						'selector'        => '#fullscreen-menu',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/fullscreen-menu' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_fullscreen_social',
				'label'       => esc_html__( 'Social Icons', 'goya' ),
				'section'     => 'header_offcanvas_desktop',
				'default'     => true,
				'priority'    => 10,
				'partial_refresh' => array(
					'menu_fullscreen_social' => array(
						'selector'        => '#fullscreen-menu',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/header/fullscreen-menu' );
						},
					),
				),
			));


			/* Mobile Menu */

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'mobile_menu_type',
				'label'         => esc_html__( 'Mobile Sub-menus', 'goya' ),
				'description'   => esc_html__( 'How to reveal sub-menus on mobiles', 'goya' ),
				'section'       => 'header_menu_mobile',
				'default'       => 'sliding',
				'priority'      => 10,
				'choices'	      => array(
					'sliding'		=> esc_attr__('Sliding', 'goya'),
					'vertical'		=> esc_attr__('Collapsible (vertical)', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_menu_mobile',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'menu_mobile_mode',
				'label'         => esc_html__( 'Panel color scheme', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'header_menu_mobile',
				'default'       => 'light',
				'priority'      => 10,
				'choices'	      => array(
					'light'		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya'),
				),
				'js_vars'     => array(
					array(
						'element'  => '#mobile-menu',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
					array(
						'element'  => '#mobile-menu',
						'function' => 'toggleClass',
						'class'    => 'light',
						'value'    => 'light',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'menu_mobile_text_color',
				'label'       => esc_html__( 'Links Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_menu_mobile',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.side-mobile-menu li, .side-mobile-menu li a, .side-mobile-menu .bottom-extras, .side-mobile-menu .bottom-extras a, .side-mobile-menu .selected'),
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'menu_mobile_background_color',
				'label'       => esc_html__( 'Panel Background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'header_menu_mobile',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.side-menu.side-mobile-menu','.side-menu.side-mobile-menu.dark'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_menu_mobile',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Elements to show', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Items to show on mobile menu', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'menu_mobile_search',
				'label'       => esc_html__( 'Search Box', 'goya' ),
				'description' => esc_html__( 'Show search box on top of mobile menu', 'goya' ),
				'section'     => 'header_menu_mobile',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'sortable',
				'settings'    => 'menu_mobile_items',
				'label'       => esc_html__( 'Extra Options', 'goya' ),
				'description'       => esc_html__( 'Additional elements below menu', 'goya' ),
				'section'     => 'header_menu_mobile',
				'transport'   => 'postMessage',
				'default'     => array('account', 'divider1', 'currency', 'language', 'divider2', 'social'),
				'choices'   => goya_mobile_menu_elements_list(),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_menu_mobile',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Text Fields', 'goya' ) . '</h3><p>' . 
					esc_html__( 'To be used with the customizer above', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'menu_mobile_custom_text',
				'label'       => esc_html__( 'Custom Text 1', 'goya' ),
				'section'     => 'header_menu_mobile',
				'priority'    => 10,
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'menu_mobile_custom_text2',
				'label'       => esc_html__( 'Custom Text 2', 'goya' ),
				'section'     => 'header_menu_mobile',
				'priority'    => 10,
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'menu_mobile_custom_text3',
				'label'       => esc_html__( 'Custom Text 3', 'goya' ),
				'section'     => 'header_menu_mobile',
				'priority'    => 10,
				'default' 	  => '',
			));


			/* Mobile Options */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'mobile_logo_position',
				'label'       => esc_html__( 'Logo Position', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_mobile',
				'default'     => 'center',
				'priority'    => 10,
				'choices'     => array(
					'center'	=> esc_attr__( 'Center', 'goya' ),
					'left'	=> esc_attr__( 'Left', 'goya' ),
				),
				'js_vars'     => array(
					array(
						'element'  => '.header .header-mobile',
						'function' => 'toggleClass',
						'class'    => 'logo-center',
						'value'    => 'center',
					),
					array(
						'element'  => '.header .header-mobile',
						'function' => 'toggleClass',
						'class'    => 'logo-left',
						'value'    => 'left',
					),
				),
			));


			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_mobile',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 11,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'header_transparent_mobiles',
				'label'       => esc_html__( 'Keep transparent header', 'goya' ),
				'description' => esc_html__( 'This option only works if you enable transparent header on other customizer sections (shop, blog) or directly on the product or page.', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_mobile',
				'default'     => true,
				'priority'    => 12,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'header-transparent-mobiles',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_mobile',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 13,
			));

			Kirki::add_field( 'goya_config', array( // Repeater
				'type'        => 'repeater',
				'settings'    => 'mobile_header_icons',
				'label'       => esc_html__( 'Header Icons', 'goya' ),
				'description' => esc_html__( 'Control icons on the right side of mobile header', 'goya' ),
				'section'     => 'header_mobile',
				'transport'   => 'postMessage',
				'default'     => array( array( 'item' => 'cart' ) ),
				'priority'    => 14,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_mobile_header_elements_list(),
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_mobile',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 15,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'header_mobile_custom_text',
				'label'       => esc_html__( 'Custom Text', 'goya' ),
				'section'     => 'header_mobile',
				'priority'    => 16,
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_mobile',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 17,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'text',
				'settings'    => 'mobile_header_breakpoint',
				'label'       => esc_html__( 'Responsive breakpoint', 'goya' ),
				'description'	=> esc_html__( 'Screen width in px at which the mobile header becomes visible. Applied to Top Bar too. Min: 575, Max: 1360, Default: 991px', 'goya' ),
				'section'     => 'header_mobile',
				'default'     => 991,
				'priority'    => 18,
			));


	/**
	 * FOOTER
	 */	
		/* Footer */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'back_to_top_button',
				'label'       => esc_html__( 'Back To Top Button', 'goya' ),
				'section'     => 'footer_setting',
				'default'     => true,
				'priority'    => 10,
			));	

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_setting',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Footer Widgets', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'footer_widgets_columns',
				'label'       => esc_html__( 'Widgets Columns', 'goya' ),
				'description' => esc_html__( 'Number of columns for Footer Widgets', 'goya' ),
				'section'     => 'footer_setting',
				'default'     => 3,
				'priority'    => 10,
				'choices'	  => 
					array 
					(
						'min'	=> 1,
						'max'	=> 4,
						'step'	=> 1
					),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'footer_widgets_column_width',
				'label'       => esc_html__( 'Columns Width', 'goya' ),
				'section'     => 'footer_setting',
				'default'     => 'equal',
				'priority'    => 10,
				'choices'     => array(
					'equal' => esc_html__( 'Equal width columns', 'goya' ),
					'last' => esc_html__( 'Last column wide', 'goya' ),
					'first' => esc_html__( 'First column wide', 'goya' ),
				),
				'required'    => array(
					array(
						'setting'  => 'footer_widgets_columns',
						'operator' => '>',
						'value'    => 1,
					),
				),
			));

			/* Footer Extra */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'footer_middle',
				'label'       => esc_html__( 'Enable Footer Extra', 'goya' ),
				'description' => esc_html__( 'Full width section with custom content', 'goya' ),
				'section'     => 'footer_extra',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_extra',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'footer_middle_position',
				'label'         => esc_html__( 'Position', 'goya' ),
				'section'     => 'footer_extra',
				'default'       => 'after',
				'priority'      => 10,
				'choices'	      => array(
					'before'		=> esc_attr__('Before Widgets', 'goya'),
					'after'		=> esc_attr__('After Widgets', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'footer_middle',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_extra',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'footer_middle_content',
				'label'       => esc_html__( 'Content', 'goya' ),
				'description'	=> esc_html__( 'You can use shortcodes like Mailchimp sign up shortcode.', 'goya' ),
				'transport'       => 'postMessage',
				'section'     => 'footer_extra',
				'priority'    => 10,
				'default' 	  => '',
				'required'    => array(
					array(
						'setting'  => 'footer_middle',
						'operator' => '==',
						'value'    => true,
					),
				),
				'partial_refresh' => array(
					'footer_middle_content' => array(
						'selector'        => '.footer-middle > div > div > .col-12',
						'render_callback' => function() {
							echo do_shortcode( get_theme_mod( 'footer_middle_content','' ) );
						},
					),
				),
			));

			/* Footer Bottom */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'footer_bar_full_width',
				'label'       => esc_html__( 'Full-width Footer Bar', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'footer_bottom',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => '.footer-bar',
						'function' => 'toggleClass',
						'class'    => 'footer-full',
						'value'    => true,
					),
					array(
						'element'  => '.footer-bar',
						'function' => 'toggleClass',
						'class'    => 'footer-normal',
						'value'    => false,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_bottom',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'footer_bar_border',
				'label'       => esc_html__( 'Footer Bar Top Border', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'footer_bottom',
				'default'     => false,
				'priority'    => 11,
				'js_vars'     => array(
					array(
						'element'  => '.footer-bar',
						'function' => 'toggleClass',
						'class'    => 'footer-bar-border-1',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_bottom',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Columns', 'goya' ) . '</h3></div>',
				'priority'    => 12,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'footer_main_left',
				'label'       => esc_html__( 'Left Section', 'goya' ),
				'section'     => 'footer_bottom',
				'transport'   => 'postMessage',
				'default'     => array( array( 'item' => 'copyright' ) ),
				'priority'    => 13,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_footer_elements_list(),
					),
				),
				'partial_refresh' => array(
					'footer_main_left' => array(
						'selector'        => '.footer-main',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/footer/footer', 'bar' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'footer_main_center',
				'label'       => esc_html__( 'Center Section', 'goya' ),
				'section'     => 'footer_bottom',
				'transport'   => 'postMessage',
				'default'     => array(),
				'priority'    => 14,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_footer_elements_list(),
					),
				),
				'partial_refresh' => array(
					'footer_main_center' => array(
						'selector'        => '.footer-main',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/footer/footer', 'bar' );
						},
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'footer_main_right',
				'label'       => esc_html__( 'Right Section', 'goya' ),
				'section'     => 'footer_bottom',
				'transport'   => 'postMessage',
				'default'     => array(),
				'priority'    => 15,
				'row_label'   => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'item',
				),
				'fields'      => array(
					'item' => array(
						'type'    => 'select',
						'choices' => goya_footer_elements_list(),
					),
				),
				'partial_refresh' => array(
					'footer_main_right' => array(
						'selector'        => '.footer-main',
						'container_inclusive' => true,
						'render_callback' => function() {
							get_template_part( 'inc/templates/footer/footer', 'bar' );
						},
					),
				),
			));

			/* Footer Text */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_bottom',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Text Fields', 'goya' ) . '</h3></div>',
				'priority'    => 16,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'footer_bar_copyright',
				'label'       => esc_html__( 'Copyright', 'goya' ),
				'description'		=> sprintf( '%s <code>[current_year]</code>',
					esc_html__( 'To automatically update the year use the shortcode ', 'goya' )
				),
				'section'     => 'footer_bottom',
				'priority'    => 17,
				'default' 	  => '',
			));
			

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'footer_bar_custom_text',
				'label'       => esc_html__( 'Custom Text 1', 'goya' ),
				'section'     => 'footer_bottom',
				'priority'    => 18,
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'footer_bar_custom_text2',
				'label'       => esc_html__( 'Custom Text 2', 'goya' ),
				'section'     => 'footer_bottom',
				'priority'    => 19,
				'default' 	  => '',
			));


			/* Footer Widgets Styles */

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'footer_widgets_mode',
				'label'         => esc_html__( 'Footer Color Scheme', 'goya' ),
				'description'   => esc_html__( 'These styles are inherited to footer middle and bottom bar', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'footer_colors',
				'transport'       => 'postMessage',
				'default'       => 'light',
				'priority'      => 10,
				'choices'	      => array(
					'light'		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya'),
				),
				'js_vars'     => array(
					array(
						'element'  => '.site-footer',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'footer_widgets_background',
				'label'       => esc_html__( 'Footer Background', 'goya' ),
				'transport'       => 'auto',
				'section'     => 'footer_colors',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.site-footer','.site-footer.dark'),
						'property' => 'background-color',
					),
				),
			));


			/* Footer Bar Styles */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'footer_colors',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'footer_bar_custom',
				'label'       => esc_html__( 'Footer Bar Colors', 'goya' ),
				'description' => esc_html__( 'Custom colors for the bottom bar', 'goya' ),
				'section'     => 'footer_colors',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'footer_bar_mode',
				'label'         => esc_html__( 'Footer Bar Scheme', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'footer_colors',
				'default'       => 'light',
				'priority'      => 10,
				'choices'	      => array(
					'light'		=> esc_attr__('Light', 'goya'),
					'dark'		=> esc_attr__('Dark', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'footer_bar_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'js_vars'     => array(
					array(
						'element'  => '.footer-bar',
						'function' => 'toggleClass',
						'class'    => 'dark',
						'value'    => 'dark',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'footer_bar_background',
				'label'       => esc_html__( 'Footer bar background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'footer_colors',
				'default'     => '#ffffff',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'footer_bar_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => array('.site-footer .footer-bar.custom-color-1','.site-footer .footer-bar.custom-color-1.dark'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'footer_bar_social_icons_color',
				'label'       => esc_html__( 'Footer Bar Social Icons', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'footer_colors',
				'default'     => '#000000',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'footer_bar_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => array('.footer-bar.custom-color-1 .social-icons a'),
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'footer_toggle_widgets',
				'label'       => esc_html__( 'Collapse Widgets on Mobiles', 'goya' ),
				'section'     => 'footer_mobile',
				'default'     => false,
				'priority'    => 10,
			));


	/**
	 * BLOG
	 */
		/* Blog Main */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'blog_style',
				'label'       => esc_html__( 'Blog Layout', 'goya' ),
				'section'     => 'blog_list',
				'default'     => 'classic',
				'priority'    => 10,
				'choices'     => array(
					'classic'    => get_template_directory_uri() . '/assets/img/admin/options/blog-classic.png',
					'masonry'     => get_template_directory_uri() . '/assets/img/admin/options/blog-masonry.png',
					'grid'        => get_template_directory_uri() . '/assets/img/admin/options/blog-grid.png',
					'cards'     => get_template_directory_uri() . '/assets/img/admin/options/blog-cards.png',
					'list'        => get_template_directory_uri() . '/assets/img/admin/options/blog-list.png',
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'blog_style',
						'operator' => 'contains',
						'value'    => array('masonry', 'grid'),
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'blog_grid_columns',
				'label'       => esc_html__( 'Columns in masonry/grid layout', 'goya' ),
				'section'     => 'blog_list',
				'default'     => 3,
				'priority'    => 10,
				'choices'	  => array (
					'min'	=> 2,
					'max'	=> 4,
					'step'	=> 1
				),
				'required'    => array(
					array(
						'setting'  => 'blog_style',
						'operator' => 'contains',
						'value'    => array('masonry', 'grid'),
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'blog_style',
						'operator' => '==',
						'value'    => 'classic',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_title_overlay',
				'label'       => esc_html__( 'Title Overlay', 'goya' ),
				'description' => esc_html__( 'Only in Classic style', 'goya' ),
				'section'     => 'blog_list',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'blog_style',
						'operator' => '==',
						'value'    => 'classic',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'blog_list_animation',
				'label'       => esc_html__( 'Load animation', 'goya' ),
				'label'       => esc_html__( 'Animation to load the posts', 'goya' ),
				'section'     => 'blog_list',
				'default' 	  => 'animation bottom-to-top',
				'priority'    => 10,
				'choices'			=> $goya_animations_list,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Hero Title', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_hero_title',
				'label'       => esc_html__( 'Post Hero Title', 'goya' ),
				'description' => esc_html__( 'For main blog, archives and single posts', 'goya' ),
				'section'     => 'blog_list',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_transparent_header',
				'label'       => esc_html__( 'Transparent header', 'goya' ),
				'description' => esc_html__( 'For blog archives if hero title is active', 'goya' ),
				'section'     => 'blog_list',
				'default'     => false,
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'blog_menu_color',
				'label'         => esc_html__( 'Header/Description color mode', 'goya' ),
				'section'       => 'blog_list',
				'default'       => 'dark-title',
				'priority'      => 10,
				'choices'	      => array(
					'dark-title'		=> esc_attr__('Dark Text', 'goya'),
					'light-title'		=> esc_attr__('Light Text', 'goya'),
				),
				'required'      => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'blog_hero_title_bg',
				'label'       => esc_html__( 'Default Header Background Color', 'goya' ),
				'description' => esc_html__( 'You can choose header color scheme on each post', 'goya' ),
				'section'     => 'blog_list',
				'default'     => '#f8f8f8',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'blog_header_bg_image',
				'label'       => esc_html__( 'Blog home image Background', 'goya' ),
				'description'       => esc_html__( 'This image is only for the Main Blog page', 'goya' ),
				'section'     => 'blog_list',
				'priority'    => 10,
				'default'	  	=> '',
				'required'    => array(
					array(
						'setting'  => 'blog_hero_title',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_sidebar',
				'label'       => esc_html__( 'Blog Sidebar', 'goya' ),
				'section'     => 'blog_list',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'blog_sidebar_position',
				'label'       => esc_html__( 'Blog Sidebar Position', 'goya' ),
				'section'     => 'blog_list',
				'default'     => 'right',
				'priority'    => 10,
				'choices'			=> array(
					'right'			=> esc_html__('Right', 'goya'),
					'left'			=> esc_html__('Left', 'goya')
				),
				'required'    => array(
					array(
						'setting'  => 'blog_sidebar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));


			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Blog List Elements', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_category',
				'label'       => esc_html__( 'Show Post Category', 'goya' ),
				'section'     => 'blog_list',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_author',
				'label'       => esc_html__( 'Show Author', 'goya' ),
				'section'     => 'blog_list',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_date',
				'label'       => esc_html__( 'Show Date', 'goya' ),
				'section'     => 'blog_list',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_list',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'blog_pagination_style',
				'label'       => esc_html__( 'Blog Pagination', 'goya' ),
				'section'     => 'blog_list',
				'default'     => 'button',
				'priority'    => 10,
				'choices'     => array(
					'regular'     => esc_attr__('Regular', 'goya'),
					'button'      => esc_attr__('Load More', 'goya'),
					'scroll'      => esc_attr__('Infinite', 'goya'),
				),
			));

		/* Blog Categories */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_categories',
				'label'       => esc_html__( 'Blog Category Menu', 'goya' ),
				'section'     => 'blog_categories',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_categories',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'blog_categories_hide_empty',
				'label'       => esc_html__( 'Hide Empty Categories', 'goya' ),
				'section'     => 'blog_categories',
				'default'     => true,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'blog_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_categories',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'blog_categories_orderby',
				'label'       => esc_html__( 'Category Menu Order', 'goya' ),
				'section'     => 'blog_categories',
				'default'     => 'name',
				'priority'    => 10,
				'choices'     => array(
					'id'         => esc_attr__('ID', 'goya'),
					'name'       => esc_attr__('Name', 'goya'),
					'slug'       => esc_attr__('Slug', 'goya'),
					'count'      => esc_attr__('Count', 'goya'),
					'term_group' => esc_attr__('Term Group', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'blog_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_categories',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'blog_categories_order',
				'label'       => esc_html__( 'Order Direction', 'goya' ),
				'section'     => 'blog_categories',
				'default'     => 'asc',
				'priority'    => 10,
				'choices'     => array(
					'asc'         => esc_attr__('Ascending', 'goya'),
					'desc'       => esc_attr__('Descending', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'blog_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			));


		/* Blog Single */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'post_featured_image',
				'label'       => esc_html__( 'Featured Media Position', 'goya' ),
				'description' => esc_html__( 'Display featured image, gallery or video if present: 1.Header Background, 2.Below title, 3.No Featured', 'goya' ),
				'section'     => 'blog_single',
				'default'     => 'below',
				'priority'    => 10,
				'choices'     => array(
					'parallax' => get_template_directory_uri() . '/assets/img/admin/options/post-parallax.png',
					'below' => get_template_directory_uri() . '/assets/img/admin/options/post-below.png',
					'regular' => get_template_directory_uri() . '/assets/img/admin/options/post-regular.png',
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'post_featured_image',
						'operator' => '==',
						'value'    => 'parallax',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'post_transparent_header',
				'label'       => esc_html__( 'Post Transparent Header', 'goya' ),
				'description' => esc_html__( 'Used with Background Featured Media', 'goya' ),
				'section'     => 'blog_single',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'post_featured_image',
						'operator' => '==',
						'value'    => 'parallax',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));			

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'post_sidebar',
				'label'       => esc_html__( 'Single Post Sidebar', 'goya' ),
				'section'     => 'blog_single',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'post_sidebar_position',
				'label'       => esc_html__( 'Single Post Sidebar Position', 'goya' ),
				'section'     => 'blog_single',
				'default'     => 'right',
				'priority'    => 10,
				'choices'			=> array(
					'right'			=> esc_html__('Right', 'goya'),
					'left'			=> esc_html__('Left', 'goya')
				),
				'required'    => array(
					array(
						'setting'  => 'post_sidebar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'post_author',
				'label'       => esc_html__( 'Author Details', 'goya' ),
				'description' => esc_html__( 'Displays author information at the bottom, only if author description exists', 'goya' ),
				'section'     => 'blog_single',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'post_meta_bar',
				'label'       => esc_html__( 'Post Categories/Tags', 'goya' ),
				'section'     => 'blog_single',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'post_footer',
				'label'       => esc_html__( 'Show Footer on Single Posts', 'goya' ),
				'section'     => 'blog_single',
				'default'     => true,
				'priority'    => 10,
			));

		/* Blog Related */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'single_post_related',
				'label'       => esc_html__( 'Related Posts', 'goya' ),
				'section'     => 'blog_related',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'single_post_related_per_page',
				'label'       => esc_html__( 'Number of Related Posts', 'goya' ),
				'section'     => 'blog_related',
				'default'     => 3,
				'priority'    => 10,
				'choices'	  => array (
					'min'	=> 2,
					'max'	=> 6,
					'step'	=> 1
				),
				'required'    => array(
					array(
						'setting'  => 'single_post_related',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'single_post_related_columns',
				'label'       => esc_html__( 'Related Posts Columns', 'goya' ),
				'section'     => 'blog_related',
				'default'     => 3,
				'priority'    => 10,
				'choices'	  => array (
					'min'	=> 2,
					'max'	=> 4,
					'step'	=> 1
				),
				'required'    => array(
					array(
						'setting'  => 'single_post_related',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'blog_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'post_navigation',
				'label'       => esc_html__( 'Previous/Next Posts Links', 'goya' ),
				'section'     => 'blog_related',
				'priority'    => 10,
				'choices'     => array(
					''           => esc_attr__( 'Disable', 'goya' ),
					'simple'     => esc_attr__( 'Simple', 'goya' ),
					'image' => esc_attr__( 'Background Image', 'goya' ),
				),
				'required'    => array(
					array(
						'setting'  => 'single_post_related',
						'operator' => '==',
						'value'    => true,
					),
				),
				'default'	  	=> 'simple',
			));


	/**
	 * PORTFOLIO
	 */

	if ( ! apply_filters('goya_disable_portfolio', false) == true ) {

		/* Portfolio Home */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_post_type',
				'label'       => esc_html__( 'Enable Portfolio', 'goya' ),
				'description' => esc_html__( 'Activate portfolio post type', 'goya' ),
				'section'     => 'portfolio_main',
				'default'     => 'true',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_main',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'portfolio_main_page',
				'label'         => esc_html__( 'Portfolio Main Page', 'goya' ),
				'description'   => esc_html__('*With the "shortcode" you can insert the Portfolio anywhere using the Page Builder.', 'goya'),
				'section'       => 'portfolio_main',
				'default'       => 'automatic',
				'priority'      => 10,
				'choices'	      => array(
					'automatic'		=> esc_attr__('Automatic', 'goya'),
					'custom'		=> esc_attr__('Static Page', 'goya'),
					'shortcode'		=> esc_attr__('Use Shortcode*', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'dropdown-pages',
				'settings'    => 'portfolio_page_custom',
				'label'       => esc_html__( 'Portfolio Page', 'goya' ),
				'description' => esc_html__( 'Select your portfolio page. Best if the slug is the same as the permalink.', 'goya' ),
				'section'     => 'portfolio_main',
				'priority'    => 10,
				'default'	  	=> '',
				'required'      => array(
					array(
						'setting'  => 'portfolio_main_page',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_main',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'text',
				'settings'    => 'portfolio_permalink',
				'label'       => esc_html__( 'Permalink', 'goya' ),
				'description'		=> sprintf( '%s <br><span class="attention">%s</span>',
					esc_html__( 'Slug used for the portfolio permalinks. Default is "portfolio".', 'goya' ), 
					esc_html__( 'Re-save "Settings > Permalinks" page after changing.', 'goya' )
				),
				'section'     => 'portfolio_main',
				'default'     => 'portfolio',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_main',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'portfolio_layout_main',
				'label'       => esc_html__( 'Portfolio Layout', 'goya' ),
				'section'     => 'portfolio_main',
				'priority'    => 10,
				'choices'     => array(
					'masonry'  => esc_attr__( 'Masonry', 'goya' ),
					'grid'  => esc_attr__( 'Grid', 'goya' ),
					'list'   => esc_attr__( 'List', 'goya' ),
				),
				'choices'     => array(
					'masonry' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-masonry.png',
					'grid' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-grid.png',
					'list' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-list.png',
				),
				'default'	  	=> 'masonry',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'portfolio_columns',
				'label'       => esc_html__( 'Number of columns', 'goya' ),
				'section'     => 'portfolio_main',
				'priority'    => 10,
				'choices'     => array(
					'6' => esc_attr( '6 Columns', 'goya' ),
					'4' => esc_attr( '4 Columns', 'goya' ),
					'3' => esc_attr( '3 Columns', 'goya' ),
					'2' => esc_attr( '2 Columns', 'goya' ),
				),
				'default'	  	=> '4',
				'required'    => array(
					array(
						'setting'  => 'portfolio_layout_main',
						'operator' => '==',
						'value'    => 'grid',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'portfolio_item_margin',
				'label'       => esc_html__( 'Margins between items', 'goya' ),
				'section'     => 'portfolio_main',
				'priority'    => 10,
				'choices'     => array(
					'regular-padding' => esc_attr( 'Regular', 'goya' ),
					'no-padding' => esc_attr( 'No Margins', 'goya' ),
				),
				'default'	  	=> 'regular-padding',
				'required'    => array(
					array(
						'setting'  => 'portfolio_layout_main',
						'operator' => '!=',
						'value'    => 'list',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_list_alternate',
				'label'       => esc_html__( 'Alternate Columns', 'goya' ),
				'description' => esc_html__( 'Alternate image/text columns in List view', 'goya' ),
				'section'     => 'portfolio_main',
				'default'     => 'true',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'portfolio_layout_main',
						'operator' => '==',
						'value'    => 'list',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_main',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'portfolio_item_style',
				'label'       => esc_html__( 'Item Style', 'goya' ),
				'description' => esc_html__( 'The style for posts in the main portfolio page', 'goya' ),
				'section'     => 'portfolio_main',
				'priority'    => 10,
				'choices'     => array(
					'regular'   => esc_attr__( 'Regular', 'goya' ),
					'overlay'  => esc_attr__( 'Overlay', 'goya' ),
					'hover-card'  => esc_attr__( 'Hover Card', 'goya' ),
				),
				'default'	  	=> 'regular',
				'required'    => array(
					array(
						'setting'  => 'portfolio_layout_main',
						'operator' => '!=',
						'value'    => 'list',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'portfolio_animation',
				'label'       => esc_html__( 'Item animation', 'goya' ),
				'section'     => 'portfolio_main',
				'default' 	  => 'animation bottom-to-top',
				'priority'    => 10,
				'choices'			=> $goya_animations_list,
				'required'    => array(
					array(
						'setting'  => 'portfolio_layout_main',
						'operator' => '!=',
						'value'    => 'list',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_main',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_categories_nav',
				'label'       => esc_html__( 'Categories Navigation', 'goya' ),
				'description' => esc_html__( 'List of portfolio categories on top', 'goya' ),
				'section'     => 'portfolio_main',
				'default'     => 'true',
				'priority'    => 10,
			));

		/* Single Portfolio */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'portfolio_title_style',
				'label'       => esc_html__( 'Single Item Style', 'goya' ),
				'description' => esc_html__( '1. Regular, 2. Featured Image Background, 3. Hero Title', 'goya' ),
				'section'     => 'portfolio_single',
				'priority'    => 10,
				'choices'     => array(
					'regular' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-single-regular.png',
					'parallax' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-single-parallax.png',
					'hero' 	=> get_template_directory_uri() . '/assets/img/admin/options/portfolio-single-hero.png',
				),
				'default'	  	=> 'parallax',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'portfolio_header_style',
				'label'         => esc_html__( 'Header Color mode', 'goya' ),
				'section'     => 'portfolio_single',
				'default'       => 'dark-title',
				'priority'      => 10,
				'choices'	      => array(
					'dark-title'		=> esc_attr__('Dark Text', 'goya'),
					'light-title'		=> esc_attr__('Light Text', 'goya'),
				),
				'required'      => array(
					array(
						'setting'  => 'portfolio_title_style',
						'operator' => '!=',
						'value'    => 'regular',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_transparent_header',
				'label'       => esc_html__( 'Single Portfolio Transparent Header', 'goya' ),
				'description' => esc_html__( 'Used with Background Featured Media or Hero Title', 'goya' ),
				'section'     => 'portfolio_single',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'portfolio_title_style',
						'operator' => '!=',
						'value'    => 'regular',
					),
				),
			));


			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'portfolio_navigation',
				'label'       => esc_html__( 'Previous/Next Links', 'goya' ),
				'section'     => 'portfolio_single',
				'priority'    => 10,
				'choices'     => array(
					''           => esc_attr__( 'Disable', 'goya' ),
					'simple'     => esc_attr__( 'Simple', 'goya' ),
					'image' => esc_attr__( 'Background Image', 'goya' ),
				),
				'default'	  	=> 'simple',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_related',
				'label'       => esc_html__( 'Portfolio Related items', 'goya' ),
				'section'     => 'portfolio_single',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'portfolio_single',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'portfolio_footer',
				'label'       => esc_html__( 'Show Footer on Portfolios', 'goya' ),
				'section'     => 'portfolio_single',
				'default'     => false,
				'priority'    => 10,
			));

	} // End Portfolio Filter

	/**
	 * SHOP
	 */
		/* General Settings */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'editor',
				'settings'    => 'shop_header_description',
				'label'       => esc_html__( 'Main Shop Intro text', 'goya' ),
				'section'     => 'shop_general',
				'priority'    => 10,
				'default' 	  => '',
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_general',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'shop_infinite_load',
				'label'       => esc_html__( 'Shop Pagination', 'goya' ),
				'section'     => 'shop_general',
				'default'     => 'button',
				'priority'    => 10,
				'choices'     => array(
					'regular'     => esc_attr__('Regular', 'goya'),
					'button'      => esc_attr__('Load More', 'goya'),
					'scroll'      => esc_attr__('Infinite', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_general',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_catalog_mode',
				'label'       => esc_html__( 'Catalog Mode', 'goya' ),
				'description'		=> sprintf( '<span class="attention">%s</span>',
					esc_html__( '* Turn off the shopping functionality. All cart buttons and cart icon will be removed', 'goya' )
				), 
				'section'     => 'shop_general',
				'default'     => false,
				'priority'    => 10,
			));

		/* Shop Header */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_homepage_title_hide',
				'label'       => esc_html__( 'Hide main "Shop" title', 'goya' ),
				'description' => esc_html__( 'Useful if the Shop is set as homepage', 'goya' ),
				'section'     => 'shop_header',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_header',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_categories_list',
				'label'       => esc_html__( 'Show Categories List', 'goya' ),
				'section'     => 'shop_header',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_categories_list_thumbnail',
				'label'       => esc_html__( 'Show Category Thumbnail', 'goya' ),
				'section'     => 'shop_header',
				'default'     => false,
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'shop_categories_list',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_header',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'shop_hero_title',
				'label'       => esc_html__( 'Shop Hero Title', 'goya' ),
				'description' => esc_html__( 'Use hero title (big area with custom background) on:', 'goya' ),
				'section'     => 'shop_header',
				'choices'	      => array(
					'none'		=> esc_attr__('None', 'goya'),
					'main-hero'		=> esc_attr__('Main Shop only', 'goya'),
					'shop-hero'		=> esc_attr__('Product archives (shop, categories, search, tags, etc)', 'goya'),
					'all-hero'		=> esc_attr__('All WooCommerce pages', 'goya'),
				),
				'default'     => 'none',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_header',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_transparent_header',
				'label'       => esc_html__( 'Transparent header', 'goya' ),
				'description' => esc_html__( 'For all product archives if hero title is active', 'goya' ),
				'section'     => 'shop_header',
				'default'     => true,
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_header',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'shop_menu_color',
				'label'         => esc_html__( 'Header/Description color mode', 'goya' ),
				'description'   => esc_html__('You can change the color per category on the Category edit page', 'goya'),
				'section'       => 'shop_header',
				'default'       => 'dark-title',
				'priority'      => 10,
				'choices'	      => array(
					'dark-title'		=> esc_attr__('Dark Text', 'goya'),
					'light-title'		=> esc_attr__('Light Text', 'goya'),
				),
				'required'      => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));


			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'shop_header_bg_color',
				'label'       => esc_html__( 'Hero Color Background', 'goya' ),
				'description' => esc_html__( 'It can be changed on each Category', 'goya' ),
				'section'     => 'shop_header',
				'default'     => '#f8f8f8',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_header',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'image',
				'settings'    => 'shop_header_bg_image',
				'label'       => esc_html__( 'Hero Image Background', 'goya' ),
				'description' => esc_html__( 'This image is only for the Main Shop page', 'goya' ),
				'section'     => 'shop_header',
				'priority'    => 10,
				'default'	  	=> '',
				'required'    => array(
					array(
						'setting'  => 'shop_hero_title',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			));



		/* Products Listing */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Catalog Layout', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'shop_product_listing',
				'label'       => esc_html__( 'Product style', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => 'style1',
				'priority'    => 10,
				'choices'     => array(
					'style1' 	=> get_template_directory_uri() . '/assets/img/admin/options/shop-style1.png',
					'style2' 	=> get_template_directory_uri() . '/assets/img/admin/options/shop-style2.png',
					'style3' 	=> get_template_directory_uri() . '/assets/img/admin/options/shop-style3.png',
					'style4' 	=> get_template_directory_uri() . '/assets/img/admin/options/shop-style4.png',
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_full_width',
				'label'       => esc_html__( 'Full-width catalog', 'goya' ),
				'description' => esc_html__( 'No padding between content and left/right edges', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_product_img_hover',
				'label'       => esc_html__( 'Additional Image on Hover', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'           => 'multicheck',
				'settings'       => 'shop_addtocart_visible',
				'label'          => esc_html__( 'Add to Cart always visible', 'goya' ),
				'description'    => esc_html__( 'Keep the add to cart button always visible on', 'goya' ),
				'section'        => 'shop_listing',
				'default'        => array(),
				'priority'       => 10,
				'multiple'       => 1,
				'choices'        => array(
					'mobile'         => esc_attr__('Mobiles', 'goya'),
					'desktop' => esc_attr__('Desktops (Product Style 1)', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"><h3>' . esc_html__( 'Animations', 'goya' ) . '</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'shop_product_animation',
				'label'       => esc_html__( 'Load animation', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'shop_listing',
				'default' 	  => 'animation bottom-to-top',
				'priority'    => 10,
				'choices'			=> $goya_animations_list,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'select',
				'settings'    => 'shop_product_animation_hover',
				'label'       => esc_html__( 'Hover animation', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'shop_listing',
				'default'     => 'zoom-jump',
				'priority'    => 10,
				'choices'     => array(
					'' => esc_html__( 'None', 'goya' ),
					'zoom' => esc_html__( 'Zoom', 'goya' ),
					'jump' => esc_html__( 'Jump', 'goya' ),
					'zoom-jump' => esc_html__( 'Zoom + Jump', 'goya' ),
				),
				'js_vars'     => array(
					array(
						'element'  => 'li.type-product .product-inner',
						'function' => 'toggleClass',
						'class'    => 'hover-animation-zoom',
						'value'    => 'zoom',
					),
					array(
						'element'  => 'li.type-product .product-inner',
						'function' => 'toggleClass',
						'class'    => 'hover-animation-jump',
						'value'    => 'jump',
					),
					array(
						'element'  => 'li.type-product .product-inner',
						'function' => 'toggleClass',
						'class'    => 'hover-animation-zoom-jump',
						'value'    => 'zoom-jump',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'View Modes', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Grid View icon will appear automatically if you enable one of the following options', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));
			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_view_small',
				'label'       => esc_html__( 'Small Grid icon', 'goya' ),
				'description' => esc_html__( 'On large screens only', 'goya' ), 
				'transport'   => 'postMessage',
				'section'     => 'shop_listing',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => '.shop-views',
						'function' => 'toggleClass',
						'class'    => 'small-1',
						'value'    => true,
					),
				),
			));
			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_view_list',
				'label'       => esc_html__( 'List View icon', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'shop_listing',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => '.shop-views',
						'function' => 'toggleClass',
						'class'    => 'list-1',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Elements', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_sale_flash',
				'label'       => esc_html__( '"Sale" Flash Badge', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => 'pct',
				'priority'    => 10,
				'choices'     => array(
					'disabled'          => esc_attr__('Disabled', 'goya'),
					'txt'      => esc_attr__('Text', 'goya'),
					'pct'      => esc_attr__('Percentage', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_new_badge',
				'label'       => esc_html__( '"New" Badge', 'goya' ),
				'description' => esc_html__( 'Show "New" badge on recent products', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'new_badge_duration',
				'label'       => esc_html__( 'Days to show "New" badge', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => 5,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 1,
					'max'	=> 30,
					'step'	=> 1
				),
				'required'    => array(
					array(
						'setting'  => 'product_new_badge',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_outofstock_badge',
				'label'       => esc_html__( '"Out of Stock" Badge', 'goya' ),
				'description' => esc_html__( 'Show "Out of Stock" badge on the catalog', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_listing',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'rating_listing',
				'label'       => esc_html__( 'Rating in Catalog', 'goya' ),
				'section'     => 'shop_listing',
				'default'     => false,
				'priority'    => 10,
			));


		/* Product Filters */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Sidebar/Filters', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_filters',
				'label'       => esc_html__( 'Enable Sidebar/Filters', 'goya' ),
				'description' => esc_html__( 'It can display other widgets but it\'s intended for filters', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'shop_filter_position',
				'label'       => esc_html__( 'Shop Filters Position', 'goya' ),
				'description'       => esc_html__( '1.Top, 2.Sidebar, 3.Off-canvas', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => 'header',
				'priority'    => 10,
				'choices'     => array(
					'header' 	=> get_template_directory_uri() . '/assets/img/admin/options/filter-top.png',
					'sidebar' 	=> get_template_directory_uri() . '/assets/img/admin/options/filter-side.png',
					'popup' 	=> get_template_directory_uri() . '/assets/img/admin/options/filter-offcanvas.png',
				),
				/*'required'    => array(
					array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'sidebar',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'shop_filters_sidebar_width',
				'label'       => esc_html__( 'Max width of side bar', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_filters',
				'default'     => 350,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 200,
					'max'	=> 400,
					'step'	=> 1
				),
				'required'    => array(
					/*array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),*/
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'sidebar',
					),
				),
				'output'      => array(
					array(
						'element'  => array('.shop-sidebar-col'),
						'property' => 'max-width',
						'units'    => 'px',
						'media_query' => '@media all and (min-width:992px)'
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'shop_filters_columns',
				'label'       => esc_html__( 'Number of Filter Columns', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => 4,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 1,
					'max'	=> 6,
					'step'	=> 1
				),
			/*	'required'    => array(
					array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'header',
					),
				),*/
				'required'    => array(
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'header',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_sidebar_sticky',
				'label'       => esc_html__( 'Sidebar Sticky', 'goya' ),
				'description' => esc_html__( 'Keep the sidebar fixed while scrolling', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => true,
				'priority'    => 10,
				'required'    => array(
					/*array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),*/
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'sidebar',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_filters_scrollbar',
				'label'       => esc_html__( 'Filters Scrollbar', 'goya' ),
				'description' => esc_html__( 'Disable if you are using a 3rd party plugin with its own scrolling options', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => true,
				'priority'    => 10,
				/*'required'    => array(
					array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),
				),*/
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'shop_filters_height',
				'label'       => esc_html__( 'Scrollbar Max Height ', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => 150,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 40,
					'max'	=> 300,
					'step'	=> 1
				),
				'required'    => array(
					/*array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),*/
					array(
						'setting'  => 'shop_filters_scrollbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_filters',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'shop_filters_sidebar_position',
				'label'       => esc_html__( 'Sidebar Position', 'goya' ),
				'section'     => 'shop_filters',
				'default'     => 'left',
				'priority'    => 10,
				'choices'     => array(
					'left'  		=> esc_attr__( 'Left', 'goya' ),
					'right'   	=> esc_attr__( 'Right', 'goya' ),
				),
				'required'    => array(
					/*array(
						'setting'  => 'shop_filters',
						'operator' => '==',
						'value'    => true,
					),*/
					array(
						'setting'  => 'shop_filter_position',
						'operator' => '==',
						'value'    => 'sidebar',
					),
				),
			));

			if ( class_exists('Woo_Variation_Swatches') ) {

				Kirki::add_field( 'goya_config', array(
					'type'        => 'custom',
					'settings'    => 'separator_' . $sep++,
					'section'     => 'shop_variations',
					'default'     => '<div class="kirki-separator"><h3>' . 
						esc_html__( 'Variations', 'goya' ) . '</h3><p>' . 
						esc_html__( 'If you have "WooCommerce Variation Swatches PRO" go to the plugin settings to enable the option.', 'goya' ) . 
						'</p></div>',
					'priority'    => 10,
				));

				if (!class_exists('Woo_Variation_Swatches_Pro') ) {

					Kirki::add_field( 'goya_config', array(
						'type'        => 'toggle',
						'settings'    => 'archive_show_swatches',
						'label'       => esc_html__( 'Display color/image swatches', 'goya' ),
						'description'       => esc_html__( 'For catalog pages', 'goya' ),
						'section'     => 'shop_variations',
						'default'     => false,
						'priority'    => 10,
					));

					if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
						
						Kirki::add_field( 'goya_config', array(
							'type'        => 'toggle',
							'settings'    => 'archive_check_variants_stock',
							'label'       => esc_html__( 'Check variations stock', 'goya' ),
							'description'		=> sprintf( '<span class="attention">%s</span>',
								esc_html__( '* Warning: For small catalogs only, it may slow down your site otherwise', 'goya' )
							), 
							'section'     => 'shop_variations',
							'default'     => false,
							'priority'    => 10,
							'required'    => array(
								array(
									'setting'  => 'archive_show_swatches',
									'operator' => '==',
									'value'    => true,
								),
							),
						));

					}

					Kirki::add_field( 'goya_config', array(
						'type'        => 'toggle',
						'settings'    => 'archive_show_all_variants',
						'label'       => esc_html__( 'Display all variations', 'goya' ),
						'description' => esc_attr__( 'Display all variations, not just color/image swatches.', 'goya' ),
						'section'     => 'shop_variations',
						'default'     => false,
						'priority'    => 10,
						'required'    => array(
							array(
								'setting'  => 'archive_show_swatches',
								'operator' => '==',
								'value'    => true,
							),
						),
					));

					Kirki::add_field( 'goya_config', array(
						'type'        => 'custom',
						'settings'    => 'separator_' . $sep++,
						'section'     => 'shop_variations',
						'default'     => '<div class="kirki-separator"></div>',
						'priority'    => 10,
					));

					Kirki::add_field( 'goya_config', array(
						'type'        => 'radio-buttonset',
						'settings'    => 'archive_swatches_position',
						'label'       => esc_html__( 'Swatches position on desktops', 'goya' ),
						'description' => esc_html__( 'For product style 1 and 2 only', 'goya' ),
						'transport'   => 'postMessage',
						'section'     => 'shop_variations',
						'default'     => 'bottom',
						'priority'    => 10,
						'choices'	    => array(
							'bottom'		=> esc_attr__('Bottom', 'goya'),
							'side'		  => esc_attr__('Side', 'goya')
						),
						'required'    => array(
							array(
								'setting'  => 'archive_show_swatches',
								'operator' => '==',
								'value'    => true,
							),
							array(
								'setting'  => 'archive_show_all_variants',
								'operator' => '!=',
								'value'    => true,
							),
							array(
								'setting'  => 'shop_product_listing',
								'operator' => 'contains',
								'value'    => array('style1', 'style2'),
							),
						),
					));

				}

			}

		/* Minicart */

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'minicart_panel',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Mini Cart', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'header_cart_icon_function',
			'label'       => esc_html__( 'Cart icon action', 'goya' ),
			'description'       => esc_html__( 'What will the cart icon do on click?', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'minicart_panel',
			'default'     => 'mini-cart',
			'priority'    => 10,
			'choices'	    => array(
				'mini-cart'	=> esc_attr__('Open Minicart', 'goya'),
				'cart-page'	=> esc_attr__('Go to Cart page', 'goya')
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'minicart_panel',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'open_minicart_automatically',
			'label'       => esc_html__( 'Open minicart automatically', 'goya' ),
			'description' => esc_html__( 'The minicart will open automatically when a product is added to cart ', 'goya' ),
			'section'     => 'minicart_panel',
			'default'     => true,
			'priority'    => 10,
			'required' => array(
				array(
					'setting' => 'header_cart_icon_function', 
					'operator' => '==', 
					'value' => 'mini-cart'
				)
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'minicart_panel',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'header_cart_icon',
			'label'       => esc_html__( 'Icon type', 'goya' ),
			'description' => esc_html__( 'Check in the Customizer: Header > Header Layout. It will be also used for \'add to cart\' buttons', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'minicart_panel',
			'default'     => 'bag',
			'priority'    => 10,
			'choices'	    => array(
				'cart'		=> esc_attr__('Cart', 'goya'),
				'bag'		  => esc_attr__('Bag', 'goya')
			),
			'partial_refresh' => array(
				'header_cart_icon_partial' => array(
					'selector'        => '.quick_cart',
					'container_inclusive' => true,
					'render_callback' => function() {
						get_template_part( 'inc/templates/header-parts/cart' );
					},
				),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'minicart_panel',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-image',
			'settings'    => 'header_cart_position',
			'label'       => esc_html__( 'Cart Open Position', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'minicart_panel',
			'default'     => 'side',
			'priority'    => 10,
			'choices'	  	=> array(
				'side' => get_template_directory_uri() . '/assets/img/admin/options/cart-side.png',
				'top' => get_template_directory_uri() . '/assets/img/admin/options/cart-top.png',
			),
			'required' => array(
				array(
					'setting' => 'header_cart_icon_function', 
					'operator' => '==', 
					'value' => 'mini-cart'
				)
			),
			'js_vars'     => array(
				array(
					'element'  => '#side-cart',
					'function' => 'toggleClass',
					'class'    => 'top',
					'value'    => 'top',
				),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'header_cart_color',
			'label'       => esc_html__( 'Cart Panel Color Scheme', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'minicart_panel',
			'default'     => 'light',
			'priority'    => 10,
			'choices'	  => array(
				'light'		=> esc_attr__('Light', 'goya'),
				'dark'		=> esc_attr__('Dark', 'goya')
			),
			'required' => array(
				array(
					'setting' => 'header_cart_icon_function', 
					'operator' => '==', 
					'value' => 'mini-cart'
				)
			),
			'js_vars'     => array(
				array(
					'element'  => '#side-cart',
					'function' => 'toggleClass',
					'class'    => 'dark',
					'value'    => 'dark',
				),
			),
		));


		/* Catalog Quick View */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_quickview',
				'label'       => esc_html__( 'Show Quick View', 'goya' ),
				'section'     => 'shop_quickview',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_quickview',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'product_quickview_width',
				'label'       => esc_html__( 'Quick View max-width', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_quickview',
				'default'     => 960,
				'priority'    => 10,
				'choices'	  => array (
					'min'	=> 910,
					'max'	=> 1160,
					'step'	=> 50
				),
				'required'    => array(
					array(
						'setting'  => 'product_quickview',
						'operator' => '==',
						'value'    => true,
					),
				),
				'output'      => array(
					array(
						'element'  => '.mfp #et-quickview',
						'property' => 'max-width',
						'units'    => 'px',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_quickview',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_quickview_summary_layout',
				'label'       => esc_html__( 'Product Summary Alignment', 'goya' ),
				'description'  => esc_html__( 'Bottom works better when your images are taller', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'shop_quickview',
				'default'     => 'align-top',
				'priority'    => 10,
				'choices'     => array(
					'align-top'    => esc_attr__( 'Top', 'goya' ),
					'align-bottom' => esc_attr__( 'Bottom', 'goya' ),
				),
				'required'    => array(
					array(
						'setting'  => 'product_quickview',
						'operator' => '==',
						'value'    => true,
					),
				),
				'js_vars'     => array(
					array(
						'element'  => '.et-qv-summary-content',
						'function' => 'toggleClass',
						'class'    => 'align-top',
						'value'    => 'align-top',
					),
					array(
						'element'  => '.et-qv-summary-content',
						'function' => 'toggleClass',
						'class'    => 'align-bottom',
						'value'    => 'align-bottom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_quickview',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_quickview_atc',
				'label'       => esc_html__( 'Display add-to-cart button', 'goya' ),
				'section'     => 'shop_quickview',
				'default'     => true,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'product_quickview',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

		/* Checkout */

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'checkout',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Cart', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'shopping_cart_auto_update',
			'label'       => esc_html__( 'Auto update Cart', 'goya' ),
			'description' => esc_html__( 'Auto update cart on quantity change. "Update" button will remain hidden.', 'goya' ),
			'section'     => 'checkout',
			'default'     => false,
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'shopping_cart_empty_cart',
			'label'       => esc_html__( 'Empty Cart button', 'goya' ),
			'description' => esc_html__( 'Button to remove all products from the cart.', 'goya' ),
			'section'     => 'checkout',
			'default'     => false,
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'checkout',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Checkout', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'checkout_style',
			'label'       => esc_html__( 'Checkout mode', 'goya' ),
			'description'	=> esc_html__( '"Distraction Free" removes header and footer on checkout page.', 'goya' ),
			'section'     => 'checkout',
			'default'     => 'free',
			'priority'    => 10,
			'choices'	  => array(
				'free'		=> esc_attr__('Distraction Free', 'goya'),
				'regular'		=> esc_attr__('Classic', 'goya')
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'checkout',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'checkout_terms_popup',
			'label'       => esc_html__( 'Terms & Conditions Lightbox', 'goya' ),
			'description' => esc_html__( 'Display Terms & Conditions in Lightbox', 'goya' ),
			'section'     => 'checkout',
			'default'     => true,
			'priority'    => 10,
		));


		/* Progress Bar */

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'progress_bar_enable',
			'label'       => esc_html__( 'Enable progress bar', 'goya' ),
			'description' => esc_html__( 'Show a progress bar on the defined locations', 'goya' ),
			'section'     => 'shop_progress_bar',
			'default'     => false,
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'default'     => '<div class="kirki-separator"></div>',
			'section'     => 'shop_progress_bar',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'           => 'multicheck',
			'settings'       => 'progress_bar_locations',
			'label'          => esc_html__( 'Locations', 'goya' ),
			'description'    => esc_html__( 'Choose at least 1', 'goya' ),
			'section'        => 'shop_progress_bar',
			'default'        => array('minicart'),
			'priority'       => 10,
			'multiple'       => 1,
			'choices'        => array(
				'minicart'         => esc_attr__('Mini Cart', 'goya'),
				'cart' => esc_attr__('Cart page', 'goya'),
				'single-product' => esc_attr__('Single product', 'goya'),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'shop_progress_bar',
			'default'     => '<div class="kirki-separator"><h3>' . 
				esc_html__( 'Amount', 'goya' ) . '</h3><p>' . 
				esc_html__( 'This option is completely manual and not connected to Shipping methods', 'goya' ) . 
				'</p></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'number',
			'settings'    => 'progress_bar_goal',
			'label'       => esc_html__( 'Goal amount', 'goya' ),
			'description' => esc_html__( 'Amount to reach 100%', 'goya' ),
			'section'     => 'shop_progress_bar',
			'default'     => 0,
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'shop_progress_bar',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'progress_bar_subtotal_taxes',
			'label'       => esc_html__( 'Apply taxes', 'goya' ),
			'description' => esc_html__( 'Calculate subtotal with taxes', 'goya' ),
			'section'     => 'shop_progress_bar',
			'default'     => true,
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'shop_progress_bar',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Messages', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'editor',
			'settings'    => 'progress_bar_msg',
			'label'       => esc_html__( 'Initial Message', 'goya' ),
			'description'	=> esc_html__( 'Message to show before reaching the goal. Use shortcode [missing_amount] to display the amount left to reach the minimum', 'goya' ),
			'section'     => 'shop_progress_bar',
			'priority'    => 10,
			'default' 	  => 'Add [missing_amount] more to get <strong>Free Shipping!</strong>',
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'editor',
			'settings'    => 'progress_bar_success_msg',
			'label'       => esc_html__( 'Success message', 'goya' ),
			'description'	=> esc_html__( 'Message to show after reaching 100%.', 'goya' ),
			'section'     => 'shop_progress_bar',
			'priority'    => 10,
			'default' 	  => '<strong>You\'ve got free shipping!</strong>',
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'shop_progress_bar',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Colors', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'color',
			'settings'    => 'progress_bar_color',
			'label'       => esc_html__( 'Progress bar color', 'goya' ),
			'transport' => 'auto',
			'section'     => 'shop_progress_bar',
			'default'     => '#b9a16b',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'color',
			'settings'    => 'progress_bar_success_color',
			'label'       => esc_html__( 'Progress bar success color', 'goya' ),
			'label'       => esc_html__( 'Color after reaching 100%', 'goya' ),
			'transport' => 'auto',
			'section'     => 'shop_progress_bar',
			'default'     => '#67bb67',
			'priority'    => 10,
		));


		/* Shop Mobile */

		Kirki::add_field( 'goya_config', array(
			'type'        => 'slider',
			'settings'    => 'shop_columns_mobile',
			'label'       => esc_html__( 'Columns in catalog', 'goya' ),
			'section'     => 'shop_mobile',
			'default'     => 2,
			'priority'    => 10,
			'choices'	  => array (
				'min'	=> 1,
				'max'	=> 2,
				'step'	=> 1
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'shop_mobile',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'shop_sticky_filters',
			'label'       => esc_html__( 'Fix filters bar to bottom', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'shop_mobile',
			'default'     => false,
			'priority'    => 10,
			'required'    => array(
				array(
					'setting'  => 'shop_filters',
					'operator' => '==',
					'value'    => true,
				),
			),
			'js_vars'     => array(
				array(
					'element'  => '.shop-filters',
					'function' => 'toggleClass',
					'class'    => 'sticky-filters',
					'value'    => true,
				),
			),
		));


	/**
	 * PRODUCT PAGE
	 */
		
		/* Product Page */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Main Layout', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'       => 'radio-image',
				'settings'   => 'product_layout_single',
				'label'      => esc_html__( 'Product Page Layout', 'goya' ),
				'description' => esc_html__( '1.Regular, 2.Showcase, 3.No Padding, 4.Full Width', 'goya' ),
				'section'    => 'product_layout',
				'default'    => 'regular',
				'priority'   => 10,
				'choices'    => array(
					'regular'    => get_template_directory_uri() . '/assets/img/admin/options/product-regular.png',
					'showcase'    => get_template_directory_uri() . '/assets/img/admin/options/product-showcase.png',
					'no-padding' => get_template_directory_uri() . '/assets/img/admin/options/product-nopadding.png',
					'full-width' => get_template_directory_uri() . '/assets/img/admin/options/product-fullwidth.png',
					),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_transparent_header',
				'label'       => esc_html__( 'Transparent Header', 'goya' ),
				'description' => esc_html__( 'Always transparent in Showcase mode.', 'goya' ),
				'section'     => 'product_layout',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_header_color',
				'label'       => esc_html__( 'Product header mode', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'dark-title',
				'priority'    => 10,
				'choices'	  => array(
					'dark-title'		=> esc_attr__('Dark Text', 'goya'),
					'light-title'		=> esc_attr__('Light Text', 'goya'),
				),
				'required'    => array(
					array(
						'setting'  => 'product_transparent_header',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_title_position',
				'label'       => esc_html__( 'Title Position', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'right',
				'priority'    => 10,
				'choices'     => array(
					'right'        => esc_attr__('Right', 'goya'),
					'top'   => esc_attr__('Top', 'goya'),
				),
				'required' => array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '!=', 
						'value' => 'no-padding'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'single_product_background',
				'label'       => esc_html__( 'Product Info Background', 'goya' ),
				'section'     => 'product_layout',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'single_product_background_color',
				'label'       => esc_html__( 'Info Background Color', 'goya' ),
				'description' => esc_html__( 'This is the global value. You can change the color individually on each product', 'goya' ),
				'section'     => 'product_layout',
				'default'     => '#f8f8f8',
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'single_product_background', 
						'operator' => '==', 
						'value' => true
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_showcase_style',
				'label'       => esc_html__( 'Info Text Color', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'dark-text',
				'priority'    => 10,
				'choices'	  => array(
					'dark-text'		=> esc_attr__('Dark Text', 'goya'),
					'light-text'		=> esc_attr__('Light Text', 'goya'),
				),
				'required' => array(
					array(
						'setting' => 'single_product_background', 
						'operator' => '==', 
						'value' => true
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '==', 
						'value' => 'showcase'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_showcase_fixed',
				'label'       => esc_html__( 'Fixed options/buttons', 'goya' ),
				'description' => esc_html__( 'Fix cart button and options to the bottom in "Showcase" layout.', 'goya' ),
				'section'     => 'product_layout',
				'default'     => false,
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '==', 
						'value' => 'showcase'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_variations_style',
				'label'       => esc_html__( 'Product variation style', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'table',
				'priority'    => 10,
				'choices'     => array(
					'table'     => esc_attr__('Table', 'goya'),
					'vertical'  => esc_attr__('Vertical', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Product Details', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'product_details_style',
				'label'       => esc_html__( 'Product Details Mode', 'goya' ),
				'description' => esc_html__( 'WooCommerce default is Tabs.', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'tabs',
				'priority'    => 10,
				'choices'     => array(
					'tabs'      => esc_attr__('Tabs', 'goya'),
					'accordion' => esc_attr__('Accordion (next to product gallery)', 'goya'),
					'vertical'   	=> esc_attr__('Vertical', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_details_style', 
						'operator' => '==', 
						'value' => 'accordion'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_accordion_swap_description',
				'label'       => esc_html__( 'Swap short/full description', 'goya' ),
				'description' => esc_html__( 'Add short description to the accordion and move full description below the product details. ', 'goya' ),
				'section'     => 'product_layout',
				'default'     => true,
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_details_style', 
						'operator' => '==', 
						'value' => 'accordion'
					)
				)
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_accordion_scrollbars',
				'label'       => esc_html__( 'Accordion scrollbars', 'goya' ),
				'description' => esc_html__( 'Set maximum height and make accordion sections scrollable', 'goya' ),
				'section'     => 'product_layout',
				'default'     => false,
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_details_style', 
						'operator' => '==', 
						'value' => 'accordion'
					)
				)
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'product_accordion_max_height',
				'label'       => esc_html__( 'Scrollbar Max Height', 'goya' ),
				'description' => esc_html__( 'The maximum height for accordion sections', 'goya' ),
				'section'     => 'product_layout',
				'default'     =>300,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 50,
					'max'	=> 500,
					'step'	=> 5
				),
				'required' => array(
					array(
						'setting' => 'product_details_style', 
						'operator' => '==', 
						'value' => 'accordion'
					),
					array(
						'setting' => 'product_accordion_scrollbars', 
						'operator' => '==', 
						'value' => true
					)
				)
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_short_desc_open',
				'label'       => esc_html__( 'Open first section on page load', 'goya' ),
				'section'     => 'product_layout',
				'default'     => true,
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_details_style', 
						'operator' => '==', 
						'value' => 'accordion'
					)
				)
			));			

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_layout',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_description_layout',
				'label'       => esc_html__( 'Description Layout', 'goya' ),
				'description' => esc_html__( 'Use "Full Width" if you plan to use Page Builder for edge to edge descriptions. You can change the layout on each product too.', 'goya' ),
				'section'     => 'product_layout',
				'default'     => 'boxed',
				'priority'    => 10,
				'choices'     => array(
					'boxed' => esc_attr__('Boxed', 'goya'),
					'full'  => esc_attr__('Full Width', 'goya'),
				),
			));


		/* Product Gallery  */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Gallery Layout', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-image',
				'settings'    => 'product_gallery_style',
				'label'       => esc_html__( 'Product Gallery Style', 'goya' ),
				'description' => esc_html__( '1.Slider, 2. Column, 3. Grid. On mobiles it\'s always slider', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'product_gallery',
				'default'     => 'carousel',
				'priority'    => 10,
				'choices'     => array(
					'carousel' => get_template_directory_uri() . '/assets/img/admin/options/product-gallery-carousel.png',
					'column' => get_template_directory_uri() . '/assets/img/admin/options/product-gallery-column.png',
					'grid' => get_template_directory_uri() . '/assets/img/admin/options/product-gallery-grid.png',
				),
				'js_vars'     => array(
					array(
						'element'  => '.et-product-detail',
						'function' => 'toggleClass',
						'class'    => 'et-product-gallery-carousel',
						'value'    => 'carousel',
					),
					array(
						'element'  => '.et-product-detail',
						'function' => 'toggleClass',
						'class'    => 'et-product-gallery-column',
						'value'    => 'column',
					),
					array(
						'element'  => '.et-product-detail',
						'function' => 'toggleClass',
						'class'    => 'et-product-gallery-grid',
						'value'    => 'grid',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required' 		=> array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '!=',
						'value' => 'full-width'
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'product_gallery_width',
				'label'       => esc_html__( 'Gallery width ratio', 'goya' ),
				'description' => esc_html__( 'In a grid of 12 columns. Default 7/12', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'product_gallery',
				'default'     => 7,
				'priority'    => 10,
				'choices'	  => array(
					'min'	=> 5,
					'max'	=> 8,
					'step'	=> 1
				),
				'required' 		=> array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '!=',
						'value' => 'full-width'
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_gallery_transition',
				'label'       => esc_html__( 'Gallery Image Transition', 'goya' ),
				'description' => esc_html__( 'Image transition with carousel gallery and mobiles', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => 'slide',
				'priority'    => 10,
				'choices'     => array(
					'fade' => esc_attr__( 'Fade', 'goya' ),
					'slide' => esc_attr__( 'Slide', 'goya' ),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_sticky_section',
				'label'       => esc_html__( 'Sticky Section', 'goya' ),
				'description'       => esc_html__( 'SHORTER section to keep sticky. Automatically set to Summary with Grid or Column gallery', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => 'summary',
				'priority'    => 10,
				'choices'     => array(
					'gallery'   		=> esc_attr__('Gallery', 'goya'),
					'summary'     => esc_attr__('Summary', 'goya'),
					'none'     => esc_attr__('Disable', 'goya'),
				),
				'required' 		=> array(
					array(
						'setting' => 'product_layout_single', 
						'operator' => '!=',
						'value' => 'full-width'
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Thumbnails', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'product_thumbnails_position',
				'label'       => esc_html__( 'Desktop Thumbnails Position', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'product_gallery',
				'default'     => 'side',
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_gallery_style', 
						'operator' => '==', 
						'value' => 'carousel'
					)
				),
				'choices'     => array(
					'side'        => esc_attr__( 'Side', 'goya' ),
					'bottom'      => esc_attr__( 'Bottom', 'goya' ),
				),
				'js_vars'     => array(
					array(
						'element'  => '.et-product-detail',
						'function' => 'toggleClass',
						'class'    => 'thumbnails-vertical',
						'value'    => 'side',
					),
					array(
						'element'  => '.et-product-detail',
						'function' => 'toggleClass',
						'class'    => 'thumbnails-horizontal',
						'value'    => 'bottom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_thumbnails_swap_hover',
				'label'       => esc_html__( 'Swap images on hover', 'goya' ),
				'description'       => esc_html__( 'Don\'t need to click on the thumbnails', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => false,
				'priority'    => 10,
				'required' => array(
					array(
						'setting' => 'product_gallery_style', 
						'operator' => '==', 
						'value' => 'carousel'
					)
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_image_lightbox',
				'label'       => esc_html__( 'Product Image Lightbox', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_image_hover_zoom',
				'label'       => esc_html__( 'Product Image Zoom', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_gallery',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'featured_video',
				'label'       => esc_html__( 'Video link position', 'goya' ),
				'section'     => 'product_gallery',
				'default'     => 'gallery',
				'priority'    => 10,
				'choices'     => array(
					'gallery' => esc_attr__( 'Icon in gallery', 'goya' ),
					'summary' => esc_attr__( 'Product summary', 'goya' ),
				),
			));

		/* Product Elements */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_single_ajax_addtocart',
				'label'       => esc_html__( 'Ajax Add to Cart', 'goya' ),
				'description' => esc_html__( 'Enable Ajax on single product page', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_cart_buttons_layout',
				'label'       => esc_html__( 'Quantity / Add to Cart layout', 'goya' ),
				'description' => esc_html__( 'Some 3rd party plugins may be incompatible with Horizontal or Mixed layout', 'goya' ),
				'description'		=> sprintf( '<span class="attention">%s</span>',
					esc_html__( 'Some 3rd party plugins may be incompatible with Horizontal or Mixed layout', 'goya' )
				), 
				'section'     => 'product_elements',
				'default'     => 'mixed',
				'priority'    => 10,
				'choices'     => array(
					'stacked'     => esc_attr__('Classic', 'goya'),
					'horizontal'   		=> esc_attr__('Horizontal', 'goya'),
					'mixed'   		=> esc_attr__('Mixed', 'goya'),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Sticky Bar', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_sticky_bar',
				'label'       => esc_html__( 'Sticky Product Bar', 'goya' ),
				'description' => esc_html__( 'Show product image, name and cart button while scrolling', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_sticky_bar_position',
				'label'       => esc_html__( 'Product Bar Position', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'product_elements',
				'default'     => 'top',
				'priority'    => 10,
				'choices'	  => array(
					'top'		=> esc_attr__('Top', 'goya'),
					'bottom'		=> esc_attr__('Bottom', 'goya')
				),
				'required'    => array(
					array(
						'setting'  => 'product_sticky_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'fixed-product-bar-bottom',
						'value'    => 'bottom',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'product_sticky_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_sticky_bar_trigger_only',
				'label'       => esc_html__( 'Sticky Add to Cart - button only', 'goya' ),
				'description' => esc_html__( 'A single button for variable products, no variations on the sticky bar. Useful for compatiblity with 3rd party plugins or if you have a lot of variations', 'goya' ),
				'section'     => 'product_elements',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'product_sticky_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'product_sticky_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_sticky_bar_mobile',
				'label'       => esc_html__( 'Sticky Add to Cart (mobiles)', 'goya' ),
				'description' => esc_html__( 'Show add to cart button fixed at the bottom on mobiles', 'goya' ),
				'section'     => 'product_elements',
				'default'     => false,
				'priority'    => 10,
				'required'    => array(
					array(
						'setting'  => 'product_sticky_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Other Elements', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_breadcrumbs',
				'label'       => esc_html__( 'Breadcrumbs', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_meta_sku',
				'label'       => esc_html__( 'SKU', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_meta_categories',
				'label'       => esc_html__( 'Categories', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_meta_tags',
				'label'       => esc_html__( 'Tags', 'goya' ),
				'description' => esc_html__( 'Deactivate the 3 options (SKU, Categories, Tags) to completely remove the Meta section', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_share_buttons',
				'label'       => esc_html__( 'Share Buttons', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_reviews',
				'label'       => esc_html__( 'Reviews & Ratings', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_elements',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'single_product_sale_flash',
				'label'       => esc_html__( 'Single product "Sale" badge', 'goya' ),
				'section'     => 'product_elements',
				'default'     => true,
				'priority'    => 10,
			));

		/* Size Guide */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_size_guide',
				'label'       => esc_html__( 'Enable Size Guide', 'goya' ),
				'description' => esc_html__( 'You can override this setting on each product', 'goya' ),
				'section'     => 'product_size',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_size',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'dropdown-pages',
				'settings'    => 'product_size_page',
				'label'       => esc_html__( 'Size Guide Page', 'goya' ),
				'description' => esc_html__( 'Select the page containing your Size Guide.', 'goya' ),
				'section'     => 'product_size',
				'priority'    => 10,
				'default'	  	=> '',
				'required'      => array(
					array(
						'setting'  => 'product_size_guide',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_size',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_size_variable',
				'label'       => esc_html__( 'Variable Products only', 'goya' ),
				'description' => esc_html__( 'Show the Size Guide on variable products only', 'goya' ),
				'section'     => 'product_size',
				'default'     => true,
				'priority'    => 10,
				'required'      => array(
					array(
						'setting'  => 'product_size_guide',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_size',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio-buttonset',
				'settings'    => 'product_size_apply',
				'label'       => esc_html__( 'Apply to', 'goya' ),
				'section'     => 'product_size',
				'default'     => 'all',
				'priority'    => 10,
				'choices'     => array(
					'all'	=> esc_attr__('All Categories', 'goya'),
					'custom'	=> esc_attr__('Select Categories', 'goya'),
				),
				'required'      => array(
					array(
						'setting'  => 'product_size_guide',
						'operator' => '==',
						'value'    => true,
					),
				),
			));

			add_action( 'init', 'add_events_categories_customizer_control', 12 );

			function add_events_categories_customizer_control() {

				if ( ! class_exists( 'WooCommerce' ) ) {
					return;
				}

				Kirki::add_field( 'goya_config', array(
					'type'			=> 'multicheck',
					'settings'		=> 'product_size_categories',
					'label'       => esc_html__( 'Select Categories', 'goya' ),
					'section'		=> 'product_size',
					'default'		=> '',
					'priority'		=> 11,
					'multiple'		=> 1,
					'choices'		=> Kirki_Helper::get_terms( array( 'taxonomy' => 'product_cat' ) ),
					'required'      => array(
						array(
							'setting'  => 'product_size_guide',
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => 'product_size_apply',
							'operator' => '==',
							'value'    => 'custom',
						),
					),
				));

			}

		/* Related Products*/	

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'related_products',
				'label'       => esc_html__( 'Show Related Products', 'goya' ),
				'section'     => 'product_related',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'upsell_products',
				'label'       => esc_html__( 'Show Up-sell Products', 'goya' ),
				'description' => esc_html__( 'When they have been defined', 'goya' ),
				'section'     => 'product_related',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'product_upsell_related_per_page',
				'label'       => esc_html__( 'Up-sell/related Products per page', 'goya' ),
				'section'     => 'product_related',
				'default'     => 4,
				'priority'    => 10,
				'choices'	  => array (
						'min'	=> 2,
						'max'	=> 12,
						'step'	=> 1
					),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'slider',
				'settings'    => 'product_upsell_related_columns',
				'label'       => esc_html__( 'Up-sell/related product columns', 'goya' ),
				'section'     => 'product_related',
				'default'     => 4,
				'priority'    => 10,
				'choices'	  => array (
						'min'	=> 2,
						'max'	=> 6,
						'step'	=> 1
					),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'product_related',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'product_upsell_related_slider',
				'label'       => esc_html__( 'Up-sell/related as carousel', 'goya' ),
				'section'     => 'product_related',
				'default'     => true,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'radio',
				'settings'    => 'product_thumbnails_mobile',
				'label'       => esc_html__( 'Product Gallery Thumbnails', 'goya' ),
				'description' => esc_html__( 'Show gallery thumbnails on mobiles?', 'goya' ),
				'section'     => 'product_mobile',
				'default'     => 'dots',
				'priority'    => 10,
				'choices'     => array(
					'thumbs'        => esc_attr__( 'Show Thumbnails', 'goya' ),
					'dots'      => esc_attr__( 'Only dots', 'goya' ),
				),
			));


	/**
	 * STYLING
	 */
		/* Global Colors */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'accent_color',
				'label'       => esc_html__( 'Accent Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#b9a16b',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.mfp-wrap.quick-search .mfp-content [type="submit"], .et-close, .single-product .pswp__button:hover, .content404 h4, .woocommerce-tabs .tabs li a span, .woo-variation-gallery-wrapper .woo-variation-gallery-trigger:hover:after, .mobile-menu li.menu-item-has-children.active > .et-menu-toggle:after, .remove:hover, a.remove:hover, .minicart-counter.et-count-zero, .tag-cloud-link .tag-link-count, .wpmc-tabs-wrapper li.wpmc-tab-item.current, div.argmc-wrapper .tab-completed-icon:before, .et-wp-gallery-popup .mfp-arrow',
						'property' => 'color',
					),
					array(
						'element'  => '.slick-dots li.slick-active button',
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'main_font_color',
				'label'       => esc_html__( 'Body Text Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#686868',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => 'body, table, .shop_table, blockquote cite, .et-listing-style1 .product_thumbnail .et-quickview-btn, .products .single_add_to_cart_button.button, .products .add_to_cart_button.button, .products .added_to_cart.button, .side-panel header h6',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'darker_font_color',
				'label'       => esc_html__( 'Darker Text Color', 'goya' ),
				'description'       => esc_html__( 'Elements with slighly darker color than body text.', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.cart-collaterals .woocommerce-shipping-destination strong, #order_review .shop_table, #payment .payment_methods li label,  .et-product-detail .summary .variations label, .woocommerce-tabs .tabs li a:hover, .woocommerce-tabs .tabs li.active a, .et-product-detail .product_meta > span *, .sticky-product-bar .variations label, .et-product-detail .summary .sizing_guide, #side-cart .woocommerce-mini-cart__total, .woocommerce-Price-amount, .cart-collaterals .shipping-calculator-button, .woocommerce-terms-and-conditions-wrapper a, .et-checkout-login-title a, .et-checkout-coupon-title a, .woocommerce-checkout h3, .order_review_heading, .woocommerce-Address-title h3, .woocommerce-MyAccount-content h3, .woocommerce-MyAccount-content legend, .et-product-detail.et-cart-mixed .summary .yith-wcwl-add-to-wishlist > div > a, .et-product-detail.et-cart-stacked .summary .yith-wcwl-add-to-wishlist > div > a, .hentry table th, .entry-content table th, #reviews .commentlist li .comment-text .meta strong, .et-feat-video-btn, #ship-to-different-address label, .woocommerce-account-fields p.create-account label, .et-login-wrapper a, .floating-labels .form-row.float-label input:focus ~ label, .floating-labels .form-row.float-label textarea:focus ~ label, .woocommerce-info, .order_details li strong, table.order_details th, table.order_details a:not(.button), .variable-items-wrapper .variable-item:not(.radio-variable-item).button-variable-item.selected, .woocommerce-MyAccount-content p a:not(.button), .woocommerce-MyAccount-content header a, .woocommerce-MyAccount-navigation ul li a, .et-MyAccount-user-info .et-username strong, .woocommerce-MyAccount-content .shop_table tr th, mark, .woocommerce-MyAccount-content strong, .product_list_widget a, .search-panel .search-field, .goya-search .search-button-group select, .widget .slider-values p span',
						'property' => 'color',
					),
					array(
						'element'  => 'input[type=radio]:checked:before, input[type=checkbox]:checked,.select2-container--default .select2-results__option--highlighted[aria-selected], .widget .noUi-horizontal .noUi-base .noUi-origin:first-child',
						'property' => 'background-color',
					),
					array(
						'element'  => 'label:hover input[type=checkbox], label:hover input[type=radio], input[type="text"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="date"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="time"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="email"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="url"]:focus, input.input-text:focus, select:focus, textarea:focus',
						'property' => 'border-color',
					),
					array(
						'element'  => 'input[type=checkbox]:checked',
						'property' => 'border-color',
						'suffix' => '!important',
					),
					array(
						'element'  => '.et-product-detail .summary .yith-wcwl-add-to-wishlist a .icon svg, .sticky-product-bar .yith-wcwl-add-to-wishlist a .icon svg',
						'property' => 'stroke',
					),
					array(
						'element'  => '.et-product-detail .summary .yith-wcwl-wishlistaddedbrowse a svg, .et-product-detail .summary .yith-wcwl-wishlistexistsbrowse a svg, .sticky-product-bar .yith-wcwl-wishlistaddedbrowse a svg, .sticky-product-bar .yith-wcwl-wishlistexistsbrowse a svg',
						'property' => 'fill',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'lighter_font_color',
				'label'       => esc_html__( 'Lighter Text Color', 'goya' ),
				'description' => esc_html__( 'Color used for breadcrumbs, dates and other light elements.', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#999999',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.woocommerce-breadcrumb, .woocommerce-breadcrumb a, .widget .wcapf-layered-nav ul li .count, .category_bar .header-active-filters, #reviews .commentlist li .comment-text .woocommerce-review__verified, #reviews .commentlist li .comment-text .woocommerce-review__published-date, .woof_container_inner h4, #side-filters .header-active-filters .active-filters-title, #side-filters .widget h6, .sliding-menu .sliding-menu-back, .type-post .post-meta',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'heading_color',
				'label'       => esc_html__( 'Headings Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => 'h1, h2, h3, h4, h5, h6',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'dot_loader_color',
				'label'       => esc_html__( 'Dot Loader color', 'goya' ),
				'description' => esc_html__( 'The pulsating circle animation', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#b9a16b',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.yith-wcan-loading:after, .blockUI.blockOverlay:after, .easyzoom-notice:after, .woocommerce-product-gallery__wrapper .slick:after, .add_to_cart_button.loading:after, .et-loader:after, .wcapf-before-update:after, #side-filters.ajax-loader .side-panel-content:after',
						'property' => 'background-color',
					),
					array(
						'element'  => '.et-page-load-overlay .dot3-loader',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'primary_buttons',
				'label'       => esc_html__( 'Primary Buttons Background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.button, input[type=submit], button[type=submit], #side-filters .et-close, .nf-form-cont .nf-form-content .submit-wrap .ninja-forms-field, .yith-wcwl-popup-footer a.button.wishlist-submit',
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'primary_buttons_text_color',
				'label'       => esc_html__( 'Primary Buttons Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.button, .button:hover, button[type=submit], button[type=submit]:hover, input[type=submit], input[type=submit]:hover, .nf-form-cont .nf-form-content .submit-wrap .ninja-forms-field, .nf-form-cont .nf-form-content .submit-wrap .ninja-forms-field:hover, .yith-wcwl-popup-footer a.button.wishlist-submit',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'second_buttons',
				'label'       => esc_html__( 'Secondary Buttons Text/Border', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.button.outlined, .button.outlined:hover, .button.outlined:focus, .button.outlined:active, .woocommerce-Reviews .comment-reply-title:hover',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'styling',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Helper Classes', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Default colors, you can override or combine with other classes. For example: "fancy-title accent-color', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'fancy_title_color',
				'label'       => esc_html__( 'Fancy Title Color', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#b9a16b',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.fancy-title',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'fancy_tag_color',
				'label'       => esc_html__( 'Fancy Tag Background', 'goya' ),
				'transport'   => 'auto',
				'section'     => 'styling',
				'default'     => '#b9a16b',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.fancy-tag',
						'property' => 'background-color',
					),
				),
			));

		/* Header Colors */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_styles',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Main Header Colors', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Default colors - if header is not transparent', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));	

			Kirki::add_field( 'goya_config', array(
				'type'          => 'radio-buttonset',
				'settings'      => 'header_regular_mode',
				'label'         => esc_html__( 'Header - Color mode', 'goya' ),
				'transport'   => 'postMessage',
				'section'       => 'header_styles',
				'default'       => 'dark',
				'priority'      => 10,
				'choices'	      => array(
					'dark'		=> esc_attr__('Dark Text', 'goya'),
					'light'		=> esc_attr__('Light Text', 'goya'),
				),
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'light-title',
						'value'    => 'light',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'header_background_color',
				'label'       => esc_html__( 'Header - Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.page-header-regular .header, .header_on_scroll .header'),
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_styles',
				'default'     => '<div class="kirki-separator"><h3>' . 
					esc_html__( 'Header Border', 'goya' ) . '</h3><p>' . 
					esc_html__( 'Applied when header is not transparent', 'goya' ) . 
					'</p></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'page_header_border',
				'label'       => esc_html__( 'Add Border', 'goya' ),
				'description' => esc_html__( 'Border on regular pages', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_styles',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'header-border-1',
						'value'    => true,
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'shop_header_border',
				'label'       => esc_html__( 'Add Border - Shop', 'goya' ),
				'description' => esc_html__( 'Border on shop pages', 'goya' ),
				'transport'   => 'postMessage',
				'section'     => 'header_styles',
				'default'     => true,
				'priority'    => 10,
				'js_vars'     => array(
					array(
						'element'  => 'body',
						'function' => 'toggleClass',
						'class'    => 'header-border-1',
						'value'    => true,
					),
				),
			));


			/* Main Menu Styles */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_styles',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Main Header Menu', 'goya' ).'</h3></div>',
				'priority'    => 10,
			));

			/* Main Menu */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'header_navigation_color',
				'label'       => esc_html__( 'Menu Links Color - Dark Text', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.header a','.header .menu-toggle','.header .goya-search button, .header .et-switcher-container .selected, .header .et-header-text, .header .product.wcml-dropdown li>a, .header .product.wcml-dropdown .wcml-cs-active-currency>a, .header .product.wcml-dropdown .wcml-cs-active-currency:hover>a, .header .product.wcml-dropdown .wcml-cs-active-currency:focus>a', ),
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'header_navigation_color_light',
				'label'       => esc_html__( 'Menu Links Color - Light Text', 'goya' ),
				'description' => esc_html__( 'Used when the header is set to Light Text mode', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.sticky-header-light .header .menu-toggle:hover','.header-transparent-mobiles.sticky-header-light.header_on_scroll .header a.icon','.header-transparent-mobiles.sticky-header-light.header_on_scroll .header .menu-toggle','.header-transparent-mobiles.light-title:not(.header_on_scroll) .header a.icon','.header-transparent-mobiles.light-title:not(.header_on_scroll) .header .menu-toggle'),
						'property' => 'color',
						'media_query' => '@media only screen and (max-width: 767px)',
					),
					array(
						'element'  => array('.light-title:not(.header_on_scroll) .header .site-title, .light-title:not(.header_on_scroll) .header .et-header-menu > li> a, .sticky-header-light.header_on_scroll .header .et-header-menu > li> a, .light-title:not(.header_on_scroll) span.minicart-counter.et-count-zero, .sticky-header-light.header_on_scroll .header .et-header-text, .sticky-header-light.header_on_scroll .header .et-header-text a, .light-title:not(.header_on_scroll) .header .et-header-text, .light-title:not(.header_on_scroll) .header .et-header-text a, .sticky-header-light.header_on_scroll .header .header .icon, .light-title:not(.header_on_scroll) .header .icon, .sticky-header-light.header_on_scroll .header .menu-toggle, .light-title:not(.header_on_scroll) .header .menu-toggle, .sticky-header-light.header_on_scroll .header .et-switcher-container .selected, .light-title:not(.header_on_scroll) .header .et-switcher-container .selected, .light-title:not(.header_on_scroll) .header .product.wcml-dropdown li>a, .light-title:not(.header_on_scroll) .header .product.wcml-dropdown .wcml-cs-active-currency>a, .light-title:not(.header_on_scroll) .header .product.wcml-dropdown .wcml-cs-active-currency:hover>a, .light-title:not(.header_on_scroll) .header .product.wcml-dropdown .wcml-cs-active-currency:focus>a, .sticky-header-light.header_on_scroll .header .product.wcml-dropdown li>a, .sticky-header-light.header_on_scroll .header .product.wcml-dropdown .wcml-cs-active-currency>a, .sticky-header-light.header_on_scroll .header .product.wcml-dropdown .wcml-cs-active-currency:hover>a, .sticky-header-light.header_on_scroll .header .product.wcml-dropdown .wcml-cs-active-currency:focus>a'),
						'property' => 'color',
						'media_query' => '@media only screen and (min-width: 768px)',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'header_navigation_tag_color',
				'label'       => esc_html__( 'Menu Link Tags', 'goya' ),
				'description' => esc_html__( 'Small labels on navigation menu. You can override the color on the Menu Manager', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#bbbbbb',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.et-header-menu .menu-label'),
						'property' => 'background-color',
					),
				),
			));

			/* Dropdown Main Menu */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'header_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'dropdown_menu_font_color',
				'label'       => esc_html__( 'Dropdown Menu Links', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#444444',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.et-header-menu ul.sub-menu li a'),
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'dropdown_menu_background_color',
				'label'       => esc_html__( 'Dropdown Menu Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'header_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.et-header-menu ul.sub-menu:before','.et-header-menu .sub-menu .sub-menu'),
						'property' => 'background-color',
					),
					array(
						'element'  => array('.et-header-menu>li.menu-item-has-children > a:after'),
						'property' => 'border-bottom-color',
					),
				),
			));

		/* Shop Colors */

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'checkout_button_bg',
				'label'       => esc_html__( '"Cart | Checkout | Order" buttons', 'goya' ),
				'description' => esc_html__( 'Background color for "Add to Cart | Checkout | Place Order" buttons', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#181818',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => array('.et-product-detail .single_add_to_cart_button, .sticky-product-bar .single_add_to_cart_button, .sticky-product-bar .add_to_cart_button, .woocommerce-mini-cart__buttons .button.checkout, .button.checkout-button, #place_order.button, .woocommerce .argmc-wrapper .argmc-nav-buttons .argmc-submit, .wishlist_table .add_to_cart'),
						'property' => 'background-color',
					),
					array(
						'element'  => array('.products:not(.shop_display_list) .et-listing-style4 .after_shop_loop_actions .button'),
						'property' => 'background-color',
						'media_query' => '@media only screen and (min-width: 768px)'
					),
					array(
						'element'  => array('.woocommerce-mini-cart__buttons .button:not(.checkout)'),
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'dark_product_button_bg',
				'label'       => esc_html__( 'Cart Button Background - Dark Products', 'goya' ),
				'description' => esc_html__( 'Button background for products with Dark Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-showcase-light-text .showcase-inner .single_add_to_cart_button',
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'dark_product_button_text',
				'label'       => esc_html__( 'Cart Button Text - Dark Products', 'goya' ),
				'description' => esc_html__( 'Button text color for products with Dark Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#181818',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-showcase-light-text .et-product-detail .single_add_to_cart_button',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'shop_toolbar_color',
				'label'       => esc_html__( 'Shop toolbar color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.shop_bar button, .shop_bar .woocommerce-ordering .select2-container--default .select2-selection--single, .shop_bar .shop-filters .orderby, .shop_bar .woocommerce-ordering:after',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'product_name',
				'label'       => esc_html__( 'Product name', 'goya' ),
				'description'       => esc_html__( 'In catalog and single product page', 'goya' ),

				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.products .product-title h3 a, .et-product-detail .summary h1',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'product_price',
				'label'       => esc_html__( 'Product price', 'goya' ),
				'description'       => esc_html__( 'In catalog and single product page', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#777777',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.products .product_after_title .price ins, .products .product_after_title .price>.amount, .price ins, .price > .amount, .price del, .price .woocommerce-Price-amount',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'rating_stars_color',
				'label'       => esc_html__( 'Rating Stars Color', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#282828',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.star-rating > span:before, .comment-form-rating .stars > span:before',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'sale_badge_font_color',
				'label'       => esc_html__( '"Sale" Badge Text', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#ef5c5c',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-inner .badge.onsale, .wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale',
						'property' => 'color',
					),
					array(
						'element'  => '.et-product-detail .summary .badge.onsale',
						'property' => 'border-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'sale_badge_background_color',
				'label'       => esc_html__( '"Sale" Badge Background', 'goya' ),
				'description' => esc_html__( 'On single product page is always transparent', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-inner .badge.onsale, .wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale',
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'new_badge_font_color',
				'label'       => esc_html__( '"New" Product Text', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#585858',
				'priority'    => 10,
				array(
					'element'  => '.product-inner .badge.new',
					'property' => 'color',
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'new_badge_background_color',
				'label'       => esc_html__( '"New" Product Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-inner .badge.new',
						'property' => 'background-color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'shop_styles',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'stock_badge_font_color',
				'label'       => esc_html__( '"Out of Stock" Text', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#585858',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-inner .badge.out-of-stock',
						'property' => 'color',
					),
				),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'color',
				'settings'    => 'stock_badge_background_color',
				'label'       => esc_html__( '"Out of Stock" Background', 'goya' ),
				'transport' => 'auto',
				'section'     => 'shop_styles',
				'default'     => '#ffffff',
				'priority'    => 10,
				'output'      => array(
					array(
						'element'  => '.product-inner .badge.out-of-stock',
						'property' => 'background-color',
					),
				),
			));

	/* Form Styles */

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'form_styles',
			'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Inputs, buttons styles', 'goya' ).'</h3></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'radio-buttonset',
			'settings'    => 'elements_border_style',
			'label'       => esc_html__( 'Input Boxes Style', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'form_styles',
			'default'     => 'all',
			'priority'    => 10,
			'choices'     => array(
				'all'	=> esc_attr__('All borders', 'goya'),
				'bottom'	=> esc_attr__('Bottom border', 'goya'),
			),
			'js_vars'     => array(
				array(
					'element'  => 'body',
					'function' => 'toggleClass',
					'class'    => 'el-style-border-all',
					'value'    => 'all',
				),
				array(
					'element'  => 'body',
					'function' => 'toggleClass',
					'class'    => 'el-style-border-bottom',
					'value'    => 'bottom',
				),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'form_styles',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'slider',
			'settings'    => 'elements_border_width',
			'label'    	  => esc_html__( 'Border Width (px)', 'goya' ),
			'description' => esc_html__( 'Choose the border width for input fields and buttons', 'goya' ),
			'transport'   => 'postMessage',
			'section'     => 'form_styles',
			'default'     => 2,
			'priority'    => 10,
			'choices'	  => array(
				'min'	=> 1,
				'max'	=> 2,
				'step'	=> 1
			),
			'js_vars'     => array(
				array(
					'element'  => 'body',
					'function' => 'toggleClass',
					'class'    => 'el-style-border-width-1',
					'value'    => '1',
				),
				array(
					'element'  => 'body',
					'function' => 'toggleClass',
					'class'    => 'el-style-border-width-2',
					'value'    => '2',
				),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'slider',
			'settings'    => 'elements_border_radius',
			'label'    	  => esc_html__( 'Border Radius (px)', 'goya' ),
			'transport'   => 'auto',
			'section'     => 'form_styles',
			'default'     => 0,
			'priority'    => 10,
			'choices'	  => array(
				'min'	=> 0,
				'max'	=> 4,
				'step'	=> 1
			),
			'output'      => array(
				array(
					'element'  => 'input[type="text"], input[type="password"], input[type="number"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="time"], input[type="month"], input[type="week"], input[type="email"], input[type="search"], input[type="tel"], input[type="url"], input.input-text, select, textarea, .wp-block-button__link, .nf-form-cont .nf-form-content .list-select-wrap .nf-field-element > div, .nf-form-cont .nf-form-content input:not([type="button"]), .nf-form-cont .nf-form-content textarea, .nf-form-cont .nf-form-content .submit-wrap .ninja-forms-field, .button, .comment-form-rating, .woocommerce a.ywsl-social, .login a.ywsl-social, input[type=submit], .select2.select2-container--default .select2-selection--single, .woocommerce .woocommerce-MyAccount-content .shop_table .woocommerce-button, .woocommerce .sticky-product-bar .quantity, .woocommerce .et-product-detail .summary .quantity, .et-product-detail .summary .yith-wcwl-add-to-wishlist > div > a, .wishlist_table .add_to_cart.button, .yith-wcwl-add-button a.add_to_wishlist, .yith-wcwl-popup-button a.add_to_wishlist, .wishlist_table a.ask-an-estimate-button, .wishlist-title a.show-title-form, .hidden-title-form a.hide-title-form, .woocommerce .yith-wcwl-wishlist-new button, .wishlist_manage_table a.create-new-wishlist, .wishlist_manage_table button.submit-wishlist-changes, .yith-wcwl-wishlist-search-form button.wishlist-search-button, #side-filters.side-panel .et-close, .header .search-button-group',
					'property' => 'border-radius',
					'units'    => 'px',
				),
			),
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'custom',
			'settings'    => 'separator_' . $sep++,
			'section'     => 'form_styles',
			'default'     => '<div class="kirki-separator"></div>',
			'priority'    => 10,
		));

		Kirki::add_field( 'goya_config', array(
			'type'        => 'toggle',
			'settings'    => 'elements_floating_labels',
			'label'       => esc_html__( 'Floating labels', 'goya' ),
			'description' => esc_html__( 'Labels for input fields will "float" on focus.', 'goya'),
			'section'     => 'form_styles',
			'default'     => true,
			'priority'    => 10,
		));


	/**
	 * FONTS
	 */
		/* Fonts */

				Kirki::add_field( 'goya_config', array(
					'type'        => 'radio-buttonset',
					'settings'    => 'main_font_source',
					'label'       => esc_html__( 'Main Font Source', 'goya' ),
					'section'     => 'fonts',
					'default'     => '1',
					'priority'    => 10,
					'choices'     => array(
						'1'	=> esc_attr__('Standard + Google Fonts', 'goya'),
						'2'	=> esc_attr__('Adobe Typekit', 'goya'),
					),
				));

				// Main font: Standard + Google Fonts

				Kirki::add_field( 'goya_config', array(
					'type'     		=> 'typography',
					'settings' 		=> 'main_font',
					'label'    	  => esc_html__( 'Main Font', 'goya' ),
					'description' => esc_html__( 'Default: Jost | 400 | 1.7', 'goya' ),
					'transport'   => 'auto',
					'section'  		=> 'fonts',
					'priority' 		=> 10,
					'choices' => goya_main_font_choices(),
					'default'     => array(
						'font-family'    => 'Jost',
						'variant'        => 'regular',
						'line-height'    => '1.7',
					),
					'output'      => array(
						array(
							'element' => 'body, blockquote cite',
						),
						array(
							'element'  => '.edit-post-visual-editor.editor-styles-wrapper,.wp-block h1,.wp-block h2,.wp-block h3,.wp-block h4,.wp-block h5,.wp-block h6,.editor-post-title__block .editor-post-title__input,.wp-block-quote p,.wp-block-pullquote p,.wp-block-cover .wp-block-cover-text',
							'context'  => array( 'editor' ),
						),
					),
					'required' => array(
						array(
							'setting' => 'main_font_source', 
							'operator' => '==', 
							'value' => '1'
						)
					),
				));

				// Main font: Adobe Typekit

				Kirki::add_field( 'goya_config', array(
					'type'        => 'text',
					'settings'    => 'main_font_typekit_kit_id',
					'label'       => esc_html__( 'Project ID', 'goya' ),
					'section'     => 'fonts',
					'default'     => '',
					'priority'    => 10,
					'required' => array(
						array(
							'setting' => 'main_font_source', 
							'operator' => '==', 
							'value' => '2'
						)
					),
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'text',
					'settings'    => 'main_typekit_font',
					'label'       => esc_html__( 'font-family', 'goya' ),
					'description'	=> esc_html__( 'The font name used in the CSS output. Example: futura-pt', 'goya' ),
					'section'     => 'fonts',
					'default'     => '',
					'priority'    => 10,
					'required' => array(
						array(
							'setting' => 'main_font_source', 
							'operator' => '==', 
							'value' => '2'
						)
					),
				));

			/* Second Font: Titles */

				Kirki::add_field( 'goya_config', array(
					'type'        => 'custom',
					'settings'    => 'separator_' . $sep++,
					'section'     => 'fonts',
					'default'     => '<div class="kirki-separator"></div>',
					'priority'    => 10,
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'radio-buttonset',
					'settings'    => 'second_font_source',
					'label'       => esc_html__( 'Second Font Source', 'goya' ),
					'section'     => 'fonts',
					'default'     => '0',
					'priority'    => 10,
					'choices'     => array(
						'0'	=> esc_attr__( 'No Second Font', 'goya' ),
						'1'	=> esc_attr__( 'Standard + Google Fonts', 'goya' ),
						'2'	=> esc_attr__( 'Adobe Typekit', 'goya' ),
					),
				));

				// Second font: Standard + Google Fonts

				Kirki::add_field( 'goya_config', array(
					'type'     		=> 'typography',
					'settings' 		=> 'second_font',
					'label'    	  => esc_html__( 'Second Font', 'goya' ),
					'description' => esc_html__( 'Default: Jost | regular', 'goya' ),
					'transport'   => 'auto',
					'section'  		=> 'fonts',
					'priority' 		=> 10,
					'choices' => goya_second_font_choices(),
					'default'     => array(
						'font-family'    => 'Jost',
						'variant'        => 'regular',
					),
					'output'      => array(
						array(
							'element'  => '.site-header .main-navigation, .site-header .secondary-navigation, h1, .page-header .page-title, .entry-header .entry-title, .et-shop-title, .product-showcase.product-title-top .product_title, .et-product-detail .summary h1.product_title, .entry-title.blog-title, .post.post-detail .entry-header .entry-title, .post.post-detail .post-featured .entry-header .entry-title, .wp-block-cover .wp-block-cover-text, .wp-block-cover .wp-block-cover__inner-container, .wp-block-cover-image .wp-block-cover-image-text, .wp-block-cover-image h2, .revslider-slide-title, blockquote h1, blockquote h2, blockquote h3, blockquote h4, blockquote h5, blockquote h6, blockquote p, .post-sidebar .widget > h6, .hentry h2, .entry-content h2, .mfp-content h2, .footer h2, .entry-content h3, .hentry h3, .mfp-content h3, .footer h3, .entry-content h4, .hentry h4, .mfp-content h4, .footer h4, .post .post-title h3, .products .product .product-title h2, .et-portfolio .type-portfolio h3, .et-banner-text .et-banner-title, .woocommerce-order-received h2, .woocommerce-MyAccount-content h2, .woocommerce-MyAccount-content h3, .woocommerce-checkout h3, .order_review_heading, .woocommerce-MyAccount-content legend, .et-portfolio .type-portfolio h3, .related h2, .up-sells h2, .cross-sells h2, .cart-collaterals h5, .cart-collaterals h3, .cart-collaterals h2, .related-posts .related-title, .et_post_nav .post_nav_link h3, .comments-container .comments-title, .product-details-accordion .woocommerce-Reviews-title, .et-hovercard .et-pricing-head',
						),
						array(
							'element'  => '.wp-block h1,.wp-block h2,.wp-block h3,.editor-post-title__block .editor-post-title__input,.wp-block-quote p,.wp-block-pullquote p,.wp-block-cover .wp-block-cover-text',
							'context'  => array( 'editor' ),
						),
					),
					'required' => array(
						array(
							'setting' => 'second_font_source', 
							'operator' => '==', 
							'value' => '1'
						)
					),
				));

				// Second font: Adobe Typekit

				Kirki::add_field( 'goya_config', array(
					'type'        => 'text',
					'settings'    => 'second_font_typekit_kit_id',
					'label'       => esc_html__( 'Project ID', 'goya' ),
					'section'     => 'fonts',
					'default'     => '',
					'priority'    => 10,
					'required' => array(
						array(
							'setting' => 'second_font_source', 
							'operator' => '==', 
							'value' => '2'
						)
					),
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'text',
					'settings'    => 'second_typekit_font',
					'label'       => esc_html__( 'font-family', 'goya' ),
					'description'	=> esc_html__( 'The font name used in the CSS output. Example: futura-pt', 'goya' ),
					'section'     => 'fonts',
					'default'     => '',
					'priority'    => 10,
					'required' => array(
						array(
							'setting' => 'second_font_source', 
							'operator' => '==', 
							'value' => '2'
						)
					),
				));

				Kirki::add_field( 'goya_config', array(
					'type'			=> 'multicheck',
					'settings'		=> 'second_font_apply',
					'label'       => esc_html__( 'Elements to apply 2nd font', 'goya' ),
					'description' => esc_html__( 'Select which elements will use the 2nd font', 'goya' ),
					'section'		=> 'fonts',
					'default'		=> array('titles','modules','widgets','blockquotes','h2','h3'),
					'priority'		=> 10,
					'multiple'		=> 1,
					'choices'		=> array(
						'main-menu'   => esc_attr__('Main Menu', 'goya'),
						'titles'      => esc_attr__('Main Title (h1)', 'goya'),
						'modules'	    => esc_attr__('Module Title (h2, h3)', 'goya'),
						'widgets'     => esc_attr__('Widget Title (h2)', 'goya'),
						'products'	  => esc_attr__('Products List', 'goya'),
						'posts'	      => esc_attr__('Posts List', 'goya'),
						'portfolio'	  => esc_attr__('Portfolio List', 'goya'),
						'h2'          => esc_attr__('Content h2', 'goya'),
						'h3'          => esc_attr__('Content h3', 'goya'),
						'h4'          => esc_attr__('Content h4', 'goya'),
						'blockquotes' => esc_attr__('Blockquotes', 'goya'),
					),
					'required' => array(
						array(
							'setting' => 'second_font_source', 
							'operator' => '!=', 
							'value' => '0'
						)
					),

				));


			/* Font Sizes */
				Kirki::add_field( 'goya_config', array(
					'type'     => 'custom',
					'settings' => 'separator_' . $sep++,
					'section'  => 'fonts',
					'default'  => '<div class="kirki-separator"><h3>' . esc_html__( 'Font Sizes', 'goya' ) . '</h3></div>',
					'priority' => 10,
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'slider',
					'settings'    => 'font_size_medium',
					'label'    	  => esc_html__( 'Medium Font Size (px)', 'goya' ),
					'description' => esc_html__( 'General Body font', 'goya' ),
					'transport'   => 'auto',
					'section'     => 'fonts',
					'default'     => 16,
					'priority'    => 10,
					'choices'	  => array(
						'min'	=> 12,
						'max'	=> 20,
						'step'	=> 1
					),
					'output'      => array(
						array(
							'element'  => 'body, blockquote cite, div.vc_progress_bar .vc_single_bar .vc_label, div.vc_toggle_size_sm .vc_toggle_title h4',
							'property' => 'font-size',
							'units'    => 'px',
						),
					),
				));

				Kirki::add_field( 'goya_config', array(
					'type'        => 'slider',
					'settings'    => 'font_size_small',
					'label'    	  => esc_html__( 'Small Font Size (px)', 'goya' ),
					'transport'   => 'auto',
					'section'     => 'fonts',
					'default'     => 14,
					'priority'    => 10,
					'choices'	  => array(
						'min'	=> 10,
						'max'	=> 16,
						'step'	=> 1
					),
					'output'      => array(
						array(
							'element'  => '.wp-caption-text, .woocommerce-breadcrumb, .post.listing .listing_content .post-meta, .footer-bar .footer-bar-content, .side-menu .mobile-widgets p, .side-menu .side-widgets p, .products .product.product-category a div h2 .count, #payment .payment_methods li .payment_box, #payment .payment_methods li a.about_paypal, .et-product-detail .summary .sizing_guide, #reviews .commentlist li .comment-text .woocommerce-review__verified, #reviews .commentlist li .comment-text .woocommerce-review__published-date, .commentlist > li .comment-meta, .widget .type-post .post-meta, .widget_rss .rss-date, .wp-block-latest-comments__comment-date, .wp-block-latest-posts__post-date, .commentlist > li .reply, .comment-reply-title small, .commentlist .bypostauthor .post-author, .commentlist .bypostauthor > .comment-body .fn:after, .et-portfolio.et-portfolio-style-hover-card .type-portfolio .et-portfolio-excerpt',
							'property' => 'font-size',
							'units'    => 'px',
						),
					),

				));

	/**
	 * SOCIAL MEDIA
	 */
		/* Social Media */

			Kirki::add_field( 'goya_config', array(
				'type'        	=> 'sortable',
				'settings'   	=> 'share_icons',
				'label'    	  	=> esc_html__( 'Share Icons', 'goya' ),
				'description'   => esc_html__( 'Select the share icons to show on posts and products', 'goya' ),
				'section'     	=> 'social_media',
				'priority'    	=> 10,
				'choices'   => array(
					'facebook'      => esc_attr__('Facebook', 'goya'),
					'twitter'       => esc_attr__('Twitter', 'goya'),
					'pinterest'     => esc_attr__('Pinterest', 'goya'),
					'vk'            => esc_attr__('VK', 'goya'),
					'linkedin'      => esc_attr__('LinkedIn', 'goya'),
					'whatsapp'      => esc_attr__('WhatsApp', 'goya'),
					'telegram'      => esc_attr__('Telegram', 'goya'),
					'email'         => esc_attr__('Email', 'goya'),
				),
				'default'     	=> array('facebook', 'twitter', 'pinterest'),
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'custom',
				'settings'    => 'separator_' . $sep++,
				'section'     => 'social_media',
				'default'     => '<div class="kirki-separator"></div>',
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'repeater',
				'settings'    => 'social_links',
				'label'       => esc_html__( 'Social Media Links', 'goya' ),
				'description' => esc_html__( 'Add your social Media URL\'s', 'goya' ),
				'section'     => 'social_media',
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_attr__( 'Element', 'goya' ),
					'field' => 'name',
				),
				'fields'          => array(
					'name' => array(
						'type'    => 'select',
						'label'       => esc_html__( 'Social Network', 'goya' ),
						'choices' => goya_social_media_icons(),
					),
					'url' => array(
						'type'    => 'text',
						'label'       => esc_html__( 'Link URL', 'goya' ),
					),
				),
			));


	/**
	 * CUSTOM CODE
	 */
		/* Custom Code */

			Kirki::add_field( 'goya_config', array(
				'type'     => 'custom',
				'settings' => 'separator_' . $sep++,
				'section'  => 'custom_css',
				'default'     => '<div class="kirki-separator"><h3>' .esc_html__( 'Goya CSS', 'goya' ).'</h3></div>',
				'priority' => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'toggle',
				'settings'    => 'custom_css_status',
				'label'       => esc_html__( 'Enable Goya CSS', 'goya' ),
				'description' => esc_html__( 'Add your theme specific code here for easy switch.', 'goya'),
				'section'     => 'custom_css',
				'default'     => false,
				'priority'    => 10,
			));

			Kirki::add_field( 'goya_config', array(
				'type'        => 'code',
				'settings'    => 'custom_css_code',
				'label'       => esc_html__( 'Goya CSS', 'goya' ),
				'section'     => 'custom_css',
				'default'     => '',
				'priority'    => 10,
				'choices'     => array(
					'language' => 'css',
					'theme'    => 'monokai',
					'height'   => 150,
				),
			));



}// End if().
