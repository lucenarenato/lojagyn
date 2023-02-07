<?php function goya_shortcode_team_member( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'image' => '',
		'style' => 'default',
		'animation' => 'animation bottom-to-top',
		'name' => '',
		'position' => '',
		'facebook' => '',
		'twitter' => '',
		'pinterest' => '',
		'linkedin' => '',
		'instagram' => '',
		'vk' => ''
	), $atts ) );

	if( ! $image){
		return;
	}

	$image_url = wp_get_attachment_image_url( $image, 'large' );

	if($image_url == '') {
		$image_url = get_template_directory_uri() . '/assets/img/placeholder.png';
	}
	
	$out ='';
	ob_start();
		
	?>
  <div class="et-team-member <?php echo esc_attr( $animation ); ?>">
  	<div class="et-team-member-image <?php echo esc_attr( $style ); ?>">
	  	<figure style="background-image:url('<?php echo esc_url( $image_url ); ?>')">
		 		<div class="overlay">
					<div class="et-member-social">
						<?php if ($facebook != '') { ?>
							<a href="<?php echo esc_url($facebook); ?>" class="facebook" target="_blank"><span class="et-icon et-facebook"></span></a>
						<?php } ?>
						<?php if ($twitter != '') { ?>
							<a href="<?php echo esc_url($twitter); ?>" class="twitter" target="_blank"><span class="et-icon et-twitter"></span></a>
						<?php } ?>
						<?php if ($pinterest != '') { ?>
							<a href="<?php echo esc_url($pinterest); ?>" class="pinterest" target="_blank"><span class="et-icon et-pinterest"></span></a>
						<?php } ?>
						<?php if ($linkedin != '') { ?>
							<a href="<?php echo esc_url($linkedin); ?>" class="linkedin" target="_blank"><span class="et-icon et-linkedin"></span></a>
						<?php } ?>
						<?php if ($instagram != '') { ?>
							<a href="<?php echo esc_url($instagram); ?>" class="instagram" target="_blank"><span class="et-icon et-instagram"></span></a>
						<?php } ?>
						<?php if ($vk != '') { ?>
							<a href="<?php echo esc_url($vk); ?>" class="vk" target="_blank"><span class="et-icon et-vk"></span></a>
						<?php } ?>
					</div>
				</div>
	  	</figure>
		</div>
		<div class="et-member-information">
			<?php if ($name) { ?>
				<h5><?php echo esc_html($name); ?></h5>
			<?php } ?>
	  	<?php if ($position) { ?>
	  		<p><?php echo esc_html($position); ?></p>
	  	<?php } ?>
  	</div>
	</div>
  <?php
  $out = ob_get_clean();
  return $out;
}
add_shortcode('et_team_member', 'goya_shortcode_team_member');