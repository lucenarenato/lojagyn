jQuery.fn.viwcaio_get_variations = function (params) {
    new viwcaio_get_variation(this, params);
    return this;
};
var viwcaio_get_variation = function (form, params) {
    let self = this;
    self.wc_ajax_url = params.wc_ajax_url || '';
    self.form = form;
    self.product_id = parseInt(form.data('product_id'));
    self.variations = form.data('product_variations') || '';
    self.is_ajax = !self.variations;
    self.xhr = false;
    let attribute = {};
    form.on('viwcaio_check_variations',{ viwcaio_get_variation: self },self.find_variation);
    form.on('change','select',{ viwcaio_get_variation: self }, self.onChange);
    form.find('select').each(function () {
        attribute[jQuery(this).data('attribute_name')] = jQuery(this).val()||'';
    });
    self.current_attr = attribute;
    setTimeout(function () {
        form.trigger('viwcaio_check_variations');
    }, 100);
};
viwcaio_get_variation.prototype.onChange = function(event){
    let self = event.data.viwcaio_get_variation;
    let form = self.form;
    form.find( 'input[name="variation_id"], input.variation_id' ).val( '' ).trigger( 'change' );
    self.current_attr[jQuery(this).data('attribute_name')] = jQuery(this).val()||'';
    if (self.is_ajax){
        form.trigger('viwcaio_check_variations');
    }else {
        form.trigger('woocommerce_variation_select_change');
        form.trigger('viwcaio_check_variations');
    }
    form.trigger('woocommerce_variation_has_changed');
};
viwcaio_get_variation.prototype.find_variation = function (event) {
    let self = event.data.viwcaio_get_variation, variation=null, is_stop = false;
    let attrs = self.current_attr,
        form = self.form,
        variations = self.variations;
    jQuery.each(attrs, function (k, v) {
        if (!v) {
            is_stop = true;
            return false;
        }
    });
    if (is_stop) {
        self.update_attributes(attrs, variations, form,self);
        self.show_variation(self, null, form);
        return false;
    }
    if (self.is_ajax) {
        if (self.xhr) {
            self.xhr.abort();
        }
        if (variations) {
            jQuery.each(variations, function (key, value) {
                if (self.check_is_equal(attrs, value.attributes )) {
                    variation = value;
                    return false;
                }
            });
            if (variation) {
                self.show_variation(self, variation, form);
            } else {
                if (variations.length < parseInt(form.data('variation_count') || 0)) {
                    self.call_ajax(attrs, variations, form, self);
                } else {
                    self.show_variation(self, null, form);
                }
            }
        } else {
            variations = [];
            self.call_ajax(attrs, variations, form, self);
        }
    } else {
        jQuery.each(variations, function (key, value) {
            if (self.check_is_equal(attrs, value.attributes )) {
                variation = value;
                return false;
            }
        });
        self.update_attributes(attrs, variations, form,self);
        self.show_variation(self, variation, form);
    }
};
viwcaio_get_variation.prototype.update_attributes = function (attrs, variations, form, self) {
    if ( self.is_ajax ) {
        return false;
    }
    form.find('select').each( function( k,v ) {
        let current_select     = jQuery( v );
        let current_name       = current_select.data( 'attribute_name' ) || current_select.attr( 'name' ),
            show_option_none        = current_select.data( 'show_option_none' ),
            current_val = current_select.val() || '',
            current_val_valid =  true,
            new_select = jQuery( '<select/>' ),
            attached_options_count,
            option_gt_filter        = ':gt(0)';

        // Reference options set at first.
        if ( ! current_select.data( 'attribute_html' ) ) {
            let refSelect = current_select.clone();
            refSelect.find( 'option' ).removeAttr( 'disabled attached selected' );
            // Legacy data attribute.
            current_select.data('attribute_options', refSelect.find( 'option' + option_gt_filter ).get());
            current_select.data( 'attribute_html', refSelect.html() );
        }

        new_select.html( current_select.data( 'attribute_html' ) );

        // The attribute of this select field should not be taken into account when calculating its matching variations:
        // The constraints of this attribute are shaped by the values of the other attributes.
        let checkAttributes = jQuery.extend( true, {}, attrs );
        checkAttributes[ current_name ] = '';
        let match_variations = [];
        for ( let i = 0; i < variations.length; i++ ) {
            let match = variations[i];
            if ( self.check_is_equal(checkAttributes, match.attributes ) ) {
                match_variations.push( match );
            }
        }
        // Loop through variations.
        for ( let num in match_variations ) {
            if ( typeof( match_variations[ num ] ) === 'undefined' ) {
                continue;
            }
            let variationAttributes = match_variations[ num ].attributes;

            for ( let attr_name in variationAttributes ) {
                if ( ! variationAttributes.hasOwnProperty( attr_name ) ) {
                    continue;
                }
                let attr_val         = variationAttributes[ attr_name ],
                    variation_active = '';

                if ( attr_name === current_name ) {
                    if ( match_variations[ num ].variation_is_active ) {
                        variation_active = 'enabled';
                    }
                    if ( attr_val ) {
                        // Decode entities.
                        attr_val = jQuery( '<div/>' ).html( attr_val ).text();
                        // Attach to matching options by value. This is done to compare
                        // TEXT values rather than any HTML entities.
                        let $option_elements = new_select.find( 'option' );
                        if ( $option_elements.length ) {
                            for (let i = 0, len = $option_elements.length; i < len; i++) {
                                let $option_element = jQuery( $option_elements[i] );
                                let    option_value = $option_element.val();

                                if ( attr_val === option_value ) {
                                    $option_element.addClass( 'attached ' + variation_active );
                                    break;
                                }
                            }
                        }
                    } else {
                        // Attach all apart from placeholder.
                        new_select.find( 'option:gt(0)' ).addClass( 'attached ' + variation_active );
                    }
                }

            }

        }

        // Count available options.
        attached_options_count = new_select.find( 'option.attached' ).length;
        // Check if current selection is in attached options.
        if ( current_val ) {
            current_val_valid = false;

            if ( 0 !== attached_options_count ) {
                new_select.find( 'option.attached.enabled' ).each( function() {
                    var option_value = jQuery( this ).val();

                    if ( current_val === option_value ) {
                        current_val_valid = true;
                        return false; // break.
                    }
                });
            }
        }

        // Detach the placeholder if:
        // - Valid options exist.
        // - The current selection is non-empty.
        // - The current selection is valid.
        // - Placeholders are not set to be permanently visible.
        if ( attached_options_count > 0 && current_val && current_val_valid && ( 'no' === show_option_none ) ) {
            new_select.find( 'option:first' ).remove();
            option_gt_filter = '';
        }

        // Detach unattached.
        new_select.find( 'option' + option_gt_filter + ':not(.attached)' ).remove();

        // Finally, copy to DOM and set value.
        current_select.html( new_select.html() );
        current_select.find( 'option' + option_gt_filter + ':not(.enabled)' ).prop( 'disabled', true );

        // Choose selected value.
        if ( current_val ) {
            // If the previously selected value is no longer available, fall back to the placeholder (it's going to be there).
            if ( current_val_valid ) {
                current_select.val( current_val );
            } else {
                current_select.val( '' ).change();
            }
        } else {
            current_select.val( '' ); // No change event to prevent infinite loop.
        }
    });
    // Custom event for when variations have been updated.
    form.trigger( 'woocommerce_update_variation_values' );
};
viwcaio_get_variation.prototype.call_ajax = function (attrs, variations, form, self) {
    attrs.product_id = self.product_id;
    self.xhr = jQuery.ajax({
        url: self.wc_ajax_url.toString().replace('%%endpoint%%', 'get_variation'),
        type: 'POST',
        data: attrs,
        beforeSend: function () {
            form.closest('.vi-wcaio-va-cart-form-wrap').addClass('vi-wcaio-container-loading');
        },
        success: function (result) {
            self.show_variation(self, result, form);
            if (result) {
                variations[variations.length || 0] = result;
            }
            delete attrs.product_id;
        },
        complete: function () {
            form.closest('.vi-wcaio-va-cart-form-wrap').removeClass('vi-wcaio-container-loading');
        }
    });
};
viwcaio_get_variation.prototype.show_variation = function (self, variation, form) {
    if (variation) {
        let purchasable = true;
        if ( ! variation.is_purchasable || ! variation.is_in_stock || ! variation.variation_is_visible ) {
            purchasable = false;
        }
        if (purchasable) {
            self.set_add_to_cart(variation.variation_id, form);
            form.find('.vi-wcaio-product-bt-atc').removeClass('vi-wcaio-button-swatches-disable');
        } else {
            self.set_add_to_cart('', form);
            form.find('.vi-wcaio-product-bt-atc').addClass('vi-wcaio-button-swatches-disable');
        }
        form.trigger('viwpvs_show_variation',[ variation, purchasable ]);
    } else {
        self.set_add_to_cart('', form);
        form.find('.vi-wcaio-product-bt-atc').addClass('vi-wcaio-button-swatches-disable');
        form.trigger('viwpvs_hide_variation');
    }
};
viwcaio_get_variation.prototype.set_add_to_cart = function (variation_id, form) {
    variation_id = variation_id || 0;
    form.find('.variation_id').val(variation_id);
};
viwcaio_get_variation.prototype.check_is_equal = function (attrs1, attrs2) {
    let aProps = Object.getOwnPropertyNames(attrs1),
        bProps = Object.getOwnPropertyNames(attrs2);
    if (aProps.length !== bProps.length) {
        return false;
    }
    for (let i = 0; i < aProps.length; i++) {
        let attr_name = aProps[i];
        let val1 = attrs1[ attr_name ];
        let val2 = attrs2[ attr_name ];
        if ( val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
            return false;
        }
    }
    return true;
};