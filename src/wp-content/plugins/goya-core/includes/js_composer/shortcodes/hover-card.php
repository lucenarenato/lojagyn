<?php function goya_shortcode_hovercard( $atts, $content = null ) {

  extract( shortcode_atts( array(
  	'icon_type'           => 'icon',
  	'icon_library'        => 'pixeden',
  	'icon_pixeden'        => '',
  	'icon_fontawesome'    => '',
  	'image_id'            => '',
  	'normal_title'        => '',
  	'normal_title_color'  => '',
  	'normal_bg_color'     => '',
  	'hover_title'         => '',
  	'hover_content'       => '',
  	'hover_icon_color'    => '',
  	'hover_title_color'   => '',
  	'hover_content_color' => '',
  	'normal_bg_image'     => '',
  	'hover_bg_color'      => '',
  	'animation'           => '',
  	'link'                => '',
  	'min_height'          => '300',
  	'extra_class'         => '',
  ), $atts ) );

  $element_id = uniqid('et-hovercard-');
  $classes[] = $element_id;
  $classes[] = $animation;
  $classes[] = 'et-hovercard';
  $classes[] = $extra_class;
  $normal_bg_image = wpb_getImageBySize( array( 'attach_id' => $normal_bg_image, 'thumb_size' => 'full' ) );

  // Custom styles
	$styles = '';
	if(!empty($normal_bg_image['p_img_large'][0])) {
		$normal_image = $normal_bg_image['p_img_large'][0];	
		$styles .= '.' . $element_id . ' .et-hovercard-front { background-image: url(' . $normal_image . ')' . '}';
	}
	

	$styles .= '.' . $element_id . ' { min-height: ' . $min_height . 'px' . '}';
	
	if ($normal_title_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-front .et-pricing-head { color: ' . $normal_title_color . '}';
	}
	if ($normal_bg_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-side.et-hovercard-front { background-color: ' . $normal_bg_color . '}';
	}
	if ($hover_title_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-back .et-pricing-head { color: ' . $hover_title_color . '}';
	}
	if ($hover_content_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-back .et-pricing-content { color: ' . $hover_content_color . '}';
	}
	if ($hover_icon_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-back .et-pricing-icon { color: ' . $hover_icon_color . '}';
	}
	if ($hover_bg_color) {
		$styles .= '.' . $element_id . ' .et-hovercard-side.et-hovercard-back { background-color: ' . $hover_bg_color . '}';
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
				wp_enqueue_style( 'vc_font_awesome_5' );
			}
		}
	} else {
		
		if ( strlen( $image_id ) > 0 ) {
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
		}
	}

	$link = ( $link == '||' ) ? '' : $link;
	$link = vc_build_link( $link  );
	
	$link_to = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'] ? $link['target'] : '_self';
	
	?>
	
	<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<?php if ( strlen( $link['url'] ) > 0 ) { ?><a class="et-hovercard-link" href="<?php echo esc_url($link_to); ?>" target="<?php echo sanitize_text_field( $a_target ); ?>"><?php } ?>
		<div class="et-hovercard-front et-hovercard-side">
			<div class="et-hovercard-inner">
				<h3 class="et-pricing-head"><?php echo esc_html($normal_title); ?></h3>
			</div>
		</div>
		<div class="et-hovercard-back et-hovercard-side">
			<div class="et-hovercard-inner">
				<?php if ($icon || $image_src) { ?>
				<figure class="et-pricing-icon">
					<?php if ($icon_type == 'icon') { ?>
					<span class="<?php echo esc_attr($icon); ?>"></span>
					<?php } else { ?>
						<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
					<?php } ?>
				</figure>
			<?php } ?>
				<h3 class="et-pricing-head"><?php echo esc_html($hover_title); ?></h3>
				<?php if ($hover_content) { ?>
				<div class="et-pricing-content"><?php echo wp_kses_post($hover_content); ?></div>
				<?php } ?>
			</div>
		</div>
		<?php if ( strlen( $link['url'] ) > 0 ) { ?></a><?php } ?>

	</div>
	<?php
	$out = ob_get_clean();

  //Output shortcode contents
  return $out;

}
add_shortcode('et_hovercard', 'goya_shortcode_hovercard');