<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @version $Id: task_print.php,v 1.1.1.1 2013/04/16 05:14:40 werner Exp $4.0 201106
* @subpackage printout
* @filesource
* @tpl printout_ppm.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$PrtScn=true;
$TASKNUM=$_REQUEST['id1'];
$EQNUM=$_REQUEST['id2'];
# Data preparation
$DB=DBC::get();
$result=$DB->query("SELECT task.TASKNUM,task.DESCRIPTION,task.TEXTS_A FROM task WHERE task.TASKNUM='$TASKNUM'");
$ppm_main_data=$result->fetch(PDO::FETCH_ASSOC);

$docs=$DB->query("SELECT dl.FILENAME,dd.FILEDESCRIPTION FROM document_links dl LEFT JOIN document_descriptions dd ON dl.FILENAME=dd.FILENAME WHERE TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
// $wikilinks=$DB->query("SELECT wl.WIKILINK FROM wiki_links wl WHERE TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
$works=$DB->query("SELECT tp.OPNUM,tp.OPDESC,tc.CRAFT,tc.TEAM,tc.ESTHRS FROM tskop tp LEFT JOIN tskcraft tc ON tp.TASKNUM=tc.TASKNUM AND tp.OPNUM=tc.OPNUM WHERE tp.TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
$spares=$DB->query("SELECT tp.ITEMNUM,i.DESCRIPTION,tp.QTYREQD FROM tskparts tp LEFT JOIN INVY i ON tp.ITEMNUM=i.ITEMNUM WHERE tp.TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
// $checks=$DB->query("SELECT tc.INDICATOR,i.TYPE,i.LABEL,i.INSTRUCTIONS FROM tskchecks tc LEFT JOIN indicators i ON tc.INDICATOR=i.INDICATOR WHERE TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
$machines=$DB->query("SELECT taskeq.EQNUM,equip.DESCRIPTION,taskeq.WONUM FROM task LEFT JOIN taskeq ON task.TASKNUM=taskeq.TASKNUM LEFT JOIN equip ON taskeq.EQNUM=equip.EQNUM WHERE task.TASKNUM='$TASKNUM'",PDO::FETCH_ASSOC);
$workorders=$DB->query("SELECT WONUM,TASKDESC,REQUESTDATE,COMPLETIONDATE,WOSTATUS FROM wo WHERE wo.TASKNUM='$TASKNUM' AND wo.EQNUM='$EQNUM'",PDO::FETCH_ASSOC);

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("ppm",$ppm_main_data);
// $tpl->assign("doc_path",DOC_LINK);
$tpl->assign("documents",$docs);
$tpl->assign("wikilinks",$wikilinks);
$tpl->assign("works",$works);
$tpl->assign("spares",$spares);
$tpl->assign("checks",$checks);
$tpl->assign("machines",$machines);
$tpl->assign("workorders",$workorders);
if($PrtScn) {
    $tpl->display_error('printout_ppm.tpl');
} else {
    ;
}
?>