<?php
/**
 * HTML markup for Settings page.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}
?>
<div class="wrap">
	<h1><?php _e('WC Ajax Product Filter', 'wcapf'); ?></h1>
	<form method="post" action="options.php">
		<?php
		settings_fields('wcapf_settings');
		do_settings_sections('wcapf_settings');

		// check if filter is applied
		$settings = apply_filters('wcapf_settings', get_option('wcapf_settings'));
		?>

		<?php if (has_filter('wcapf_settings')): ?>
			<p><span class="dashicons dashicons-info"></span> <?php _e('Filter has been applied and that may modify the settings below.', 'wcapf'); ?></p>
		<?php endif ?>

		<table class="form-table">
			<tr>
				<th scope="row"><?php _e('Shop loop container', 'wcapf'); ?></th>
				<td>
					<input type="text" name="wcapf_settings[shop_loop_container]" size="50" value="<?php echo '.wcapf-before-products'; ?>" >
					<br />
					<span><?php _e('Selector for tag that is holding the shop loop. Most of cases you won\'t need to change this.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('No products container', 'wcapf'); ?></th>
				<td>
					<input type="text" name="wcapf_settings[not_found_container]" size="50" value="<?php echo '.wcapf-before-products'; ?>" >
					<br />
					<span><?php _e('Selector for tag that is holding no products found message. Most of cases you won\'t need to change this.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Pagination container', 'wcapf'); ?></th>
				<td>
					<input type="text" name="wcapf_settings[pagination_container]" size="50" value="<?php echo '.woocommerce-pagination'; ?>" >
					<br />
					<span><?php _e('Selector for tag that is holding the pagination. Most of cases you won\'t need to change this.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Overlay background color', 'wcapf'); ?></th>
				<td>
					<input type="text" name="wcapf_settings[overlay_bg_color]" size="50" value="<?php echo isset($settings['overlay_bg_color']) ? esc_attr($settings['overlay_bg_color']) : '#fff'; ?>">
					<br />
					<span><?php _e('Change this color according to your theme, eg: #fff', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Product sorting', 'wcapf'); ?></th>
				<td>
					<input type="checkbox" name="wcapf_settings[sorting_control]" value="1" <?php (!empty($settings['sorting_control'])) ? checked(1, $settings['sorting_control'], true) : 1; ?>>
					<span><?php _e('Check if you want to sort your products via ajax.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Scroll to top', 'wcapf'); ?></th>
				<td>
					<input type="checkbox" name="wcapf_settings[scroll_to_top]" value="1" <?php (!empty($settings['scroll_to_top'])) ? checked(1, $settings['scroll_to_top'], true) : 1; ?>>
					<span><?php _e('Check if to enable scroll to top after updating shop loop.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Scroll to top offset', 'wcapf'); ?></th>
				<td>
					<input type="text" name="wcapf_settings[scroll_to_top_offset]" size="50" value="<?php echo isset($settings['scroll_to_top_offset']) ? esc_attr($settings['scroll_to_top_offset']) : 150; ?>">
					<br />
					<span><?php _e('You need to change this value to match with your theme, eg: 150', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr style="display: none;">
				<th scope="row"><?php _e('Custom JavaScript after update', 'wcapf'); ?></th>
				<td>
					<textarea name="wcapf_settings[custom_scripts]" rows="5" cols="70"><?php echo ''; ?></textarea>
					<br />
					<span><?php _e('If you want to add custom scripts that would be loaded after updating shop loop, eg: alert("hello");', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Disable Transients', 'wcapf'); ?></th>
				<td>
					<input type="checkbox" name="wcapf_settings[disable_transients]" value="1" <?php (!empty($settings['disable_transients'])) ? checked(1, $settings['disable_transients'], true) : ''; ?>>
					<span><?php _e('To disable transients check this checkbox.', 'wcapf'); ?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Clear Transients', 'wcapf'); ?></th>
				<td>
					<input type="checkbox" name="wcapf_settings[clear_transients]" value="1">
					<span><?php _e('To clean transients check this checkbox and then press \'Save Changes\' button.', 'wcapf'); ?></span>
				</td>
			</tr>
		</table>
		<?php submit_button() ?>
	</form>
</div>
