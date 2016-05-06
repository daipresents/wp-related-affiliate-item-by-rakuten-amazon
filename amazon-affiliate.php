<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
ini_set( 'display_errors', 0 );

$xml = null;
if ($response = file_get_contents(generate_amazon_request_url(get_search_keyword()))) {
  $xml = simplexml_load_string($response);

  // No result
  if ($xml->Items->Request->Errors) {
    error_log("Error code: " . $xml->Items->Request->Errors->Error->Code . " Message: " . $xml->Items->Request->Errors->Error->Message , 0);
    echo get_default_banner();
    return;
  }
  
} else {
  error_log("file_get_contents failed. Maybe failed to open stream: HTTP request failed! HTTP/1.1 503 Service Unavailable or please check your API setting (Access Key, Secret Access Key)", 0);
  echo get_default_banner();
  return;
}
?>

<div id='wp-raira'>
<aside id="wp-raira-items">
<?php echo get_site_option('wp_raira_heading_text') ?>

<?php
  
  $count = 1;
  foreach ($xml->Items->Item as $item) {
    
    $attributes = get_item_attributes($item);
    
    // Skip no image item or not. The image url of no image item is NULL.
    if (empty($attributes["image_url"])) {
      continue;
    }
?>

<article class="wp-raira" style="width:<?php echo $attributes["item_width"] ?>px; height:<?php echo $attributes["item_height"] ?>px">
  <div class="wp-raira-thumbnail">
    <a href="<?php echo $attributes["item_url"] ?>" title="<?php echo $attributes["item_name"] ?>" target="_blank">
      <img src="<?php echo $attributes["image_url"] ?>" alt="<?php echo $attributes["item_name"] ?>" title="<?php echo $attributes["item_name"] ?>" style="height:<?php echo $attributes["image_height"] ?>px; width:<?php echo $attributes["image_width"] ?>px" />
    </a>
  </div><!-- .wp-raira-thumb -->
  <?php if (get_site_option('wp_raira_is_display_item_name')){ ?>
  <div class="wp-raira-content">
    <a href="<?php echo $attributes["item_url"] ?>" title="<?php echo $attributes["item_name"] ?>">
      <?php echo $attributes["short_item_name"] ?>
    </a>
  </div><!-- .wp-raira-content -->
  <?php } ?>
</article><!-- .wp-raira-thumbnail -->

<?php
    if (wp_is_mobile()) {
      if ($count < get_site_option('wp_raira_max_item_number_mobile')) {
        $count++;
      } else {
        break;
      }
    } else {
      if ($count < get_site_option('wp_raira_max_item_number_pc')) {
        $count++;
      } else {
        break;
      }
    } // if
  } //foreach
?>

<br style="clear:both;">
</aside><!-- #wp-raira-items -->
<div id="wp-raira-powered-by">powered by <a href="http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/" target="_blank">daipresents.com</a></div>
</div><!-- #wp-raira -->
