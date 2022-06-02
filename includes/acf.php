<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Hide acf menu unless defined in wp-config.
 * This is a requirement of the plugin license when included as a dependency.
 *
 * @param boolean $show
 * @return void
 */
function appp_acf_show_admin( $show ) {

	if ( SHOW_ACF === true ) {
		return true; // show it.
	} else {
		return false; // hide it.
	}
}
add_filter( 'acf/settings/show_admin', 'appp_acf_show_admin' );
