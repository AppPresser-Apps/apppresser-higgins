<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register push_notification Custom Post Type
 *
 * @return void
 */
function appp_push_notification() {

	$labels = array(
		'name'                  => _x( 'Push Notifications', 'Post Type General Name', 'AppPresser' ),
		'singular_name'         => _x( 'Push Notification', 'Post Type Singular Name', 'AppPresser' ),
		'menu_name'             => __( 'Push Notification', 'AppPresser' ),
		'name_admin_bar'        => __( 'Push Notification', 'AppPresser' ),
		'archives'              => __( 'Notification Archives', 'AppPresser' ),
		'attributes'            => __( 'Notification Attributes', 'AppPresser' ),
		'parent_item_colon'     => __( 'Parent Notification:', 'AppPresser' ),
		'all_items'             => __( 'All Notifications', 'AppPresser' ),
		'add_new_item'          => __( 'Add New Notification', 'AppPresser' ),
		'add_new'               => __( 'Add New', 'AppPresser' ),
		'new_item'              => __( 'New Notification', 'AppPresser' ),
		'edit_item'             => __( 'Edit Notification', 'AppPresser' ),
		'update_item'           => __( 'Update Notification', 'AppPresser' ),
		'view_item'             => __( 'View Notification', 'AppPresser' ),
		'view_items'            => __( 'View Notifications', 'AppPresser' ),
		'search_items'          => __( 'Search Notification', 'AppPresser' ),
		'not_found'             => __( 'Not found', 'AppPresser' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'AppPresser' ),
		'featured_image'        => __( 'Featured Image', 'AppPresser' ),
		'set_featured_image'    => __( 'Set featured image', 'AppPresser' ),
		'remove_featured_image' => __( 'Remove featured image', 'AppPresser' ),
		'use_featured_image'    => __( 'Use as featured image', 'AppPresser' ),
		'insert_into_item'      => __( 'Insert into Notification', 'AppPresser' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Notification', 'AppPresser' ),
		'items_list'            => __( 'Notifications list', 'AppPresser' ),
		'items_list_navigation' => __( 'Notifications list navigation', 'AppPresser' ),
		'filter_items_list'     => __( 'Filter Notifications list', 'AppPresser' ),
	);
	$args   = array(
		'label'               => __( 'Push Notification', 'AppPresser' ),
		'description'         => __( 'Post Type Description', 'AppPresser' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => false,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-megaphone',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => false,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
		'show_in_rest'        => false,
	);
	register_post_type( 'push_notification', $args );

}
add_action( 'acf/init', 'appp_push_notification', 0 );