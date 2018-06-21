<?php
/*
Plugin Name: Gravity Forms - IBAN Field
Plugin URI: https://github.com/teolaz/gravityforms-iban-field
Description: An add-on to validate the printed text field with IBAN specifications
Version: 1.0
Author: teolaz
Author URI: https://github.com/teolaz
*/

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

define( 'GF_IBAN_FIELD', '1.0' );

add_action( 'gform_loaded', function () {
	if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
		return;
	}
	GFAddOn::register( \Teolaz\GravityFormsIBANField\Addon::class );
}, 5 );