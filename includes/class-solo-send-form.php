<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://dailysolosends.com/
 * @since      1.0.0
 *
 * @package    Solo_Send_Form
 * @subpackage Solo_Send_Form/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Solo_Send_Form
 * @subpackage Solo_Send_Form/includes
 * @author     Talha Muneer <talha.tech01@gmail.com>
 */
class Solo_Send_Form
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Solo_Send_Form_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('SOLO_SEND_FORM_VERSION')) {
			$this->version = SOLO_SEND_FORM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'solo-send-form';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		add_action('admin_menu', function () {
			add_menu_page('Daily Solo Sends Form', 'Daily Solo Sends Form', 'manage_options', 'dss-forms', '', 'dashicons-email-alt2');
			add_submenu_page('dss-forms', 'PayPal Settings', 'PayPal Settings', 'manage_options', 'paypal-settings', array($this, 'render_paypal_settings'), NULL);
			add_submenu_page('dss-forms', 'Plans', 'Plans', 'manage_options', 'dss-plans', array($this, 'render_plans'), NULL);
			add_submenu_page('dss-forms', 'Entries', 'Entries', 'manage_options', 'dss-entries', array($this, 'render_view_entries'), NULL);
			remove_submenu_page('dss-forms', 'dss-forms');
		}, 90);

		add_action('wp_ajax_paypal_settings', array($this, 'ajax_paypal_setting'));
		add_action('wp_ajax_nopriv_paypal_settings', array($this, 'ajax_paypal_setting'));
	}

	public function render_paypal_settings()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/templates/paypal-settings.php';
	}

	public function render_plans()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/templates/plans.php';
	}

	public function render_view_entries()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/templates/view-entries.php';
	}

	public function ajax_paypal_setting()
	{
		$response = [];
		global $wpdb;
		$table_name = $wpdb->prefix . 'paypal_settings';
		$sql = $wpdb->prepare("INSERT INTO $table_name 
		(ID, currency_symbol, currency, paypal_account, payza_email, contact_email)
		VALUES
		(1, '". $_POST['currency_symbol'] ."', '". $_POST['currency'] ."', '". $_POST['paypal_email'] ."', '". $_POST['payza_email'] ."', '". $_POST['contact_email'] ."')
		ON DUPLICATE KEY UPDATE
		currency_symbol = '". $_POST['currency_symbol'] . "',
		currency = '". $_POST['currency'] ."',
		paypal_account = '". $_POST['paypal_email'] ."',
		payza_email = '". $_POST['payza_email'] ."',
		contact_email = '". $_POST['contact_email'] ."'
		");
		$res = $wpdb->query($sql);
		
		if($res){
			$response['message'] = 'Record successfully updated!';
			$response['status_code'] = 200;
		}else{
			$response['message'] = 'Something went wrong!';
			$response['status_code'] = 400;
		}
		echo json_encode($response);
		wp_die();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Solo_Send_Form_Loader. Orchestrates the hooks of the plugin.
	 * - Solo_Send_Form_i18n. Defines internationalization functionality.
	 * - Solo_Send_Form_Admin. Defines all hooks for the admin area.
	 * - Solo_Send_Form_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-solo-send-form-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-solo-send-form-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-solo-send-form-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-solo-send-form-public.php';

		$this->loader = new Solo_Send_Form_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Solo_Send_Form_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Solo_Send_Form_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Solo_Send_Form_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Solo_Send_Form_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Solo_Send_Form_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
