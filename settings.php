<?php
require( RIARA_DIR . 'common.php' );

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

// Image Size
$current_amazon_image_size = get_site_option('riara_amazon_image_size');
?>

<h2>Related Item by Amazon and Rakuten Affiliate Plugin (RIARA)</h2>

<div style="color:red;">"*" is mandatory.</div>

<form action="options.php" method="post">
  <?php
    settings_fields( 'riara_group' );
    do_settings_sections( 'default' );
  ?>
  <h3>Amazon Product Advertising API</h3>
  
  <table>
  <tr>
  <th>API Location:</th>
    <td>
    <select name="riara_amazon_api_url" id="riara_amazon_api_url">
      <?php foreach ($riara_amazon_api_urls as $location => $url) { 
        $url_selected = "";
        if ($current_amazon_api_url === $url) { 
          $url_selected = "selected";
        }
        ?>
        <option value="<?php echo $url ?>" <?php echo $url_selected ?>><?php echo $location ?></option>
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
      $amazon_search_index_selected = "";
      if ($current_amazon_search_index == $index) { 
        $amazon_search_index_selected = "selected";
      }
      ?>
      <option value="<?php echo $index ?>" <?php echo $amazon_search_index_selected ?>><?php echo $index_key ?></option>
    <?php } //foreach ?>
    </select>
  </td>
  </tr>
  <tr>
  <th>Associate Tag(ex. daipresents-22):</th>
    <td><input name="riara_amazon_associate_tag" id="riara_amazon_associate_tag" type="text" value="<?php echo $current_amazon_associate_tag ?>" /></td>
  </tr>
  <tr>
  <th>Amazon Image Size:</th>
  <td>
    <select name="riara_amazon_image_size" id="riara_amazon_image_size">
    <?php foreach ($riara_amazon_image_sizes as $size_key => $size) { 
      $amazon_image_size_selected = "";
      if ($current_amazon_image_size == $size) { 
        $amazon_image_size_selected = "selected";
      }
      ?>
      <option value="<?php echo $size ?>" <?php echo $amazon_image_size_selected ?>><?php echo $size_key ?></option>
    <?php } //foreach ?>
    </select>
  </td>
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

// Image Size
$current_rakuten_image_size = get_site_option('riara_rakuten_image_size');
?>

  <h3>Rakuten Web Service API</h3>
  <table>
  <tr>
  <th>API Type:</th>
  <td>
    <select name="riara_rakuten_api_type" id="riara_rakuten_api_type">
    <?php foreach ($riara_rakuten_api_types as $type_key => $type) { 
      $rakuten_api_type_selected = "";
      if ($current_rakuten_api_type == $type) { 
        $rakuten_api_type_selected = "selected";
      }
      ?>
      <option value="<?php echo $type ?>" <?php echo $rakuten_api_type_selected ?>><?php echo $type_key ?></option>
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
  <tr>
  <th>Rakuten Image Size:</th>
  <td>
    <select name="riara_rakuten_image_size" id="riara_rakuten_image_size">
    <?php foreach ($riara_rakuten_image_sizes as $size_key => $size) { 
      $rakuten_image_size_selected = "";
      if ($current_rakuten_image_size == $size) { 
        $rakuten_image_size_selected = "selected";
      }
      ?>
      <option value="<?php echo $size ?>" <?php echo $rakuten_image_size_selected ?>><?php echo $size_key ?></option>
    <?php } //foreach ?>
    </select>
  </td>
  </tr>
  </table>

TEST

<?php

// Heading Text
$current_general_heading_text = get_site_option('riara_general_heading_text');

// Display
$current_general_display_value = get_site_option('riara_general_display_value');

// Default Banner for PC
$current_general_default_banner_pc = get_site_option('riara_general_default_banner_pc');

// Default Banner for mobile
$current_general_default_banner_mobile = get_site_option('riara_general_default_banner_mobile');

// Number of Item for PC 
$current_general_max_item_number_pc = get_site_option('riara_general_max_item_number_pc');

// Number of Item for mobile
$current_general_max_item_number_mobile = get_site_option('riara_general_max_item_number_mobile');

?>

  <h3>General Setting</h3>
  
  <table>
  <tr><th>Heading Text:</th>
  <td><input name="riara_general_heading_text" id="riara_general_heading_text" type="text" value="<?php echo $current_general_heading_text ?>" style="width: 400px" /></td></tr>
  
  <tr><th>Display setting:</th>
  <td>
    <select name="riara_general_display_value" id="riara_general_display_value">
    <?php foreach ($riara_general_display_values as $display_value) { 
      $general_display_value_selected = "";
      if ($current_general_display_value == $display_value) { 
        $general_display_value_selected = "selected";
      }
      ?>
      <option value="<?php echo $display_value ?>" <?php echo $general_display_value_selected ?>><?php echo $display_value ?></option>
    <?php } //foreach ?>
    </select>
  </td>
  </tr>
  <tr><th>Safety mode:</th><td>TODO</td></tr>
  <tr><th>Template(Text, Thumbnail, Custom):</th><td>TODO</td></tr>
  <tr>
  <th>Default banner for PC (When there is no related item):</th>
  <td>
  <textarea name="riara_general_default_banner_pc" id="riara_general_default_banner_pc"  rows="8" cols="70"><?php echo $current_general_default_banner_pc ?></textarea>
  </td>
  </tr>
  <tr>
  <th>Default banner for mobile (When there is no related item):</th>
  <td>
  <textarea name="riara_general_default_banner_mobile" id="riara_general_default_banner_mobile"  rows="8" cols="70"><?php echo $current_general_default_banner_mobile ?></textarea>
  </td>
  </tr>
  <tr>
  <th>Number of Item for PC:</th>
  <td>
    <select name="riara_general_max_item_number_pc" id="riara_general_max_item_number_pc">
    <?php for ($count = 1; $count <= $riara_general_max_item_number_pc; $count++){
      $general_max_item_number_pc_selected = "";
      if ($current_general_max_item_number_pc == $count) { 
        $general_max_item_number_pc_selected = "selected";
      }
      ?>
      <option value="<?php echo $count ?>" <?php echo $general_max_item_number_pc_selected ?>><?php echo $count ?></option>
    <?php } // for ?>
    </select>
  </td>
  </tr>
  <tr>
  <th>Number of Item for Mobile:</th>
  <td>
    <select name="riara_general_max_item_number_mobile" id="riara_general_max_item_number_mobile">
    <?php for ($count = 1; $count <= $riara_general_max_item_number_mobile; $count++){
      $general_max_item_number_mobile_selected = "";
      if ($current_general_max_item_number_mobile == $count) { 
        $general_max_item_number_mobile_selected = "selected";
      }
      ?>
      <option value="<?php echo $count ?>" <?php echo $general_max_item_number_mobile_selected ?>><?php echo $count ?></option>
    <?php } // for ?>
    </select>
  </td>
  </tr>
  </table>
  
  <?php submit_button();?>
</form>
