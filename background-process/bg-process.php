<?php

use AppPresser\OneSignal;

class App_Push_Process extends WP_Background_Process {

	use App_Push_Logger;

	/**
	 * @var string
	 */
	protected $action = 'push_process';

	/**
	 * Task
	 *
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param mixed $item Queue item to iterate over
	 *
	 * @return mixed
	 */
	protected function task( $item ) {
		// Actions to perform
		// $this->really_long_running_task();
		$this->log( $item );

		$options = array(
			'tag'   => $item['send_to'],
			'image' => 'https://higginsstormchasing.com/wp-content/uploads/2021/10/AUS-Cyclone-Outlook-2122-scaled.jpg',
		);

		AppPresser\OneSignal\appsig_send_message_to_tag( $item['message'], $item['title'], $item['sub_title'], $options );

		return false;
	}

	/**
	 * Complete
	 *
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();

		// Show notice to user or perform some other arbitrary task...
	}

}
