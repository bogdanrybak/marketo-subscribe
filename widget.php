<?php
class Marketo_Subscribe_Widget extends WP_Widget
{
	// Main widget logic
	function widget($args, $instance)
	{       
		extract($args, EXTR_SKIP);
		echo $before_widget;
		echo $before_title;
		echo $instance['title'];
		echo $after_title;
		echo '<p>' . $instance['widget_text'] . '</p>';
		echo $after_widget;
	}

	// Constructor
	function Marketo_Subscribe_Widget()
	{
		$widget_options = array(
			'classname' => 'marketo-subscribe-widget',
			'description' => 'Shows a simple email form for your Marketo form'
			);
		$this->WP_Widget('marketo_subscribe_widget', 'Marketo Subscribe Widget', $widget_options, null);
	}

	function  update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['widget_text'] = $new_instance['widget_text'];

		return $instance;
	}

	// Widgets form
	function form($config)
	{
	?>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			<p>
				Title: <input type="text" value="<?php echo $config['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_name('title'); ?>">
			</p>
		</label>

		<label for="<?php echo $this->get_field_id('widget_text'); ?>">
			<p>
				Text: <input type="text" value="<?php echo $config['widget_text']; ?>" name="<?php echo $this->get_field_name('widget_text'); ?>" id="<?php echo $this->get_field_name('widget_text'); ?>">
			</p>
		</label>
	<?php
	}
}
?>