<?php
/*  Copyright 2016 Dai Fujihara  (email : daipresents[at]gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Affiliate {

  private $wp_raira_title_max_num = array(
    "Small"  => 12,
    "Medium" => 18,
    "Large"  => 35,
  );
  
  // Amazon: Small (75x58), Medium (160x124), Large (500x389)
  private $wp_raira_amazon_image_heights = array(
    "Small"  => 130,
    "Medium" => 200,
    "Large"  => 270,
  );

  // image height + title height
  private $wp_raira_amazon_item_heights = array(
    "Small"  => 170,
    "Medium" => 240,
    "Large"  => 310,
  );

  // Item size are Small (64x64), Medium (128x128), Large (200x200) in Rakuten wchich are wrriten in API docs but they return only following image size:
  // Rakuten Ichiba: Small (64x64), Medium (128x128), Large (Nothing)
  // Rakuten Books : Small (64x42), Medium (120x80), Large (180x120)
  private $wp_raira_rakuten_image_heights = array(
    "Small"  =>  60,
    "Medium" => 115,
    "Large"  => 170,
  );
  
  // fixed value for Rakuten because of small image.
  private $wp_raira_rakuten_item_widths = array(
    "Small"  =>  42,
    "Medium" =>  80,
    "Large"  => 120,
  );

  // image height + title height
  private $wp_raira_rakuten_item_heights = array(
    "Small"  => 135,
    "Medium" => 160,
    "Large"  => 225,
  );

  // return the result or false
  private function get_api_response($url) {
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
    $result = curl_exec( $ch );
    curl_close( $ch );
    return $result;
  }
  
  public function execute($test = false) {
    
    // not display error message for security.
    ini_set( 'display_errors', 0 );
    
    // $xml is main parameter for view file.
    $xml = null;
    
    // if not set the keyword, not request to API.
    $keywords = "";
    if($test) {
      // test mode
      $keywords = "Osaka";
    } else {
      $keywords = $this->get_search_keywords();
      if (empty($keywords) || !get_site_option('wp_raira_is_display')) {
        echo $this->get_default_banner();
        return;
      }
    }
    
    switch (get_site_option('wp_raira_display_service')) {
      
      case "Amazon":
        if ($response = $this->get_api_response($this->generate_amazon_request_url($keywords))) {
          $xml = simplexml_load_string($response);
          
          // No result
          if ($xml->Items->Request->Errors) {
            error_log("Error code: " . $xml->Items->Request->Errors->Error->Code . " Message: " . $xml->Items->Request->Errors->Error->Message , 0);
            echo $this->get_default_banner();
            return NULL;
          }
          
          return $xml;
          
        } else {
          error_log("file_get_contents failed. Maybe failed to open stream: HTTP request failed! HTTP/1.1 503 Service Unavailable or please check your API setting (Access Key, Secret Access Key)", 0);
          echo $this->get_default_banner();
          return NULL;
        }
        
      case "Rakuten":
        $url = $this->generate_rakuten_request_url($keywords);
        if ($response = $this->get_api_response($url)) {
          $xml = simplexml_load_string($response);
          
          // No result
          if ($xml->count == 0) {
            echo $this->get_default_banner();
            return NULL;
          }
          
          return $xml;
          
        } else {
          // API error
          error_log("file_get_contents failed. url = " . $url, 0);
          echo $this->get_default_banner();
          return NULL;
        }
    }
  }
  
  private function get_default_banner() {
    if (wp_is_mobile()) {
      return get_site_option('wp_raira_default_banner_mobile');
    } else {
      return get_site_option('wp_raira_default_banner_pc');
    }
  }

  private function give_me_donate() {
    if ((mt_rand(1, 10) % 10) === 0) {
      return true;
    } else {
      return false;
    }
  }

  private function get_affiliate_tag() {
    switch (get_site_option('wp_raira_display_service')) {
      case "Amazon":
        if ($this->give_me_donate()) {
          return get_site_option('wp_raira_default_amazon_associate_tag');
        } else {
          $tag = get_site_option('wp_raira_amazon_associate_tag');
          if (empty($tag)) {
            return get_site_option('wp_raira_default_amazon_associate_tag');
          } else {
            return $tag;
          }
        }
        
      case "Rakuten":
        if ($this->give_me_donate()) {
          return get_site_option('wp_raira_default_rakuten_affiliate_id');
        } else {
          $tag = get_site_option('wp_raira_rakuten_affiliate_id');
          if (empty($tag)) {
            return get_site_option('wp_raira_default_rakuten_affiliate_id');
          } else {
            return $tag;
          }
        }
    }
  }

  private function generate_amazon_request_url($keywords) {
    // for signnature
    $params = array();
    $params['Service'] = 'AWSECommerceService';
    $params['AWSAccessKeyId'] = get_site_option('wp_raira_amazon_access_key');
    $params['Operation'] = 'ItemSearch';
    $params['SearchIndex'] = get_site_option('wp_raira_amazon_search_index');
    $params['AssociateTag'] = $this->get_affiliate_tag();
    $params['Version'] = '2011-08-02';
    $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
    // if this option set, the result is not natural so comment out.
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
    $parsed_url = parse_url(get_site_option('wp_raira_amazon_api_endpoint'));
    $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
    $params['Signature'] = rawurlencode(base64_encode(hash_hmac('sha256', $string_to_sign, get_site_option('wp_raira_amazon_secret_access_key'), true)));
    return get_site_option('wp_raira_amazon_api_endpoint') . '?' . $canonical_string . '&Signature=' . $params['Signature'];
  }

  private function generate_rakuten_request_url($keywords) {
    $params = array();
    $params['format'] = 'xml';
    $params['keyword'] = $keywords;
    $params['applicationId'] = get_site_option('wp_raira_rakuten_application_id');
    $params['affiliateId'] = $this->get_affiliate_tag();
    
    if (wp_is_mobile()) {
      $params['hits'] = get_site_option('wp_raira_max_item_number_mobile');
    } else {
      $params['hits'] = get_site_option('wp_raira_max_item_number_pc');
    }

    ksort($params);
    
    $canonical_string = '';
    foreach ($params as $k => $v) {
      $canonical_string .= '&' . rawurlencode($k) . '=' . rawurlencode($v);
    }
    $canonical_string = substr($canonical_string, 1);
    return get_site_option('wp_raira_rakuten_api_endpoint') . '?' . $canonical_string;
    
  }

  private function get_search_keywords () {
    switch (get_site_option('wp_raira_search_by')){
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

  public function get_item_attributes($item) {
    
    $attributes = array();
    $size = get_site_option('wp_raira_image_size');
    
    switch (get_site_option('wp_raira_display_service')) {
      
      case "Amazon":
        $attributes["item_name"] =$item->ItemAttributes->Title;
        $attributes["short_item_name"] = $this->get_item_name($item->ItemAttributes->Title, $size);
        $attributes["item_url"] = $item->DetailPageURL;
        $attributes["image_height"] = $this->wp_raira_amazon_image_heights[$size];
        
        if (get_site_option('wp_raira_is_display_item_name')) {
          $attributes["item_height"] = $this->wp_raira_amazon_item_heights[$size];
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
          if (get_site_option('wp_raira_skip_no_image_item')) {
            $attributes["image_url"] = NULL;
          } else {
            $attributes["image_url"] = AMAZON_NO_IMAGE;
          }
        }
        
        return $attributes;
        
      case "Rakuten":
        
        // not set image_width because API doesn't return image height and width so we can't define these value.
        
        $attributes["item_url"] = $item->affiliateUrl;
        $attributes["item_width"] = $this->wp_raira_rakuten_item_widths[$size];
        $attributes["image_height"] = $this->wp_raira_rakuten_image_heights[$size];
        
        if (get_site_option('wp_raira_is_display_item_name')) {
          $attributes["item_height"] = $this->wp_raira_rakuten_item_heights[$size];
        } else {
          // if the title doesn't need to display, the item height is same as image height.
          $attributes["item_height"] = $attributes["image_height"];
        }
        
        $api_name = get_site_option('wp_raira_rakuten_api_endpoint');
        
        if ($api_name == "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222") {
          
          $attributes["item_name"] =$item->itemName;
          $attributes["short_item_name"] =$this->get_item_name($item->itemName, $size);
          
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
          
        } elseif ($api_name == "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522" || $api_name == "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522" ) {
          
          $attributes["item_name"] =$item->title;
          $attributes["short_item_name"] = $this->get_item_name($item->title, $size);
          
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
          if (get_site_option('wp_raira_skip_no_image_item')) {
            $attributes["image_url"] = NULL;
          }
        }
        
        return $attributes;
        
    }
    
  }

  private function get_item_name($name, $size) {
    
    switch (get_site_option('wp_raira_display_service')) {
      case "Amazon":
        $max_num = $this->wp_raira_title_max_num[$size];
        break;
      case "Rakuten":
        $max_num = round($this->wp_raira_title_max_num[$size] * 0.5);
        break;
    }
    
    if (mb_strlen($name) > $max_num) {
      return mb_substr(strip_tags($name), 0, $max_num, 'UTF-8') . " …";
    } else {
      return $name;
    }
  }

}

?>
