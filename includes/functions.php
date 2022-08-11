<?php
/**
 * Exit if accessed directly.
 */
defined( 'ABSPATH' ) || exit;

use AppPresser\OneSignal;

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

/**
 * Register page taxonomies.
 *
 * @return void
 */
function appp_add_taxonomies_to_pages() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'appp_add_taxonomies_to_pages' );

if ( ! is_admin() ) {
	add_action( 'pre_get_posts', 'appp_category_and_tag_archives' );
}

/**
 * Add Page as post_type in the tag.php and archive.php files.
 *
 * @param WP_Query $wp_query
 * @return void
 */
function appp_category_and_tag_archives( $wp_query ) {

	$appp_post_array = array( 'post', 'page' );

	if ( $wp_query->get( 'category_name' ) || $wp_query->get( 'cat' ) ) {
		$wp_query->set( 'post_type', $appp_post_array );
	}

	if ( $wp_query->get( 'tag' ) ) {
		$wp_query->set( 'post_type', $appp_post_array );
	}

}

/**
 * Add post code to auth response.
 *
 * @param array   $data
 * @param WP_User $user
 * @return array
 */
function appp_add_postcode_auth( $data, $user ) {

	$billing_postcode = get_user_meta( (int) $user->data->ID, 'billing_postcode', true );

	if ( ! empty( $billing_postcode ) ) {
		$data['postcode'] = $billing_postcode;
	}

	return $data;

}
add_filter( 'jwt_auth_token_before_dispatch', 'appp_add_postcode_auth', 10, 2 );

/**
 * Check if active subscrption before login..
 *
 * @param array   $data
 * @param WP_User $user
 * @return array
 */
function appp_check_if_user_is_premium_auth( $data, $user ) {

	$has_sub = wcs_user_has_subscription( (int) $user->data->ID, 12075, 'active' );

	/** If the sub authentication fails return a error*/
	if ( ! $has_sub ) {
		AppPresser\OneSignal\appsig_set_tags( $userid, '{"tags":{"has_subscription":""}}' );
		return new WP_Error(
			'jwt_no_sub',
			'User has no access to this resource. Please manage account on website.',
			array(
				'status'           => 403,
				'has_subscription' => false,
			)
		);
	} else {
		AppPresser\OneSignal\appsig_set_tags( $userid, '{"tags":{"has_subscription":"true"}}' );
		$data['has_subscritpion'] = true;
	}

	return $data;

}
add_filter( 'jwt_auth_token_before_dispatch', 'appp_check_if_user_is_premium_auth', 999, 2 );
