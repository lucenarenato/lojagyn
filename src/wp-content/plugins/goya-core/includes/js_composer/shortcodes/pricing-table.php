<?php function goya_shortcode_pricing_table( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'background_color' => '',
		'icon_color' => '',
		'title_color' => '',
		'price_color' => '',
		'button_color' => '',
	), $atts ) );
	
	$element_id = uniqid('et-pricing-table-');
	$classes[] = 'et-pricing-table';

	// Custom styles
	$styles = '';
	if ($background_color) {
		$styles .= '#' . $element_id . ' .highlight- .pricing-container { background-color:' . $background_color .'; }';
	}
	if ($icon_color) {
		$styles .= '#' . $element_id . ' .et-pricing-icon i { color: ' . $icon_color  . '; }';
	}
	if ($title_color) {
		$styles .= '#' . $element_id . ' .et_pricing_head h4 { color: ' . $title_color  . '; }';
	}
	if ($price_color) {
		$styles .= '#' . $element_id . ' .et_pricing_head h3 { color: ' . $price_color  . '; }';
	}
	if ($button_color) {
		$styles .= '#' . $element_id . ' .button-container .button.outlined { color: ' . $button_color  . '; }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	$out ='';
	ob_start();
	
	?>

	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<div class="row">
			<?php echo wpb_js_remove_wpautop($content, false); ?>
		</div>
	</div>
	<?php
	$out = ob_get_clean();
	return $out;
}
add_shortcode('et_pricing_table', 'goya_shortcode_pricing_table');