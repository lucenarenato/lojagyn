<?php

/* Account login
---------------------------------------------------------- */

	/* Get my-account/login link */
	function goya_get_myaccount_link( $is_header = true ) {

		if( ! goya_wc_active() ) {
			return;
		}
		
		$myaccount_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$button_style = 'account-' . get_theme_mod('main_header_login_icon','text');

		if ( is_user_logged_in() && $is_header ) { ?>
			<ul class="account-links et-header-menu">
				<li class="menu-item-has-children">
					<a href="<?php echo esc_url( $myaccount_url ); ?>" class="et-menu-account-btn icon <?php echo esc_attr( $button_style ); ?>"><span class="icon-text"><?php esc_html_e( 'My Account', 'goya' ) ?></span> <?php echo apply_filters( 'goya_account_icon', goya_load_template_part('assets/img/svg/user.svg') ); ?></a>
					<ul class="sub-menu">
					<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
						<li class="account-link--<?php echo esc_attr( $endpoint ); ?> menu-item">
							<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				</li>
			</ul>
		<?php } else { ?>
			<a href="<?php echo esc_url( $myaccount_url ); ?>" class="et-menu-account-btn icon <?php echo esc_attr( $button_style ); ?>"><span class="icon-text"><?php esc_html_e( 'Login', 'woocommerce' ) ?></span> <?php echo apply_filters( 'goya_account_icon', goya_load_template_part('assets/img/svg/user.svg') ); ?></a>
		<?php }
	}

	add_action( 'goya_get_myaccount_link', 'goya_get_myaccount_link' );


/* Wishlist
---------------------------------------------------------- */

	/* Wishlist icon on header */
	
	function goya_quick_wishlist() {

			if ( ! class_exists( 'YITH_WCWL' ) || ! goya_wc_active() )  {
				return;
			}

			$in_account = get_theme_mod('wishlist_account_dashboard', false);
			$url = ($in_account == true && is_user_logged_in() ) ? wc_get_account_endpoint_url( 'wishlist' ) : YITH_WCWL()->get_wishlist_url();
			$wishlist_url = apply_filters('goya_yith_wishlist_url', $url);
		$count = yith_wcwl_count_products();
		$countp = ($count > 0) ? $count : '';
		?>
			<a href="<?php echo esc_url( $wishlist_url ); ?>" class="quick_wishlist icon">
			<span class="text"><?php esc_attr_e('Wishlist', 'goya' ); ?></span>
			<?php echo apply_filters( 'goya_wishlist_icon', goya_load_template_part('assets/img/svg/heart.svg') ); ?>
			<span class="item-counter et-wishlist-counter<?php if ($count > 0) echo esc_attr( ' active' ); ?>"><?php echo esc_attr( $countp ); ?></span>
		</a>
	<?php
	}
		add_action( 'goya_quick_wishlist', 'goya_quick_wishlist' );


	/* Wishlist button on products */
	function goya_wishlist_button($loop) {

			if ( ! class_exists( 'YITH_WCWL' ) || ! goya_wc_active() )  {
				return;
			}

		$wish_loop = get_option('yith_wcwl_show_on_loop');

		if ( $loop == 'loop' && $wish_loop != 'yes') {
			return;
		}

			if ( get_theme_mod('shop_catalog_mode', false) == false )  {
			echo do_shortcode('[yith_wcwl_add_to_wishlist]');
		}
	}

	
	if ( class_exists( 'YITH_WCWL' ) && goya_wc_active() )  {

		if( ! function_exists( 'yith_wcwl_ajax_update_count' ) ){
		
			function goya_yith_wcwl_ajax_update_count(){
			wp_send_json( array(
			'count' => yith_wcwl_count_products()
			) );
		}

			add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'goya_yith_wcwl_ajax_update_count' );
			add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'goya_yith_wcwl_ajax_update_count' );
	}

	/* Add wishlist to account menu */
	add_filter ( 'woocommerce_account_menu_items', 'goya_account_wishlist_link' );
	function goya_account_wishlist_link( $menu_links ) {
			$new = array( 'wishlist' => esc_attr__('Wishlist', 'goya' ) );
			$menu_links = array_slice( $menu_links, 0, 2, true ) 
			+ $new 
			+ array_slice( $menu_links, 1, NULL, true );

			return $menu_links;
		}
		 
		/* Create wishlist endpoint */
		add_action( 'init', 'goya_account_wishlist_endpoint' );
		function goya_account_wishlist_endpoint() {
			$in_account = get_theme_mod('wishlist_account_dashboard', false);
			if ( $in_account == true) {
				add_rewrite_endpoint( 'wishlist', EP_ROOT | EP_PAGES );
		}
	}
	 
		add_filter( 'woocommerce_get_endpoint_url', 'goya_account_wishlist_endpoint_external', 10, 4 );
		function goya_account_wishlist_endpoint_external( $url, $endpoint, $value, $permalink ){
			$in_account = get_theme_mod('wishlist_account_dashboard', false);
			
			if ( $endpoint === 'wishlist' && !$in_account == true ) {
			$url = YITH_WCWL()->get_wishlist_url();
		}
		return $url;
	}

		/* Add shortcode to wishlist tab */
		add_action( 'woocommerce_account_wishlist_endpoint', 'goya_account_wishlist_content' );
		function goya_account_wishlist_content() {
			echo do_shortcode( '[yith_wcwl_wishlist]' );
		}

	}
	
	/* Remove default YITH Wishlist shortcode */
	if ( class_exists( 'YITH_WCWL_Frontend' ) )  {
		remove_action( 'wp_head', array( YITH_WCWL_Frontend(), 'add_button' ) );

		if (is_admin()) {
			update_option( 'yith_wcwl_button_position', 'shortcode');
			update_option( 'yith_wcwl_loop_position', 'shortcode');
			update_option( 'add_to_wishlist-position', 'shortcode');
			update_option( 'add_to_wishlist_catalog-position', 'shortcode');
		}
	}	

	
	/* Single Product: Render wishlist on single product pages */
	function goya_wishlist_button_product() {
		goya_wishlist_button('product');
	}

	
	/* Mini Cart
	---------------------------------------------------------- */

		/* Mini Cart: Header Button */
		function goya_quick_cart() {

			if( ! goya_wc_active() ) {
				return;
			}

			if ( get_theme_mod('shop_catalog_mode', false) == false ) {
				$cart_count = apply_filters( 'goya_cart_count', is_object( WC()->cart ) ? WC()->cart->cart_contents_count : 0 );
				$count_class = ( $cart_count > 0 ) ? '' : ' et-count-zero';
			?>
				<a data-target="open-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('Cart', 'goya' ); ?>" class="quick_cart icon">
					<span class="text"><?php esc_attr_e('Cart', 'goya' ); ?></span>
					<?php echo apply_filters( 'goya_minicart_icon', goya_load_template_part('assets/img/svg/shopping-'. get_theme_mod('header_cart_icon', 'bag').'.svg') ); ?>
					<span class="item-counter minicart-counter<?php echo esc_attr( $count_class ); ?>"><?php echo esc_html($cart_count); ?></span>
				</a>
			<?php
			}
		}
		add_action( 'goya_quick_cart', 'goya_quick_cart', 3 );


	/* Cart Page
	---------------------------------------------------------- */

		/* Empty Cart button */

		add_action( 'woocommerce_cart_actions', 'goya_woocommerce_empty_cart_button', 20 );
		function goya_woocommerce_empty_cart_button() {
			if (get_theme_mod('shopping_cart_empty_cart', false) != true) { 
			return; } ?>
			<a href="<?php echo esc_url( add_query_arg( 'empty_cart', 'yes' ) ); ?>" class="button btn-sm empty-cart" title="<?php esc_attr_e( 'Empty Cart', 'goya' ); ?>"><?php esc_html_e( 'Empty Cart', 'goya' ); ?></a>
		<?php }

		add_action( 'wp_loaded', 'goya_woocommerce_empty_cart_action', 20 );
		function goya_woocommerce_empty_cart_action() {
			if ( isset( $_GET['empty_cart'] ) && 'yes' === esc_html( $_GET['empty_cart'] ) ) {
				WC()->cart->empty_cart();

				$referer  = wp_get_referer() ? esc_url( remove_query_arg( 'empty_cart' ) ) : wc_get_cart_url();
				wp_safe_redirect( $referer );
			}
		}