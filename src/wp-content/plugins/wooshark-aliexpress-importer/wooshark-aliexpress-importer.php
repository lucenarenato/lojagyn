<?php
/*
   Plugin Name: theShark dropshipping for AliExpress and Woocommerce
   Plugin URI: http://wordpress.org/extend/plugins/wooshark-aliexpress-importer/
   Version: 2.1.8
   Author: wooproductimporter
   Description: Wooshark dropshipping for aliexpress and woocommerce
   Text Domain: wooshark-aliexpress-importer
   
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2018 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$WoosharkAliexpressImporter_minimalRequiredPhpVersion = '5.0';

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function wads_WoosharkAliexpressImporter_noticePhpVersionWrong()
{
    global $WoosharkAliexpressImporter_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
        __('Error: plugin "Wooshark dropshipping for aliexpress and woocommerce" requires a newer version of PHP to be running.',  'wooshark-aliexpress-importer') .
        '<br/>' . __('Minimal version of PHP required: ', 'wooshark-aliexpress-importer') . '<strong>' . $WoosharkAliexpressImporter_minimalRequiredPhpVersion . '</strong>' .
        '<br/>' . __('Your server\'s PHP version: ', 'wooshark-aliexpress-importer') . '<strong>' . phpversion() . '</strong>' .
        '</div>';
}

function wads_WoosharkAliexpressImporter_PhpVersionCheck()
{
    global $WoosharkAliexpressImporter_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $WoosharkAliexpressImporter_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'wads_WoosharkAliexpressImporter_noticePhpVersionWrong');
        return false;
    }
    return true;
}


function wads_our_plugin_action_links($links, $file)
{
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    // check to make sure we are on the correct plugin

    if ($file == $this_plugin) {

        // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page

        $settings_link = '<a style="color:red" target="_blank" href="https://wooshark.com/aliexpress">Go pro</a>';

        // add the link to the list

        array_unshift($links, $settings_link);
    }

    return $links;
}

add_filter('plugin_action_links', 'wads_our_plugin_action_links', 10, 2);


function wads_my_admin_scripts_init_for_Aliexpreee_freeVersion($hook_suffix)
{

    if ('post.php' == $hook_suffix || 'post-new.php' == $hook_suffix) {

        wp_enqueue_script('original', plugin_dir_url(__FILE__) . 'js/OriginalProductUrl.js', array('jquery'), NULL, false);
        wp_localize_script(
            'original',
            'wooshark_params',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce')
            )
        );
    }
}
add_action('admin_enqueue_scripts', 'wads_my_admin_scripts_init_for_Aliexpreee_freeVersion');








// Run the version check.
// If it is successful, continue with initialization for this plugin
if (wads_WoosharkAliexpressImporter_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('wooshark-aliexpress-importer_init.php');
    wads_WoosharkAliexpressImporter_init(__FILE__);
    wads_initOriginalProductUrl();
}

function wads_initOriginalProductUrl()
{


   
    add_action( 'post_submitbox_misc_actions', 'wads_woo_add_custom_general_fields_originalProductUrl', 20 );

    function wads_woo_add_custom_general_fields_originalProductUrl()
    {

        echo ' 
        <button  style="background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        border-radius: 5px;
        padding: 7px;
        margin: 5px;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;" type="button" style="margin:10px; "  class="btn btn-primary" id="openOriginalProductUrl" data-target=".bd-example-modal-lg"> Open Original product url (wooshark)</button>
        
        <div class="loader2" style="display:none"><div></div><div></div><div></div><div></div></div>';
       
        

    
    }
}

if (!wp_next_scheduled('wooshark_myprefix_cron_hook')) {
    wp_schedule_event(time(), 'weekly', 'wooshark_myprefix_cron_hook');
}
add_action('wooshark_myprefix_cron_hook', 'wads_wooshark_myprefix_cron_function()');
function wads_wooshark_myprefix_cron_function()
{
    update_option('isAllowedToImport', 0);
}
