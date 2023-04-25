<?php
/**
 * CPT setup
 *
 * @package Medicines
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Medicines' ) ) {
	/**
	 * Main Medicines Class.
	 *
	 * @class Medicines
	 */
	final class Medicines {
		/**
		 * Medicines plugin version.
		 *
		 * @var string
		 */
		public $version = '1.0.0';
		/**
		 * Plugin name.
		 *
		 * @var string
		 */
		public $plugin_name = 'WP Medicines';

		/**
		 * The single instance of the class.
		 *
		 * @var med_instance
		 * @since 2.1
		 */
		protected static $instance = null;


		/**
		 * Main Medicines Instance.
		 *
		 * Ensures only one instance of Medicines is loaded or can be loaded.
		 *
		 * @since 2.1
		 * @static
		 * @see WC()
		 * @return Medicines - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}


		/**
		 * Class Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since 2.3
		 */
		private function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
		}

		/**
		 * Registers the Custom Product Boxes Product type to WooCommerce
		 *
		 * @return void
		 */
		public function register_medicine_post_type() {
			// Medicine post Type, registering post type medicines.
			require_once MED_ABSPATH . 'includes/class-wp-post-medicines.php';

			// Data Store classes.
			// include_once MED_ABSPATH . 'includes/data/class-medicines-data.php';
		}

		/**
		 * Define MED Constants.
		 */
		private function define_constants() {
			$this->define( 'MED_ABSPATH', dirname( MED_PLUGIN_FILE ) . '/' );
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
			/**
			 * Class autoloader.
			 */
			include_once MED_ABSPATH . 'includes/class-med-autoloader.php';
			// Including core med functions.
			include_once MED_ABSPATH . 'includes/med-core-functions.php';
			// include_once MED_ABSPATH . 'public/class-med-public.php';
			// include_once MED_ABSPATH . 'public/med-template-hooks.php';
			include_once MED_ABSPATH . 'includes/class-med-endpoints.php';

			if ( is_request( 'admin' ) ) {
				// Including admin classes.
				include_once MED_ABSPATH . 'admin/class-med-admin.php';
			}
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name  Constant name.
		 * @param string|bool $value Constant value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Init Medicine when WordPress Initialises.
		 */
		public function init() {
			$this->load_plugin_textdomain();
			$this->register_medicine_post_type();
		}

		/**
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'wp-medicines', false, plugin_basename( dirname( MED_PLUGIN_FILE ) ) . '/languages/' );
		}

		/**
		 * Function used to Init Template Functions - This makes them pluggable by plugins and themes.
		 */
		public function cpb_include_template_functions() {
			include_once MED_ABSPATH . 'public/cpb-template-functions.php';
		}
	}
}
