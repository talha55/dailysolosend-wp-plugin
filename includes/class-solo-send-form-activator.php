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
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)' );

	}

}
