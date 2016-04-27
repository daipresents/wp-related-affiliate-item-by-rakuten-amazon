<?php
/*
Plugin Name: Related Item by Amazon and Rakuten Affiliate (RIARA)
Plugin URI: http://daipresents.com/2016/wp-related-item-by-amazon-rakuten-affiliate-plugin/
Description: This plugin support you to monetize your blog by displaying the contents which are affiliate image, link etc.
Author: @daipresents
Version: 0.1
Author URI: http://daipresents.com/
*/

require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'widget.php' );

// For setting on admin menu.
function add_plugin_admin_menu() {
  add_submenu_page( 
    'options-general.php',
    'Related Amazon and Rakuten Affiliate',
    'Related Amazon and Rakuten Affiliate Setting',
    'administrator',
    'wp-related-item-by-amazon-rakuten-affiliate',
    'display_riara_settings'
  );
  
  // General Setting
  register_setting('riara_group', 'riara_is_display', '');
  register_setting('riara_group', 'riara_search_by', '');

  // Amazon Setting
  register_setting('riara_group', 'riara_amazon_api_url', '');
  register_setting('riara_group', 'riara_amazon_access_key', '');
  register_setting('riara_group', 'riara_amazon_secret_access_key', '');
  register_setting('riara_group', 'riara_amazon_search_index', '');
  register_setting('riara_group', 'riara_amazon_associate_tag', '');
  
  // Rakuten Setting
  register_setting('riara_group', 'riara_rakuten_api_type', '');
  register_setting('riara_group', 'riara_rakuten_application_id', '');
  register_setting('riara_group', 'riara_rakuten_affiliate_id', '');
  
  // Display Setting
  register_setting('riara_group', 'riara_heading_text', '');
  register_setting('riara_group', 'riara_display_value', '');
  register_setting('riara_group', 'riara_image_size', '');
  register_setting('riara_group', 'riara_default_banner_pc', '');
  register_setting('riara_group', 'riara_default_banner_mobile', '');
  register_setting('riara_group', 'riara_max_item_number_pc', '');
  register_setting('riara_group', 'riara_max_item_number_mobile', '');

  // Default
  register_setting('riara_group', 'riara_default_amazon_associate_tag', '');
  register_setting('riara_group', 'riara_default_rakuten_application_id', '');
  register_setting('riara_group', 'riara_default_rakuten_affiliate_id', '');
  register_setting('riara_group', 'riara_default_search_word', '');

}
add_action('admin_menu', 'add_plugin_admin_menu');

add_action('widgets_init', function () {
    register_widget( 'RIARA_Widget');
} );
?>
