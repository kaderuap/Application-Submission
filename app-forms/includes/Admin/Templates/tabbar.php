<?php
/**
 * Tab Bar
 *
 * @package    Application Form
 * @subpackage Application Form/admin/tempaltes
 * @author     Roni
 */

global $submenu;
$apf_sumenu_list = $submenu['app-forms'];

?>

<ul class="apf-top-nav">
    <?php 
        if(!empty($apf_sumenu_list)) {
            for($m=0; $m<count($apf_sumenu_list); $m++) :
    ?>   
                <?php if($_REQUEST['page'] == $apf_sumenu_list[$m][2]) : ?>
                    <li class="active"><?php echo $apf_sumenu_list[$m][0]; ?></li>
                <?php else : ?>
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo $apf_sumenu_list[$m][2]; ?>"><?php echo $apf_sumenu_list[$m][0]; ?></a></li>
                <?php endif; ?>
                
    <?php
            endfor;
        }
    ?>
</ul>