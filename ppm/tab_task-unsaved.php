<?php
require("setup.php");
$tpl = new smarty_mycmms();
$tpl->debugging=false;
$tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
$tpl->display_error('tab_task-unsaved.tpl');  
?>
