<?php

/**
 * Dashboard
 *
 * @package    Application Form
 * @subpackage Application Form/admin/tempaltes
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Admin\Templates;

//aped($_REQUEST);

class DashBoard
{

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->dashManagement();
    }

    /**
     * Dahsboard Function
     */
    public function dashManagement()
    {

        global $wpdb;
        $apf_form_tbl = $wpdb->prefix . 'applicant_submissions';

        $uploads = wp_upload_dir();

        $sql =  "SELECT COUNT(apid) AS totalapp FROM " . $apf_form_tbl;
        $alltotalapp = $wpdb->get_results($sql, 'ARRAY_A');

        $sql =  "SELECT * FROM " . $apf_form_tbl . " ORDER BY ap_time desc LIMIT 5";
        $allapp = $wpdb->get_results($sql, 'ARRAY_A');


?>
        
        <div class="wrap apfwap">
            
            <div class="apf-top-logo"><img src="<?php echo APF_URL; ?>/includes/Admin/Assets/images/wedevs.png" alt="weDevs Logo"></div>

            <?php if (!empty($success_msg)) : ?>
                <div class="apf-success-message">
                    <p><?php echo $success_msg; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="apf-setting-box">
                <div class="apf-sboxleft">
                    <?php include 'tabbar.php';?>
                    
                    <div class="apf-setting-inner-box">
                        <h2>Application Dashboard</h2>
                        <hr>
                        <div class="ov-box">Total Applicant Submissions : <?php if (!empty($alltotalapp)) echo $alltotalapp[0]['totalapp']; else echo "0"; ?></div>
                        
                        <?php if (!empty($allapp)) : ?>
                            <ul class="apf-box">
                                <?php for ($i = 0; $i < count($allapp); $i++) : ?>
                                    <li <?php if ($i == 0 || $i == 3 || $i == 4) : ?> class="bgd-blur" <?php endif; ?> <?php if ($i == 4) : ?> style="width: 100%;margin-right: 0;" <?php endif; ?>>
                                        <?php if (!empty($allapp[$i]['f_name']) || !empty($allapp[$i]['l_name'])) : ?><span>Name : <?php echo $allapp[$i]['f_name'] . " " . $allapp[$i]['l_name']; ?></span><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_address'])) : ?><p>Address : <?php echo $allapp[$i]['ap_address']; ?></p><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_email'])) : ?><p>Email : <?php echo $allapp[$i]['ap_email']; ?></p><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_mobile'])) : ?><p>Mobile No : <?php echo $allapp[$i]['ap_mobile']; ?></p><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_postname'])) : ?><p>Post Name : <?php echo $allapp[$i]['ap_postname']; ?></p><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_cv'])) : ?><p style="display: flex;">CV : <a style="margin-left: 10px;" href="<?php echo $uploads['baseurl'] . '/app_file/' . $allapp[$i]['ap_cv'] ?>" target="_blank"><img src="<?php echo APF_URL ?>includes/Admin/Assets/images/file-img.png"></a></p><?php endif; ?>
                                        <?php if (!empty($allapp[$i]['ap_time'])) : ?><p>Submission Date : <?php echo $allapp[$i]['ap_time']; ?></p><?php endif; ?>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        <?php endif; ?>
                    
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

new DashBoard();
