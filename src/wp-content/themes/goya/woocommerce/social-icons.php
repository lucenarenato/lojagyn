<?php
/**
 * Only icons for socials
 *
 * @package YITH WooCommerce Social Login
 * @since   1.0.0
 * @author  Yithemes
 */

foreach ( $socials as $key => $value ) {
	$enabled = get_option( 'ywsl_' . $key . '_enable' );

	if ( $enabled == 'yes' ) {

		$args = array(
			'value'     => $value,
			'url'       => esc_url( add_query_arg( array(
				'ywsl_social' => $key,
				'redirect'    => urlencode( ywsl_curPageURL() )
			), site_url( 'wp-login.php' ) ) ),
			'image_url' => GOYA_THEME_URI . '/assets/img/social/' . $key . '.png',
			'class'     => 'ywsl-social ywsl-' . $key
		);

		$caption  = sprintf( '<span class="et-icon et-'. $key .'"/></span> ' . esc_html__('Login with %s','goya'), '<span>'. $key . '</span>' );
		$button = sprintf( '<a class="%s" href="%s">%s</a>', $args['class'], $args['url'], $caption );

		echo apply_filters( 'yith_wc_social_login_icon', $button, $key, $args );

	}
}