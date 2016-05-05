<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );

ini_set( 'display_errors', 0 );

$xml = null;
if ($response = file_get_contents(generate_rakuten_request_url(get_search_keyword()))) {
  $xml = simplexml_load_string($response);
  
  // No result
  if ($xml->count == 0) {
    echo get_default_banner();
    return;
  }
  
} else {
  // API error
  error_log("file_get_contents failed. url = " . generate_rakuten_request_url(get_search_keyword()), 0);
  echo get_default_banner();
  return;
}
?>

<div id='related-amazon-rakuten-affiliate'>
<aside id="related-amazon-rakuten-affiliate-items">
<?php echo get_site_option('riara_heading_text') ?>
<?php
  foreach ($xml->Items->Item as $item) {
  
    $attributes = get_item_attributes($item);
    if (empty($attributes["image_url"])) {
      continue;
    }
?>

<article class="related-amazon-rakuten-affiliate" style="width:<?php echo $attributes["item_width"] ?>px; height:<?php echo $attributes["item_height"] ?>px">
  <div class="related-amazon-rakuten-affiliate-thumbnail">
    <a href="<?php echo $attributes["item_url"] ?>" title="<?php echo $attributes["item_name"] ?>" target="_blank">
      <img src="<?php echo $attributes["image_url"] ?>" alt="<?php echo $attributes["item_name"] ?>" title="<?php echo $attributes["item_name"] ?>" style="height:<?php echo $attributes["image_height"] ?>px;" />
    </a>
  </div><!-- .related-amazon-rakuten-affiliate-thumb -->
  <?php if (get_site_option('riara_is_display_title')){ ?>
  <div class="related-amazon-rakuten-affiliate-content">
    <a href="<?php echo $attributes["item_url"] ?>" title="<?php echo $attributes["item_name"] ?>">
      <?php echo $attributes["short_item_name"] ?>
    </a>
  </div><!-- .related-amazon-rakuten-affiliate-content -->
  <?php } ?>
</article><!-- .related-amazon-rakuten-affiliate-thumbnail -->

<?php } //foreach ?>

<br style="clear:both;">
</aside><!-- #related-amazon-rakuten-affiliate-items -->
</div><!-- #related-amazon-rakuten-affiliate -->
