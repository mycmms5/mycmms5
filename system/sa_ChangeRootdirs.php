<?php
/**
* This module will translate all paths in sys_navoptions to their absolute path
* Only to be used by System Administrator and after check of status.
*/
require("../includes/config_mycmms.inc.php");
$DB=DBC::get();

$result=$DB->query("SELECT * FROM sys_navoptions",PDO::FETCH_ASSOC);
foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
    eval('$action="'.$row['action'].'";');
    echo $action." *** ";
    if (strpos($row['action'],"rootdir") > 0) { 
        echo $action."</br>";
        DBC::execute("UPDATE sys_navoptions SET action=:action WHERE action=:action_rootdir",
            array("action"=>$action, "action_rootdir"=>$row['action']));
    } else {
        echo "</br>";
    }// EO if substr
}
?>
