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
				'title'      => get_field( 'onesignal_title', $post->ID ),
				'sub_title'  => get_field( 'onesignal_sub_title', $post->ID ),
				'message'    => get_field( 'onesignal_message', $post->ID ),
				'image'      => $image,
				'url'        => get_field( 'onesignal_launch_url', $post->ID ),
				'send_to'    => get_field( 'onesignal_send_to', $post->ID ),
				'custom_url' => get_field( 'onesignal_custom_url', $post->ID ),
				'open_page'  => $page ? "/{$launch_url}/{$page->post_name}" : null,
			);

			// error_log( print_r( $message, true ) );

			$options = array(
				'data'  => array(),
				'image' => $image,
			);

			if ( 'none' !== $launch_url ) {

				switch ( $launch_url ) {
					case 'member-portal':
						$options['data']['deeplink'] = $message['open_page'];
						break;
					case 'custom':
						$options['url'] = $message['custom_url'];
						break;

				}
			}

			if ( in_array( 'all', $message['send_to'], true ) ) {
				AppPresser\OneSignal\appsig_send_message( $message['message'], $message['title'], $message['sub_title'], $options );
			} else {
				$options['filters'] = array();
				$options['image']   = $message['image'];

				foreach ( $message['send_to'] as $tag ) {
					$options['filters'][] = array(
						'field'    => 'tag',
						'key'      => $tag,
						'relation' => '=',
						'value'    => 'true',
					);

					$options['filters'][] = array( 'operator' => 'OR' );
				}

				AppPresser\OneSignal\appsig_send_message_to_tag( $message['message'], $message['title'], $message['sub_title'], $options );
			}
	}

}
add_action( 'draft_to_publish', 'appp_push_notification_send_hook' );
add_action( 'future_to_publish', 'appp_push_notification_send_hook' );
