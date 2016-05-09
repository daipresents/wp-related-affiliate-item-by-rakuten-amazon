<?php
/*  Copyright 2016 Dai Fujihara  (email : daipresents[at]gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
?>
<?php
Plugin Name: Related Affiliate Item by Rakuten and Amazon (RAIRA)
Plugin URI: http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/
Description: This plugin support you to monetize your blog by displaying the contents which are affiliate image, link etc.
Author: @daipresents
Version: 0.1
Author URI: http://daipresents.com/
*/

require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'widget.php' );

load_plugin_textdomain
( 'wp-raira', false, basename( dirname( __FILE__ ) ) . '/languages' );

// For setting on admin menu.
function add_plugin_admin_menu() {
  add_submenu_page( 
    'options-general.php',
    'Related Affiliate Item (関連アフィリエイト商品)',
    'Related Affiliate Item (関連アフィリエイト商品)',
    'administrator',
    'wp-related-affiliate-item-by-rakuten-amazon',
    'display_wp_raira_settings'
  );
  
  // General Setting
  register_setting('wp_raira_group', 'wp_raira_is_display', '');
  register_setting('wp_raira_group', 'wp_raira_search_by', '');

  // Amazon Setting
  register_setting('wp_raira_group', 'wp_raira_amazon_api_endpoint', '');
  register_setting('wp_raira_group', 'wp_raira_amazon_access_key', '');
  register_setting('wp_raira_group', 'wp_raira_amazon_secret_access_key', '');
  register_setting('wp_raira_group', 'wp_raira_amazon_search_index', '');
  register_setting('wp_raira_group', 'wp_raira_amazon_associate_tag', '');
  
  // Rakuten Setting
  register_setting('wp_raira_group', 'wp_raira_rakuten_api_endpoint', '');
  register_setting('wp_raira_group', 'wp_raira_rakuten_application_id', '');
  register_setting('wp_raira_group', 'wp_raira_rakuten_affiliate_id', '');
  
  // Display Setting
  register_setting('wp_raira_group', 'wp_raira_display_service', '');
  register_setting('wp_raira_group', 'wp_raira_heading_text', '');
  register_setting('wp_raira_group', 'wp_raira_image_size', '');
  register_setting('wp_raira_group', 'wp_raira_skip_no_image_item', '');
  register_setting('wp_raira_group', 'wp_raira_is_display_item_name', '');
  register_setting('wp_raira_group', 'wp_raira_default_banner_pc', '');
  register_setting('wp_raira_group', 'wp_raira_default_banner_mobile', '');
  register_setting('wp_raira_group', 'wp_raira_max_item_number_pc', '');
  register_setting('wp_raira_group', 'wp_raira_max_item_number_mobile', '');

  // Default
  register_setting('wp_raira_group', 'wp_raira_default_amazon_associate_tag', '');
  register_setting('wp_raira_group', 'wp_raira_default_rakuten_affiliate_id', '');

}
add_action('admin_menu', 'add_plugin_admin_menu');

add_action('widgets_init', function () {
    register_widget( 'wp_raira_Widget');
} );

add_action( 'wp_enqueue_scripts', 'add_init' );

?>
