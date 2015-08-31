<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @package warehouse
* @version $Id: stock_print.php,v 1.1.1.1 2013/04/16 05:14:40 werner Exp $4.0 201106
* @subpackage printout
* @filesource
* @tpl printout_invy.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$PrtScn=true;
$ITEMNUM=$_REQUEST['id1'];

# Data preparation
$DB=DBC::get();
$result=$DB->query("SELECT ITEMNUM,DESCRIPTION,NOTES FROM invy WHERE ITEMNUM='$ITEMNUM'");
$invy_main_data=$result->fetch(PDO::FETCH_ASSOC);

$docs=$DB->query("SELECT dl.FILENAME,dd.FILEDESCRIPTION FROM document_links dl LEFT JOIN document_descriptions dd ON dl.FILENAME=dd.FILENAME WHERE ITEMNUM='$ITEMNUM'",PDO::FETCH_ASSOC);
$stocks=$DB->query("SELECT WAREHOUSEID,LOCATION,QTYONHAND FROM stock WHERE ITEMNUM='$ITEMNUM'",PDO::FETCH_ASSOC);
// $transactions=$DB->query("SELECT ITEMNUM,TRANSTYPE,ISSUEDATE,CHARGETO,NUMCHARGEDTO FROM issrec WHERE ITEMNUM=$ITEMNUM ORDER BY ISSUEDATE DESC LIMIT 50",PDO::FETCH_ASSOC);

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("invy",$invy_main_data);
$tpl->assign("doc_path",DOC_LINK);
$tpl->assign("documents",$docs);
$tpl->assign("stocks",$stocks);
if($PrtScn) {
    $tpl->display_error('printout_invy.tpl');
} else {
    ;
}
?>