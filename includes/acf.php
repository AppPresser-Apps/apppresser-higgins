<?php
/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Hide acf menu unless defined in wp-config.
 * This is a requirement of the plugin license when included as a dependency.
 *
 * @param boolean $show
 * @return boolean
 */
function appp_acf_show_admin( $show ) {

	if ( defined( 'SHOW_ACF' ) ) {
		return true; // show it.
	} else {
		return false; // hide it.
	}
}
add_filter( 'acf/settings/show_admin', 'appp_acf_show_admin' );

/**
 * Save acf json to plugin folder
 *
 * @param string $path
 * @return string
 */
function appp_acf_json_save_point( $path ) {

	// update path.
	$path = APPPRESSER_DIR . '/acf-json';

	// return.
	return $path;

}
add_filter( 'acf/settings/save_json', 'appp_acf_json_save_point' );

/**
 * Get acf json from plugin folder
 *
 * @param array $paths
 * @return array
 */
function appp_acf_json_load_point( $paths ) {

	// remove original path (optional).
	unset( $paths[0] );

	// append path.
	$paths[] = APPPRESSER_DIR . '/acf-json';

	// return.
	return $paths;

}
add_filter( 'acf/settings/load_json', 'appp_acf_json_load_point' );
