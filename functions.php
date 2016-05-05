<?php
define("DEBUG", true);

function debug($message) {
  if (DEBUG) {
    echo $message . "<br>";
  }
}

function debug_obj($obj) {
  if (DEBUG) {
    echo "<pre>" . var_dump($obj) . "</pre>";
  }
}

// Initialization
function add_init(){
    // add css
    debug("load css");
    wp_register_style('riara_css', plugins_url('style.css', __FILE__));
    wp_enqueue_style('riara_css');
}

// for setting page
function display_riara_settings() {
  require_once( plugin_dir_path( __FILE__ ) . 'settings.php' );
}

// display_related item by Amazon, Rakuten affiliate.
function display_riara() {
  
  // if not set the keyword, not request to API.
  if (empty(get_search_keyword())) {
    echo get_default_banner();
    return;
  }
  
  switch (get_site_option('riara_display_service')) {
    case "Amazon":
      require_once( plugin_dir_path( __FILE__ ) . 'amazon-affiliate.php' );
      break;
    case "Rakuten":
      require_once( plugin_dir_path( __FILE__ ) . 'rakuten-affiliate.php' );
      break;
  }
    
}

function get_search_keyword () {
  switch (get_site_option('riara_search_by')){
    case "Category Name":
      $categories = get_the_category();
      foreach($categories as $category) {
        return $category->cat_name;
      }
    case "Category Description":
      $categories = get_the_category();
      foreach($categories as $category) {
        return $category->category_description;
      }
    case "Tag Name":
      $tags = get_the_tags();
      foreach($tags as $tag) {
        return $tag->name;
      }
    case "Tag Description":
      $tags = get_the_tags();
      foreach($tags as $tag) {
        return $tag->description;
      }
    default:
      return NULL;
  }
}

function generate_amazon_request_url($keywords) {
  // for signnature
  $params = array();
  $params['Service'] = 'AWSECommerceService';
  $params['AWSAccessKeyId'] = get_site_option('riara_amazon_access_key');
  $params['Operation'] = 'ItemSearch';
  $params['SearchIndex'] = get_site_option('riara_amazon_search_index');
  $params['AssociateTag'] = get_site_option('riara_amazon_associate_tag');
  $params['Version'] = '2011-08-02';
  $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
  //$params['Sort'] = 'salesrank';
  $params['ResponseGroup'] = 'Medium';
  $params['Keywords'] = $keywords;
  $params['ItemPage'] = 1;    
  ksort($params);

  $canonical_string = '';
  foreach ($params as $k => $v) {
    $canonical_string .= '&' . rawurlencode($k) . '=' . rawurlencode($v);
  } 

  $canonical_string = substr($canonical_string, 1);
  $parsed_url = parse_url(get_site_option('riara_amazon_api_endpoint'));
  $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
  $params['Signature'] = rawurlencode(base64_encode(hash_hmac('sha256', $string_to_sign, get_site_option('riara_amazon_secret_access_key'), true)));
  return get_site_option('riara_amazon_api_endpoint') . '?' . $canonical_string . '&Signature=' . $params['Signature'];
}

function generate_rakuten_request_url($keyword) {
  $params = array();
  $params['format'] = 'xml';
  $params['keyword'] = $keyword;
  $params['applicationId'] = get_site_option('riara_rakuten_application_id');
  $params['affiliateId'] = get_site_option('riara_rakuten_affiliate_id');
  
  if (wp_is_mobile()) {
    $params['hits'] = get_site_option('riara_max_item_number_mobile');
  } else {
    $params['hits'] = get_site_option('riara_max_item_number_pc');
  }

  ksort($params);
  
  $canonical_string = '';
  foreach ($params as $k => $v) {
    $canonical_string .= '&' . rawurlencode($k) . '=' . rawurlencode($v);
  }
  $canonical_string = substr($canonical_string, 1);
  return get_site_option('riara_rakuten_api_endpoint') . '?' . $canonical_string;
  
}

function get_item_name($name, $size) {
  require( plugin_dir_path( __FILE__ ) . 'common.php' );
  
  switch (get_site_option('riara_display_service')) {
    case "Amazon":
      $max_num = $riara_title_max_num[$size];
      break;
    case "Rakuten":
      $max_num = round($riara_title_max_num[$size] * 0.5);
      break;
  }
  
  if (mb_strlen($name) > $max_num) {
    return mb_substr(strip_tags($name), 0, $max_num, 'UTF-8') . " …";
  } else {
    return $name;
  }
}

function get_item_attributes($item) {
  require( plugin_dir_path( __FILE__ ) . 'common.php' );
  
  $attributes = array();
  $size = get_site_option('riara_image_size');
  
  switch (get_site_option('riara_display_service')) {
    
    case "Amazon":
      
      $attributes["item_name"] =$item->ItemAttributes->Title;
      $attributes["short_item_name"] =get_item_name($item->ItemAttributes->Title, $size);
      $attributes["item_url"] = $item->DetailPageURL;
      $attributes["image_height"] = $riara_amazon_image_heights[$size];
      
      if (get_site_option('riara_is_display_title')) {
        $attributes["item_height"] = $riara_amazon_item_heights[$size];
      } else {
        // if the title doesn't need to display, the item height is same as image height.
        $attributes["item_height"] = $attributes["image_height"];
      }
      
      switch ($size) {
        case "Small":
          $attributes["image_width"] = round(($attributes["image_height"] / $item->MediumImage->Height) * $item->MediumImage->Width);
          $attributes["image_url"] = $item->MediumImage->URL;
          break;
        case "Medium":
          $attributes["image_width"] = round(($attributes["image_height"] / $item->LargeImage->Height) * $item->LargeImage->Width);
          $attributes["image_url"] = $item->LargeImage->URL;
          break;
        case "Large":
          $attributes["image_width"] = round(($attributes["image_height"] / $item->LargeImage->Height) * $item->LargeImage->Width);
          $attributes["image_url"] = $item->LargeImage->URL;
          break;
      }
      
      // Same as item width and image width.
      $attributes["item_width"] = $attributes["image_width"];
      
      if (empty($attributes["image_url"])){
        if (get_site_option('riara_skip_no_image_item')) {
          $attributes["image_url"] = NULL;
        } else {
          $attributes["image_url"] = AMAZON_NO_IMAGE;
        }
      }
      
      return $attributes;
      
    case "Rakuten":
      
      // not set image_width because API doesn't return image height and width so we can't define these value.
      
      $attributes["item_url"] = $item->affiliateUrl;
      $attributes["item_width"] = $riara_rakuten_item_widths[$size];
      $attributes["image_height"] = $riara_rakuten_image_heights[$size];
      
      if (get_site_option('riara_is_display_title')) {
        $attributes["item_height"] = $riara_rakuten_item_heights[$size];
      } else {
        // if the title doesn't need to display, the item height is same as image height.
        $attributes["item_height"] = $attributes["image_height"];
      }
      
      $api_name = array_search(get_site_option('riara_rakuten_api_endpoint'), $riara_rakuten_api_endpoints);
      
      if ($api_name == "IchibaItem") {
        
        $attributes["item_name"] =$item->itemName;
        $attributes["short_item_name"] =get_item_name($item->itemName, $size);
        
        switch ($size) {
        
          case "Small":
            $attributes["image_url"] = $item->smallImageUrls->imageUrl[0];
            break;
            
          case "Medium":
            $attributes["image_url"] = $item->mediumImageUrls->imageUrl[0];
            break;
            
          // Large size doesn't exist in API response
          case "Large":
            $attributes["image_url"] = $item->mediumImageUrls->imageUrl[0];
            break;
        }
        
      } elseif ($api_name == "BooksTotal" || $api_name == "BooksBook" ) {
        
        $attributes["item_name"] =$item->title;
        $attributes["short_item_name"] =get_item_name($item->title, $size);
        
        switch ($size) {
        
          case "Small":
            $attributes["image_url"] = $item->smallImageUrl;
            break;
            
          case "Medium":
            $attributes["image_url"] = $item->mediumImageUrl;
            break;
            
          case "Large":
            $attributes["image_url"] = $item->largeImageUrl;
            break;
        }
        
      } else {
      }
      
      // Rakuten API always return image url (include no image url)
      if(strpos($attributes["image_url"],'noimage') !== false) {
        if (get_site_option('riara_skip_no_image_item')) {
          $attributes["image_url"] = NULL;
        }
      }
      
      return $attributes;
      
  }
  
}

function get_default_banner() {
  if (wp_is_mobile()) {
    return get_site_option('riara_default_banner_mobile');
  } else {
    return get_site_option('riara_default_banner_pc');
  }
}

?>
