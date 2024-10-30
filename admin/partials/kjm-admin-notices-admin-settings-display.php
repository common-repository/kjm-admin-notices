<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.kajoom.ca/
 * @since      1.0.0
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/admin/partials
 */
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}

if (!current_user_can('manage_options')) {
		wp_die( __('You do not have sufficient permissions to access this page.', 'kjm-admin-notices') );
}

global $wpdb;

$Kjm_Admin_Notices_Admin = Kjm_Admin_Notices_Admin::get_instance();

if (!empty($Kjm_Admin_Notices_Admin->message)) echo $Kjm_Admin_Notices_Admin->message;

$settings_section = $Kjm_Admin_Notices_Admin->settings_fields_display();

$post_type_url = admin_url('edit.php?post_type=kjm_notice');

$cpt_active = $Kjm_Admin_Notices_Admin->get_option($Kjm_Admin_Notices_Admin->plugin_name.'_kjm_notice_active');
?>
<div class="wrap kjm-admin-notices-wrap">
	
		<h2>
			<?php _e('KJM Admin Notices', 'kjm-admin-notices'); ?> 
		</h2>
		
		<div class="tablenav">
			
				<h3>
					<?php _e('KJM Admin Notices Settings', 'kjm-admin-notices'); ?> 
					<img class="kjm_admin_notice_logo" width="64" height="64" src="<?php echo KJM_ADMIN_NOTICES_PLUGIN_URL; ?>admin/images/icon-128x128.png" atl="KJM Admin Notices" />
				</h3>
				
				<div class="tablenav-pages" style="float: none;">
					<span><?php if (!empty($cpt_active)) echo '<a href="'.$post_type_url.'">'.__('Manage KJM Admin Notices', 'kjm-admin-notices').'</a>'; ?></span>
					<span style="margin-left:1em;"><?php echo __('You are using') .' <b><a class="inline" href="https://wordpress.org/plugins/kjm-admin-notices/" target="_blank">' . __('KJM Admin Notices') . '</a></b> ' . __('plugin version') .' <b>'. $Kjm_Admin_Notices_Admin->version; ?></b>.</span>
					<?php //echo $log_export_link; ?>
				</div>
				
				<div class="tablenav-pages">
					 
				</div>
		</div>
		
		<div class="container">
			<p><img style="float: none; width: 100%; height: auto; max-width: 840px;" width="940" height="305" src="<?php echo KJM_ADMIN_NOTICES_PLUGIN_URL; ?>admin/images/banner-940x305.png" atl="KJM Admin Notices Banner" /></p>
		</div>

		<form name="kjm_admin_notices_form" method="post">
				<table class="form-table">
					
						<?php echo $settings_section; ?>
					
				</table>
				<p class="submit">
						<input type="submit" name="kjm_admin_notices_settings_saved" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'kjm-admin-notices'); ?>" />
				</p>
		</form>
		
		<?php if (defined('WP_DEBUG') && true === WP_DEBUG && current_user_can($Kjm_Admin_Notices_Admin->capability)) :	?>
		<div class="tablenav">
			<h3 id="kjm-debug">Debug</h3><?php $Kjm_Admin_Notices_Admin->get_debug(); ?>
		</div>
		<?php endif; ?>
		
</div> <!-- end .wrap -->
<?php
