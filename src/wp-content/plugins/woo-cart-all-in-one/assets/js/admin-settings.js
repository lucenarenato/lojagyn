jQuery(document).ready(function () {
    'use strict';
    viwcaio_init_tab();
    jQuery('.vi-ui.dropdown').unbind().dropdown();
    jQuery('.vi-ui.checkbox').unbind().checkbox();
    jQuery('input[type="checkbox"]').unbind().on('change', function () {
        if (jQuery(this).prop('checked')) {
            jQuery(this).parent().find('input[type="hidden"]').val('1');
            if (jQuery(this).hasClass('vi-wcaio-ajax_atc-checkbox')) {
                jQuery('.vi-wcaio-ajax_atc-enable').removeClass('vi-wcaio-disabled');
            }
            if (jQuery(this).hasClass('vi-wcaio-pd_variable_bt_atc_text_enable-checkbox')) {
                jQuery('.vi-wcaio-pd_variable_bt_atc_text_enable-enable').removeClass('vi-wcaio-disabled');
            }
        } else {
            jQuery(this).parent().find('input[type="hidden"]').val('');
            if (jQuery(this).hasClass('vi-wcaio-ajax_atc-checkbox')) {
                jQuery('.vi-wcaio-ajax_atc-enable').addClass('vi-wcaio-disabled');
            }
            if (jQuery(this).hasClass('vi-wcaio-pd_variable_bt_atc_text_enable-checkbox')) {
                jQuery('.vi-wcaio-pd_variable_bt_atc_text_enable-enable').addClass('vi-wcaio-disabled');
            }
        }
    });
    jQuery('input[type = "number"]').unbind().on('blur', function () {
        let new_val, min = parseFloat(jQuery(this).attr('min')) || 0,
            max = parseFloat(jQuery(this).attr('max')),
            val = parseFloat(jQuery(this).val()) || 0;
        new_val = val;
        if (min > val) {
            new_val = min;
        }
        if (max && max < val) {
            new_val = max;
        }
        jQuery(this).val(new_val).trigger('change');
    });
    jQuery('.vi-wcaio-search-select2:not(.vi-wcaio-search-select2-init)').each(function () {
        let select = jQuery(this);
        let close_on_select = false, min_input = 2, placeholder = '', action = '', type_select2 = select.data('type_select2');
        switch (type_select2) {
            case 'product':
                placeholder = 'Please fill in your product title';
                action = 'viwcaio_search_product';
                break;
            case 'category':
                placeholder = 'Please fill in your category title';
                action = 'viwcaio_search_cats';
                break;
        }
        select.addClass('vi-wcaio-search-select2-init').select2(viwcaio_select2_params(placeholder, action, close_on_select, min_input));
    });
});

function viwcaio_select2_params(placeholder, action, close_on_select, min_input) {
    let result = {
        closeOnSelect: close_on_select,
        placeholder: placeholder,
        cache: true
    };
    if (action) {
        result['minimumInputLength'] = min_input;
        result['escapeMarkup'] = function (markup) {
            return markup;
        };
        result['ajax'] = {
            url: "admin-ajax.php?action=" + action,
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: false
        };
    }
    return result;
}

function viwcaio_init_tab(tab_default = 'sidebar_cart') {
    jQuery('.vi-ui.vi-ui-main.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });
    /*Setup tab*/
    let tabs,
        tabEvent = false,
        initialTab = tab_default,
        navSelector = '.vi-ui.vi-ui-main.menu';
    // Initializes plugin features
    jQuery.address.strict(false).wrap(true);

    if (jQuery.address.value() == '') {
        jQuery.address.history(false).value(initialTab).history(true);
    }
    // Address handler
    jQuery.address.init(function (event) {

        // Tabs setup
        tabs = jQuery('.vi-ui.vi-ui-main.menu')
            .vi_tab({
                history: true,
                historyType: 'hash'
            });

        // Enables the plugin for all the tabs
        jQuery(navSelector + ' a').on('click', function (event) {
            tabEvent = true;
            tabEvent = false;
            return true;
        });

    });
}