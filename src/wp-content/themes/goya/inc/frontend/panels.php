<?php

/* Popup */
function goya_popup_modal() {
	
	$popup_modal = goya_meta_config('','popup_modal',false);

	$goya_popup = apply_filters( 'goya_popup_modal', $popup_modal );
	
	if ($popup_modal) {

		$classes[] = 'popup-layout-' . goya_meta_config('','popup_layout','1-col');
		$classes[] = goya_meta_config('','popup_color_style','');

		if(!is_admin() && $goya_popup ) {
			$popup_content = get_theme_mod( 'popup_content', '' );
			$popup_image = get_theme_mod( 'popup_image', '' );
			$delay = goya_meta_config('','popup_delay', 3 ) * 1000;
		?>
			<aside id="goya-popup" rel="inline-auto" class="mfp-hide mfp-automatic goya-popup <?php echo implode(' ', $classes); ?>" data-class="goya-popup" data-delay="<?php echo esc_attr( $delay ); ?>">
				<div class="popup-wrapper">
					<?php
					if ( strlen( $popup_image ) > 0 ) {
						$popup_image = ( is_ssl() ) ? str_replace( 'http://', 'https://', $popup_image ) : $popup_image;
					} ?>
					<div class="popup-image">
						<div class="image-wrapper" style="background-image: url(<?php echo esc_attr($popup_image); ?>)"><img src="<?php echo esc_attr($popup_image); ?>" alt="goya-popup"></div>
					</div>
					<div class="popup-content">
						<div class="content-wrapper">
							<?php if ($popup_content) { echo do_shortcode( wp_kses_post( $popup_content ) ); } ?>
						</div>
					</div>
				</div>
			</aside>
			<?php
		}
	}
}
add_action( 'wp_footer', 'goya_popup_modal' );


/* Mobile/Side Menu Panel*/
function goya_mobile_menu() {

	get_template_part( 'inc/templates/header/mobile-menu' );

}
add_action( 'wp_footer', 'goya_mobile_menu' );


/* FullScreen Menu Panel */

function goya_fullscreen_panel() { 

	global $goya;

	$mobile_override = get_theme_mod('menu_fullscreen_override',false);

	if ( empty( $goya['panels'] ) || ! in_array( 'hamburger', $goya['panels'] ) || $mobile_override == true ) {
		return;
	}
	
	get_template_part( 'inc/templates/header/fullscreen-menu' );

}
add_action( 'wp_footer', 'goya_fullscreen_panel' );


/* Mini Cart Panel */
function goya_quick_cart_panel() {
	global $goya;

	if ( empty( $goya['panels'] ) || ! in_array( 'cart', $goya['panels'] ) ) {
		return;
	}

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$classes[] = 'side-panel mini-cart';
	$classes[] = goya_meta_config('header', 'cart_position', 'side');
	$classes[] = goya_meta_config('header', 'cart_color', 'light');

	if ( !is_cart() ) {
	?>
		<nav id="side-cart" class="<?php echo implode(' ', $classes); ?>">
			<header>
				<div class="container">
					<div class="panel-header-inner">
					<div class="side-panel-title"><?php esc_html_e('Cart', 'goya' ); ?> <?php echo goya_minicart_items_count(); ?></div>
					<a href="#" class="et-close" title="<?php esc_attr_e('Close', 'goya'); ?>"></a>
					</div>
				</div>
			</header>
			<div class="side-panel-content container widget_shopping_cart">
				<div id="minicart-loader">
					<span class="et-loader"><?php esc_html_e( 'Updating&hellip;', 'goya' );?></span>
				</div>
				<div class="widget_shopping_cart_content">
					<?php woocommerce_mini_cart(); ?>
				</div>
			</div>
		</nav>
	<?php
	}
}
add_action( 'wp_footer', 'goya_quick_cart_panel',3 );


/* Quick Login Panel*/

function goya_quick_login_panel() {

	global $goya;

	if ( empty( $goya['panels'] ) || ! in_array( 'account', $goya['panels'] ) ) {
		return;
	}

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( get_theme_mod('main_header_login_popup', false) && ! is_user_logged_in() && ! is_account_page() ) {
		?>
	 <div id="et-login-popup-wrap" class="et-login-popup-wrap mfp-hide">
		<?php wc_get_template( 'myaccount/form-login.php', array( 'is_popup' => true ) ); ?>
	 </div>
	<?php 
	}
}
add_action( 'wp_footer', 'goya_quick_login_panel' );


/* Search Panel */

function goya_quick_search_panel() { 

	global $goya;

	if ( empty( $goya['panels'] ) || ! in_array( 'search', $goya['panels'] ) ) {
		return;
	}
	
	?>

	<nav class="search-panel side-panel">
		<header>
			<div class="container">
				<div class="panel-header-inner">
					<div class="side-panel-title"><?php esc_html_e('Search', 'goya' ); ?></div>
					<a href="#" class="et-close" title="<?php esc_attr_e('Close', 'goya'); ?>"></a>
				</div>
			</div>
		</header>
		<div class="side-panel-content container">
			<div class="row justify-content-md-center">
				<div class="col-lg-10">
					<?php goya_search_box(); ?>
				</div>
			</div>
		</div>
	</nav>
	<?php
}
add_action( 'wp_footer', 'goya_quick_search_panel' );


/* Quick View Panel: placeholder */

function goya_quick_view_panel() { 

	if ( get_theme_mod('product_quickview', true) == false ) {
		return;
	}
	?>
	<div id="et-quickview" class="clearfix"></div>
	<?php
}

add_action( 'wp_footer', 'goya_quick_view_panel' );

