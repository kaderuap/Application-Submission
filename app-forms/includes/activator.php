<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Application Form
 * @subpackage Application Form/includes
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES;

class activator
{

	/**
	 * Active Plugin
	 *
	 * @since    1.0.0
	 */

	public function __construct()
	{

		$this->Create_Table();
	}

	/**
	 * Create Table
	 *
	 * @since    1.0.0
	 */

	private function Create_Table()
	{

		global $wpdb;

		if (!current_user_can('activate_plugins')) {
			return;
		}

		if (!defined('DB_CHARSET') || !($db_charset = DB_CHARSET)) {
			$db_charset = 'utf8mb4';
		}

		$db_charset = "CHARACTER SET " . $db_charset;

		if (defined('DB_COLLATE') && $db_collate = DB_COLLATE) {
			$db_collate = "COLLATE " . $db_collate;
		}

		// Create App Form Table
		$apf_form_tbl = $wpdb->prefix . "applicant_submissions";
		if ($wpdb->get_var("SHOW TABLES LIKE '$apf_form_tbl'") != $apf_form_tbl) {

			$sql = "CREATE TABLE IF NOT EXISTS " . $apf_form_tbl . " (
					`apid` bigint(20) NOT NULL AUTO_INCREMENT,
					`f_name` varchar(255) NOT NULL,
					`l_name` varchar(255) NOT NULL,
					`ap_address` longtext NOT NULL,
					`ap_email` varchar(100) NOT NULL,
					`ap_mobile` varchar(100) NOT NULL,
					`ap_postname` varchar(100) NOT NULL,
					`ap_cv` varchar(100) NOT NULL,
					`ap_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					 PRIMARY KEY  (`apid`)
				  )  {$db_charset} {$db_collate};";
			$results = $wpdb->query($sql);
		}

		// Create Directory For Application File
		$uploads = wp_upload_dir();

		$target_dir = $uploads['basedir'] . '/app_file/';
		if (!is_dir($target_dir)) {
			mkdir($target_dir);
		}
	}
}
