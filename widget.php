<?php
class Marketo_Subscribe_Widget extends WP_Widget
{
	// Main widget logic
	function widget($args, $instance)
	{
		// enquee the widget js
		wp_enqueue_script( 'marketo_subscribe_widget', plugins_url('js/widget.js', __FILE__), array('jquery'), null, true );

		extract($args, EXTR_SKIP);

		echo $before_widget;
		echo $before_title;
		echo $instance['title'];
		echo $after_title;

		// create a nonce
		$nonce = wp_create_nonce('marketo_subscribe_nonce');
		?>
			<form id="marketo-subscribe-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
				<input type="hidden" name="action" value="marketo_subscribe">
				<input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
				<input type="hidden" name="campaign_id" value="<?php echo $instance['campaign_id'] ?>">
				<div id="marketo-subscribe-inputs">
					<p><?php echo $instance['widget_text'] ?></p>
					<p><input type="email" name="subscriber_email" id="marketo-subscriber-email" value="Email Address"></p>
					<p><input type="submit" value="Subscribe"></p>
				</div>
				<p id="marketo-subscribe-thank-you" style="display: none;"><?php echo $instance['thank_you'] ?></p>
			</form>
		<?php

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
		$instance['thank_you'] = $new_instance['thank_you'];
		$instance['campaign_id'] = $new_instance['campaign_id'];

		return $instance;
	}

	// Widgets form
	function form($config)
	{
	?>
		<label for="<?php echo $this->get_field_id('title'); ?>">
			<p>
				<label>Title:</label>
				<input class="widefat" type="text" value="<?php echo $config['title']; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_name('title'); ?>">
			</p>
		</label>

		<label for="<?php echo $this->get_field_id('widget_text'); ?>">
			<p>
				<label>Text:</label>
				<textarea type="text" class="widefat" name="<?php echo $this->get_field_name('widget_text'); ?>" id="<?php echo $this->get_field_name('widget_text'); ?>"><?php echo $config['widget_text']; ?></textarea>
			</p>
		</label>

		<label for="<?php echo $this->get_field_id('thank_you'); ?>">
			<p>
				<label for="">Thank you message:</label>
				<textarea tipe="text" class="widefat" name="<?php echo $this->get_field_name('thank_you'); ?>" id="<?php echo $this->get_field_name('widget_text'); ?>"><?php echo $config['thank_you']; ?></textarea>
			</p>
		</label>

		<label for="<?php echo $this->get_field_id('campaign_id'); ?>">
			<p>
				<label>Campaign ID: (4 digit number)</label>
				<input class="widefat" type="text" value="<?php echo $config['campaign_id']; ?>" name="<?php echo $this->get_field_name('campaign_id'); ?>" id="<?php echo $this->get_field_name('campaign_id'); ?>">
			</p>
		</label>
	<?php
	}
}
?>