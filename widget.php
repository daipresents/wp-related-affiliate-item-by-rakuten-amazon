<?php
class RIARA_Widget extends WP_Widget{

  function __construct() {
    parent::__construct(
        'riara_widget',
        'Related Item by Amazon and Rakuten Affiliate Widget',
        array( 'description' => 'Display Related Item by Amazon and Rakuten Affiliate.', )
    );
  }

  /**
   * Display this widget on widget page.
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
      display_riara();
  }

  /**
   * Widget form
   * @param array
   * @return string|void
   */
  public function form( $instance ){
    echo "<p>Add this widget to the place which you want to set. You can also use this code. <br><code>&lt;?php display_riara(); ?&gt;</code></p>";
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

