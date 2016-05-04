<?php

$riara_search_by_list = array(
  "Category Name" => "Category Name",
  "Category Description" => "Category Description",
  "Tag Name" => "Tag Name",
  "Tag Description" => "Tag Description",
);

$riara_amazon_api_endpoints = array(
  "JP" => "https://webservices.amazon.co.jp/onca/xml",
  "US" => "https://webservices.amazon.com/onca/xml",
  "UK" => "https://webservices.amazon.co.uk/onca/xml",
  "MX" => "https://webservices.amazon.com.mx/onca/xml",
  "IT" => "https://webservices.amazon.it/onca/xml",
  "IN" => "https://webservices.amazon.in/onca/xml",
  "FR" => "https://webservices.amazon.fr/onca/xml",
  "ES" => "https://webservices.amazon.es/onca/xml",
  "DE" => "https://webservices.amazon.de/onca/xml",
  "CN" => "https://webservices.amazon.cn/onca/xml",
  "CA" => "https://webservices.amazon.ca/onca/xml",
  "BR" => "https://webservices.amazon.com.br/onca/xml",
);

$riara_amazon_search_indexes = array(
  "All" => "All",
  "Books" => "Books",
);

$riara_rakuten_api_endpoints = array(
  "IchibaItem" => "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222",
  "BooksTotal" => "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522",
  "BooksBook" => "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522",
);

// Amazon: Small (75x58), Medium (160x124), Large (500x389)
// Item size are Small (64x64), Medium (128x128), Large (200x200) in Rakuten wchich are wrriten in API docs but they return only following image size:
// Rakuten Ichiba: Small (64x64), Medium (128x128), Large (Nothing)
// Rakuten Books : Small (64x42), Medium (120x80), Large (180x120)
$riara_image_sizes = array(
  "Small" => 42,
  "Medium" => 80,
  "Large" => 120,
);

$riara_display_services = array("Amazon", "Rakuten",);

$riara_max_item_number_pc = 12;
$riara_max_item_number_mobile = 12;

?>