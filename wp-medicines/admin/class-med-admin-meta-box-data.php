<?php
/**
 * Med_Admin_Meta_Box_Data class
 *
 * @package  Medicines
 * @since    5.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Med_Admin_Meta_Box_Data' ) ) {

	/**
	 * Product meta-box data for the CPB Product type.
	 *
	 * @class    Med_Admin_Meta_Box_Data
	 * @version  5.9.0
	 */
	class Med_Admin_Meta_Box_Data {

		/**
		 * Hook in.
		 */
		public function __construct() {
			// Configuration Model.

			// Creates the panel for configuring custom box product options.
			add_action( 'add_meta_boxes', array( $this, 'medicine_custom_box' ) );

			// Configuration Controller.

			// Processes and saves data.
			// add_action( 'woocommerce_admin_process_product_object', array( __CLASS__, 'cpb_process_data' ) );
			add_action( 'save_post', array( $this, 'process_post_data' ) );

		}

		public function medicine_custom_box() {
			$screens = [ 'post', 'medicines' ];
			foreach ( $screens as $screen ) {
				add_meta_box(
					'med_box_id',
					'Medicine Details',
					array( $this, 'medicine_custom_box_view' ), // Configuration View.
					$screen,
				);
			}
		}

		/**
		 * Display Medicines configuration section view
		 *
		 * @since 1.0
		 * @param  object $post Post Object.
		 * @return void
		 */
		public function medicine_custom_box_view( $post ) {
		    $med_expiry = get_post_meta( $post->ID, 'med_expiry', true );
		    $med_price = get_post_meta( $post->ID, 'price', true );
		    $mfg_company = get_post_meta( $post->ID, 'med_mfg_company', true );
		    $med_type = get_post_meta( $post->ID, 'med_type', true );

		    error_log('med_expiry : '. $med_expiry);
		    error_log('med_price : '. $med_price);
		    error_log('mfg_company : '. $mfg_company);
		    error_log('med_type : '. $med_type);

			?>
		    <div>
		        <div class="meta-row">
		            <div class="meta-th">
		                <label for="med_expiry" class="wdm-row-title">Expiry: </label>
		            </div>
		            <div class="meta-td"> 
		                <input type="text" name="med_expiry" id="med-expiry" value="<?php echo esc_attr( $med_expiry ); ?>"/>
		            </div>
		        </div>

		        <div class="meta-row">
		            <div class="meta-th">
		                <label for="price" class="wdm-row-title">Price: </label>
		            </div>
		            <div class="meta-td">
		                <input type="number" name="price" id="price" value="<?php echo esc_attr( $med_price ); ?>"/>
		            </div>
		        </div>

		        <div class="meta-row">
		            <div class="meta-th">
		                <label for="publisher" class="wdm-row-title">Manufacturing Company: </label>
		            </div>
		            <div class="meta-td">
		                <input type="text" name="med_mfg_company" id="publisher" value="<?php echo esc_attr( $mfg_company ); ?>"/>
		            </div>
		        </div>

		        <div class="meta-row">
		            <div class="meta-th">
		                <label for="year" class="wdm-row-title">Medicine Type: </label>
		            </div>
		            <div class="meta-td">
		                <select name="med_type" id="med_type">
		                	<option value="tablet"<?php selected( $med_type, 'tablet' ); ?>>Tablet</option>
		                	<option value="capsule"<?php selected( $med_type, 'capsule' ); ?>>Capsule</option>
		                	<option value="syrup"<?php selected( $med_type, 'syrup' ); ?>>Syrup</option>
		                </select>
		            </div>
		        </div>

		    <?php wp_nonce_field( 'med_custom_medicine_info_nonce', 'med_medicine_info_nonce' ); ?>
		    </div>
		    <?php
		}

		/**
		 * Saving the values using update
		 */
		public function process_post_data( $post_id ) {
		    if( ! isset( $_POST['med_medicine_info_nonce'] ) || ! wp_verify_nonce( $_POST['med_medicine_info_nonce'], 'med_custom_medicine_info_nonce' ) ){
		        return $post_id;
		    }
		    if( isset( $_POST['med_expiry'] ) ){
				update_post_meta( $post_id, 'med_expiry', sanitize_text_field( wp_unslash( $_POST['med_expiry'] ) ) );
		    }

		    if( isset( $_POST['price'] ) ){
				update_post_meta( $post_id, 'price', sanitize_text_field( wp_unslash( $_POST['price'] ) ) );
		    }

		    if( isset( $_POST['med_mfg_company'] ) ){
				update_post_meta( $post_id, 'med_mfg_company', sanitize_text_field( wp_unslash( $_POST['med_mfg_company'] ) ) );
		    }

		    if( isset( $_POST['med_type'] ) ){
				update_post_meta( $post_id, 'med_type', sanitize_text_field( wp_unslash( $_POST['med_type'] ) ) );
		    }		    
		}
	}

	return new Med_Admin_Meta_Box_Data();
}
