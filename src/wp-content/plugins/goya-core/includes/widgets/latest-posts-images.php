<?php
/**
 *	Goya Widget: Latest Posts with Images
 */

class Goya_Widget_Latest_Images extends WP_Widget {

	/**
	 * Constructor
	 */

	function __construct() {
		$widget_ops = array(
			'classname'   => 'et_widget et_widget_latestimages',
			'description' => __('Display latest posts with images', 'goya-core' )
		);
		
		parent::__construct(
			'et_latestimages_widget',
			__( 'Goya - Latest Posts with Images' , 'goya-core' ),
			$widget_ops
		);
				
		$this->defaults = array( 'title' => 'Latest Posts', 'show' => '3' );
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
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$show = $instance['show'];
		
		$args = array(
			'post_type'=>'post', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'no_found_rows' => true,
			'showposts' => $show
		);
		$posts = new WP_Query( $args );
		
		echo $before_widget;
		echo ($title ? $before_title . $title . $after_title : '');
		echo '<ul>';
		$i = 1;
		while  ($posts->have_posts()) : $posts->the_post();
			?>
				<li <?php post_class('post listing'); ?>>
					<a href="<?php the_permalink() ?>" class="post-gallery">
						<span class="count"><?php echo esc_html($i); ?></span>
						<?php the_post_thumbnail(); ?>
					</a>
					<div class="listing_content">
						<div class="post-title">
							<?php the_title('<h6 class="entry-title" itemprop="name headline"><a href="'.get_permalink().'" title="'.the_title_attribute("echo=0").'">', '</a></h6>'); ?>
						</div>
						<aside class="post-meta">
							<?php echo get_the_date(); ?>
						</aside>
					</div>
				</li>
			<?php
			$i++;
		endwhile;
		echo '</ul>';
		echo $after_widget;
		
		wp_reset_query();
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show'] = strip_tags( $new_instance['show'] );
		
		return $instance;
	}
	
	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 */

	function form($instance) {
		$defaults = $this->defaults;
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Widget Title:', 'goya-core' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'name' )); ?>"><?php esc_html_e('Number of Posts:', 'goya-core' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'name' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show' )); ?>" value="<?php echo esc_attr($instance['show']); ?>" class="widefat" type="text" />
		</p>
	<?php
	}
}
