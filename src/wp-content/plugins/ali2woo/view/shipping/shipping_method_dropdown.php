<?php /*echo $title; */?>

<?php if (isset($shipping_methods) && $shipping_methods) :  ?>
<?php
$a2w_shipping_html = '<div class="a2w_to_shipping">' .
     woocommerce_form_field('a2w_shipping_field'.$cart_item_key, array(
       'type'       => 'select',
       'class'      => array( 'chzn-drop' ),
       'label'      => __('Shipping method: ', 'ali2woo'),
       'placeholder'    => __('Select a Shipping method', 'ali2woo'),
       'options'    => $shipping_methods ,
       'default' => $default_shipping_method,
       'return' => true
        )
    ) . '</div>'; 
    
$a2w_shipping_html = str_replace(array("\r", "\n"), '', $a2w_shipping_html);         
?>
<div class="a2w_shipping_field<?php echo $cart_item_key; ?>_container">
<?php echo $a2w_shipping_html; ?>
</div>
<?php if (!defined('DOING_AJAX')) : ?>
<script>
jQuery(document).ready(function($){
   window.a2w_shipping_api.init_shipping_dropdown_in_cart('<?php echo $cart_item_key; ?>'); 
});
</script>
<?php endif; ?>
<?php endif; ?>