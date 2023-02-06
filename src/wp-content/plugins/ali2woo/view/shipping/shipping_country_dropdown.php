<?php
$a2w_shipping_html = '<div id="a2w_to_country">' .
	woocommerce_form_field('a2w_to_country_field', array(
		   'type'       => 'select',
		   'class'      => array( 'chzn-drop' ),
		   'label'      => __('Ship my order(s) to: ', 'ali2woo'),
		   'placeholder'    => __('Select a Country', 'ali2woo'),
		   'options'    => $countries,
		   'default' => $default_country,
		   'return' => true
			)
	 ) .
'</div>';
$a2w_shipping_html = str_replace(array("\r", "\n"), '', $a2w_shipping_html);
?>
<div class="a2w_shipping">
</div>
<script id="a2w_country_selector_html" type="text/html">
<?php echo $a2w_shipping_html; ?>
</script>
<script>
jQuery(document).ready(function($){
window.a2w_shipping_api.init_in_cart( $('#a2w_country_selector_html').html()); 
});
</script>
