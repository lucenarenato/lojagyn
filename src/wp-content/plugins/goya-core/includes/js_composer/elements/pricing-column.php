<?php
	
// VC element: et_pricing_table

vc_map( array(
	'name' => esc_html__('Pricing Table Column', 'goya-core' ),
  'description' => esc_html__('Add a pricing table column', 'goya-core' ),
  'category' => esc_html__('Goya', 'goya-core'),
	'base' => 'et_pricing_column',
	'icon' => 'et_pricing_column',
	'as_child' => array('only' => 'et_pricing_table'),
	'params'	=> array(
		array(
			'type' => 'checkbox',
			'heading' => esc_html__('Highlight this column?', 'goya-core' ),
			'param_name' => 'highlight',
			'value' => array(
				__( 'Yes', 'goya-core' )	=> 'true'
			),
			'description' => esc_html__('If enabled, this column will be hightlighted. See the Styling tab.', 'goya-core' ),
		),
		array(
      'type'      => 'dropdown',
      'heading'     => __('Icon Type', 'goya-core' ),
      'param_name'  => 'icon_type',
      'description' => __( 'Select icon type.', 'goya-core' ),
      'value'     => array(
        __( 'Font Icon', 'goya-core' ) => 'icon',
        __( 'Image', 'goya-core' )   => 'image_id'
      ),
      'std'       => 'icon',
      'dependency' => array(
        'element' => 'style',
        'value'   => array( 'counter-top','counter-bottom' )),
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Icon library', 'goya-core' ),
      'value' => array(
        __( 'Pixeden 7 Stroke', 'goya-core' ) => 'pixeden',
        __( 'Font Awesome', 'goya-core' ) => 'fontawesome',
      ),
      'admin_label' => true,
      'param_name' => 'icon_library',
      'description' => __( 'Select icon library.', 'goya-core' ),
      'std' => 'pixeden',
      'dependency'  => array(
        'element' => 'icon_type',
        'value'   => 'icon'
      )
    ),
    array(
      'type'      => 'iconpicker',
      'heading'     => __( 'Icon', 'goya-core' ),
      'param_name'  => 'icon_pixeden',
      'description'   => __( 'Select icon from library.', 'goya-core' ),
      'value'     => 'pe-7s-close',
      'settings'    => array(
        'type'      => 'pixeden',
        'emptyIcon'   => false,
        'iconsPerPage'  => 3000
      ),
      'dependency'  => array(
        'element' => 'icon_library',
        'value'   => 'pixeden'
      )
    ),
    array(
      'type' => 'iconpicker',
      'heading' => __( 'Icon', 'goya-core' ),
      'param_name' => 'icon_fontawesome',
      'value' => 'fa fa-adjust',
      'settings' => array(
        'emptyIcon' => false,
        'iconsPerPage' => 4000,
      ),
      'dependency' => array(
        'element' => 'icon_library',
        'value' => 'fontawesome',
      ),
      'description' => __( 'Select icon from library.', 'goya-core' ),
    ),
    array(
      'type'      => 'attach_image',
      'heading'     => __( 'Image', 'goya-core' ),
      'param_name'  => 'image_id',
      'description' => __( 'Select image from the media library.', 'goya-core' ),
      'dependency'  => array(
        'element' => 'icon_type',
        'value'   => array( 'image_id' )
      )
    ),
		array(
			'type'           => 'textfield',
			'heading'        => esc_html__( 'Title', 'goya-core' ),
			'param_name'     => 'title',
			'admin_label'	 => true,
			'description'    => esc_html__( 'Title of this pricing column', 'goya-core' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => esc_html__( 'Price', 'goya-core' ),
			'param_name'     => 'price',
			'description'    => esc_html__( 'Price of this pricing column.', 'goya-core' ),
		),
		array(
			'type'           => 'textfield',
			'heading'        => esc_html__( 'Sub Title', 'goya-core' ),
			'param_name'     => 'sub_title',
			'description'    => esc_html__( 'Some information under the price.', 'goya-core' ),
		),
		array(
			'type'           => 'textarea_html',
			'heading'        => esc_html__( 'Description', 'goya-core' ),
			'param_name'     => 'content',
			'description'    => esc_html__( 'Include a small description for this box, this text area supports HTML too.', 'goya-core' ),
		),
		array(
			'type'           => 'vc_link',
			'heading'        => esc_html__( 'Pricing CTA Button', 'goya-core' ),
			'param_name'     => 'link',
			'description'    => esc_html__( 'Button at the end of the pricing table.', 'goya-core' ),
		),
    array(
      'type'      => 'dropdown',
      'heading'     => __( 'Animation', 'goya-core' ),
      'param_name'  => 'animation',
      'value'     => array(
        __( 'None', 'goya-core' )               => '',
        __( 'Right to Left', 'goya-core' )      => 'animation right-to-left',
        __( 'Left to Right', 'goya-core' )      => 'animation left-to-right',
        __( 'Right to Left - 3D', 'goya-core' ) => 'animation right-to-left-3d',
        __( 'Left to Right - 3D', 'goya-core' ) => 'animation left-to-right-3d',
        __( 'Bottom to Top', 'goya-core' )      => 'animation bottom-to-top',
        __( 'Top to Bottom', 'goya-core' )      => 'animation top-to-bottom',
        __( 'Bottom to Top - 3D', 'goya-core' ) => 'animation bottom-to-top-3d',
        __( 'Top to Bottom - 3D', 'goya-core' ) => 'animation top-to-bottom-3d',
        __( 'Scale', 'goya-core' )              => 'animation scale',
        __( 'Fade', 'goya-core' )               => 'animation fade',
      ),
      'std'       => 'animation bottom-to-top'
    ),
		array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Background Color', 'goya-core' ),
      'param_name'     => 'background_color',
      'group' => __( 'Styling','goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
		array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Price Color', 'goya-core' ),
      'param_name'     => 'price_color',
      'group' => __( 'Styling','goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
    array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Icon Color', 'goya-core' ),
      'param_name'     => 'icon_color',
      'group' => __( 'Styling','goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
    array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Title Color', 'goya-core' ),
      'param_name'     => 'title_color',
      'group' => __( 'Styling','goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
    array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Button Color', 'goya-core' ),
      'param_name'     => 'button_color',
      'group' => __( 'Styling','goya-core' ),
      'dependency' => array(
        'element' => 'highlight',
        'value'   => array( 'true' )),
    ),
	),
	
) );

// Extend element with the WPBakeryShortCode class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_ET_Pricing_Column extends WPBakeryShortCode {}
}