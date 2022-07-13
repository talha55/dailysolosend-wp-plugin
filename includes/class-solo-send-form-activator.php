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
class Solo_Send_Form_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;    
maybe_create_table( $wpdb->prefix . 'paypal_settings', 'CREATE TABLE MyGuests (
	ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	currency_symbol VARCHAR(30) NOT NULL,
	currency VARCHAR(30) NOT NULL,
	paypal_account VARCHAR(50) NOT NULL,
	payza_email VARCHAR(50) NULL,
	contact_email VARCHAR(200) NOT NULL,
	date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)' );

	}

}
