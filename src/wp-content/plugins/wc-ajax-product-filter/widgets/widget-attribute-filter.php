<?php
/**
 * WC Ajax Product Filter by Attribute
 */
if (!class_exists('WCAPF_Attribute_Filter_Widget')) {
	class WCAPF_Attribute_Filter_Widget extends WP_Widget {
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wcapf-attribute-filter', // Base ID
				__('WC Ajax Product Filter by Attribute', 'wcapf'), // Name
				array('description' => __('Filter woocommerce products by attribute.', 'wcapf')) // Args
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
			if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
				return;
			}
			
			// enqueue necessary scripts
			wp_enqueue_style('wcapf-style');
			wp_enqueue_script('wcapf-script');
			
			if ( (empty($instance['attr_name']) && empty($instance['query_type'])) || !taxonomy_exists('pa_' . $instance['attr_name']) ) {
				return;
			}

			$enable_multiple = (!empty($instance['enable_multiple'])) ? (bool)$instance['enable_multiple'] : '';
			$show_count = (!empty($instance['show_count'])) ? (bool)$instance['show_count'] : '';
			$enable_hierarchy = (!empty($instance['hierarchical'])) ? (bool)$instance['hierarchical'] : '';
			$show_children_only = (!empty($instance['show_children_only'])) ? (bool)$instance['show_children_only'] : '';
			$display_type = (!empty($instance['display_type'])) ? $instance['display_type'] : '';

			$attribute_name = $instance['attr_name'];
			$taxonomy   = 'pa_' . $attribute_name;
			$query_type = $instance['query_type'];
			$data_key   = ($query_type === 'and') ? 'attra-' . $attribute_name : 'attro-' . $attribute_name;

			// parse url
			$url = $_SERVER['QUERY_STRING'];
			parse_str($url, $url_array);

			$attr_args = array(
				'taxonomy'           => $taxonomy,
				'data_key'           => $data_key,
				'query_type'         => $query_type,
				'enable_multiple'    => $enable_multiple,
				'show_count'         => $show_count,
				'enable_hierarchy'   => $enable_hierarchy,
				'show_children_only' => $show_children_only,
				'url_array'          => $url_array,
				'display_type'       => $display_type,
			);

			// if display type list
			if ($display_type === 'dropdown') {
				$output = wcapf_dropdown_terms($attr_args);
			} else {
				$output = wcapf_list_terms($attr_args);
			}

			$html = $output['html'];
			$found = $output['found'];

			// if display type list
			if (!empty($instance['display_type']) && $instance['display_type'] === 'list') {}

			extract($args);

			// Add class to before_widget from within a custom widget
		
			// if $selected_terms array is empty we will hide this widget totally
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
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo (!empty($instance['title']) ? esc_attr($instance['title']) : __( 'Filter by', 'wcapf' )); ?>">
			</p>
			<p>
			<?php
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if (sizeof($attribute_taxonomies) > 0) {
				?>
				<label for="<?php echo $this->get_field_id('attr_name'); ?>"><?php printf(__('Attribute', 'wcapf')); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('attr_name'); ?>" name="<?php echo $this->get_field_name('attr_name'); ?>">
					<?php
					foreach ($attribute_taxonomies as $taxonomy) {
						echo '<option value="' . $taxonomy->attribute_name . '" ' . ((!empty($instance['attr_name']) && $instance['attr_name'] === $taxonomy->attribute_name) ? 'selected="selected"' : '') . '>' . $taxonomy->attribute_label . '</option>';
					}
					?>
				</select>
				<?php
			} else {
				printf(__('No attribute found!', 'wcapf'));
			}
			?>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('display_type'); ?>"><?php printf(__('Display Type')) ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('display_type'); ?>" name="<?php echo $this->get_field_name('display_type'); ?>">
					<option value="list" <?php echo ((!empty($instance['display_type']) && $instance['display_type'] === 'list') ? 'selected="selected"' : ''); ?>><?php printf(__('List', 'wcapf')); ?></option>
					<option value="button" <?php echo ((!empty($instance['display_type']) && $instance['display_type'] === 'button') ? 'selected="selected"' : ''); ?>><?php printf(__('Button', 'wcapf')); ?></option>
					<option value="swatch" <?php echo ((!empty($instance['display_type']) && $instance['display_type'] === 'swatch') ? 'selected="selected"' : ''); ?>><?php printf(__('Swatch', 'wcapf')); ?></option>
					<option value="dropdown" <?php echo ((!empty($instance['display_type']) && $instance['display_type'] === 'dropdown') ? 'selected="selected"' : ''); ?>><?php printf(__('Dropdown', 'wcapf')); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('query_type'); ?>"><?php printf(__('Query Type')) ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('query_type'); ?>" name="<?php echo $this->get_field_name('query_type'); ?>">
					<option value="and" <?php echo ((!empty($instance['query_type']) && $instance['query_type'] === 'and') ? 'selected="selected"' : ''); ?>><?php printf(__('AND', 'wcapf')); ?></option>
					<option value="or" <?php echo ((!empty($instance['query_type']) && $instance['query_type'] === 'or') ? 'selected="selected"' : ''); ?>><?php printf(__('OR', 'wcapf')); ?></option>
				</select>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id('enable_multiple'); ?>" name="<?php echo $this->get_field_name('enable_multiple'); ?>" type="checkbox" value="1" <?php echo (!empty($instance['enable_multiple']) && $instance['enable_multiple'] == true) ? 'checked="checked"' : ''; ?>>
				<label for="<?php echo $this->get_field_id('enable_multiple'); ?>"><?php printf(__('Enable multiple filter', 'wcapf')); ?></label>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="checkbox" value="1" <?php echo (!empty($instance['show_count']) && $instance['show_count'] == true) ? 'checked="checked"' : ''; ?>>
				<label for="<?php echo $this->get_field_id('show_count'); ?>"><?php printf(__('Show count', 'wcapf')); ?></label>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>" type="checkbox" value="1" <?php echo (!empty($instance['hierarchical']) && $instance['hierarchical'] == true) ? 'checked="checked"' : ''; ?>>
				<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php printf(__('Show hierarchy', 'wcapf')); ?></label>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id('show_children_only'); ?>" name="<?php echo $this->get_field_name('show_children_only'); ?>" type="checkbox" value="1" <?php echo (!empty($instance['show_children_only']) && $instance['show_children_only'] == true) ? 'checked="checked"' : ''; ?>>
				<label for="<?php echo $this->get_field_id('show_children_only'); ?>"><?php printf(__('Only show children of the current attribute', 'wcapf')); ?></label>
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
			$instance['attr_name'] = (!empty($new_instance['attr_name'])) ? strip_tags($new_instance['attr_name']) : '';
			$instance['display_type'] = (!empty($new_instance['display_type'])) ? strip_tags($new_instance['display_type']) : '';
			$instance['query_type'] = (!empty($new_instance['query_type'])) ? strip_tags($new_instance['query_type']) : '';
			$instance['enable_multiple'] = (!empty($new_instance['enable_multiple'])) ? strip_tags($new_instance['enable_multiple']) : '';
			$instance['show_count'] = (!empty($new_instance['show_count'])) ? strip_tags($new_instance['show_count']) : '';
			$instance['hierarchical'] = (!empty($new_instance['hierarchical'])) ? strip_tags($new_instance['hierarchical']) : '';
			$instance['show_children_only'] = (!empty($new_instance['show_children_only'])) ? strip_tags($new_instance['show_children_only']) : '';
			return $instance;
		}
	}
}

// register widget
if (!function_exists('wcapf_register_attribute_filter_widget')) {
	function wcapf_register_attribute_filter_widget() {
		register_widget('WCAPF_Attribute_Filter_Widget');
	}
	add_action('widgets_init', 'wcapf_register_attribute_filter_widget');
}