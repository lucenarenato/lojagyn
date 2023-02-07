<?php
/**
 * Template part for displaying the top bar
 *
 * @package Goya
 */

$groups = array(
	'left'   => goya_meta_config('','top_bar_left', array( array( 'item' => 'social' )) ),
	'center'   => goya_meta_config('','top_bar_center', array() ),
	'right'   => goya_meta_config('','top_bar_right', array() ),
); ?>

<div id="top-bar" class="et-top-bar top-bar">
	<div class="container">
		<?php foreach ( $groups as $group => $items ) : ?>
			<div class="topbar-items topbar-<?php echo esc_attr( $group ); ?>">
				<?php
				foreach ( $items as $item ) {
					$item['item'] = $item['item'] ? $item['item'] : key( goya_topbar_elements_list() );
					goya_topbar_elements( $item['item'] );
				} ?>
			</div>
		<?php endforeach; ?>			
	</div>                
</div>