<?php
/**
 * Edit category header field.
 */

function goya_edit_category_header_img( $term, $taxonomy ) {
	$display_type	= get_term_meta( $term->term_id, 'display_type', true );
	$image 			= '';
	$header_id 	= absint( get_term_meta( $term->term_id, 'header_id', true ) );
	$shop_menu_color_cat 	= get_term_meta( $term->term_id, 'shop_menu_color_cat', true );
	if ($header_id) {
		$image = wp_get_attachment_image_url( $header_id, 'medium' );
	} else {
		$image = wc_placeholder_img_src();
	}

	?>
	<tr class="form-field">
		<th scope="row"><h2><?php esc_html_e( 'Goya Settings', 'goya' ); ?></h2></th>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Hero Banner', 'goya' ); ?></label></th>
		<td>
			<div id="product_cat_header"><img src="<?php echo esc_url($image); ?>" /></div>
			<div>
				<input type="hidden" id="wc_placeholder_img_src" name="wc_placeholder_img_src" value="<?php echo esc_url(wc_placeholder_img_src()); ?>" />
				<input type="hidden" id="product_cat_header_id" name="product_cat_header_id" value="<?php echo esc_attr($header_id); ?>" />
				<button type="submit" class="et_upload_header button"><?php esc_html_e( 'Upload/Add image', 'goya' ); ?></button>
				<button type="submit" class="et_remove_header button"><?php esc_html_e( 'Remove image', 'goya' ); ?></button>
			</div>

			<div class="clear"></div>
			<p class="description"><?php esc_html_e( 'Used when the hero title is enabled for all product archives in Appearance > Customize > Shop > Products Catalog > Shop Hero Title', 'goya' ); ?></p>

		</td>

	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Hero Text Color', 'goya' ); ?></label></th>
		<td>
			<select id="shop_menu_color_cat" name="shop_menu_color_cat" class="postform">
				<option value="" <?php selected( '', $shop_menu_color_cat ); ?>><?php esc_html_e( 'Default', 'woocommerce' ); ?></option>
				<option value="dark-title" <?php selected( 'dark-title', $shop_menu_color_cat ); ?>><?php esc_html_e( 'Dark Text', 'woocommerce' ); ?></option>
				<option value="light-title" <?php selected( 'light-title', $shop_menu_color_cat ); ?>><?php esc_html_e( 'Light Text', 'woocommerce' ); ?></option>
			</select>
			<p class="description"><?php esc_html_e( '"Default" is the global value set in the customizer.', 'goya' ); ?></p>
		</td>
	</tr>
	<?php

}

add_action( 'product_cat_edit_form_fields', 'goya_edit_category_header_img', 20, 2 );
add_action( 'product_tag_edit_form_fields', 'goya_edit_category_header_img', 20, 2 );
add_action( 'product_brand_edit_form_fields', 'goya_edit_category_header_img', 20, 2 );
add_action( 'category_edit_form_fields', 'goya_edit_category_header_img', 20, 2 );


if ( class_exists( 'woocommerce' ) ) {

	$attribute_taxonomies = wc_get_attribute_taxonomies();

	if ( ! empty( $attribute_taxonomies ) ) {
		foreach ( $attribute_taxonomies as $attribute ) {
			add_action( 'pa_' . $attribute->attribute_name . '_edit_form_fields', 'goya_edit_category_header_img', 20, 2 );
		}
	}
}

/**
 * woocommerce_category_header_img_save function.
 */

function goya_category_header_img_save( $term_id, $tt_id, $taxonomy ) {

	if ( isset( $_POST['product_cat_header_id'] ) )
		update_woocommerce_term_meta( $term_id, 'header_id', wp_unslash( absint( $_POST['product_cat_header_id'] ) ) );

	if ( isset( $_POST['shop_menu_color_cat'] ) )
		update_woocommerce_term_meta( $term_id, 'shop_menu_color_cat', wp_unslash($_POST['shop_menu_color_cat'] ) );
	delete_transient( 'wc_term_counts' );

}

add_action( 'created_term', 'goya_category_header_img_save', 10,3 );
add_action( 'edit_term', 'goya_category_header_img_save', 10,3 );

/**
 * Header column added to category admin.
 */

function goya_woocommerce_product_cat_header_columns( $columns ) {

	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = esc_html__( 'Image', 'goya' );
	$new_columns['header'] = esc_html__( 'Header', 'goya' );
	unset( $columns['cb'] );
	unset( $columns['thumb'] );

	return array_merge( $new_columns, $columns );

}

add_filter( 'manage_edit-product_cat_columns', 'goya_woocommerce_product_cat_header_columns' );


/**
 * Thumbnail column value added to category admin.
 */

function goya_woocommerce_product_cat_header_column( $columns, $column, $id ) {

	if ( $column == 'header' ) {

		$image 			= '';
		$thumbnail_id 	= get_term_meta( $id, 'header_id', true );
		$thumb_size = 48;

		if ($thumbnail_id)
			$image = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
		else
			$image = wc_placeholder_img_src();

		$columns .= '<img src="' . esc_url($image) . '" alt="Thumbnail" class="wp-post-image" height="' . $thumb_size . '" width="' . $thumb_size . '" />';

	}

	return $columns;

}

add_filter( 'manage_product_cat_custom_column', 'goya_woocommerce_product_cat_header_column', 10, 3 );
