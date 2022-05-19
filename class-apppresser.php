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
			$instance->load();
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
	private function includes() {

		$files = array(
			'/includes/functions.php',
			'/includes/endpoints.php',
			'/includes/push-post-type.php',
			'/includes/class-options.php',
			'/includes/acf.php',
			'/includes/push-process.php',
		);

		foreach ( $files as $file ) {
			if ( file_exists( APPPRESSER_DIR . $file ) ) {
				require_once APPPRESSER_DIR . $file;
			}
		}
	}

	/**
	 * Include vendor dependencies.
	 *
	 * @return void
	 */
	private function vendors() {

		$files = array(
			'vendors/jwt-authentication/jwt-authentication.php',
			'vendors/apppresser-onesignal/apppresser-onesignal.php',
			'vendors/advanced-custom-fields-pro/acf.php',
		);

		foreach ( $files as $file ) {
			if ( file_exists( APPPRESSER_DIR . $file ) ) {
				require_once APPPRESSER_DIR . $file;
			}
		}

	}

	/**
	 * Class instantiation method.
	 *
	 * @return void
	 */
	private function load() {
		if ( class_exists( 'AppPresserOptions' ) ) {
			AppPresserOptions::instance();
		}
	}

}
