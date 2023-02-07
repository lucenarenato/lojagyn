<figure class="post-featured-section post-featured-video">
	<?php 
	$id = get_the_ID();
	$embed = get_post_meta($id , 'goya_post_featured_video', true); 

	echo apply_filters( 'goya_post_video_embed', $embed );
	?>
</figure>