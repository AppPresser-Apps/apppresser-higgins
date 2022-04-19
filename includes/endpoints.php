<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


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

function appp_one_call() {

	$url = 'https://api.openweathermap.org/data/2.5/onecall?lat=34.110466&lon=-118.287451&appid=' . OPW_KEY;

	$response = wp_remote_get( $url );
	$body     = wp_remote_retrieve_body( $response );

	return json_decode( $body );

}
