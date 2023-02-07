<?php

$tab_links = array(
	'goya-theme' 	=> esc_attr__( 'Welcome', 'goya' ),
);
	
?>
<h2 class="nav-tab-wrapper wp-clearfix">
<?php
	foreach ( $tab_links as $link_id => $title ) {
		?>
		<a href="<?php echo esc_url("admin.php?page={$link_id}"); ?>" class="nav-tab<?php if ( $link_id === 'goya-theme') { echo ' nav-tab-active'; } ?>">
			<?php echo esc_attr($title); ?>
		</a>
		<?php
	}
?>
<a href="<?php echo esc_url('customize.php'); ?>" class="nav-tab"><?php esc_html_e( 'Theme Options', 'goya' ); ?></a>
</h2>