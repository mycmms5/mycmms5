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
require("../includes/config_mycmms.inc.php");
require("class_printoutPageSmarty.php");
require("setup.php");
$ITEMNUM=$_REQUEST['id1'];
$DB=DBC::get();

$printout=new printoutPageSmarty();
$printout->main_data("SELECT invy.* FROM invy WHERE invy.ITEMNUM='$ITEMNUM'");  
#$printout->listdata1("SELECT dl.filename, filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='$EQNUM'");$printout->listdata2("SELECT e.EQNUM,e.DESCRIPTION FROM equip e WHERE EQROOT='$EQNUM'");
#$printout->listdata2("SELECT EQNUM, DESCRIPTION FROM equip WHERE EQROOT='$EQNUM'");
$printout->display();
?>