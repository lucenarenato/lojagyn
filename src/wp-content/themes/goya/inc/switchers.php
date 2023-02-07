<?php

function goya_currency_switcher( $args = array() ) {

	if ( class_exists( 'WOOCS' ) ) {

	global $WOOCS;

	$args          = wp_parse_args( $args, array( 'label' => '', 'direction' => 'down' ) );
	$currencies    = $WOOCS->get_currencies();
	$currency_list = array();

	foreach ( $currencies as $key => $currency ) {
		if ( $WOOCS->current_currency == $key ) {
			array_unshift( $currency_list, sprintf(
				'<li><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s</a></li>',
				esc_attr( $currency['name'] ),
				esc_html( $currency['name'] )
			) );
		} else {
			$currency_list[] = sprintf(
				'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s</a></li>',
				esc_attr( $currency['name'] ),
				esc_html( $currency['name'] )
			);
		}
	}
	?>
	<div class="et-switcher-container et-currency">
		<span class="label"><?php echo esc_html__('Currency', 'goya');	?></span>
		<?php if ( ! empty( $args['label'] ) ) : ?>
			<span class="label"><?php echo esc_html( $args['label'] ); ?></span>
		<?php endif; ?>
		<ul class="et-header-menu">
			<li class="menu-item-has-children">
				<span class="selected"><?php echo esc_html( $currencies[ $WOOCS->current_currency ]['name'] ); ?></span>
				<ul class="sub-menu">
					<?php echo implode( "\n\t", $currency_list ); ?>
				</ul>
			</li>
		</ul>
	</div>
		
	<?php } else if (class_exists('WCML_Currency_Switcher') ) { ?>
		
		<div class="et-switcher-container et-currency">
			<span class="label"><?php echo esc_html__('Currency', 'goya');	?></span> <?php do_action('wcml_currency_switcher', array('format' => '%code%'));  ?>
		</div>

	<?php }
}
add_action( 'goya_currency_switcher', 'goya_currency_switcher' );


/* Custom Language Switcher */
function goya_language_switcher() {
	$langs = array();
	$languages = apply_filters( 'goya_languages', $langs );
	$ls_default = get_theme_mod('ls_default', array('name'));
	$ls_mobile = get_theme_mod('ls_mobile_header', array('code'));

	if (function_exists('icl_get_languages') || 
		function_exists('pll_the_languages') || 
		function_exists('weglot_get_languages_available') || 
		!empty($languages)) {
	?>
		<div class="et-switcher-container et-language">
			<span class="label"><?php echo esc_html__('Language', 'goya');	?></span>

			<?php

			if (class_exists('TRP_Translate_Press')) {

				echo do_shortcode('[language-switcher]');
	
			} else if (function_exists('weglot_get_languages_available')) {

				echo do_shortcode('[weglot_switcher]');
			
			} else if ( function_exists('icl_get_languages') 
				|| !empty($languages) 
				|| function_exists('pll_the_languages')) {

	$classes [] = 'et-header-menu';

	foreach($ls_default as $el) {
		$classes [] = 'ls-default-' . $el;	
	}
	foreach($ls_mobile as $el) {
		$classes [] = 'ls-mobile-' . $el;
	}
	
	$classes [] = 'style-' . apply_filters( 'goya_language_switcher_style', get_theme_mod('ls_default_layout', 'dropdown') );

					if (function_exists('pll_the_languages')) {
						$languages = pll_the_languages(array('raw'=>1));	
					} else if (function_exists('icl_get_languages')) {
						$languages = icl_get_languages('skip_missing=0');
		}
		?>

		<ul class="<?php echo esc_attr(implode(' ', $classes)); ?>">
			<li class="menu-item-has-children">
					
				<span class="selected"><?php
					if(1 < count($languages)){
						if (function_exists('pll_the_languages')) { // Polylang
							foreach($languages as $l){
								if ($l['current_lang']) {
								echo '<img class="ls-flag" src="'. $l['flag'] .'" alt="'.$l['name'].'"><span class="ls-code">' . $l['slug'] . '</span><span class="ls-name">' . $l['name'] . '</span>';
								}
							}
						} else { // WPML, Custom
							foreach($languages as $l){
								if ($l['active']) {
									if (!empty($l['country_flag_url'])) {
										echo '<img class="ls-flag" src="'. $l['country_flag_url'] .'" alt="'.$l['native_name'].'">';
									}
									echo '<span class="ls-code">' . $l['language_code'] . '</span><span class="ls-name">' . $l['native_name'] . '</span>';
								}
							}
						}
					}
				?></span>

				<ul class="sub-menu">
				<?php
					if(0 < count($languages)){
						foreach($languages as $l){
							if (function_exists('pll_the_languages')) {
								if (!$l['current_lang']) {
									echo '<li><a lang="'.$l['locale'].'" hreflang="'.$l['locale'].'" href="'.$l['url'].'" data-lang="'.$l['slug'].'" title="'.$l['name'].'"><img class="ls-flag" src="'. $l['flag'] .'" alt="'.$l['name'].'"><span class="ls-code">' . $l['slug'] . '</span><span class="ls-name">' . $l['name'] . '</span></a></li>';
								}
							} else {
								if (!$l['active']) {
									echo '<li><a href="'.$l['url'].'" data-lang="'.$l['language_code'].'" title="'.$l['native_name'].'" class="nturl">';
									if (!empty($l['country_flag_url'])) {
										echo '<img class="ls-flag" src="'. $l['country_flag_url'] .'" alt="'.$l['native_name'].'">';
									}
									echo '<span class="ls-code">' . $l['language_code'] . '</span><span class="ls-name">' . $l['native_name'] . '</span></a></li>';
								}
							}
						}
					} else {
						echo '<li>'.esc_html__('Add Languages', 'goya').'</li>';	
					}
				?>
				</ul>
			</li>
		</ul>

			<?php } ?>

	</div>

<?php
	}
}
add_action( 'goya_language_switcher', 'goya_language_switcher' );
