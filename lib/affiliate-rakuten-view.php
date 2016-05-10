<?php
require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'affiliate.php' );

define("WP_DEBUG", true);
$start_time = get_start_time();

$Affiliate = new Affiliate();
$xml = $Affiliate->execute();

if(empty($xml)) {
  return;
}
?>

<div id='wp-raira'>
<aside id="wp-raira-items">
<?php echo get_site_option('wp_raira_heading_text') ?>
<?php
  foreach ($xml->Items->Item as $item) {
  
    $attributes = $Affiliate->get_item_attributes($item);
    
    // Skip no image item or not. The image url of no image item is NULL.
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
</div><!-- #wp-raira -->

<?php display_performance_time($start_time); ?>
