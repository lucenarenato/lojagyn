<?php
$a2w_use_extended_price_markup = a2w_get_setting('use_extended_price_markup');
$a2w_use_compared_price_markup = a2w_get_setting('use_compared_price_markup');
$a2w_local_currency = strtoupper(a2w_get_setting('local_currency'));
?>

<div class="global-pricing mt20">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Global pricing rules</h3>
            <span class="pull-right">
            <a class="disabled" style="display: none;">You have unsaved changes</a>
            <a href="#" class="apply-pricing-rules btn">Apply pricing rules to existing products</a></span>
        </div>


        <div class="panel-body p20 border-bottom js-default-prices"  <?php if ($a2w_use_extended_price_markup): ?>style="display: none;" <?php else: ?>style="display: block;"<?php endif; ?>>

            <div class="row pb20 border-bottom">

                <div class="col-sm-1 vertical-align">   
                    <svg class="icon-pricechanged">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-pricechanged"></use>
                    </svg>

                </div>


                <div class="col-sm-2 vertical-align">
                    <h3>Product cost</h3>
                </div>

                <div class="col-sm-1 vertical-align">
                    <svg class="sign <?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus <?php endif;?><?php if ($default_formula->sign == '*'): ?>icon-rotate45<?php endif;?> <?php if ($default_formula->sign == '='): ?>icon-equal<?php endif;?>">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus<?php else:?>icon-equal<?php endif; ?>"></use>
                    </svg> 
                </div>
                <div class="col-sm-3 col-md-3 vertical-align">
                    <div class="input-group price-dropdown-group">
                        <input type="text" class="form-control value" value="<?php echo $default_formula->value; ?>">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <h3 style="width: 135px;">Product price</h3>
                </div>
                <div class="col-sm-1 vertical-align">                
                    <div class="info-box" data-placement="left" data-toggle="tooltip" title=""></div>
                </div>

            </div>

            <div class="row pt20 compared">
                <div class="col-sm-1 vertical-align">   
                    <div class="price-rulle-toggle <?php if (!$a2w_use_compared_price_markup): ?>price-rulle-toggle--disabled<?php endif; ?>"></div>
                </div>

                <div class="col-sm-10 vertical-align switch-col" <?php if ($a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <span class="grey-color" style="">Set your compared at pricing rules</span>
                </div> 
                <div class="col-sm-2 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <h3>Product cost</h3>
                </div>                            
                <div class="col-sm-1 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <svg class="sign <?php if ($default_formula->compared_sign == '+' || $default_formula->compared_sign == '*'): ?>icon-plus <?php endif;?><?php if ($default_formula->compared_sign == '*'): ?>icon-rotate45<?php endif;?> <?php if ($default_formula->compared_sign == '='): ?>icon-equal<?php endif;?>">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?php if ($default_formula->compared_sign == '+' || $default_formula->compared_sign == '*'): ?>icon-plus<?php else:?>icon-equal<?php endif; ?>"></use>
                    </svg>
                </div>
                <div class="col-sm-3 col-md-3 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <div class="input-group price-dropdown-group">

                        <input type="text" value="<?php echo $default_formula->compared_value; ?>" class="form-control compared_value">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if ($default_formula->compared_sign == '+'): ?>Fixed Markup<?php endif; ?>
                                <?php if ($default_formula->compared_sign == '='): ?>Custom Price<?php endif; ?>   
                                <?php if ($default_formula->compared_sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right compared_sign">
                                <li data-sign = "+" <?php if ($default_formula->compared_sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                <li data-sign = "=" <?php if ($default_formula->compared_sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                <li data-sign = "*" <?php if ($default_formula->compared_sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                            </ul>
                        </div><!-- /btn-group -->
                    </div>
                </div>
                <div class="col-sm-1 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <svg class="icon-full-arrow-right">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-full-arrow-right"></use>
                    </svg>
                </div>
                <div class="col-sm-2 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <h3 style="width: 135px;">Compared at price</h3>
                </div>
                <div class="col-sm-1 vertical-align switch-col" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                    <div class="info-box" data-toggle="tooltip" data-placement="left" title=""></div><span class="grey-color" style="display:none;">Set your compared at pricing rules</span>
                </div>

            </div>
        </div>
        <div class="p20 extended_prices">
            <div class="container-flex">
                <div class="price-rulle-toggle <?php if (!$a2w_use_extended_price_markup): ?>price-rulle-toggle--disabled<?php endif; ?>"></div>
                <div>
                    <h3 style="margin: 0; line-height: 24px;">Advanced pricing rules</h3>
                    <div class="grey-color">Set your product markup depending on cost ranges.</div>
                </div>
            </div>
            <div class="js-advanced-prices mt20" <?php if (!$a2w_use_extended_price_markup): ?>style="display: none;" <?php else: ?>style="display: block;"<?php endif; ?>>

                <div class="table-responsive">
                    <table class="border">
                        <thead>
                            <tr class="border-bottom">
                                <th colspan="4" width="50%">Cost range</th>
                                <th width="25%">Markup</th>
                                <th width="25%" style="white-space: nowrap;">
                                    <input class="use_compared_price_markup" type="checkbox" <?php if ($a2w_use_compared_price_markup): ?>checked="checked"<?php endif; ?>><span>Compared at price markup</span>
                                </th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($formulas as $ind => $formula): ?>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="input-group">        
                                            <input type="text" class="form-control min_price" value="<?php echo $formula->min_price; ?>"><span class="input-group-addon"> <?php echo $a2w_local_currency;?> </span>
                                        </div>
                                    </td>
                                    <td>-</td>
                                    <td>
                                        <div class="input-group">        
                                            <input type="text" class="form-control max_price" value="<?php echo $formula->max_price; ?>"><span class="input-group-addon"> <?php echo $a2w_local_currency;?> </span>
                                        </div>
                                    </td>
                                    <td>
                                        <svg class="<?php if ($formula->sign == '+' || $formula->sign == '*'): ?>icon-plus <?php endif;?><?php if ($formula->sign == '*'): ?>icon-rotate45<?php endif;?> <?php if ($formula->sign == '='): ?>icon-equal<?php endif;?>">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?php if ($formula->sign == '+' || $formula->sign == '*'): ?>icon-plus<?php else:?>icon-equal<?php endif; ?>"></use>
                                        </svg>
                                    </td>

                                    <td>
                                        <div class="input-group price-dropdown-group">
                                            <input type="text" class="form-control value" value="<?php echo $formula->value; ?>">

                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php if ($formula->sign == '+'): ?>Fixed Markup<?php endif; ?>
                                                    <?php if ($formula->sign == '='): ?>Custom Price<?php endif; ?>   
                                                    <?php if ($formula->sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right sign">
                                                    <li data-sign = "+" <?php if ($formula->sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                                    <li data-sign = "=" <?php if ($formula->sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                                    <li data-sign = "*" <?php if ($formula->sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                                                </ul>
                                            </div><!-- /btn-group -->
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group price-dropdown-group <?php if (!$a2w_use_compared_price_markup): ?>visually-hidden<?php endif; ?>">
                                            <input type="text" class="form-control compared_value" value="<?php echo $formula->compared_value; ?>">

                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php if ($formula->compared_sign == '+'): ?>Fixed Markup<?php endif; ?>
                                                    <?php if ($formula->compared_sign == '='): ?>Custom Price<?php endif; ?>   
                                                    <?php if ($formula->compared_sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right compared_sign">
                                                    <li data-sign = "+" <?php if ($formula->compared_sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                                    <li data-sign = "=" <?php if ($formula->compared_sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                                    <li data-sign = "*" <?php if ($formula->compared_sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                                                </ul>
                                            </div><!-- /btn-group -->
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn--transparent delete" <?php if ($ind === count($formulas) - 1) : ?> style="display:none;" <?php endif; ?>>
                                            <svg class="icon-cross">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cross"></use>
                                            </svg>
                                        </button>             
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-bottom">
                                <td colspan="3">
                                    <div class="container-flex jc-sb panel__message">
                                        <div>Rest of the price ranges</div>
                                        <div class="info-box" data-toggle="tooltip" title="These markups will be used for the rest of the price ranges"></div>
                                    </div>
                                </td>
                                <td>
                                     <svg class="sign <?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus <?php endif;?><?php if ($default_formula->sign == '*'): ?>icon-rotate45<?php endif;?> <?php if ($default_formula->sign == '='): ?>icon-equal<?php endif;?>">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?php if ($default_formula->sign == '+' || $default_formula->sign == '*'): ?>icon-plus<?php else:?>icon-equal<?php endif; ?>"></use>
                                     </svg> 
                                </td>

                                <td>
                                    <div class="input-group price-dropdown-group">
                                        <input type="text" class="form-control default_value" value="<?php echo $default_formula->value; ?>">

                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php if ($default_formula->sign == '+'): ?>Fixed Markup<?php endif; ?>
                                                <?php if ($default_formula->sign == '='): ?>Custom Price<?php endif; ?>   
                                                <?php if ($default_formula->sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right default_sign">
                                                <li data-sign = "+" <?php if ($default_formula->sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                                <li data-sign = "=" <?php if ($default_formula->sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                                <li data-sign = "*" <?php if ($default_formula->sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                                            </ul>
                                        </div><!-- /btn-group -->
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group price-dropdown-group <?php if (!$a2w_use_compared_price_markup): ?>visually-hidden<?php endif; ?>">
                                        <input type="text" value="<?php echo $default_formula->compared_value; ?>" class="form-control default_compared_value">

                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php if ($default_formula->compared_sign == '+'): ?>Fixed Markup<?php endif; ?>
                                                <?php if ($default_formula->compared_sign == '='): ?>Custom Price<?php endif; ?>   
                                                <?php if ($default_formula->compared_sign == '*'): ?>Multiplier<?php endif; ?>  <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right default_compared_sign">
                                                <li data-sign = "+" <?php if ($default_formula->compared_sign == '+'): ?>style="display: none;"<?php endif; ?>><a>Fixed Markup</a></li>
                                                <li data-sign = "=" <?php if ($default_formula->compared_sign == '='): ?>style="display: none;"<?php endif; ?>><a>Custom Price</a></li>
                                                <li data-sign = "*" <?php if ($default_formula->compared_sign == '*'): ?>style="display: none;"<?php endif; ?>><a>Multiplier</a></li>
                                            </ul>
                                        </div><!-- /btn-group -->
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel small-padding margin-small-top panel-danger" style="display: none;"> 
                    <div class="panel-body"> 
                        <div class="container-flex flex-between"> 
                            <div class="container-flex"> 
                                <div class="svg-container no-shrink">   
                                    <svg class="icon-danger-circle margin-small-right"> 
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-danger-circle"></use> 
                                    </svg> 
                                </div> 
                                <div class="ml5 mr10">
                                    <div class="content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="assign-cents">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel__header-title">Assign cents</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="grey-color mb20">You can set a specific cent value for your retail price. We will use this value when forming the final price for your items (e.g., if you want the cost of your product to be XX.99 then add 99 to the fields below).</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="input-wrap">
                            <input type="checkbox" id="cb-set-cents" <?php if ($cents > -1) : ?> checked <?php endif; ?>>
                            <label for="cb-set-cents">Assign cents</label>
                            <input type="text" class="form-control small-input" id="set-cents"  <?php if ($cents > -1) : ?> value="<?php echo $cents; ?>" <?php else: ?> disabled="" <?php endif; ?>>
                        </div>    
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-10">
                        <div class="input-wrap" <?php if (!$a2w_use_compared_price_markup): ?>style="display:none;"<?php endif; ?>>
                            <input type="checkbox" id="cb-compared-set-cents" <?php if ($compared_cents > -1) : ?> checked <?php endif; ?>>
                            <label for="cb-compared-set-cents">Assign compared at cents</label>
                            <input type="text" class="form-control small-input" id="compared-set-cents" <?php if ($compared_cents > -1) : ?> value="<?php echo $compared_cents; ?>" <?php else: ?> disabled="" <?php endif; ?>>
                        </div>    
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>    
<div class="container-fluid">
    <div class="row pt20 border-top">
        <div class="col-sm-12">
            <input class="btn btn-success mt20" type="submit" id="save-price-rules" value="<?php _e('Save settings', 'ali2woo'); ?>"/>
        </div>
    </div>
</div>

<div class="modal-overlay modal-apply-pricing-rules">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Apply pricing rules to existing products</h3>
            <a class="modal-btn-close" href="#"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cross"></use></svg></a>
        </div>
        <div class="modal-body">
            <label>Select the update type</label>
            <div style="padding-bottom: 20px;">
                <div class="type btn-group" role="group">
                    <button type="button" class="btn btn-default" value="price">Prices</button>
                    <button type="button" class="btn btn-default" value="regular_price">Compared at Prices</button>
                    <button type="button" class="btn btn-default" value="all">Prices and Compared at Prices</button>
                </div>
            </div>
            <label>Select the update scope</label>
            <div>
                <div class="scope btn-group" role="group">
                    <button type="button" class="btn btn-default" value="shop">Shop</button>
                    <button type="button" class="btn btn-default" value="import">Import List</button>
                    <button type="button" class="btn btn-default" value="all">Shop and Import List</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default close-btn" type="button"><?php _e('Close'); ?></button>
            <button class="btn btn-success apply-btn" type="button"><div class="btn-icon-wrap cssload-container"><div class="cssload-speeding-wheel"></div></div><?php _e('Apply'); ?></button>
        </div>
    </div>
</div>



<script>
    jQuery(function ($) {
        $('[data-toggle="tooltip"]').tooltip({"placement": "left"});

        $(".apply-pricing-rules").on("click", function () {
            $(".modal-apply-pricing-rules .btn-group").each(function () {
                $(this).find('.btn').removeClass('btn-info').removeClass('active').addClass('btn-default');
                $(this).find('.btn:first').removeClass('btn-default').addClass('btn-info').addClass('active');
                $(this).data({value:$(this).find('.btn:first').val()});
            });
            $(".modal-apply-pricing-rules .apply-btn").removeAttr("disabled");
            $(".modal-apply-pricing-rules").fadeIn(400);
            return false;
        });

        $(".modal-apply-pricing-rules .close-btn").on("click", function () {
            $(".modal-apply-pricing-rules").fadeOut(400);
            return false;
        });
        
        function a2w_apply_pricing_rules(type, scope, page, on_done_calback){
            var data = {'action': 'a2w_apply_pricing_rules', 'type':type,'scope':scope, 'page':page};
            jQuery.post(ajaxurl, data).done(function (response) {
                var json = jQuery.parseJSON(response);
                if(json.state==='ok'){
                    if(json.done===0){
                        a2w_apply_pricing_rules(type, scope, page+1, on_done_calback);
                    }else{
                        if(on_done_calback){
                            on_done_calback(json.state, '');
                        }
                    }
                }else{
                    if(on_done_calback){
                        on_done_calback(json.state, json.message);
                    }
                }
            }).fail(function (xhr, status, error) {
                if(on_done_calback){
                    on_done_calback('error', 'Applying pricing rules failed.');
                }
            });
        }
        
        $(".modal-apply-pricing-rules .apply-btn").on("click", function () {
            var _this_btn = $(this);
            $(_this_btn).attr("disabled", true);
            
            var scope = $(".modal-apply-pricing-rules .btn-group.scope").data().value;
            var type = $(".modal-apply-pricing-rules .btn-group.type").data().value;
            
            var on_done_calback = function (state, message) {
                if(state!=='ok'){
                    show_notification(message, true);
                }else{
                    show_notification('Applying pricing rules to your existing products');
                    $(".modal-apply-pricing-rules").fadeOut(400);
                }
                $(_this_btn).removeAttr("disabled");
            };
            
            a2w_apply_pricing_rules(type, scope, 0, on_done_calback);
            
            return false;
        });
        
        $(".modal-apply-pricing-rules .btn-group .btn").on("click", function () {
            $(this).parents('.btn-group').find('.btn').removeClass('btn-info').removeClass('active').addClass('btn-default');
            $(this).removeClass('btn-default').addClass('btn-info').addClass('active');
            $(this).parents('.btn-group').data({value:$(this).val()});
        });
        

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

            // $(this).closest('.input-group').children('input[type="text"]').val(sign);

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

        //switch-buttons
        $(".price-rulle-toggle").first().on("click", function () {
            $(".js-advanced-prices input[type=checkbox]").trigger("click");
        });

        $(".price-rulle-toggle").eq(1).on("click", function () {
            $(this).trigger('change');
            $(this).toggleClass("price-rulle-toggle--disabled");
            $(".js-advanced-prices").slideToggle();
            $(".js-default-prices").slideToggle();
        });




        $(".js-advanced-prices input[type=checkbox]").on("click", function () {
            comparedPrice();
        })

        function comparedPrice() {
            $(".price-rulle-toggle").first().toggleClass("price-rulle-toggle--disabled");
            $(".price-rulle-toggle").first().parents('.row').find('.switch-col').toggle();
            $(".js-advanced-prices table tr").find("td:eq(-2) .input-group").toggleClass('visually-hidden');
            $(".input-wrap").has("input[id=compared-set-cents]").toggle();
            //$("#cb-compared-set-cents").trigger('click');
        }
        //assign-cents inputs
        $(".assign-cents input:checkbox").on("change", function () {
            if ($(this).is(":checked")) {
                $(this).siblings('input:text').prop("disabled", false);
            } else
                $(this).siblings('input:text').prop("disabled", true);
        });

        //our script begin here
        var settings_changed = false;

        $(".global-pricing").change(function () {
            if (!settings_changed) {
                settings_changed = true;

                $('a.apply-pricing-rules').hide();
                $('a.apply-pricing-rules').prev().show(); 

            }
        });


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

        function check_price_rules() {
            var num_check = true;
            var min_max_check = true;
            var ranges_check = true;

            var price_ranges = [];

            $('.js-advanced-prices table tbody .max_price').each(function () {
                if (isNaN($(this).val()) || isNaN($(this).parents('tr').find('.min_price').val())) {
                    num_check = false;
                } else {
                    if (parseFloat($(this).val()) <= parseFloat($(this).parents('tr').find('.min_price').val())) {
                        min_max_check = false;
                    }
                }

                if (num_check && !isNaN(parseFloat($(this).val())) && !isNaN(parseFloat($(this).parents('tr').find('.min_price').val()))) {
                    price_ranges.push({'min_price': parseFloat($(this).parents('tr').find('.min_price').val()), 'max_price': parseFloat($(this).val())});
                }
            });

            for (var i = 0; i < price_ranges.length; i++) {
                for (var j = 1; j < price_ranges.length; j++) {
                    if (i !== j && ((price_ranges[j].min_price <= price_ranges[i].max_price && price_ranges[i].max_price <= price_ranges[j].max_price) || (price_ranges[j].min_price <= price_ranges[i].min_price && price_ranges[i].min_price <= price_ranges[j].max_price))) {
                        ranges_check = false;
                        break;
                    }
                }
                if (!ranges_check) {
                    break;
                }
            }

            $('.panel-danger').hide();
            if (!num_check) {
                $('.panel-danger .content').html('Cost value must be a number.');
                $('.panel-danger').show();
            }
            if (!min_max_check) {
                $('.panel-danger .content').html('Cost range end value must be greater than the starting value.');
                $('.panel-danger').show();
            }
            if (!ranges_check) {
                $('.panel-danger .content').html('Your ranges overlap.');
                $('.panel-danger').show();
            }

            return num_check && min_max_check && ranges_check;
        }

        function isInt(value) {
            return !isNaN(value) &&
                    parseInt(Number(value)) == value &&
                    !isNaN(parseInt(value, 10));
        }

        function check_cents() {

            function check_cents_range(el) {
                var check = true;

                if (!isInt(el.val()) || el.val() < 0 || el.val() > 99) {
                    el.addClass('has-error');
                    check = false;
                }

                return check;
            }

            var ranges_check1 = true, ranges_check2 = true;

            if ($('#cb-compared-set-cents').is(":checked")) {
                ranges_check1 = check_cents_range($('#compared-set-cents'));
            }

            if ($('#cb-set-cents').is(":checked")) {
                ranges_check2 = check_cents_range($('#set-cents'));
            }

            if (!ranges_check1 || !ranges_check2)
                show_notification('Assign cents field value should be an integer between 1 and 99', true);

            return ranges_check1 && ranges_check2;
        }

        function set_last_rule_row_enability(show) {
            var row = $('.js-advanced-prices table tbody tr:last-child'),
                    td4 = row.find('td:eq(4)'), td5 = row.find('td:eq(5)');

            if (show) {
                td4.children('.input-group').removeClass('opacity50');
                td5.children('.input-group').removeClass('opacity50');

                td4.find('input[type="text"]').prop('disabled', false);
                td5.find('input[type="text"]').prop('disabled', false);

                td4.find('button').prop('disabled', false);
                td5.find('button').prop('disabled', false);
            } else {
                td4.children('.input-group').removeClass('opacity50').addClass('opacity50');
                td5.children('.input-group').removeClass('opacity50').addClass('opacity50');

                td4.find('input[type="text"]').prop('disabled', true);
                td5.find('input[type="text"]').prop('disabled', true);

                td4.find('button').prop('disabled', true);
                td5.find('button').prop('disabled', true);
            }


        }

        function add_rule_row(this_row) {

            var row = $(this_row).parents('table').find("tbody tr:last-child"), new_row = row.clone();

            new_row.find('.min_price').val(parseFloat($(this_row).find('.max_price').val()) + 0.01);
            new_row.find('.max_price').val('');
            new_row.find('.delete').hide();

            set_last_rule_row_enability(true);
            $('.js-advanced-prices table tbody').append(new_row);
            set_last_rule_row_enability(false);

            row.find('.delete').show();

        }

        set_last_rule_row_enability(false);

        var price_rule_keyup_timer = false;

        //rule table interactive
        $('.js-advanced-prices table').on('keyup', 'input[type="text"]', function () {
            var this_row = $(this).parents('tr');
            if (price_rule_keyup_timer) {
                clearTimeout(price_rule_keyup_timer);
            }
            price_rule_keyup_timer = setTimeout(function () {
                if (check_price_rules() && parseFloat($(this_row).parents('table').find("tbody tr:last-child .max_price").val()) > 0) {
                    /*   var row = $(this_row).parents('table').find("tbody tr:last-child"), new_row = row.clone();
                     
                     new_row.find('.min_price').val( parseFloat($(this_row).find('.max_price').val()) + 0.01 );
                     new_row.find('.max_price').val('');
                     new_row.find('.delete').hide();  */

                    add_rule_row(this_row);

                    //  row.find('.delete').show();
                }
            }, 1000);

            //$(this).removeClass('error_input');
        });

        $('.js-advanced-prices table').on('click', '.delete', function () {
            if ($(this).parents('tr').is(":first-child") && $(this).parents('tbody').find('tr').length < 3) {
                //first action: hide price markup
                $('.price-rulle-toggle').click()
            } else if ($(this).parents('tr').is(":last-child")) {
                //last action must be empty
            } else {
                $(this).trigger('change');
                $(this).parents('tr').remove();
            }
            return false;
        });

        //info content 
        $(".js-default-prices div.info-box").on("mouseover", function () {
            $(this).attr('title', rule_info_box_calculation("E.g., A product that costs %d <?php echo $a2w_local_currency;?> would have its price set to %d <?php echo $a2w_local_currency;?> (%d %s %d = %d).", get_el_sign_value($('.js-default-prices ul.sign')), get_value()));
            $(this).tooltip('fixTitle').tooltip('show');
        });

        $(".js-default-prices .compared div.info-box").on("mouseover", function () {
            $(this).attr('title', rule_info_box_calculation("If you import a product that costs %d <?php echo $a2w_local_currency;?>, we'll set its compared at price to %d <?php echo $a2w_local_currency;?> (%d %s %d = %d).", get_el_sign_value($('.js-default-prices ul.compared_sign')), get_value(true)));
            $(this).tooltip('fixTitle').tooltip('show');
        });


        //save rules  
        $("#save-price-rules").click(function () {
            var use_extended_price_markup = !$('.extended_prices .price-rulle-toggle').hasClass('price-rulle-toggle--disabled');



            $('.input-group.has-error, input.has-error').each(function () {
                $(this).removeClass('has-error');
            });

            if (use_extended_price_markup) {

                if (check_price_rules()) {

                    if (parseFloat($(".js-advanced-prices table tbody tr:last-child .max_price").val()) > 0) {
                        add_rule_row($(".js-advanced-prices table tbody tr:last-child"));
                    }
                    if ($.trim($(".js-advanced-prices table tbody tr:last-child .max_price").val()) === '' && !isNaN(parseFloat($(".js-advanced-prices table tbody tr:last-child").prev().find('.max_price').val()))) {
                        $(".js-advanced-prices table tbody tr:last-child .min_price").val(parseFloat($(".js-advanced-prices table tbody tr:last-child").prev().find('.max_price').val()) + 0.01)
                    }

                    var price_table = $(".js-advanced-prices table"),
                            use_compared = $('.js-advanced-prices input.use_compared_price_markup').is(":checked"),
                            emptyInputs = $('.js-advanced-prices table tbody tr:not(:last-child) input[type="text"], .js-advanced-prices table tfoot tr input[type="text"]').filter(function () {
                        return $.trim($(this).val()) === "";
                    });
                    emptyInputs.each(function () {
                        if (use_compared || (!$(this).hasClass('compared_value') && !$(this).hasClass('default_compared_value'))) {
                            $(this).parents('.input-group').addClass('has-error');
                        }
                    });

                    if ($('.js-advanced-prices table .input-group.has-error').length === 0) {
                        if (check_cents()) {
                            var data = {'action': 'a2w_update_price_rules', 'use_extended_price_markup': 'yes', 'use_compared_price_markup': use_compared ? 'yes' : 'no', 'rules': [],
                                'default_rule': {'value': $(price_table).find('.default_value').val(),
                                    'sign': get_el_sign_value($(price_table).find('.default_sign')),
                                    'compared_value': $(price_table).find('.default_compared_value').val(),
                                    'compared_sign': get_el_sign_value($(price_table).find('.default_compared_sign'))},
                                'cents': $('#cb-set-cents').is(":checked") ? $('#set-cents').val() : -1,
                                'compared_cents': $('#cb-compared-set-cents').is(":checked") ? $('#compared-set-cents').val() : -1};

                            $('.js-advanced-prices table tbody tr:not(:last-child)').each(function () {
                                var rule = {'min_price': $(this).find('.min_price').val(),
                                    'max_price': $(this).find('.max_price').val(),
                                    'value': $(this).find('.value').val(),
                                    'sign': get_el_sign_value($(this).find('.sign')),
                                    'compared_value': $(this).find('.compared_value').val(),
                                    'compared_sign': get_el_sign_value($(this).find('.compared_sign'))
                                };
                                data.rules.push(rule);
                            });

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
                    }
                }

            } else {

                var use_compared = !$('.js-default-prices .price-rulle-toggle').hasClass('price-rulle-toggle--disabled');

                var emptyInputs = $('.js-default-prices input[type="text"]').filter(function () {
                    return $.trim($(this).val()) === "";
                });
                emptyInputs.each(function () {
                    if (use_compared || !$(this).hasClass('compared_value')) {
                        $(this).parents('.input-group').addClass('has-error');
                    }
                });

                if ($('.js-default-prices .input-group.has-error').length === 0) {

                    if (check_cents()) {
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
                }



            }
            return false;
        });
    });
</script>