<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @package homenet4
* @version 4.0 201106
* @subpackage printout
* @filesource
* @tpl printout_music.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$PrtScn=true;
$ID = $_REQUEST['id1'];

# Data preparation
$DB=DBC::get();
$result=$DB->query("SELECT wo.* FROM wo WHERE wo.WONUM=$ID");
$work_data=$result->fetch(PDO::FETCH_ASSOC);
# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("work_data",$work_data);
$tpl->assign("purchases",$DB->query("SELECT * FROM purreq WHERE WONUM={$ID}",PDO::FETCH_ASSOC));
$tpl->assign("totalcost",DBC::fetchcolumn("SELECT SUM(LINECOST) FROM purreq WHERE WONUM={$ID}",0));
#$tpl->assign("hours",$DB->query("SELECT EMPCODE,WODATE,ESTHRS,REGHRS FROM WOE WHERE WOE.WONUM={$ID}",PDO::FETCH_ASSOC));
#$tpl->assign("parts",$DB->query("SELECT WOP.ITEMNUM,INVY.SAP,DESCRIPTION,QTYREQD,QTYUSED FROM WOP LEFT JOIN INVY ON WOP.ITEMNUM=INVY.ITEMNUM 
$tpl->display('printout/printout-homework.tpl');
