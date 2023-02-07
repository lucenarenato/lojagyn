<?php function goya_shortcode_pricing_column( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'highlight' => '',
		'icon_type'				=> 'icon',
		'icon_library'				=> 'pixeden',
		'icon_pixeden'					=> '',
		'icon_fontawesome'					=> '',
		'image_id'				=> '',
		'title'				=> '',
		'price'					=> '',
		'sub_title'					=> '',
		'link'			=> '',
		'animation' => 'animation bottom-to-top',
		'background_color' => '',
		'icon_color' => '',
		'title_color' => '',
		'price_color' => '',
		'button_color' => '',
	), $atts ) );
		
	$content = vc_value_from_safe( $content );
	
	$element_id = uniqid('et-pricing-column-');
	$classes[] = $animation;
	$classes[] = 'et-pricing-column';
	$classes[] = 'col';
	$classes[] = 'columns';
	$classes[] = 'highlight-'.$highlight;

	// Custom styles
	$styles = '';
	if ($background_color) {
		$styles .= '#' . $element_id . ' .pricing-container { background-color:' . $background_color .'; }';
	}
	if ($icon_color) {
		$styles .= '#' . $element_id . ' .pricing-container .et-pricing-icon { color: ' . $icon_color  . '; }';
	}
	if ($title_color) {
		$styles .= '#' . $element_id . ' .et_pricing_head .pricing_title { color: ' . $title_color  . '; }';
	}
	if ($price_color) {
		$styles .= '#' . $element_id . ' .et_pricing_head .pricing_price { color: ' . $price_color  . '; }';
	}
	if ( $highlight && $button_color) {
		$styles .= '#' . $element_id . ' .button-container .button { background-color: ' . $button_color  . '; }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	$out ='';
	ob_start();

	if ( $icon_type == 'icon' ) {

		$icon = ($icon_library == 'pixeden') ? $icon_pixeden : $icon_fontawesome;

		if ( strlen( $icon ) > 0 ) {
			// Enqueue font icon styles
			if($icon_library == 'pixeden') {
				wp_enqueue_style( 'pe-icons-filled', GOYA_THEME_URI . '/assets/icons/pe-icon-7-filled/css/pe-icon-7-filled.css' );
				wp_enqueue_style( 'pe-icons-stroke', GOYA_THEME_URI . '/assets/icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css' );
			} else {
				wp_enqueue_style( 'font-awesome', vc_asset_url( 'lib/bower/font-awesome/css/font-awesome.min.css' ), array(), WPB_VC_VERSION );
			}
		}
	} else {
		
		if ( strlen( $image_id ) > 0 ) {
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
		}
	}
	
	/* Button */
	$link = ( $link == '||' ) ? '' : $link;
	$link = vc_build_link( $link  );
	
	$link_to = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'] ? $link['target'] : '_self';	
	
	?>

	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<div class="pricing-container">
			<figure class="et-pricing-icon">
				<?php if ($icon_type == 'icon') { ?>
				<span class="<?php echo esc_attr($icon); ?>"></span>
				<?php } else { ?>
					<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php esc_attr_e( $title ); ?>" />
				<?php } ?>
			</figure>
			<div class="et_pricing_head">
				<?php if ($title) { ?>
					<h4 class="pricing_title"><?php echo esc_html($title); ?></h4>
				<?php } ?>
				<?php if ($price) { ?>
					<h3 class="pricing_price"><?php echo esc_html($price); ?></h3>
				<?php } ?>
				<?php if ($sub_title) { ?>
					<p class="pricing_sub_title"><?php echo esc_html($sub_title); ?></p>
				<?php } ?>
			</div>
			<div class="pricing-description">
				<?php if ($content) { echo do_shortcode($content); } ?>
			</div>
			<?php if ( strlen( $link['url'] ) > 0 ) { ?>
				<div class="button-container">
					<a class="button <?php echo ($highlight) ? 'solid' : 'outlined'; ?> et_btn arrow-enabled" href="<?php echo esc_url($link_to); ?>" target="<?php echo sanitize_text_field( $a_target ); ?>" role="button" title="<?php echo esc_attr( $a_title ); ?>"><span><?php echo esc_attr($a_title); ?></span> <?php get_template_part('assets/img/svg/next_arrow.svg'); ?></a>
				</div>
			<?php } ?>
		</div>

	</div>
	<?php
	$out = ob_get_clean();
	return $out;
}
add_shortcode('et_pricing_column', 'goya_shortcode_pricing_column');