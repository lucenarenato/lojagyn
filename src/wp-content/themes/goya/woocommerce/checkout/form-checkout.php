<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove social login dropdown on checkout
if ( class_exists( 'YITH_WC_Social_Login_Frontend' ) )  {
	remove_action('woocommerce_after_template_part', array( YITH_WC_Social_Login_Frontend(),'social_buttons_in_checkout') );
}

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


<div class="checkout-options">
	<div class="row">
		<div class="<?php echo esc_attr( $columns ); ?>">
			<div class="before-checkout">
			<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
			</div>
		</div>
	</div>
</div>

		
<?php 
// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>
		
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	
	<div class="row">
		
		<div class="<?php echo esc_attr( $columns ); ?> woocommerce-checkout-customer-fields">

			<div id="checkout-spacer"></div>
			<div class="et-woocommerce-NoticeGroup"></div>

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set et-inline-validation-notices" id="customer_details">
					<div class="col-1">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<div class="col-2">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

		</div>

		<div class="woocommerce-checkout-review-order-container col">

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">

				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

				<h3 class="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
				
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		</div>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
