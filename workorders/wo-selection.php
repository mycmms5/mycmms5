<?php
/** 
* Printout selected workorders  
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage printout_ALL
* @filesource
* @done Use Smarty
* @done Adapt the choice of the template in function of the DATABASE
*/
require("../includes/config_mycmms.inc.php");

function get_data_sql($query) {
    $DB=DBC::get();
    $result=$DB->query("SELECT mysql FROM sys_queries WHERE name='$query'");
    $sql=$result->fetchColumn(0);
    $sql_where=split("WHERE",$sql);
    if (is_null($sql_where[1])) {
        $sql_where[1]=" 1";
    }
    $sql_selection="SELECT WONUM,EQNUM,TASKDESC,'X' FROM wo WHERE ".$sql_where[1];
    // Get the data
    eval('$sql_selection="'.$sql_selection.'";');
    return $sql_selection;
}
$DB=DBC::get();
$selection=get_data_sql($_SESSION['query_name']);
$data=$DB->query($selection,PDO::FETCH_ASSOC);
    
require("setup.php");
$tpl=new smarty_mycmms();
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
$tpl->assign("data",$data);
$tpl->assign("action","printout2pdf_".CMMS_DB.".php");
$tpl->assign("reports",array("printout_wo_".CMMS_DB.".tpl"));
$tpl->assign("session",$_SESSION);
$tpl->assign("wikipage","Printout ALL work orders");
$tpl->display_error("wo-selection_form.tpl");
?>
