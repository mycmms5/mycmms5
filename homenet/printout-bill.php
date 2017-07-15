<?php
/** 
* @author  Werner Huysmans 
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("class_printoutPageSmarty.php");
require("setup.php");
if (is_null($_REQUEST['id1'])) {
    $ID=$_SESSION['Ident_1'];
} else {    
    $ID=$_REQUEST['id1'];   
}

$printout=new printoutPageSmarty();
$printout->main_data("SELECT * FROM cash WHERE ID=$ID");  
$printout->listdata1("SELECT *,rate*workhours AS 'total' FROM billing WHERE FactuurID={$ID} ORDER BY workdate ASC");
$printout->serialData("SELECT BILL FROM cash WHERE ID={$ID}");

$DB=DBC::get();
$printout->calcul_data=DBC::fetchcolumn("SELECT SUM(workhours*rate)+SUM(costs) FROM billing WHERE FactuurID={$ID}",0);
$printout->display();
?>