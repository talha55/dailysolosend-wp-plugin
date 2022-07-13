<?php

/**
 * 
 *
 * @link              https://dailysolosends.com/
 * @since             1.0.0
 * @package           Solo_Send_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Solo Send Form
 * Plugin URI:        https://dailysolosends.com/
 * Description:       Primed and ready to deliver an enormous amounts of real visitor to your advertised programs by direct email marketing.
 * Version:           1.0.0
 * Author:            Talha Muneer
 * Author URI:        https://dailysolosends.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       solo-send-form
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'SOLO_SEND_FORM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-solo-send-form-activator.php
 */
function activate_solo_send_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-solo-send-form-activator.php';
	Solo_Send_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-solo-send-form-deactivator.php
 */
function deactivate_solo_send_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-solo-send-form-deactivator.php';
	Solo_Send_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_solo_send_form' );
register_deactivation_hook( __FILE__, 'deactivate_solo_send_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-solo-send-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_solo_send_form() {

	$plugin = new Solo_Send_Form();
	$plugin->run();

}
run_solo_send_form();
