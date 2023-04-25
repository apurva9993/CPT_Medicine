<?php
/**
 * Medicines Autoloader.
 *
 * @package Medicines/Classes
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 */
class MED_Autoloader {

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $include_path = '';

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $public_path = '';

	/**
	 * The Constructor.
	 */
	public function __construct() {
		if ( function_exists( '__autoload' ) ) {
			spl_autoload_register( '__autoload' );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->include_path = untrailingslashit( plugin_dir_path( MED_PLUGIN_FILE ) ) . '/includes/';
		$this->public_path = untrailingslashit( plugin_dir_path( MED_PLUGIN_FILE ) ) . '/public/';
		$this->admin_path = untrailingslashit( plugin_dir_path( MED_PLUGIN_FILE ) ) . '/admin/';
	}

	/**
	 * Take a class name and turn it into a file name.
	 *
	 * @param  string $class Class name.
	 * @return string
	 */
	private function get_file_name_from_class( $class ) {
		return 'class-' . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string $path File path.
	 * @return bool Successful or not.
	 */
	private function load_file( $path ) {
		if ( $path && is_readable( $path ) ) {
			include_once $path;
			return true;
		}
		return false;
	}

	/**
	 * Auto-load WC classes on demand to reduce memory consumption.
	 *
	 * @param string $class Class name.
	 */
	public function autoload( $class ) {

		$class = strtolower( $class );

		$include_path = $this->include_path;

		if ( 0 !== strpos( $class, 'med_' ) ) {
			return;
		}

		$file = $this->get_file_name_from_class( $class );
		$path = '';

		if ( 0 === strpos( $class, 'med_admin' ) ) {
			$include_path = $this->admin_path;
		} elseif ( 0 === strpos( $class, 'med_public' ) ) {
			$include_path = $this->public_path;
		}

		if ( empty( $path ) || ! $this->load_file( $path . $file ) ) {
			$this->load_file( $include_path . $file );
		}
	}
}

new MED_Autoloader();
