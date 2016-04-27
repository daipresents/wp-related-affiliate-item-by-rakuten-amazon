<?php

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
   
    switch (get_site_option('riara_display_value')) {
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

function generate_amazon_api_url($keywords) {
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
  $parsed_url = parse_url(get_site_option('riara_amazon_api_url'));
  $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
  $params['Signature'] = rawurlencode(base64_encode(hash_hmac('sha256', $string_to_sign, get_site_option('riara_amazon_secret_access_key'), true)));
  return get_site_option('riara_amazon_api_url') . '?' . $canonical_string . '&Signature=' . $params['Signature'];
}

function generate_rakuten_api_url($keyword) {
  $params = array();
  $params['format'] = 'xml';
  $params['sort'] = 'sales';
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
  return get_site_option('riara_rakuten_api_type') . '?' . $canonical_string;
  
}

function get_item_url($item) {
  switch (get_site_option('riara_display_value')) {
    case "Amazon":
      return $item->DetailPageURL;
    case "Rakuten":
      return $item->affiliateUrl;
    default:
      return "";
  }
}

function get_item_title($item) {
  
  switch (get_site_option('riara_display_value')) {
    
    case "Amazon":
      return $item->ItemAttributes->Title;
    
    case "Rakuten":
      if (get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222") {
        return $item->itemName;
        
      } elseif (get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522" ||
                get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522") {
        
        return $item->title;
        
      } else {
        return "";
      }

    default:
      return "";
  }
}

function get_item_image($item) {
  switch (get_site_option('riara_display_value')) {
    
    case "Amazon":
      
      switch (get_site_option('riara_image_size')) {
        case "Small":
          return $item->SmallImage->URL;
        case "Medium":
          return $item->MediumImage->URL;
        case "Large":
          return $item->LargeImage->URL;
        default:
          return "";
      }
    
    case "Rakuten":
      
      if (get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222") {
        
        switch (get_site_option('riara_image_size')) {
          case "Small":
            return $item->smallImageUrls[0];
          case "Medium":
            return $item->mediumImageUrls[0];
          case "Large":
            return $item->largeImageUrls[0];
          default:
            return "";
        }
        
      } elseif (get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522" ||
                get_site_option('riara_rakuten_api_type') == "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522") {
        
        switch (get_site_option('riara_image_size')) {
          case "Small":
            return $item->smallImageUrl;
          case "Medium":
            return $item->mediumImageUrl;
          case "Large":
            return $item->largeImageUrl;
          default:
            return "";
        }
        
      } else {
        return "";
      }
     
    default:
      return "";
  }
}

?>
