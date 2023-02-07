<?php
	
	// Shortcode: et_lightbox
	function goya_shortcode_lightbox( $atts, $content = NULL ) {
		
		extract( shortcode_atts( array(
			'link_type'  => 'link',
			'title' => 'View',
			'button_style' => 'solid',
			'button_align' => 'center',
			'button_size' => 'lg',
			'button_color' => '',
			'link_image_id' => '',
			'content_type' => 'image',
			'content_image_id' => '',
			'content_image_caption' => '0',
			'content_url' => '',
			'content_selector' => '',
		), $atts ) );

		$content = vc_value_from_safe( $content );

		$element_id = uniqid('et-lightbox-');
		$content_src = $image_title = '';
		$mfp_class = 'mfp et-mfp-zoom-in';
		
		if ( $content_type == 'iframe' ) {
			
			$content_src = $content_url;

		} else if ( $content_type == 'inline' ) {
			
			if ( !empty($content_selector ) ) {
				$content_src = $content_selector;
			} else {
				$content_src = '#' . $element_id . '-src';
			}

			$mfp_class .= ' et-lightbox-content-inline';

		} else {
			
			$image_src = wp_get_attachment_image_src( $content_image_id, 'full' );
			$content_src = $image_src[0];
						
			// Image title
			if ( $content_image_caption ) {
				$image_title = get_the_title( $content_image_id );
			}

		}

		$styles = '';
		if ($content_type == 'inline') {
			$styles .= $content_src . ' { display: none; }';
			$styles .= '.mfp-ready ' . $content_src . ' { display: block !important; }';
		}

		//Add inline styles
	  if (class_exists('Goya_Layout')) {
	  	Goya_Layout::append_to_shortcodes_css_buffer( $styles );
	  }

	 	$out ='';
		ob_start();

		?>
		
		<div class="et-lightbox et-vc-lightbox" data-btn-inside="<?php echo ( $content_type == 'inline' ) ? true : false; ?>" data-mfp-class="<?php echo esc_attr( $mfp_class ); ?>" data-mfp-type="<?php echo esc_attr( $content_type ) ?>" data-mfp-src="<?php echo esc_url( $content_src ) ?>" data-mfp-title="<?php echo esc_attr( $image_title ) ?>" >

			<?php if ( $link_type == 'btn' ) { 
			
				$shortcode_params = 'link="url:%23" title="' . esc_attr( $title ) . '" align="' . esc_attr( $button_align ) . '" size="' . esc_attr( $button_size ) . '" style="' . esc_attr( $button_style ) . '"';
				$shortcode_params .= ( strlen( $button_color ) > 0 ) ? ' color="' . $button_color . '"' : ''; 
				
				echo do_shortcode( '[et_button ' . $shortcode_params . ']' );

			} else if ( $link_type == 'image' ) {
				
				$image_src = wp_get_attachment_image_src( $link_image_id, 'full' );
				$image_title = get_the_title( $link_image_id ); ?>
				
				<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php echo esc_attr( $image_title ); ?>" />
				<?php if ( $content_type == 'iframe' ) {?>
					<div class="video-icon">
					<?php get_template_part('assets/img/svg/play.svg'); ?>
					</div>
				<?php } ?>
				<div class="et-image-overlay"></div>

			<?php } else { ?>
				
				<a href="#"><?php echo esc_attr( $title ); ?></a>

			<?php } ?>
		</div>

		<?php if ($content_type == 'inline' and $content_selector == '' ) { ?>

			<div id="<?php echo esc_attr( $element_id . '-src' ); ?>" style="display: none;">
				<?php echo do_shortcode($content); ?>
			</div>

		<?php } ?>

		<?php

		$out = ob_get_clean();
		   
		return $out;
	}
	
	add_shortcode( 'et_lightbox', 'goya_shortcode_lightbox' );