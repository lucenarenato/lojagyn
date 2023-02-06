// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

var a2w_chrome_extension_loaded = false;
document.addEventListener('maAPILoaded', function () {
    jQuery("#chrome-notify").hide();
    a2w_chrome_extension_loaded = true;
});

var waitForFinalEvent = (function () {
    var timers = {};
    return function (callback, ms, uniqueId) {
        if (!uniqueId) {
            uniqueId = "Don't call this twice without a uniqueId";
        }
        if (timers[uniqueId]) {
            clearTimeout(timers[uniqueId]);
        }
        timers[uniqueId] = setTimeout(callback, ms);
    };
})();

function a2w_tmce_getContent(editor_id, textarea_id) {
    if ( typeof editor_id == 'undefined' ) editor_id = wpActiveEditor;
    if ( typeof textarea_id == 'undefined' ) textarea_id = editor_id;

    if ( jQuery('#wp-'+editor_id+'-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id) ) {
        return tinyMCE.get(editor_id).getContent();
    }else{
        return jQuery('#'+textarea_id).val();
    }
}

function show_notification(text, danger) {

    if(jQuery(".a2w-content .alert").length === 0){
        jQuery('<div class="alert" role="alert">').prependTo(jQuery(".a2w-content"));
    }
    
    var alert = jQuery(".a2w-content .alert");

    alert.removeClass('alert-success alert-danger');

    alert.addClass((typeof danger !== "undefined") ? 'alert-danger' : 'alert-success')

    alert.html(text);
    alert.fadeTo(5000, 500, function () {
        alert.fadeOut("slow");
    });
}

function update_product_info(data, on_update_calback) {
    data.action = 'a2w_update_product_info';
    jQuery.post(ajaxurl, data).done(function (response) {
        var json = jQuery.parseJSON(response);
        if (json.state !== 'ok') {
            console.log(json);
        }
        
        if(on_update_calback){
            on_update_calback();
        }
    }).fail(function (xhr, status, error) {
        console.log(error);
        
        if(on_update_calback){
            on_update_calback();
        }
    });
}

function update_variation_info(data, on_update_calback) {
    var on_update_calback_call_cnt = 0;
    if(data.variations.length>0){
        var post_data = {action:'a2w_update_variation_info', id:data.id, variations:data.variations.splice(0, 100)}
        jQuery.post(ajaxurl, post_data).done(function (response) {
            var json = jQuery.parseJSON(response);
            if (json.state !== 'ok') {
                console.log(json);
            }

            if (json.state !== 'error') {
                jQuery.each(json.new_attr_mapping, function (i, attr_mapping) {
                    jQuery('tr[data-id="' + attr_mapping.variation_id + '"] .attr[data-id="' + attr_mapping.old_attr_id + '"]').attr('data-id', attr_mapping.new_attr_id);
                });
            }
            
            if(on_update_calback && on_update_calback_call_cnt==0){
                on_update_calback_call_cnt++;
                on_update_calback();
            }
            
            update_variation_info(data, on_update_calback);
        }).fail(function (xhr, status, error) {
            console.log(error);
            
            if(on_update_calback){
                on_update_calback();
            }
        });
    }
    
}

function chech_products_view() {
    var products_to_load = [];
    jQuery(".product-card .product-card-shipping-info").each(function () {
        var _this_data = jQuery(this).data();
        if (_this_data && !_this_data.shipping) {
            if (Utils.isElementInView(jQuery(this).closest(".product-card"), false)) {
                products_to_load.push(jQuery(this).closest(".product-card").attr('data-id'));
                _this_data.shipping = 'loading';
                jQuery(this).data(_this_data);
            }
        }
    });

    if (products_to_load.length > 0) {
        var data = {'action': 'a2w_load_shipping_info', 'id': products_to_load};
        jQuery.post(ajaxurl, data).done(function (response) {
            var json = jQuery.parseJSON(response);
            if (json.state !== 'ok') {
                console.log(json);
            }
            if (json.state != 'error') {
                jQuery.each(json.products, function (i, product) {
                    var product_block = jQuery('.product-card[data-id="' + product.product_id + '"] .product-card-shipping-info');
                    var tmp_data = jQuery(product_block).data();
                    tmp_data.shipping = product.items;
                    jQuery(product_block).data(tmp_data);
                    var p = -1;
                    var fp = '';
                    var n = '';
                    var t = '';
                    jQuery.each(product.items, function (j, item) {
                        if (p < 0 || item.freightAmount.value < p) {
                            p = item.freightAmount.value;
                            fp = p > 0.009 ? item.freightAmount.formatedAmount : 'Free';
                            n = item.company;
                            t = item.time + ' days';
                        }
                    });
                    jQuery(product_block).find('.shipping-title').html(fp + ' ' + n);
                    jQuery(product_block).find('.delivery-time').html(t);

                });
            }
        }).fail(function (xhr, status, error) {
            console.log(error);
        });
    }

}

function Utils() {
}
Utils.prototype = {
    constructor: Utils,
    isElementInView: function (element, fullyInView) {
        var pageTop = jQuery(window).scrollTop();
        var pageBottom = pageTop + jQuery(window).height();
        var elementTop = jQuery(element).offset().top;
        var elementBottom = elementTop + jQuery(element).height();

        if (fullyInView === true) {
            return ((pageTop < elementTop) && (pageBottom > elementBottom));
        } else {
            return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
        }
    }
};
var Utils = new Utils();

(function ($, window, document, undefined) {
    $(function () {
        if (a2w_chrome_extension_loaded === false) {
            $("#chrome-notify").show();
        }

        $(".country_list").select2();

        $("img.lazy").lazyload({effect: "fadeIn"});

        $("#a2w-do-filter").click(function () {
            $(this).closest('form').submit();
            return false;
        });

        jQuery("#a2w-search-form").submit(function () {
            jQuery(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });

        $("#a2w-sort-selector").change(function () {
            jQuery("#a2w-search-form #a2w_sort").val($(this).val());
            jQuery("#a2w-search-form").submit();
            return false;
        });

        $("#a2w-search-pagination li a").click(function () {
            jQuery("#a2w-search-form #cur_page").val($(this).attr('rel'));
            jQuery("#a2w-search-form").submit();

            return false;
        });

        function find_min_shipping_price(items) {
            var result = false;
            var p = -1;
            $.each(items, function (i, item) {
                if (p < 0 || item.freightAmount.value < p) {
                    p = item.freightAmount.value;
                    result = {'price': item.freightAmount.value, 'formated_price': item.freightAmount.value > 0.009 ? item.freightAmount.formatedAmount : 'Free', 'name': item.company, 'time': item.time};
                }
            });
            return result;
        }

        function fill_modal_shipping_info(product_id, country, items) {
            var tmp_data = {'product_id': product_id, 'country': country, 'shipping': items};
            $(".modal-shipping").data(tmp_data);
            $('#modal-country-select').val(country).trigger('change');

            var html = '<table class="shipping-table"><thead><tr><th><strong>Shipping Method</strong></th><th><strong>Estimated Delivery Time</strong></th><th><strong>Shipping Cost</strong></th></tr></thead><tbody>';
            $.each(tmp_data.shipping, function (i, item) {
                html += '<tr><td>' + item.company + '</td><td>' + item.time + '</td><td>' + item.freightAmount.formatedAmount + '</td></tr>';
            });
            html += '</tbody></table>';
            $('.modal-shipping .shipping-method').html(html);

            var product_block = $('.product-card[data-id="' + tmp_data.product_id + '"]');
            var min_shipping_price = find_min_shipping_price(tmp_data.shipping);
            if (min_shipping_price) {
                $(product_block).find('.product-card-shipping-info .shipping-title').html(min_shipping_price.formated_price + ' ' + min_shipping_price.name);
                $(product_block).find('.product-card-shipping-info .delivery-time').html(min_shipping_price.time + ' days');
                $(product_block).find('.product-card-shipping-info').data({'country': tmp_data.country, 'shipping': tmp_data.shipping});
            }
        }

        $(".product-card-shipping-info").on("click", function () {
            var tmp_data = $(this).data();

            fill_modal_shipping_info($(this).closest(".product-card").attr('data-id'), tmp_data.country, tmp_data.shipping);

            $(".modal-shipping").fadeIn(400);
            return false;
        });

        $('#modal-country-select').on('change', function (evt) {
            var tmp_data = $(".modal-shipping").data();
            if (tmp_data.country != $(this).val()) {
                tmp_data.country = $(this).val();
                $(".modal-shipping").data(tmp_data);

                $('.modal-shipping .shipping-method').html('<div class="a2w-load-container"><div class="a2w-load-speeding-wheel"></div></div>');

                var data = {'action': 'a2w_load_shipping_info', 'id': tmp_data.product_id, 'country': tmp_data.country};
                jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.state !== 'ok') {
                        console.log(json);
                    }
                    if (json.state != 'error') {
                        var tmp_data = $(".modal-shipping").data();
                        tmp_data.shipping = json.products[0].items;
                        fill_modal_shipping_info(tmp_data.product_id, tmp_data.country, tmp_data.shipping);
                    }
                }).fail(function (xhr, status, error) {
                    console.log(error);
                });
            }
        });

        $(".product-card").find(".product-card__actions .btn").on("click", function () {
            var _this = $(this);
            $(_this).addClass("load");
            if ($(_this).closest(".product-card").hasClass('product-card--added')) {
                $(_this).addClass("btn-success");
                $(_this).removeClass("btn-default");

                var data = {'action': 'a2w_remove_from_import', 'id': $(_this).closest(".product-card").attr('data-id')};
                jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.state !== 'ok') {
                        console.log(json);
                        show_notification('Import failed. '+json.message, true);
                    }else{
                        show_notification('Imported successfully.');
                        
                        $(_this).closest(".product-card").removeClass("product-card--added");
                        $(_this).find(".title").text('Add to import list');
                    }

                    $(_this).removeClass("load");
                }).fail(function (xhr, status, error) {
                    console.log(error);
                    show_notification('Import failed. '+error, true);
                    $(_this).removeClass("load");

                });
            } else {
                var data = {'action': 'a2w_add_to_import', 'id': $(_this).closest(".product-card").attr('data-id')};
                jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.state !== 'ok') {
                        console.log(json);
                        show_notification('Import failed. '+json.message, true);
                    }else{
                        show_notification('Imported successfully.');
                        
                        $(_this).closest(".product-card").addClass("product-card--added");
                        $(_this).find(".title").text('Remove from import list');
                    }

                    $(_this).removeClass("load");
                }).fail(function (xhr, status, error) {
                    console.log(error);
                    show_notification('Import failed. '+error, true);
                    $(_this).removeClass("load");
                });
            }
        });

        $("#import-by-id-url-btn").on("click", function () {
            var _this_btn = $(this);
            var url_value = $(this).parents('.modal-content').find('#url_value').val();
            var id_value = $.trim($(this).parents('.modal-content').find('#id_value').val());

            var product_id = '';
            if (id_value) {
                product_id = id_value;
            } else if (url_value) {
                var result = url_value.match(/.*\/([0-9]+)\.html/i);
                if (result && result.length > 1) {
                    product_id = result[1];
                }
            }
            if (product_id) {
                $(_this_btn).attr("disabled", true);
                var product_block = $('.product-card[data-id="' + product_id + '"]');
                var data = {'action': 'a2w_add_to_import', 'id': product_id};
                jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.state !== 'ok') {
                        console.log(json);
                        show_notification('Import failed. '+json.message, true);
                    }else{
                        show_notification('Imported successfully.');
                        
                        $(product_block).addClass("product-card--added");
                        $(product_block).find(".product-card__actions .title").text('Remove from import list');
                    }

                    $(product_block).removeClass("loading");
                    $(".modal-overlay").fadeOut(400);
                    $("#import-by-id-url-btn").removeAttr('disabled');
                    
                    $(_this_btn).removeAttr("disabled");
                }).fail(function (xhr, status, error) {
                    console.log(error);
                    show_notification('Import failed. '+error, true);
                    $(product_block).removeClass("loading");
                    $("#import-by-id-url-btn").removeAttr('disabled');
                    $(".modal-overlay").fadeOut(400);
                    
                    $(_this_btn).removeAttr("disabled");
                });
            }else{
                
            }
        });

        $(".country-select__trigger").on("click", function () {
            $(this).siblings(".country-select__list-wrap").slideToggle('400');
        });

        $(".country-select").find(".country-select__item").on("click", function () {
            var val = $(this).html();
            $(this).closest(".country-select").find(".country-select__trigger").html(val).end().find(".country-select__list-wrap").fadeOut(300);
        });

        $(".modal-search-open").on("click", function () {
            $('.modal-search input[type="text"]').val('');
            $("#import-by-id-url-btn").removeAttr('disabled');
            $(".modal-search").fadeToggle(400);
        });

        $(".modal-close, .modal-btn-close").on("click", function () {
            $(".modal-overlay").fadeOut(400);
            return false;
        });

        $("#search-trigger").on("click", function () {
            $(".search-panel-advanced").slideToggle("fast", function () {
                if ($(this).is(":visible")) {
                    $("#search-trigger").html("Simple");
                } else {
                    $("#search-trigger").html("Advance");
                }
            });
        });

        $(document).mouseup(function (e) {
            var div = $(".country-select__list-wrap, .dropdown-menu");
            if (!div.is(e.target) && div.has(e.target).length === 0) {
                div.hide();
            }
        });

        $(window).resize(resizeRowproducts);
        resizeRowproducts();
        function resizeRowproducts() {
            $(".search-result__row").height($(".product-card").innerHeight());
        }

        $(".product-card__shipping-info").on("click", function () {
            $(".modal-overlay-shipping").fadeIn(400);
        });


        $.fn.confirm_modal = function (options) {
            var confirm_modal_dialog = this;

            $(confirm_modal_dialog).find('.modal-header .modal-title').html(options.title ? options.title : '');
            $(confirm_modal_dialog).find('.modal-body').html(options.body ? options.body : '');

            $(confirm_modal_dialog).find(".btn.no-btn").on("click", function () {
                if (options && options.no) {
                    options.no();
                }
                $(confirm_modal_dialog).fadeOut(400);
            });
            $(confirm_modal_dialog).find(".btn.yes-btn").on("click", function () {
                if (options && options.yes) {
                    options.yes();
                }
                $(confirm_modal_dialog).fadeOut(400);
            });
            $(document).ready(function () {
                $(".modal-confirm").fadeIn(400);
            });
            return this;
        };

        function update_bulk_actions() {
            if ($('.a2w-product-import-list .select :checkbox:checked').length > 0) {
                $("#a2w-import-actions .action-with-check select option").first().text('Bulk Actions (' + $('.a2w-product-import-list .select :checkbox:checked').length + ' selected)');
                $('.action-with-check').show();
            } else {
                $('.action-with-check').hide();
            }
        }

        $('#a2w-import-actions .check-all').change(function () {
            var checkboxes = $('.a2w-product-import-list .select :checkbox').not($(this));
            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true);
            } else {
                checkboxes.prop('checked', false);
            }
            update_bulk_actions();
        });

        $('.variants-table .check-all-var').change(function () {
            var checkboxes = $(this).closest('.variants-table').find(':checkbox').not($(this));
            if ($(this).is(':checked')) {
                checkboxes.prop('checked', true);
            } else {
                checkboxes.prop('checked', false);
            }

            var $product = $(this).closest('.product');
            waitForFinalEvent(function () {
                var skip_vars = [];
                $($product).find('.variants-table .check-var').not(':checked').each(function () {
                    skip_vars.push($(this).closest('tr').attr('data-id'));
                });
                update_product_info({id: $product.attr('data-id'), skip_vars: skip_vars});
            }, 1000, "update_product_variations");
        });

        $('.variants-table .check-var').change(function () {
            var $product = $(this).closest('.product');
            waitForFinalEvent(function () {
                var skip_vars = [];
                $($product).find('.variants-table .check-var').not(':checked').each(function () {
                    skip_vars.push($(this).closest('tr').attr('data-id'));
                });
                update_product_info({id: $product.attr('data-id'), skip_vars: skip_vars});
            }, 1000, "update_product_variations");
        });
        
        function recalc_image_block_selector(){
            $("[rel=images] .images-blog-title").each(function () {
                $(this).find('.check-all-block-image').prop('checked', jQuery(this).next().find('.image.selected').length ===  jQuery(this).next().find('.image').length);
            });;
        }
        
        recalc_image_block_selector();
        
        
        
        $('[rel=images] .images-blog-title .check-all-block-image').change(function () {
            var _block = $(this).parents('.images-blog-title');
            if ($(this).is(':checked')) {
                jQuery(_block).next().find('.image').addClass('selected');
            } else {
                jQuery(_block).next().find('.image').removeClass('selected');
                jQuery(_block).next().find('.icon-gallery-box').removeClass('selected');
            }

            var $product = $(this).closest('.product');
            waitForFinalEvent(function () {
                var thumb_id = ($($product).find('[rel="images"] .image .icon-gallery-box.selected').length>0)?$($product).find('[rel="images"] .image .icon-gallery-box.selected').parents('.image').attr('id'):'';
                var skip_images_data = [];
                $($product).find('[rel="images"] .image').not('.selected').each(function () {
                    skip_images_data.push($(this).attr('id'));
                });
                var data = {id: $product.attr('data-id'), skip_images: skip_images_data, thumb: thumb_id};
                if(skip_images_data.length === 0){
                    data.no_skip = 1;
                }
                update_product_info(data);
            }, 1000, "update_product_images");
        });
        
        $('.a2w-product-import-list [rel="images"] .image').click(function () {
            $(this).toggleClass('selected');
            
            if(!$(this).hasClass('selected')){
                $(this).find('.selected').removeClass('selected');
            }
            
            recalc_image_block_selector();

            var $product = $(this).closest('.product');
            waitForFinalEvent(function () {
                var thumb_id = ($($product).find('[rel="images"] .image .icon-gallery-box.selected').length>0)?$($product).find('[rel="images"] .image .icon-gallery-box.selected').parents('.image').attr('id'):'';
                var skip_images_data = [];
                $($product).find('[rel="images"] .image').not('.selected').each(function () {
                    skip_images_data.push($(this).attr('id'));
                });
                var data = {id: $product.attr('data-id'), skip_images: skip_images_data, thumb: thumb_id};
                if(skip_images_data.length === 0){
                    data.no_skip = 1;
                }
                update_product_info(data);
            }, 1000, "update_product_images");
        });
        
        $('.a2w-product-import-list [rel="images"] .image .icon-selected-box').click(function () {
            $(this).toggleClass('selected');
            return false;
        });
        
        $('.a2w-product-import-list [rel="images"] .image .icon-gallery-box').click(function () {
            $(this).toggleClass('selected');
            $('.a2w-product-import-list [rel="images"] .image .icon-gallery-box').not(this).removeClass('selected');
            $(this).closest('.image').addClass('selected');
            recalc_image_block_selector();

            var $product = $(this).closest('.product');
            waitForFinalEvent(function () {
                var thumb_id = ($($product).find('[rel="images"] .image .icon-gallery-box.selected').length>0)?$($product).find('[rel="images"] .image .icon-gallery-box.selected').parents('.image').attr('id'):'';
                var skip_images_data = [];
                $($product).find('[rel="images"] .image').not('.selected').each(function () {
                    skip_images_data.push($(this).attr('id'));
                });
                var data = {id: $product.attr('data-id'), skip_images: skip_images_data, thumb: thumb_id};
                if(skip_images_data.length === 0){
                    data.no_skip = 1;
                }
                update_product_info(data);
            }, 1000, "update_product_images");
            
            return false;
        });
        
        $('.description-images-action').change(function () {
            var action = $(this).val();
            var _this = this;
            $(_this).attr('disabled', 'disabled');
            
            
            var images_data = [];
            var selected_images_block = [];
            $(this).parents('.images-blog-title').next().find('.image .icon-selected-box.selected').each(function () {
                images_data.push($(this).parents('.image').attr('id'));
                selected_images_block.push($(this).parents('.image').parent());
            });
                
            var data = {'action': 'a2w_import_images_action', 'id': $(this).parents('.product').attr('data-id'), 'source': 'description', 'type': action, 'images': images_data};
                
            jQuery.post(ajaxurl, data).done(function (response) {
                $(_this).val('');
                $(_this).removeAttr('disabled');
                
                var json = jQuery.parseJSON(response);
                if (json.state !== 'ok') {
                    console.log(json);
                }else{
                    $.each(selected_images_block, function (i, image_block) {
                        $(image_block).find('.image').append('<div class="cancel-image-action"><a href="#" data-action="'+action+'#description">'+(action=='move'?'Cancel move':'Cancel copy')+'</a>');
                        if(action=='move'){
                            $(image_block).detach();
                        }
                        $(image_block).appendTo($('.row.gallery_images'));
                    });
                }
            }).fail(function (xhr, status, error) {
                $(_this).val('');
                $(_this).removeAttr('disabled');
                
                console.log(error);
            });
            
        });
        
        $('.a2w-product-import-list [rel="images"] .image').on('click', '.cancel-image-action a', function () {
            var tmp = $(this).attr('data-action').split('#')
            var data = {'action': 'a2w_import_cancel_images_action', 'id': $(this).parents('.product').attr('data-id'), 'source': tmp[1], 'type': tmp[0], 'image': $(this).parents('.image').attr('id')}; 
            var image_block = $(this).parents('.image').parent();
            
            jQuery.post(ajaxurl, data).done(function (response) {
                var json = jQuery.parseJSON(response);
                if (json.state !== 'ok') {
                    console.log(json);
                }else{
                    $(image_block).detach();
                    if(tmp[0]=='move'){
                        if(tmp[1]=='description'){
                            $(image_block).find('.cancel-image-action').remove();
                            $(image_block).appendTo($('.row.description_images'));
                        } else if(tmp[1]=='variant'){
                            $(image_block).find('.cancel-image-action').remove();
                            $(image_block).appendTo($('.row.variant_images'));
                        }
                    }
                }
            }).fail(function (xhr, status, error) {
                console.log(error);
            });
            return false;
        });
        
        $('.a2w-product-import-list .select :checkbox').change(function () {
            update_bulk_actions();
        });

        jQuery(".a2w-product-import-list").on("click", ".post_import", function () {
            var this_btn = this;
            var product = $(this).parents('.product');
            var products_to_import = [];
            var data = {'action': 'a2w_push_product', 'id': $(product).attr('data-id')};
            products_to_import.push(data);

            $(this_btn).addClass('load');
            var on_load = function (id, response_state, response_message, state) {
                if (response_state !== 'error') {
                    $('.a2w-product-import-list .select :checkbox[value="' + id + '"]').parents('.product').parents('.row').remove();
                    if ($('.a2w-product-import-list').find('.product').length === 0) {
                        $('#a2w-import-content').hide();
                        $('#a2w-import-empty').show();
                    }
                    show_notification('Push to shop complete successfully.');
                }else{
                    show_notification('Import failed. '+response_message, true);
                }
                $(this_btn).removeClass('load');
            };
            
            var state = {num_to_import: products_to_import.length, import_cnt: 0, import_error_cnt: 0};
            a2w_js_post_to_woocomerce(products_to_import, state, on_load);

            return false;
        });


        $('#a2w-import-actions .action-with-check select').change(function () {
            var ids = [];
            $('.a2w-product-import-list .select :checkbox:checked:not(:disabled)').each(function () {
                ids.push($(this).val());
            });

            if ($(this).val() === 'remove') {

                $('.modal-confirm').confirm_modal({
                    title: 'Remove ' + $('.a2w-product-import-list .select :checkbox:checked').length + ' products',
                    body: 'Are you sure you want to remove ' + $('.a2w-product-import-list .select :checkbox:checked').length + ' products from your import list?',
                    yes: function () {
                        $('#a2w-import-actions .action-with-check').addClass('load');
                        $("#a2w-import-actions .action-with-check select").prop('disabled', true);

                        var data = {'action': 'a2w_delete_import_products', 'ids': ids};
                        jQuery.post(ajaxurl, data).done(function (response) {
                            var json = jQuery.parseJSON(response);
                            if (json.state !== 'ok') {
                                console.log(json);
                            }
                            $('#a2w-import-actions .action-with-check').removeClass('load');
                            $("#a2w-import-actions .action-with-check select").prop('disabled', false);
                            $('#a2w-import-actions .action-with-check select').val(0);
                            $.each(ids, function (i, item) {
                                $('.a2w-product-import-list .select :checkbox[value="' + item + '"]').closest('.product').parents('.row').remove();
                            });
                            update_bulk_actions();

                            if ($('.a2w-product-import-list').find('.product').length === 0) {
                                $('#a2w-import-content').hide();
                                $('#a2w-import-empty').show();
                            }

                        }).fail(function (xhr, status, error) {
                            console.log(error);
                            $('#a2w-import-actions .action-with-check').removeClass('load');
                            $("#a2w-import-actions .action-with-check select").prop('disabled', false);
                            $('#a2w-import-actions .action-with-check select').val(0);
                        });
                    },
                    no: function () {
                        $('#a2w-import-actions .action-with-check select').val(0);
                    }
                });


            } else if ($(this).val() === 'push') {
                $('.modal-confirm').confirm_modal({
                    title: 'Push ' + $('.a2w-product-import-list .select :checkbox:checked').length + ' products',
                    body: 'Are you sure you want to push ' + $('.a2w-product-import-list .select :checkbox:checked').length + ' products to woocommerce?',
                    yes: function () {
                        $('#a2w-import-actions .action-with-check').addClass('load');
                        $("#a2w-import-actions .action-with-check select").prop('disabled', true);

                        var products_to_import = [];
                        $.each(ids, function (i, item) {
                            products_to_import.push({'action': 'a2w_push_product', 'id': item});
                        });

                        $('.a2w-product-import-list .select :checkbox:checked:not(:disabled)').closest('.product').find('.post_import').addClass('load');

                        var on_load = function (id, response_state, response_message, state) {
                            if ((state.import_cnt + state.import_error_cnt) === state.num_to_import) {
                                $('#a2w-import-actions .action-with-check').removeClass('load');
                                $("#a2w-import-actions .action-with-check select").prop('disabled', false);
                                $('#a2w-import-actions .action-with-check select').val(0);
                            }
                            if (response_state !== 'error') {
                                $('.a2w-product-import-list .select :checkbox[value="' + id + '"]').closest('.product').parents('.row').remove();
                            }

                            if ($('.a2w-product-import-list').find('.product').length === 0) {
                                $('#a2w-import-content').hide();
                                $('#a2w-import-empty').show();
                            }
                        };


                        var state = {num_to_import: products_to_import.length, import_cnt: 0, import_error_cnt: 0};

                        a2w_js_post_to_woocomerce(products_to_import, state, on_load);
                        a2w_js_post_to_woocomerce(products_to_import, state, on_load);
                    },
                    no: function () {
                        $('#a2w-import-actions .action-with-check select').val(0);
                    }
                });
            } else if ($(this).val() === 'link-category') {
                $(".set-category-dialog .categories").attr('data-link-type','selected');
                $(".set-category-dialog").fadeIn(200);
                update_bulk_actions();
                $('#a2w-import-actions .action-with-check select').val(0);
            }
        });
        
        $('#a2w-import-actions .link_category_all').click(function () {
            $(".set-category-dialog .categories").attr('data-link-type','all');
            $(".set-category-dialog").fadeIn(200);
            return false;
        });

        $('#a2w-import-actions .delete_all').click(function () {
            var del_url = $(this).attr('href');
            $('.modal-confirm').confirm_modal({
                title: 'Remove all products',
                body: 'Are you sure you want to remove all products from your import list?',
                yes: function () {
                    window.location.href = del_url;
                }
            });
            return false;
        });

        $('#a2w-import-actions .push_all').click(function () {
            var this_btn = $(this);
            $('.modal-confirm').confirm_modal({
                title: 'Push all products',
                body: 'Are you sure you want to push all products to woocommerce?',
                yes: function () {
                    $(this_btn).addClass('load');
                    $('.a2w-product-import-list .select :checkbox:not(:disabled)').closest('.product').find('.post_import').addClass('load');
                    
                    var data = {'action': 'a2w_get_all_products_to_import'};
                    jQuery.post(ajaxurl, data).done(function (response) {
                        var json = jQuery.parseJSON(response);
                        if (json.state !== 'ok') {
                            console.log(json);
                        }
                        
                        var products_to_import = [];
                        $.each(json.ids, function (i, id) {
                            products_to_import.push({'action': 'a2w_push_product', 'id': id});
                        });
                        
                        var on_load = function (id, response_state, response_message, state) {
                            if ((state.import_cnt + state.import_error_cnt) === state.num_to_import) {
                                $(this_btn).removeClass('load');
                            }
                            if (response_state !== 'error') {
                                $('.a2w-product-import-list .select :checkbox[value="' + id + '"]').closest('.product').parents('.row').remove();
                            } else {
                                $('.a2w-product-import-list .select :checkbox[value="' + id + '"]').closest('.product').find('.post_import').removeClass('load');
                            }

                            if ($('.a2w-product-import-list').find('.product').length === 0) {
                                $('#a2w-import-content').hide();
                                $('#a2w-import-empty').show();
                            }
                        };

                        var state = {num_to_import: products_to_import.length, import_cnt: 0, import_error_cnt: 0};
                        a2w_js_post_to_woocomerce(products_to_import, state, on_load);
                        a2w_js_post_to_woocomerce(products_to_import, state, on_load);
                        
                    }).fail(function (xhr, status, error) {
                        $(this_btn).removeClass('load');
                    });
                }
            });
            return false;
        });


        function a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback) {
            if (products_to_import.length > 0) {
                var data = products_to_import.shift();
                
                var product = $('.product[data-id="'+data.id+'"]');
                var need_update_product = $(product).attr('data-need-update-product');
                var need_update_variation = $(product).attr('data-need-update-variation');
                
                
                if (typeof need_update_product !== typeof undefined && need_update_product !== false) {
                    var update_data = {id: data.id, title: $(product).find('.title').val(), tags: $(product).find('.tags').val(), type: $(product).find('.type').val(), status: $(product).find('.status').val(), categories: $(product).find('.categories').val()};
                    if ( typeof tinyMCE !== 'undefined' ) { update_data['description'] = encodeURIComponent(a2w_tmce_getContent(data.id));}
                    update_product_info(update_data, function() {
                        $(product).removeAttr('data-need-update-product');
                        jQuery.post(ajaxurl, data).done(function (response) {
                            var json = jQuery.parseJSON(response);
                            if (json.state !== 'ok') {
                                console.log(json);
                            }

                            if (json.state === 'error') {
                                state.import_error_cnt++;

                            } else {
                                state.import_cnt++;
                            }

                            if (on_load_calback) {
                                on_load_calback(data.id, json.state, json.message, state);
                            }

                            a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                        }).fail(function (xhr, status, error) {
                            console.log(error);
                            state.import_error_cnt++;

                            if (on_load_calback) {
                                on_load_calback(data.id, 'error', 'request error', state);
                            }
                            
                            a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                        });
                        
                    });
                } else if (typeof need_update_variation !== typeof undefined && need_update_variation !== false) {
                    var update_data = {id: $(product).attr('data-id'), variations: []};
                    $(product).find('.variants-table tbody tr').each(function () {
                        var variation = {variation_id: $(this).attr('data-id'), sku: $(this).find('.sku').val(), quantity: $(this).find('.quantity').val(), price: $(this).find('.price').val(), regular_price: $(this).find('.regular_price').val(), attributes: []};
                        $(this).find('input.attr').each(function () {
                            variation.attributes.push({id: $(this).attr('data-id'), value: $(this).val()});
                        });
                        update_data.variations.push(variation);
                    });
                    update_variation_info(update_data, function() {
                        $(product).removeAttr('data-need-update-variation');
                        
                        jQuery.post(ajaxurl, data).done(function (response) {
                            var json = jQuery.parseJSON(response);
                            if (json.state !== 'ok') {
                                console.log(json);
                            }

                            if (json.state === 'error') {
                                state.import_error_cnt++;

                            } else {
                                state.import_cnt++;
                            }

                            if (on_load_calback) {
                                on_load_calback(data.id, json.state, json.message, state);
                            }

                            a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                        }).fail(function (xhr, status, error) {
                            console.log(error);
                            state.import_error_cnt++;

                            if (on_load_calback) {
                                on_load_calback(data.id, 'error', 'request error', state);
                            }

                            a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                        });
                        
                    });
                } else{
                    jQuery.post(ajaxurl, data).done(function (response) {
                        var json = jQuery.parseJSON(response);
                        if (json.state !== 'ok') {
                            console.log(json);
                        }

                        if (json.state === 'error') {
                            state.import_error_cnt++;

                        } else {
                            state.import_cnt++;
                        }

                        if (on_load_calback) {
                            on_load_calback(data.id, json.state, json.message, state);
                        }

                        a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                    }).fail(function (xhr, status, error) {
                        console.log(error);
                        state.import_error_cnt++;

                        if (on_load_calback) {
                            on_load_calback(data.id, 'error', 'request error', state);
                        }

                        a2w_js_post_to_woocomerce(products_to_import, state, on_load_calback);
                    });
                }
            }
        }

        $('.a2w-content .product input.title').change(function () {
            var product = $(this).parents('.product');
            $(product).attr('data-need-update-product', true);
            update_product_info({id: $(product).attr('data-id'), title: $(product).find('.title').val(), tags: $(product).find('.tags').val(), type: $(product).find('.type').val(), status: $(product).find('.status').val(), categories: $(product).find('.categories').val()}, function() {$(product).removeAttr('data-need-update-product');});
        });
        $(".a2w-content .product .select2, .a2w-content .product .select2-tags").on("select2:select", function (e) {
            var product = $(this).parents('.product');
            $(product).attr('data-need-update-product', true);
            update_product_info({id: $(product).attr('data-id'), title: $(product).find('.title').val(), tags: $(product).find('.tags').val(), type: $(product).find('.type').val(), status: $(product).find('.status').val(), categories: $(product).find('.categories').val()}, function() {$(product).removeAttr('data-need-update-product');});
        });
        $(".a2w-content .product .select2, .a2w-content .product .select2-tags").on("select2:unselect", function (e) {
            var product = $(this).parents('.product');
            $(product).attr('data-need-update-product', true);
            update_product_info({id: $(product).attr('data-id'), title: $(product).find('.title').val(), tags: $(product).find('.tags').val(), type: $(product).find('.type').val(), status: $(product).find('.status').val(), categories: $(product).find('.categories').val()}, function() {$(product).removeAttr('data-need-update-product');});
        });

        $('.a2w-content .variants-table .var_data input[type="text"]').change(function () {
            var product = $(this).closest('.product');
            $(product).attr('data-need-update-variation', true);
            waitForFinalEvent(function () {
                var data = {id: $(product).attr('data-id'), variations: []};
                $(product).find('.variants-table tbody tr').each(function () {
                    var variation = {variation_id: $(this).attr('data-id'), sku: $(this).find('.sku').val(), quantity: $(this).find('.quantity').val(), price: $(this).find('.price').val(), regular_price: $(this).find('.regular_price').val(), attributes: []};
                    $(this).find('input.attr').each(function () {
                        variation.attributes.push({id: $(this).attr('data-id'), value: $(this).val()});
                    });
                    data.variations.push(variation);
                });
                update_variation_info(data, function() {$(product).removeAttr('data-need-update-variation');});
            }, 2000, "update_variation_info");
        });

        jQuery(".wp-editor-container textarea").change(function (e) {
            var product = $('.product[data-id='+$(this).attr('id')+']');
            $(product).attr('data-need-update-product', true);
            update_product_info({id: $(this).attr('id'), description: encodeURIComponent($(this).val())}, function() {$(product).removeAttr('data-need-update-product');});
        });

        $('.a2w-content .price-edit-selector .dropdown-menu a').click(function () {
            if ($(this).hasClass('set-new-value')) {
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').attr('placeholder', 'Enter Value');
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data({type: 'value'});
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').val('');
            } else if ($(this).hasClass('multiply-by-value')) {
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').attr('placeholder', 'Enter Multiplier');
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data({type: 'multiplier'});
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').val('');
            } else if ($(this).hasClass('set-new-quantity')) {
                $(this).parents('.price-edit-selector').removeClass('random-value');
                $(this).parents('.price-edit-selector').addClass('set-new-quantity');
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data({type: 'quantity-value'});
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"].simple-value').val('');
            } else if ($(this).hasClass('random-value')) {
                $(this).parents('.price-edit-selector').removeClass('set-new-quantity');
                $(this).parents('.price-edit-selector').addClass('random-value');
                $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data({type: 'quantity-random'});
            }
            $('.price-edit-selector').find('.price-box-top').hide();
            $(this).parents('.price-edit-selector').find('.price-box-top').toggle();
        });

        $('.a2w-content .price-edit-selector .price-box-top .apply').click(function () {
            var new_value = -1,new_from=-1,new_from=-1, type='';
            if ($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type === 'value') {
                type = $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type;
                new_value = parseFloat($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').val());
            } else if ($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type === 'multiplier') {
                type = $(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type;
                new_value = parseFloat($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').val());
            } else if ($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type === 'quantity-value') {
                new_value = parseInt($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').val());
            } else if ($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"]').data().type === 'quantity-random') {
                new_from = parseInt($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"].random-from').val());
                new_to = parseInt($(this).parents('.price-edit-selector').find('.price-box-top input[type="text"].random-to').val());
                new_value = (new_from>0 && new_to>0)?1:0;
            }
            if (new_value > 0) {
                if ($(this).parents('.price-edit-selector').hasClass('edit-regular-price')) {
                    $(this).parents('.variants-table').find('input[type="text"].regular_price').each(function () {
                        var min_price = $(this).parents('tr').find('input[type="text"].price').val();
                        var cur_value = Number(((type == 'multiplier')?parseFloat($(this).val())*new_value:new_value).toFixed(2));
                        $(this).val(min_price < cur_value ? cur_value : min_price);
                    });
                } else if ($(this).parents('.price-edit-selector').hasClass('edit-price')) {
                    $(this).parents('.variants-table').find('input[type="text"].price').each(function () {
                        var max_price = $(this).parents('tr').find('input[type="text"].regular_price').val();
                        var cur_value = Number(((type == 'multiplier')?parseFloat($(this).val())*new_value:new_value).toFixed(2));
                        $(this).val(max_price > cur_value ? cur_value : max_price);
                    });
                } else if ($(this).parents('.price-edit-selector').hasClass('edit-quantity')) {
                    var edit_selector = $(this).parents('.price-edit-selector');
                    $(this).parents('.variants-table').find('input[type="text"].quantity').each(function () {
                        if ($(edit_selector).hasClass('set-new-quantity')) {
                            $(this).val(new_value);
                        } else if ($(edit_selector).hasClass('random-value')) {
                            if(new_from>new_to){
                                var tmp = new_from;
                                new_from = new_to;
                                new_to=tmp;
                            }
                            $(this).val(Math.round(Math.random() * (new_to - new_from)) + new_from);
                        }
                    });
                }
                
                if($(this).parents('.variants-table').find('.var_data input[type="text"]').length>0){
                    $(this).parents('.variants-table').find('.var_data input[type="text"]').first().trigger('change');
                }
            }

            $(this).parents('.price-box-top').hide();
        });

        $('.a2w-content .price-edit-selector .price-box-top .close').click(function () {
            $(this).parents('.price-box-top').hide();
        });

        $('.a2w-content .variants-actions .disable-var-price-change').change(function () {
            var $product = $(this).closest('.product');
            var disable_var_price_change = $(this).is(':checked') ? 1 : 0;
            waitForFinalEvent(function () {
                var skip_vars = [];
                $($product).find('.variants-table .check-var').not(':checked').each(function () {
                    skip_vars.push($(this).closest('tr').attr('data-id'));
                });
                update_product_info({id: $product.attr('data-id'), disable_var_price_change: disable_var_price_change});
            }, 1000, "update_product_variations");
        });
        
        $('.a2w-content .variants-actions .disable-var-quantity-change').change(function () {
            var $product = $(this).closest('.product');
            var disable_var_quantity_change = $(this).is(':checked') ? 1 : 0;
            waitForFinalEvent(function () {
                var skip_vars = [];
                $($product).find('.variants-table .check-var').not(':checked').each(function () {
                    skip_vars.push($(this).closest('tr').attr('data-id'));
                });
                update_product_info({id: $product.attr('data-id'), disable_var_quantity_change: disable_var_quantity_change});
            }, 1000, "update_product_variations");
        });
        
        // load external images -->
        var a2w_external_images_page_size = 1000;
        
        function a2w_calc_external_images(on_load_calback){
            var data = {'action': 'a2w_calc_external_images', 'page_size': a2w_external_images_page_size};
            jQuery.post(ajaxurl, data).done(function (response) {
                var json = jQuery.parseJSON(response);
                
                var block_data = $('#a2w_load_external_image_block').data();
                
                on_load_calback(json.ids, block_data);
                
            }).fail(function (xhr, status, error) {
                console.log(error);
            });
        }
        
        
        var a2w_calc_external_images_calback = function (ids, block_data) {
            images_to_load = [];
            jQuery.each(ids, function (i, id) {
                images_to_load.push({'action': 'a2w_load_external_image', 'id': id});
            });
            
            var on_load = function (state) {
                $("#a2w_load_external_image_progress").html(sprintf(a2w_common_data.lang.process_loading_d_of_d_erros_d, block_data.ok+state.import_cnt, block_data.total, block_data.error+state.import_error_cnt));
                
                if ((state.import_cnt + state.import_error_cnt) === state.num_to_import) {
                    block_data.ok+=state.import_cnt;
                    block_data.error+=state.import_error_cnt;
                    
                    $('#a2w_load_external_image_block').data(block_data);
                    
                    if((block_data.ok + block_data.error)<block_data.total){
                        a2w_calc_external_images(a2w_calc_external_images_calback);
                    }else{
                        location.reload();    
                    }
                }
            };
            
            var state = {num_to_import: images_to_load.length, import_cnt: 0, import_error_cnt: 0};
            a2w_load_external_image(images_to_load, state, on_load);
        };
        
        function a2w_load_external_image(images_to_load, state, on_load) {
            if (images_to_load.length > 0) {
                var data = images_to_load.shift();

                jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    if (json.state !== 'ok') {
                        console.log(json);
                    }

                    if (json.state === 'error') {
                        state.import_error_cnt++;

                    } else {
                        state.import_cnt++;
                    }

                    if (on_load) {
                        on_load(state);
                    }

                    a2w_load_external_image(images_to_load, state, on_load);
                }).fail(function (xhr, status, error) {
                    console.log(error);
                    state.import_error_cnt++;

                    if (on_load) {
                        on_load(state);
                    }

                    a2w_load_external_image(images_to_load, state, on_load);
                });
            }
        }
        
        
        
        $('#a2w_load_external_image_block .load-images').click(function () {
            $('#a2w_load_external_image_block .load-images').attr('disabled','disabled');
            var block_data = $('#a2w_load_external_image_block').data();
            $("#a2w_load_external_image_progress").html(sprintf(a2w_common_data.lang.process_loading_d_of_d_erros_d, 0, block_data.total, 0));
            a2w_calc_external_images(a2w_calc_external_images_calback);
        });
        
        $('.set-category-dialog .modal-footer .btn').click(function () {
            if($(this).hasClass('no-btn')){
                $(this).parents(".modal-overlay").fadeOut(200);
            }else if($(this).hasClass('yes-btn')){
                var new_categories = $(this).parents(".modal-overlay").find('.categories').val();
                var link_type = $(this).parents(".modal-overlay").find('.categories').attr('data-link-type');
                
                if(new_categories){
                    if(link_type === 'all'){
                        var ids = 'all';
                        $('.a2w-product-import-list .product select.categories').each(function () {
                            $(this).val(new_categories).trigger('change');
                        });
                    }else{
                        var ids = [];
                        $('.a2w-product-import-list .select :checkbox:checked:not(:disabled)').each(function () {
                            $(this).parents('.product').find('select.categories').val(new_categories).trigger('change');
                            ids.push($(this).val());
                        });
                    }
                    
                    jQuery.post(ajaxurl, {'action': 'a2w_link_to_category', 'categories': new_categories, 'ids': ids}).fail(function (xhr, status, error) {console.log(error);});
                }
                $(this).parents(".modal-overlay").fadeOut(200);
            }
            return false;
        });
        
        // init load button
        if($("#a2w_use_external_image_urls").length>0 && !$("#a2w_use_external_image_urls").is(':checked')){
            $('#a2w_load_external_image_block').data({total:0, ok:0, error:0});
            var data = {'action': 'a2w_calc_external_images_count'};
            jQuery.post(ajaxurl, data).done(function (response) {
                var json = jQuery.parseJSON(response);

                $('#a2w_load_external_image_block').data({total:json.total_images, ok:0, error:0});
                if(json.total_images>0){
                    $('#a2w_load_external_image_block .load-images').removeAttr('disabled');
                    $('#a2w_load_external_image_block .load-images').val(sprintf(a2w_common_data.lang.load_button_text, json.total_images));
                }else{
                    $("#a2w_load_external_image_progress").html(a2w_common_data.lang.all_images_loaded_text);
                }

            }).fail(function (xhr, status, error) {
                console.log(error);
            });
        }
        // <-- load external images
        
        $( '#a2w-import-filter form select[name="o"]').change(function() {
            $(this).parents('form').submit();
        });
    });

})(jQuery, window, document);


