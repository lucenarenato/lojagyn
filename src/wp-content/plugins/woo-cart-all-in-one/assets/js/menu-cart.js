jQuery(document).ready(function () {
    'use strict';
    if (typeof wc_cart_fragments_params === 'undefined') {
        return false;
    }
    jQuery(document.body).on('mouseenter','.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show .vi-wcaio-menu-cart-nav-wrap', function () {
        let menu_content = jQuery('.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show .vi-wcaio-menu-cart-content-wrap');
        if (!menu_content.length){
            return false;
        }
        menu_content.addClass('vi-wcaio-menu-cart-content-wrap-show');
        let left = menu_content.offset().left, width = menu_content.outerWidth();
        if (jQuery('body').outerWidth() < (left + width)){
            menu_content.addClass('vi-wcaio-menu-cart-content-wrap-show-right')
        }
    });
    jQuery(document.body).on('mouseleave','.vi-wcaio-menu-cart.vi-wcaio-menu-cart-show', function () {
        jQuery('.vi-wcaio-menu-cart-content-wrap-show').removeClass('vi-wcaio-menu-cart-content-wrap-show');
    });
    jQuery(document.body).on('added_to_cart', function (evt, fragments, cart_hash, btn) {
        jQuery('.vi-wcaio-menu-cart').each(function () {
            vi_wcaio_mc_toggle(jQuery(this), true);
        });
    });
    jQuery(document.body).on('removed_from_cart', function (evt, fragments, cart_hash, btn) {
        let cart_item_key = jQuery(btn).data('cart_item_key') || '';
        jQuery('.vi-wcaio-menu-cart').each(function () {
            if (cart_item_key && jQuery(this).find('[data-cart_item_key="' + cart_item_key + '"]').length) {
                jQuery(this).find('[data-cart_item_key="' + cart_item_key + '"]').closest('li').remove();
            }
            vi_wcaio_mc_toggle(jQuery(this));
        });
    });
});

function vi_wcaio_mc_toggle(cart, show = false) {
    cart = jQuery(cart);
    if (show) {
        cart.removeClass('vi-wcaio-disabled');
        return false;
    }
    if (cart.data('empty_enable') || cart.find('.widget_shopping_cart_content > ul > li').length) {
        return false;
    }
    cart.addClass('vi-wcaio-disabled');
}
