<?php
/**
 * WP_Post_Medicines class
 *
 * @package  Medicines
 * @since 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Post_Medicines' ) ) {
	/**
	 * Medicine Post Class.
	 *
	 * @class    WP_Post_Medicines
	 * @version  1.0
	 */
	class WP_Post_Medicines {
		/**
		 * Array of UI labels for Custom Post Type, data fields used in CRUD and runtime operations.
		 *
		 * @var array
		 */
		private $labels = array();

		/**
		 * Array of other options for Custom Post Type.
		 *
		 * @var array
		 */
		private $args = array();

		/**
		 * Expiry date of Medicine.
		 *
		 * @var string
		 */
		protected $expiry_date;

		/**
		 * Manufacturing Company.
		 *
		 * @var string
		 */
		protected $mfg_company;

		/**
		 * The type of Medicine.
		 *
		 * @var string
		 */
		private $med_type;

		/**
		 * Constructor.
		 */
		public function __construct() {
			// Initialize the data store.

			// Initialize private properties.
			$this->load_defaults();

			// Define/load post data.
			$this->load_med_post_data();

			// Register medicine post type.
			$this->med_register_post_type();
		}

		/**
		 * Load property and runtime cache defaults to trigger a re-sync.
		 *
		 * @param bool $reset_objects Whether to rest the object or not.
		 * @since 1.0.0
		 */
		public function load_defaults() {
			// Set UI labels for Medicines Post Type
			$this->labels = array(
				'name' => _x( 'Medicines', 'post type general name', 'wp-medicines' ),
				'singular_name' => _x( 'Medicine', 'post type singular name', 'wp-medicines' ),
				'add_new' => _x( 'Add New', 'wp-medicines' ),
				'add_new_item' => __( 'Add New Medicine', 'wp-medicines' ),
				'edit_item' => __( 'Edit Medicine', 'wp-medicines' ),
				'new_item' => __( 'New Medicine', 'wp-medicines' ),
				'all_items' => __( 'All Medicines', 'wp-medicines' ),
				'view_item' => __( 'View Medicine', 'wp-medicines' ),
				'search_items' => __( 'Search medicines', 'wp-medicines' ),
				'update_item' => __( 'Update Medicine', 'wp-medicines' ),
				'not_found' => __( 'No medicines found', 'wp-medicines' ),
				'not_found_in_trash' => __( 'No medicines found in the Trash', 'wp-medicines' ),
				'parent_item_colon' => '',
				'menu_name' => 'Medicines',
			);

			$this->expiry_date = '';
			$this->mfg_company = '';
			$this->med_type = '';
		}

		/**
		 * Define type-specific data.
		 *
		 * @since 1.0.00
		 */
		private function load_med_post_data() {
			//Set other options for Medicines Post Type.
			$this->args = array(
		        'label'               => __( 'medicines', 'wp-medicines' ),
		        'description'         => __( 'Medicines details', 'wp-medicines' ),
		        'labels'              => $this->labels,  
		        'supports'            => array( 'title' ),     
		        'taxonomies'          => array( 'genres' ),     
		        'hierarchical'        => false,
		        'public'              => true,
		        'show_ui'             => true,
		        'show_in_menu'        => true,
		        'show_in_nav_menus'   => true,
		        'show_in_admin_bar'   => true,
		        'menu_position'       => 5,
		        'can_export'          => true,
		        'has_archive'         => true,
		        'exclude_from_search' => false,
		        'publicly_queryable'  => true,
			    'capability_type'     => array('medicine','medicines'), //custom capability type
			    'map_meta_cap'        => true,
		        'show_in_rest' => true, 
		    );

		    $role = get_role( 'editor' );

            $singular = 'medicine';
            $plural = 'medicines';

            $role->add_cap( "edit_{$singular}" ); 
            $role->add_cap( "edit_{$plural}" ); 
            $role->add_cap( "edit_others_{$plural}" ); 
            $role->add_cap( "publish_{$plural}" ); 
            $role->add_cap( "read_{$singular}" ); 
            $role->add_cap( "read_{$plural}" ); 
            $role->add_cap( "read_private_{$plural}" ); 
            $role->add_cap( "delete_{$singular}" ); 
            $role->add_cap( "delete_{$plural}" );
            $role->add_cap( "delete_private_{$plural}" );
            $role->add_cap( "delete_others_{$plural}" );
            $role->add_cap( "edit_published_{$plural}" );
            $role->add_cap( "edit_private_{$plural}" );
            $role->add_cap( "delete_published_{$plural}" );
		}

		/**
		 * Registering for medicine post type.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function med_register_post_type() {
			register_post_type( 'medicines', $this->args );
		}
	}
	new WP_Post_Medicines();
}
