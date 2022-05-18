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
function appsig_send_message( string $message, string $header, string $subtitle, array $options = array() ) {

	$settings = get_option( 'appp_onesignal' );

	if ( empty( $settings['onesignal_app_id'] ) || empty( $settings['onesignal_rest_api_key'] ) ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $settings['onesignal_app_id'], $settings['onesignal_rest_api_key'] );

	if ( empty( $options ) ) {
		$response = $api_class->send_message( $message, $header, $subtitle );
	} 
}

function appsig_send_message_to_tag( string $message, string $header, string $subtitle, array $options ) {

	$settings = get_option( 'appp_onesignal' );

	if ( empty( $settings['onesignal_app_id'] ) || empty( $settings['onesignal_rest_api_key'] ) ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $settings['onesignal_app_id'], $settings['onesignal_rest_api_key'] );

	$response = $api_class->send_message_to_tag( $message, $header, $subtitle, $options );

}