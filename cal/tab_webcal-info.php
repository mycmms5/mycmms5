<?php
/**
* WEBCAL connection
* 
* @author  Werner Huysmans 
* @access  public
* @version $Id: tab_webcal-info.php,v 1.2 2013/08/19 13:28:05 werner Exp $4.0 201105
* @package work
* @subpackage webcal
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("setup.php");
$DB=DBC::get(); # Connection to CMMS DB
$ID=$_SESSION['Ident_1'];
$wonum=DBC::fetchcolumn("SELECT DISTINCT WONUM FROM woe WHERE ID='{$_SESSION['Ident_1']}'",0);
if ($wonum) {
    $result=$DB->query("SELECT WONUM,EQNUM,TASKDESC,TEXTS_B,wo.WOSTATUS,wostatus.DESCRIPTION FROM wo LEFT JOIN WOSTATUS ON wo.WOSTATUS=wostatus.WOSTATUS WHERE WONUM=$wonum");
    $wo_data=$result->fetch(PDO::FETCH_ASSOC);

    $result=$DB->query("SELECT EMPCODE,WODATE,ESTHRS,REGHRS FROM woe WHERE WONUM=$wonum ORDER BY WODATE DESC");
    $woe_data=$result->fetchAll(PDO::FETCH_ASSOC);
}

/**
* All data is in myCMMS database now
* $result=$DB->query("SELECT * FROM temp_webcal_entries WHERE ID='{$_SESSION['Ident_1']}'");
* $webcal_data=$result->fetch(PDO::FETCH_ASSOC);
*/

$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
$tpl->assign("wo_data",$wo_data);
$tpl->assign("woe_data",$woe_data);
$tpl->assign("cookies",$_COOKIE);
// $tpl->assign("webcal_data",$webcal_data);
$tpl->assign("error",$e_getMessage);
$tpl->display_error('cal/webcal_info.tpl');
?>
