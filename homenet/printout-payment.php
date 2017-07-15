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
$printout->main_data("SELECT * FROM cash LEFT JOIN genledger ON cash.GENLEDGER=genledger.GENLEDGER WHERE ID=$ID");  
$printout->display();
?>