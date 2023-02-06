<?php

/**
 * @package: importify-plugin
 */

/**
 * Plugin Name: Importify
 * Description: Easily import best-selling products, and automate your entire dropshipping process, all with a single click.
 * Version: 1.0.2
 * Author: Importify
 * Author URI: https://www.importify.com/
 * License: GPLv3 or later
 * Text Domain: importify-plugin
 */

if (!defined('ABSPATH')) {
  die;
}

define("IMPORTIFY_API_URL", "https://app.importify.net/dashboard");
define('IMPORTIFY_VERSION', '1.0.2');
define('IMPORTIFY_PATH', dirname(__FILE__));
define('IMPORTIFY_FOLDER', basename(IMPORTIFY_PATH));
define('IMPORTIFY_URL', plugins_url() . '/' . IMPORTIFY_FOLDER);
define('IMPORTIFY_API_KEY', get_option('importify_api_key'));
define("IMPORTIFY_DEBUG", true);

register_activation_hook(__FILE__, 'importify_activation_hook');
register_deactivation_hook(__FILE__, 'importify_deactivation_hook');
register_uninstall_hook(__FILE__, 'importify_uninstall_hook');
add_action('admin_enqueue_scripts', 'importify_add_admin_css_js');
add_action('admin_menu', 'importify_admin_menu');
add_action("wp_ajax_nopriv_importify_installation","importify_installation");
add_action("wp_ajax_importify_installation","importify_installation");

function importify_activation_hook()
{
	$data = array(
		'store' => get_site_url(),
    'email' => get_option('admin_email'),
		'event' => 'install'
	);

	$response = importify_send_request('/woocomerce/status', $data);

	if ($response)
	{
		if ($response['success'] > 0)
	 	{
	 		importify_log('api key: '.$response['api_key'], get_site_url());
      importify_log((!get_option('importify_api_key') ? "yes" : "no"), get_site_url());

	 		if (!get_option('importify_api_key'))
	 		{
	 			add_option('importify_api_key',$response['api_key']);

        importify_log($response['app_name']." ".$response['user_id']." ".$response['scope'], get_site_url());
        
        if (class_exists("WC_Auth"))
        {
          class importify_AuthCustom extends WC_Auth 
          {
            public function getKeys($app_name, $user_id, $scope)
            {
              return parent::create_keys($app_name, $user_id, $scope);
            }
          }

          $auth = new importify_AuthCustom();
          $keys = $auth->getKeys($response['app_name'], $response['user_id'], $response['scope']);
          $data = array(
            'store' => get_site_url(),
            'keys' => $keys,
            'user_id' => $response['user_id'],
            'event' => 'update_keys'
          );
          $keys_response = importify_send_request('/woocomerce/status', $data);

          if ($keys_response && $keys_response['success'] == 0)
          {
            add_option('importify_error', 'yes');
            add_option('importify_error_message', $keys_response['message']);
          }
        }

        importify_log('after auth');
	 		}
	 		else 
	 		{	 			
        update_option('importify_api_key', $response['api_key']);
	 		}
		}
		else
		{
			importify_log('invalid response - api key', get_site_url());
      
      if (!get_option('importify_error'))
      {
        add_option('importify_error', 'yes');
        add_option('importify_error_message', 'Error activation plugin!');
      }
		}
	}
	else
	{
		importify_log('error getting response - api key', get_site_url());

    if (!get_option('importify_error'))
    {
      add_option('importify_error', 'yes');
      add_option('importify_error_message', 'Error activation plugin!');
    }
	}
}

function importify_deactivation_hook()
{
  if(!current_user_can('activate_plugins')) 
  {
    return;
  }
  $data = array(
    'store' => get_site_url(),
    'event' => 'deactivated',
  );
  return importify_send_request('/woocomerce/status', $data);
}

function importify_uninstall_hook() 
{
  if(!current_user_can('activate_plugins')) 
  {
    return;
  }

  delete_option('importify_api_key');

  if (get_option('importify_error'))
  {
    delete_option('importify_error');
  }

  if (get_option('importify_error_message'))
  {
    delete_option('importify_error_message');
  }

  importify_clear_all_caches();

  $data = array(
  	'store' => get_site_url(),
    'event' => 'uninstall',
  );
  return importify_send_request('/woocomerce/status', $data);
}


function importify_add_admin_css_js()
{
	wp_register_style('importify_style', IMPORTIFY_URL.'/assets/css/style.css');
  wp_enqueue_style('importify_style');
  wp_register_script('importify-admin', IMPORTIFY_URL.'/assets/js/script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('importify-admin');
}

function importify_admin_menu()
{
  add_menu_page('Importify Settings', 'Importify', 'manage_options', 'importify', 'importify_admin_menu_page_html', IMPORTIFY_URL.'/assets/images/importify_icon.png');
}

function importify_has_woocommerce() 
{
  return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
}

function importify_admin_menu_page_html()
{
  $data = array(
    'store' => get_site_url(),
    'event' => 'check_status'
  );
  
  $status_response = importify_send_request('/woocomerce/status', $data);

  if ($status_response && $status_response['success'] == 0)
  {
    add_option('importify_error', 'yes');
    add_option('importify_error_message', $keys_response['message']);
  }


  if ($status_response && $status_response['success'] == 1)
  {
    delete_option('importify_error', 'yes');
    delete_option('importify_error_message', $keys_response['message']);

    if (!get_option('importify_api_key'))
    {
      add_option('importify_api_key',$status_response['api_key']);
    }
    else
    {
      update_option('importify_api_key',$status_response['api_key']);
    }
  }

	include_once IMPORTIFY_PATH.'/views/importify_admin_page.php';
}

function importify_send_request($path, $data) 
{
  try 
  {
		$headers = array(
		  'Content-Type' => 'application/json',
		  'x-plugin-version' => IMPORTIFY_VERSION,
		  'x-site-url' => get_site_url(),
		  'x-wp-version' => get_bloginfo('version'),
		);

    if (importify_has_woocommerce()) 
    {
      $headers['x-woo-version'] = WC()->version;
    }

    $url = IMPORTIFY_API_URL.$path;
    $data = array(
      'headers' => $headers,
      'body' => json_encode($data),
      'method' => 'POST',
      'data_format' => 'body',
      'sslverify' => false
    );
    importify_log('sending request', $url);
    $response = wp_remote_post($url, $data);
    importify_log('got response', $url);
   
   	if (!is_wp_error($response)) 
		{
	  	$decoded_response = json_decode(wp_remote_retrieve_body($response), true);

	  	return $decoded_response;
	  }

	  return 0;
  } 
  catch(Exception $err) 
  {
    importify_handle_error('failed sending request', $err, $data);
  }
}

function importify_log($message, $data = null)
{
  $log = null;

  if (isset($data)) 
  {
    $log = "\n[Importify] " . $message . ":\n" . print_r($data, true);
  } 
  else 
  {
    $log = "\n[Importify] " . $message;
  }
  error_log($log);

  if (IMPORTIFY_DEBUG) 
  {
    $plugin_log_file = plugin_dir_path(__FILE__).'debug.log';
    error_log($log."\n", 3, $plugin_log_file);
  }
}

function importify_handle_error($message, $err, $data = null)
{
  importify_log($message, $err);
}

function importify_plugin_redirect()
{
  exit(wp_redirect("admin.php?page=Importify"));
}

function importify_clear_all_caches()
{
  try 
  {
    global $wp_fastest_cache;

    if (function_exists('w3tc_flush_all')) 
    {
      w3tc_flush_all();                
    } 

    if (function_exists('wp_cache_clean_cache')) 
    {
      global $file_prefix, $supercachedir;

      if (empty($supercachedir) && function_exists('get_supercache_dir')) 
      {
        $supercachedir = get_supercache_dir();
      }
      wp_cache_clean_cache($file_prefix);
    } 
    
    if (method_exists('WpFastestCache', 'deleteCache') && !empty($wp_fastest_cache)) 
    {
      $wp_fastest_cache->deleteCache();
    } 

    if (function_exists('rocket_clean_domain')) 
    {
      rocket_clean_domain();
      // Preload cache.
      if (function_exists('run_rocket_sitemap_preload')) {
        run_rocket_sitemap_preload();
      }
    } 
    
    if (class_exists("autoptimizeCache") && method_exists("autoptimizeCache", "clearall")) 
    {
      autoptimizeCache::clearall();
    }
    
    if (class_exists("LiteSpeed_Cache_API") && method_exists("autoptimizeCache", "purge_all")) 
    {
      LiteSpeed_Cache_API::purge_all();
    }
    
    if (class_exists('\Hummingbird\Core\Utils')) 
    {
      $modules= \Hummingbird\Core\Utils::get_active_cache_modules();
      foreach ($modules as $module => $name) 
      {
        $mod = \Hummingbird\Core\Utils::get_module( $module );

        if ($mod->is_active()) 
        {
          if ('minify' === $module) 
          {
            $mod->clear_files();
          } 
          else 
          {
            $mod->clear_cache();
          }
        }
      } 
    }
  } 
  catch (Exception $e) 
  {
    return 1;
  }
}

function importify_installation()
{
  if (in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins'))) && !get_option('importify_error')) 
  {
    $json['success'] = 1;
    $json['api_key'] = get_option('importify_api_key');
  }
  else
  {
    $json["success"] = 0;
  }

  wp_send_json($json);
  wp_die();
}

?>