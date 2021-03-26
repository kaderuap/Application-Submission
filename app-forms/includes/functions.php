<?php

/**
 * Common Function
 * 
 *
 * @package    Application Form
 * @subpackage Application Form/functions
 * @author     Roni
 */

////////////////////////////// Echo Function ////////////////////////////////

function aped($arrgument)
{
    echo "<pre>";
    print_r($arrgument);
    echo "</pre>";
    return true;
}

////////////////////////////// Application Short Code ////////////////////////////////

function applicant_name()
{
    $appName = '';

    if (isset($_REQUEST['f_name']) && !empty($_REQUEST['f_name'])) {
        $appName .= $_REQUEST['f_name'] . ' ';
    }

    if (isset($_REQUEST['l_name']) && !empty($_REQUEST['l_name'])) {
        $appName .= $_REQUEST['l_name'] . ' ';
    }

    return $appName;
}

add_shortcode('appname', 'applicant_name');

function application_form()
{
    ob_start();

    global $wpdb;
    $apf_form_tbl = $wpdb->prefix . 'applicant_submissions';

    $uploads = wp_upload_dir();

    $error_massage = '';
    $success_massage = '';

    if (isset($_POST['appsubmit']) && !empty($_POST['appsubmit'])) {

        $sql = "SELECT apid FROM " . $apf_form_tbl . " WHERE ap_email = '" . $_POST['ap_email'] . "' OR ap_mobile = '" . $_POST['ap_mobile'] . "'";
        $app_check = $wpdb->get_results($sql, ARRAY_A);

        if (empty($app_check)) {

            if (is_email($_POST['ap_email'])) {

                $image_name = '';

                if (isset($_FILES["ap_cv"]['name']) && !empty($_FILES["ap_cv"]['name'])) {

                    $target_dir = $uploads['basedir'] . '/app_file/';

                    $target_file = $target_dir . basename($_FILES["ap_cv"]["name"]);

                    if (file_exists($target_file)) {
                        $image_name = time() . "_" . $_FILES["ap_cv"]["name"];
                        $target_file = $target_dir . basename($image_name);
                    } else {
                        $image_name = $_FILES["ap_cv"]["name"];
                    }

                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    if (!move_uploaded_file($_FILES["ap_cv"]["tmp_name"], $target_file)) {
                        $error_massage = "Cannt Upload File";
                    }
                }

                if (empty($error_massage)) {

                    $sql = "INSERT INTO " . $apf_form_tbl . " (`f_name`, `l_name`, `ap_address`, `ap_email`, `ap_mobile`, `ap_postname`,`ap_cv`) VALUES ( '" . $_POST['f_name'] . "','" . $_POST['l_name'] . "','" . $_POST['ap_address'] . "','" . $_POST['ap_email'] . "','" . $_POST['ap_mobile'] . "','" . $_POST['ap_postname'] . "','" . $image_name . "')";

                    $apf_insert = $wpdb->query($sql);

                    $apf_message = get_option('apf_message');
                    $apf_email_template = get_option('apf_email_template');

                    $success_massage  = !empty($apf_message) ? $apf_message : 'Thanks for taking the time to apply for our position. We appreciate your interest in weDevs Ltd.';
                    $mail_content  = !empty($apf_email_template) ? $apf_email_template : '[appname], <p>Thanks for taking the time to apply for our position. We appreciate your interest in weDevs Ltd.</p>';

                    $mail_content = apply_filters('the_content', $mail_content);

                    $to = $_POST['ap_email'];
                    $headers[] = "MIME-Version: 1.0";
                    $headers[] = "Content-type:text/html;charset=UTF-8";
                    $headers[] = "From: " . get_option('admin_email');
                    $subject = 'Applicant Submissions';
                    $mail_details = wp_mail($to, $subject, $mail_content, $headers);
                    
                }
            } else {
                $error_massage = 'This Not Valid Email';
            }
        } else {
            $error_massage = 'Sorry. You are already apply';
        }
    }
?>

    <div class="apf-container">

        <?php if (isset($error_massage) && !empty($error_massage)) : ?>
            <span class="error_massage"><?php echo $error_massage; ?></span>
        <?php elseif (isset($success_massage) && !empty($success_massage)) : ?>
            <span class="success_massage"><?php echo $success_massage; ?></span>
        <?php endif ?>



        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12">
                    <label for="appname">Name<sup>*</sup></label>
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="form-control" id="appname" name="f_name" type="text" placeholder="First Name" value="<?php if (empty($success_massage) && isset($_POST['f_name']) && !empty($_POST['f_name'])) echo $_POST['f_name']; ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <input class="form-control" id="appname" name="l_name" type="text" value="<?php if (empty($success_massage) && isset($_POST['l_name']) && !empty($_POST['l_name'])) echo $_POST['l_name']; ?>" placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label for="appaddress">Present Address<sup>*</sup></label>
                    <input class="form-control" id="appaddress" name="ap_address" type="text" placeholder="" value="<?php if (empty($success_massage) && isset($_POST['ap_address']) && !empty($_POST['ap_address'])) echo $_POST['ap_address']; ?>" required>
                </div>
                <div class="col-sm-12">
                    <label for="appemail">Email Address<sup>*</sup></label>
                    <input class="form-control" id="appemail" name="ap_email" type="email" placeholder="" value="<?php if (empty($success_massage) && isset($_POST['ap_email']) && !empty($_POST['ap_email'])) echo $_POST['ap_email']; ?>" required>
                </div>
                <div class="col-sm-12">
                    <label for="appmobile">Mobile No<sup>*</sup></label>
                    <input class="form-control number_check" id="appmobile" name="ap_mobile" type="text" placeholder="" value="<?php if (empty($success_massage) && isset($_POST['ap_mobile']) && !empty($_POST['ap_mobile'])) echo $_POST['ap_mobile']; ?>" required>
                </div>
                <div class="col-sm-12">
                    <label for="apppost">Post Name<sup>*</sup></label>
                    <input class="form-control" id="apppost" name="ap_postname" type="text" placeholder="" value="<?php if (empty($success_massage) && isset($_POST['ap_postname']) && !empty($_POST['ap_postname'])) echo $_POST['ap_postname']; ?>" required>
                </div>
                <div class="col-sm-12">
                    <label for="appcv">CV<sup>*</sup></label>
                    <input type="file" class="form-control-file" id="appcv" name="ap_cv" accept=".doc,.docx,application/msword,.pdf" required>
                </div>
                <div class="col-sm-12 appBtnBox">
                    <input class="appBtn" type="submit" name="appsubmit" value="Submit">
                </div>
            </div>

        </form>
    </div>

<?php

    return ob_get_clean();
}

add_shortcode('applicant_form', 'application_form');
