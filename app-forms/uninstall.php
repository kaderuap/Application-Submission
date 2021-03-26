<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://
 * @since      1.0.0
 *
 * @package    Application Form
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

new Plugin_Uninstall;

class Plugin_Uninstall
{

	/**
	 * Unistall Plugin
	 *
	 * @since    1.0.0
	 */

	public function __construct()
	{

		global $wpdb;

		$apf_form_tbl = $wpdb->prefix . "applicant_submissions";
		$wpdb->query("DROP TABLE IF EXISTS $apf_form_tbl");

		$uploads = wp_upload_dir();

		$target_dir = $uploads['basedir'] . '/app_file/';
		if (is_dir($target_dir)) {
			$all_file = scandir($target_dir);
			for ($i = 2; $i < count($all_file); $i++) {
				unlink($target_dir . $all_file[$i]);
			}
			rmdir($target_dir);
		}

		delete_option('apf_per_page');
		delete_option('apf_message');
		delete_option('apf_email_template');
	}
}
