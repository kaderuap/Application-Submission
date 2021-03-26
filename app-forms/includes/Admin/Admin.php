<?php

/**
 * The admin Main functionality of the plugin.
 * 
 *
 * @package    Application Form
 * @subpackage Application Form/admin
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Admin;

class Admin
{

    public function __construct()
    {
        new Menu();
        add_action('admin_enqueue_scripts', [$this, 'admin_hooks']);
    }

    /**
     * Enqueue Css And JS
     */

    public function admin_hooks()
    {
        wp_enqueue_script('apf-admin-script', APF_URL . 'includes/Admin/Assets/js/admin.js', array('jquery'), '1.0.0', true);
        wp_localize_script('apf-admin-script', 'apfAjax', array('ajaxurl' => admin_url('admin-ajax.php'), 'apfurl' => APF_URL));
        wp_enqueue_style('apf-admin-style', APF_URL . 'includes/Admin/Assets/css/admin.css');
    }
}
