<?php
/**
 * WC Ajax Active Filters
 */
if (!class_exists('WCAPF_Active_Filters_Widget')) {
	class WCAPF_Active_Filters_Widget extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wcapf-active-filters', // Base ID
				__('WC Ajax Active Filters', 'wcapf'), // Name
				array('description' => __('Shows active filters so users can see and deactivate them.', 'wcapf')) // Args
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget($args, $instance) {

			global $wp_query;

			if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
				return;
			}
			
			// enqueue necessary scripts
			wp_enqueue_style('wcapf-style');
			wp_enqueue_script('wcapf-script');
			
			global $wcapf;
			$active_filters = $wcapf->getChosenFilters();
			$active_filters = $active_filters['active_filters'];
			$found = false;
			$html = '';

			if (sizeof($active_filters) > 0) {
				$found = true;
				$html .= '<div class="wcapf-active-filters">';

					foreach ($active_filters as $key => $active_filter) {
						if ($key === 'term') {
							foreach ($active_filter as $data_key => $terms) {
								foreach ($terms as $term_id => $term_name) {
									$html .= '<a href="javascript:void(0)" data-key="' . $data_key . '" data-value="' . $term_id . '">' . $term_name . '</a>';
								}
							}
						}

						if (!empty($active_filter)) {

							if ($key === 'keyword') {
								$html .= '<a href="javascript:void(0)" data-key="keyword">' . apply_filters( 'wcapf_search_for_text',  esc_html__('Search For:', 'wcapf' ) ) . ' ' . $active_filter . '</a>';
							}

							if ($key === 'orderby') {
								
								$orderby_names = apply_filters('wcapf_order_by_values', array(
										'popularity' => esc_html__( 'popularity', 'wcapf' ),
										'rating'     => esc_html__( 'rating', 'wcapf' ),
										'date'       => esc_html__( 'latest', 'wcapf' ),
										'price'      => esc_html__( 'price low to high', 'wcapf' ),
										'price-desc' => esc_html__( 'price high to low', 'wcapf' ),
									)
								);
								if (!empty($orderby_names[$active_filter])) {
									$active_filter = $orderby_names[$active_filter];
								}

								$html .= '<a href="javascript:void(0)" data-key="orderby">' . apply_filters( 'wcapf_order_by_text',  esc_html__('Order by:', 'wcapf' ) ) . ' ' . $active_filter . '</a>';
							}

							if ($key === 'min_price') {
								$html .= '<a href="javascript:void(0)" data-key="min-price">' . apply_filters( 'wcapf_min_price_text',  esc_html__('Min Price:', 'wcapf' ) ) . ' ' . $active_filter . '</a>';
							}

							if ($key === 'max_price') {
								$html .= '<a href="javascript:void(0)" data-key="max-price">' . apply_filters( 'wcapf_max_price_text',  esc_html__('Max Price:', 'wcapf' ) ) . ' ' . $active_filter . '</a>';
							}

						}

					}

					if (!empty($instance['button_text'])) {
						if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
							$link = home_url();
						} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
							$link = get_post_type_archive_link( 'product' );
						} else {
							$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
						}

						/**
						 * Search Arg.
						 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
						 */
						if ( get_search_query() ) {
							$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
						}

						// Post Type Arg
						if ( isset( $_GET['post_type'] ) ) {
							$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
						}

						$link = apply_filters('wcapf_get_reset_link', $link);

						$html .= '<a href="javascript:void(0)" class="reset" data-location="' . $link . '">' . $instance['button_text'] . '</a>';
					}

				$html .= '</div>';
			}

			extract($args);

			// Add class to before_widget from within a custom widget
			// http://wordpress.stackexchange.com/questions/18942/add-class-to-before-widget-from-within-a-custom-widget

			if ($found === false) {
				$widget_class = 'wcapf-widget-hidden woocommerce wcapf-ajax-term-filter';
			} else {
				$widget_class = 'woocommerce wcapf-ajax-term-filter';
			}

			// no class found, so add it
			if (strpos($before_widget, 'class') === false) {
				$before_widget = str_replace('>', 'class="' . $widget_class . '"', $before_widget);
			}
			// class found but not the one that we need, so add it
			else {
				$before_widget = str_replace('class="', 'class="' . $widget_class . ' ', $before_widget);
			}

			echo $before_widget;

			if (!empty($instance['title'])) {
				echo $args['before_title'] . apply_filters('widget_title', $instance['title']). $args['after_title'];
			}

			echo $html;

			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form($instance) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php printf(__('Title:', 'wcapf')); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo (!empty($instance['title']) ? esc_attr($instance['title']) : __( 'Active filters', 'wcapf' )); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php printf(__('Button Text:', 'wcapf')); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo (!empty($instance['button_text']) ? esc_attr($instance['button_text']) : __( 'Reset', 'wcapf' )); ?>">
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update($new_instance, $old_instance) {
			$instance = array();
			$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
			$instance['button_text'] = (!empty($new_instance['button_text'])) ? strip_tags($new_instance['button_text']) : '';
			return $instance;
		}
	}
}

// register widget
if (!function_exists('wcapf_register_active_filters_widget')) {
	function wcapf_register_active_filters_widget() {
		register_widget('WCAPF_Active_Filters_Widget');
	}
	add_action('widgets_init', 'wcapf_register_active_filters_widget');
}