<?php function goya_shortcode_testimonial( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'quote'		=> '',
		'author_image'		=> '',
		'author_name'		=> '',
		'author_title'		=> '',
		'show_stars'		=> '',
		'stars'		=> '5',
	), $atts ) );

	// Image
	$image_class = '';
	
	if ( strlen( $author_image ) > 0 ) { $image_class = ' has-image'; }

	$out ='';
	ob_start();
	
	?>
	<div class="et-testimonial <?php echo esc_attr( $image_class ); ?>">
		<?php if ( strlen( $show_stars ) > 0 && class_exists( 'woocommerce' ) ) {
			echo '<div class="stars-rating-wrap">' . wc_get_rating_html( $stars, 1 ) . '</div>';
		} ?>
		<blockquote><?php echo wpautop($quote); ?></blockquote>
		<?php if($author_name) { ?>
			<div class="et-testimonial-image"><?php echo wp_get_attachment_image( $author_image, array('140','140') ); ?></div>
			<div class="et-testimonial-author">
				<cite><?php echo esc_html($author_name); ?></cite><?php if (!empty($author_title ) ) { ?><span class="title"><?php echo esc_html($author_title); ?></span><?php } ?>
			</div>
		<?php } ?>
	</div>

	<?php
	$out = ob_get_contents();
	if (ob_get_contents()) ob_end_clean();
	return $out;
}

add_shortcode('et_testimonial', 'goya_shortcode_testimonial');