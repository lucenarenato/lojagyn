<?php
/**
 * List of hooks in WC Ajax Product Filter plugin.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

$wcapf = new WCAPF();

add_action('woocommerce_before_shop_loop', array('WCAPF', 'beforeProductsHolder'), 0);
add_action('woocommerce_after_shop_loop', array('WCAPF', 'afterProductsHolder'), 200);
add_action('woocommerce_before_template_part', array('WCAPF', 'beforeNoProducts'), 0);
add_action('woocommerce_after_template_part', array('WCAPF', 'afterNoProducts'), 200);

add_action('paginate_links', array('WCAPF', 'paginateLinks'));

// frontend sctipts
add_action('wp_enqueue_scripts', array($wcapf, 'frontendScripts'));

// filter products
add_action('woocommerce_product_query', array($wcapf, 'setFilter'));

// clear old transients
add_action('create_term', 'wcapf_clear_transients');
add_action('edit_term', 'wcapf_clear_transients');
add_action('delete_term', 'wcapf_clear_transients');

add_action('save_post', 'wcapf_clear_transients');
add_action('delete_post', 'wcapf_clear_transients');