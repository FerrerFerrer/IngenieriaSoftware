<?php 
class phpeverywherewidget extends WP_Widget
{
  function __construct()
  {
	load_plugin_textdomain('php-everywhere', false, plugin_dir_path( __FILE__ )  . 'languages/' );
    $widget_ops = array('classname' => 'phpeverywherewidget', 'description' => __('Enables the execution of PHP and HTML', 'php-everywhere') );
    parent::__construct('phpeverywherewidget', 'PHP + HTML', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '','content' => '' ) );
    $title = $instance['title'];
    $content = $instance['content'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>

<label for="<?php echo $this->get_field_id('content'); ?>">Content: <textarea class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" rows="10"><?php echo esc_attr($content); ?></textarea></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['content'] = $new_instance['content'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
$content = empty($instance['content']) ? ' ' : $instance['content'];
$content = str_replace("<!--<?php","<?php",$content);
$content = str_replace("?-->","?>",$content);
eval(' ?>'.$content.'<?php ');

 
    echo $after_widget;
  }
 
}
?>