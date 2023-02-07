<?php function goya_shortcode_counter( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'style' => 'counter-top',
		'icon_type'				=> 'icon',
		'icon_library'				=> 'pixeden',
		'icon_pixeden'					=> '',
		'icon_fontawesome'					=> '',
		'image_id'				=> '',
		'image_style'			=> 'default',
		'icon_image_width'			=> '64',
		'counter_color'				=> '',
		'icon_color'				=> '',
		'text_color'				=> '',
		'counter_color_custom'				=> '',
		'icon_color_custom'				=> '',
		'text_color_custom'				=> '',
		'counter' 					=> '',
		'speed' 					=> '2000',
		'title'					=> '',
		'description'				=> '',
		'animation' => 'animation bottom-to-top',
	), $atts ) );

	$speed = $speed === '' ? 2000 : $speed;
	$out = '';
	$element_id = uniqid('et-counter-');
	$description = vc_value_from_safe( $description );

	// Enqueue Countdown script
	wp_enqueue_script( 'counter', GOYA_THEME_URI . '/assets/js/vendor/odometer.min.js', array( 'jquery' ), '0.4.8', true );

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
		$classes[] = 'icon-style-image-' . esc_attr( $image_style );
	}

	$classes[] = 'et-counter';
	$classes[] = $animation;
	$classes[] = 'counter-color-' . $counter_color;
	$classes[] = 'icon-color-' . $icon_color;
	$classes[] = 'text-color-' . $text_color;
	$classes[] = $style;

	// Custom styles
	$styles = '';
	$styles .= '#' . $element_id . ' .odometer.odometer-auto-theme.odometer-animating-up .odometer-ribbon-inner, #' . $element_id . ' .odometer.odometer-theme-minimal.odometer-animating-up .odometer-ribbon-inner {
			transition: transform ' . $speed / 1000 .'s; }';
	if ($counter_color_custom) {
		$styles .= '#' . $element_id . ' .h1 { color: ' . $counter_color_custom  . '; }';
	}
	if ($text_color_custom) {
		$styles .= '#' . $element_id . ' h4 { color: ' . $text_color_custom  . '; }';
		$styles .= '#' . $element_id . ' .description { color: ' . $text_color_custom  . '; }';
	}
	if ($icon_color_custom) {
		$styles .= '#' . $element_id . ' i { color: ' . $icon_color_custom  . '; }';
	}
	if ($icon_image_width) {
		$styles .= '#' . $element_id . ' img { width: ' . $icon_image_width . 'px; height: auto; } #' . $element_id . ' i { font-size: ' . $icon_image_width . 'px; }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }
	
	ob_start();
	?>

	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>" >
		<?php if ($style === 'counter-bottom') { ?>
			<figure><?php if ($icon_type == 'icon') { ?>
				<span class="<?php echo esc_attr($icon); ?>"></span>
				<?php } else { ?>
					<div class="counter-image">
						<?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
					</div>
				<?php } ?>
			</figure>
			<div class="counter-container">
				<?php if ( strlen( $title ) > 0 ) { ?>
					<h4><?php echo esc_attr( $title ); ?></h4>
				<?php } ?>
				<?php if ( strlen( $description ) > 0 ) { ?>
					<div class="description"><p><?php echo esc_attr( $description ); ?></p></div>
				<?php } ?>
				<?php if ( strlen( $counter ) > 0 ) { ?>
					<div class="h1" data-count="<?php echo esc_attr($counter); ?>" data-speed="<?php echo esc_attr($speed); ?>">0</div>
				<?php } ?>
				<?php ( strlen( $counter ) > 0 ) ? '<div class="h1" data-count="'. esc_attr($counter). '" data-speed="'. esc_attr($speed) .'">0</div>' : ''; ?>
			</div>
		<?php } else { ?>
			<div class="counter-container">
				<?php if ( strlen( $counter ) > 0 ) { ?>
					<div class="h1" data-count="<?php echo esc_attr($counter); ?>" data-speed="<?php echo esc_attr($speed); ?>">0</div>
				<?php } ?>
				<?php if ( strlen( $title ) > 0 ) { ?>
					<h4><?php echo esc_attr( $title ); ?></h4>
				<?php } ?>
			</div>
			<?php if ( strlen( $description ) > 0 ) { ?>
				<div class="description"><p><?php echo esc_attr( $description ); ?></p></div>
			<?php } ?>
			<?php if($style === 'counter-top') { ?>
				<figure><?php if ($icon_type == 'icon') { ?>
					<span class="<?php echo esc_attr($icon); ?>"></span>
					<?php } else { ?>
						<div class="counter-image">
							<?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
						</div>
					<?php } ?>
				</figure>
			<?php } ?>
		<?php } ?>
		
	</div>
	<?php
	
  $out = ob_get_clean();
     
  return $out;
}
add_shortcode('et_counter', 'goya_shortcode_counter');