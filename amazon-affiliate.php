<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );

$keywords = '';
foreach($tags as $tag) {
  $keywords .= $tag->description . " ";
  break;
}

$xml = null;
ini_set( 'display_errors', 0 );
if ($response = file_get_contents(generate_amazon_api_url($keywords))) {
  $xml = simplexml_load_string($response);
} else {
  error_log("file_get_contents failed. Maybe failed to open stream: HTTP request failed! HTTP/1.1 503 Service Unavailable", 0);
  get_template_part('rakuten-affiliate');
  return;
}
?>

<div id='related-amazon-rakuten-affiliate'>
<aside id="related-amazon-rakuten-affiliate-items">

<?php echo get_site_option('riara_heading_text') ?>

<?php
  $count = 0;
  foreach ($xml->Items->Item as $item) {
    
    if (!$item->LargeImage->URL) continue;
?>

<article class="related-amazon-rakuten-affiliate-thumbnail">
  <div class="related-amazon-rakuten-affiliate-thumb">
    <a href="<?php echo $item->DetailPageURL ?>" rel="bookmark" title="<?php echo $item->ItemAttributes->Title ?>" target="_blank">
      <img src="<?php echo $item->LargeImage->URL ?>" alt="<?php echo $item->ItemAttributes->Title ?>" title="<?php echo $item->ItemAttributes->Title ?>" />
    </a>
  </div><!-- /.related-amazon-rakuten-affiliate-thumb -->
  
  <div class="related-amazon-rakuten-affiliate-content">
    <h3 class="related-amazon-rakuten-affiliate-title">
      <a href="<?php echo $item->DetailPageURL ?>" rel="bookmark" title="<?php echo $item->ItemAttributes->Title ?>">
        <?php echo mb_substr(strip_tags($item->ItemAttributes->Title),0,30)." …"; ?>
      </a>
    </h3>
    <br style="clear:both;">
  </div><!-- /.related-amazon-rakuten-affiliate-content -->
</article><!-- /related-amazon-rakuten-affiliate-thumbnail -->

<?php } //foreach ?>
</aside>
</div>
