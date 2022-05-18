<?php
class App_Push_Background_Processing {

	/**
	 * @var WP_Example_Process
	 */
	public $process_all;

	/**
	 * Example_Background_Processing constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'draft_to_publish', array( $this, 'appp_push_notification_send_hook' ) );
		add_action( 'future_to_publish', array( $this, 'appp_push_notification_send_hook' ) );
	}

	/**
	 * Init
	 */
	public function init() {

		if ( ! class_exists( 'WP_Async_Request' ) ) {
			require_once APPPRESSER_DIR . '/background-process/classes/wp-async-request.php';
		}
		if ( ! class_exists( 'WP_Background_Process' ) ) {
			require_once APPPRESSER_DIR . '/background-process/classes/wp-background-process.php';
		}

		require_once APPPRESSER_DIR . '/background-process/class-logger.php';
		require_once APPPRESSER_DIR . '/background-process/bg-process.php';

		$this->process_all = new App_Push_Process();

	}

	public function appp_push_notification_send_hook( $post ) {

		//error_log( print_r( $post, true ) );

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

				$this->process_all->push_to_queue( $message );

				$this->process_all->save()->dispatch();

		}

	}
}
new App_Push_Background_Processing();


function appp_push_notification_send_hook22222( $post_id ) {
	$screen = get_current_screen();

	// error_log( print_r( $screen, true ) );

	if ( 'apppresser_page_acf-options-push-notifications' === $screen->id ) {

		$title     = get_field( 'onesignal_title', 'option' );
		$sub_title = get_field( 'onesignal_sub_title', 'option' );
		$message   = get_field( 'onesignal_message', 'option' );
		$image     = get_field( 'onesignal_image', 'option' );
		$url       = get_field( 'onesignal_launch_url', 'option' );
		$send_to   = get_field( 'onesignal_send_to', 'option' );

		$example_process = new App_Push_Process();
		// error_log( print_r( $title, true ) );
		// error_log( print_r( $sub_title, true ) );
		// error_log( print_r( $message, true ) );
		// error_log( print_r( $image, true ) );
		// error_log( print_r( $url, true ) );
		// error_log( print_r( $send_to, true ) );

		if ( 'all' === $send_to ) {
			// AppPresser\OneSignal\appsig_send_message( $message, $title, $sub_title, array() );
		} else {

			$user_ids = array();

			switch ( $send_to ) {
				case 'admin':
					$users = get_users( array( 'role__in' => array( 'administrator' ) ) );
					// Array of WP_User objects.
					foreach ( $users as $user ) {
						$user_ids[] = strval( $user->ID );
					}

					break;

				case 'subscribers':
					$users = get_users( array( 'role__in' => array( 'subscriber' ) ) );
					// Array of WP_User objects.
					foreach ( $users as $user ) {
						$user_ids[] = strval( $user->ID );
					}

					break;

				case 'premium':
					// [total_users] => 32617
					// [avail_roles] => Array
					// (
					// [administrator] => 7
					// [subscriber] => 7388
					// [customer] => 25222
					// [none] => 0
					// )

					$count_users = count_users();
					$per_page    = 10;

					$customer_count = $count_users['avail_roles']['customer'];
					$num_pages      = ceil( ( $customer_count / 1000 ) / $per_page );

					error_log( print_r( $num_pages, true ) );

					for ( $i = 1; $i < $num_pages; $i++ ) {

						$args = array(
							'fields'   => array( 'ID' ),
							'role__in' => array( 'customer' ),
							'number'   => $per_page,
							'paged'    => $i,
						);

						$users = new WP_User_Query( $args );

						// error_log( print_r( $users, true ) );

						$user_ids = array();

						// Array of WP_User objects.
						foreach ( $users->get_results() as $user ) {
							$user_ids[] = strval( $user->ID );
							$example_process->push_to_queue( strval( $user->ID ) );
						}

						// $example_request = new App_Push_Request();
						// $example_request->data( array( 'data' => $user_ids ) )->dispatch();

						// $options = array(
						// 'users' => $user_ids,
						// );

						// AppPresser\OneSignal\appsig_send_message( $message, $title, $sub_title, $options );

					}

					$example_process->save()->dispatch();
					// error_log( print_r( $example_process, true ) );

					break;

			}
		}
	}
}
// add_action( 'acf/save_post', 'appp_push_notification_send_hook' );
