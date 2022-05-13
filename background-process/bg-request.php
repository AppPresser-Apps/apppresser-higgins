<?php

class App_Push_Request extends WP_Async_Request {

	/**
	 * @var string
	 */
	protected $action = 'push_request';

	/**
	 * Handle
	 *
	 * Override this method to perform any actions required
	 * during the async request.
	 */
	protected function handle() {
		error_log( print_r( 'request', true ) );
		// Actions to perform
	}

}
