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

	$appid  = get_field( 'onesignal_app_id', 'options' );
	$apikey = get_field( 'onesignal_api_key', 'options' );

	if ( ! $appid || ! $apikey ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $appid, $apikey );

	$response = $api_class->send_message( $message, $header, $subtitle, $options );
}

function appsig_send_message_to_tag( string $message, string $header, string $subtitle, array $options = array() ) {

	$appid  = get_field( 'onesignal_app_id', 'options' );
	$apikey = get_field( 'onesignal_api_key', 'options' );

	if ( ! $appid || ! $apikey ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $appid, $apikey );

	$response = $api_class->send_message_to_tag( $message, $header, $subtitle, $options );

}

function appsig_set_tags( $user_id, $tags ) {

	$appid  = get_field( 'onesignal_app_id', 'options' );
	$apikey = get_field( 'onesignal_api_key', 'options' );

	if ( ! $appid || ! $apikey ) {
		return;
	}

	// Attempt to send the message through the OneSignal API.
	$api_class = new API( $appid, $apikey );

	$response = $api_class->set_tags( $user_id, $tags );

}