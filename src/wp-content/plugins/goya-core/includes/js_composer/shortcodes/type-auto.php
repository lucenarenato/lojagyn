<?php function goya_shortcode_typeauto( $atts, $content = null ) {

  extract( shortcode_atts( array(
		'typed_text' => '<h2>Your animated text *Goya;WordPress*</h2>',
		'text_color' => '',
		'text_color_custom' => '',
		'text_size' => 'medium',
		'text_size_custom' => '',
		'typed_speed' => '',
		'cursor' => '',
		'loop' => '',
		'extra_class' => '',
	), $atts ) );

	// Enqueue Scripts
	wp_enqueue_script( 'typed',  GOYA_THEME_URI . '/assets/js/vendor/typed.min.js', array( 'jquery' ), '2.0.9', TRUE);
  
	$out = $text = '';
	$element_id = uniqid('et-autotype-');
	$typed_text_safe = vc_value_from_safe($typed_text);
	$typed_text_safe = goya_remove_vc_added_p($typed_text_safe);
	$typed_speed = $typed_speed !== '' ? $typed_speed : 50;
	
	$class[] = 'et-autotype';
	$class[] = 'et-animatype';
	$class[] = 'size-' . $text_size;
	$class[] = 'color-' . $text_color;
	$class[] = $extra_class;

	// Custom styles
	$styles = '';
	
	if ($text_size_custom) {
		$font_value = preg_replace('/[^0-9]/', '', $text_size_custom);
		$font_unit = preg_replace('/[0-9]/', '', $text_size_custom);
		$font_unit = ( $font_unit != '' ) ? $font_unit : 'px';
		
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

	if ($text_color_custom) {
		$styles .= '#' . $element_id . ' .et-animated-entry { color:' . $text_color_custom .'; }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	ob_start();
	?>
	<div id="<?php echo esc_attr($element_id); ?>" class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<?php 
			if(preg_match_all("/(\*.*?\*)/is", $typed_text_safe, $entries)) {
				foreach($entries[0] as $entry) {
				  $text = substr($entry, 1, -1);
				  $autotype = explode(';', $text);
				  $autotype = array_map('trim', $autotype);
				  
				  $typed_text_safe = str_replace($entry, '<placeholder>', $typed_text_safe);
				}
			}
			echo str_replace('<placeholder>', '<span class="et-animated-entry" data-et-cursor="'.esc_attr($cursor).'" data-et-loop="'.esc_attr($loop).'" data-strings="'.esc_attr(json_encode($autotype)).'" data-speed="'.esc_attr($typed_speed).'"></span>', $typed_text_safe);
		?>
	</div>
  
  <?php
  $out = ob_get_clean();
     
  return $out;
}
add_shortcode('et_typeauto', 'goya_shortcode_typeauto');