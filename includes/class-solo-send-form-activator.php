<?php

/**
 * Fired during plugin activation
 *
 * @link       https://dailysolosends.com/
 * @since      1.0.0
 *
 * @package    Solo_Send_Form
 * @subpackage Solo_Send_Form/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Solo_Send_Form
 * @subpackage Solo_Send_Form/includes
 * @author     Talha Muneer <talha.tech01@gmail.com>
 */


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


class Solo_Send_Form_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		global $wpdb;
		$paypal_setting_table =   $wpdb->prefix . 'paypal_settings';
		maybe_create_table($paypal_setting_table, "CREATE TABLE $paypal_setting_table (
			ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			currency_symbol VARCHAR(30) NOT NULL,
			currency VARCHAR(30) NOT NULL,
			paypal_account VARCHAR(50) NOT NULL,
			payza_email VARCHAR(50) NULL,
			contact_email VARCHAR(200) NOT NULL,
			date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)");

		$plans_table =   $wpdb->prefix . 'dss_plans';
		maybe_create_table($plans_table, "CREATE TABLE $plans_table (
			ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			form_id INT(6) NOT NULL DEFAULT 1,
			title VARCHAR(200) NOT NULL,
			description TEXT NULL,
			amount INT(6) NOT NULL,
			date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)");

		$entries =   $wpdb->prefix . 'dss_entries';
		maybe_create_table($entries, "CREATE TABLE $entries (
			ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			form_id INT(6) NOT NULL DEFAULT 1,
			data TEXT NOT NULL,
			date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)");
	}
}
