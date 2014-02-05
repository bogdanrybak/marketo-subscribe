<?php
/*
Plugin Name: Marketo Subscribe Plugin
Plugin URI: 
Description: Helps you add leads through your compaign via custom form.
Version: 0.1
Author: Bogdan Rybak
Author URI: https://github.com/bogdanrybak
License: MIT
*/

require_once(dirname(__FILE__) . '/admin/marketo-subscribe-admin.php');
require_once(dirname(__FILE__) . '/widget.php');

// Add the settings page
if( is_admin() )
    $marketo_subscribe_settings_page = new MarketoSubscribeSettings();

// Register the widget
function marketo_subscribe_init()
{
	register_widget('Marketo_Subscribe_Widget');
}

add_action('widgets_init', 'marketo_subscribe_init');

?>
