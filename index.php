<?php
/*
Plugin Name: Related Item by Amazon and Rakuten Affiliate (RIARA)
Plugin URI: http://daipresents.com/2016/wp-related-item-by-amazon-rakuten-affiliate-plugin/
Description: This plugin support you to monetize your blog by displaying the contents which are affiliate image, link etc.
Author: @daipresents
Version: 0.1
Author URI: http://daipresents.com/
*/

require( plugin_dir_path( __FILE__ ) . 'common.php' );

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
  
  // Amazon Setting
  register_setting('riara_group', 'riara_amazon_api_url', '');
  register_setting('riara_group', 'riara_amazon_access_key', '');
  register_setting('riara_group', 'riara_amazon_secret_access_key', '');
  register_setting('riara_group', 'riara_amazon_search_index', '');
  register_setting('riara_group', 'riara_amazon_search_index', '');
  register_setting('riara_group', 'riara_amazon_associate_tag', '');
  register_setting('riara_group', 'riara_amazon_image_size', '');
  
  // Rakuten Setting
  register_setting('riara_group', 'riara_rakuten_api_type', '');
  register_setting('riara_group', 'riara_rakuten_application_id', '');
  register_setting('riara_group', 'riara_rakuten_affiliate_id', '');
  register_setting('riara_group', 'riara_rakuten_image_size', '');
  
  // General Setting
  register_setting('riara_group', 'riara_general_heading_text', '');
  register_setting('riara_group', 'riara_general_display_value', '');
  register_setting('riara_group', 'riara_general_default_banner_pc', '');
  register_setting('riara_group', 'riara_general_default_banner_mobile', '');
  register_setting('riara_group', 'riara_general_max_item_number_pc', '');
  register_setting('riara_group', 'riara_general_max_item_number_mobile', '');

}
add_action('admin_menu', 'add_plugin_admin_menu');

function display_riara_settings() {
  require_once( RIARA_DIR . 'settings.php' );
}

function display_riara() {
  $tags = get_the_tags();
  if (!$tags){
    if (wp_is_mobile()) {
      echo get_site_option('riara_general_default_banner_pc');
    } else {
      echo get_site_option('riara_general_default_banner_mobile');
    }
  } else { 
    if (true) {
      require_once( RIARA_DIR . 'amazon-affiliate.php' );
    } else {
      require_once( RIARA_DIR . 'rakuten-affiliate.php' );
    }
  }
}

