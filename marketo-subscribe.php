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

/**
 * Settings page
 */

if( is_admin() )
    $marketo_subscribe_settings_page = new MarketoSubscribeSettings();

/**
 * Ajax request handling
 */

add_action('wp_ajax_marketo_subscribe', 'add_lead_to_marketo');
add_action('wp_ajax_nopriv_marketo_subscribe', 'add_lead_to_marketo');

/**
 * Adding lead to marketo using marketo API library by Bon Ubois. (https://github.com/flickerbox/marketo)
 * Email address is used to create a new lead.
 * 
 * If marketo cookie is present it is also sent to identify the lead (should work if the munchkin script is used on the site)
 */

function add_lead_to_marketo()
{
	if (!wp_verify_nonce($_POST['nonce'], 'marketo_subscribe_nonce')) {
		exit('No');
	}

	$subscriber_email = sanitize_text_field($_POST['subscriber_email']);
	$campaign_id = absint($_POST['campaign_id']);
	$result = array();

	/**
	 * Check if the email is supplied or valid
	 */
	if (empty($subscriber_email) || !is_email($subscriber_email))
		exit('Invalid email');

	require_once(dirname(__FILE__) . '/marketo/marketo.php');

	$options = get_option('marketo_credentials_option');

	$marketo_client = new Marketo($options['user_id'], $options['encryption_key'], preg_replace('#^http(s)?://#', '', $options['soap_endpoint']));

	$lead = null;

	if (isset($_COOKIE['mkto_trk']))
	{
		$lead = $marketo_client->sync_lead(
			array('Unsubscribed' => false), // set to false if the lead was unsubscribed
			$subscriber_email,
			$_COOKIE['mto_trk']);
	}
	else // in case of no munchkin
	{
		$lead = $marketo_client->sync_lead(array( 'Email' => $subscriber_email));
	}

	if (!empty($campaign_id))
		$added_to_campaign = $marketo_client->add_to_campaign($campaign_id, array('idnum' => $lead->leadId));

	if ($lead && !empty($lead->leadId))
		$result['type'] = 'success';
	else
		$result['type'] = 'error';
	
	$result['email'] = $subscriber_email;

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$result = json_encode($result);
		echo $result;
	}
	else {
		header("Location: ".$_SERVER["HTTP_REFERER"]);
	}

   die();
}


/**
 * Widget initialization
 */

function marketo_subscribe_init()
{
	register_widget('Marketo_Subscribe_Widget');
}

add_action('widgets_init', 'marketo_subscribe_init');

?>
