<?php

$has_username = true;
$has_password = false;

if (
	\Blocksy\Plugin::instance()->account_auth->has_woo_register_flow()
	&&
	'no' !== get_option('woocommerce_registration_generate_username')
) {
	$has_username = false;
}

if (
	\Blocksy\Plugin::instance()->account_auth->has_woo_register_flow()
	&&
	'no' === get_option('woocommerce_registration_generate_password')
) {
	$has_password = true;
}

?>

<form name="registerform" id="registerform" action="#" method="post" novalidate="novalidate">
	<?php do_action('woocommerce_register_form_start') ?>
	<?php do_action('blocksy:account:modal:register:start'); ?>

	<?php if ($has_username) { ?>
		<p>
			<label for="user_login_register"><?php echo __('Username', 'blocksy-companion') ?></label>
			<input type="text" name="user_login" id="user_login_register" class="input" value="" size="20" autocapitalize="off">
		</p>
	<?php } ?>

	<p>
		<label for="user_email"><?php echo __('Email', 'blocksy-companion') ?></label>
		<input type="email" name="user_email" id="user_email" class="input" value="" size="25">
	</p>

	<?php if ($has_password) { ?>
		<p>
			<label for="user_pass_register"><?php echo __('Password', 'blocksy-companion') ?></label>
			<input type="password" name="user_pass" id="user_pass_register" class="input" value="" size="20" autocapitalize="off" autocomplete="new-password">
		</p>
	<?php } ?>

	<?php
		if (blc_fs()->can_use_premium_code()) {
			if (class_exists('NextendSocialLogin')) {
				\NextendSocialLogin::addRegisterFormButtons();
			}
		}

		do_action('register_form')
	?>

	<p id="reg_passmail">
		<?php echo __('Registration confirmation will be emailed to you', 'blocksy-companion') ?>
	</p>

	<p>
		<button name="wp-submit" class="ct-button">
			<?php echo __('Register', 'blocksy-companion') ?>

			<svg width="23" height="23" viewBox="0 0 40 40">
				<path opacity=".2" fill="currentColor" d="M20.201 5.169c-8.254 0-14.946 6.692-14.946 14.946 0 8.255 6.692 14.946 14.946 14.946s14.946-6.691 14.946-14.946c-.001-8.254-6.692-14.946-14.946-14.946zm0 26.58c-6.425 0-11.634-5.208-11.634-11.634 0-6.425 5.209-11.634 11.634-11.634 6.425 0 11.633 5.209 11.633 11.634 0 6.426-5.208 11.634-11.633 11.634z"/>

				<path fill="currentColor" d="m26.013 10.047 1.654-2.866a14.855 14.855 0 0 0-7.466-2.012v3.312c2.119 0 4.1.576 5.812 1.566z">
					<animateTransform attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="1s" repeatCount="indefinite"/>
				</path>
			</svg>
		</button>

		<!-- <input type="hidden" name="redirect_to" value="<?php echo blocksy_current_url() ?>"> -->
	</p>

	<?php do_action('blocksy:account:modal:register:end'); ?>
	<?php do_action('woocommerce_register_form_end') ?>
	<?php wp_nonce_field('blocksy-register', 'blocksy-register-nonce'); ?>
</form>

