<?php

/**
 * Create Admin Menu 
 *
 * @package    Application Form
 * @subpackage Application Form/admin
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Admin;

class Menu
{

	public $user_level = 'manage_options';

	public function __construct()
	{
		add_action('admin_menu', [$this, 'register_menu_page']);
	}

	/**
	 * Register Admin Menu
	 */

	function register_menu_page()
	{

		add_menu_page(__('App Form'), __('App Form'), $this->user_level, APF_HANDLE, [$this, 'show_menu'], 'dashicons-forms', 80);
		add_submenu_page(APF_HANDLE, __('Overview'), __('Overview'), $this->user_level, APF_HANDLE, [$this, 'show_menu']);
		$All_S_Form = add_submenu_page(APF_HANDLE, __('All Submissions'), __('All Submissions'), $this->user_level, 'all-submissions', [$this, 'show_menu']);
		add_submenu_page(APF_HANDLE, __('Setting'), __('Setting'), $this->user_level, 'apf-setting', [$this, 'show_menu']);

		add_action("load-$All_S_Form", [$this, 'Screen_app_Form']);
	}

	/**
	 * Call Menu Function
	 */

	function show_menu()
	{

		switch ($_GET['page']) {

			case "all-submissions":
				$this->ShowFormObj->ShowForm('All Submissions');
				break;

			case "apf-setting":
				include_once(dirname(__FILE__) . '/Templates/setting.php');
				break;

			default:
				include_once(dirname(__FILE__) . '/Templates/dashboard.php');
				break;
		}
	}

	public function Screen_app_Form()
	{
		
		$this->ShowFormObj = new Templates\ShowApf();
	}
}
