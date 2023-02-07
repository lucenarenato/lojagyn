<div class="et-welcome">

	<div class="wrap about-wrap et_theme_welcome">

		<?php include 'header.php'; ?>
	
		<div class="theme-browser">
			
			<?php if (class_exists('TGM_Plugin_Activation')) {

				$installer = TGM_Plugin_Activation::get_instance(); ?>

				<div class="theme post-box et-plugins">
					<?php get_template_part('assets/img/admin/welcome/settings.svg'); ?>
					<h3><?php esc_html_e('Plugins Installation', 'goya'); ?></h3>
					<?php 
					if ( $installer->is_tgmpa_complete() ) { ?>
						<p><span class="dashicons success dashicons-plugins-checked"></span> <?php esc_html_e('Plugins installed and up-to-date', 'goya'); ?></p>
					<?php } else { ?>
						<p><span class="dashicons warning dashicons-info"></span> <?php esc_html_e('Install/update required plugins', 'goya'); ?></p>
						<a href="<?php echo esc_url("admin.php?page=install-required-plugins"); ?>"  class="button button-primary"><?php esc_html_e('Install Plugins', 'goya'); ?></a>
					<?php } ?>
				</div>

				<div class="theme post-box et-demo">
					<?php get_template_part('assets/img/admin/welcome/cloud-storage.svg'); ?>
					<h3><?php esc_html_e('Demo Content', 'goya'); ?></h3>
					<p><span class="dashicons dashicons-download"></span>  <?php esc_html_e('Download and import sample content', 'goya'); ?></p>
					<p class="instructions"><small><?php esc_html_e('Import demo on a clean site. If you need to reinstall reset your site first.', 'goya'); ?></small></p>
					<?php if (class_exists('OCDI_Plugin')) { ?>
						<a href="<?php echo esc_url("admin.php?page=pt-one-click-demo-import"); ?>"  class="button"><?php esc_html_e('Demo Import', 'goya'); ?></a>
					<?php } else { ?>
						<a href="<?php echo esc_url("themes.php?page=merlin&step=content"); ?>"  class="button"><?php esc_html_e('Demo Import', 'goya'); ?></a>
					<?php } ?>
				</div>

			<?php } ?>

			<div class="theme post-box et-support">
				<?php get_template_part('assets/img/admin/welcome/customer-service.svg'); ?>
				<h3><?php esc_html_e('Help Center', 'goya'); ?></h3>
				<p><a href="https://goya.everthemes.com/help-center/installation-guide/" target="_blank"><span class="dashicons dashicons-star-filled"></span> <?php esc_html_e('Installation Guide', 'goya'); ?></a></p>
				<p><a href="https://goya.everthemes.com/help-center/" target="_blank"><span class="dashicons dashicons-admin-page"></span> <?php esc_html_e('Full Documentation', 'goya'); ?></a></p>
				<p><a href="https://support.everthemes.com/" target="_blank" class="button button-secondary"><?php esc_html_e('Get Support', 'goya'); ?></a></p>
			</div>

		</div>
	
	</div>
</div>