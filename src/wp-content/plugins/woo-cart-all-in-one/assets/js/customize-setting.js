jQuery(document).ready(function () {
    'use strict';
    viwcaio_design_init();
    viwcaio_customize_init();
    viwcaio_sc_icon_design();
    viwcaio_sc_header_design();
    viwcaio_sc_footer_design();
});

function viwcaio_design_init() {
    jQuery('.vi-wcaio-customize-range').each(function () {
        let range_wrap = jQuery(this),
            range = jQuery(this).find('.vi-wcaio-customize-range1');
        let min = range.attr('min') || 0,
            max = range.attr('max') || 0,
            start = range.data('start');
        range.range({
            min: min,
            max: max,
            start: start,
            input: range_wrap.find('.vi-wcaio-customize-range-value'),
            onChange: function (val) {
                let setting = range_wrap.find('.vi-wcaio-customize-range-value').attr('data-customize-setting-link');
                wp.customize(setting, function (e) {
                    e.set(val);
                });
            }
        });
        range_wrap.next('.vi-wcaio-customize-range-min-max').find('.vi-wcaio-customize-range-min').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            range.range('set value', min);
            let setting = range_wrap.find('.vi-wcaio-customize-range-value').attr('data-customize-setting-link');
            wp.customize(setting, function (e) {
                e.set(min);
            });
        });
        range_wrap.next('.vi-wcaio-customize-range-min-max').find('.vi-wcaio-customize-range-max').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            range.range('set value', max);
            let setting = range_wrap.find('.vi-wcaio-customize-range-value').attr('data-customize-setting-link');
            wp.customize(setting, function (e) {
                e.set(max);
            });
        });
        range_wrap.find('.vi-wcaio-customize-range-value').on('change', function () {
            let setting = jQuery(this).attr('data-customize-setting-link'),
                val = parseInt(jQuery(this).val() || 0);
            if (val > parseInt(max)) {
                val = max
            } else if (val < parseInt(min)) {
                val = min;
            }
            range.range('set value', val);
            wp.customize(setting, function (e) {
                e.set(val);
            });
        });
    });
    jQuery('.vi-wcaio-customize-radio').each(function () {
        jQuery(this).buttonset();
        jQuery(this).find('input:radio').on('change', function () {
            let setting = jQuery(this).attr('data-customize-setting-link'),
                val = parseInt(jQuery(this).val() || 0);
            wp.customize(setting, function (e) {
                e.set(val);
            });
        });
    });
    jQuery('.vi-wcaio-customize-checkbox').each(function () {
        jQuery(this).checkbox();
        jQuery(this).on('change', function () {
            let input = jQuery(this).parent().find('input[type="hidden"]');
            if (jQuery(this).prop('checked')) {
                input.val('1');
            }else {
                input.val('');
            }
            let setting = input.attr('data-customize-setting-link');
            wp.customize(setting).set(input.val());
        });
    });
}
function viwcaio_customize_init() {
    let sc_show = [
            'vi_wcaio_design_sidebar_cart_general',
            'vi_wcaio_design_sidebar_header',
            'vi_wcaio_design_sidebar_footer',
            'vi_wcaio_design_sidebar_products',
        ],
        sc_hide = [
            'vi_wcaio_design_sidebar_cart_icon',
            'vi_wcaio_design_menu_cart',
        ];
    jQuery.each(sc_show, function (k, v) {
        wp.customize.section(v, function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded && wp.customize('woo_cart_all_in_one_params[sc_enable]').get()) {
                    wp.customize.previewer.send('vi_wcaio_sc_toggle', 'show', '');
                }
            });
        });
    });
    jQuery.each(sc_hide, function (k, v) {
        wp.customize.section(v, function (section) {
            section.expanded.bind(function (isExpanded) {
                if (isExpanded) {
                    wp.customize.previewer.send('vi_wcaio_sc_toggle', 'hide', '');
                }
            });
        });
    });
    wp.customize.previewer.bind('vi_wcaio_update_url', function (url) {
        wp.customize.previewer.previewUrl.set(url);
    });
    wp.customize.panel('vi_wcaio_design', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded) {
                let current_url = wp.customize.previewer.previewUrl.get(),
                    cart_url = vi_wcaio_preview_setting.cart_url,
                    checkout_url = vi_wcaio_preview_setting.checkout_url;
                if (current_url.indexOf(cart_url) > -1 || current_url.indexOf(checkout_url) > -1) {
                    wp.customize.previewer.send('vi_wcaio_update_url',vi_wcaio_preview_setting.shop_url);
                }
            }
        });
    });
}
function viwcaio_sc_icon_design() {
    if (jQuery('select[id="_customize-input-woo_cart_all_in_one_params[sc_icon_style]"]').val() === '4') {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_bg_color"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_color"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_border_radius"]').addClass('vi-wcaio-disabled');
    } else {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_bg_color"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_color"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_border_radius"]').removeClass('vi-wcaio-disabled');
    }
    jQuery('select[id="_customize-input-woo_cart_all_in_one_params[sc_icon_style]"]').on('change', function () {
        if (jQuery(this).val() === '4') {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_bg_color"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_color"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_border_radius"]').addClass('vi-wcaio-disabled');
        } else {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_bg_color"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_color"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_icon_count_border_radius"]').removeClass('vi-wcaio-disabled');
        }
    });
}

function viwcaio_sc_header_design() {
    if (jQuery('input:checkbox[name="woo_cart_all_in_one_params[sc_header_coupon_enable]"]').prop('checked')) {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_input_radius"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color_hover"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color_hover"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_border_radius"]').removeClass('vi-wcaio-disabled');
    } else {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_input_radius"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color_hover"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color_hover"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_border_radius"]').addClass('vi-wcaio-disabled');
    }
    jQuery('input:checkbox[name="woo_cart_all_in_one_params[sc_header_coupon_enable]"]').on('change', function () {
        if (jQuery(this).prop('checked')) {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_input_radius"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color_hover"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color_hover"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_border_radius"]').removeClass('vi-wcaio-disabled');
        } else {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_input_radius"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_bg_color_hover"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_color_hover"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_header_coupon_button_border_radius"]').addClass('vi-wcaio-disabled');
        }
    });
}

function viwcaio_sc_footer_design() {
    if (jQuery('select[id="_customize-input-woo_cart_all_in_one_params[sc_footer_button]"]').val() === 'cart') {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_cart_text"]').removeClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_checkout_text"]').addClass('vi-wcaio-disabled');
    } else {
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_cart_text"]').addClass('vi-wcaio-disabled');
        jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_checkout_text"]').removeClass('vi-wcaio-disabled');
    }
    jQuery('select[id="_customize-input-woo_cart_all_in_one_params[sc_footer_button]"]').on('change', function () {
        if (jQuery(this).val() === 'cart') {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_cart_text"]').removeClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_checkout_text"]').addClass('vi-wcaio-disabled');
        } else {
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_cart_text"]').addClass('vi-wcaio-disabled');
            jQuery('li[id="customize-control-woo_cart_all_in_one_params-sc_footer_bt_checkout_text"]').removeClass('vi-wcaio-disabled');
        }
    });
    jQuery('select[id="_customize-input-woo_cart_all_in_one_params[sc_footer_pd_plus]"] option').each(function () {
       let val = jQuery(this).val();
       if (val && jQuery.inArray(val,['best_selling','viewed_product','product_rating']) === -1){
           jQuery(this).prop('disabled', true);
       }
    });
}
