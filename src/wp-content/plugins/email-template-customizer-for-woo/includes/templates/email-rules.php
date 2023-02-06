<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$currency       = get_woocommerce_currency_symbol( get_woocommerce_currency() );
$currency_label = esc_html__( 'Subtotal', 'viwec-email-template-customizer' ) . " ({$currency})";

?>
<div>
    <div class="viwec-setting-row" data-attr="country">
        <label><?php esc_html_e( 'Apply to billing countries', 'viwec-email-template-customizer' ) ?></label>
		<?php viwec_get_pro_version() ?>
    </div>

    <div class="viwec-setting-row" data-attr="category">
        <label><?php esc_html_e( 'Apply to categories', 'viwec-email-template-customizer' ) ?></label>
		<?php viwec_get_pro_version() ?>

    </div>

    <div class="viwec-setting-row" data-attr="min_order">
        <label><?php esc_html_e( 'Apply to min order', 'viwec-email-template-customizer' ) ?></label>
		<?php viwec_get_pro_version() ?>

    </div>

    <div class="viwec-setting-row" data-attr="max_order">
        <label><?php esc_html_e( 'Apply to max order', 'viwec-email-template-customizer' ) ?></label>
		<?php viwec_get_pro_version() ?>
    </div>
</div>
