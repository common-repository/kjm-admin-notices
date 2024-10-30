<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.kajoom.ca/
 * @since      1.0.0
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/includes
 * @author     Marc-Antoine Minville <support@kajoom.ca>
 */
class Kjm_Admin_Notices_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		// PHP version check.
		if ( version_compare( phpversion(), '5.0', '<' ) ) {
			trigger_error(__("Sorry,  Plugin requires PHP 5.0 or higher. Please deactivate Plugin.", 'kjm-admin-notices'), E_USER_ERROR);
		}
		
		$plugin_admin = Kjm_Admin_Notices_Admin::get_instance();
		
		/* Create default categories */
		$kjm_notices_accept_values = array("success", "info", "warning", "error");
		foreach ($kjm_notices_accept_values as $term) {
			
			$term_exists = term_exists($term, 'kjm_notice_cat');
			if (empty($term_exists)) wp_insert_term($term, 'kjm_notice_cat');
			
			$term_exists = term_exists($term, 'kjm_notice_cat');
			if (!empty($term_exists)) {
				#$default_color = $plugin_admin->messages_statuses['messages_statuses'];
				#$term_obj = get_term_by('name', $term, 'kjm_notice_cat');
				#$color = get_term_meta( $term_obj->term_id, $meta_name, true );
				#$color = ( !empty( $color ) ) ? "#{$color}" : '#ffffff';
			}
			
		}
		
		// Database Schema.
		self::update_db_schema();
		
	}
	
	
	/**
	 * Update Database Schema.
	 *
	 * Create or Update Database schema.
	 *
	 * @since    1.0.3	
	 * 
	 */
	public static function update_db_schema() {
		
		global $wpdb;
			
		if( get_option('kjm-admin-notices-version') != KJM_ADMIN_NOTICES_VERSION ) {
			
			// Required for dbDelta operations.
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			
			// Create or Update kjm_notices_views table
			$table_name = $wpdb->prefix . "kjm_notices_views";
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				
				$sql = "CREATE TABLE $table_name (
					id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					post_id int(11) NOT NULL,
					user_id int(11) NOT NULL,
					type varchar(60) NOT NULL,
					time int(10) UNSIGNED NOT NULL,
					hash varchar(255) NOT NULL,
					reference text NOT NULL,
					PRIMARY KEY  (id)
				) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				
				dbDelta( $sql );
			}
		
			update_option( 'kjm-admin-notices-version', KJM_ADMIN_NOTICES_VERSION );
		}
	}
}

// Display error message to users.
if ($_GET['action'] == 'error_scrape') {                                                                                                   
		die(__("Sorry,  Plugin requires PHP 5.0 or higher. Please deactivate Plugin.", 'kjm-admin-notices'));                                 
}





