<?php
/**
 * Plugin Name: WP Medicines
 * Description: The WP Medicines is an extension for creating a new post type medicines.
 * Version: 1.0
 * Author: Apurva
 * Text Domain: wp-medicines
 * Domain Path: /languages/
 * License: GPL
 * Requires at least: 5.4
 * Requires PHP: 8.0
 * WP requires at least: 6.0
 * WP tested up to: 6.2
 *
 * @package Medicines
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
// Define plugin constants.
// constant version.
if ( ! defined( 'MED_PLUGIN_FILE' ) ) {
	define( 'MED_PLUGIN_FILE', __FILE__ );
}


/**
 * Returns the main instance of Medicines.
 *
 * @since  2.1
 * @return WooCommerce
 */
function MED() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	// Include the main MED class.
	if ( ! class_exists( 'Medicines', false ) ) {
		include_once dirname( __FILE__ ) . '/includes/class-medicines.php';
	}
	return Medicines::instance();
}


add_action( 'plugins_loaded', 'load_med_plugin' );

/**
 * Starts the instantiation of Medicines plugin.
 *
 * @return void
 */
function load_med_plugin() {
	// Global for backwards compatibility.
	$GLOBALS['med_instance'] = MED();
}
