<?php
/**
 * Functions for AppPresser OneSignal
 *
 * @package  AppPresser OneSignal
 */

namespace AppPresser\OneSignal;

/**
 * Send push data to OneSignal api.
 *
 * @param string $message
 * @param string $header
 * @param array  $user_ids
 * @return void
 */
function appsig_send_message( string $message, string $header, string $subtitle, array $user_ids = array() ) {

	$options = get_option( 'appp_onesignal' );

	if ( empty( $options['onesignal_app_id'] ) || empty( $options['onesignal_rest_api_key'] ) ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $options['onesignal_app_id'], $options['onesignal_rest_api_key'] );

	if ( empty( $user_ids ) ) {
		$response = $api_class->send_message( $message, $header, $subtitle );
	} else {
		$response = $api_class->send_message_to_device( $message, $header, $subtitle, array( 'users' => array_map( 'strval', $user_ids ) ) );
	}	

}
