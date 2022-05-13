<?php

use AppPresser\OneSignal;

/**
 * Hide acf menu unless defined in wp-config.
 * This is a requirement of the plugin license when included as a dependency.
 *
 * @param boolean $show
 * @return void
 */
function appp_acf_show_admin( $show ) {

	if ( SHOW_ACF === true ) {
		return true; // show it.
	} else {
		return false; // hide it.
	}
}
add_filter( 'acf/settings/show_admin', 'appp_acf_show_admin' );

function appp_push_notification_send_hook( $post_id ) {
	$screen = get_current_screen();

	error_log( print_r( $screen, true ) );

	if ( 'apppresser_page_acf-options-push-notifications' === $screen->id ) {

		$title     = get_field( 'onesignal_title', 'option' );
		$sub_title = get_field( 'onesignal_sub_title', 'option' );
		$message   = get_field( 'onesignal_message', 'option' );
		$image     = get_field( 'onesignal_image', 'option' );
		$url       = get_field( 'onesignal_launch_url', 'option' );
		$send_to   = get_field( 'onesignal_send_to', 'option' );

		error_log( print_r( $title, true ) );
		error_log( print_r( $sub_title, true ) );
		error_log( print_r( $message, true ) );
		error_log( print_r( $image, true ) );
		error_log( print_r( $url, true ) );
		error_log( print_r( $send_to, true ) );

		if ( 'all' === $send_to ) {
			AppPresser\OneSignal\appsig_send_message( $message, $title, $sub_title, array() );
		} else {

			$options = array(
				'users' => array(),
			);

			AppPresser\OneSignal\send_message_to_device( $message, $header, $subtitle, $options );
		}
	}
}
add_action( 'acf/save_post', 'appp_push_notification_send_hook' );
