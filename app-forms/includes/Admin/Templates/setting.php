<?php

/**
 * Setting
 *
 * @package    Application Form
 * @subpackage Application Form/admin/tempaltes
 * @author     Roni
 */

// Set Namespace.
namespace WEDEVS\APF\INCLUDES\Admin\Templates;

//aped($_REQUEST);

class Setting
{

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->settingManagement();
    }

    /**
     * Setting Function
     */
    public function settingManagement()
    {

        $success_msg = '';

        if (isset($_REQUEST['update_setting']) && !empty($_REQUEST['update_setting'])) {

            // Set App Per Page.

            if (get_option('apf_per_page') !== false) {

                // The option already exists, so update it.
                update_option('apf_per_page', $_REQUEST['apf_per_page']);
            } else {

                // The option hasn't been created yet, so add it with $autoload set to 'no'.
                $deprecated = null;
                $autoload = 'no';
                add_option('apf_per_page', $_REQUEST['apf_per_page'], $deprecated, $autoload);
            }

            // Set App Thank You Message.

            if (get_option('apf_message') !== false) {

                // The option already exists, so update it.
                update_option('apf_message', $_REQUEST['apf_message']);
            } else {

                // The option hasn't been created yet, so add it with $autoload set to 'no'.
                $deprecated = null;
                $autoload = 'no';
                add_option('apf_message', $_REQUEST['apf_message'], $deprecated, $autoload);
            }

            // Set Email Template.

            if (get_option('apf_email_template') !== false) {

                // The option already exists, so update it.
                update_option('apf_email_template', $_REQUEST['apf_email_template']);
            } else {

                // The option hasn't been created yet, so add it with $autoload set to 'no'.
                $deprecated = null;
                $autoload = 'no';
                add_option('apf_email_template', $_REQUEST['apf_email_template'], $deprecated, $autoload);
            }

            $success_msg = 'Successfully Save';
        }

        $apf_per_page = get_option('apf_per_page');
        $apf_message = get_option('apf_message');
        $apf_email_template = get_option('apf_email_template');


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
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=apf-setting">
                        <div class="apf-setting-inner-box">
                            <h2>Setting</h2>
                            <hr>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="20%"><strong>Application Per Page</strong> </td>
                                    <td width="80%">
                                        <input type="text" name="apf_per_page" required value="<?php echo $apf_per_page; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%"><strong>Application Thank You Message</strong> </td>
                                    <td width="80%">
                                        <input type="text" name="apf_message" required value="<?php echo $apf_message; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Email Template</strong> </td>
                                    <td>
                                        <textarea name="apf_email_template" required rows="10" cols="50"><?php echo $apf_email_template; ?></textarea>
                                        <span class="hint-class">[appname] = Applicant name</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <input name="update_setting" type="submit" value="Save Setting">
                    </form>
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

new Setting();
