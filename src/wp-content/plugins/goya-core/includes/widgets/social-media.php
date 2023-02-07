<?php
/**
 *	Goya Widget: Social Media Icons
 */

class Goya_Widget_Social_Media extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname'   => 'et_widget et_widget_social_media',
			'description' => __('Display social media icons', 'goya-core' )
		);

		parent::__construct(
			'et_social_media_widget',
			__( 'Social Media Icons' , 'goya-core' ),
			$widget_ops
		);

	}

	/**
	 * Widget function
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$social_icons = array(
			'facebook',
			'twitter',
			'instagram',
			'googleplus',
			'pinterest',
			'linkedin',
			'rss',
			'tumblr',
			'youtube',
			'email',
			'whatsapp',
			'vimeo',
			'behance',
			'dribbble',
			'flickr',
			'github',
			'skype',
			'snapchat',
			'wechat',
			'weibo',
			'foursquare',
			'soundcloud',
			'vk',
			'tiktok',
			'phone',
			'map-marker',
			'spotify'
		);

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$intro_text = $instance['intro_text'];

		echo $before_widget;

		// Display the widget title 
		if ( $title ) echo $before_title . $title . $after_title; ?>

		<div class="social_widget">
			<?php if ($intro_text) { ?>
				<div class="intro-text"><?php echo esc_attr( $intro_text ) ?></div>
			<?php }

			$output = '';
			foreach ($social_icons as $key) {
				if(isset($instance[$key]) && !empty($instance[$key])) {
					$output .= '<li><a href="'. esc_url( $instance[$key] ) . '" title="' . esc_attr($key) . '" target="_blank"><span class="et-icon et-'. esc_attr($key) .'"></span></a></li>';
				}
			}

			$output = apply_filters( 'social_icons_items', $output );
			
			echo '<ul class="social-icons">' . $output . '</ul>';

			?>
		</div>
		
		<?php 
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['intro_text'] = strip_tags( $new_instance['intro_text'] );

		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['whatsapp'] = strip_tags( $new_instance['whatsapp'] );
		$instance['vimeo'] = strip_tags( $new_instance['vimeo'] );
		$instance['behance'] = strip_tags( $new_instance['behance'] );
		$instance['dribbble'] = strip_tags( $new_instance['dribbble'] );
		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
		$instance['github'] = strip_tags( $new_instance['github'] );
		$instance['skype'] = strip_tags( $new_instance['skype'] );
		$instance['snapchat'] = strip_tags( $new_instance['snapchat'] );
		$instance['wechat'] = strip_tags( $new_instance['wechat'] );
		$instance['weibo'] = strip_tags( $new_instance['weibo'] );
		$instance['foursquare'] = strip_tags( $new_instance['foursquare'] );
		$instance['soundcloud'] = strip_tags( $new_instance['soundcloud'] );
		$instance['vk'] = strip_tags( $new_instance['vk'] );
		$instance['tiktok'] = strip_tags( $new_instance['tiktok'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['map-marker'] = strip_tags( $new_instance['map-marker'] );
		$instance['spotify'] = strip_tags( $new_instance['spotify'] );

		return $instance;
	}

	
	function form( $instance ) {

		$social_base = array(
			'facebook'   => esc_html__( 'Facebook', 'goya-core' ),
			'twitter'    => esc_html__( 'Twitter', 'goya-core' ),
			'instagram'  => esc_html__( 'Instagram', 'goya-core' ),
			'googleplus' => esc_html__( 'Google+', 'goya-core' ),
			'pinterest'  => esc_html__( 'Pinterest', 'goya-core' ),
			'linkedin'   => esc_html__( 'LinkedIn', 'goya-core' ),
			'rss'        => esc_html__( 'RSS', 'goya-core' ),
			'tumblr'     => esc_html__( 'Tumblr', 'goya-core' ),
			'youtube'    => esc_html__( 'Youtube', 'goya-core' ),
			'email'      => esc_html__( 'Email', 'goya-core' ),
			'whatsapp'   => esc_html__( 'Whatsapp', 'goya-core' ),
			'vimeo'      => esc_html__( 'Vimeo', 'goya-core' ),
			'behance'    => esc_html__( 'Behance', 'goya-core' ),
			'dribbble'   => esc_html__( 'Dribbble', 'goya-core' ),
			'flickr'     => esc_html__( 'Flickr', 'goya-core' ),
			'github'     => esc_html__( 'GitHub', 'goya-core' ),
			'skype'      => esc_html__( 'Skype', 'goya-core' ),
			'snapchat'   => esc_html__( 'Snapchat', 'goya-core' ),
			'wechat'     => esc_html__( 'WeChat', 'goya-core' ),
			'weibo'      => esc_html__( 'Weibo', 'goya-core' ),
			'foursquare' => esc_html__( 'Foursquare', 'goya-core' ),
			'soundcloud' => esc_html__( 'Soundcloud', 'goya-core' ),
			'vk'         => esc_html__( 'VK', 'goya-core' ),
			'tiktok'     => esc_html__( 'TikTok', 'goya-core' ),
			'phone'      => esc_html__( 'Phone', 'goya-core' ),
			'map-marker' => esc_html__( 'Map Pin', 'goya-core' ),
			'spotify'    => esc_html__( 'Spotify', 'goya-core' ),
		);

		//Set up some default widget settings.
		$defaults = array( 
			'title'      => '',
			'intro_text' => '',
			'facebook'   => '',
			'twitter'    => '',
			'instagram'  => '',
			'googleplus' => '',
			'pinterest'  => '',
			'linkedin'   => '',
			'rss'        => '',
			'tumblr'     => '',
			'youtube'    => '',
			'email'      => '',
			'whatsapp'   => '',
			'vimeo'      => '',
			'behance'    => '',
			'dribbble'   => '',
			'flickr'     => '',
			'github'     => '',
			'skype'      => '',
			'snapchat'   => '',
			'wechat'     => '',
			'weibo'      => '',
			'foursquare' => '',
			'soundcloud' => '',
			'vk'         => '',
			'tiktok'     => '',
			'phone'      => '',
			'map-marker' => '',
			'spotify'    => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget title:', 'goya-core'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php _e('Intro text', 'goya-core'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'intro_text' ); ?>" name="<?php echo $this->get_field_name( 'intro_text' ); ?>" rows="6" cols="20" class="widefat" ><?php echo $instance['intro_text']; ?></textarea>
		</p>

		<?php foreach ($social_base as $key => $value) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( $key ); ?>"><?php _e($value, 'goya-core'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" value="<?php echo $instance[$key]; ?>" class="widefat" />
			</p>
		<?php } 
	}
}
