<?php
/**
* System Administrator only
* Compare previous version with the new version
* and store the difference in a diff file
*/
require("../includes/config_mycmms.inc.php");
unset($_SESSION['PDO_ERROR']);
require("setup.php");
$DB=DBC::get();

switch ($_REQUEST['STEP']) {
case "1": { 
    if (!array_key_exists('PREVIOUS',$_FILES)) {
        throw new Exception('File-info PREVIOUS not found in uploaded data');
        $error='File-info PREVIOUS not found in uploaded data';
    } else {
        $file_previous=$_FILES['PREVIOUS'];
    }
    if (!array_key_exists('NEW',$_FILES)) {
        throw new Exception('File-info NEW not found in uploaded data');
        $error='File-info NEW not found in uploaded data';
    } else {
        $file_new=$_FILES['NEW'];
    }
    $success=xdiff_file_diff($file_previous['tmp_name'],$file_new['tmp_name'],'patch.diff', 2);
    if ($success) {
        $result="Successfully created patch {$file_new['name']}-{$file_previous['name']}";
    } else {
        $error="Could not create patch for {$file_new['name']}-{$file_previous['name']}";
    }
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('message',$result);
    $tpl->assign('errors',$error);
    $tpl->assign("result","patch.diff");
    $tpl->display_error("action/generic_action_end.tpl");
    break;
}
default: {
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$DB->query("SELECT ...",PDO::FETCH_ASSOC));
    $tpl->display_error("sa/sa_patch-create.tpl");
}
}
?>
