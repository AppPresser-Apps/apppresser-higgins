<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add user meta to jwt api response.
 *
 * @param array   $data
 * @param WP_User $user
 * @return array
 */
function appp_add_user_meta_jwt( $data, $user ) {

	$alerts = get_user_meta( $user->data->ID, 'appp_alerts', true );

	$data['alerts'] = $alerts ? $alerts : array( 'general' );

	return $data;
}
add_filter( 'jwt_auth_token_before_dispatch', 'appp_add_user_meta_jwt', 10, 2 );
