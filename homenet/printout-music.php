<?php
/** 
* @author  Werner Huysmans 
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("class_printoutPageSmarty.php");
require("setup.php");
$ID = $_REQUEST['id1'];

$printout=new printoutPageSmarty();
$printout->main_data("SELECT * FROM records WHERE RecordingID=$ID");  
$musicDir=DBC::fetchcolumn("SELECT setting FROM sys_system WHERE ID='musicDir'",0); 
$printout->params=$musicDir.floor($ID/100);
$printout->listdata1("SELECT * FROM tracks WHERE RecordingID={$ID}");
$printout->listdata2("SELECT dl.filename, filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='$ID'");
$printout->listdata3("SELECT * FROM records2 WHERE RecordingID='$ID'");
#$printout->listdata4
$printout->display();
?>