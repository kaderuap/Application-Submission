<?php

/**
 * Show All Submissions Using WP List Table View
 * 
 *
 * @package    Application Form
 * @subpackage Application Form/admin/tempaltes
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Admin\Templates;

if (!class_exists('WP_List_Table')) {
	require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class ShowApf extends \WP_List_Table
{

	/** Class constructor */
	public function __construct()
	{

		parent::__construct([
			'singular' => __(''),
			'plural'   => __(''),
			'ajax'     => false
		]);
	}

	public function get_db_col_name($presentingName)
	{
		return $presentingName;
	}

	/** Get Data From Table */
	public static function get_form_info($search = '', $per_page = 5, $page_number = 1)
	{
		global $wpdb;
		$apf_form_tbl = $wpdb->prefix . 'applicant_submissions';

		if (!empty($search)) {
			$sql = "SELECT * FROM " . $apf_form_tbl . " WHERE f_name LIKE '%" . $search . "%' OR l_name LIKE '%" . $search . "%' OR ap_address LIKE '%" . $search . "%' OR ap_email LIKE '%" . $search . "%' OR ap_mobile LIKE '%" . $search . "%' OR ap_postname LIKE '%" . $search . "%' ";
		} else {
			$sql =  "SELECT * FROM " . $apf_form_tbl;
		}

		if (!empty($_REQUEST['orderby'])) {
			$sql .= " ORDER BY " .  $_REQUEST['orderby'] . " " . $_REQUEST['order'];
		} else {
			$sql .= " ORDER BY apid DESC";
		}

		$sql .= " LIMIT $per_page";
		$sql .= " OFFSET " . ($page_number - 1) * $per_page;

		$result = $wpdb->get_results($sql, 'ARRAY_A');

		return stripslashes_deep($result);
	}

	/** Get Number Of Data From Table */
	public static function record_count($search = '')
	{

		global $wpdb;
		$apf_form_tbl = $wpdb->prefix . 'applicant_submissions';

		if (!empty($search)) {
			$sql = "SELECT * FROM " . $apf_form_tbl . " WHERE f_name LIKE '%" . $search . "%' OR l_name LIKE '%" . $search . "%' OR ap_address LIKE '%" . $search . "%' OR ap_email LIKE '%" . $search . "%' OR ap_mobile LIKE '%" . $search . "%' OR ap_postname LIKE '%" . $search . "%' ";
		} else {
			$sql =  "SELECT * FROM " . $apf_form_tbl;
		}

		$wpdb->get_results($sql);

		return $wpdb->num_rows;
	}

	/** Text displayed when no data is available */
	public function no_items()
	{
		_e('<span class="hlight">Whoops, No Application found.</span>');
	}


	/** Show Column Value */
	public function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'address':
				return $item['ap_address'];
			case 'email':
				return $item['ap_email'];
			case 'mobileNo':
				return $item['ap_mobile'];
			case 'post':
				return $item['ap_postname'];
			case 'cv':
				$uploads = wp_upload_dir();
				return '<a href="' . $uploads['baseurl'] . '/app_file/' . $item['ap_cv'] . '" target="_blank"><img src="' . APF_URL . 'includes/Admin/Assets/images/file-img.png"></a>';
			case 'stime':
				return $item['ap_time'];
		}
	}

	/** Checkbox For Action */
	function column_cb($item)
	{
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />',
			$item['apid']
		);
	}

	/** Column Customization Depand on Column Field Name */
	function column_Name($item)
	{
		$delete_nonce = wp_create_nonce('sp_delete_trailer');
		$title = '<strong>' . $item['f_name'] . ' ' . $item['l_name'] . '</strong>';
		$actions = [
			'delete' => sprintf("<a href='?page=%s&action=%s&id=%s&_wpnonce=%s' onclick='return confirm(\"you want to delete?\");'>Delete</a>", esc_attr($_REQUEST['page']), "delete", absint($item['apid']), $delete_nonce)
		];
		return $title . $this->row_actions($actions, true);
	}

	/** Name Of The Columns Which want to show */
	function get_columns()
	{
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'name' => __('Name'),
			'address' => __('Address'),
			'email' => __('Email'),
			'mobileNo' => __('Mobile No'),
			'post' => __('Post Name'),
			'cv' => __('CV'),
			'stime' => __('Submission Date'),
		];

		return $columns;
	}

	/** For Shortable Column */
	public function get_sortable_columns()
	{
		$sortable_columns = array(
			'stime' => array('ap_time', false),
		);
		return $sortable_columns;
	}

	/** Bulk Action Add */
	public function get_bulk_actions()
	{
		$actions = [
			'bulk-delete' => 'Delete'
		];
		return $actions;
	}


	/** Handles data query and filter, sorting, and pagination */
	public function prepare_items($search = '')
	{
		$this->_column_headers = $this->get_column_info();

		$per_page  = !empty(get_option('apf_per_page')) ? get_option('apf_per_page') : '10';
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count($search);

		$this->set_pagination_args([
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page, //WE have to determine how many items to show on a page
			'search'    => $search //WE have to determine how many items to show on a page
		]);
		$this->items = self::get_form_info($search, $per_page, $current_page);
	}

	/** Handles For Show All */
	public function ShowForm($arg)
	{
		$msg = '';

		global $wpdb;
		$apf_form_tbl = $wpdb->prefix . 'applicant_submissions';

		$uploads = wp_upload_dir();
		$target_dir = $uploads['basedir'] . '/app_file/';

		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {

			$sql =  "SELECT ap_cv FROM " . $apf_form_tbl . " WHERE apid = '" . $_REQUEST['id'] . "'";
			$getcv = $wpdb->get_results($sql, 'ARRAY_A');

			if (!empty($getcv[0]['ap_cv'])) {
				if (file_exists($target_dir . $getcv[0]['ap_cv'])) {
					unlink($target_dir . $getcv[0]['ap_cv']);
				}
			}

			$sql = "DELETE FROM " . $apf_form_tbl . " WHERE apid = '" . $_REQUEST['id'] . "'";
			$delete_form = $wpdb->query($sql);

			$msg = 'Sucessfully Delete';
		} elseif (isset($_REQUEST['bulk-delete']) && !empty($_REQUEST['bulk-delete'])) {

			for ($d = 0; $d < count($_REQUEST['bulk-delete']); $d++) {

				$sql =  "SELECT ap_cv FROM " . $apf_form_tbl . " WHERE apid = '" . $_REQUEST['bulk-delete'][$d] . "'";
				$getcv = $wpdb->get_results($sql, 'ARRAY_A');

				if (!empty($getcv[0]['ap_cv'])) {
					if (file_exists($target_dir . $getcv[0]['ap_cv'])) {
						unlink($target_dir . $getcv[0]['ap_cv']);
					}
				}

				$sql = "DELETE FROM " . $apf_form_tbl . " WHERE apid = '" . $_REQUEST['bulk-delete'][$d] . "'";
				$delete_form = $wpdb->query($sql);
			}

			$msg = 'Sucessfully Delete';
		}

?>

		<div class="wrap apfwap">
		    
		    <div class="apf-top-logo"><img src="<?php echo APF_URL; ?>/includes/Admin/Assets/images/wedevs.png" alt="weDevs Logo"></div>
		    
		    <?php if (!empty($msg)) : ?>
                <div class="apf-success-message">
                    <p><?php echo $msg; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="apf-setting-box">
                <div class="apf-sboxleft">
                    <?php include 'tabbar.php';?>
                    <div class="apf-setting-inner-box">
                        <form id="posts-filter" method="get">
    						<input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
    						<?php
    							if (isset($_REQUEST['s'])) {
    								$this->prepare_items($_REQUEST['s']);
    							} else {
    								$this->prepare_items();
    							}
    							$this->search_box('Search', 'search');
    							$this->display();
    						?>
    					</form>
					</div>
                </div>
                <div class="apf-sboxright">
                    <span class="apf-cell-title">weDevs recommendations for you</span>
                    <?php include 'sidebar.php';?>
                </div>
            </div>
            
		</div>

<?php
	}
}
