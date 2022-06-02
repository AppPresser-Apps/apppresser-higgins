<?php
/**
 * AppPresser
 *
 * @package   AppPresser
 * @copyright Copyright(c) 2019, AppPresser LLC
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 * Plugin Name: AppPresser Custom
 * Plugin URI: https://apppresser.com
 * Description: Functionality for custom AppPresser Apps.
 * Version: 1.0.0
 * Author: AppPresser
 * Author URI: https://apppresser.com
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: apppresser
 * Domain Path: languages
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'APPPRESSER_VERSION', '1.0.0' );
define( 'APPPRESSER_PLUGIN_NAME', 'AppPresser' );
define( 'APPPRESSER_DIR', plugin_dir_path( __FILE__ ) );
define( 'APPPRESSER_URL', plugins_url( '/', __FILE__ ) );
define( 'APPPRESSER_SLUG', plugin_basename( __FILE__ ) );
define( 'APPPRESSER_FILE', __FILE__ );

require dirname( __FILE__ ) . '/class-apppresser.php';

/**
 * The main loader function.
 *
 * @return AppPresser|null The one true AppPresser Instance.
 */
function apppresser() {

	if ( class_exists( 'AppPresser' ) ) {
		return AppPresser::instance();
	}

}
add_action( 'plugins_loaded', 'apppresser' );

/**
 * Force CORS to allow api access from Android and iOS.
 *
 * @param WP_Rest_Request $request
 * @return void
 */
function appp_init_cors( $request ) {
	$origin_url = '*';

	header( 'Access-Control-Allow-Origin: ' . $origin_url );
	header( 'Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS' );
	header( 'Access-Control-Allow-Credentials: true' );
	return $request;
}
add_action(
	'rest_api_init',
	function() {
		remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
		add_filter( 'rest_pre_serve_request', 'appp_init_cors' );
	},
	15
);
