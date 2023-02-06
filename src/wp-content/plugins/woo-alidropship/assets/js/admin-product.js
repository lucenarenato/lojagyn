jQuery(document).ready(function ($) {
    'use strict';
    $(document).on('change', '#product-type', function () {
        let $simple_attributes = $('.vi-wad-original-attributes-simple');
        if ($(this).val() === 'variable') {
            $simple_attributes.fadeOut(200)
        } else {
            $simple_attributes.fadeIn(200)
        }
    }).trigger('change');
    $(document).on('change', '.vi-wad-original-attributes-select', function () {
        let $sku_attr = $(this);
        $sku_attr.closest('.vi-wad-original-attributes').find('.vi-wad-original-sku-id').val($sku_attr.find(`option[value="${$sku_attr.val()}"]`).data('vi_wad_sku_id'))
    });
});