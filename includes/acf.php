<?php

/**
 * ACF Options Page
 */
function appp_acf_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'title'      => 'AppPresser',
			'capability' => 'manage_options',
            'redirect' => true,
            'icon_url' => 'dashicons-smartphone',
            'update_button' => 'Save options',
            'updated_message' => 'Options saved',
		)
	);
}
add_action( 'init', 'appp_acf_options_page' );
