<?php 
if ( !is_admin() ) { return; }

global $goya_demo_list;

$goya_demo_list = array(
	array(
		'id' => 'basic-v1',
		'name' => esc_html__('Basic (faster)', 'goya'),
		'url' => 'demo-basic/',
		'home' => 'Home - Classic',
		'content' => 'basic-v1',
		'revslider' => 'basic-v1'
	),
	array(
		'id' => 'decor-v1',
		'name' => esc_html__('Decoration', 'goya'),
		'url' => 'demo-decor/',
		'home' => 'Home - Classic',
		'content' => 'decor-v1',
		'revslider' => 'decor-v3'
	),
	
	array(
		'id' => 'fashion-v1',
		'name' => esc_html__('Fashion', 'goya'),
		'url' => 'demo-fashion/',
		'home' => 'Home - Classic',
		'content' => 'fashion-v1',
		'revslider' => 'fashion-v2'
	),
	
);

function goya_ocdi_import_files() {
	global $goya_demo_list;

	$url = 'https://goya.everthemes.com/';
	$path = 'https://goya.b-cdn.net/assets/demo/content/';

	foreach ($goya_demo_list as $params) {
		$import[] = array(
			'import_file_name'           => $params['name'],
			'import_file_url'            => $path . $params['content'] . '/content-'. $params['content'] .'.xml',
			'import_widget_file_url'     => $path . $params['content'] . '/widgets-'. $params['content'] .'.wie',
			'import_customizer_file_url' => $path . $params['content'] . '/customizer-'. $params['content'] .'.dat',
			'import_rev_slider_file_url' => $path . $params['content'] . '/revslider-'. $params['revslider'] .'.zip',
			'import_preview_image_url'   => $path . $params['id'] . '/preview-'. $params['id'] .'.jpg',
			'preview_url'                => $url . $params['url'],
		);
	}

	return $import;

}
add_filter( 'pt-ocdi/import_files', 'goya_ocdi_import_files' );


if( extension_loaded('imagick') || class_exists('Imagick') ){ 
	// disable thumbnail regeneration
	add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
	add_filter( 'merlin_regenerate_thumbnails_in_content_import', '__return_false' );
}



function goya_ocdi_after_import( $selected_import ) {
	global $goya_demo_list;

	// Assign menus to their locations.
	$navigation = get_term_by('name', 'Main', 'nav_menu');
	$topbar = get_term_by('name', 'Top Bar', 'nav_menu');
	$footer = get_term_by('name', 'Footer', 'nav_menu');
	$secondary = get_term_by('name', 'Secondary', 'nav_menu');
	
	set_theme_mod( 'nav_menu_locations' , array(
		'primary-menu'    => $navigation->term_id,
		'topbar-menu'     => $topbar->term_id,
		'secondary-menu'   => $secondary->term_id,
		'fullscreen-menu' => $navigation->term_id,
		'mobile-menu'     => $navigation->term_id,
		'footer-menu'     => $footer->term_id )
	);
	
	// Assign front, blog and WooCommerce pages.
	$home = get_page_by_path('home');
	$blog = get_page_by_path('blog');

	// Override home and blog pages according to demo ID
	$home = get_page_by_title($goya_demo_list[$selected_import]['home']);
	if ($selected_import == 2) {
		$blog = get_page_by_path('journal');
	}
	// Delete duplicates
	$pages2 = array('cart','checkout','my-account','wishlist');
	foreach ($pages2 as $p2) {
		$p = get_page_by_path($p2 . '-2');
		if ($p) {
			wp_delete_post( $p->ID, true);
		}
	}
	// Get Shop page
	$shop2 = get_page_by_path('shop-2');
	if ($shop2) {
		$shop1 = get_page_by_path('shop');
		wp_delete_post( $shop1->ID, true);
		wp_update_post([
			'post_name' => 'shop',
			'ID' => $shop2->ID,
		]);
	}

	$shop = get_page_by_path('shop');
	$cart = get_page_by_path('cart');
	$checkout = get_page_by_path('checkout');
	$wishlist = get_page_by_path('wishlist');
	$myaccount = get_page_by_path('my-account');
	
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home->ID );
	update_option( 'page_for_posts', $blog->ID );
	
	update_option( 'woocommerce_myaccount_page_id', $myaccount->ID );
	update_option( 'woocommerce_shop_page_id', $shop->ID );
	update_option( 'woocommerce_cart_page_id', $cart->ID );
	update_option( 'woocommerce_checkout_page_id', $checkout->ID );
	update_option( 'general-show_notice', '');

	// Yith Wishlist
	if ( class_exists( 'YITH_WCWL_Frontend' ) )  {
		remove_action( 'wp_head', array( YITH_WCWL_Frontend(), 'add_button' ) );
		update_option( 'yith_wcwl_show_on_loop', 'yes');
		update_option( 'yith_wcwl_button_position', 'shortcode');
		update_option( 'yith_wcwl_loop_position', 'shortcode');
		update_option( 'add_to_wishlist-position', 'shortcode');
		update_option( 'add_to_wishlist_catalog-position', 'shortcode');
		update_option( 'yith_wcwl_rounded_corners', 0);
		update_option( 'yith_wcwl_price_show', 'yes');
		update_option( 'yith_wcwl_add_to_cart_show', 'yes');
		update_option( 'yith_wcwl_show_remove', 'yes');
		update_option( 'yith_wcwl_repeat_remove_button', 'yes');
		update_option( 'yith_wcwl_wishlist_page_id', $wishlist->ID );
	}

	// WC Ajax Product Filters
	$wcapf = get_option('wcapf_settings');
	$wcapf['shop_loop_container'] = '.wcapf-before-products';
	$wcapf['not_found_container'] = '.wcapf-before-products';
	$wcapf['pagination_container'] = '.woocommerce-pagination';
	$wcapf['overlay_bg_color'] = '#fff';
	$wcapf['sorting_control'] = '1';
	$wcapf['scroll_to_top'] = '1';
	$wcapf['scroll_to_top_offset'] = '150';
	$wcapf['custom_scripts'] = '';
	$wcapf['disable_transients'] = '';
	update_option('wcapf_settings', $wcapf);

	// Ninja Forms
	$ninjaf = get_option('ninja_forms');
	$ninjaf['opinionated_styles'] = '';
	update_option('ninja_forms', $ninjaf);

	// ARG Multistep Checkout
	$argmc = get_option('arg-mc-options');
	$argmc['tabs_layout'] = 'tabs-progress-bar';
	update_option('arg-mc-options', $argmc);
	
	// We no longer need to install pages for WooCommerce
	delete_option( '_wc_needs_pages' );
	delete_transient( '_wc_activation_redirect' );

	// Flush rules after install
	flush_rewrite_rules();

	global $wpdb;
	
	// Change attribute types
	$table_name = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
	
	$wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'color' WHERE `attribute_name` = 'color'" );
	$wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'image' WHERE `attribute_name` = 'pattern'" );
	$wpdb->query( "UPDATE `$table_name` SET `attribute_type` = 'button' WHERE `attribute_name` = 'size'" );
}
add_action( 'pt-ocdi/after_import', 'goya_ocdi_after_import' );

/* Disable Branding */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/* Intro text */
function goya_ocdi_plugin_intro_text( $default_text ) {

	ob_start(); ?>
	
	<div class="ocdi__intro-notice  notice  notice-warning">
		<p><?php esc_html_e( 'Before you begin, make sure all the required plugins are activated.', 'goya' ); ?></p>
	</div>
	
		<div class="ocdi__intro-text">
			<p class="about-description">
				<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'goya' ); ?>
				<?php esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'goya' ); ?>
			</p>

			<p><span class="dashicons dashicons-warning"></span>  <?php esc_html_e( 'Please click on the Import button only once and wait, it can take some minutes.', 'goya' ); ?></p>

			<?php if ( empty( $_GET['import-mode'] ) || 'manual' !== $_GET['import-mode'] ) : ?>
				<a href="<?php echo esc_url("admin.php?page=pt-one-click-demo-import&amp;import-mode=manual"); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch to manual import!', 'goya' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url("admin.php?page=pt-one-click-demo-import"); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch back to theme predefined imports!', 'goya' ); ?></a>
			<?php endif; ?>

		</div>



	<?php
	$default_text = ob_get_clean();
	return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'goya_ocdi_plugin_intro_text' );
