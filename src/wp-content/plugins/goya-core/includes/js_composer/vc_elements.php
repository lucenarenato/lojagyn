<?php

$goya_animation_array = array(
	'type' => 'dropdown',
	'heading' => esc_html__('Animation', 'goya-core'),
	'param_name' => 'animation',
	'value' => array(
		'None' => '',
		'Right to Left' => 'animation right-to-left',
		'Left to Right' => 'animation left-to-right',
		'Right to Left - 3D' => 'animation right-to-left-3d',
		'Left to Right - 3D' => 'animation left-to-right-3d',
		'Bottom to Top' => 'animation bottom-to-top',
		'Top to Bottom' => 'animation top-to-bottom',
		'Bottom to Top - 3D' => 'animation bottom-to-top-3d',
		'Top to Bottom - 3D' => 'animation top-to-bottom-3d',
		'Scale' => 'animation scale',
		'Fade' => 'animation fade-in'
	)
);

// Remove WordPress default Widgets (Appearance > Widgets)
if ( ! get_theme_mod('js_composer_standalone', false) == true ) {
	vc_remove_element( 'vc_wp_search' );
	vc_remove_element( 'vc_wp_meta' );
	vc_remove_element( 'vc_wp_recentcomments' );
	vc_remove_element( 'vc_wp_calendar' );
	vc_remove_element( 'vc_wp_pages' );
	vc_remove_element( 'vc_wp_tagcloud' );
	vc_remove_element( 'vc_wp_custommenu' );
	vc_remove_element( 'vc_wp_text' );
	vc_remove_element( 'vc_wp_posts' );
	vc_remove_element( 'vc_wp_categories' );
	vc_remove_element( 'vc_wp_archives' );
	vc_remove_element( 'vc_wp_rss' );
}
// Other elements
vc_remove_element( 'vc_carousel' );
vc_remove_element( 'vc_masonry_grid' );


// Element: vc_row
vc_remove_param( 'vc_row', 'full_width' );
vc_remove_param( 'vc_row', 'gap' );
vc_remove_param( 'vc_row', 'css_animation' );

vc_add_param('vc_row', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Enable Full Width', 'goya-core'),
	'param_name' => 'et_full_width',
	'value' => array(
		'Yes' => 'true'
	),
	'weight' => 1,
	'description' => esc_html__('If you enable this, this row will fill the screen', 'goya-core')
));
vc_add_param('vc_row', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Disable Padding', 'goya-core'),
	'param_name' => 'et_row_padding',
	'value' => array(
		'Yes' => 'true'
	),
	'weight' => 1,
	'description' => esc_html__('If you enable this, this row won\'t leave padding on the sides', 'goya-core')
));
vc_add_param('vc_row', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Column Alignment', 'goya-core'),
	'param_name' => 'et_column_align',
	'value' => array(
		'Default' => '',
		'Center' => 'align-center',
		'Right' => 'align-right'
	),
	'weight' => 1,
	'description' => esc_html__('Aligment for the columns inside this row.', 'goya-core')
));


// Element: vc_row_inner
vc_remove_param( 'vc_row_inner', 'gap' );

vc_add_param('vc_row_inner', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Enable Max Width', 'goya-core'),
	'param_name' => 'et_max_width',
	'value' => array(
		'Yes' => 'max_width'
	),
	'std' => 'max_width',
	'weight' => 1,
	'description' => esc_html__('If you enable this, the row won\'t exceed the max width, especially inside a full-width parent row.', 'goya-core')
));

vc_add_param('vc_row_inner', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Column Alignment', 'goya-core'),
	'param_name' => 'et_column_align',
	'value' => array(
		'Default' => '',
		'Center' => 'align-center',
		'Right' => 'align-right'
	),
	'weight' => 1,
	'description' => esc_html__('Aligment for the columns inside this row.', 'goya-core')
));

vc_add_param('vc_row_inner', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Disable Padding', 'goya-core'),
	'param_name' => 'et_row_padding',
	'value' => array(
		'Yes' => 'true'
	),
	'weight' => 1,
	'description' => esc_html__('If you enable this, the columns inside won\'t leave padding on the sides', 'goya-core')
));


// Element: vc_column
vc_remove_param( 'vc_column', 'css_animation' );
vc_add_param('vc_column', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Column Content Color', 'goya-core'),
	'param_name' => 'et_column_color',
	'value' => array(
		'Dark' => 'et-dark-column',
		'Light' => 'et-light-column'
	),
	'std' => 'et-dark-column',
	'weight' => 1,
	'description' => esc_html__('If you white-colored contents for this column, select Light.', 'goya-core')
));
vc_add_param('vc_column', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Overlap column', 'goya-core'),
	'param_name' => 'et_column_overlap',
	'value' => array(
		'None' => '',
		'Overlap Right' => 'overlap-right',
		'Overlap Left' => 'overlap-left'
	),
	'weight' => 1,
	'description' => esc_html__('Overlap adjacent columns.', 'goya-core')
));
vc_add_param('vc_column', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Make column sticky', 'goya-core'),
	'param_name' => 'fixed',
	'value' => array(
		'Yes' => 'et-fixed'
	),
	'weight' => 1,
	'description' => esc_html__('Keep the column fixed while scrolling.', 'goya-core')
));

// Element: vc_column_inner
vc_add_param('vc_column_inner', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Column Content Color', 'goya-core'),
	'param_name' => 'et_column_color',
	'value' => array(
		'Dark' => 'et-dark-column',
		'Light' => 'et-light-column'
	),
	'std' => 'et-dark-column',
	'weight' => 1,
	'description' => esc_html__('If you white-colored contents for this column, select Light.', 'goya-core')
));
vc_add_param('vc_column_inner', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Overlap column', 'goya-core'),
	'param_name' => 'et_column_overlap',
	'value' => array(
		'None' => '',
		'Overlap Right' => 'overlap-right',
		'Overlap Left' => 'overlap-left'
	),
	'weight' => 1,
	'description' => esc_html__('Overlap adjacent columns.', 'goya-core')
));
vc_add_param('vc_column_inner', array(
	'type' => 'checkbox',
	'heading' => esc_html__('Make column sticky', 'goya-core'),
	'param_name' => 'fixed',
	'value' => array(
		'Yes' => 'et-fixed'
	),
	'weight' => 1,
	'description' => esc_html__('Keep the column fixed while scrolling.', 'goya-core')
));
vc_add_param('vc_column', $goya_animation_array);
vc_add_param('vc_column_inner', $goya_animation_array);


vc_remove_param('vc_single_image', 'css_animation');
vc_add_param('vc_single_image', $goya_animation_array);


// Text Area
vc_remove_param('vc_column_text', 'css_animation');
vc_add_param('vc_column_text', $goya_animation_array);

// Element: vc_tta_accordion
vc_remove_param('vc_tta_accordion', 'title' );
vc_remove_param('vc_tta_accordion', 'no_fill');
vc_remove_param('vc_tta_accordion', 'no_fill_content_area');
vc_remove_param('vc_tta_accordion', 'shape');
vc_remove_param('vc_tta_accordion', 'color');
vc_remove_param('vc_tta_accordion', 'style');
vc_remove_param('vc_tta_accordion', 'spacing');
vc_remove_param('vc_tta_accordion', 'gap');
vc_remove_param('vc_tta_accordion', 'css_animation');
vc_add_param('vc_tta_accordion', $goya_animation_array);

// Element: vc_tta_tabs
vc_remove_param('vc_tta_tabs', 'title' );
vc_remove_param('vc_tta_tabs', 'no_fill');
vc_remove_param('vc_tta_tabs', 'no_fill_content_area');
vc_remove_param('vc_tta_tabs', 'shape');
vc_remove_param('vc_tta_tabs', 'color');
vc_remove_param('vc_tta_tabs', 'style');
vc_remove_param('vc_tta_tabs', 'spacing');
vc_remove_param('vc_tta_tabs', 'gap');
vc_remove_param('vc_tta_tabs', 'css_animation');
vc_add_param('vc_tta_tabs', $goya_animation_array);


// Element: vc_tour
vc_remove_param('vc_tta_tour', 'title' );
vc_remove_param('vc_tta_tour', 'no_fill');
vc_remove_param('vc_tta_accordion', 'no_fill_content_area');
vc_remove_param('vc_tta_tour', 'shape');
vc_remove_param('vc_tta_tour', 'color');
vc_remove_param('vc_tta_tour', 'style');
vc_remove_param('vc_tta_tour', 'spacing');
vc_remove_param('vc_tta_tour', 'gap');
vc_remove_param('vc_tta_tour', 'css_animation');
vc_add_param('vc_tta_tour', $goya_animation_array);

// Element: vc_toggle
vc_add_param('vc_toggle', array(
	'type' => 'dropdown',
	'heading' => esc_html__('Toggle style', 'goya-core'),
	'param_name' => 'style',
	'value' => array(
		'Default' => 'default',
		'Simple' => 'simple'
	),
	'std' => 'default',
	'weight' => 2,
));
