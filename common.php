<?php
define("AMAZON_NO_IMAGE", "http://g-ecx.images-amazon.com/images/G/09/icons/books/comingsoon_books._V376986337_BO1,204,203,200_.gif");

$wp_raira_search_by_list = array(
  "Category Name" => "Category Name",
  "Category Description" => "Category Description",
  "Tag Name" => "Tag Name",
  "Tag Description" => "Tag Description",
);

$wp_raira_amazon_api_endpoints = array(
  "JP" => "https://webservices.amazon.co.jp/onca/xml",
//  "US" => "https://webservices.amazon.com/onca/xml",
//  "UK" => "https://webservices.amazon.co.uk/onca/xml",
//  "MX" => "https://webservices.amazon.com.mx/onca/xml",
//  "IT" => "https://webservices.amazon.it/onca/xml",
//  "IN" => "https://webservices.amazon.in/onca/xml",
//  "FR" => "https://webservices.amazon.fr/onca/xml",
//  "ES" => "https://webservices.amazon.es/onca/xml",
//  "DE" => "https://webservices.amazon.de/onca/xml",
//  "CN" => "https://webservices.amazon.cn/onca/xml",
//  "CA" => "https://webservices.amazon.ca/onca/xml",
//  "BR" => "https://webservices.amazon.com.br/onca/xml",
);

$wp_raira_amazon_search_indexes = array(
  "All" => "All",
  "Books" => "Books",
);

$wp_raira_rakuten_api_endpoints = array(
  "IchibaItem" => "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222",
  "BooksTotal" => "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522",
  "BooksBook" => "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522",
);

$wp_raira_title_max_num = array(
  "Small"  => 12,
  "Medium" => 18,
  "Large"  => 35,
);

// Image Size
$wp_raira_image_sizes = array(
  "Small" => "Small",
  "Medium" => "Medium",
  "Large" => "Large",
);

// Amazon: Small (75x58), Medium (160x124), Large (500x389)
$wp_raira_amazon_image_heights = array(
  "Small"  => 160,
  "Medium" => 230,
  "Large"  => 300,
);

$wp_raira_amazon_item_heights = array(
  "Small"  => 200,
  "Medium" => 270,
  "Large"  => 340,
);

// Item size are Small (64x64), Medium (128x128), Large (200x200) in Rakuten wchich are wrriten in API docs but they return only following image size:
// Rakuten Ichiba: Small (64x64), Medium (128x128), Large (Nothing)
// Rakuten Books : Small (64x42), Medium (120x80), Large (180x120)
$wp_raira_rakuten_image_heights = array(
  "Small"  =>  60,
  "Medium" => 115,
  "Large"  => 170,
);

$wp_raira_rakuten_item_widths = array(
  "Small"  =>  42,
  "Medium" =>  80,
  "Large"  => 120,
);

$wp_raira_rakuten_item_heights = array(
  "Small"  => 135,
  "Medium" => 160,
  "Large"  => 225,
);

$wp_raira_display_services = array("Amazon", "Rakuten",);

$wp_raira_max_item_number_pc = 10;
$wp_raira_max_item_number_mobile = 10;

?>