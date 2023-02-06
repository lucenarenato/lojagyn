<?php
$a2w_local_currency = strtoupper(a2w_get_setting('local_currency'));
?>
<form method="post" enctype='multipart/form-data'>
    <input type="hidden" name="setting_form" value="1"/>
    <div class="panel panel-primary mt20">
        <div class="panel-heading">
            <h3 class="display-inline"><?php _ex('Shipping settings', 'Setting title', 'ali2woo'); ?></h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Use Aliexpress Shipping', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Show the shipping drop-down selection in Frontend (Cart, Checkout and Order page)', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-8">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control small-input" id="a2w_aliship_frontend" name="a2w_aliship_frontend" <?php if (a2w_get_setting('aliship_frontend')): ?>value="yes" checked<?php endif; ?> />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Default Shipping Country', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Set the Default option for Country drop-down selection in Frontend (Cart and Checkout pages)', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-8">
                    <?php $cur_a2w_aliship_shipto = a2w_get_setting('aliship_shipto'); ?>
                    <div class="form-group input-block no-margin">
                        <select name="a2w_aliship_shipto" id="a2w_aliship_shipto" <?php if (!a2w_get_setting('aliship_frontend')): ?>disabled<?php endif; ?>>
                            <?php foreach ($shipping_countries as $country): ?>
                                <option value="<?php echo $country['c']; ?>"<?php if ($cur_a2w_aliship_shipto == $country['c']): ?> selected<?php endif; ?>>
                                    <?php echo $country['n']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>



        </div> 
    </div>
    <div class="global-pricing mt20"> 
        <div class="panel panel-primary mt20">
            <div class="panel-heading">
                <h3 class="display-inline"><?php _ex('Global shipping rules', 'Setting title', 'ali2woo'); ?><div class="info-box" data-placement="left" data-toggle="tooltip" title="<?php _ex('Please note that you can disable Global rules for specific shipping methods if needed. Just go to "Shipping List" page, then choose "specific method" and set  "Enable price rule" to "no".', 'Setting tip', 'ali2woo'); ?>"></div></h3>
            </div>

            <div class="panel-body js-default-prices">
                <div class="row">

                    <div class="col-sm-1 vertical-align">   
                        <svg class="icon-pricechanged">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-pricechanged"></use>
                        </svg>

                    </div>


                    <div class="col-sm-2 vertical-align">
                        <h3>Shipping cost</h3>
                    </div>

                    <div class="col-sm-1 vertical-align">
                        <svg class="sign <?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus <?php endif; ?><?php if ($default_formula->sign == '*'): ?>icon-rotate45<?php endif; ?> <?php if ($default_formula->sign == '='): ?>icon-equal<?php endif; ?>">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus<?php else: ?>icon-equal<?php endif; ?>"></use>

                        </svg> 
                    </div>
                    <div class="col-sm-3 col-md-3 vertical-align">
                        <div class="input-group price-dropdown-group">
                            <input name="default_rule[sign]" type="hidden" value="<?php echo $default_formula->sign; ?>">
                            <input name="default_rule[value]" type="text" class="form-control value" value="<?php echo $default_formula->value; ?>" <?php if (!a2w_get_setting('aliship_frontend')): ?> disabled <?php endif; ?>>

                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php if (!a2w_get_setting('aliship_frontend')): ?> disabled <?php endif; ?>>
                                    <?php if ($default_formula->sign == '+'): ?>Fixed Markup<?php endif; ?>
                                    <?php if ($default_formula->sign == '='): ?>Custom Price<?php endif; ?>   
                                    <?php if ($default_formula->sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right sign">
                                    <li data-sign = "+" <?php if ($default_formula->sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                    <li data-sign = "=" <?php if ($default_formula->sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                    <li data-sign = "*" <?php if ($default_formula->sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                    <div class="col-sm-1 vertical-align">
                        <svg class="icon-full-arrow-right">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-full-arrow-right"></use>
                        </svg>
                    </div>
                    <div class="col-sm-2 vertical-align">
                        <h3 style="width: 135px;">Shipping price</h3>
                    </div>
                    <div class="col-sm-1 vertical-align">                
                        <div class="info-box" data-placement="left" data-toggle="tooltip" title="Todo"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>   
    <div class="row pt20">
        <div class="col-sm-12">
            <input class="btn btn-success" type="submit" value="<?php _e('Save settings', 'ali2woo'); ?>"/>
        </div>
    </div>

</form>

<script>
    function a2w_isInt(value) {
        return !isNaN(value) &&
                parseInt(Number(value)) == value &&
                !isNaN(parseInt(value, 10));
    }

    (function ($) {

        function get_el_sign_value(el) {
            return el.children('li')
                    .filter(function () {
                        return $(this).css('display') === 'none'
                    })
                    .attr('data-sign');
        }

        function get_value(compared) {
            var s_class = 'compared_value';
            if (typeof compared == "undefined")
                s_class = 'value';

            return $('.js-default-prices .' + s_class).val();
        }

        function rule_info_box_calculation(str_tmpl, sign, value) {

            var def_value = 1, result = value;
            if (sign == "+")
                result = def_value + Number(value);
            if (sign == "*")
                result = def_value * Number(value);

            return sprintf(str_tmpl, def_value, result, def_value, sign, value, result)

        }

        function check_prices() {
            return true;
        }
        /* 
         function save_prices(){
         if (check_prices()) {
         var data = {'action': 'a2w_update_price_rules',
         'use_extended_price_markup': use_extended_price_markup ? 'yes' : 'no',
         'use_compared_price_markup': use_compared ? 'yes' : 'no',
         'cents': $('#cb-set-cents').is(":checked") ? $('#set-cents').val() : -1,
         'compared_cents': $('#cb-compared-set-cents').is(":checked") ? $('#compared-set-cents').val() : -1,
         'default_rule': {'value': get_value(),
         'sign': get_el_sign_value($('.js-default-prices ul.sign')),
         'compared_value': get_value(true),
         'compared_sign': get_el_sign_value($('.js-default-prices ul.compared_sign'))}};
         jQuery.post(ajaxurl, data).done(function (response) {
         show_notification('Saved successfully.');
         var json = jQuery.parseJSON(response);
         
         settings_changed = false;
         $('a.apply-pricing-rules').show();
         $('a.apply-pricing-rules').prev().hide();
         
         }).fail(function (xhr, status, error) {
         show_notification('Save failed.', true);
         });
         }    
         }*/

        $('[data-toggle="tooltip"]').tooltip({"placement": "top"});

        //info content 
        $(".js-default-prices div.info-box").on("mouseover", function () {
            $(this).attr('title', rule_info_box_calculation("E.g., A product shipping that costs %d <?php echo $a2w_local_currency; ?> would have its price set to %d <?php echo $a2w_local_currency; ?> (%d %s %d = %d).", get_el_sign_value($('.js-default-prices ul.sign')), get_value()));
            $(this).tooltip('fixTitle').tooltip('show');
        });



        //default rule dropdown

        $(".global-pricing .dropdown").on("click", function () {
            $(this).next().slideToggle();
        });
        $(".global-pricing .dropdown-menu li").click("click", function (e) {
            e.preventDefault();
            $(this).trigger('change');
            var sign = $(this).attr('data-sign'),
                    svg = $(this).closest('.input-group').prev('svg'),
                    svg = svg.length > 0 ? svg : $(this).closest('td').prev('td').find("svg"),
                    svg = svg.length > 0 ? svg : $(this).closest('.row').find('svg.sign');

            $('input[name="default_rule[sign]"]').val(sign);

            if (sign == '=') {
                svg.removeClass('icon-equal icon-plus icon-rotate45').addClass('icon-equal');
                svg.children('use').attr('xlink:href', '#icon-equal');
            }
            else if (sign == '*') {
                svg.removeClass('icon-equal icon-plus icon-rotate45').addClass('icon-plus icon-rotate45');
                svg.children('use').attr('xlink:href', '#icon-plus');
            }
            else if (sign == '+') {
                svg.removeClass('icon-equal icon-plus icon-rotate45').addClass('icon-plus');
                svg.children('use').attr('xlink:href', '#icon-plus');
            }

            $(this).hide().siblings().each(function () {
                $(this).show()
            });
            $(this).parent().fadeOut().prev().html($(this).text());
        });

        $('.a2w-content form').on('submit', function () {
            if ($(this).find('.has-error').length > 0)
                return false;
        });

        $("#a2w_aliship_frontend").change(function () {

            $(".global-pricing .dropdown-menu li").trigger('click');

            var checked_status = !$(this).is(':checked');
            $("#a2w_aliship_shipto").prop('disabled', checked_status);

            $(".global-pricing").find('input').each(function () {
                $(this).prop('disabled', checked_status);
            });

            $(".global-pricing").find('button').each(function () {
                $(this).prop('disabled', checked_status);
            });
            return true;
        });

    })(jQuery);




</script>