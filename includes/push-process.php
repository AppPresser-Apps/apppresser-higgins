<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use AppPresser\OneSignal;

/**
 * Sends push notification on post publish.
 *
 * @param WP_Post $post
 * @return void
 */
function appp_push_notification_send_hook( $post ) {

	if ( isset( $post ) && 'push_notification' === $post->post_type ) {

			$launch_url = get_field( 'onesignal_launch_url', $post->ID );
			$page       = get_field( 'onesignal_open_page', $post->ID );
			$image      = get_field( 'onesignal_image', $post->ID );

			$message = array(
				'title'     => get_field( 'onesignal_title', $post->ID ),
				'sub_title' => get_field( 'onesignal_sub_title', $post->ID ),
				'message'   => get_field( 'onesignal_message', $post->ID ),
				'image'     => $image,
				'url'       => get_field( 'onesignal_launch_url', $post->ID ),
				'send_to'   => get_field( 'onesignal_send_to', $post->ID ),
				'open_page' => $page ? "/{$launch_url}/{$page->post_name}" : null,
			);

			$options = array(
				'data'  => array(),
				'image' => $image,
			);

			if ( 'none' !== $launch_url ) {
				$options['data']['deeplink'] = $message['open_page'];
			}

			switch ( $message['send_to'] ) {

				case 'all':
					AppPresser\OneSignal\appsig_send_message( $message['message'], $message['title'], $message['sub_title'], $options );
					break;

				default:
					$options['tag']   = $message['send_to'];
					$options['image'] = $message['image'];

					AppPresser\OneSignal\appsig_send_message_to_tag( $message['message'], $message['title'], $message['sub_title'], $options );
					break;
			}
	}

}
add_action( 'draft_to_publish', 'appp_push_notification_send_hook' );
add_action( 'future_to_publish', 'appp_push_notification_send_hook' );
