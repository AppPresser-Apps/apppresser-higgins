<?php

/*
Plugin Name: Advanced Custom Fields: Random ID Field
Plugin URI: https://apppresser.com
Description: A random ID field for Advanced Custom Fields
Version: 1.0.0
Author: modemlooper, AppPresser
Author URI:https://apppresser.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-randomid', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );


// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function appp_sd344_include_field_types_randomid( $version ) {
	include_once 'acf-randomid-v5.php';
}

add_action( 'acf/include_field_types', 'appp_sd344_include_field_types_randomid' );


// 3. Include field type for ACF4
function appp_sd344_register_fields_randomid() {
	include_once 'acf-randomid-v4.php';
}

add_action( 'acf/register_fields', 'appp_sd344_register_fields_randomid' );
