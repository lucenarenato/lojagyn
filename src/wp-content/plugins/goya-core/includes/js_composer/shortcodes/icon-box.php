<?php
	
// Shortcode: et_iconbox
function goya_shortcode_iconbox( $atts, $content = NULL ) {
	extract( shortcode_atts( array(
		'title'					=> '',
		'subtitle'				=> '',
		'icon_type'				=> 'icon',
		'icon_library'				=> 'pixeden',
		'icon_pixeden'					=> '',
		'icon_fontawesome'					=> '',
		'icon_style'			=> 'simple',
		'icon_color'			=> '',
		'icon_color_custom'			=> '',
		'icon_background_color_custom'	=> '',
		'text_color'			=> '',
		'title_color'			=> '',
		'subtitle_color'			=> '',
		'image_id'				=> '',
		'image_url'				=> '',
		'image_style'			=> 'default',
		'layout'				=> 'default',
		'animation' => 'animation bottom-to-top',
		'bottom_spacing'		=> 'none',
		'extra_class'			=> '',
		'link' 					=> ''
	), $atts ) );
	
	// Prepare icon/image
	if ( $icon_type === 'icon' ) {

		$icon = ($icon_library == 'pixeden') ? $icon_pixeden : $icon_fontawesome;

		if ( strlen( $icon ) > 0 ) {
			// Enqueue font icon styles
			if($icon_library == 'pixeden') {
				wp_enqueue_style( 'pe-icons-filled', GOYA_THEME_URI . '/assets/icons/pe-icon-7-filled/css/pe-icon-7-filled.css' );
				wp_enqueue_style( 'pe-icons-stroke', GOYA_THEME_URI . '/assets/icons/pe-icon-7-stroke/css/pe-icon-7-stroke.css' );
			} else {
				wp_enqueue_style( 'vc_font_awesome_5' );
			}
		}

	} else if ( $icon_type === 'image_id') {

		$icon_style = 'image-' . $image_style;
		if ( strlen( $image_id ) > 0 ) {
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
			$image_url = $image_src[0];
		}

	}

	$element_id = 'et-iconbox-' . mt_rand(10, 999);

	$class[] = 'et-iconbox';
	$class[] = 'layout-'. $layout;
	$class[] = 'icon-style-'. $icon_style;
	$class[] = 'bottom-spacing-'. $bottom_spacing;
	$class[] = 'icon-color-'. $icon_color;
	$class[] = 'text-color-'. $text_color;
	$class[] = $animation;
	$class[] = $extra_class;

  // Custom styles
	$styles = '';

	if ($icon_color_custom) {
		$styles .= '#' . $element_id . ' .et-feature-icon { color: ' . $icon_color_custom . '}';
	}
	if ( $icon_background_color_custom && $icon_style == 'background') {
		$styles .= '#' . $element_id . ' .et-feature-icon { background-color: ' . $icon_background_color_custom . '; }';
	}
	if ($title_color) {
		$styles .= '#' . $element_id . ' .title { color: ' . $title_color . '}';
	}
	if ($subtitle_color) {
		$styles .= '#' . $element_id . ' .subtitle { color: ' . $subtitle_color . '}';
	}

  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	$out = '';
	ob_start();

	// Link
	$vclink = '';
	if ( strlen( $link ) > 0 ) {
		$vclink = vc_build_link( $link );
	}

	?>

	<div id="<?php echo esc_attr( $element_id ); ?>" class="<?php echo esc_attr(implode(' ', $class)); ?>"> 
		<div class="et-icon-inner">
			<?php if ( strlen( $link ) > 0 ) { ?>
				<a href="<?php echo esc_url( $vclink['url'] ); ?>" title="<?php echo esc_attr( $vclink['title'] ); ?>">
			<?php } ?>
			<figure class="et-feature-icon">
				<?php if ($icon_type == 'icon') { ?>
				<span class="<?php echo esc_attr($icon); ?>"></span>
				<?php } else { ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( $title ); ?>" />
				<?php } ?>
			</figure>
			<?php if ( strlen( $link ) > 0 ) { ?>
				</a>
			<?php } ?>
			<div class="et-feature-content"> 
				<?php if ( strlen( $link ) > 0 ) { ?>
					<a href="<?php echo esc_url( $vclink['url'] ); ?>" title="<?php echo esc_attr( $vclink['title'] ); ?>">
				<?php } ?>
				<?php if ($subtitle) { ?>
					<h5 class="subtitle"><?php echo esc_html($subtitle); ?></h5>
				<?php } ?>
				<?php if ($title) { ?>
					<h4 class="title"><?php echo esc_html($title); ?></h4>
				<?php } ?>
				<?php if ( strlen( $link ) > 0 ) { ?>
					</a>
				<?php } ?>
				<div class="wpb_text_column"><?php echo wpb_js_remove_wpautop( $content, true ); ?></div>
			</div>
		</div>
	</div>

	<?php

	$out = ob_get_clean();
	return $out;

}

add_shortcode( 'et_iconbox', 'goya_shortcode_iconbox' );