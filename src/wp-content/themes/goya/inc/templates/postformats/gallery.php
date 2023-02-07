<?php if ( rwmb_meta( 'goya_post_featured_gallery') !== '' ) {

	$gallery = rwmb_meta( 'goya_post_featured_gallery', array( 'size' => 'full' ) );
	
?>
<div class="et-banner-slider slick slick-slider post-featured-section post-featured-gallery slick-dotted slick-dots-inside slick-dots-centered" data-pagination="true" data-navigation="true" data-columns="1" data-autoplay="false" data-infinite="true">
	<?php foreach ( $gallery as $gallery_image ) { ?>
		<figure class="et-banner image-type-fluid">
			<div class="et-banner-image vh-height">
				<img src="<?php echo esc_attr($gallery_image['url']); ?>" alt="<?php echo esc_attr($gallery_image['caption']); ?>">
			</div>
			<?php if ($gallery_image['caption']) { ?>
			<div class="et-banner-content">
				<div class="et-banner-text h_left v_bottom align_left">
					<div class="et-banner-text-inner" >
						<h4 class="et-banner-title"><?php echo esc_attr($gallery_image['caption']); ?></h4>
					</div>
				</div>
			</div>
		<?php } ?>
	</figure>
	<?php } ?>
</div>

<?php } ?>