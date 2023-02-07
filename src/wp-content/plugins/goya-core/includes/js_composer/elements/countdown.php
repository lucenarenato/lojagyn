<?php 

// VC element: et_countdown

vc_map(array(
  'name' => esc_html__('Countdown', 'goya-core' ),
  'base' => 'et_countdown',
  'icon' => 'et_countdown',
  'description' => esc_html__('Countdown module for your events.', 'goya-core' ),
  'category' => esc_html__('Goya', 'goya-core' ),
  'params' => array(
    array(
      'type' => 'textfield',
      'heading' => esc_html__('Upcoming Event Date', 'goya-core' ),
      'param_name' => 'date',
      'admin_label' => true,
      'value' => '12/24/2018 12:00:00',
      'description' => esc_html__('Enter the due date for Event. eg : 12/24/2018 12:00:00 => month/day/year hour:minute:second', 'goya-core' )
    ),
    array(
      'heading' => esc_html__('UTC Timezone', 'goya-core' ),
      'type' => 'dropdown',
      'param_name' => 'utc_timezone',
      'value' => array(
          '-12' => '-12',
          '-11' => '-11',
          '-10' => '-10',
          '-9' => '-9',
          '-8' => '-8',
          '-7' => '-7',
          '-6' => '-6',
          '-5' => '-5',
          '-4' => '-4',
          '-3' => '-3',
          '-2' => '-2',
          '-1' => '-1',
          '0' => '0',
          '+1' => '+1',
          '+2' => '+2',
          '+3' => '+3',
          '+4' => '+4',
          '+5' => '+5',
          '+6' => '+6',
          '+7' => '+7',
          '+8' => '+8',
          '+9' => '+9',
          '+10' => '+10',
          '+12' => '+12'
      ),

      'description'	=> sprintf( __( 'You can check your UTC Timezone in this %sinteractive map%s.', 'goya-core' ), '<a href="https://www.timeanddate.com/time/map/#!cities=1440" target="_blank">', '</a>' )
    ),
    array(
      'type'      => 'dropdown',
      'heading'     => __( 'Countdown Size', 'goya-core' ),
      'param_name'  => 'size',
      'value'     => array(
        __( 'Large', 'goya-core' )     => 'lg',
        __( 'Medium', 'goya-core' )    => 'md',
        __( 'Small', 'goya-core' )     => 'sm',
      ),
      'std'       => 'md'
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
      'std'       => 'animation bottom-to-top',
      'group' => __( 'Styling','goya-core' ),
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Countdown Color', 'goya-core' ),
      'param_name' => 'countdown_color',
      'value' => array(
        __( 'Default', 'goya-core' ) => '',
        __( 'Dark', 'goya-core' ) => 'dark',
        __( 'Light', 'goya-core' ) => 'light',
        __( 'Accent Color', 'goya-core' ) => 'accent',
        __( 'Custom', 'goya-core' ) => 'custom'
      ),
      'std' => '',
      'group' => __( 'Styling','goya-core' ),
    ),
    array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Countdown Custom Color', 'goya-core' ),
      'param_name'     => 'countdown_color_custom',
      'dependency' => array(
        'element' => 'countdown_color',
        'value' => array( 'custom' )
      ),
      'group' => __( 'Styling','goya-core' ),
    ),
    array(
      'type' => 'dropdown',
      'heading' => __( 'Caption Color', 'goya-core' ),
      'param_name' => 'caption_color',
      'value' => array(
        __( 'Default', 'goya-core' ) => '',
        __( 'Dark', 'goya-core' ) => 'dark',
        __( 'Light', 'goya-core' ) => 'light',
        __( 'Accent Color', 'goya-core' ) => 'accent',
        __( 'Custom', 'goya-core' ) => 'custom'
      ),
      'std' => '',
      'group' => __( 'Styling','goya-core' ),
    ),
    array(
      'type'           => 'colorpicker',
      'heading'        => esc_html__('Captions Custom Color', 'goya-core' ),
      'param_name'     => 'caption_color_custom',
      'dependency' => array(
        'element' => 'caption_color',
        'value' => array( 'custom' )
      ),
      'group' => __( 'Styling','goya-core' ),
    ),

  )
));
