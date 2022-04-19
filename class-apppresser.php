<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Main AppPresser Class.
 *
 * @since 1.0.0
 */
class AppPresser {

	/**
	 * Main AppPresser Instance.
	 *
	 * @since 1.0.0
	 *
	 * @static object $instance
	 * @see AppPresser()
	 *
	 * @return AppPresser|null The one true AppPresser.
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication.
		static $instance = null;

		// Only run these methods if they haven't been run previously.
		if ( null === $instance ) {
			$instance = new AppPresser();
			$instance->vendors();
			$instance->includes();
		}

		// Always return the instance.
		return $instance;

		// Long live and prosper.
	}

	/** Magic Methods *********************************************************/

	/**
	 * A dummy constructor to prevent AppPresser from being loaded more than once.
	 *
	 * @since 1.0.0
	 * @see AppPresser::instance()
	 * @see AppPresser()
	 */
	private function __construct() {
		/* Do nothing here */
	}

	/**
	 * Include files
	 *
	 * @return void
	 */
	public function includes() {
		require_once APPPRESSER_DIR . '/includes/functions.php';
		require_once APPPRESSER_DIR . '/includes/endpoints.php';
	}

	/**
	 * Include vendors
	 *
	 * @return void
	 */
	public function vendors() {
		require_once APPPRESSER_DIR . 'vendors/jwt-authentication/jwt-authentication.php';
	}

}
