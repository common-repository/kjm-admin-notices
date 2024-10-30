<?php
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}


// Strings.
$strings = array();
//$strings['name'] = __('Name', 'kjm-admin-notices');

$strings['kjm-admin-notices_active_title']	=	__('KJM Admin Notices', 'kjm-admin-notices');
$strings['kjm-admin-notices_active_description']	=	__('Check to activate KJM Admin Notices.', 'kjm-admin-notices');

$strings['kjm-admin-notices_kjm_notice_active_title']	=	__('Notice Post Type', 'kjm-admin-notices');
$strings['kjm-admin-notices_kjm_notice_active_description']	=	__('Check to activate Notice Post Type.', 'kjm-admin-notices');

$strings['kjm-admin-notices_send_email_active_title']	=	__('Send Email', 'kjm-admin-notices');
$strings['kjm-admin-notices_send_email_active_description']	=	__('Check to send email to users on publish.', 'kjm-admin-notices');

$strings['kjm-admin-notices_from_email_active_title']	=	__('Email From', 'kjm-admin-notices');
$strings['kjm-admin-notices_from_email_active_description']	=	__('Leave empty for emails sent by "wordpress@yourdomain.com".', 'kjm-admin-notices');

$strings['kjm-admin-notices_from_name_active_title']	=	__('Email From Name', 'kjm-admin-notices');
$strings['kjm-admin-notices_from_name_active_description']	=	__('Leave empty for emails sent from "WordPress".', 'kjm-admin-notices');

$strings['kjm-admin-notices_comments_active_title']	=	__('Allow Comments', 'kjm-admin-notices');
$strings['kjm-admin-notices_comments_active_description']	=	__('Check to activate comments system.', 'kjm-admin-notices');

$strings['kjm-admin-notices_allow_role_title']	=	__('Allow Role or Capability to Edit', 'kjm-admin-notices');
$strings['kjm-admin-notices_allow_role_description']	=	__('Allow Role or Capability to Edit and Post Notices (default : "administrator").', 'kjm-admin-notices');


$strings['kjm-admin-notices_allow_frontend_title']	=	__('Frontend Notices', 'kjm-admin-notices');
$strings['kjm-admin-notices_allow_frontend_description']	=	__('Check to allow frontend notices display.', 'kjm-admin-notices');

$strings['kjm-admin-notices_frontend_absolute_title']	=	__('Display Over Content', 'kjm-admin-notices');
$strings['kjm-admin-notices_frontend_absolute_description']	=	__('Display frontend notices over content.', 'kjm-admin-notices');

$strings['kjm-admin-notices_frontend_layout_title']	=	__('Notice Layout Display', 'kjm-admin-notices');
$strings['kjm-admin-notices_frontend_layout_description']	=	__('Possibles values are "default" (compact) and "post" (post style). Default value if empty : "default".', 'kjm-admin-notices');

$strings['kjm-admin-notices_show_pages_title']	=	__('Show Notices on Pages', 'kjm-admin-notices');
$strings['kjm-admin-notices_show_pages_description']	=	__('List of Pages where the notices should display. Other pages will never display a notice. This param will take precedence on the "hide" one. Separate multiples pages with a comma like this : "1,23,456".', 'kjm-admin-notices');

$strings['kjm-admin-notices_hide_pages_title']	=	__('Hide Notices on Pages', 'kjm-admin-notices');
$strings['kjm-admin-notices_hide_pages_description']	=	__('List of Pages where the notices should NEVER display. Separate multiples pages with a comma like this : "1,23,456".', 'kjm-admin-notices');

// Stats
$strings['kjm-admin-notices_enable_stats_title']	=	__('Statistics', 'kjm-admin-notices');
$strings['kjm-admin-notices_enable_stats_description']	=	__('Check to enable stats features.', 'kjm-admin-notices');

$strings['kjm-admin-notices_stats_exclude_superadmin_title']	=	__('Exclude SuperAdmin', 'kjm-admin-notices');
$strings['kjm-admin-notices_stats_exclude_superadmin_description']	=	__('Check to exclude superadmin user views from statistics.', 'kjm-admin-notices');

$strings['kjm-admin-notices_stats_exclude_author_title']	=	__('Exclude Author', 'kjm-admin-notices');
$strings['kjm-admin-notices_stats_exclude_author_description']	=	__('Check to exclude notice author views from statistics.', 'kjm-admin-notices');

// Advanced
$strings['kjm-admin-notices_advanced_title']	=	__('Advanced', 'kjm-admin-notices');
$strings['kjm-admin-notices_advanced_description']	=	__('Some advanced plugin\'s features.', 'kjm-admin-notices');

$strings['kjm-admin-notices_plugins_compat_title']	=	__('Compatibility', 'kjm-admin-notices');
$strings['kjm-admin-notices_plugins_compat_description']	=	__('Check compatibility status with third-party plugins.', 'kjm-admin-notices');

$strings['kjm-admin-notices_is_plugin_kjm-search-log_active_title']	=	__('KJM Search Log', 'kjm-admin-notices');
$strings['kjm-admin-notices_is_plugin_kjm-search-log_active_description']	=	__('Plugin\'s official page <a target="_blank" href="https://www.kajoom.ca/produits/kjm-search-log-plugin-for-wordpress/">here</a>.', 'kjm-admin-notices');

$strings['kjm-admin-notices_is_plugin_kjm-avia-form-cpt_active_title']	=	__('KJM Avia Form CPT', 'kjm-admin-notices');
$strings['kjm-admin-notices_is_plugin_kjm-avia-form-cpt_active_description']	=	__('Plugin\'s official page <a target="_blank" href="https://www.kajoom.ca/produits/kjm-avia-form-cpt-plugin-for-wordpress/">here</a>.', 'kjm-admin-notices');

$strings['kjm-admin-notices_is_plugin_kajoom-framework_active_title']	=	__('Kajoom Framework', 'kjm-admin-notices');
$strings['kjm-admin-notices_is_plugin_kajoom-framework_active_description']	=	__('Plugin\'s official page <a target="_blank" href="https://www.kajoom.ca/produits/kajoom-framework-plugin-for-wordpress/">here</a>.', 'kjm-admin-notices');

$strings['kjm-admin-notices_is_plugin_archived-post-status_active_title']	=	__('Archived Post Status', 'kjm-admin-notices');
$strings['kjm-admin-notices_is_plugin_archived-post-status_active_description']	=	__('Plugin\'s official page <a target="_blank" href="https://wordpress.org/plugins/archived-post-status/">here</a>.', 'kjm-admin-notices');

$strings['kjm-admin-notices_updater_title']	=	__('Updater', 'kjm-admin-notices');
$strings['kjm-admin-notices_updater_description']	=	__('Use custom updater.', 'kjm-admin-notices');

$strings['kjm-admin-notices_use_kjm_updater_active_title']	=	__('Use our External Updater', 'kjm-admin-notices');
$strings['kjm-admin-notices_use_kjm_updater_active_description']	=	__('Check to use the External Updater. <br>In order to check for new updates, occasional requests will be sent to our servers. Requests are secured with HTTPS and we do not track personal data. See our <a href="https://www.kajoom.ca/a-propos/conditions-dutilisation" target="_new">Terms of use</a> (in french). Check out our <a href="https://www.kajoom.ca/a-propos/politique-de-confidentialite" target="_new">Privacy Policy</a> (in french).', 'kjm-admin-notices');

// Other strings.
__('wordpress_version', 'kjm-admin-notices');
__('active_plugins', 'kjm-admin-notices');
__('theme', 'kjm-admin-notices');
__('child_theme', 'kjm-admin-notices');

__('Sent', 'kjm-admin-notices');
