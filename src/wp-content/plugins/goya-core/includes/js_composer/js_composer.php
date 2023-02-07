<?php
/**
 * Integrate with WPBakery Page Builder.
 */

class Goya_Core_JS_Composer {

	/**
	 * Initialize.
	 */
	public static function init() {

		// Remove Welcome redirects
		remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
		remove_action( 'init', 'vc_page_welcome_redirect' );
		remove_action( 'admin_init', 'vc_page_welcome_redirect' );

		// Remove admin bar menu
		remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );

		if ( function_exists( 'vc_license' ) ) {
			remove_action( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ) );
		}

	}

	public static function init_shortcodes() {

		if ( ! function_exists('visual_composer')) return;
		
		include( GOYA_VC_DIR . 'shortcodes/banner-slider.php' );
		include( GOYA_VC_DIR . 'shortcodes/banner.php' );
		include( GOYA_VC_DIR . 'shortcodes/blog-posts.php' );
		include( GOYA_VC_DIR . 'shortcodes/button.php' );
		include( GOYA_VC_DIR . 'shortcodes/content-carousel.php' );
		include( GOYA_VC_DIR . 'shortcodes/countdown.php' );
		include( GOYA_VC_DIR . 'shortcodes/counter.php' );
		include( GOYA_VC_DIR . 'shortcodes/gmap.php' );
		include( GOYA_VC_DIR . 'shortcodes/gmap-parent.php' );
		include( GOYA_VC_DIR . 'shortcodes/hover-card.php' );
		include( GOYA_VC_DIR . 'shortcodes/icon-holder.php' );
		include( GOYA_VC_DIR . 'shortcodes/icon-box.php' );
		include( GOYA_VC_DIR . 'shortcodes/image.php' );
		include( GOYA_VC_DIR . 'shortcodes/image-slider.php' );
		include( GOYA_VC_DIR . 'shortcodes/lightbox.php' );
		include( GOYA_VC_DIR . 'shortcodes/pricing-table.php' );
		include( GOYA_VC_DIR . 'shortcodes/pricing-column.php' );
		include( GOYA_VC_DIR . 'shortcodes/team-member.php' );
		include( GOYA_VC_DIR . 'shortcodes/testimonial-slider.php' );
		include( GOYA_VC_DIR . 'shortcodes/testimonial.php' );
		include( GOYA_VC_DIR . 'shortcodes/type-auto.php' );
		include( GOYA_VC_DIR . 'shortcodes/type-stroke.php' );
		include( GOYA_VC_DIR . 'shortcodes/video-lightbox.php' );

		if ( post_type_exists( 'portfolio' ) ) {
			include( GOYA_VC_DIR . 'shortcodes/portfolio.php' );
		}

		if (goya_wc_exists()) {
			include( GOYA_VC_DIR . 'shortcodes/product-masonry.php' );
			include( GOYA_VC_DIR . 'shortcodes/product-slider.php' );
			include( GOYA_VC_DIR . 'shortcodes/product-category-grid.php' );
		}

		/* Ajax Action */
		add_action( 'wp_ajax_nopriv_goya_load_vc_template', array( __CLASS__, 'goya_load_vc_template' ) );
		add_action( 'wp_ajax_goya_load_vc_template', array( __CLASS__, 'goya_load_vc_template' ) );
		
	}

	public static function goya_load_vc_template() {
		$id = isset($_POST['template_unique_id']) ? wp_unslash($_POST['template_unique_id']) : false;
		
	  $template = goya_template_get_list($id);
	  echo wp_kses_post( $template['sc'] );
		wp_die();
	}

	/**
	 * Customize default shortcodes of WPBakery Page Builder.
	 */
	public static function customize_elements() {

		include( GOYA_VC_DIR . 'vc_elements.php' );
	}

	/**
	 * Undocumented function
	 */
	public static function add_templates() {

		if ( ! get_theme_mod('js_composer_standalone', false) == true ) {
		if (class_exists('WPBakeryVisualComposerAbstract')) {
		// Remove "Template library" tab from Templates modal
		if ( isset( visual_composer()->shared_templates ) ) {
			remove_filter( 'vc_get_all_templates', array( visual_composer()->shared_templates, 'addTemplatesTab' ) );
		}
			}	
		}

		// Add new templates
		$vc_element_templates_dir = GOYA_VC_DIR . 'vc_elements/';
		vc_set_shortcodes_templates_dir( $vc_element_templates_dir );

		include( GOYA_VC_DIR . 'templates.php' );
	
	}


	/**
	 * Map theme's shortcodes.
	 */
	public static function map_shortcodes() {
		// Include new VC elements
		include( GOYA_VC_DIR . 'elements/banner-slider.php' );
		include( GOYA_VC_DIR . 'elements/banner.php' );
		include( GOYA_VC_DIR . 'elements/blog-posts.php' );
		include( GOYA_VC_DIR . 'elements/button.php' );
		include( GOYA_VC_DIR . 'elements/content-carousel.php' );
		include( GOYA_VC_DIR . 'elements/countdown.php' );
		include( GOYA_VC_DIR . 'elements/counter.php' );
		include( GOYA_VC_DIR . 'elements/gmap.php' );
		include( GOYA_VC_DIR . 'elements/gmap-parent.php' );
		include( GOYA_VC_DIR . 'elements/hover-card.php' );
		include( GOYA_VC_DIR . 'elements/icon-holder.php' );
		include( GOYA_VC_DIR . 'elements/icon-box.php' );
		include( GOYA_VC_DIR . 'elements/image.php' );
		include( GOYA_VC_DIR . 'elements/image-slider.php' );
		include( GOYA_VC_DIR . 'elements/lightbox.php' );
		include( GOYA_VC_DIR . 'elements/pricing-table.php' );
		include( GOYA_VC_DIR . 'elements/pricing-column.php' );
		include( GOYA_VC_DIR . 'elements/team-member.php' );
		include( GOYA_VC_DIR . 'elements/testimonial-slider.php' );
		include( GOYA_VC_DIR . 'elements/testimonial.php' );
		include( GOYA_VC_DIR . 'elements/type-auto.php' );
		include( GOYA_VC_DIR . 'elements/type-stroke.php' );
		include( GOYA_VC_DIR . 'elements/video-lightbox.php' );

		if ( post_type_exists( 'portfolio' ) ) {
			include( GOYA_VC_DIR . 'elements/portfolio.php' );
		}

		if (goya_wc_exists()) {
			include( GOYA_VC_DIR . 'elements/product-masonry.php' );
			include( GOYA_VC_DIR . 'elements/product-slider.php' );
			include( GOYA_VC_DIR . 'elements/product-category-grid.php' );
		}

		// Include custom params
		include( GOYA_VC_DIR . 'params/iconpicker.php' );

	}

}

