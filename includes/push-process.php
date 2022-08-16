<?php
/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

use AppPresser\OneSignal;

/**
 * Sends push notification on post publish.
 *
 * @param WP_Post $post
 * @return void
 */
function appp_push_notification_send_hook( $post_id ) {


	if ( get_post_status( $post_id ) !== 'publish' ) {
		return;
	}

	if ( 'push_notification' === get_post_type( $post_id ) ) {

			$launch_url = get_field( 'onesignal_launch_url', $post_id );
			$page       = get_field( 'onesignal_open_page', $post_id );
			$image      = get_field( 'onesignal_image', $post_id );

			$message = array(
				'title'      => get_field( 'onesignal_title', $post_id ),
				'sub_title'  => get_field( 'onesignal_sub_title', $post_id ),
				'message'    => get_field( 'onesignal_message', $post_id ),
				'image'      => $image,
				'url'        => get_field( 'onesignal_launch_url', $post_id ),
				'send_to'    => get_field( 'onesignal_send_to', $post_id ),
				'custom_url' => get_field( 'onesignal_custom_url', $post_id ),
				'open_page'  => $page ? "/{$launch_url}/{$page->post_name}" : null,
			);

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

			if ( empty( $message['send_to'] ) ) {
				return;
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
add_action( 'acf/save_post', 'appp_push_notification_send_hook', 15 );
add_action( 'future_to_publish', 'appp_push_notification_send_hook', 15 );

/**
 * Hook into woo subscriton status change and then update onesignal has_subscription tag for user.
 *
 * @param object $data woo subscription object
 * @param string $to
 * @param string $from
 * @return void
 */
function appp_update_onesignal_subscription_tag( $data, $to, $from ) {

	$userid = $data->get_user_id();

	if ( 'active' === $to ) {
		AppPresser\OneSignal\appsig_set_tags( $userid, '{"tags":{"has_subscription":"true"}}' );

	} else {
		AppPresser\OneSignal\appsig_set_tags( $userid, '{"tags":{"has_subscription":""}}' );
	}
}
//add_action( 'woocommerce_subscription_status_updated', 'appp_update_onesignal_subscription_tag', 10, 3 );
