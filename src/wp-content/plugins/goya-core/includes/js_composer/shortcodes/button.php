<?php
	
// Shortcode: et_button
function goya_shortcode_button( $atts, $content = NULL ) {
	extract( shortcode_atts( array(
		'title'	=> __( 'Button with Text', 'goya-core' ),
		'link' 	=> '',
		'style'	=> 'solid',
		'color'	=> '',
		'color_custom'	=> '',
		'text_color_custom'	=> '',
		'el_id' => '',
		'el_class' => '',
		'size' 	=> 'md',
		'add_arrow' => '',
		'shadow' => '',
		'animation' => '',
		'align'	=> 'left',
		'extra_class'	=> '',
	), $atts ) );

	$element_id =  (!empty( $el_id )) ? $el_id  : uniqid("et-button-");
	
	// Parse link
	$link = ( $link == '||' ) ? '' : $link;
	$link = vc_build_link( $link );
	$a_href = $link['url'];
  $a_title_attr = ( strlen( $link['title'] ) > 0 ) ? $link['title'] : '';
  $a_target_attr = ( strlen( $link['target'] ) > 0 ) ? $link['target'] : '';
	
	// Class
	$class[] = $el_class;
	$class[] = 'et_btn button';
	$class[] = 'et_btn_' . $size;
	$class[] = $style;
	$class[] = 'color-' . $color;
	$class[] = $shadow;
	$class[] = $add_arrow ? 'arrow-enabled' : '';
	$class[] = $extra_class;

	// Custom styles
	$styles = '';
	if ( strlen( $color_custom ) > 0 ) {
		if ( strpos( $style, 'outlined' ) !== false ) {
			$styles .= '#' . $element_id . ' .et_btn { color:' . $color_custom .'; border-color:'. $color_custom .'; }';
			$styles .= '#' . $element_id . ' .et_btn svg { fill:' . $color_custom .'; }';
		} 
		else if ( strpos( $style, 'link' ) !== false ) {
			$styles .= '#' . $element_id . ' .et_btn { color:' . $color_custom .'; }';
			$styles .= '#' . $element_id . ' .et_btn svg { fill:' . $color_custom .'; }';
		}
		else {
			$styles .= '#' . $element_id . ' .et_btn { background-color:' . $color_custom .'; }';
			if ( strlen( $text_color_custom ) > 0 ) {
				$styles .= '#' . $element_id . ' .et_btn { background-color:' . $color_custom .'; color:' . $text_color_custom .'; }';
				$styles .= '#' . $element_id . ' .et_btn svg { fill:' . $text_color_custom .'; }';
			}
		}
		
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	$out = '';
	ob_start();

	?>
		<div id="<?php echo esc_attr($element_id); ?>" class="et_btn_align_<?php echo esc_attr($align . ' ' . $animation); ?>">
			<a href="<?php echo esc_url($a_href) ?>" class="<?php echo esc_attr(implode(' ', $class)); ?>" <?php if (strlen( $link['target'] ) > 0 ) { ?>target="<?php echo esc_attr( $a_target_attr ); ?>"<?php } ?> role="button" title="<?php echo esc_attr( $a_title_attr ); ?>" ><span><?php echo esc_attr( $title ); ?></span><?php if ($add_arrow) { get_template_part('assets/img/svg/next_arrow.svg'); } ?></a>
		</div>
		
	<?php

	$out = ob_get_clean();
     
  return $out;

}
	
add_shortcode( 'et_button', 'goya_shortcode_button' );