<?php
// for signnature
$params = array();
$params['Service'] = 'AWSECommerceService';
$params['AWSAccessKeyId'] = get_site_option('riara_amazon_access_key');
$params['Operation'] = 'ItemSearch';
$params['SearchIndex'] = get_site_option('riara_amazon_search_index');
$params['AssociateTag'] = get_site_option('riara_amazon_associate_tag');
$params['Version'] = '2011-08-02';
$params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
//$params['Sort'] = 'salesrank';
$params['ResponseGroup'] = 'Medium';
$keywords = '';
foreach($tags as $tag) {
  $keywords .= $tag->description . " ";
  break;
}
$params['Keywords'] = $keywords;
$params['ItemPage'] = 1;    
ksort($params);

$canonical_string = '';
foreach ($params as $k => $v) {
  $canonical_string .= '&' . rawurlencode($k) . '=' . rawurlencode($v);
} 
$canonical_string = substr($canonical_string, 1);
$parsed_url = parse_url(get_site_option('riara_amazon_api_url'));
$string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
$params['Signature'] = rawurlencode(base64_encode(hash_hmac('sha256', $string_to_sign, get_site_option('riara_amazon_secret_access_key'), true)));
$url = get_site_option('riara_amazon_api_url') . '?' . $canonical_string . '&Signature=' . $params['Signature'];
//echo $url . "<br />";

$xml = null;
ini_set( 'display_errors', 0 );
if ($response = file_get_contents($url)) {
  $xml = simplexml_load_string($response);
} else {
  error_log("file_get_contents failed. Maybe failed to open stream: HTTP request failed! HTTP/1.1 503 Service Unavailable", 0);
  get_template_part('rakuten-affiliate');
  return;
}
?>

<div id='related-amazon-rakuten-affiliate'>
<aside id="related-amazon-rakuten-affiliate-items">

<?php echo get_site_option('riara_general_heading_text') ?>

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
