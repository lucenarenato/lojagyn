<div class="a2w-hidden-shipping-recalc">
<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<input type="hidden" name="calc_shipping_country" id="calc_shipping_country" value="<?php echo $selected_country; ?>" />
<input type="hidden" name="calc_shipping_state" id="calc_shipping_state"  />

<input type="hidden" name="calc_shipping_city" id="calc_shipping_city"  />
<input type="hidden" name="calc_shipping_postcode" id="calc_shipping_postcode"  />

<button type="submit" name="calc_shipping" value="1" class="button"><?php _e( 'Update totals', 'woocommerce' ); ?></button>

<?php wp_nonce_field( 'woocommerce-cart' ); ?>
</form>
</div>