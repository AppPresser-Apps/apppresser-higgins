<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use AppPresser\OneSignal;

function appp_push_notification_send_hook( $post ) {

	// error_log( print_r( $post, true ) );

	if ( isset( $post ) && 'push_notification' === $post->post_type ) {

			$page = get_field( 'onesignal_open_page', $post->ID );

			$message = array(
				'title'     => get_field( 'onesignal_title', $post->ID ),
				'sub_title' => get_field( 'onesignal_sub_title', $post->ID ),
				'message'   => get_field( 'onesignal_message', $post->ID ),
				'image'     => get_field( 'onesignal_image', $post->ID ),
				'url'       => get_field( 'onesignal_launch_url', $post->ID ),
				'send_to'   => get_field( 'onesignal_send_to', $post->ID ),
				'open_page' => $page ? '/member-portal/' . $page->post_name : null,
			);

			switch ( $message['send_to'] ) {
				case 'all':
					AppPresser\OneSignal\appsig_send_message( $message['message'], $message['title'], $message['sub_title'], array() );
					break;

				default:
					$options = array(
						'tag'   => $message['send_to'],
						'image' => 'https://higginsstormchasing.com/wp-content/uploads/2021/10/AUS-Cyclone-Outlook-2122-scaled.jpg',
					);

					AppPresser\OneSignal\appsig_send_message_to_tag( $message['message'], $message['title'], $message['sub_title'], $options );
					break;
			}
	}

}
add_action( 'draft_to_publish', 'appp_push_notification_send_hook' );
add_action( 'future_to_publish', 'appp_push_notification_send_hook' );
