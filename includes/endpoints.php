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
			'methods'  => 'GET',
			'callback' => 'appp_one_call',
		)
	);

}
add_action( 'rest_api_init', 'appp_register_routes' );

/**
 * Open Weather API Data.
 *
 * @return void
 */
function appp_one_call( $request ) {

	$lat      = $request->get_param( 'lat' );
	$lon      = $request->get_param( 'lon' );
	$location = $request->get_param( 'location' );
	$unit     = $request->get_param( 'unit' );

	error_log( print_r( $request->get_params(), true ) );

	if ( ! empty( $location ) ) {
		$geo = appp_opw_geo( $location );

		error_log( print_r( $geo, true ) );

		if ( is_array( $geo ) ) {
			$lat = $geo[0]->lat;
			$lon = $geo[0]->lon;
		}
	}

	$url = 'https://api.openweathermap.org/data/2.5/onecall?lat=' . $lat . '&lon=' . $lon . '&units=' . $unit . '&appid=' . OPW_KEY;

	$response = wp_remote_get( $url );
	$body     = wp_remote_retrieve_body( $response );

	error_log( print_r( $url, true ) );

	return json_decode( $body );

}

function appp_opw_geo( $location = '' ) {

	$url = 'https://api.openweathermap.org/geo/1.0/direct?q=' . $location . '&limit=1&appid=' . OPW_KEY;

	$response = wp_remote_get( $url );
	$body     = wp_remote_retrieve_body( $response );

	error_log( print_r( $body, true ) );

	return json_decode( $body );
}
