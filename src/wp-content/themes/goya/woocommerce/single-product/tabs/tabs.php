<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_layout = goya_meta_config('product','layout_single','regular');
$is_showcase = ($product_layout == 'showcase') ? true : false;
$details_style = goya_meta_config('product','details_style','tabs');
$description_layout = goya_meta_config('product','description_layout','boxed');
$accordion_scroll = (get_theme_mod('product_accordion_scrollbars', false) == true) ? 'custom_scroll' : '';

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : 

	if ($details_style != 'accordion' || $is_showcase) : ?>
	
			<div class="woocommerce-tabs wc-tabs-wrapper product-details-<?php echo esc_attr( $details_style ); ?> desc-layout-<?php echo esc_attr( $description_layout ); ?>">
				<div class="container">
					<div class="row justify-content-md-center">
						<div class="col-12">
							<ul class="tabs wc-tabs" role="tablist">
								<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
									<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
										<a href="#tab-<?php echo esc_attr( $key ); ?>" class="tab-link">
											<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<div class="container">
							<div class="row">
								<div class="col tab-panel-inner">
									<?php
									if ( isset( $product_tab['callback'] ) ) {
										call_user_func( $product_tab['callback'], $key, $product_tab );
									}
									?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		
		<?php else: ?>
			
			<div class="woocommerce-tabs tabs-accordion wc-tabs-wrapper">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<div class="<?php echo esc_attr( $key ); ?>_tab tab-title" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>" class="tab-link">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</a>
					</div>
		
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab <?php echo esc_attr($accordion_scroll); ?>" id="tab-<?php echo esc_attr( $key ); ?>" class="tab-content" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php if ( isset( $product_tab['callback'] ) ) { call_user_func( $product_tab['callback'], $key, $product_tab ); } ?>
					</div>
				<?php endforeach; ?>
			</div>

	<?php endif; ?>		
<?php endif; ?>