<?php
/** edit_query.php
* Help function used to save changes made by the administrator to the queries
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
*/
require("../includes/config_mycmms.inc.php");
DebugBreak();
$prefix=substr($_REQUEST['qry_name'],0,2);
if ($prefix=="P_") { die("Cannot change parameter query (starts with P_)"); }

DBC::execute("UPDATE sys_queries SET mysql=:mysql WHERE name LIKE :query_name",
    array("mysql"=>$_REQUEST['sql_query'],"query_name"=>$_REQUEST['qry_name']));
header("location: list.php?query_name=".$_REQUEST['qry_name']);
?>

