<div class="a2w-content">
    <div class="page-main">
        <?php include_once A2W()->plugin_path . 'view/chrome_notify.php'; ?>
        
        <form class="search-panel" method="GET" id="a2w-search-form">
            <input type="hidden" name="page" id="page" value="<?php echo esc_attr(((isset($_GET['page'])) ? $_GET['page'] : '')); ?>" />
            <input type="hidden" name="cur_page" id="cur_page" value="<?php echo esc_attr(((isset($_GET['cur_page'])) ? $_GET['cur_page'] : '')); ?>" />
            <input type="hidden" name="a2w_sort" id="a2w_sort" value="<?php echo $filter['sort']; ?>" />
            <input type="hidden" name="a2w_search" id="a2w_search" value="1" />
            <div class="search-panel-header">
                <h3 class="search-panel-title"><?php _e('Search for products', 'ali2woo'); ?></h3>
                <button class="btn btn-default to-right modal-search-open" type="button"><?php _e('Import product by URL or ID', 'ali2woo'); ?></button>
            </div>
            <div class="search-panel-body">
                <div class="search-panel-simple">
                    <div class="row">
                        <div class="col-lg-9 col-sm-9">
                            <div class="input-group">
                                <input class="form-control" type="text" name="a2w_keywords" id="a2w_keywords" placeholder="<?php _e('Enter Keywords', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['keywords']) ? $filter['keywords'] : ""); ?>">
                                <select id="a2w_category" class="form-control" name="a2w_category" aria-invalid="false">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php if (isset($filter['category']) && $filter['category'] == $cat['id']): ?>selected="selected"<?php endif; ?>><?php if (intval($cat['level']) > 1): ?> - <?php endif; ?><?php echo $cat['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-4">
                            <div class="search-panel-buttons">
                                <button class="btn btn-info no-outline" id="a2w-do-filter" type="button"><?php _e('Search', 'ali2woo'); ?></button>
                                <button class="btn btn-link no-outline" id="search-trigger" type="button">Advance</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-panel-advanced" <?php if ($adv_search): ?>style="display: block;"<?php endif; ?>>
                    <div class="search-panel-row">
                        <div class="search-panel-col">
                            <label><?php _e('Price', 'ali2woo'); ?></label>
                            <input type="text" class="form-control" name="a2w_min_price" placeholder="<?php _e('Price from', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['min_price']) ? $filter['min_price'] : ""); ?>">
                            <input type="text" class="form-control" name="a2w_max_price" placeholder="<?php _e('Price to', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['max_price']) ? $filter['max_price'] : ""); ?>">
                        </div>
                        <div class="search-panel-col">
                            <label><?php _e("Seller's Feedback score", 'ali2woo'); ?></label>
                            <input type="text" class="form-control" name="a2w_min_feedback" placeholder="<?php _e('Score from 0', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['min_feedback']) ? $filter['min_feedback'] : ""); ?>">
                            <input type="text" class="form-control" name="a2w_max_feedback" placeholder="<?php _e('Score to 400 000+', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['max_feedback']) ? $filter['max_feedback'] : ""); ?>">
                        </div>
                        <div class="search-panel-col">
                            <label><?php _e('Sold in 30 days', 'ali2woo'); ?></label>
                            <input type="text" class="form-control" name="a2w_volume_from" placeholder="<?php _e('Orders count from', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['volume_from']) ? $filter['volume_from'] : ""); ?>">
                            <input type="text" class="form-control" name="a2w_volume_to" placeholder="<?php _e('Orders count to', 'ali2woo'); ?>" value="<?php echo esc_attr(isset($filter['volume_to']) ? $filter['volume_to'] : ""); ?>">
                        </div>
                    </div>
                </div>
                <div class="search-panel__row"><span class="country-select-title"><?php _e('Show shipping price to', 'ali2woo'); ?></span>
                    <div class="country-select" id="my-list">
                        <select name="a2w_country" class="form-control country_list">
                            <?php foreach ($countries as $country): ?>
                                <option value="<?php echo $country['c']; ?>"<?php if (isset($filter['country']) && $filter['country'] == $country['c']): ?> selected="selected"<?php endif; ?>><?php echo $country['n']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div><span class="country-select-descr"><?php _e('We will display the cheapest shipping option on the results page', 'ali2woo'); ?></span>
                </div>
            </div>

            <div class="modal-overlay modal-search">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><?php _e('Import product by URL or ID', 'ali2woo'); ?></h3>
                        <a class="modal-btn-close" href="#"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cross"></use></svg></a>
                    </div>
                    <div class="modal-body">
                        <label><?php _e('Product URL', 'ali2woo'); ?></label>
                        <input class="form-control" type="text" id="url_value">
                        <div class="separator"><?php _e('or', 'ali2woo'); ?></div>
                        <label><?php _e('Product ID', 'ali2woo'); ?></label>
                        <input class="form-control" type="text" id="id_value">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default modal-close" type="button"><?php _e('Cancel'); ?></button>
                        <button id="import-by-id-url-btn" class="btn btn-success" type="button">
                            <div class="btn-icon-wrap cssload-container"><div class="cssload-speeding-wheel"></div></div>
                            <?php _e('Import', 'ali2woo'); ?>
                        </button>
                    </div>
                </div>
            </div>

        </form>

        <div class="sort-panel">
            <label for="a2w-sort-selector"><?php _e('Sort by:', 'ali2woo'); ?></label>
            <select class="form-control" id="a2w-sort-selector">
                <option value="orignalPriceUp" <?php if ($filter['sort'] == 'orignalPriceUp'): ?>selected="selected"<?php endif; ?>><?php _ex('Lowest price', 'sort by', 'ali2woo'); ?></option>
                <option value="orignalPriceDown" <?php if ($filter['sort'] == 'orignalPriceDown'): ?>selected="selected"<?php endif; ?>><?php _ex('Highest price', 'sort by', 'ali2woo'); ?></option>
                <option value="sellerRateDown" <?php if ($filter['sort'] == 'sellerRateDown'): ?>selected="selected"<?php endif; ?>><?php _ex("Seller's feedback score", 'sort by', 'ali2woo'); ?></option>
                <option value="commissionRateUp" <?php if ($filter['sort'] == 'commissionRateUp'): ?>selected="selected"<?php endif; ?>><?php _ex('Lowest commission rate', 'sort by', 'ali2woo'); ?></option>
                <option value="commissionRateDown" <?php if ($filter['sort'] == 'commissionRateDown'): ?>selected="selected"<?php endif; ?>><?php _ex('Highest commission rate', 'sort by', 'ali2woo'); ?></option>
                <option value="volumeDown" <?php if ($filter['sort'] == 'volumeDown'): ?>selected="selected"<?php endif; ?>><?php _ex('Orders count', 'sort by', 'ali2woo'); ?></option>
                <option value="validTimeUp" <?php if ($filter['sort'] == 'validTimeUp'): ?>selected="selected"<?php endif; ?>><?php _ex('Lowest valid time', 'sort by', 'ali2woo'); ?></option>
                <option value="validTimeDown" <?php if ($filter['sort'] == 'validTimeDown'): ?>selected="selected"<?php endif; ?>><?php _ex('Highest valid time', 'sort by', 'ali2woo'); ?></option>
            </select>
        </div>

        <div class="search-result">
            <div class="messages"><?php settings_errors('a2w_products_list'); ?></div>
            <?php $localizator = A2W_AliexpressLocalizator::getInstance(); ?>
            <?php if ($load_products_result['state'] != 'error'): ?>
                <?php if (!$load_products_result['total']): ?>
                    <p>products not found</p>
                <?php else: ?>
                    <?php $row_ind = 0; ?>
                    <?php foreach ($load_products_result['products'] as $product): ?>
                        <?php
                        if ($row_ind == 0) {
                            echo '<div class="search-result__row">';
                        }
                        ?>
                        <article class="product-card<?php if ($product['post_id'] || $product['import_id']): ?> product-card--added<?php endif; ?>" data-id="<?php echo $product['id'] ?>">
                            <div class="product-card__img"><a href="<?php echo $product['affiliate_url'] ?>" target="_blank"><img src="<?php echo A2W()->plugin_url . 'assets/img/blank_image.png'; ?>" class="lazy" data-original="<?php echo $product['thumb'] ?>" alt="#"></a>
                                <div class="product-card__marked-corner">
                                    <svg class="product-card__marked-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-selected"></use></svg>
                                </div>
                            </div>
                            <div class="product-card__body">
                                <div class="product-card__meta">
                                    <div class="product-card__title"><a href="<?php echo $product['affiliate_url'] ?>" target="_blank"><?php echo $product['title']; ?></a></div>
                                </div>
                                <div class="product-card__price-wrapper">
                                    <h4><span class="product-card__price"><?php echo $localizator->getLocaleCurr(); ?><?php echo $product['local_price']; ?></span><span class="product-card__discount"><?php echo $localizator->getLocaleCurr(); ?><?php echo $product['local_regular_price']; ?></span></h4>
                                </div><span class="product-card__subtitle">
                                    <div>
                                        <div class="product-card-shipping-info"<?php if (isset($product['shipping_to_country'])): ?> data-country="<?php echo $product['shipping_to_country'] ?>"<?php endif; ?>>
                                            <div class="shipping-title"><?php _e('Choose shipping country', 'ali2woo'); ?></div>
                                            <div class="delivery-time"></div>
                                        </div>
                                    </div></span>
                                <div class="product-card__meta-wrapper">
                                    <div class="product-card__rating">
                                        <?php for ($i = 0; $i < round($product['evaluateScore']); $i++): ?>
                                            <svg class="icon-star"><use xlink:href="#icon-star"></use></svg>
                                        <?php endfor; ?>
                                        <?php for ($i = round($product['evaluateScore']); $i < 5; $i++): ?>
                                            <svg class="icon-empty-star"><use xlink:href="#icon-star"></use></svg>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="product-card__supplier">
                                        <div class="product-card__orderscount"><?php echo $product['volume']; ?> <span>Orders</span></div><img class="supplier-icon" src="<?php echo A2W()->plugin_url . '/assets/img/icons/supplier_ali_2x.png'; ?>" width="16" height="16">
                                    </div>
                                </div>
                                <div class="product-card__actions">
                                    <button class="btn <?php echo ($product['post_id'] || $product['import_id']) ? 'btn-default' : 'btn-success'; ?> no-outline btn-icon-left"><span class="title"><?php if ($product['post_id'] || $product['import_id']): ?><?php _e('Remove from import list', 'ali2woo'); ?><?php else: ?><?php _e('Add to import list', 'ali2woo'); ?><?php endif; ?></span>
                                        <div class="btn-loader-wrap"><div class="a2w-loader"></div></div>
                                        <span class="btn-icon-wrap add"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-add"></use></svg></span>
                                        <span class="btn-icon-wrap remove"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cross"></use></svg></span>
                                    </button>
                                </div>
                            </div>
                        </article>
                        <?php $row_ind++; ?>
                        <?php
                        if ($row_ind == 4) {
                            echo '</div>';
                            $row_ind = 0;
                        }
                        ?>
                    <?php endforeach; ?>
                    <?php
                    if (0 < $row_ind && $row_ind < 4) {
                        echo '</div>';
                    }
                    ?>
                    <?php if (isset($filter['country'])): ?>
                        <script>
                            (function ($) {
                                $(function () {
                                    chech_products_view();
                                    $(window).scroll(function () {
                                        chech_products_view();
                                    });
                                });
                            })(jQuery);
                        </script>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <?php if ($load_products_result['state'] != 'error' && $load_products_result['total_pages'] > 0): ?>
            <div id="a2w-search-pagination" class="pagination">
                <div class="pagination__wrapper">
                    <ul class="pagination__list">
                        <li <?php if (1 == $load_products_result['page']): ?>class="disabled"<?php endif; ?>><a href="#" rel="<?php echo $load_products_result['page'] - 1; ?>">«</a></li>
                        <?php foreach ($load_products_result['pages_list'] as $p): ?>
                            <?php if ($p): ?>
                                <?php if ($p == $load_products_result['page']): ?>
                                    <li class="active"><span><?php echo $p; ?></span></li>
                                <?php else: ?>
                                    <li><a href="#" rel="<?php echo $p; ?>"><?php echo $p; ?></a></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="disabled"><span>...</span></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <li <?php if ($load_products_result['total_pages'] == $load_products_result['page']): ?>class="disabled"<?php endif; ?>><a href="#" rel="<?php echo $load_products_result['page'] + 1; ?>">»</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <div class="modal-overlay modal-shipping">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><?php _e('Available shipping methods', 'ali2woo'); ?></h3>
                    <a class="modal-btn-close" href="#"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-cross"></use></svg></a>
                </div>
                <div class="modal-body">
                    <div class="container-flex"><span><?php _e('Calculate your shipping price:', 'ali2woo'); ?></span>
                        <div class="country-select" id="my-list">
                            <select id="modal-country-select" class="form-control country_list" style="width: 100%;">
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo $country['c']; ?>"<?php if (isset($filter['country']) && $filter['country'] == $country['c']): ?> selected="selected"<?php endif; ?>><?php echo $country['n']; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
                    <div class="message-container">
                        <div class="shipping-method"> <span class="shipping-method-title"><?php _e('These are the shipping methods you will be able to select when processing orders:', 'ali2woo'); ?></span>
                            <div class="shipping-method">
                                <table class="shipping-table">
                                    <thead>
                                        <tr>
                                            <th><strong><?php _e('Shipping Method', 'ali2woo'); ?></strong></th>
                                            <th><strong><?php _e('Estimated Delivery Time', 'ali2woo'); ?></strong></th>
                                            <th><strong><?php _e('Shipping Cost', 'ali2woo'); ?></strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Free Worldwide Shipping</td>
                                            <td>19-39</td>
                                            <td>$0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default modal-close" type="button"><?php _e('Ok', 'ali2woo'); ?></button>
                </div>
            </div>
        </div>

    </div>
</div>