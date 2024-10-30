<?php
/**
 * KJM Admin Notices Local Settings File.
 *
 * The file containing user defined functions and variables intended to 
 * provide a place to dump settings as it was a theme file. Rename this 
 * file from local-settings.example.php to local-settings.php to 
 * activate it on the system. We recommend to move this file to your 
 * theme to allow your customizations to stay between updates. To do so, 
 * move the file to a folder "plugin/kjm-admin-notices" into your theme folder. 
 * 
 *
 * @link              http://www.kajoom.ca/
 * @since             0.0.1
 * @package           Kjm_Admin_Notices
 * 
 * Author:            Marc-Antoine Minville
 * Author URI:        https://www.kajoom.ca/
 * License:           All Rights Reserved.
 * 
 * Example file: 		./includes/models/local-settings.example.php
 * 
*/

if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}


# ------------------------------------------------------ #
# Constants.
# ------------------------------------------------------ #

if (!defined('KJM_ADMIN_NOTICES_DEBUG_IP')) {
	define('KJM_ADMIN_NOTICES_DEBUG_IP', '');
}

if (!defined('KJM_ADMIN_NOTICES_APP')) {
	define('KJM_ADMIN_NOTICES_APP', 'app');
}

if (!defined('KJM_ADMIN_NOTICES_DEBUG')) {
	define('KJM_ADMIN_NOTICES_DEBUG', false);
}
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', KJM_ADMIN_NOTICES_DEBUG);
}


# ------------------------------------------------------ #
# Functions.
# ------------------------------------------------------ #

add_filter('kjm_debug_ip_whitelist', 'theme_kjm_debug_ip_whitelist', 10, 1);
function theme_kjm_debug_ip_whitelist($ip_addresses) {
	
	$add_address = array(
		// Add your IPs in the following format : 
		#'000.000.000.000', // Name - Place (type)
	);

	if (!empty($add_address)) {
		$ip_addresses = array_merge($ip_addresses, $add_address);
	}
	
	return $ip_addresses;
}

# ------------------------------------------------------ #
# Custom stuff.
# ------------------------------------------------------ #

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}
