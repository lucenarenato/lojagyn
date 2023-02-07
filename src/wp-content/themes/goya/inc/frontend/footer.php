<?php

/* Footer Build
---------------------------------------------------------- */

function goya_footer_build() {

	$portfolio_footer = is_singular('portfolio') ? get_theme_mod('portfolio_footer', false) : true;
	$post_footer = is_singular('post') ? get_theme_mod('post_footer', true) : true;
	$page_footer = get_post_meta(get_queried_object_id(), 'goya_page_disable_footer', true);

	$display_footer = ( $portfolio_footer && $post_footer && !$page_footer ) ? true : false;

	$checkout_style = goya_meta_config('','checkout_style','free');

	if ( $display_footer ) { ?>

	<footer id="colophon" class="footer site-footer <?php echo esc_attr( get_theme_mod('footer_widgets_mode', 'light') ); ?>">

		<?php

		$footer_middle = get_theme_mod('footer_middle_position', 'after');

		// Footer Middle: before
		if ( $footer_middle == 'before') {
			get_template_part( 'inc/templates/footer/footer', 'middle' );
		}

		// Footer Widgets
		get_template_part( 'inc/templates/footer/footer', 'widgets' );

		// Footer Middle: after
		if ( $footer_middle != 'before') {
			get_template_part( 'inc/templates/footer/footer', 'middle' );
		}
		
		// Footer bar
		get_template_part( 'inc/templates/footer/footer', 'bar' );
		?>
	</footer>

	<?php }

}

add_action( 'goya_footer', 'goya_footer_build' );


/* Footer Columns
---------------------------------------------------------- */

function goya_footer_columns() {
	$columns = get_theme_mod('footer_widgets_columns', 3);
	$col_width = get_theme_mod('footer_widgets_column_width', 'equal');
	?>

	<?php if ($columns == 1) { ?>
		
		<div class="col-12">
			<?php dynamic_sidebar('footer1'); ?>
		</div>

	<?php } else if ($col_width == 'equal') {

		$columns_medium = ( intval( $columns ) < 2 ) ? '1' : '2';
		$columns_large = (intval( $columns )) ? $columns : '2';
		$columns_class = apply_filters( 'footer_widgets_columns_class', 'col-12 col-md-' . 12/$columns_medium . ' col-lg-' . 12/$columns_large );

		for ($i = 1; $i <= $columns ; $i++) { ?>

			<div class="<?php echo esc_attr($columns_class . ' footer' . $i); ?>">
				<?php dynamic_sidebar('footer' . $i); ?>
			</div>
			
		<?php } ?>
	
	<?php } else { ?>
		
		<?php if ($columns == 4) {
			if ($col_width == 'first') {
				$footX = 'footer1'; $footY = 'footer4';
			} else {
				$footX = 'footer4'; $footY = 'footer1';
			} ?>
			<div class="column-wide column-<?php echo esc_attr( $col_width ); ?> col-md-4 <?php echo esc_attr( $footX ); ?>">
				<?php dynamic_sidebar($footX); ?>
			</div>
			<div class="other-columns col">
				<div class="row">
					<div class="col-12 col-lg-4 col-md-6 footer2">
						<?php dynamic_sidebar('footer2'); ?>
					</div>
					<div class="col-12 col-lg-4 col-md-6 footer3">
						<?php dynamic_sidebar('footer3'); ?>
					</div>
					<div class="col-12 col-lg-4 col-md-6 <?php echo esc_attr( $footY ); ?>">
						<?php dynamic_sidebar($footY); ?>
					</div>
				</div>
			</div>
		<?php } else if ($columns == 3) {
			if ($col_width == 'first') {
				$footX = 'footer1'; $footY = 'footer3';
			} else {
				$footX = 'footer3'; $footY = 'footer1';
			} ?>
			<div class="column-wide column-<?php echo esc_attr( $col_width ); ?> col-md-5 <?php echo esc_attr( $footX ); ?>">
				<?php dynamic_sidebar($footX); ?>
			</div>
			<div class="other-columns col">
				<div class="row">
					<div class="col-12 col-md-6 footer2">
						<?php dynamic_sidebar('footer2'); ?>
					</div>
					<div class="col-12 col-md-6 <?php echo esc_attr( $footY ); ?>">
						<?php dynamic_sidebar($footY); ?>
					</div>
				</div>
			</div>
		<?php } else if ($columns == 2) {
			if ($col_width == 'first') {
				$footX = 'footer1'; $footY = 'footer2';
			} else {
				$footX = 'footer2'; $footY = 'footer1';
			} ?>
			<div class="column-wide column-<?php echo esc_attr( $col_width ); ?> col-md-7 <?php echo esc_attr( $footX ); ?>">
				<?php dynamic_sidebar($footX); ?>
			</div>
			<div class="other-columns col <?php echo esc_attr( $footY ); ?>">
				<?php dynamic_sidebar($footY); ?>
			</div>
		<?php } ?>

	<?php } ?>

	<?php
}
add_action( 'goya_footer_columns', 'goya_footer_columns' );


function goya_footer_elements( $item ) {
	switch ( $item ) {
		case 'copyright':
			echo '<div class="footer-bar-content copyright">' . do_shortcode( wp_kses( get_theme_mod( 'footer_bar_copyright', '' ), 'essentials' ) ). '</div>';
			break;

		case 'menu':
			get_template_part( 'inc/templates/footer/menu-footer');
			break;

		case 'social':
			echo goya_social_profiles( 'footer-social-icons' );
			break;

		case 'currency':
			do_action( 'goya_currency_switcher' );
			break;

		case 'language':
			do_action( 'goya_language_switcher' );
			break;

		case 'currency_language':
			echo '<div class="switchers">';
			do_action( 'goya_currency_switcher' );
			do_action( 'goya_language_switcher' );
			echo '</div>';
			break;

		case 'text':
			echo '<div class="footer-bar-content text-1">' . do_shortcode( wp_kses( get_theme_mod('footer_bar_custom_text', ''), 'essentials' ) ) .'</div>';
			break;

		case 'text2':
			echo '<div class="footer-bar-content text-2">' . do_shortcode( wp_kses( get_theme_mod('footer_bar_custom_text2', ''), 'essentials' ) ) .'</div>';
			break;

		default:
			do_action( 'goya_footer_main_item', $item );
			break;
	}
}


/* Back to Top
---------------------------------------------------------- */

function goya_back_to_top() { 

	if ( get_theme_mod('back_to_top_button', true) == false ) {
		return;
	}

	?>
	<a href="#" title="<?php esc_attr_e('Scroll To Top', 'goya'); ?>" id="scroll_to_top"><span class="arrow-top"><?php get_template_part('assets/img/svg/arrow-right.svg'); ?></span></a>
	<?php
}

add_action( 'wp_footer', 'goya_back_to_top' );

