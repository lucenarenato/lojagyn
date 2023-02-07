<?php

/* Enqueue WordPress theme styles within Gutenberg. */

function goya_readable_color($color, $default){
	$r = hexdec(substr($color,0,2));
	$g = hexdec(substr($color,2,2));
	$b = hexdec(substr($color,4,2));

	$squared_contrast = (
		$r * $r * .299 +
		$g * $g * .587 +
		$b * $b * .114
	);

	if($squared_contrast > pow(130, 2)){
		return $default;
	}else{
		return $color;
	}
}

function goya_gutenberg_styles() {

	$body_font_color = str_replace('#', '', get_theme_mod('main_font_color', '#585858') );
	$body_readable_color = '#' . goya_readable_color($body_font_color, $default = '585858');

	// Load the theme styles within Gutenberg.
		ob_start(); ?>
	
		.edit-post-visual-editor.editor-styles-wrapper {
		 color:<?php echo esc_attr( $body_readable_color ); ?>;
		}

	<?php 
	$title_font_color = str_replace('#', '', get_theme_mod('heading_color', '#282828') );
	$title_readable_color = '#' . goya_readable_color($title_font_color, $default = '282828');
	?>
		.block-editor .editor-styles-wrapper h1,
		.block-editor .editor-styles-wrapper h2,
		.block-editor .editor-styles-wrapper h3,
		.block-editor .editor-styles-wrapper h4,
		.block-editor .editor-styles-wrapper h5,
		.block-editor .editor-styles-wrapper h6,
		.editor-post-title__block .editor-post-title__input,
		.wp-block-quote  {
			color:<?php echo esc_attr( $title_readable_color ); ?>;
		}
		.wp-block-freeform.block-library-rich-text__tinymce a {
			color:<?php echo esc_attr( $title_readable_color ); ?>;
			cursor: pointer;
		}
		.wp-block-freeform.block-library-rich-text__tinymce a:hover {
			color: <?php echo esc_attr( get_theme_mod('accent_color', '#b9a16b') ); ?>;
		}
	 
	 <?php

	 $styles = ob_get_contents();
	 if (ob_get_contents()) ob_end_clean();

	 $styles = goya_clean_custom_css($styles);

	 return $styles;
}
add_action( 'enqueue_block_editor_assets', 'goya_gutenberg_styles' );