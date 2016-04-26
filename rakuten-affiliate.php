<?php
  $widget = '<?php echo get_site_option('riara_general_default_banner_pc')?>';
  $tags = get_the_tags();
  if (!$tags){
?>
<div><?php echo $widget ?></div>
<?php
  }else{
    foreach($tags as $tag) {
?>
<script type="text/javascript">
  var recommendBooks = '';
  jQuery.ajax({
    type: 'GET',
    url: '<?php echo get_site_option('riara_rakuten_api_type') ?>',
    dataType: 'jsonp',
    timeout:10000,
    data: {
      "applicationId": "<?php echo get_site_option('riara_rakuten_application_id') ?>",
      "affiliateId": "<?php echo get_site_option('riara_rakuten_affiliate_id') ?>",
      "title": "<?php echo $tag->description; ?>",
      <?php if (wp_is_mobile()) { ?>
        "hits": "<?php echo get_site_option('riara_general_max_item_number_mobile') ?>",
      <?php } else { ?>
        "hits": "<?php echo get_site_option('riara_general_max_item_number_pc') ?>",
      <?php } ?>
      "sort": "sales",
    },
    success: function(json)
    {
      if (json.count == 0){
        recommendBooks = '<?php echo $widget ?>';
      } else {
         jQuery.each(json.Items, function() {
          recommendBooks += (
            '<div class="book">' + '<a href="' + this.Item.affiliateUrl + '" target="_blank">' + 
            '<img src="' + this.Item.largeImageUrl + '" alt="' + this.Item.title + '" title="' + this.Item.title + '" width="160"/></a></div>'
          );
        });
      }
      jQuery("#recommendBooks").append(recommendBooks);
    },
    complete: function() {
    }
  });
</script>
<div id="related-entries">
<h3>この記事に関係あるかもしれない本</h3>
<div id="recommendBooks"></div>
</div>
<br style="clear:both" />
<?php
      break;
    }
  }
?>
