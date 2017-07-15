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
$printout->main_data("SELECT * FROM books WHERE BookID=$ID");  
$printout->params=DOC_PATH."books/".floor($ID/100);
$printout->listdata1("SELECT * FROM quotes WHERE BookID={$ID}");
$printout->listdata2("SELECT * FROM books2 WHERE BookID={$ID}");
$printout->listdata3("SELECT dl.filename, filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='$ID'");
#$printout->listdata4
$printout->display();
?>
