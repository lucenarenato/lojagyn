<?php
/**
 * Klarna Checkout page
 *
 * Overrides /checkout/form-checkout.php.
 *
 * @package klarna-checkout-for-woocommerce
 */

wc_print_notices();

$columns = 'col-lg-7';

$checkout_style = goya_meta_config('','checkout_style','free');

if ( $checkout_style == 'free' ) { ?>

	<div class="form-distr-free-bg">
		<div class="col-lg-7">
			<div></div>
		</div>
		<div class="col right-bg">
			<div></div>
		</div>
	</div>

<?php 
} else {
	$columns .= ' col-xl-8'; 
} ?>

<div class="checkout-options klarna">
	<div class="row">
		<div class="<?php echo esc_attr( $columns ); ?>">
			<div class="before-checkout">
			<?php do_action( 'woocommerce_before_checkout_form', WC()->checkout() ); ?>
			</div>
		</div>
		<?php do_action( 'goya_back_button', $context = 'checkout' ); ?>
	</div>
</div>

<?php 


// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<form name="checkout" class="checkout woocommerce-checkout">
<?php do_action( 'kco_wc_before_wrapper' ); ?>
	<div id="kco-wrapper">
		<div id="kco-order-review" class="col">
			<?php do_action( 'kco_wc_before_order_review' ); ?>
			<?php woocommerce_order_review(); ?>
			<?php do_action( 'kco_wc_after_order_review' ); ?>
		</div>

		<div id="kco-iframe" class="<?php echo esc_attr( $columns ); ?>">
			<?php do_action( 'kco_wc_before_snippet' ); ?>
			<?php kco_wc_show_snippet(); ?>
			<?php do_action( 'kco_wc_after_snippet' ); ?>
		</div>
	</div>
	<?php do_action( 'kco_wc_after_wrapper' ); ?>
</form>

<?php do_action( 'woocommerce_after_checkout_form', WC()->checkout() ); ?>
