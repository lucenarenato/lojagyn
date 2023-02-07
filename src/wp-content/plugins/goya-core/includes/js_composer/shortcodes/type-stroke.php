<?php function goya_shortcode_typestroke( $atts, $content = null ) {

  extract( shortcode_atts( array(
		'slide_text' => '<h2>Type Stroke</h2>',
		'stroke_width' => '',
		'text_size' => 'medium',
		'text_size_custom' => '',
		'text_color' => '',
		'text_color_custom' => '',
		'extra_class' => '',
		'animation' => '',
	), $atts ) );
  
	$out = $text = '';
	$element_id = uniqid('et-stroketype-');
	$stroke_text_safe = vc_value_from_safe($slide_text);
	
	$stroke_text_safe = goya_remove_vc_added_p($stroke_text_safe);
	
	$class[] = 'et-stroketype';
	$class[] = 'et-animatype';
	$class[] = 'size-' . $text_size;
	$class[] = 'color-' . $text_color;
	$class[] = $extra_class;
	$class[] = $animation;

	// Custom styles
	$styles = '';

	if ($text_color_custom) {
		$styles .= '#' . $element_id . ' * { 
			color:' . $text_color_custom . ';
			-webkit-text-stroke-color:' . $text_color_custom . ';
	    -moz-text-stroke-color:' . $text_color_custom . ';
	    -o-text-stroke-color:' . $text_color_custom . ';
	    -ms-text-stroke-color:' . $text_color_custom . ';
	    text-stroke-color:' . $text_color_custom . ';
	  }';
	}
	if ($stroke_width) {
		$styles .= '#' . $element_id . ' * { 
			-webkit-text-stroke-width:' . $stroke_width . ';
	    -moz-text-stroke-width:' . $stroke_width . ';
	    -o-text-stroke-width:' . $stroke_width . ';
	    -ms-text-stroke-width:' . $stroke_width . ';
	    text-stroke-width:' . $stroke_width . ';
	  }';
	}
	if ($text_size_custom) {
		$font_value = preg_replace('/[^0-9]/', '', $text_size_custom);
		$font_unit = preg_replace('/[0-9]/', '', $text_size_custom);
		
		$styles .= '#' . $element_id . ' * { 
			font-size:' . floor($font_value/1.6) . $font_unit . ';
	  }';
	   $styles .= '@media (min-width: 576px) { #' . $element_id . ' * { 
			font-size:' . floor($font_value/1.3) . $font_unit . ';
	  } }';
	  $styles .= '@media (min-width: 768px) { #' . $element_id . ' * { 
			font-size:' . $font_value . $font_unit . ';
	  } }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
		Goya_Layout::append_to_shortcodes_css_buffer( $styles );
	}

	ob_start();
	?>
	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<?php echo wp_kses_post($stroke_text_safe); ?>
	</div>
  
  <?php
  $out = ob_get_clean();
     
  return $out;
}
add_shortcode('et_typestroke', 'goya_shortcode_typestroke');