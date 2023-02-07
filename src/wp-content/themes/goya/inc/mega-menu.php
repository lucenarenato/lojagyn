<?php

/**
* Add custom fields to menu item
*
* This will allow us to play nicely with any other plugin that is adding the same hook
*
* @param  int $item_id 
* @params obj $item - the menu item
* @params array $args
*/
function goya_custom_fields( $item_id, $item ) {

	$menu_item_megamenu = get_post_meta( $item_id, '_menu_item_megamenu', true );
	$menu_item_megamenu_columns = get_post_meta( $item_id, '_menu_item_megamenu_columns', true );
	$menu_item_menutitle = get_post_meta( $item_id, '_menu_item_menutitle', true );
	$menu_item_menulabel = get_post_meta( $item_id, '_menu_item_menulabel', true );
	$menu_item_menulabelcolor = get_post_meta( $item_id, '_menu_item_menulabelcolor', true );
	$menu_item_menuimage = get_post_meta( $item_id, '_menu_item_menuimage', true );

	?>

	<div class="et_menu_options">
		<div class="et-field-link-mega description description-thin">
		<label for="menu_item_megamenu-<?php echo esc_attr($item_id); ?>">
			<?php esc_html_e( 'Show as Mega Menu', 'goya'  ); ?><br />
		  <?php 
			  $value = $menu_item_megamenu;
			  if($value != "") $value = "checked='checked'";
		  ?>
	  	<input type="checkbox" value="enabled" id="menu_item_megamenu-<?php echo esc_attr($item_id); ?>" name="menu_item_megamenu[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr( $value ); ?> />
	  	<?php esc_html_e( 'Enable', 'goya'  ); ?>
	  </label>
	  </div>
	   <div class="et-field-link-mega description description-thin">
	  	<label for="menu_item_megamenu-columns-<?php echo esc_attr($item_id); ?>">
	  		<?php esc_html_e( 'Main menu columns', 'goya'  ); ?><br />
	  		<select class="widefat code edit-menu-item-custom" id="menu_item_megamenu_columns-<?php echo esc_attr($item_id); ?>" name="menu_item_megamenu_columns[<?php echo esc_attr($item_id); ?>]">
	  			<?php $value = $menu_item_megamenu_columns;
	  				if (!$value) {
	  					$value = 5;
	  				}
	  			for ($i = 3; $i <= 9; $i++) { ?>
	  				<option value="<?php echo esc_attr( $i ) ?>" <?php echo ($value == $i) ? "selected='selected'" : ''; ?>><?php echo esc_attr( $i ) ?></option>	
	  			<?php } ?>
	  		</select>
	  	 </label>
	    </div>
	  <div class="et-field-link-title description description-wide">
	  	<label for="menu_item_menutitle-<?php echo esc_attr($item_id); ?>">
	  		<?php esc_html_e( 'Show as Title', 'goya'  ); ?><br />
	  	  <?php 
	  		  $value = $menu_item_menutitle;
	  		  if($value != "") $value = "checked='checked'";
	  	  ?>
	  	  <input type="checkbox" value="enabled" id="menu_item_menutitle-<?php echo esc_attr($item_id); ?>" name="menu_item_menutitle[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr( $value ); ?> />
	  	  <?php esc_html_e( 'Enable', 'goya'  ); ?>
	  	</label>
	  </div>
    <div class="et-field-link-label description description-wide">
  	<label for="menu_item_menulabel-<?php echo esc_attr($item_id); ?>">
  		<?php esc_html_e( 'Highlight Label', 'goya'  ); ?> <span class="small-tag"><?php esc_html_e( 'label', 'goya'  ); ?></span><br />
  	  <input type="text" class="widefat code edit-menu-item-custom" id="menu_item_menulabel-<?php echo esc_attr($item_id); ?>" name="menu_item_menulabel[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $menu_item_menulabel ); ?>"/>
  	 </label>
    </div>
    <div class="et-field-link-labelcolor description description-wide">
    	<label for="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>">
  	  	<input type="text" class="widefat code edit-menu-item-custom et-color-field" id="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>" name="menu_item_menulabelcolor[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $menu_item_menulabelcolor ); ?>"/>
  	  </label>
    </div>
	  <div class="et-field-link-image description description-wide">
	  	
	  	<?php wp_enqueue_media(); ?>

			<label for="menu_item_menuimage-<?php echo esc_attr($item_id); ?>">
				<?php esc_html_e( 'Menu Image', 'goya'  ); ?>
				</label>

				<div class='image-preview-wrapper'>
					<?php $image_attributes = wp_get_attachment_image_src( $menu_item_menuimage, 'thumbnail' );
					if ($image_attributes != '' ) { ?>
						<img id='image-preview-<?php echo esc_attr($item_id); ?>' class="image-preview" src="<?php echo esc_attr( $image_attributes[0]); ?>" />
					<?php } ?>
				</div>
				<input id="remove_image_button-<?php echo esc_attr($item_id); ?>" type="button" class="remove_image_button button" value="<?php esc_attr_e( 'Remove', 'goya' ); ?>" style="display: none;" />
				<input id="upload_image_button-<?php echo esc_attr($item_id); ?>" type="button" class="upload_image_button button" value="<?php esc_attr_e( 'Select image', 'goya' ); ?>" />

				<input type="hidden" class="widefat code edit-menu-item-custom image_attachment_id" id="menu_item_menuimage-<?php echo esc_attr($item_id); ?>" name="menu_item_menuimage[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $menu_item_menuimage ); ?>"/>

			
		</div>
	  
  </div>

	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'goya_custom_fields', 10, 2 );


/**
* Save the menu item meta
* 
* @param int $menu_id
* @param int $menu_item_db_id	
*/
function goya_nav_update( $menu_id, $menu_item_db_id ) {

  if (!isset($_REQUEST['menu_item_megamenu'][$menu_item_db_id])) {
	  $_REQUEST['menu_item_megamenu'][$menu_item_db_id] = '';  
  }
  $menumega_enabled_value = $_REQUEST['menu_item_megamenu'][$menu_item_db_id];
  update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $menumega_enabled_value );
  
  if (isset($menumega_enabled_value) && !empty($_REQUEST['menu_item_megamenu_columns'])) {
	  $menumega_columns_enabled_value = $_REQUEST['menu_item_megamenu_columns'][$menu_item_db_id];
	  update_post_meta( $menu_item_db_id, '_menu_item_megamenu_columns', $menumega_columns_enabled_value );
  }
	
	if (!isset($_REQUEST['menu_item_menutitle'][$menu_item_db_id])) {
		$_REQUEST['menu_item_menutitle'][$menu_item_db_id] = '';
	}
	$menutitle_enabled_value = $_REQUEST['menu_item_menutitle'][$menu_item_db_id];
	update_post_meta( $menu_item_db_id, '_menu_item_menutitle', $menutitle_enabled_value );

	if (!empty($_REQUEST['menu_item_menulabel'])) {
		$menulabel_enabled_value = $_REQUEST['menu_item_menulabel'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_menulabel', $menulabel_enabled_value );
	}
	
	if (!empty($_REQUEST['menu_item_menulabelcolor'])) {
		$menulabelcolor_enabled_value = $_REQUEST['menu_item_menulabelcolor'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_menulabelcolor', $menulabelcolor_enabled_value );
	}

		if (!empty($_REQUEST['menu_item_menuimage'])) {
		$menuimage_enabled_value = $_REQUEST['menu_item_menuimage'][$menu_item_db_id];
		update_post_meta( $menu_item_db_id, '_menu_item_menuimage', $menuimage_enabled_value );
	}

}

add_action( 'wp_update_nav_menu_item', 'goya_nav_update', 10, 2 );


/**
 * Filters the CSS classes applied to a menu item's list item element.
 *
 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
 * @param WP_Post  $item    The current menu item.
 * @param stdClass $args    An object of wp_nav_menu() arguments.
 * @param int      $depth   Depth of menu item. Used for padding.
 */
function goya_custom_nav_menu_css_class( $classes, $item, $args, $depth ) {

	$item->active_megamenu = get_post_meta( $item->ID, '_menu_item_megamenu', true);

	if ($depth === 0) {
	  $mega_columns = get_post_meta( $item->ID, '_menu_item_megamenu_columns', true);
	  if ($item->active_megamenu) { 
	  	$classes[] = 'menu-item-mega-parent'; 
	  	$classes[] = 'menu-item-mega-column-' . $mega_columns;
	  }
  } else {
		$classes[] = get_post_meta( $item->ID, '_menu_item_menutitle', true) === 'enabled' ? ' title-item' : '';
  }
  if ($depth === 1 && $item->active_megamenu)  {
  	$classes[] = 'mega-menu-title';
  }
  
	return $classes;
}

add_filter( 'nav_menu_css_class', 'goya_custom_nav_menu_css_class', 10, 4 );


/**
* Displays text on the front-end.
*
* @param string   $title The menu item's title.
* @param WP_Post  $item  The current menu item.
* @return string      
*/
function goya_custom_nav_menu_item_title( $title, $item, $args, $depth ) {

	if( is_object( $item ) && isset( $item->ID ) ) {

		$item->menuimage = get_post_meta( $item->ID, '_menu_item_menuimage', true);
		$item->menulabel = get_post_meta( $item->ID, '_menu_item_menulabel', true);
		$item->menu_label_color = get_post_meta( $item->ID, '_menu_item_menulabelcolor', true);

		$menu_label_color = ($item->menu_label_color != '') ? ' style="background-color:'. $item->menu_label_color .'"' : '';
		$menu_image = wp_get_attachment_image( $item->menuimage, 'medium_large' );

		$original_title = $title;

		$title = ($item->menuimage != '') ? '<span class="item-thumb">' . $menu_image . '</span><span class="item-caption">' : '';

		$title .= $original_title;
		$title .= ($item->menulabel != '') ? '<span class="menu-label"'. $menu_label_color .'>'. $item->menulabel .'</span>' : '';

		$title .= ($item->menuimage != '') ? '</span>' : '';

	}

	return $title;
}

add_filter( 'nav_menu_item_title', 'goya_custom_nav_menu_item_title', 10, 4 );

