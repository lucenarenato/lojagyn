<?php
/**
 * Template part for displaying the campaign bar
 *
 * @package Goya
 */

$cookie = isset($_COOKIE['et-global-campaign']) ? wp_unslash($_COOKIE['et-global-campaign']) : false;
$dismissible = (goya_meta_config('','campaign_bar_dismissible',true) == true) ? 'dismissible' : '';

$campaigns = apply_filters('goya_campaign_bar_items', get_theme_mod( 'campaign_bar_items', array() ) );
$layout = get_theme_mod( 'campaign_layout', 'slider' );
$link_mode = get_theme_mod( 'campaign_links_mode', 'button' );
$autoplay_speed = get_theme_mod( 'campaign_autoplay_speed', 2500 );
$fade = ( get_theme_mod( 'campaign_slider_transition', 'slide' ) == 'fade' ) ? 'true' : 'false';

$attributes = apply_filters('campaign_bar_slider_attributes', array(
	'autoplay' => 'true',
	'autoplay-speed' => $autoplay_speed,
	'fade' => $fade,
));

if ( !$cookie ) {
?>
	<aside class="campaign-bar et-global-campaign">
		<div class="container">
			<?php if (sizeof($campaigns) > 1 && $layout == 'slider') { ?>
				<div class="campaign-inner slick" <?php foreach ($attributes as $att => $value) { ?>data-<?php echo esc_attr($att); ?>="<?php echo esc_attr($value); ?>" <?php } ?>>
			<?php } else { ?>
				<div class="campaign-inner inline">
			<?php } ?>
				
				<?php foreach ($campaigns as $campaign) {
					$text = wp_kses( $campaign['campaign_text'], 'essentials' ); 
					$link = $campaign['campaign_link'];
					$button = $campaign['campaign_button'];
					?>

					<?php if (!empty($text)) { ?>
					<div class="et-campaign">
					<?php if(!empty($link) && $link_mode != 'button') { ?>
						<a href="<?php echo esc_url($link); ?>" class="link-<?php echo esc_attr($link_mode); ?>"><?php echo do_shortcode( __($text, 'goya' ) ); ?></a>
					<?php } else { ?>
						<?php echo do_shortcode( __($text, 'goya' ) ); ?>
						<?php if(!empty($link) && $link_mode == 'button') { ?>
							<a href="<?php echo esc_url($link); ?>" class="link-<?php echo esc_attr($link_mode); ?>"><?php echo esc_html($button); ?></a>
						<?php } ?>
					<?php } ?>
					</div>
					<?php } ?>
				<?php } ?>

				<?php 
				if (sizeof($campaigns) < 1) {
					echo do_shortcode( wp_kses( get_theme_mod('campaign_bar_content', ''), 'essentials' ) );	
				}
				 ?>
			</div>
			<a href="#" class="et-close <?php echo esc_attr( $dismissible ); ?>" title="<?php esc_attr_e('Close', 'goya'); ?>"></a>
		</div>
	</aside>
<?php } ?>