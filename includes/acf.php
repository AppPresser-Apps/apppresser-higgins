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
		return true; // hide it.
	}
}
add_filter( 'acf/settings/show_admin', 'appp_acf_show_admin' );


function appp_acf_update_value( $value, $post_id, $field, $original ) {

	/**
	 * Filter one signal check box to not save the yes value and use send so a push gets sent when checked.
	 */
	if ( 'onesignal_check_to_send' === $field['name'] ) {
		if ( 'yes' === $value[0] ) {
			$value = 'send';
		}
	}

	return $value;
}
add_filter( 'acf/update_value', 'appp_acf_update_value', 10, 4 );
