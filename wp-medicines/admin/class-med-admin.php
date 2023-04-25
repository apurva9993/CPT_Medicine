<?php
/**
 * MED Admin
 *
 * @class    MED_Admin
 * @package  Medicines
 * @version  4.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MED_Admin' ) ) {
	/**
	 * MED_Admin class.
	 */
	class MED_Admin {
		/**
		 * Constructor.
		 */
		public function __construct() {
			// $this->includes();
			add_action( 'init', array( $this, 'includes' ) );
		}

		/**
		 * File Includes.
		 */
		public function includes() {
			$directory = dirname( __FILE__ );

			include MED_ABSPATH .'admin/class-med-admin-meta-box-data.php';
		}
	}

	return new MED_Admin();
}