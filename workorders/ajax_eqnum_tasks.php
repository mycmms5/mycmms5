<?php
/** 
* Returns tasks in answer to XMLHttpRequest
*  
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage AJAX
* @filesource
*/
require("../includes/config_mycmms.inc.php");
$DB=DBC::get();
$result=$DB->query("SELECT te.TASKNUM,CONCAT(DESCRIPTION,':',te.TASKNUM) AS 'OPTION' FROM taskeq te LEFT JOIN task t ON te.TASKNUM=t.TASKNUM WHERE EQNUM='{$_REQUEST['EQNUM']}'");
if ($result) {
    echo "<SELECT NAME='TASK'>";
    foreach($result->fetchAll(PDO::FETCH_NUM) AS $row) {
        echo "<OPTION value='{$row[0]}'>".$row[1]."</OPTION>";
    }
    echo "</SELECT>";
}
?>
