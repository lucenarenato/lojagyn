<?php function goya_shortcode_image( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'image'        => '',
		'caption'     => '',
		'full_width'       => '',
		'animation' => '',
		'img_size'        => '',
		'alignment'    => '',
		'lightbox'    => '',
		'img_link'    => '',
		'extra_class'    => '',
		'border_radius'    => '',
		'box_shadow'    => '',
		'max_width'    => '',
	), $atts ) );
	
	$element_id = 'et-image-' . mt_rand(10, 999);
	
	$img_id = preg_replace('/[^\d]/', '', $image);
	
	$full = $full_width === 'true' ? 'full' : '';
	$img_size = ($img_size === '' ? 'full' : $img_size);
	$final_image = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size ) );

	$image_title = get_the_title( $image );
  
  $link_to = $c_lightbox = $a_title = $a_target = '';
  $image_post = get_post($img_id);
  $image_caption = ( isset($image_post->post_excerpt) ) ? $image_post->post_excerpt : $image_title;
  $c_lightbox = '';
  
  if ($lightbox == true) {
    $link = wp_get_attachment_image_src( $img_id, 'full');
    $link_to = $link[0];
    $c_lightbox = 'mfp-image et-lightbox';
    $a_title = $image_title;
  } else {
		$img_link = ( $img_link == '||' ) ? '' : $img_link;
		$link = vc_build_link( $img_link );
		
    $link_to = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'] ? $link['target'] : '_self';	
  }
  
  $classes[] = $element_id;
	$classes[] = 'et-image';
	$classes[] = $alignment;
	$classes[] = $full;
	$classes[] = $extra_class;
	$classes[] = $box_shadow;
	$classes[] = 'et_image_link';

	// Custom styles
	$styles = '';
	if ($border_radius) {
		$styles .= '.' . $element_id . ', .' . $element_id . ' img { border-radius:' . $border_radius .'; }';
	}

	//Add inline styles
  if (class_exists('Goya_Layout')) {
  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
  }

	
	$out ='';
	ob_start();
	?>
	<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<div class="et-image-inner <?php echo esc_attr( $animation ); ?>">
			<?php if (!empty($link_to)) { ?>
				<a <?php if ($lightbox == true) { ?> class="<?php echo esc_attr($c_lightbox); ?>" data-mfp-type="image" data-mfp-src="<?php echo esc_url( $link_to ) ?>" <?php } else { ?> href="<?php echo esc_url($link_to); ?>" target="<?php echo sanitize_text_field( $a_target ); ?>" <?php } ?> title="<?php echo esc_attr($a_title); ?>">
			<?php } ?>
				<div class="et-image-thumb <?php echo esc_attr($max_width); ?>">
					<?php
					if ( $final_image != '' ) {
						echo $final_image['thumbnail'];
					} else { ?>
						<img src="<?php echo get_template_directory_uri() . '/assets/img/placeholder.png'; ?>" />
					<?php } ?>
				</div>
			<?php if (!empty($link_to)) { ?>
				</a>
			<?php } ?>
			<?php if ($image_caption && $caption === 'true') { ?>
				<div class="wp-caption-text"><?php echo esc_html($image_caption); ?></div>
			<?php } ?>
			<?php if ($content) { ?>
				<div class="et-image-content">
					<?php echo wpb_js_remove_wpautop( $content, true ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
  <?php
  
	$out = ob_get_clean();
	return $out;
}
add_shortcode('et_image', 'goya_shortcode_image');