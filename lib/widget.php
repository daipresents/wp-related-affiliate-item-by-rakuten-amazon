<?php
class RAIRA_Widget extends WP_Widget{

  function __construct() {
    parent::__construct(
        'wp_raira_widget',
        __("Related Affiliate Item by Amazon and Rakuten Widget", "wp-raira"),
        array( 'description' => __("Display Related Affiliate Item by Rakuten and Amazon. Add this widget to the place which you want to set.", "wp-raira"), )
    );
  }

  /**
   * Display this widget on widget page.
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
      display_raira();
  }

  /**
   * Widget form
   * @param array
   * @return string|void
   */
  public function form( $instance ){
    _e("Support page is <a href='http://daipresents.com/2016/wp-related-affiliate-item-by-rakuten-amazon-plugin/' target='_blank'>here</a>. You can also use this code. <br><code>&lt;?php display_raira(); ?&gt;</code>", "wp-raira");
  }

  /**
   * Check setting data.
   * @param array $new_instance
   * @param array $old_instance
   * @return array The setting data you want to save.
   */
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
}

