<?php
require_once( plugin_dir_path( __FILE__ ) . 'affiliate.php' );
$Affiliate = new Affiliate();
$test_result = $Affiliate->execute(true);

$wp_raira_search_by_list = array(
  "Category Name" => "Category Name",
  "Category Description" => "Category Description",
  "Tag Name" => "Tag Name",
  "Tag Description" => "Tag Description",
);

$wp_raira_amazon_api_endpoints = array(
  "JP" => "https://webservices.amazon.co.jp/onca/xml",
//  "US" => "https://webservices.amazon.com/onca/xml",
//  "UK" => "https://webservices.amazon.co.uk/onca/xml",
//  "MX" => "https://webservices.amazon.com.mx/onca/xml",
//  "IT" => "https://webservices.amazon.it/onca/xml",
//  "IN" => "https://webservices.amazon.in/onca/xml",
//  "FR" => "https://webservices.amazon.fr/onca/xml",
//  "ES" => "https://webservices.amazon.es/onca/xml",
//  "DE" => "https://webservices.amazon.de/onca/xml",
//  "CN" => "https://webservices.amazon.cn/onca/xml",
//  "CA" => "https://webservices.amazon.ca/onca/xml",
//  "BR" => "https://webservices.amazon.com.br/onca/xml",
);

$wp_raira_amazon_search_indexes = array(
  "All" => "All",
  "Apparel" => "Apparel",
  "Automotive" => "Automotive",
  "Baby" => "Baby",
  "Beauty" => "Beauty",
  "Blended" => "Blended",
  "Books" => "Books",
  "Classical" => "Classical",
  "DVD" => "DVD",
  "Electronics" => "Electronics",
  "ForeignBooks" => "ForeignBooks",
  "Grocery" => "Grocery",
  "HealthPersonalCare" => "HealthPersonalCare",
  "Hobbies" => "Hobbies",
  "HomeImprovement" => "HomeImprovement",
  "Jewelry" => "Jewelry",
  "Kitchen" => "Kitchen",
  "Music" => "Music",
  "MusicTracks" => "MusicTracks",
  "OfficeProducts" => "OfficeProducts",
  "Shoes" => "Shoes",
  "Software" => "Software",
  "SportingGoods" => "SportingGoods",
  "Toys" => "Toys",
  "VHS" => "VHS",
  "Video" => "Video",
  "VideoGames" => "VideoGames",
  "Watches" => "Watches",
);

$wp_raira_rakuten_api_endpoints = array(
  "IchibaItem" => "https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222",
  "BooksTotal" => "https://app.rakuten.co.jp/services/api/BooksTotal/Search/20130522",
  "BooksBook" => "https://app.rakuten.co.jp/services/api/BooksBook/Search/20130522",
);

$wp_raira_display_services = array("Amazon", "Rakuten",);

// Image Size
$wp_raira_image_sizes = array(
  //"Small"  => "Small",
  "Medium" => "Medium",
  //"Large"  => "Large",
);
  
$wp_raira_max_item_number_pc = 15;
$wp_raira_max_item_number_mobile = 15;

?>
<style>
th, td {
  border-bottom: solid 1px #ffffff;
}

.option_name {
  width: 200px;
}

.option_description {
  width:250px;
  font-size: 0.9em;
}
</style>

<h2><?php _e("Related Affiliate Item by Rakuten and Amazon (RAIRA)", "wp-raira"); ?></h2>

<p><?php _e("This plugin supports you to monetize your blog by displaying the contents which are affiliate image, link etc. Please set each option in this page first. If you don't set each one, this plugin use default value or doesn't display relate item.", "wp-raira"); ?></p>

<p><?php _e("If you want to use this plugin, please read support page first. Support page is <a href='http://daipresents.com/2016/wp-related-item-by-amazon-rakuten-affiliate-plugin/' target='_blank'>here</a>.", 'wp-raira'); ?></p>

<h3><?php _e("The result of current setting", "wp-raira") ?></h3>
<div>
<textarea name="kanso" rows="5" cols="100"><?php var_dump($test_result) ?></textarea>
</div>

<form action="options.php" method="post">
<?php

settings_fields( 'wp_raira_group' );
do_settings_sections( 'default' );

// API Location
$current_amazon_api_endpoint = get_site_option('wp_raira_amazon_api_endpoint');

// Access Key
$current_amazon_access_key = get_site_option('wp_raira_amazon_access_key');

// Secret Access Key
$current_amazon_secret_access_key = get_site_option('wp_raira_amazon_secret_access_key');

// Search Index
$current_amazon_search_index = get_site_option('wp_raira_amazon_search_index');

// Associate Tag
$current_amazon_associate_tag = get_site_option('wp_raira_amazon_associate_tag');

?>

<h3>Amazon Product Advertising API</h3>

<table>
<tr>
<td class="option_name"><?php _e("API Endpoint", "wp-raira"); ?></td>
<td class="option_description"><?php _e("You can select the location of API. If you like to show Japanese product, you should select 'JP' location.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_amazon_api_endpoint" id="wp_raira_amazon_api_endpoint">
    <?php foreach ($wp_raira_amazon_api_endpoints as $location => $url) { 
      $selected = "";
      if ($current_amazon_api_endpoint == $url) { 
        $selected = "selected='selected'";
      }
      ?>
      <option value="<?php echo $url ?>" <?php echo $selected ?>><?php echo $location ?></option>
    <?php } //foreach ?>
  </select>
  </td>
</tr>
<tr>
<td class="option_name"><?php _e("Access Key", "wp-raira") ?></td>
<td class="option_description"><?php _e("Get access key for Amazon Product Advertising API from <a href='http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/#amazon' target='_blank'>here</a>.", "wp-raira"); ?></td>
<td><input name="wp_raira_amazon_access_key" id="wp_raira_amazon_access_key" type="text" value="<?php echo $current_amazon_access_key ?>" style="width: 400px" /></td>
</tr>
<tr>
<td class="option_name"><?php _e("Secret Access Key", "wp-raira") ?></td>
<td class="option_description"><?php _e("Get secret access key for Amazon Product Advertising API from <a href='http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/#amazon' target='_blank'>here</a>.", "wp-raira"); ?></td>
<td><input name="wp_raira_amazon_secret_access_key" id="wp_raira_amazon_secret_access_key" type="text" value="<?php echo $current_amazon_secret_access_key ?>"  style="width: 400px" /></td>
</tr>
<tr>
<td class="option_name"><?php _e("Search Index", "wp-raira") ?></td>
<td class="option_description"><?php _e("The genre of item for search.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_amazon_search_index" id="wp_raira_amazon_search_index">
  <?php foreach ($wp_raira_amazon_search_indexes as $index_key => $index) { 
    $selected = "";
    if ($current_amazon_search_index == $index) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $index ?>" <?php echo $selected ?>><?php echo $index_key ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Associate Tag", "wp-raira") ?></td>
<td class="option_description"><?php _e("Your Amazon accociate tag. e.g. daipresents-22", "wp-raira"); ?></td>
<td><input name="wp_raira_amazon_associate_tag" id="wp_raira_amazon_associate_tag" type="text" value="<?php echo $current_amazon_associate_tag ?>" /></td>
</tr>
</table>

<?php

// API Type
$current_rakuten_api_endpoint = get_site_option('wp_raira_rakuten_api_endpoint');

// Application ID
$current_rakuten_application_id = get_site_option('wp_raira_rakuten_application_id');

// Affilicate ID
$current_rakuten_affiliate_id = get_site_option('wp_raira_rakuten_affiliate_id');

?>

<h3>Rakuten Web Service API</h3>
<table>
<tr>
<td class="option_name"><?php _e("API Type", "wp-raira") ?></td>
<td class="option_description"><?php _e("API you like to use to display item.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_rakuten_api_endpoint" id="wp_raira_rakuten_api_endpoint">
  <?php foreach ($wp_raira_rakuten_api_endpoints as $type_key => $type) { 
    $selected = "";
    if ($current_rakuten_api_endpoint == $type) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $type ?>" <?php echo $selected ?>><?php echo $type_key ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<td class="option_name"><?php _e("Application ID", "wp-raira") ?></td>
<td class="option_description"><?php _e("Get application ID for Rakuten Web Service API from <a href='http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/#rakuten' target='_blank'>here</a>.", "wp-raira"); ?></td>
<td><input name="wp_raira_rakuten_application_id" id="wp_raira_rakuten_application_id" type="text" value="<?php echo $current_rakuten_application_id ?>" style="width: 400px" /></td>
</tr>
<tr>
<td class="option_name"><?php _e("Affiliate ID", "wp-raira") ?></td>
<td class="option_description"><?php _e("Get affiliate ID for Rakuten Web Service API from <a href='http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/#rakuten' target='_blank'>here</a>.", "wp-raira"); ?></td>
<td><input name="wp_raira_rakuten_affiliate_id" id="wp_raira_rakuten_affiliate_id" type="text" value="<?php echo $current_rakuten_affiliate_id ?>" style="width: 400px" /></td>
</tr>
</table>

<?php

// Is Display
$current_is_display = get_site_option('wp_raira_is_display');

// Display
$current_general_display_service = get_site_option('wp_raira_display_service');

// Search Keyword
$current_search_by = get_site_option('wp_raira_search_by');

// Safe mode
$current_safe_mode = get_site_option('wp_raira_safe_mode');

// Heading Text
$current_general_heading_text = get_site_option('wp_raira_heading_text');

// Image Size
$current_image_size = get_site_option('wp_raira_image_size');

// Display Title
$current_is_display_item_name = get_site_option('wp_raira_is_display_item_name');

// Skip No Image Item
$current_skip_no_image_item = get_site_option('wp_raira_skip_no_image_item');

// Default Banner for PC
$current_general_default_banner_pc = get_site_option('wp_raira_default_banner_pc');

// Default Banner for mobile
$current_general_default_banner_mobile = get_site_option('wp_raira_default_banner_mobile');

// Number of Item for PC 
$current_general_max_item_number_pc = get_site_option('wp_raira_max_item_number_pc');

// Number of Item for mobile
$current_general_max_item_number_mobile = get_site_option('wp_raira_max_item_number_mobile');

?>

<h3><?php _e("Display Setting", "wp-raira") ?></h3>

<table>
<tr>
<td class="option_name"><?php _e("Display related affiliate item", "wp-raira"); ?></td>
<td class="option_description"><?php _e("If you like to display related affiliate item, please check this option. This check box is the switch to display item without removing widget.", "wp-raira"); ?></td>
<?php
  $checked = "";
  if ($current_is_display == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="wp_raira_is_display" id="wp_raira_is_display" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr><td class="option_name"><?php _e("Display service", "wp-raira") ?></td>
<td class="option_description"><?php _e("Select a service for displaying affiliate item.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_display_service" id="wp_raira_display_service">
  <?php foreach ($wp_raira_display_services as $display_service) { 
    $selected = "";
    if ($current_general_display_service == $display_service) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $display_service ?>" <?php echo $selected ?>><?php echo $display_service ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Search Item by", "wp-raira") ?></td>
<td class="option_description"><?php _e("This plugin try to find the related item by using this part of article.", "wp-raira") ?></td>
<td>
  <select name="wp_raira_search_by" id="wp_raira_search_by">
    <?php foreach ($wp_raira_search_by_list as $search_by_key => $search_by) { 
      $selected = "";
      if ($current_search_by == $search_by) { 
        $selected = "selected='selected'";
      }
      ?>
      <option value="<?php echo $search_by ?>" <?php echo $selected ?>><?php echo $search_by_key ?></option>
    <?php } //foreach ?>
  </select>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Heading Text", "wp-raira") ?></td>
<td class="option_description"><?php _e("You can display heading text above the related item. (e.g. &lt;h3&gt;Related Item&lt;/h3&gt;)", "wp-raira"); ?></td>
<td><input name="wp_raira_heading_text" id="wp_raira_heading_text" type="text" value="<?php echo $current_general_heading_text ?>" style="width: 400px" /></td></tr>
<tr>
<td class="option_name"><?php _e("Image Size", "wp-raira") ?></td>
<td class="option_description"><?php _e("Amazon image is bigger than Rakuten one.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_image_size" id="wp_raira_image_size">
  <?php foreach ($wp_raira_image_sizes as $size_key => $size_value) { 
    $selected = "";
    if ($current_image_size == $size_value) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $size_value ?>" <?php echo $selected ?>><?php echo $size_key ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Display Item Name", "wp-raira") ?></td>
<td class="option_description"><?php _e("If you like to display item name. Please check here. But if you select the size of image 'Small', I don't recommend to show the title because of limited space.", "wp-raira"); ?></td>
<?php
  $checked = "";
  if ($current_is_display_item_name == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="wp_raira_is_display_item_name" id="wp_raira_is_display_item_name" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr>
<td class="option_name"><?php _e("Skip No Image Item", "wp-raira") ?></td>
<td class="option_description"><?php _e("If you like to skip to display item of no image. Please check here.", "wp-raira"); ?></td>
<?php
  $checked = "";
  if ($current_skip_no_image_item == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="wp_raira_skip_no_image_item" id="wp_raira_skip_no_image_item" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr>
<td class="option_name"><?php _e("Template", "wp-raira"); ?></td>
<td class="option_description"><?php _e("Preparing now. (Text, Thumbnail, Custom)", "wp-raira"); ?></td>
<td>TODO</td>
</tr>
<tr>
<td class="option_name"><?php _e("Default banner for PC", "wp-raira") ?></td>
<td class="option_description"><?php _e("When there is no related item, you can display this value. Any plain HTML is OK.", "wp-raira"); ?></td>
<td>
<textarea name="wp_raira_default_banner_pc" id="wp_raira_default_banner_pc"  rows="8" cols="70"><?php echo $current_general_default_banner_pc ?></textarea>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Default banner for mobile", "wp-raira") ?></td>
<td class="option_description"><?php _e("When there is no related item, you can display this value. Any plain HTML is OK.", "wp-raira"); ?></td>
<td>
<textarea name="wp_raira_default_banner_mobile" id="wp_raira_default_banner_mobile"  rows="8" cols="70"><?php echo $current_general_default_banner_mobile ?></textarea>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Number of Item for PC", "wp-raira") ?></td>
<td class="option_description"><?php _e("The number of relate item for PC view.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_max_item_number_pc" id="wp_raira_max_item_number_pc">
  <?php for ($count = 1; $count <= $wp_raira_max_item_number_pc; $count++){
    $selected = "";
    if ($current_general_max_item_number_pc == $count) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $count ?>" <?php echo $selected ?>><?php echo $count ?></option>
  <?php } // for ?>
  </select>
</td>
</tr>
<tr>
<td class="option_name"><?php _e("Number of Item for mobile", "wp-raira") ?></td>
<td class="option_description"><?php _e("The number of relate item for mobile view. The recommend number is half of PC one.", "wp-raira"); ?></td>
<td>
  <select name="wp_raira_max_item_number_mobile" id="wp_raira_max_item_number_mobile">
  <?php for ($count = 1; $count <= $wp_raira_max_item_number_mobile; $count++){
    $selected = "";
    if ($current_general_max_item_number_mobile == $count) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $count ?>" <?php echo $selected ?>><?php echo $count ?></option>
  <?php } // for ?>
  </select>
</td>
</tr>
</table>

<input name="wp_raira_default_amazon_associate_tag" id="wp_raira_default_amazon_associate_tag" type="hidden" value="daipresents-22" />
<input name="wp_raira_default_rakuten_affiliate_id" id="wp_raira_default_rakuten_affiliate_id" type="hidden" value="082db8a6.9792b509.082db8a7.22ecf61a" />

<?php submit_button();?>
</form>
