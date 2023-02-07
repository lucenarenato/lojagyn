<?php
/**
 * The template for displaying the post tags
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goya
 */
?>

<div class="article-tags">
	<?php
	$tag_list = get_the_tag_list( '', ', ' );

	if ( $tag_list ) {
		echo esc_html__( 'Tags:', 'goya' ) . '&nbsp;' . $tag_list . '';
	} ?>
</div>