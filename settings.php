<?php
require_once( plugin_dir_path( __FILE__ ) . 'common.php' );
?>

<h2>Related Item by Amazon and Rakuten Affiliate Plugin (RIARA)</h2>

<form action="options.php" method="post">
  <?php
    settings_fields( 'riara_group' );
    do_settings_sections( 'default' );
  ?>

<?php

// Is Display
$current_is_display = get_site_option('riara_is_display');

// Search Keyword
$current_search_keyword = get_site_option('riara_search_keyword');

?>

<h3>General Setting</h3>

<table>
<tr>
<th>Display Related Item: </th>
<?php
  $checked = "";
  if ($current_is_display == "TRUE") {
    $checked = "checked='checked'";
  }
?>
<td><input type="checkbox" name="riara_is_display" id="riara_is_display" value="TRUE " <?php echo $checked ?> / ></td>
</tr>
<tr><th>Search Keyword: </th>
<td>
  <select name="riara_search_keyword" id="riara_search_keyword">
    <?php foreach ($riara_search_keywords as $keyword_key => $where) { 
      $selected = "";
      if ($current_search_keyword == $where) { 
        $selected = "selected='selected'";
      }
      ?>
      <option value="<?php echo $where ?>" <?php echo $selected ?>><?php echo $keyword_key ?></option>
    <?php } //foreach ?>
  </select>
</td></tr>
</table>

<?php
// API Location
$current_amazon_api_url = get_site_option('riara_amazon_api_url');

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

<p>If you like to use Amazon Product Advertising  API to display item, you need to set these options.</p>

<table>
<tr>
<th>API Location:</th>
  <td>
  <select name="riara_amazon_api_url" id="riara_amazon_api_url">
    <?php foreach ($riara_amazon_api_urls as $location => $url) { 
      $selected = "";
      if ($current_amazon_api_url == $url) { 
        $selected = "selected='selected'";
      }
      ?>
      <option value="<?php echo $url ?>" <?php echo $selected ?>><?php echo $location ?></option>
    <?php } //foreach ?>
  </select>
  </td>
</tr>
<th>Access Key:</th>
  <td><input name="riara_amazon_access_key" id="riara_amazon_access_key" type="text" value="<?php echo $current_amazon_access_key ?>" style="width: 400px" /></td>
</tr>
<tr>
<th>Secret Access Key:</th>
  <td><input name="riara_amazon_secret_access_key" id="riara_amazon_secret_access_key" type="text" value="<?php echo $current_amazon_secret_access_key ?>"  style="width: 400px" /></td>
</tr>
<tr>
<th>Search Index:</th>
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
<th>Associate Tag (ex. daipresents-22):</th>
  <td><input name="riara_amazon_associate_tag" id="riara_amazon_associate_tag" type="text" value="<?php echo $current_amazon_associate_tag ?>" /></td>
</tr>
</table>

TEST

<?php

// API Type
$current_rakuten_api_type = get_site_option('riara_rakuten_api_type');

// Application ID
$current_rakuten_application_id = get_site_option('riara_rakuten_application_id');

// Affilicate ID
$current_rakuten_affiliate_id = get_site_option('riara_rakuten_affiliate_id');

?>

<h3>Rakuten Web Service API</h3>
<table>
<tr>
<th>API Type:</th>
<td>
  <select name="riara_rakuten_api_type" id="riara_rakuten_api_type">
  <?php foreach ($riara_rakuten_api_types as $type_key => $type) { 
    $selected = "";
    if ($current_rakuten_api_type == $type) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $type ?>" <?php echo $selected ?>><?php echo $type_key ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<th>Application ID:</th>
<td><input name="riara_rakuten_application_id" id="riara_rakuten_application_id" type="text" value="<?php echo $current_rakuten_application_id ?>" style="width: 400px" /></td>
</tr>
<tr>
<th>Affiliate ID:</th>
<td><input name="riara_rakuten_affiliate_id" id="riara_rakuten_affiliate_id" type="text" value="<?php echo $current_rakuten_affiliate_id ?>" style="width: 400px" /></td>
</tr>
</table>

TEST

<?php

// Heading Text
$current_general_heading_text = get_site_option('riara_heading_text');

// Display
$current_general_display_value = get_site_option('riara_display_value');

// Image Size
$current_image_size = get_site_option('riara_image_size');


// Default Banner for PC
$current_general_default_banner_pc = get_site_option('riara_default_banner_pc');

// Default Banner for mobile
$current_general_default_banner_mobile = get_site_option('riara_default_banner_mobile');

// Number of Item for PC 
$current_general_max_item_number_pc = get_site_option('riara_max_item_number_pc');

// Number of Item for mobile
$current_general_max_item_number_mobile = get_site_option('riara_max_item_number_mobile');

?>

<h3>Display Setting</h3>

<table>
<tr><th>Heading Text:</th>
<td><input name="riara_heading_text" id="riara_heading_text" type="text" value="<?php echo $current_general_heading_text ?>" style="width: 400px" /></td></tr>

<tr><th>Display setting:</th>
<td>
  <select name="riara_display_value" id="riara_display_value">
  <?php foreach ($riara_display_values as $display_value) { 
    $selected = "";
    if ($current_general_display_value == $display_value) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $display_value ?>" <?php echo $selected ?>><?php echo $display_value ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>
<tr>
<th>Image Size:</th>
<td>
  <select name="riara_image_size" id="riara_image_size">
  <?php foreach ($riara_image_sizes as $size_key => $size) { 
    $selected = "";
    if ($current_image_size == $size) { 
      $selected = "selected='selected'";
    }
    ?>
    <option value="<?php echo $size ?>" <?php echo $selected ?>><?php echo $size_key ?></option>
  <?php } //foreach ?>
  </select>
</td>
</tr>

<tr><th>Safety mode:</th><td>TODO</td></tr>
<tr><th>Template(Text, Thumbnail, Custom):</th><td>TODO</td></tr>
<tr>
<th>Default banner for PC (When there is no related item):</th>
<td>
<textarea name="riara_default_banner_pc" id="riara_default_banner_pc"  rows="8" cols="70"><?php echo $current_general_default_banner_pc ?></textarea>
</td>
</tr>
<tr>
<th>Default banner for mobile (When there is no related item):</th>
<td>
<textarea name="riara_default_banner_mobile" id="riara_default_banner_mobile"  rows="8" cols="70"><?php echo $current_general_default_banner_mobile ?></textarea>
</td>
</tr>
<tr>
<th>Number of Item for PC:</th>
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
<th>Number of Item for Mobile:</th>
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
<input name="riara_default_rakuten_application_id" id="riara_default_rakuten_application_id" type="hidden" value="94861c35f590dcd5deb9e873957cff83" />
<input name="riara_default_rakuten_affiliate_id" id="riara_default_rakuten_affiliate_id" type="hidden" value="082db8a6.9792b509.082db8a7.22ecf61a" />
<input name="riara_default_search_word" id="riara_default_search_word" type="hidden" value="Lean from the trenches" />

<?php submit_button();?>
</form>
