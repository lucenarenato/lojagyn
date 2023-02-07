<?php
/**
 * Template file for displaying default header
 *
 * @package Goya
 */
?>

<header id="header" class="<?php echo esc_attr( implode( ' ', (array) apply_filters( 'goya_header_class', array() ) ) ); ?>">

	<?php do_action( 'goya_header_inner' ); ?>

</header>