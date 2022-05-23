<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * REgister API routes.
 *
 * @return void
 */
function appp_register_routes() {

	register_rest_route(
		'opw',
		'onecall',
		array(
			'methods'             => 'GET',
			'callback'            => 'appp_one_call',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'apppresser',
		'meta',
		array(
			'methods'             => 'POST',
			'callback'            => 'appp_user_meta',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'apppresser',
		'portal',
		array(
			'methods'             => 'GET',
			'callback'            => 'appp_member_portal',
			'permission_callback' => '__return_true',
		)
	);

}
add_action( 'rest_api_init', 'appp_register_routes' );

/**
 * Open Weather API Data.
 *
 * @param WP_Rest_Request $request
 * @return object
 */
function appp_one_call( $request ) {

	$opw = get_field( 'openweather_api_key', 'option' );

	$lat      = $request->get_param( 'lat' );
	$lon      = $request->get_param( 'lon' );
	$location = $request->get_param( 'location' );
	$unit     = $request->get_param( 'unit' );

	if ( ! empty( $location ) ) {
		$geo = appp_opw_geo( $location );

		if ( is_array( $geo ) ) {
			$lat = $geo[0]->lat;
			$lon = $geo[0]->lon;
		}
	}

	$url = 'https://api.openweathermap.org/data/2.5/onecall?lat=' . $lat . '&lon=' . $lon . '&units=' . $unit . '&appid=' . $opw;

	$response = wp_remote_get( $url );
	$body     = wp_remote_retrieve_body( $response );

	return json_decode( $body );

}

/**
 * Fetch openweather geo data and return response.
 *
 * @param string $location
 * @return object
 */
function appp_opw_geo( $location = '' ) {

	$opw = get_field( 'openweather_api_key', 'option' );

	$url = 'https://api.openweathermap.org/geo/1.0/direct?q=' . $location . '&limit=1&appid=' . $opw;

	$response = wp_remote_get( $url );
	$body     = wp_remote_retrieve_body( $response );

	return json_decode( $body );
}

/**
 * Update each user meta key / value.
 *
 * @param WP_Rest_Request $request
 * @return void
 */
function appp_user_meta( $request ) {

	$meta    = $request->get_param( 'meta' );
	$user_id = get_current_user_id();

	if ( 0 !== $user_id ) {
		foreach ( $meta as $key => $value ) {
			$update = update_user_meta( $user_id, $key, $value );
		}
	}

	return $update;

}

function appp_member_portal( $request ) {
	$field = get_field( 'member_portal_section', 'options' );
	return $field;
}
