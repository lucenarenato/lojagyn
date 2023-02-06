<?php


add_action('wp_ajax_wooshark-insert-product', 'wads_insertProductInWoocommerce');
add_action('wp_ajax_nopriv_wooshark-insert-product', 'wads_insertProductInWoocommerce');
add_action('wp_ajax_get_all_products', 'wads_get_all_Products');
add_action('wp_ajax_nopriv_get_all_products', 'wads_get_all_Products');
add_action('wp_ajax_search-category-by-name', 'wads_searchCategoryByName');
add_action('wp_ajax_nopriv_search-category-by-name', 'wads_searchCategoryByName');
add_action('wp_ajax_getOrders', 'wads_getOrders');
add_action('wp_ajax_nopriv_getOrders', 'wads_getOrders');
add_action('wp_ajax_get-sku-and-url-by-Category', 'wads_getSKuAbdUrlByCategory');
add_action('wp_ajax_nopriv_get-sku-and-url-by-Category', 'wads_getSKuAbdUrlByCategory');
add_action('wp_ajax_get-already-imported-products', 'wads_getAlreadyImportedProducts');
add_action('wp_ajax_nopriv_get-already-imported-products', 'wads_getAlreadyImportedProducts');
add_action('wp_ajax_insert-reviews-to-product', 'wads_insertReviewsIntoProduct');
add_action('wp_ajax_nopriv_insert-reviews-to-product', 'wads_insertReviewsIntoProduct');
add_action('wp_ajax_remove-product-from-wp', 'wads_removeProductFromShop');
add_action('wp_ajax_nopriv_remove-product-from-wp', 'wads_removeProductFromShop');
add_action('wp_ajax_search-product-by-sku', 'wads_searchProductBySku');
add_action('wp_ajax_nopriv_search-product-by-sku', 'wads_searchProductBySku');
add_action('wp_ajax_get_products-draft', 'wads_getProductsDraft');
add_action('wp_ajax_nopriv_get_products-draft', 'wads_getProductsDraft');
add_action('wp_ajax_get-old-product-details', 'wads_getOldProductDetails');
add_action('wp_ajax_nopriv_get-old-product-details', 'wads_getOldProductDetails');
add_action('wp_ajax_get-product-by-id', 'wads_searchProductByIdReviews');
add_action('wp_ajax_nopriv_get-product-by-id', 'wads_searchProductByIdReviews');
add_action('wp_ajax_saveOptionsDB', 'wads_saveOptionsDB');
add_action('wp_ajax_nopriv_saveOptionsDB', 'wads_wads_saveOptionsDB');
add_action('wp_ajax_getProductsCount', 'wads_getProductsCount_FROM_WP');
add_action('wp_ajax_nopriv_getProductsCount', 'wads_getProductsCount_FROM_WP');
add_action('wp_ajax_get_categories', 'wads_get_categories_FROMWP');
add_action('wp_ajax_nopriv_get_categories', 'wads_get_categories_FROMWP');
add_action('wp_ajax_insert-reviews-to-productRM', 'wads_insertReviewsIntoProductRM_PREMUIM_PLUGIN');
add_action('wp_ajax_nopriv_insert-reviews-to-producRMt', 'wads_insertReviewsIntoProductRM_PREMUIM_PLUGIN');
add_action('wp_ajax_restoreConfiguration', 'wads_restoreConfiguration');
add_action('wp_ajax_nopriv_restoreConfiguration', 'wads_restoreConfiguration');



function wads_WoosharkAliexpressImporter_init($file)
{
  require_once('WoosharkAliexpressImporter_Plugin.php');
  $aPlugin = new WoosharkAliexpressImporter_Plugin();
  if (!$aPlugin->isInstalled()) {
    $aPlugin->install();
  } else {
    $aPlugin->upgrade();
  }
  $aPlugin->addActionsAndFilters();
  if (!$file) {
    $file = __FILE__;
  }
  register_activation_hook($file, array(&$aPlugin, 'activate'));
  register_deactivation_hook($file, array(&$aPlugin, 'deactivate'));
}
add_action('rest_api_init', function () {
  register_rest_route('myplugin/v1', '/author/(?P<id>\d+)', array('methods' => 'GET', 'callback' => 'wads_my_awesome_func',));
});
function wads_my_awesome_func($data)
{
  $posts = get_posts(array('author' => $data['id'],));
  if (empty($posts)) {
    return null;
  }
  return $posts[0]->post_title;
}



function wads_getProductsCount_FROM_WP()
{

  $args = array(
    'post_type'      => 'product',
    'post_status' => array('publish', 'draft'),
    'meta_query' => array(
      array(
        'key' => 'productUrl', //meta key name here
        'value' => 'aliexpress.com',
        'compare' => 'LIKE',
      )
    ),
  );
  $query = new WP_Query($args);
  $total = $query->found_posts;
  wp_reset_postdata();
  wp_send_json($total);
}



function wads_get_categories_FROMWP()
{


  $categoriesArray = array();

  $orderby = 'name';
  $order = 'asc';
  $hide_empty = false;
  $cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
  );

  $product_categories = get_terms('product_cat', $cat_args);

  foreach ($product_categories as $product_category) {
    // if ($product_category->count > 0) {
    array_push($categoriesArray, array('name' => $product_category->name, 'count' => $product_category->count, 'term_id' => $product_category->term_id));
    // }
  }

  // $response['message'] = $post_id->get_error_message();
  wp_send_json($categoriesArray);
}

function wads_get_all_Products()
{

  $paged = isset($_POST['paged']) ? wc_clean($_POST['paged']) : '';

  $args = array(
    'post_type'      => 'product',
    'posts_per_page' => 20,
    'paged' => $paged,
    'meta_query' => array(
      array(
        'key' => 'productUrl', //meta key name here
        'value' => 'aliexpress.com',
        'compare' => 'LIKE',
      )
    )


  );

  $products = new WP_Query($args);
  $finalList = array();

  if ($products->have_posts()) {
    while ($products->have_posts()) : $products->the_post();
      $theid = get_the_ID();
      $product = new WC_Product($theid);
      if (has_post_thumbnail()) {
        $thumbnail = get_post_thumbnail_id();
        $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
      }
      $finalList[] = array(
        'sku' => $product->get_sku(),
        'id' => $theid,
        // image => wp_get_attachment_image_src( get_post_thumbnail_id($products->post->ID)),
        'image' => $image,
        'title' =>  $product->get_title(),
        'productUrl' => get_post_meta($theid, 'productUrl', true),
        'lastUpdated' => get_post_meta($theid, 'lastUpdated', true),
        'status' => $product->get_status()



      );
    endwhile;
  } else {
    echo __('No products found');
  }
  wp_reset_postdata();

  wp_send_json($finalList);
}




function wads_insertProductInWoocommerce()
{


  if (isset($_POST)) {
    $sku = isset($_POST['sku']) ? wc_clean($_POST['sku']) : '';
    $images = isset($_POST['images']) ? wc_clean($_POST['images']) : array();
    $categories = isset($_POST['categories']) ? wc_clean($_POST['categories']) : array();
    $title = isset($_POST['title']) ? wc_clean($_POST['title']) : '';
    $description = isset($_POST['description']) ? wp_kses_post($_POST['description']) : '';   
    $postStatus = isset($_POST['postStatus']) ? wc_clean($_POST['postStatus']) : 'draft';
    $variations = isset($_POST['variations']) ? wc_clean($_POST['variations']) : array();
    $attributes = isset($_POST['attributes']) ? wc_clean($_POST['attributes']) : array();
    $productUrl = isset($_POST['productUrl']) ? wc_clean($_POST['productUrl']) : '';

    $shortDescription = isset($_POST['shortDescription']) ? wc_clean($_POST['shortDescription']) : '';
    $importVariationImages = isset($_POST['importVariationImages']) ? wc_clean($_POST['importVariationImages']) : '';
    $reviews = isset($_POST['reviews']) ? wc_clean($_POST['reviews']) : array();
    $tags = isset($_POST['tags']) ? wc_clean($_POST['tags']) : array();


    $currentImportedNumber = get_option('isAllowedToImport');
    if (isset($currentImportedNumber)) {
      $finalCounter = (int) $currentImportedNumber + 1;
      update_option('isAllowedToImport',   $finalCounter);
    } else {
      update_option('isAllowedToImport',   '1');
    }

    // if(null != get_option('isAllowedToImport') && (int) get_option('isAllowedToImport') > 150){
    //   $results = array('error' => true, 'error_msg' => 'you have reached the permitted usage limit for this week, you can either wait 1 week to import again or upgrade to a premuim plan', 'data' => '');
    //   wp_send_json($results);
    // } 


    //Create main product

    try {
      $product = new WC_Product_Variable();
      if (isset($title)) {
        $product->set_name($title);
      }
      if (isset($description)) {
        // $product->set_description($description);
      }
      if (isset($shortDescription)) {
        $product->set_short_description($shortDescription);
      }

      if (isset($sku)) {
        $product->set_sku($sku);
      }

      if (isset($postStatus)) {
        $product->set_status($postStatus);
      }


      //   //categories
      if (is_array($categories) && count($categories)) {
        $product->set_category_ids($categories);
      }
      //images


      wads_save_product_images($product, $images);

      // if (is_array($images) && count($images)) {
      //   $attarray = array();
      //   for ($j = 0; $j < count($images); $j++) {
      //     array_push($attarray,  upload_image($images[$j], $post_id));
      //   }
      //   // set_post_thumbnail($post_id, $attarray[0]);
      //   $product->set_image_id($attarray[0]);
      //   if (sizeof($attarray) > 1) {
      //     array_shift($attarray); //removes first item of the array (because it's been set as the featured image already)
      //     $product->set_gallery_image_ids($attarray); //set the images id's left over after the array shift as the gallery images
      //   }
      // } 

      $attributeArray = array();
      if (is_array($attributes) && count($attributes)) {
        foreach ($attributes as $attributeValue) {
          $values = $attributeValue['values'];
          $attr_label = $attributeValue['name'];
          $isVariation = $attributeValue['variation'];

          //Create the attribute object
          $attribute = new WC_Product_Attribute();

          //pa_size tax id
          // $attribute->set_id(0); // -> SET to 0

          //pa_size slug
          $attribute->set_name($attr_label); // -> removed 'pa_' prefix

          //Set terms slugs
          $attribute->set_options($values);

          //If enabled
          $attribute->set_visible(1);

          //If we are going to use attribute in order to generate variations
          // $attribute->set_variation(1);

          if ($isVariation == 'true') {
            $attribute->set_variation(1);
          } else {
            $attribute->set_variation(0);
          }

          array_push($attributeArray, $attribute);
        }
        $product->set_attributes($attributeArray);
      } else {
        $results = array(
          'error' => true,
          'error_msg' => 'Missing attributes or variations, could not insert product ',
          'data' => ''
        );
        wp_send_json($results);
      }
    } catch (Exception $ex) {
      /* ERROR LIKE "SKU ALREADY EXISTS" */
      $results = array(
        'error' => true,
        'error_msg' => 'Error received when trying to insert the product' . $ex->getMessage(),
        'data' => ''
      );
      wp_send_json($results);
    }


    try {
      $post_id = $product->save();
    } catch (Exception $e) {
      $results = array(
        'error' => true,
        'error_msg' => 'Error received when trying to insert the product' . $ex->getMessage(),
        'data' => ''
      );
      wp_send_json($results);
    }
    
    if (isset($productUrl)) {
      $promotedUrm = 'https://alitems.site/g/1e8d114494bee1754d1816525dc3e8/?ulp=' . urlencode($productUrl);
      update_post_meta($post_id, 'productUrl', $promotedUrm);
    }
    // https://alitems.site/g/1e8d114494bee1754d1816525dc3e8/?ulp=https%3A%2F%2Faliexpress.com%2Fitem%2F2255800758990879.html



    if (isset($post_id) && isset($tags) && count($tags)) {
      // wp_set_post_tags( $post_id, $tags, true );
      wp_set_object_terms($post_id, $tags, 'product_tag');
    }

    if (isset($post_id) && isset($reviews) && count($reviews)) {

      foreach ($reviews as $review) {
        $comment_id = wp_insert_comment(array(
          'comment_post_ID'      => wc_clean($post_id), // <=== The product ID where the review will show up
          'comment_author'       => wc_clean($review['username']),
          'comment_author_email' => wc_clean($review['email']), // <== Important
          'comment_author_url'   => '',
          'comment_content'      => $review['review'],
          'comment_type'         => '',
          'comment_parent'       => 0,
          'user_id'              => 5, // <== Important
          'comment_author_IP'    => '',
          'comment_agent'        => '',
          'comment_date'         => $review['datecreation'],
          'comment_approved'     => 1,
        ));

        // HERE inserting the rating (an integer from 1 to 5)
        update_comment_meta($comment_id, 'rating', wc_clean($review['rating']));
      }
    }





    // wp_send_json($variations);

    if (is_array($variations) && count($variations)) {
      array_splice($variations, 1);
      foreach ($variations as $variation) {

        $attributesVariations = $variation['attributesVariations'];
        $variationToCreate = new WC_Product_Variation();
        // $variationToCreate->set_regular_price(10);
        $variationToCreate->set_parent_id($post_id);
        if (!empty($variation['SKU'])) {
          $variationToCreate->set_sku($variation['SKU']);
        }
        if (!empty(wc_clean($variation['regularPrice']))) {
          $variationToCreate->set_regular_price(wc_clean($variation['regularPrice']));
        }

        if (!empty(wc_clean($variation['salePrice']))) {
          $variationToCreate->set_sale_price(wc_clean($variation['salePrice']));
        }


        $stockProduct = wc_clean($variation['availQuantity']);
        if (isset($stockProduct)) {
          $variationToCreate->set_manage_stock(true);
          $variationToCreate->set_stock_quantity($stockProduct);
          $variationToCreate->set_stock_status('instock');
        }
        $variationsArray = array();
        foreach ($attributesVariations as $attributesVariation) {
          $variationsArray[$attributesVariation['name']] = $attributesVariation['value'];

          $arrayImageId = array();
          if (($importVariationImages == 'true')) {
            // wp_send_json($importVariationImages);

            $imageVariations = $attributesVariation['image'];
            if (isset($imageVariations)) {
              $imageId = false;
              foreach ($arrayImageId as $imageObject) {
                if ($imageObject->imageVariations == $imageVariations) {
                  $imageId = $imageObject->id;
                  break;
                }
              }
              if ($imageId != false) {
                $variationToCreate->set_image_id($imageId);
              } else {
                $imageIdVariation  =  wads_save_single_variation_image($variationToCreate, $imageVariations);
                array_push($arrayImageId, array('image' => $imageVariations, 'id' => $imageIdVariation));
                if (isset($imageIdVariation)) {
                  $variationToCreate->set_image_id($imageIdVariation);
                }
              }
            }
          }
        };

        $variationToCreate->set_attributes($variationsArray);
        try {
          $variationToCreate->save();
        } catch (Exception $e) {
          echo __('Error while saving variation found');
        }
      }
    }
    $results = array(
      'error' => false,
      'error_msg' => '',
      'data' => 'Product inserted successfully'
    );
    wp_send_json($results);
  }
}













function wads_getProductsDraft()
{

  $paged = isset($_POST['paged']) ? wc_clean($_POST['paged']) : '';

  $args = array(
    'post_type'      => 'product',
    'posts_per_page' => 20,
    'paged' => $paged,
    'meta_query' => array(
      array(
        'key' => 'isExpired', //meta key name here
        'value' => 'true',
        'compare' => 'LIKE',
      )
    )


  );

  $products = new WP_Query($args);
  $finalList = array();

  if ($products->have_posts()) {
    while ($products->have_posts()) : $products->the_post();
      $theid = get_the_ID();
      $product = new WC_Product($theid);
      if (has_post_thumbnail()) {
        $thumbnail = get_post_thumbnail_id();
        $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
      }
      $finalList[] = array(
        'sku' => $product->get_sku(),
        'id' => $theid,
        // image => wp_get_attachment_image_src( get_post_thumbnail_id($products->post->ID)),
        'image' => $image,
        'title' =>  $product->get_title(),
        'productUrl' => get_post_meta($theid, 'productUrl', true)

      );
    endwhile;
  } else {
    echo __('No products found');
  }
  wp_reset_postdata();

  wp_send_json($finalList);
}

function wads_getOldProductDetails()
{
  // $productUrl = 'https://www.aliexpress.com/item/4001024639837.html';
  $post_id = isset($_POST['post_id']) ? wc_clean($_POST['post_id']) : '';


  $product = wc_get_product($post_id);
  $oldVariations = $product->get_available_variations();


  wp_send_json($oldVariations);
}


function wads_searchProductBySku()
{
  $searchSkuValue = isset($_POST['searchSkuValue']) ? wc_clean($_POST['searchSkuValue']) : '';

  if (isset($searchSkuValue)) {
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => 1,
      'meta_query' => array(
        array(
          "key" => "_sku",
          "value" => $searchSkuValue,
          "compare" => "LIKE"
        ),
        array(
          'key' => 'productUrl', //meta key name here
          'value' => 'aliexpress.com',
          'compare' => 'LIKE',
        )
      )
    );





    $products = new WP_Query($args);
    $finalList = array();

    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);
        if (has_post_thumbnail()) {
          $thumbnail = get_post_thumbnail_id();
          $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
        }
        $finalList[] = array(
          'sku' => $product->get_sku(),
          'id' => $theid,
          // image => wp_get_attachment_image_src( get_post_thumbnail_id($products->post->ID)),
          'image' => $image,
          'title' =>  $product->get_title(),
          'productUrl' => get_post_meta($theid, 'productUrl', true)

        );
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();

    wp_send_json($finalList);
  } else {
    $results = array(
      'error' => true,
      'error_msg' => 'cannot find result for the introduced sku value, please make sure the product is imported using wooshark',
      'data' => ''
    );
    wp_send_json($results);
  }
}



function wads_removeProductFromShop()
{
  $post_id = isset($_POST['post_id']) ? wc_clean($_POST['post_id']) : '';
  if (isset($post_id)) {
    $id_remove = wp_delete_post($post_id);
    if ($id_remove != false && isset($id_remove)) {
      $results = array(
        'error' => false,
        'error_msg' => '',
        'data' => 'removed successfully'
      );
      wp_send_json($results);
    } else {
      $results = array(
        'error' => trye,
        'error_msg' => 'error while removing the product',
        'data' => ''
      );
      wp_send_json($results);
    }
  }
}




function wads_insertReviewsIntoProduct()
{
  $post_id = isset($_POST['post_id']) ? wc_clean($_POST['post_id']) : '';
  $reviews = isset($_POST['reviews']) ? wc_clean($_POST['reviews']) : array();
  $insertedSuccessfully = array();
  if (isset($post_id) && isset($reviews) && count($reviews)) {

    foreach ($reviews as $review) {
      $comment_id = wp_insert_comment(array(
        'comment_post_ID'      => wc_clean($post_id), // <=== The product ID where the review will show up
        'comment_author'       => wc_clean($review['username']),
        'comment_author_email' => wc_clean($review['email']), // <== Important
        'comment_author_url'   => '',
        'comment_content'      => wc_clean($review['review']),
        'comment_type'         => '',
        'comment_parent'       => 0,
        'user_id'              => 5, // <== Important
        'comment_author_IP'    => '',
        'comment_agent'        => '',
        'comment_date'         => date('Y-m-d H:i:s'),
        'comment_approved'     => 1,
      ));

      // HERE inserting the rating (an integer from 1 to 5)
      $response = update_comment_meta($comment_id, 'rating', wc_clean($review['rating']));
      if ($response != false && isset($response)) {
        array_push($insertedSuccessfully, $comment_id);
      }
    }
    wp_send_json(array('insertedSuccessfully' => $insertedSuccessfully));
  }
}





function wads_getAlreadyImportedProducts()
{
  $listOfSkus = isset($_POST['listOfSkus']) ? wc_clean($_POST['listOfSkus']) : array();

  if (isset($listOfSkus) && count($listOfSkus)) {
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => 40,
      'meta_query' => array(
        array(
          "key" => "_sku",
          "value" => $listOfSkus,
          "compare" => "IN"
        ), array(
          'key' => 'productUrl', //meta key name here
          'value' => 'aliexpress.com',
          'compare' => 'LIKE',
        )
      )
    );
    $products = new WP_Query($args);
    $finalList = array();

    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);

        $finalList[] = array(
          'sku' => $product->get_sku(),
          'id' => $theid,
          'title' =>  $product->get_title(),
          'productUrl' => get_post_meta($theid, 'productUrl', true)

        );
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();

    wp_send_json($finalList);
  }
}





function wads_getSKuAbdUrlByCategory()
{

  $categoryId = isset($_POST['categoryId']) ? wc_clean($_POST['categoryId']) : array();

  if (isset($categoryId)) {
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => -1,
      'post_status' => array('publish'),
      'meta_query' => array(
        array(
          'key' => 'productUrl', //meta key name here
          'value' => 'aliexpress.com',
          'compare' => 'LIKE',
        )
      ),
      'tax_query'             => array(
        array(
          'taxonomy'      => 'product_cat',
          'field' => 'term_id', //This is optional, as it defaults to 'term_id'
          'terms'         => $categoryId,
          'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        )
      )


    );
    $products = new WP_Query($args);
    $finalList = array();

    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);
        $finalList[] = array(
          'sku' => $product->get_sku(),
          'id' => $theid,
          'productUrl' => get_post_meta($theid, 'productUrl', true)

        );
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();

    wp_send_json($finalList);
  }
}


function wads_getOrders()
{
  $query = new WC_Order_Query(array(
    'limit' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'ids',
  ));
  $orders = $query->get_orders();
  wp_send_json($orders);
}




function wads_searchCategoryByName()
{
  $searchCategoryByNameInput = isset($_POST['searchCategoryByNameInput']) ? wc_clean(($_POST['searchCategoryByNameInput'])) : array();
  $product_categories  = get_terms('category', array('search' => $searchCategoryByNameInput));
  wp_send_json($product_categories);
}



// helper 

// function upload_image($imageurl)
// {

//   include_once(ABSPATH . 'wp-admin/includes/image.php');
//   $imagetype = end(explode('/', getimagesize($imageurl)['mime']));
//   $uniq_name = date('dmY') . '' . (int) microtime(true);
//   $filename = $uniq_name . '.' . $imagetype;

//   $uploaddir = wp_upload_dir();
//   $uploadfile = $uploaddir['path'] . '/' . $filename;
//   $contents = file_get_contents($imageurl);
//   $savefile = fopen($uploadfile, 'w');
//   fwrite($savefile, $contents);
//   fclose($savefile);

//   $wp_filetype = wp_check_filetype(basename($filename), null);
//   $attachment = array(
//     'post_mime_type' => $wp_filetype['type'],
//     'post_title' => $filename,
//     'post_content' => '',
//     'post_status' => 'inherit'
//   );

//   $attach_id = wp_insert_attachment($attachment, $uploadfile);
//   // $imagenew = get_post($attach_id);
//   // $fullsizepath = get_attached_file($imagenew->ID);
//   // $attach_data = wp_generate_attachment_metadata($attach_id, $fullsizepath);
//   // wp_update_attachment_metadata($attach_id, $attach_data);

//   // echo $attach_id;
//   return $attach_id;
// }


function wads_save_product_images($product, $images)
{
  if (is_array($images)) {
    array_splice($images, 1);

    $gallery = array();
    foreach ($images as $key => $image) {
      if (isset($image)) {
        $upload = wc_rest_upload_image_from_url(esc_url_raw($image));
        if (is_wp_error($upload)) {
          if (!apply_filters('woocommerce_rest_suppress_image_upload_error', false, $upload, $product->get_id(), $images)) {
            throw new WC_REST_Exception('woocommerce_product_image_upload_error', $upload->get_error_message(), 400);
          } else {
            continue;
          }
        }
        $attachment_id = wc_rest_set_uploaded_image_as_attachment($upload, $product->get_id());
      }
      if ($key == 0) {
        $product->set_image_id($attachment_id);
      } else {
        array_push($gallery, $attachment_id);
      }
    }
    if (!empty($gallery)) {
      $product->set_gallery_image_ids($gallery);
    }
  } else {
    $product->set_image_id('');
    $product->set_gallery_image_ids(array());
  }
  return $product;
}


function wads_save_single_variation_image($product, $image)
{
  $gallery = array();
  if (isset($image)) {
    $upload = wc_rest_upload_image_from_url(esc_url_raw($image));
    if (is_wp_error($upload)) {
      if (!apply_filters('woocommerce_rest_suppress_image_upload_error', false, $upload, $product->get_id(), $image)) {
        throw new WC_REST_Exception('woocommerce_product_image_upload_error', $upload->get_error_message(), 400);
      }
    }
    $attachment_id = wc_rest_set_uploaded_image_as_attachment($upload, $product->get_id());
  }
  $product->set_image_id($attachment_id);
  return $attachment_id;
}


function wads_searchProductByIdReviews()
{
  $searchSkuValue = isset($_POST['searchSkuValue']) ? wc_clean($_POST['searchSkuValue']) : '';

  if (isset($searchSkuValue)) {
    $args = array(
      'post_type'      => 'product',
      'posts_per_page' => 1,
      'p' => $searchSkuValue
      // 'meta_query' => array(
      //   array(
      //     "key" => "_sku",
      //     "value" => $searchSkuValue,
      //     "compare" => "LIKE"
      //   )
      // )
    );





    $products = new WP_Query($args);
    $finalList = array();

    if ($products->have_posts()) {
      while ($products->have_posts()) : $products->the_post();
        $theid = get_the_ID();
        $product = new WC_Product($theid);
        if (has_post_thumbnail()) {
          $thumbnail = get_post_thumbnail_id();
          $image = $thumbnail ? wp_get_attachment_url($thumbnail) : '';
        }
        $finalList[] = array(
          'sku' => $product->get_sku(),
          'id' => $theid,
          // image => wp_get_attachment_image_src( get_post_thumbnail_id($products->post->ID)),
          'image' => $image,
          'title' =>  $product->get_title(),
          'productUrl' => get_post_meta($theid, 'productUrl', true),
          'lastUpdated' => get_post_meta($theid, 'lastUpdated', true),
          'status' => $product->get_status()


        );
      endwhile;
    } else {
      echo __('No products found');
    }
    wp_reset_postdata();

    wp_send_json($finalList);
  } else {
    $results = array(
      'error' => true,
      'error_msg' => 'cannot find result for the introduced sku value, please make sure the product is imported using wooshark',
      'data' => ''
    );
    wp_send_json($results);
  }
}



function wads_saveOptionsDB()
{
  $isShippingCostEnabled = isset($_POST['isShippingCostEnabled']) ? wc_clean($_POST['isShippingCostEnabled']) : 'N';
  $isEnableAutomaticUpdateForAvailability = isset($_POST['isEnableAutomaticUpdateForAvailability']) ? wc_clean($_POST['isEnableAutomaticUpdateForAvailability']) : 'N';
  $isUpdateRegularPrice = isset($_POST['isUpdateRegularPrice']) ? wc_clean($_POST['isUpdateRegularPrice']) : 'N';
  $isUpdateSalePrice = isset($_POST['isUpdateSalePrice']) ? wc_clean($_POST['isUpdateSalePrice']) : 'N';
  $isUpdateStock = isset($_POST['isUpdateStock']) ? wc_clean($_POST['isUpdateStock']) : 'N';
  $priceFormulaIntervalls = isset($_POST['priceFormulaIntervalls']) ? wc_clean($_POST['priceFormulaIntervalls']) : array();
  $onlyPublishProductWillSync = isset($_POST['onlyPublishProductWillSync']) ? wc_clean($_POST['onlyPublishProductWillSync']) : 'N';
  $enableAutomaticUpdates = isset($_POST['enableAutomaticUpdates']) ? wc_clean($_POST['enableAutomaticUpdates']) : 'N';
  $applyPriceFormulaAutomaticUpdate = isset($_POST['applyPriceFormulaAutomaticUpdate']) ? wc_clean($_POST['applyPriceFormulaAutomaticUpdate']) : 'N';
  $syncRegularPrice = isset($_POST['syncRegularPrice']) ? wc_clean($_POST['syncRegularPrice']) : 'N';
  $syncSalePrice = isset($_POST['syncSalePrice']) ? wc_clean($_POST['syncSalePrice']) : 'N';
  $syncStock = isset($_POST['syncStock']) ? wc_clean($_POST['syncStock']) : 'N';
  $_savedConfiguration = isset($_POST['_savedConfiguration']) ? wc_clean($_POST['_savedConfiguration']) : null;

  if (isset($_savedConfiguration)) {
    update_option('_savedConfiguration',   $_savedConfiguration);
  }



  if (isset($syncRegularPrice)) {
    update_option('syncRegularPrice', $syncRegularPrice);
  }

  if (isset($syncSalePrice)) {
    update_option('syncSalePrice', $syncSalePrice);
  }

  if (isset($syncStock)) {
    update_option('syncStock', $syncStock);
  }

  // wp_send_json($updateVariationsOnServer);
  if (isset($priceFormulaIntervalls)) {
    update_option('priceFormulaIntervalls', $priceFormulaIntervalls);
  }

  if (isset($isShippingCostEnabled)) {
    update_option('isShippingCostEnabled', $isShippingCostEnabled);
  }

  if (isset($isEnableAutomaticUpdateForAvailability)) {
    update_option('isEnableAutomaticUpdateForAvailability', $isEnableAutomaticUpdateForAvailability);
  }


  // if (isset($removeVariationIfStockIsEmpty)) {
  //   update_option('removeVariationIfStockIsEmpty', $removeVariationIfStockIsEmpty);
  // }


  // if (isset($setToOutOfStockIfVariationsDoesNotExist)) {
  //   update_option('setToOutOfStockIfVariationsDoesNotExist', $setToOutOfStockIfVariationsDoesNotExist);
  // }


  if (isset($isUpdateRegularPrice)) {
    update_option('isUpdateRegularPrice', $isUpdateRegularPrice);
  }


  if (isset($isUpdateSalePrice)) {
    update_option('isUpdateSalePrice', $isUpdateSalePrice);
  }


  if (isset($isUpdateStock)) {
    update_option('isUpdateStock', $isUpdateStock);
  }
  if (isset($onlyPublishProductWillSync)) {
    update_option('onlyPublishProductWillSync', $onlyPublishProductWillSync);
  }
  if (isset($enableAutomaticUpdates)) {
    update_option('enableAutomaticUpdates', $enableAutomaticUpdates);
  }
  if (isset($applyPriceFormulaAutomaticUpdate)) {
    update_option('applyPriceFormulaAutomaticUpdate', $applyPriceFormulaAutomaticUpdate);
  }


  wp_send_json($isShippingCostEnabled);
}



function wads_insertReviewsIntoProductRM_PREMUIM_PLUGIN()
{
  $post_id = isset($_POST['post_id']) ? wc_clean($_POST['post_id']) : '';
  $reviews = isset($_POST['reviews']) ? wc_clean($_POST['reviews']) : array();
  $insertedSuccessfully = array();
  if (isset($post_id) && isset($reviews) && count($reviews)) {

    foreach ($reviews as $review) {
      $comment_id = wp_insert_comment(array(
        'comment_post_ID'      => wc_clean($post_id), // <=== The product ID where the review will show up
        'comment_author'       => wc_clean($review['username']),
        'comment_author_email' => wc_clean($review['email']), // <== Important
        'comment_author_url'   => '',
        'comment_content'      => $review['review'],
        'comment_type'         => '',
        'comment_parent'       => 0,
        'user_id'              => 5, // <== Important
        'comment_author_IP'    => '',
        'comment_agent'        => '',
        'comment_date'         => wc_clean($review['datecreation']),
        'comment_approved'     => 1,
      ));

      // HERE inserting the rating (an integer from 1 to 5)
      $response = update_comment_meta($comment_id, 'rating', wc_clean($review['rating']));
      if ($response != false && isset($response)) {
        array_push($insertedSuccessfully, $comment_id);
      }
    }
    wp_send_json(array('insertedSuccessfully' => $insertedSuccessfully));
  }
}




function wads_restoreConfiguration()
{
  $_savedConfiguration  = get_option('_savedConfiguration');
  wp_send_json(array('_savedConfiguration' => $_savedConfiguration));
}
