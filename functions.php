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
    if (true) {
      require_once( plugin_dir_path( __FILE__ ) . 'amazon-affiliate.php' );
    } else {
      require_once( plugin_dir_path( __FILE__ ) . 'rakuten-affiliate.php' );
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

?>
