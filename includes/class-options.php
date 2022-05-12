<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Options for AppPresser OneSignal
 *
 * @package  AppPresser OneSignal
 */

/**
 * AppPresserOptions class
 */
class AppPresserOptions {

	/**
	 * Main Instance.
	 *
	 * @since 1.0.0
	 *
	 * @static object $instance
	 * @see AppPresserOptions()
	 *
	 * @return AppPresserOptions|null The one true AppPresser.
	 */
	public static function instance() {

		// Store the instance locally to avoid private static replication.
		static $instance = null;

		// Only run these methods if they haven't been run previously.
		if ( null === $instance ) {
			$instance = new AppPresserOptions();
			$instance->load();
		}

		// Always return the instance.
		return $instance;

		// Long live and prosper.
	}


	/**
	 * A dummy constructor to prevent AppPresserOptions from being loaded more than once.
	 *
	 * @since 1.0.0
	 * @see AppPresserOptions::instance()
	 * @see AppPresserOptions()
	 */
	private function __construct() {
		/* Do nothing here */
	}

	/**
	 * Registers hooks for this class.
	 *
	 * @return void
	 */
	public function load() {
		add_action( 'init', array( $this, 'add_options_page' ), 999 );
	}

	/**
	 * Add options page
	 */
	public function add_options_page() {

		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		$options = acf_add_options_page(
			array(
				'page_title' => 'AppPresser',
				'menu_title' => 'AppPresser',
				'menu_slug'  => 'appp-general-settings',
				'icon_url'   => 'dashicons-smartphone',
				'capability' => 'manage_options',
				'redirect'   => false,
				'position'   => 1,
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Push Notifications',
				'menu_title'  => 'Push Notifications',
				'parent_slug' => $options['menu_slug'],
				'capability'  => 'manage_options',
				'redirect'    => false,
			)
		);

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Open Weather',
				'menu_title'  => 'Open Weather',
				'parent_slug' => $options['menu_slug'],
				'capability'  => 'manage_options',
				'redirect'    => false,
			)
		);

	}



}
