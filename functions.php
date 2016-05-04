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

// for setting page
function display_riara_settings() {
  require_once( plugin_dir_path( __FILE__ ) . 'settings.php' );
}

// display_item
function display_riara() {
  $tags = get_the_tags();
  if (!$tags){
    if (wp_is_mobile()) {
      echo get_site_option('riara_banner_pc');
    } else {
      echo get_site_option('riara_banner_mobile');
    }
  } else {
   
    switch (get_site_option('riara_display_service')) {
      case "Amazon":
        require_once( plugin_dir_path( __FILE__ ) . 'amazon-affiliate.php' );
        break;
      case "Rakuten":
        require_once( plugin_dir_path( __FILE__ ) . 'rakuten-affiliate.php' );
        break;
    }
    
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
      return get_site_option('riara_default_search_word');
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

function get_item_url($item) {
  switch (get_site_option('riara_display_service')) {
    case "Amazon":
      return $item->DetailPageURL;
    case "Rakuten":
      return $item->affiliateUrl;
    default:
      return "";
  }
}

function get_item_title($item) {
  
  switch (get_site_option('riara_display_service')) {
    
    case "Amazon":
      return $item->ItemAttributes->Title;
    
    case "Rakuten":
      if (get_site_option('riara_rakuten_api_endpoint') == "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222") {
        return $item->itemName;
        
      } elseif (get_site_option('riara_rakuten_api_endpoint') == "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522" ||
                get_site_option('riara_rakuten_api_endpoint') == "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522") {
        
        return $item->title;
        
      } else {
        return "";
      }
  }
}

function get_item_image($item) {
  require( plugin_dir_path( __FILE__ ) . 'common.php' );
  
  $image_url = "";
  
  $service = get_site_option('riara_display_service');
  $size_key = array_search(get_site_option('riara_image_size'), $riara_image_sizes);
  
  switch ($service) {
    
    case "Amazon":
      
      switch ($size_key) {
        case "Small":
          $image_url = $item->SmallImage->URL;
          break;
        case "Medium":
          $image_url =  $item->MediumImage->URL;
          break;
        case "Large":
          $image_url = $item->LargeImage->URL;
          break;
      }
      
      if (empty($image_url)) {
        return "http://g-ecx.images-amazon.com/images/G/09/icons/books/comingsoon_books._V376986337_BO1,204,203,200_.gif";
      }
      
      return $image_url;
      
    case "Rakuten":
      
      $rakuten_api_endpoint = get_site_option('riara_rakuten_api_endpoint');
      $api_name = array_search($rakuten_api_endpoint, $riara_rakuten_api_endpoints);
      
      if ($api_name == "IchibaItem") {
        
        switch ($size_key) {
          case "Small":
            $image_url = $item->smallImageUrls->imageUrl[0];
            break;
          case "Medium":
            $image_url = $item->mediumImageUrls->imageUrl[0];
            break;
          // not exist in API response
          case "Large":
            $image_url = $item->mediumImageUrls->imageUrl[0];
            break;
        }
        
      } elseif ($api_name == "BooksTotal" ||
                $api_name == "BooksBook" ) {
        
        switch ($size_key) {
          case "Small":
            $image_url = $item->smallImageUrl;
            break;
          case "Medium":
            $image_url = $item->mediumImageUrl;
            break;
          case "Large":
            $image_url = $item->largeImageUrl;
            break;
        }
        
      } else {
      }

      if (empty($image_url)) {
        return "http://thumbnail.image.rakuten.co.jp/@0_mall/book/cabinet/noimage_01.gif?_ex=130x130&s=2&r=0";
      }
      
      return $image_url;

  }
  
}

function get_image_size() {
  return get_site_option('riara_image_size');
}

?>
