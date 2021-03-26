<?php

/**
 * The Public Main functionality of the plugin.
 * 
 *
 * @package    Application Form
 * @subpackage Application Form/public
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Client;

class Client
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'client_hooks']);
    }

    /**
     * Enqueue Css And JS
     */

    public function client_hooks()
    {
        wp_enqueue_script('apf-client-script', APF_URL . 'includes/Client/Assets/js/client.js', array('jquery'), '1.0.0', true);
        wp_localize_script('apf-client-script', 'apfsetting', array('ajaxurl' => admin_url('admin-ajax.php'), 'apfurl' => APF_URL));
        wp_enqueue_style('apf-client-style', APF_URL . 'includes/Client/Assets/css/client.css');
    }
}
