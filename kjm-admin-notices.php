<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.kajoom.ca/
 * @since             1.0.0
 * @package           Kjm_Admin_Notices
 *
 * @wordpress-plugin
 * Plugin Name:       KJM Admin Notices
 * Plugin URI:        https://www.kajoom.ca/produits/kjm-admin-notices-plugin-for-wordpress/
 * Description:       Notify your WordPress users effortlessly! Create, manage and display nice custom dismissible notices to admin users.
 * Version:           2.0.1
 * Author:            KAJOOM
 * Author URI:        https://www.kajoom.ca/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kjm-admin-notices
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'KJM_ADMIN_NOTICES_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'KJM_ADMIN_NOTICES_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'KJM_ADMIN_NOTICES_FILE', plugin_basename(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kjm-admin-notices-activator.php
 */
function activate_kjm_admin_notices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kjm-admin-notices-activator.php';
	Kjm_Admin_Notices_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kjm-admin-notices-deactivator.php
 */
function deactivate_kjm_admin_notices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kjm-admin-notices-deactivator.php';
	Kjm_Admin_Notices_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kjm_admin_notices' );
register_deactivation_hook( __FILE__, 'deactivate_kjm_admin_notices' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kjm-admin-notices.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kjm_admin_notices() {

	$plugin = new Kjm_Admin_Notices();
	$plugin->run();

}
run_kjm_admin_notices();
