<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
ini_set( 'display_errors', 0 );

$xml = null;
if ($response = file_get_contents(generate_rakuten_request_url(get_search_keyword()))) {
  $xml = simplexml_load_string($response);
  
} else {
  error_log("file_get_contents failed. url = " . generate_rakuten_request_url(get_search_keyword()), 0);
  //require_once( plugin_dir_path( __FILE__ ) . 'amazon-affiliate.php' );
  return;
  
}
?>

<div id='related-amazon-rakuten-affiliate'>
<aside id="related-amazon-rakuten-affiliate-items">
<?php echo get_site_option('riara_heading_text') ?>
<?php
  foreach ($xml->Items->Item as $item) {
?>
<article class="related-amazon-rakuten-affiliate-thumbnail">
  <div class="related-amazon-rakuten-affiliate-thumb">
    <a href="<?php echo get_item_url($item) ?>" title="<?php echo get_item_title($item) ?>" target="_blank">
      <img src="<?php echo get_item_image($item) ?>" alt="<?php echo get_item_title($item) ?>" title="<?php echo get_item_title($item) ?>" />
    </a>
  </div><!-- /.related-amazon-rakuten-affiliate-thumb -->
  
  <div class="related-amazon-rakuten-affiliate-content">
    <h3 class="related-amazon-rakuten-affiliate-title">
      <a href="<?php echo get_item_url($item) ?>" title="<?php echo get_item_title($item) ?>">
        <?php echo mb_substr(strip_tags(get_item_title($item)),0,30)." …"; ?>
      </a>
    </h3>
    <br style="clear:both;">
  </div><!-- /.related-amazon-rakuten-affiliate-content -->
</article><!-- /related-amazon-rakuten-affiliate-thumbnail -->

<?php } //foreach ?>
</aside>
</div>
