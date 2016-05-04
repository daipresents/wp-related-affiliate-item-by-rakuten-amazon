<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
ini_set( 'display_errors', 0 );

$xml = null;
if ($response = file_get_contents(generate_amazon_request_url(get_search_keyword()))) {
  $xml = simplexml_load_string($response);
} else {
  error_log("file_get_contents failed. Maybe failed to open stream: HTTP request failed! HTTP/1.1 503 Service Unavailable", 0);
  //require_once( plugin_dir_path( __FILE__ ) . 'rakuten-affiliate.php' );
  return;
}
?>

<div id='related-amazon-rakuten-affiliate'>
<aside id="related-amazon-rakuten-affiliate-items">
<?php echo get_site_option('riara_heading_text') ?>

<?php
  $count = 1;
  foreach ($xml->Items->Item as $item) {
    $image_url = get_item_image($item);
    if (empty($image_url)) {
      continue;
    }
?>

<article class="related-amazon-rakuten-affiliate" style="width:<?php echo get_image_width() ?>; height:<?php echo get_item_height() ?>">
  <div class="related-amazon-rakuten-affiliate-thumbnail">
    <a href="<?php echo get_item_url($item) ?>" title="<?php echo get_item_title($item) ?>" target="_blank">
      <img src="<?php echo $image_url ?>" alt="<?php echo get_item_title($item) ?>" title="<?php echo get_item_title($item) ?>" width="<?php echo get_image_width() ?>" />
    </a>
  </div><!-- .related-amazon-rakuten-affiliate-thumb -->
  <?php if (get_site_option('riara_is_display_title')){ ?>
  <div class="related-amazon-rakuten-affiliate-content">
    <a href="<?php echo get_item_url($item) ?>" title="<?php echo get_item_title($item) ?>">
      <?php echo mb_substr(strip_tags(get_item_title($item)),0,30)." …"; ?>
    </a>
  </div><!-- .related-amazon-rakuten-affiliate-content -->
  <?php } ?>
</article><!-- .related-amazon-rakuten-affiliate-thumbnail -->

<?php
    if (wp_is_mobile()) {
      if ($count < get_site_option('riara_max_item_number_mobile')) {
        $count++;
      } else {
        break;
      }
    } else {
      if ($count < get_site_option('riara_max_item_number_pc')) {
        $count++;
      } else {
        break;
      }
    } // if
  } //foreach
?>

<br style="clear:both;">
</aside><!-- #related-amazon-rakuten-affiliate-items -->
</div><!-- #related-amazon-rakuten-affiliate -->
