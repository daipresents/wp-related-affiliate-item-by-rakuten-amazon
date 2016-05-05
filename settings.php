<style>
th, td {
  border-bottom: solid 1px #ffffff;
}

th {
  width: 250px;
}
</style>

<?php
require( plugin_dir_path( __FILE__ ) . 'common.php' );
?>

<h2><?php _e('Related Item by Amazon and Rakuten Affiliate (RIARA)', 'riara'); ?></h2>

<p><?php _e('Related Item by Amazon and Rakuten Affiliate (RIARA) supports you to monetize your blog by displaying the contents which are affiliate image, link etc. Please set each option in this page first. If you don\'t set each one, this plugin use default value or doesn\'t display relate item.', 'riara'); ?></p>

<p><?php _e('This plugin is free to use but please show plugin attribution link (powered by daipresents.com). And this plugin use my associate id 10% of the time to display item link for donation to me. Thank you for your cooperation. Support page is ', 'riara'); ?><a href="http://daipresents.com/2016/wp-related-item-by-amazon-rakuten-affiliate-plugin/" target="_blank"><?php _e('here', 'riara'); ?></a>.</p>

<h3><?php _e('The result of current setting', 'riara') ?></h3>
<div>
<textarea name="kanso" rows="5" cols="100"><?php test_display_riara() ?></textarea>
</div>

<form action="options.php" method="post">
  <?php
    settings_fields( 'riara_group' );
    do_settings_sections( 'default' );
  ?>

<?php

// Is Display
$current_is_display = get_site_option('riara_is_display');

// Search Keyword
$current_search_by = get_site_option('riara_search_by');

?>

<h3><?php _e('General Setting', 'riara') ?></h3>

<table>
<tr>
<th><?php _e('If you like to display related item, please check this option. This check box is the switch: ', 'riara'); ?></th>
<?php
  $checked = "";
  if ($current_is_display == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="riara_is_display" id="riara_is_display" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr><th><?php _e('Search Item by ', 'riara') ?></th>
<td>
  <select name="riara_search_by" id="riara_search_by">
    <?php foreach ($riara_search_by_list as $search_by_key => $search_by) { 
      $selected = "";
      if ($current_search_by == $search_by) { 
        $selected = "selected='selected'";
      }
      ?>
      <option value="<?php echo $search_by ?>" <?php echo $selected ?>><?php echo $search_by_key ?></option>
    <?php } //foreach ?>
  </select>
</td></tr>
</table>

<?php
// API Location
$current_amazon_api_endpoint = get_site_option('riara_amazon_api_endpoint');

// Access Key
$current_amazon_access_key = get_site_option('riara_amazon_access_key');

// Secret Access Key
$current_amazon_secret_access_key = get_site_option('riara_amazon_secret_access_key');

// Search Index
$current_amazon_search_index = get_site_option('riara_amazon_search_index');

// Associate Tag
$current_amazon_associate_tag = get_site_option('riara_amazon_associate_tag');

?>

<h3>Amazon Product Advertising API</h3>

<table>
<tr>
<th><?php _e('API Endpoint ', 'riara'); ?></th>
  <td>
  <select name="riara_amazon_api_endpoint" id="riara_amazon_api_endpoint">
    <?php foreach ($riara_amazon_api_endpoints as $location => $url) { 
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
<th><?php _e('Access Key ', 'riara') ?></th>
  <td><input name="riara_amazon_access_key" id="riara_amazon_access_key" type="text" value="<?php echo $current_amazon_access_key ?>" style="width: 400px" /></td>
</tr>
<tr>
<th><?php _e('Secret Access Key ', 'riara') ?></th>
  <td><input name="riara_amazon_secret_access_key" id="riara_amazon_secret_access_key" type="text" value="<?php echo $current_amazon_secret_access_key ?>"  style="width: 400px" /></td>
</tr>
<tr>
<th><?php _e('Search Index ', 'riara') ?></th>
<td>
  <select name="riara_amazon_search_index" id="riara_amazon_search_index">
  <?php foreach ($riara_amazon_search_indexes as $index_key => $index) { 
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
<th><?php _e('Associate Tag (ex. daipresents-22) ', 'riara') ?></th>
  <td><input name="riara_amazon_associate_tag" id="riara_amazon_associate_tag" type="text" value="<?php echo $current_amazon_associate_tag ?>" /></td>
</tr>
</table>

<?php

// API Type
$current_rakuten_api_endpoint = get_site_option('riara_rakuten_api_endpoint');

// Application ID
$current_rakuten_application_id = get_site_option('riara_rakuten_application_id');

// Affilicate ID
$current_rakuten_affiliate_id = get_site_option('riara_rakuten_affiliate_id');

?>

<h3>Rakuten Web Service API</h3>
<table>
<tr>
<th><?php _e('API Type ', 'riara') ?></th>
<td>
  <select name="riara_rakuten_api_endpoint" id="riara_rakuten_api_endpoint">
  <?php foreach ($riara_rakuten_api_endpoints as $type_key => $type) { 
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
<th><?php _e('Application ID ', 'riara') ?></th>
<td><input name="riara_rakuten_application_id" id="riara_rakuten_application_id" type="text" value="<?php echo $current_rakuten_application_id ?>" style="width: 400px" /></td>
</tr>
<tr>
<th><?php _e('Affiliate ID ', 'riara') ?></th>
<td><input name="riara_rakuten_affiliate_id" id="riara_rakuten_affiliate_id" type="text" value="<?php echo $current_rakuten_affiliate_id ?>" style="width: 400px" /></td>
</tr>
</table>

<?php

// Display
$current_general_display_service = get_site_option('riara_display_service');

// Safe mode
$current_safe_mode = get_site_option('riara_safe_mode');

// Heading Text
$current_general_heading_text = get_site_option('riara_heading_text');

// Image Size
$current_image_size = get_site_option('riara_image_size');

// Display Title
$current_is_display_item_name = get_site_option('riara_is_display_item_name');

// Skip No Image Item
$current_skip_no_image_item = get_site_option('riara_skip_no_image_item');

// Default Banner for PC
$current_general_default_banner_pc = get_site_option('riara_default_banner_pc');

// Default Banner for mobile
$current_general_default_banner_mobile = get_site_option('riara_default_banner_mobile');

// Number of Item for PC 
$current_general_max_item_number_pc = get_site_option('riara_max_item_number_pc');

// Number of Item for mobile
$current_general_max_item_number_mobile = get_site_option('riara_max_item_number_mobile');

?>

<h3><?php _e('Display Setting', 'riara') ?></h3>

<table>
<tr><th><?php _e('Display service ', 'riara') ?></th>
<td>
  <select name="riara_display_service" id="riara_display_service">
  <?php foreach ($riara_display_services as $display_service) { 
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
<tr><th><?php _e('Heading Text (ex. <h3>Related Item</h3>) ', 'riara') ?></th>
<td><input name="riara_heading_text" id="riara_heading_text" type="text" value="<?php echo $current_general_heading_text ?>" style="width: 400px" /></td></tr>
<tr>
<th><?php _e('Image Size ', 'riara') ?></th>
<td>
  <select name="riara_image_size" id="riara_image_size">
  <?php foreach ($riara_image_sizes as $size_key => $size_value) { 
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
<th><?php _e('Display Item Name ', 'riara') ?></th>
<?php
  $checked = "";
  if ($current_is_display_item_name == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="riara_is_display_item_name" id="riara_is_display_item_name" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr>
<th><?php _e('Skip No Image Item ', 'riara') ?></th>
<?php
  $checked = "";
  if ($current_skip_no_image_item == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="riara_skip_no_image_item" id="riara_skip_no_image_item" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr><th>Template(Text, Thumbnail, Custom):</th><td>TODO</td></tr>
<tr>
<th><?php _e('Default banner for PC when there is no related item. Any plain HTML is OK. ', 'riara') ?></th>
<td>
<textarea name="riara_default_banner_pc" id="riara_default_banner_pc"  rows="8" cols="70"><?php echo $current_general_default_banner_pc ?></textarea>
</td>
</tr>
<tr>
<th><?php _e('Default banner for mobile when there is no related item. Any plain HTML is OK. ', 'riara') ?></th>
<td>
<textarea name="riara_default_banner_mobile" id="riara_default_banner_mobile"  rows="8" cols="70"><?php echo $current_general_default_banner_mobile ?></textarea>
</td>
</tr>
<tr>
<th><?php _e('Number of Item for PC ', 'riara') ?></th>
<td>
  <select name="riara_max_item_number_pc" id="riara_max_item_number_pc">
  <?php for ($count = 1; $count <= $riara_max_item_number_pc; $count++){
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
<th><?php _e('Number of Item for mobile ', 'riara') ?></th>
<td>
  <select name="riara_max_item_number_mobile" id="riara_max_item_number_mobile">
  <?php for ($count = 1; $count <= $riara_max_item_number_mobile; $count++){
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

<input name="riara_default_amazon_associate_tag" id="riara_default_amazon_associate_tag" type="hidden" value="daipresents-22" />
<input name="riara_default_rakuten_affiliate_id" id="riara_default_rakuten_affiliate_id" type="hidden" value="082db8a6.9792b509.082db8a7.22ecf61a" />

<?php submit_button();?>
</form>
