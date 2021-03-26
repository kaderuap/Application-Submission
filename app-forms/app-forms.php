<?php

/**
 * Plugin Name:         Application Form
 * Description:         Application Collection Form using shortcode for WordPress
 * Plugin URI:          https://
 * Author:              Md. Abdul Kader Roni
 * Author URI:          https://
 * Version:             1.0.0
 * License:             GPLv2 or later
 * License URI:         https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:         app-forms
 * Domain Path:         /languages
 */

// Initialized Namespace.
namespace WEDEVS\APF;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';

if (!class_exists('AppForm')) :

    /**
     * Main Application Form Class
     *
     * @since 1.0.0
     */

    final class AppForm
    {
        public function __construct()
        {
            $this->define_constants();
            $this->load_dependencies();

            /**
             * Active Deactive Hook
             */
            register_activation_hook(__FILE__, [$this, 'activate_plugin']);
        }

        /**
         * Define All Constants
         */
        public function define_constants()
        {
            if (!defined('APF_NAME')) {
                define('APF_NAME', plugin_basename(__FILE__)); // Plugin Name
            }
            if (!defined('APF_HANDLE')) {
                define('APF_HANDLE', plugin_basename(dirname(__FILE__))); // Plugin Handle 
            }
            if (!defined('APF_PATH')) {
                define('APF_PATH', plugin_dir_path(__FILE__)); // Plugin Path
            }
            if (!defined('APF_URL')) {
                define('APF_URL', plugins_url('', __FILE__) . '/'); // Plugin URL
            }
            if (!defined('APF_VERSION')) {
                define('APF_VERSION', '1.0.0'); // Plugin Version
            }
        }

        /**
         * Divided Admin And Public Section
         */
        public function load_dependencies()
        {
            /**
             * Admin Section
             */
            if (is_admin()) {
                new INCLUDES\Admin\Admin();
            } else {
                new INCLUDES\Client\Client();
            }
        }

        /**
         * Plugin Active Function
         */
        public function activate_plugin()
        {
            new INCLUDES\activator();
        }
    }

endif; // End if class_exists check.

new AppForm;
