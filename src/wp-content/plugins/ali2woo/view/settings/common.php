<form method="post">

    <input type="hidden" name="setting_form" value="1"/>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="display-inline"><?php _ex('Purchase Settings', 'Setting title', 'ali2woo'); ?></h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="row-comments">
                        You need to log into your CodeCanyon account and go to your "Downloads" page. Locate this plugin you purchased in your "Downloads" list and click on the "License Certificate" link next to the download link. After you have downloaded the certificate you can open it in a text editor such as Notepad and copy the Item Purchase Code.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_item_purchase_code">
                        <strong><?php _ex('Item Purchase Code', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title='Need for everything.'></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="<?php echo ( a2w_check_defined('A2W_HIDE_KEY_FIELDS') ? 'password' : 'text'); ?>" class="form-control small-input" id="a2w_item_purchase_code" name="a2w_item_purchase_code" value="<?php echo esc_attr(a2w_get_setting('item_purchase_code')); ?>"/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="row-comments">
                        Go to page <a href="https://build.envato.com/my-apps/">https://build.envato.com/my-apps/</a>, log into your CodeCanyon account and press "Create a new token", and select  option "Download your purchased items", then press Create Token.
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_envato_personal_token">
                        <strong><?php _ex('Envato Personal Tokens', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title='Need for auto update'></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="<?php echo ( a2w_check_defined('A2W_HIDE_KEY_FIELDS') ? 'password' : 'text'); ?>" class="form-control small-input" id="a2w_envato_personal_token" name="a2w_envato_personal_token" value="<?php echo esc_attr(a2w_get_setting('envato_personal_token')); ?>"/>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="display-inline"><?php _ex('Import Settings', 'Setting title', 'ali2woo'); ?></h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Language', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex("It's applied to Product title, description, attributes and reviews", 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $cur_language = a2w_get_setting('import_language'); ?>
                        <select name="a2w_import_language" id="a2w_import_language" class="form-control small-input">
                            <option value="en" <?php if ($cur_language == "en"): ?>selected="selected"<?php endif; ?>>English</option>
                            <option value="ar" <?php if ($cur_language == "ar"): ?>selected="selected"<?php endif; ?>>Arabic</option>
                            <option value="de" <?php if ($cur_language == "de"): ?>selected="selected"<?php endif; ?>>German</option>
                            <option value="es" <?php if ($cur_language == "es"): ?>selected="selected"<?php endif; ?>>Spanish</option>
                            <option value="fr" <?php if ($cur_language == "fr"): ?>selected="selected"<?php endif; ?>>French</option>
                            <option value="it" <?php if ($cur_language == "it"): ?>selected="selected"<?php endif; ?>>Italian</option>
                            <option value="pl" <?php if ($cur_language == "pl"): ?>selected="selected"<?php endif; ?>>Polish</option>
                            <option value="ja" <?php if ($cur_language == "ja"): ?>selected="selected"<?php endif; ?>>Japanese</option>
                            <option value="ko" <?php if ($cur_language == "ko"): ?>selected="selected"<?php endif; ?>>Korean</option>
                            <option value="nl" <?php if ($cur_language == "nl"): ?>selected="selected"<?php endif; ?>>Notherlandish (Dutch)</option>
                            <option value="pt" <?php if ($cur_language == "pt"): ?>selected="selected"<?php endif; ?>>Portuguese (Brasil)</option>
                            <option value="ru" <?php if ($cur_language == "ru"): ?>selected="selected"<?php endif; ?>>Russian</option>
                            <option value="th" <?php if ($cur_language == "th"): ?>selected="selected"<?php endif; ?>>Thai</option>    
                            <option value="id" <?php if ($cur_language == "id"): ?>selected="selected"<?php endif; ?>>Indonesian</option>            
                            <option value="he" <?php if ($cur_language == "he"): ?>selected="selected"<?php endif; ?>>Hebrew</option>    
                            <option value="tr" <?php if ($cur_language == "tr"): ?>selected="selected"<?php endif; ?>>Turkish</option>
                            <option value="vi" <?php if ($cur_language == "vi"): ?>selected="selected"<?php endif; ?>>Vietnamese</option>
                        </select>                         
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Currency', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex("Default currency coefficients", 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $cur_a2w_local_currency = a2w_get_setting('local_currency'); ?>
                        <select name="a2w_local_currency" id="a2w_local_currency" class="form-control small-input">
                            <option value=""> - </option>
                            <option value="usd" <?php if ($cur_a2w_local_currency == "usd"): ?>selected="selected"<?php endif; ?>>usd</option>
                            <option value="rub" <?php if ($cur_a2w_local_currency == "rub"): ?>selected="selected"<?php endif; ?>>rub</option>
                            <option value="gbp" <?php if ($cur_a2w_local_currency == "gbp"): ?>selected="selected"<?php endif; ?>>gbp</option>
                            <option value="brl" <?php if ($cur_a2w_local_currency == "brl"): ?>selected="selected"<?php endif; ?>>brl</option> 
                            <option value="cad" <?php if ($cur_a2w_local_currency == "cad"): ?>selected="selected"<?php endif; ?>>cad</option>
                            <option value="aud" <?php if ($cur_a2w_local_currency == "aud"): ?>selected="selected"<?php endif; ?>>aud</option>
                            <option value="eur" <?php if ($cur_a2w_local_currency == "eur"): ?>selected="selected"<?php endif; ?>>eur</option>
                            <option value="inr" <?php if ($cur_a2w_local_currency == "inr"): ?>selected="selected"<?php endif; ?>>inr</option>
                            <option value="uah" <?php if ($cur_a2w_local_currency == "uah"): ?>selected="selected"<?php endif; ?>>uah</option>
                            <option value="jpy" <?php if ($cur_a2w_local_currency == "jpy"): ?>selected="selected"<?php endif; ?>>jpy</option>
                            <option value="mxn" <?php if ($cur_a2w_local_currency == "mxn"): ?>selected="selected"<?php endif; ?>>mxn</option>
                            <option value="idr" <?php if ($cur_a2w_local_currency == "idr"): ?>selected="selected"<?php endif; ?>>idr</option>
                            <option value="try" <?php if ($cur_a2w_local_currency == "try"): ?>selected="selected"<?php endif; ?>>try</option>
                            <option value="sek" <?php if ($cur_a2w_local_currency == "sek"): ?>selected="selected"<?php endif; ?>>sek</option>
                            <?php if(!empty($custom_currency)):?>
                            <optgroup label="<?php _ex("Custom currency", 'setting description', 'ali2woo'); ?>">
                            <?php foreach($custom_currency as $curr):?><option value="<?php echo $curr['value'];?>" <?php if ($cur_a2w_local_currency == $curr['value']): ?>selected="selected"<?php endif; ?>><?php echo $curr['name'];?></option><?php endforeach; ?>
                            </optgroup>
                            <?php endif; ?>
                            
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_default_product_type">
                        <strong><?php _ex('Default product type', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex("Default product type", 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $default_product_type = a2w_get_setting('default_product_type'); ?>
                        <select name="a2w_default_product_type" id="a2w_default_product_type" class="form-control small-input">
                            <option value="simple" <?php if ($default_product_type == "simple"): ?>selected="selected"<?php endif; ?>><?php _ex('Simple/Variable Product', 'Setting option', 'ali2woo'); ?></option>
                            <option value="external" <?php if ($default_product_type == "external"): ?>selected="selected"<?php endif; ?>><?php _ex('External/Affiliate Product', 'Setting option', 'ali2woo'); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_default_product_status">
                        <strong><?php _ex('Default product status', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex("Default product type", 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $default_product_status = a2w_get_setting('default_product_status'); ?>
                        <select name="a2w_default_product_status" id="a2w_default_product_status" class="form-control small-input">
                            <option value="publish" <?php if ($default_product_status == "publish"): ?>selected="selected"<?php endif; ?>><?php _e('Publish'); ?></option>
                            <option value="draft" <?php if ($default_product_status == "draft"): ?>selected="selected"<?php endif; ?>><?php _e('Draft'); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_tracking_code_order_status">
                        <strong><?php _ex('Tracking Code Order Status', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex("Change the order status when the tracking code is received", 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $tracking_code_order_status = a2w_get_setting('tracking_code_order_status'); ?>
                        <select name="a2w_tracking_code_order_status" id="a2w_tracking_code_order_status" class="form-control small-input">
                            <option value=""><?php _ex('Do nothing', 'Setting option', 'ali2woo'); ?></option>
                            <?php foreach($order_statuses as $os_key=>$os_value):?>
                            <option value="<?php echo $os_key;?>" <?php if ($tracking_code_order_status == $os_key): ?>selected="selected"<?php endif; ?>><?php echo $os_value;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_not_import_attributes">
                        <strong><?php _e('Not import attributes', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _e('Not import attributes', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_not_import_attributes" name="a2w_not_import_attributes" value="yes" <?php if (a2w_get_setting('not_import_attributes')): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_not_import_description">
                        <strong><?php _e('Not import description', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _e('Not import description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_not_import_description" name="a2w_not_import_description" value="yes" <?php if (a2w_get_setting('not_import_description')): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_not_import_description_images">
                        <strong><?php _e("Don't import images from the description", 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _e("Don't import images from the description", 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_not_import_description_images" name="a2w_not_import_description_images" value="yes" <?php if (a2w_get_setting('not_import_description_images')): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_use_external_image_urls">
                        <strong><?php _ex('Use external image urls', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Use external image urls', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_use_external_image_urls" name="a2w_use_external_image_urls" value="yes" <?php if (a2w_get_setting('use_external_image_urls')): ?>checked<?php endif; ?>/>
                    </div>
                    <div id="a2w_load_external_image_block" class="form-group input-block no-margin" <?php if (a2w_get_setting('use_external_image_urls')): ?>style="display: none;"<?php endif; ?>>
                        <input class="btn btn-default load-images" disabled="disabled" type="button" value="<?php _e('Load images', 'ali2woo'); ?>"/>
                        <div id="a2w_load_external_image_progress"></div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_use_cdn">
                        <strong><?php _ex('Use image proxy', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('If you have problems with loading images, try to use this option.', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_use_cdn" name="a2w_use_cdn" value="yes" <?php if (a2w_get_setting('use_cdn')): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_use_random_stock">
                        <strong><?php _ex('Use random stock value', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Use random stock value', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_use_random_stock" name="a2w_use_random_stock" value="yes" <?php if (a2w_get_setting('use_random_stock')): ?>checked<?php endif; ?>/>
                    </div>
                    <div id="a2w_use_random_stock_block" class="form-group input-block no-margin" <?php if (!a2w_get_setting('use_random_stock')): ?>style="display: none;"<?php endif; ?>>
                        <?php _e('From', 'ali2woo'); ?> <input type="text" style="max-width: 60px;" class="form-control" id="a2w_use_random_stock_min" name="a2w_use_random_stock_min" value="<?php echo esc_attr(a2w_get_setting('use_random_stock_min')); ?>">
                        <?php _e('To', 'ali2woo'); ?> <input type="text" style="max-width: 60px;" class="form-control" id="a2w_use_random_stock_max" name="a2w_use_random_stock_max" value="<?php echo esc_attr(a2w_get_setting('use_random_stock_max')); ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label for="a2w_import_extended_variation_attribute">
                        <strong><?php _ex('Extended variation attributes', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Import variation attributes as product attributes', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_import_extended_variation_attribute" name="a2w_import_extended_variation_attribute" value="yes" <?php if (a2w_get_setting('import_extended_variation_attribute')): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="display-inline"><?php _ex('Schedule settings', 'Setting title', 'ali2woo'); ?></h3>
        </div>
        <div class="panel-body">
            <?php $a2w_auto_update = a2w_get_setting('auto_update'); ?>
            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Aliexpress Sync', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Enable auto-update features', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="checkbox" class="form-control" id="a2w_auto_update" name="a2w_auto_update" value="yes" <?php if ($a2w_auto_update): ?>checked<?php endif; ?>/>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Not available product status', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('Change Product Status when the it becomes unavailable at Aliexpress', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $cur_a2w_not_available_product_status = a2w_get_setting('not_available_product_status'); ?>
                        <select class="form-control small-input" name="a2w_not_available_product_status" id="a2w_not_available_product_status" <?php if (!$a2w_auto_update): ?>disabled<?php endif; ?>>
                            <option value="trash" <?php if ($cur_a2w_not_available_product_status == "trash"): ?>selected="selected"<?php endif; ?>><?php _e('Trash'); ?></option>
                            <option value="outofstock" <?php if ($cur_a2w_not_available_product_status == "outofstock"): ?>selected="selected"<?php endif; ?>><?php _e('Out of stock'); ?></option>
                            <option value="instock" <?php if ($cur_a2w_not_available_product_status == "instock"): ?>selected="selected"<?php endif; ?>><?php _e('In stock'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _e('Synchronization type', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _e('Synchronization type', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $cur_a2w_sync_type = a2w_get_setting('sync_type'); ?>
                        <select class="form-control small-input" name="a2w_sync_type" id="a2w_sync_type" <?php if (!$a2w_auto_update): ?>disabled<?php endif; ?>>
                            <option value="price_and_stock" <?php if ($cur_a2w_sync_type == "price_and_stock"): ?>selected="selected"<?php endif; ?>><?php _e('Sync price and stock', 'ali2woo'); ?></option>
                            <option value="price" <?php if ($cur_a2w_sync_type == "price"): ?>selected="selected"<?php endif; ?>><?php _e('Sync only price', 'ali2woo'); ?></option>
                            <option value="stock" <?php if ($cur_a2w_sync_type == "stock"): ?>selected="selected"<?php endif; ?>><?php _e('Sync only stock', 'ali2woo'); ?></option>
                            <option value="no" <?php if ($cur_a2w_sync_type == "no"): ?>selected="selected"<?php endif; ?>><?php _e("Don't sync prices and stock", 'ali2woo'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="display-inline"><?php _ex('Chrome Extension settings', 'Setting title', 'ali2woo'); ?></h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Default shipping method', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('If possible, we will auto-select this shipping method during the checkout on AliExpress.', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <?php $cur_a2w_fulfillment_prefship = a2w_get_setting('fulfillment_prefship', 'EMS_ZX_ZX_US'); ?>
                        <select name="a2w_fulfillment_prefship" id="a2w_fulfillment_prefship" class="form-control small-input" >
                            <option value="" <?php if ($cur_a2w_fulfillment_prefship === ""): ?>selected="selected"<?php endif; ?>>Default (not override)</option>
                            <option value="CAINIAO_STANDARD" <?php if ($cur_a2w_fulfillment_prefship == "CAINIAO_STANDARD"): ?>selected="selected"<?php endif; ?>>AliExpress Standard Shipping</option>
                            <option value="CPAM" <?php if ($cur_a2w_fulfillment_prefship == "CPAM"): ?>selected="selected"<?php endif; ?>>China Post Registered Air Mail</option>
                            <option value="EMS" <?php if ($cur_a2w_fulfillment_prefship == "EMS"): ?>selected="selected"<?php endif; ?>>EMS</option>
                            <option value="EMS_ZX_ZX_US" <?php if ($cur_a2w_fulfillment_prefship == "EMS_ZX_ZX_US"): ?>selected="selected"<?php endif; ?>>ePacket</option>
                            <option value="DHL" <?php if ($cur_a2w_fulfillment_prefship == "DHL"): ?>selected="selected"<?php endif; ?>>DHL</option>
                            <option value="FEDEX" <?php if ($cur_a2w_fulfillment_prefship == "FEDEX"): ?>selected="selected"<?php endif; ?>>FedEx</option>
                            <option value="SGP" <?php if ($cur_a2w_fulfillment_prefship == "SGP"): ?>selected="selected"<?php endif; ?>>Singapore Post</option>
                            <option value="TNT" <?php if ($cur_a2w_fulfillment_prefship == "TNT"): ?>selected="selected"<?php endif; ?>>TNT</option>
                            <option value="UPS" <?php if ($cur_a2w_fulfillment_prefship == "UPS"): ?>selected="selected"<?php endif; ?>>UPS</option>
                            <option value="USPS" <?php if ($cur_a2w_fulfillment_prefship == "USPS"): ?>selected="selected"<?php endif; ?>>USPS</option> 
                            <option value="CAINIAO_PREMIUM" <?php if ($cur_a2w_fulfillment_prefship == "AliExpress Premium Shipping"): ?>selected="selected"<?php endif; ?>>AliExpress Premium Shipping</option>            
                        </select>       
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Override phone number', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('This will be used instead of a customer phone number.', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <input type="text" placeholder="code" style="max-width: 60px;" class="form-control" id="a2w_fulfillment_phone_code" maxlength="5" name="a2w_fulfillment_phone_code" value="<?php echo esc_attr(a2w_get_setting('fulfillment_phone_code')); ?>" />
                        <input type="text" placeholder="phone" class="form-control small-input" id="a2w_fulfillment_phone_number" maxlength="16" name="a2w_fulfillment_phone_number" value="<?php echo esc_attr(a2w_get_setting('fulfillment_phone_number')); ?>" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>
                        <strong><?php _ex('Custom note', 'Setting title', 'ali2woo'); ?></strong>
                    </label>
                    <div class="info-box" data-toggle="tooltip" title="<?php _ex('A note to the supplier on the Aliexpress checkout page.', 'setting description', 'ali2woo'); ?>"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group input-block no-margin">
                        <textarea placeholder="note for aliexpress order" maxlength="1000" rows="5" class="form-control" id="a2w_fulfillment_custom_note" name="a2w_fulfillment_custom_note" cols="50"><?php echo esc_attr(a2w_get_setting('fulfillment_custom_note')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row pt20 border-top">
        <div class="col-sm-12">
            <input class="btn btn-success js-main-submit" type="submit" value="<?php _e('Save settings', 'ali2woo'); ?>"/>
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
        $('[data-toggle="tooltip"]').tooltip({"placement": "top"});

        jQuery("#a2w_auto_update").change(function () {
            jQuery("#a2w_not_available_product_status").prop('disabled', !jQuery(this).is(':checked'));
            jQuery("#a2w_sync_type").prop('disabled', !jQuery(this).is(':checked'));
            return true;
        });

        jQuery("#a2w_use_random_stock").change(function () {
            jQuery("#a2w_use_random_stock_block").toggle();
            return true;
        });

        var a2w_import_product_images_limit_keyup_timer = false;

        $('#a2w_import_product_images_limit').on('keyup', function () {
            if (a2w_import_product_images_limit_keyup_timer) {
                clearTimeout(a2w_import_product_images_limit_keyup_timer);
            }

            var this_el = $(this);

            this_el.parents('.form-group').removeClass('has-error');
            if (this_el.parents('.form-group').children('span').length > 0)
                this_el.parents('.form-group').children('span').remove();

            a2w_import_product_images_limit_keyup_timer = setTimeout(function () {
                if (!a2w_isInt(this_el.val()) || this_el.val() < 0) {
                    this_el.after("<span class='help-block'>Please enter a integer greater than or equal to 0</span>");
                    this_el.parents('.form-group').addClass('has-error');
                }

            }, 1000);
        });

        var a2w_fulfillment_phone_code_keyup_timer = false;

        $('#a2w_fulfillment_phone_code').on('keyup', function () {

            if (a2w_fulfillment_phone_code_keyup_timer) {
                clearTimeout(a2w_fulfillment_phone_code_keyup_timer);
            }

            var this_el = $(this);

            this_el.removeClass('has-error');
            this_el.parents('.form-group').removeClass('has-error');
            if (this_el.parents('.form-group').children('span').length > 0)
                this_el.parents('.form-group').children('span').remove();

            a2w_fulfillment_phone_code_keyup_timer = setTimeout(function () {
                if (this_el.val() != '' && (!a2w_isInt(this_el.val()) || this_el.val().length < 1 || this_el.val().length > 5)) {
                    this_el.parents('.form-group').append("<span class='help-block'>Please enter Numbers. Between 1 - 5 characters.</span>");
                    this_el.addClass('has-error');
                    this_el.parents('.form-group').addClass('has-error');
                }

            }, 1000);

            //$(this).removeClass('error_input');
        });

        var a2w_fulfillment_phone_number_keyup_timer = false;

        $('#a2w_fulfillment_phone_number').on('keyup', function () {

            if (a2w_fulfillment_phone_number_keyup_timer) {
                clearTimeout(a2w_fulfillment_phone_number_keyup_timer);
            }

            var this_el = $(this);

            this_el.removeClass('has-error');
            this_el.parents('.form-group').removeClass('has-error');
            if (this_el.parents('.form-group').children('span').length > 0)
                this_el.parents('.form-group').children('span').remove();

            a2w_fulfillment_phone_number_keyup_timer = setTimeout(function () {
                if (this_el.val() != '' && (!a2w_isInt(this_el.val()) || this_el.val().length < 5 || this_el.val().length > 16)) {
                    this_el.parents('.form-group').append("<span class='help-block'>Please enter Numbers. Between 5 - 16 characters.</span>");
                    this_el.addClass('has-error');
                    this_el.parents('.form-group').addClass('has-error');
                }

            }, 1000);

            //$(this).removeClass('error_input');
        });

        //form submit
        $('.a2w-content form').on('submit', function () {
            if ($(this).find('.has-error').length > 0)
                return false;
        })
    })(jQuery);


</script>
