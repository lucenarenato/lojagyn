<?php 

function goya_custom_styles() {

	$id = get_queried_object_id();

	ob_start();

	// Primary font
	if ( get_theme_mod('main_font_source', '1') === '2' && get_theme_mod('main_font_typekit_kit_id', '') != '' ) {
		// Typekit font
		$main_font_family = get_theme_mod('main_typekit_font', '');
	}

	// Secondary font
	$second_font_enabled = ( get_theme_mod('second_font_source', '0') !== '0' ) ? true : false;
	if ( $second_font_enabled ) {
		$second_font_elements = get_theme_mod('second_font_apply',array('titles','modules','widgets','blockquotes','h2','h3'));
		if ( get_theme_mod('second_font_source', '0') === '2' && get_theme_mod('second_font_typekit_kit_id', '') != '' ) {
			// Typekit font
			$second_font_family = get_theme_mod('second_typekit_font', '');
		}
	}

 ?>


	/* Typography */
	
	<?php if ( get_theme_mod('main_font_source', '1') === '2' && !empty($main_font_family)) { ?>
	body,
	blockquote cite,
	.hentry h2,
	.post-sidebar .widget > h6,
	.hentry h2,
	.mfp-content h2,
	.footer h2,
	.hentry h3,
	.mfp-content h3,
	.footer h3,
	.hentry h4,
	.mfp-content h4,
	.footer h4,
	.et-banner-text .et-banner-title,
	.woocommerce-order-received h2,
	.woocommerce-MyAccount-content h2,
	.woocommerce-MyAccount-content h3,
	.woocommerce-checkout h3,
	.order_review_heading,
	.woocommerce-MyAccount-content legend,
	.related h2,
	.up-sells h2,
	.cross-sells h2,
	.cart-collaterals h5,
	.cart-collaterals h3,
	.cart-collaterals h2,
	.related-posts .related-title,
	.et_post_nav .post_nav_link h3,
	.comment-reply-title,
	.comment-reply-title .button,
	.product-details-accordion .woocommerce-Reviews-title,
	.comments-container .comments-title {
		font-family: <?php echo wp_kses( $main_font_family, 'text' ); ?>;
	}
	<?php } ?>

	<?php if ( $second_font_enabled ) { ?>

		<?php if ( get_theme_mod('second_font_source', '1') === '2' && !empty($second_font_family) ) { ?>
	
			<?php if (in_array('main-menu', $second_font_elements)) { ?>
			.site-header .main-navigation,
			.site-header .secondary-navigation,
			<?php } ?>
			<?php if (in_array('titles', $second_font_elements)) { ?>
			h1,
			.page-header .page-title,
			.entry-header .entry-title,
			.et-shop-title,
			.product-showcase.product-title-top .product_title,
			.et-product-detail .summary h1.product_title,
			.entry-title.blog-title,
			.post.post-detail .entry-header .entry-title,
			.post.post-detail .post-featured .entry-header .entry-title,
			.wp-block-cover .wp-block-cover-text,
			.wp-block-cover .wp-block-cover__inner-container,
			.wp-block-cover-image .wp-block-cover-image-text,
			.wp-block-cover-image h2,
			.revslider-slide-title,
			<?php } ?>
			<?php if (in_array('blockquotes', $second_font_elements)) { ?>
			blockquote h1, 
			blockquote h2, 
			blockquote h3, 
			blockquote h4, 
			blockquote h5, 
			blockquote h6,
			blockquote p,
			<?php } ?>
			<?php if (in_array('widgets', $second_font_elements)) { ?>
			.post-sidebar .widget > h6,
			<?php } ?>
			<?php if (in_array('h2', $second_font_elements)) { ?>
			.entry-content h2,
			.hentry h2,
			.mfp-content h2,
			.footer h2,
			<?php } ?>
			<?php if (in_array('h3', $second_font_elements)) { ?>
			.entry-content h3,
			.hentry h3,
			.mfp-content h3,
			.footer h3,
			<?php } ?>
			<?php if (in_array('h4', $second_font_elements)) { ?>
			.entry-content h4,
			.hentry h4,
			.mfp-content h4,
			.footer h4,
			<?php } ?>
			<?php if (in_array('posts', $second_font_elements)) { ?>
			.post .post-title h3,
			<?php } ?>
			<?php if (in_array('products', $second_font_elements)) { ?>
			.products .product .product-title h2,
			<?php } ?>
			<?php if (in_array('portfolio', $second_font_elements)) { ?>
			.et-portfolio .type-portfolio h3,
			<?php } ?>
			<?php if (in_array('modules', $second_font_elements)) { ?>
			.et-banner-text .et-banner-title,
			.woocommerce-order-received h2,
			.woocommerce-MyAccount-content h2,
			.woocommerce-MyAccount-content h3,
			.woocommerce-checkout h3,
			.order_review_heading,
			.woocommerce-MyAccount-content legend,
			.et-portfolio .type-portfolio h3,
			.related h2,
			.up-sells h2,
			.cross-sells h2,
			.cart-collaterals h5,
			.cart-collaterals h3,
			.cart-collaterals h2,
			.related-posts .related-title,
			.et_post_nav .post_nav_link h3,
			.comments-container .comments-title,
			.comment-reply-title,
			.product-details-accordion .woocommerce-Reviews-title,
			.et-hovercard .et-pricing-head,
			<?php } ?>
			.font-catcher {
				font-family: <?php echo wp_kses( $second_font_family, 'text' ); ?>;
			}
		<?php } else { ?>

			<?php if (! in_array('main-menu', $second_font_elements)) { ?>
			.theme-goya .site-header .main-navigation,
			.theme-goya .site-header .secondary-navigation,
			<?php } ?>
			<?php if (! in_array('titles', $second_font_elements)) { ?>
			.theme-goya h1,
			.theme-goya .page-header .page-title,
			.theme-goya .entry-header .entry-title,
			.theme-goya .et-shop-title,
			.theme-goya .product-showcase.product-title-top .product_title,
			.theme-goya .et-product-detail .summary h1.product_title,
			.theme-goya .entry-title.blog-title,
			.theme-goya .post.post-detail .entry-header .entry-title,
			.theme-goya .post.post-detail .post-featured .entry-header .entry-title,
			.theme-goya .wp-block-cover .wp-block-cover-text,
			.theme-goya .wp-block-cover .wp-block-cover__inner-container,
			.theme-goya .wp-block-cover-image .wp-block-cover-image-text,
			.theme-goya .wp-block-cover-image h2,
			.theme-goya .revslider-slide-title,
			<?php } ?>
			<?php if (! in_array('blockquotes', $second_font_elements)) { ?>
			.theme-goya blockquote h1, 
			.theme-goya blockquote h2, 
			.theme-goya blockquote h3, 
			.theme-goya blockquote h4, 
			.theme-goya blockquote h5, 
			.theme-goya blockquote h6,
			.theme-goya blockquote p,
			<?php } ?>
			<?php if (! in_array('widgets', $second_font_elements)) { ?>
			.theme-goya .post-sidebar .widget > .widgettitle,
			<?php } ?>
			<?php if (! in_array('h2', $second_font_elements)) { ?>
			.theme-goya .entry-content h2,
			.theme-goya .hentry h2,
			.theme-goya .mfp-content h2,
			.theme-goya .footer h2,
			<?php } ?>
			<?php if (! in_array('h3', $second_font_elements)) { ?>
			.theme-goya .entry-content h3,
			.theme-goya .hentry h3,
			.theme-goya .mfp-content h3,
			.theme-goya .footer h3,
			<?php } ?>
			<?php if (! in_array('h4', $second_font_elements)) { ?>
			.theme-goya .entry-content h4,
			.theme-goya .hentry h4,
			.theme-goya .mfp-content h4,
			.theme-goya .footer h4,
			<?php } ?>
			<?php if (! in_array('posts', $second_font_elements)) { ?>
			.theme-goya .post .post-title h3,
			<?php } ?>
			<?php if (! in_array('products', $second_font_elements)) { ?>
			.theme-goya .products .product .product-title h2,
			<?php } ?>
			<?php if (! in_array('portfolio', $second_font_elements)) { ?>
			.theme-goya .et-portfolio .type-portfolio h3,
			<?php } ?>
			<?php if (! in_array('modules', $second_font_elements)) { ?>
			.theme-goya .et-banner-text .et-banner-title,
			.theme-goya .woocommerce-order-received h2,
			.theme-goya .woocommerce-MyAccount-content h2,
			.theme-goya .woocommerce-MyAccount-content h3,
			.theme-goya .woocommerce-checkout h3,
			.theme-goya .order_review_heading,
			.theme-goya .woocommerce-MyAccount-content legend,
			.theme-goya .et-portfolio .type-portfolio h3,
			.theme-goya .related h2,
			.theme-goya .up-sells h2,
			.theme-goya .cross-sells h2,
			.theme-goya .cart-collaterals h5,
			.theme-goya .cart-collaterals h3,
			.theme-goya .cart-collaterals h2,
			.theme-goya .related-posts .related-title,
			.theme-goya .et_post_nav .post_nav_link h3,
			.theme-goya .comments-container .comments-title,
			.theme-goya .comment-reply-title,
			.theme-goya .product-details-accordion .woocommerce-Reviews-title,
			.et-hovercard .et-pricing-head,
			<?php } ?>
			.theme-goya .font-catcher {
				font-family: inherit;
				font-weight: inherit;
				font-style: inherit;
			}

		<?php } ?>
	
	<?php } ?>


	/* Typography Sizes */
	body,
	blockquote cite,
	div.vc_progress_bar .vc_single_bar .vc_label,
	div.vc_toggle_size_sm .vc_toggle_title h4 {
		font-size: <?php echo intval( get_theme_mod('font_size_medium', 16 ) ); ?>px;
	}
	
	/* Input fields size for mobiles */
	<?php if (intval( get_theme_mod('font_size_medium', 16 )) < 16 ) { ?>
	@media all and (max-width: 767px) {
		input[type="text"], input[type="password"], input[type="number"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="time"], input[type="month"], input[type="week"], input[type="email"], input[type="search"], input[type="tel"], input[type="url"], input.input-text, select, textarea {
			font-size: 16px;
		}
	}
	<?php } ?>
	
	.wp-caption-text,
	.woocommerce-breadcrumb,
	.post.listing .listing_content .post-meta,
	.footer-bar .footer-bar-content,
	.side-menu .mobile-widgets p,
	.side-menu .side-widgets p,
	.products .product.product-category a div h2 .count,
	#payment .payment_methods li .payment_box,
	#payment .payment_methods li a.about_paypal,
	.et-product-detail .summary .sizing_guide,
	#reviews .commentlist li .comment-text .woocommerce-review__verified,
	#reviews .commentlist li .comment-text .woocommerce-review__published-date,
	.commentlist > li .comment-meta,
	.widget .type-post .post-meta,
	.widget_rss .rss-date,
	.wp-block-latest-comments__comment-date,
	.wp-block-latest-posts__post-date,
	.commentlist > li .reply,
	.comment-reply-title small,
	.commentlist .bypostauthor .post-author,
	.commentlist .bypostauthor > .comment-body .fn:after,
	.et-portfolio.et-portfolio-style-hover-card .type-portfolio .et-portfolio-excerpt {
		font-size: <?php echo intval( get_theme_mod('font_size_small', 14 ) ); ?>px;
	}

	/* Typography Color */
	h1, h2, h3, h4, h5, h6  {
		color: <?php echo esc_attr( get_theme_mod('heading_color', '#282828') ); ?>;
	}


	/* Accent color */

	/* Shortcodes */
		
	/* Banners */
	.et-banner .et-banner-content .et-banner-title.color-accent,
	.et-banner .et-banner-content .et-banner-subtitle.color-accent,
	.et-banner .et-banner-content .et-banner-link.link.color-accent,
	.et-banner .et-banner-content .et-banner-link.link.color-accent:hover,
	.et-banner .et-banner-content .et-banner-link.outlined.color-accent,
	.et-banner .et-banner-content .et-banner-link.outlined.color-accent:hover {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	.et-banner .et-banner-content .et-banner-subtitle.tag_style.color-accent,
	.et-banner .et-banner-content .et-banner-link.solid.color-accent,
	.et-banner .et-banner-content .et-banner-link.solid.color-accent:hover {
		background: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}

	/* Iconbox */
	.et-iconbox.icon-style-background.icon-color-accent .et-feature-icon {
		background: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	.et-iconbox.icon-style-border.icon-color-accent .et-feature-icon,
	.et-iconbox.icon-style-simple.icon-color-accent .et-feature-icon {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	/* Counter */
	.et-counter.counter-color-accent .h1,
	.et-counter.icon-color-accent i {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}

	/* Buttons */
	.et_btn.solid.color-accent {
		background: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	.et_btn.link.color-accent,
	.et_btn.outlined.color-accent,
	.et_btn.outlined.color-accent:hover {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}

	/* Type Effects */
	.et-animatype.color-accent .et-animated-entry,
	.et-stroketype.color-accent *  {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;	
	}

	/* General */
	.slick-prev:hover,
	.slick-next:hover,
	.flex-prev:hover,
	.flex-next:hover,
	.mfp-wrap.quick-search .mfp-content [type="submit"],
	.et-close,
	.single-product .pswp__button:hover,
	.content404 h4,
	.woocommerce-tabs .tabs li a span,
	.woo-variation-gallery-wrapper .woo-variation-gallery-trigger:hover:after,
	.mobile-menu li.menu-item-has-children.active > .et-menu-toggle:after,
	.remove:hover, a.remove:hover,
	span.minicart-counter.et-count-zero,
	.tag-cloud-link .tag-link-count,
	.star-rating > span:before,
	.comment-form-rating .stars > span:before,
	.wpmc-tabs-wrapper li.wpmc-tab-item.current,
	div.argmc-wrapper .tab-completed-icon:before,
	div.argmc-wrapper .argmc-tab-item.completed .argmc-tab-number,
	.widget ul li.active,
	.et-wp-gallery-popup .mfp-arrow {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	.menu-item.accent-color a,
	.accent-color:not(.fancy-tag),
	.accent-color:not(.fancy-tag) .wpb_wrapper > h1,
	.accent-color:not(.fancy-tag) .wpb_wrapper > h2,
	.accent-color:not(.fancy-tag) .wpb_wrapper > h3,
	.accent-color:not(.fancy-tag) .wpb_wrapper > h4,
	.accent-color:not(.fancy-tag) .wpb_wrapper > h5,
	.accent-color:not(.fancy-tag) .wpb_wrapper > h6,
	.accent-color:not(.fancy-tag) .wpb_wrapper > p {
		color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?> !important;
	}
	.accent-color.fancy-tag,
	.wpb_text_column .accent-color.fancy-tag:last-child,
	.accent-color.fancy-tag .wpb_wrapper > h1,
	.accent-color.fancy-tag .wpb_wrapper > h2,
	.accent-color.fancy-tag .wpb_wrapper > h3,
	.accent-color.fancy-tag .wpb_wrapper > h4,
	.accent-color.fancy-tag .wpb_wrapper > h5,
	.accent-color.fancy-tag .wpb_wrapper > h6,
	.accent-color.fancy-tag .wpb_wrapper > p {
		background-color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}

	.wpmc-tabs-wrapper li.wpmc-tab-item.current .wpmc-tab-number,
	.wpmc-tabs-wrapper li.wpmc-tab-item.current:before,
	.tag-cloud-link:hover,
	div.argmc-wrapper .argmc-tab-item.completed .argmc-tab-number,
	div.argmc-wrapper .argmc-tab-item.current .argmc-tab-number,
	div.argmc-wrapper .argmc-tab-item.last.current + .argmc-tab-item:hover .argmc-tab-number {
		border-color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	.vc_progress_bar.vc_progress-bar-color-bar_orange .vc_single_bar span.vc_bar,
	span.minicart-counter,
	.filter-trigger .et-active-filters-count,
	.et-active-filters-count,
	div.argmc-wrapper .argmc-tab-item.current .argmc-tab-number,
	div.argmc-wrapper .argmc-tab-item.visited:hover .argmc-tab-number,
	div.argmc-wrapper .argmc-tab-item.last.current + .argmc-tab-item:hover .argmc-tab-number,
	.slick-dots li button:hover,
	.wpb_column.et-light-column .postline:before,
	.wpb_column.et-light-column .postline-medium:before,
	.wpb_column.et-light-column .postline-large:before,
	.et-feat-video-btn:hover .et-featured-video-icon:after,
	.post.type-post.sticky .entry-title a:after {
		background-color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}
	div.argmc-wrapper .argmc-tab-item.visited:before {
		border-bottom-color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
	}

	/* Loaders */
	.yith-wcan-loading:after,
	.blockUI.blockOverlay:after,
	.easyzoom-notice:after,
	.woocommerce-product-gallery__wrapper .slick:after,
	.add_to_cart_button.loading:after,
	.et-loader:after {
		background-color: <?php echo esc_attr( get_theme_mod('dot_loader_color', '#b9a16b') ); ?>;
	}

	/* Fancy Title default color */
	.fancy-title,
	h1.fancy-title,
	h2.fancy-title,
	h3.fancy-title,
	h4.fancy-title,
	h5.fancy-title,
	h6.fancy-title {
		color: <?php echo esc_attr( get_theme_mod('fancy_title_color', '#b9a16b') ); ?>
	}
	
	/* Fancy Tag default color */
	.fancy-tag,
	h1.fancy-tag,
	h2.fancy-tag,
	h3.fancy-tag,
	h4.fancy-tag,
	h5.fancy-tag,
	h6.fancy-tag {
		background-color: <?php echo esc_attr( get_theme_mod('fancy_tag_color', '#b9a16b') ); ?>
	}

	/* Mobile header breakpoint */

	@media only screen and (max-width: <?php echo esc_attr( get_theme_mod('mobile_header_breakpoint', 991) ); ?>px) {
		.header .header-mobile {
			display: block !important;
		}
		.header .header-main,
		.header .header-bottom {
			display: none !important;
		}
	}
	
	/* Header Height */
	
	@media only screen and (min-width: 992px) {
		.header,
		.header-spacer,
		.product-header-spacer {
			height: <?php echo esc_attr( get_theme_mod('header_height', 90) ); ?>px;
		}
		.page-header-transparent .hero-header .hero-title {
			padding-top: <?php echo esc_attr( get_theme_mod('header_height', 90) ); ?>px;
		}
		
		.et-product-detail.et-product-layout-no-padding.product-header-transparent .showcase-inner .product-information {
			padding-top: <?php echo esc_attr( get_theme_mod('header_height', 90) ); ?>px;
		}
		.header_on_scroll:not(.megamenu-active) .header,
		.header_on_scroll:not(.megamenu-active) .header-spacer,
		.header_on_scroll:not(.megamenu-active) .product-header-spacer {
			height: <?php echo esc_attr( get_theme_mod('header_height_sticky', 70) ); ?>px;
		}
	}

	@media only screen and (max-width: 991px) {
		.header,
		.header_on_scroll .header,
		.header-spacer,
		.product-header-spacer {
			height: <?php echo esc_attr( get_theme_mod('header_height_mobile', 60) ); ?>px;
		}
		.page-header-transparent .hero-header .hero-title {
			padding-top: <?php echo esc_attr( get_theme_mod('header_height_mobile', 60) ); ?>px;
		}
	}
	@media screen and (min-width: 576px) and (max-width: 767px) {
		.sticky-product-bar {
			height: <?php echo esc_attr( get_theme_mod('header_height_mobile', 60) ); ?>px;
		}
		.product-bar-visible.single-product.fixed-product-bar-bottom .footer {
			margin-bottom: <?php echo esc_attr( get_theme_mod('header_height_mobile', 60) ); ?>px;
		}
		.product-bar-visible.single-product.fixed-product-bar-bottom #scroll_to_top.active {
			bottom: <?php echo esc_attr( get_theme_mod('header_height_mobile', 60) + 10 ); ?>px;
		}
	}

	<?php if ( goya_wc_active() ) { 

		global $wp_query;

		$is_sale_page = $wp_query->is_sale_page;
		$is_latest_page = $wp_query->is_latest_page;

		$shop_header_bg = get_theme_mod('shop_header_bg_color', '#f8f8f8');
		$shop_hero_title = goya_meta_config('shop','hero_title','none');
		?>
		<?php if (! is_shop() ) { ?>
			<?php if ( $shop_hero_title === 'all-hero' ) { ?>
				.hero-header .hero-title {
					background-color:<?php echo esc_attr( $shop_header_bg ); ?>;
				}
			<?php } ?>
		<?php } ?>
		<?php if ( ( is_shop() || ( is_search() && $shop_hero_title != 'main-hero' ) ) && ! $is_sale_page && ! $is_latest_page ) { ?>
			<?php if ( $shop_hero_title != 'none') { ?>
				.post-type-archive-product .hero-header .hero-title {
					background-color:<?php echo esc_attr( $shop_header_bg ); ?>;
					<?php if ( ! empty (get_theme_mod('shop_header_bg_image', '') ) && ! is_search() ) { ?>
					background-image: url('<?php echo esc_attr( get_theme_mod('shop_header_bg_image', '') ); ?>');
					<?php } ?>
				}
			<?php } ?>
		<?php } ?>
		<?php if ( $is_sale_page || $is_latest_page) {
				$image_url = get_the_post_thumbnail_url(get_queried_object_id(), 'full');
				if ($image_url) { ?>
				.post-type-archive-product .hero-header .hero-title {
					background-image: url('<?php echo esc_attr( $image_url ); ?>');
				}
			<?php }
		} ?>
		<?php if ( is_tax() ) { 
			$term = get_queried_object();
			$term_id = $term->term_id;
			$header_id = get_term_meta( $term_id, 'header_id', true );
			$image = wp_get_attachment_url($header_id, 'full');
		?>
			.tax-<?php echo esc_attr($term->taxonomy) ?>.term-<?php echo esc_attr($term_id); ?> .hero-header .hero-title {
				<?php if ( get_theme_mod('shop_hero_title', 'none') != 'none' ) { ?>
					background-color:<?php echo esc_attr( $shop_header_bg ); ?>;
				<?php } ?>
				<?php if (! empty($image)) { ?>
					background-image: url('<?php echo esc_url($image); ?>');	
				<?php } ?>
			}
		<?php } ?>
	<?php } ?>
	
	/* Top bar */
	<?php $topbar_mobile =  get_theme_mod('top_bar_mobiles', array());
	$tp_sections = '';
	foreach($topbar_mobile as $i => $section) { 
		if ($tp_sections != '') {
			$tp_sections .= ',';
	}
		$tp_sections .= '.top-bar .topbar-' . $section; 
	} ?>
	<?php if ($tp_sections != '') { ?>
		@media only screen and (max-width: 991px) {
			.top-bar { display: flex; }
			<?php echo esc_attr($tp_sections); ?> { display: flex; }
	}
	<?php } ?>
	

	/* Header */
	.page-header-regular .header,
	.header_on_scroll .header {
		background-color:<?php echo esc_attr( get_theme_mod('header_background_color', '#ffffff') ); ?>;
	}

	@media only screen and (max-width: 576px) {
		.page-header-transparent:not(.header-transparent-mobiles):not(.header_on_scroll) .header {
			background-color:<?php echo esc_attr( get_theme_mod('header_background_color', '#ffffff') ); ?>;
		}
	}
	.header a,
	.header .menu-toggle,
	.header .goya-search button {
		color:<?php echo esc_attr( get_theme_mod('header_navigation_color', '#282828') ); ?>;
	}
	
	@media only screen and (max-width: 767px) {
		
		.sticky-header-light .header .menu-toggle:hover,
		.header-transparent-mobiles.sticky-header-light.header_on_scroll .header a.icon,
		.header-transparent-mobiles.sticky-header-light.header_on_scroll .header .menu-toggle,
		.header-transparent-mobiles.light-title:not(.header_on_scroll) .header a.icon,
		.header-transparent-mobiles.light-title:not(.header_on_scroll) .header .menu-toggle {
			color:<?php echo esc_attr( get_theme_mod('header_navigation_color_light', '#ffffff') ); ?>;
		}
	}
	@media only screen and (min-width: 768px) {
		.light-title:not(.header_on_scroll) .header .site-title,
		.light-title:not(.header_on_scroll) .header .et-header-menu>li> a,
		.sticky-header-light.header_on_scroll .header .et-header-menu>li> a,
		.light-title:not(.header_on_scroll) span.minicart-counter.et-count-zero,
		.sticky-header-light.header_on_scroll .header .icon,
		.sticky-header-light.header_on_scroll .header .menu-toggle,
		.light-title:not(.header_on_scroll) .header .icon,
		.light-title:not(.header_on_scroll) .header .menu-toggle {
			color:<?php echo esc_attr( get_theme_mod('header_navigation_color_light', '#ffffff') ); ?>;
		}
	}
	.et-header-menu .menu-label,
	.mobile-menu .menu-label {
		background-color:<?php echo esc_attr( get_theme_mod('header_navigation_tag_color', '#bbbbbb') ); ?>;
	}

	/* Menu: Dropdown */
	.et-header-menu ul.sub-menu:before,
	.et-header-menu .sub-menu .sub-menu {
		background-color:<?php echo esc_attr( get_theme_mod('dropdown_menu_background_color', '#ffffff') ); ?> !important;
	}
	.et-header-menu>li.menu-item-has-children > a:after {
		border-bottom-color:<?php echo esc_attr( get_theme_mod('dropdown_menu_background_color', '#ffffff') ); ?>;
	}
	.et-header-menu .sub-menu li.menu-item-has-children:after,
	.et-header-menu ul.sub-menu li a {
		color:<?php echo esc_attr( get_theme_mod('dropdown_menu_font_color', '#444444') ); ?>;
	}

	/* Vertical bar */
	.side-panel .mobile-bar,
	.side-panel .mobile-bar.dark {
		background:<?php echo esc_attr( get_theme_mod('vertical_bar_background', '#f8f8f8') ); ?>;
	}

	/* Mobile menu */
	.side-mobile-menu,
	.side-mobile-menu.dark {   
		background:<?php echo esc_attr( get_theme_mod('menu_mobile_background_color', '#ffffff') ); ?>;
	}

	/* Full Screen menu */
	.side-fullscreen-menu,
	.side-fullscreen-menu.dark {   
		background:<?php echo esc_attr( get_theme_mod('menu_fullscreen_background_color', '#ffffff') ); ?>;
	}
	
	/* Footer widgets */
	.site-footer,
	.site-footer.dark {
		background-color:<?php echo esc_attr( get_theme_mod('footer_widgets_background', '#ffffff') ); ?>;
	}

	/* Footer bar */
	.site-footer .footer-bar.custom-color-1,
	.site-footer .footer-bar.custom-color-1.dark {
		background-color:<?php echo esc_attr( get_theme_mod('footer_bar_background', '#ffffff') ); ?>;
	}


	/* Shop */

	/* Catalog Mode */
	<?php if ( get_theme_mod('shop_catalog_mode', false) == true ) { ?>
		.single_variation_wrap { display: none !important; }
		.et-product-detail .summary .product_actions_wrap { justify-content: left; }
	<?php } ?>

	/* Quick View */
	.mfp #et-quickview {
		max-width: <?php echo esc_attr( get_theme_mod('product_quickview_width', 960) ); ?>px;
	}

	/* Single product */
	<?php 
		$showcase_bg = get_post_meta( $id, 'goya_product_showcase_background', true);

		if ( get_theme_mod('single_product_background', false) == true || $showcase_bg ) { 
			if (! $showcase_bg) { // use global value instead
			$showcase_bg = get_theme_mod('single_product_background_color', '#f8f8f8');
			}
		?>
		.easyzoom-flyout,
		.single-product .pswp__bg,
		.single-product .pswp__img--placeholder--blank,
		.product-showcase {
			background: <?php echo esc_attr( $showcase_bg ); ?>;
		}
	<?php } ?>

	/* Single Product: Accordion Scrollbar */
	.woocommerce-Tabs-panel.custom_scroll {
		max-height:<?php echo esc_attr( get_theme_mod('product_accordion_max_height', 400) ); ?>px;
	}

	/* Single Product: Meta */
	<?php 
	$meta_sku = get_theme_mod('product_meta_sku', true);
	$meta_cat = get_theme_mod('product_meta_categories', true);
	$meta_tag = get_theme_mod('product_meta_tags', true);
	?>

	<?php if (!$meta_sku) { ?>
		.product_meta .sku_wrapper,
	<?php } ?>
	<?php if (!$meta_cat) { ?>
		.product_meta .posted_in,
	<?php } ?>
	<?php if (!$meta_tag) { ?>
		.product_meta .tagged_as,
	<?php } ?>
	.product_meta .trap {
		display: none !important;
	}

	<?php if (!$meta_sku && !$meta_cat && !$meta_tag) { ?>
		.product_meta {
			display: none !important;
		}
		.product_meta + .post-share {
			margin-top: 30px;
		}
	<?php } ?>

	/* Shop: Filters: Scrollbar */
	.shop-widget-scroll .widget > ul,
	.shop-widget-scroll .widget:not(.widget-woof) > .widgettitle + *,
	.shop-widget-scroll .wcapf-layered-nav {
		max-height:<?php echo esc_attr( get_theme_mod('shop_filters_height', 150) ); ?>px;
	}

	/* Shop: Progress bar */
	<?php $progress_bar_color = get_theme_mod('progress_bar_color', '#b9a16b'); ?>
	.free-shipping-progress-bar .progress-bar-indicator {
		background: linear-gradient(270deg, <?php echo esc_attr( $progress_bar_color ); ?> 0, #ffffff 200%);
		background-color:  <?php echo esc_attr( $progress_bar_color ); ?>;
		flex-grow: 1;
	}
	.rtl .free-shipping-progress-bar .progress-bar-indicator {
		background: linear-gradient(90deg, <?php echo esc_attr( $progress_bar_color ); ?> 0, #ffffff 200%);
	}
	.progress-bar-status.success .progress-bar-indicator {
	 background: <?php echo esc_attr( get_theme_mod('progress_bar_success_color', '#67bb67') ); ?>;
	}

	/* Shop: Colors */

	.star-rating > span:before,
	.comment-form-rating .stars > span:before {
		color:<?php echo esc_attr( get_theme_mod('rating_stars_color', '#282828') ); ?>;
	}

	.product-inner .badge.onsale,
	.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-onsale {
		color:<?php echo esc_attr( get_theme_mod('sale_badge_font_color', '#ef5c5c') ); ?>;
		background-color:<?php echo esc_attr( get_theme_mod('sale_badge_background_color', '#ffffff') ); ?>;
	}
	.et-product-detail .summary .badge.onsale {
		border-color: <?php echo esc_attr( get_theme_mod('sale_badge_font_color', '#ef5c5c') ); ?>;
	}
	.product-inner .badge.new {
		color:<?php echo esc_attr( get_theme_mod('new_badge_font_color', '#585858') ); ?>;
		background-color:<?php echo esc_attr( get_theme_mod('new_badge_background_color', '#ffffff') ); ?>;
	}
	.product-inner .badge.out-of-stock {
		color:<?php echo esc_attr( get_theme_mod('stock_badge_font_color', '#585858') ); ?>;
		background-color:<?php echo esc_attr( get_theme_mod('stock_badge_background_color', '#ffffff') ); ?>;
	}

	/* WooCommerce Blocks */

	
	@media screen and (min-width: 768px) {
		<?php if (get_theme_mod('shop_product_animation_hover', 'zoom-jump') == 'jump' || get_theme_mod('shop_product_animation_hover', 'zoom-jump') == 'zoom-jump') { ?>
		.wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-image {
			margin-top: 5px;
		}
		.wc-block-grid__products .wc-block-grid__product:hover .wc-block-grid__product-image {
		  transform: translateY(-5px);
		}
		<?php } ?>
		<?php if (get_theme_mod('shop_product_animation_hover', 'zoom-jump') == 'zoom-jump') { ?>
		.wc-block-grid__products .wc-block-grid__product:hover .wc-block-grid__product-image img {
	    -moz-transform: scale(1.05, 1.05);
	    -ms-transform: scale(1.05, 1.05);
	    -webkit-transform: scale(1.05, 1.05);
	    transform: scale(1.05, 1.05);
	  }
	  <?php } ?>
	}
	

	/* Blog: Title */

	.et-blog.hero-header .hero-title {
		background-color:<?php echo esc_attr( get_theme_mod('blog_hero_title_bg', '#f8f8f8') ); ?>;
	}

	<?php 
  if ( is_home() && ! is_front_page() ) {
    $page = get_queried_object();

    if ( !is_null( $page ) && $page->ID == get_option( 'page_for_posts' ) ) {

    if ( ! empty (get_theme_mod('blog_header_bg_image', '') ) ) { ?>
    	.et-blog.hero-header .hero-title {
				background-image: url('<?php echo esc_attr( get_theme_mod('blog_header_bg_image', '') ); ?>');
			}
			<?php }
    }
  } else if (is_category()) {
  		$cat = get_queried_object();
  		$cat_id = $cat->term_id;
  		$header_id = get_term_meta( $cat_id, 'header_id', true );
  		
  		$image = wp_get_attachment_url($header_id, 'full');
  	?>
  		.category.category-<?php echo esc_attr($cat_id); ?> .hero-header .hero-title {
  			<?php if ( get_theme_mod('shop_hero_title', 'none') != 'none' ) { ?>
  				background-color:<?php echo esc_attr( get_theme_mod('blog_hero_title_bg', '#f8f8f8') ); ?>;
  			<?php } ?>
  			<?php if (! empty($image)) { ?>
  				background-image: url('<?php echo esc_url($image); ?>');	
  			<?php } ?>
  		}
  	<?php } ?>

	/* Single post */
	<?php $hero_bg = get_post_meta( $id, 'goya_post_hero_background', true); ?>
	
	.post.post-detail.hero-title .post-featured.title-wrap {
		background-color:<?php echo esc_attr( get_theme_mod('blog_hero_title_bg', '#f8f8f8') ); ?>;
		<?php if ( $hero_bg ) echo 'background-color: ' . esc_attr($hero_bg).';'; ?>
	}

	/* Pages/Portfolio background */
	<?php $page_bg = get_post_meta( $id, 'goya_page_page_background', true);
	$portfolio_bg = get_post_meta( $id, 'goya_portfolio_page_background', true);

	if ($page_bg) { ?>
		.page-id-<?php echo esc_attr($id); ?> #wrapper div[role="main"] {
			background-color: <?php echo esc_attr( $page_bg ); ?>
		}
	<?php } 
	if ($portfolio_bg) { ?>
		.postid-<?php echo esc_attr($id); ?> #wrapper div[role="main"] {
			background-color: <?php echo esc_attr( $portfolio_bg ); ?>
		}
	<?php } ?>

	/* Page hero title background */
	<?php $hero_bg = get_post_meta( $id, 'goya_page_hero_title_background', true);
	$title_style = get_post_meta(get_queried_object_id(), 'goya_page_title_style', true);

	if ($title_style == 'hero' && $hero_bg) { ?>
	.page-id-<?php echo esc_attr($id); ?> .hero-header .hero-title {
		background-color: <?php echo esc_attr( $hero_bg ); ?>
	}
	<?php } ?>

	/* Portfolio hero title background */
	<?php $hero_bg = get_post_meta( $id, 'goya_portfolio_hero_title_background', true);
	$portfolio_layout = goya_meta_config('portfolio','layout_single','regular');;

	if ($portfolio_layout == 'hero' && $hero_bg) { ?>
	.postid-<?php echo esc_attr($id); ?> .post-detail.hero-title .post-featured.title-wrap {
		background-color: <?php echo esc_attr( $hero_bg ); ?>
	}
	<?php } ?>

	/* Gutenberg Styles */
	<?php 
	// Retrieve the accent color from the Customizer.
	$gutstyles = array(
		'white' => '#ffffff',
		'shade' => '#f8f8f8',
		'gray' => get_theme_mod( 'main_font_color', '#777777' ),
		'dark' => get_theme_mod( 'primary_buttons', '#282828' ),
		'accent' => get_theme_mod( 'accent_color', '#b9a16b' ),
	);

	goya_gutenberg_colors($gutstyles);

	?>

	/* Translation Styles */
	.commentlist .bypostauthor > .comment-body .fn:after {
		content: '<?php echo esc_html__( 'Post Author', 'goya' ); ?>';
	}
	.et-inline-validation-notices .form-row.woocommerce-invalid-required-field:after{
		content: '<?php echo esc_html__( 'Required field', 'goya' ); ?>';
	}
	.post.type-post.sticky .entry-title a:after {
		content: '<?php echo esc_html__( 'Featured', 'goya' ); ?>';
	}

	/* Custom CSS */
	<?php 
	if( get_theme_mod('custom_css_status', false) == true ) {
		echo get_theme_mod('custom_css_code', '');
	}

	$styles = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();

	$styles = goya_clean_custom_css($styles);

	return $styles;
}


/* Add custom colors to Gutenberg. */
function goya_gutenberg_colors($gutstyles) {

	// Build styles.
	$css  = '';
	foreach ($gutstyles as $name => $color) {
		$css .= '.has-gutenberg-'.$name.'-color { color: ' . esc_attr( $color ) . ' !important; }';
		$css .= '.has-gutenberg-'.$name.'-background-color { background-color: ' . esc_attr( $color ) . '; }';
		$css .= '.wp-block-button.outlined .has-gutenberg-'.$name.'-color { border-color: ' . esc_attr( $color ) . ' !important; background-color: transparent !important; }';
	}
	
	echo wp_strip_all_tags( $css );
}

/* Process background field from array */
function goya_bg_output($array) {
	if(!empty($array)) {
		if (!empty($array['background-color'])) { 
			echo "background-color: " . $array['background-color'] . " !important;\n";
		}
		if (!empty($array['background-image'])) { 
			echo "background-image: url(" . $array['background-image'] . ") !important;\n";
		}
		if (!empty($array['background-repeat'])) { 
			echo "background-repeat: " . $array['background-repeat'] . " !important;\n";
		}
		if (!empty($array['background-attachment'])) { 
			echo "background-attachment: " . $array['background-attachment'] . " !important;\n";
		}
		if (!empty($array['background-position'])) { 
			echo "background-position: " . $array['background-position'] . " !important;\n";
		}
		if (!empty($array['background-size'])) { 
			echo "background-size: " . $array['background-size'] . " !important;\n";
		}
	}
}
