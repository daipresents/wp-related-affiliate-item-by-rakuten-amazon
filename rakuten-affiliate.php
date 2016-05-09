<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
ini_set( 'display_errors', 0 );

$start_time = get_start_time();

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

<div id='wp-raira'>
<aside id="wp-raira-items">
<?php echo get_site_option('wp_raira_heading_text') ?>
<?php
  foreach ($xml->Items->Item as $item) {
  
    $attributes = get_item_attributes($item);
    if (empty($attributes["image_url"])) {
      continue;
    }
?>

<article class="wp-raira" style="width:<?php echo $attributes["item_width"] ?>px; height:<?php echo $attributes["item_height"] ?>px">
  <div class="wp-raira-thumbnail">
    <a href="<?php echo $attributes["item_url"] ?>" title="<?php echo $attributes["item_name"] ?>" target="_blank">
      <img src="<?php echo $attributes["image_url"] ?>" alt="<?php echo $attributes["item_name"] ?>" title="<?php echo $attributes["item_name"] ?>" style="height:<?php echo $attributes["image_height"] ?>px;" />
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

<?php } //foreach ?>

<br style="clear:both;">
</aside><!-- #wp-raira-items -->
<div id="wp-raira-powered-by">powered by <a href="<?php echo POWERED_BY ?>" target="_blank">daipresents.com</a></div>
</div><!-- #wp-raira -->

<?php display_performance_time($start_time); ?>
