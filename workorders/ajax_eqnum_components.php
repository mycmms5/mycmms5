<?php
/** 
* Returns components in answer to XMLHttpRequest
* 
* @author  Werner Huysmans 
* @access  public
* @version $Id: ajax_eqnum_components.php,v 1.1.1.1 2013/04/16 05:14:40 werner Exp $ 4.0 201104
* @package work
* @subpackage AJAX
* @filesource
* @tpl  No Template
* @txid No DATABASE action
* @todo Returns a list of Machine components / called in tab_wo-basic
*/
require("../includes/config_mycmms.inc.php");
$DB=DBC::get();
$result=$DB->query("SELECT e.EQNUM,CONCAT(DESCRIPTION,':',EQNUM) AS 'OPTION' FROM equip e WHERE EQROOT='{$_REQUEST['EQNUM']}' AND EQFL='COMP'");
if ($result) {
    echo "<SELECT NAME='COMPONENT'>";
    foreach($result->fetchAll(PDO::FETCH_NUM) AS $row) {
        echo "<OPTION value='{$row[0]}'>".$row[1]."</OPTION>";
    }
    echo "</SELECT>";
}
?>
