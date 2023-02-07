<?php
	$title_class[] = 'post-featured';
	$title_class[] = 'single-image';
	$title_class[] = 'title-wrap';

	$image_id = $image_src = '';
	if ( has_post_thumbnail() ) {
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id, 'full');
		$image_src = $image_url[0];
	}

	if ( rwmb_meta( 'goya_portfolio_featured_gallery') !== '' ) {
		$gallery = array();
		$gallery = rwmb_meta( 'goya_portfolio_featured_gallery', array( 'size' => 'full' ) );
		if (!empty($gallery) && count($gallery) > 0) {
			$gallery = array_shift($gallery);
			$image_src = $gallery['url'];
		}
	}

?>

<div class="post-featured-section">
	<?php if ( $image_src != '' ) {
		$title_class[] = 'parallax_image';
		$title_class[] = 'vh-height';
	?>
		<figure class="<?php echo esc_attr(implode(' ', $title_class)); ?>" style="background-image: url(<?php echo esc_url($image_src); ?>);">
	<?php } else { ?>
		<figure class="<?php echo esc_attr(implode(' ', $title_class)); ?>" >
	<?php } ?>
		<?php get_template_part( 'inc/templates/portfolio/portfolio-title'); ?>
	</figure>
</div>