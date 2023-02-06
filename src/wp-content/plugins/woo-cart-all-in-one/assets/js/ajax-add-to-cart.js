var viwcaio_atc = [];
jQuery(document).ready(function () {
    'use strict';
    if (typeof viwcaio_ajax_atc_params==='undefined'){
        return false;
    }
    if ( viwcaio_ajax_atc_params.ajax_atc == 1) {
        jQuery(document).on('click', 'form:not(.woocommerce-boost-sales-cart-form) .single_add_to_cart_button:not(.vicatna-single-atc-button):not(.vi-wcaio-product-bt-atc-loading)', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let button = jQuery(this), form = jQuery(this).closest('form.cart');
            button.addClass('vi-wcaio-product-bt-atc-loading');
            if (button.hasClass('disabled')) {
                button.removeClass('vi-wcaio-product-bt-atc-loading');
                return false;
            }
            if (form.hasClass('.variations_form')) {
                let variation_id_check = parseInt(form.find('input[name=variation_id]').val());
                if (!variation_id_check || variation_id_check <= 0) {
                    button.removeClass('vi-wcaio-product-bt-atc-loading');
                    return false;
                }
            }
            let product_id = form.find('input[name=product_id]').val();
            if (!product_id){
                product_id = form.find('[name=add-to-cart]').val()
            }
            if (!product_id || viwcaio_ajax_atc_params.ajax_atc_pd_exclude.indexOf(product_id) !== -1 || form.find('[name="woopb-add-to-cart"]').length) {
                button.attr('type', 'submit').trigger('click');
                return false;
            }
            let data = form.find('select, input').serialize();
            if (data.search('add-to-cart') === -1) {
                data += '&add-to-cart=' + form.find('[name=add-to-cart]').val();
            }
            viwcaio_atc.push({
                type: 'post',
                url: viwcaio_ajax_atc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_add_to_cart'),
                data: data,
                beforeSend: function (response) {
                    button.removeClass('added').addClass('loading');
                },
                success: function (response) {
                    if (response.error) {
                        location.href = window.location.href;
                        return false;
                    }
                    if (viwcaio_ajax_atc_params.cart_redirect_after_add === 'yes') {
                        window.location = viwcaio_ajax_atc_params.cart_url;
                        return false;
                    }
                    jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, button]);
                    if (!viwcaio_ajax_atc_params.woocommerce_enable_ajax_add_to_cart){
                        jQuery(document.body).trigger("wc_fragment_refresh");
                    }
                    jQuery(document.body).trigger('vi_wcaio_added_to_cart', [response.fragments, response.cart_hash, button]);
                    viwcaio_atc.shift();
                    if (viwcaio_atc.length > 0) {
                        jQuery.ajax(viwcaio_atc[0]);
                    } else {
                        jQuery(document.body).trigger('update_checkout');
                    }
                },
                complete: function (response) {
                    button.removeClass('loading vi-wcaio-product-bt-atc-loading').addClass('added');
                },
            });
            if (viwcaio_atc.length === 1) {
                jQuery.ajax(viwcaio_atc[0]);
            }
        });
    }
    jQuery(document).on('click', '.vi-wcaio-product-bt-atc:not(.vicatna-single-atc-button):not(.vi-wcaio-product-bt-not-atc):not(.vi-wcaio-product-bt-atc-loading):not(.vi-wcaio-product-bt-atc-non-ajax)', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let button = jQuery(this),
            form = jQuery(this).closest('.vi-wcaio-va-cart-form');
        button.addClass('vi-wcaio-product-bt-atc-loading').removeClass('added');
        let check_attribute = true;
        form.find('.vi-wcaio-attribute-options').each(function (k, item) {
            if (!jQuery(item).val()) {
                check_attribute = false;
                return false;
            }
        });
        if (!check_attribute) {
            if (!jQuery('.vi-wcaio-warning-wrap').length) {
                jQuery('body').append('<div class="vi-wcaio-warning-wrap vi-wcaio-warning-wrap-open">' + viwcaio_ajax_atc_params.i18n_make_a_selection_text + '</div>');
            } else {
                jQuery('.vi-wcaio-warning-wrap').removeClass('vi-wcaio-warning-wrap-close').addClass('vi-wcaio-warning-wrap-open').html(viwcaio_ajax_atc_params.i18n_make_a_selection_text);
            }
            setTimeout(function () {
                jQuery('.vi-wcaio-warning-wrap').addClass('vi-wcaio-warning-wrap-close').removeClass('vi-wcaio-warning-wrap-open');
            }, 2000);
            button.removeClass('vi-wcaio-product-bt-atc-loading');
            return false;
        }
        if (button.hasClass('vi-wcaio-button-swatches-disable') || button.hasClass('vi-wcaio-product-bt-atc-disabled')) {
            if (!jQuery('.vi-wcaio-warning-wrap').length) {
                jQuery('body').append('<div class="vi-wcaio-warning-wrap vi-wcaio-warning-wrap-open">' + viwcaio_ajax_atc_params.i18n_unavailable_text + '</div>');
            } else {
                jQuery('.vi-wcaio-warning-wrap').removeClass('vi-wcaio-warning-wrap-close').addClass('vi-wcaio-warning-wrap-open').html(viwcaio_ajax_atc_params.i18n_unavailable_text);
            }
            setTimeout(function () {
                jQuery('.vi-wcaio-warning-wrap').addClass('vi-wcaio-warning-wrap-close').removeClass('vi-wcaio-warning-wrap-open');
            }, 2000);
            button.removeClass('vi-wcaio-product-bt-atc-loading');
            return false;
        }
        if (form.hasClass('vi-wcaio-va-cart-form')) {
            button.data('quantity', form.find('input.vi-wcaio-va-qty-input').val() || 0);
        }
        let data = form.find('select, input').serialize();
        viwcaio_atc.push({
            type: 'post',
            url: viwcaio_ajax_atc_params.wc_ajax_url.toString().replace('%%endpoint%%', 'viwcaio_add_to_cart'),
            data: data,
            beforeSend: function (response) {
                form.addClass('vi-wcaio-va-cart-form-loading');
            },
            success: function (response) {
                if (response.error) {
                    location.href = window.location.href;
                    return false;
                }
                if (viwcaio_ajax_atc_params.cart_redirect_after_add === 'yes') {
                    window.location = viwcaio_ajax_atc_params.cart_url;
                    return false;
                }
                jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, button]);
                if (!viwcaio_ajax_atc_params.woocommerce_enable_ajax_add_to_cart ){
                    jQuery(document.body).trigger("wc_fragment_refresh");
                }
                jQuery(document.body).trigger('vi_wcaio_added_to_cart', [response.fragments, response.cart_hash, button]);
                viwcaio_atc.shift();
                if (viwcaio_atc.length > 0) {
                    jQuery.ajax(viwcaio_atc[0]);
                }else {
                    jQuery(document.body).trigger('update_checkout');
                }
            },
            complete: function (response) {
                button.removeClass('vi-wcaio-product-bt-atc-loading');
                form.closest('.vi-wcaio-va-cart-form-wrap-wrap').remove();
            },
        });
        if (viwcaio_atc.length === 1) {
            jQuery.ajax(viwcaio_atc[0]);
        }
    })
});