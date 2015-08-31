<?php
/**
* Printout Generic object information  
* 
*/
$DB=DBC::get();
if(defined('OBJECT_DATA')) {
    $result=$DB->query("SELECT * FROM equip WHERE equip.EQNUM='$EQNUM'");
    $object_data=$result->fetch(PDO::FETCH_ASSOC);
}
if(defined('OBJECT_RISK')) {
    $result=$DB->query("SELECT * FROM equip_t0118 WHERE EQNUM='$EQNUM'");
    $object_risk=$result->fetch(PDO::FETCH_ASSOC);
}
if(defined('')) {
    $result=$DB->query("SELECT COMPONENT,DESC_COMP,COMPTYPE FROM equip_components ec WHERE ec.EQNUM='$EQNUM'");
    $components=$result->fetchAll(PDO::FETCH_ASSOC);
}
if(defined("OBJECT_BOM")) {
    $BOM_name=DBC::fetchcolumn("SELECT SPARECODE FROM equip WHERE EQNUM='$EQNUM'",0);
    $result=$DB->query("SELECT spares.ITEMNUM,SAP,DESCRIPTION,WAREHOUSEID,QTYONHAND,LOCATION FROM spares 
        LEFT JOIN invy ON spares.ITEMNUM=invy.ITEMNUM 
        LEFT JOIN stock ON spares.ITEMNUM=stock.ITEMNUM 
        WHERE SPARECODE='$BOM_name'");
    $BOM_spares=$result->fetchAll(PDO::FETCH_ASSOC);
}
if(defined("OBJECT_WO")) {
    $result=$DB->query("SELECT * FROM wo WHERE EQNUM='$EQNUM' ORDER BY REQUESTDATE DESC LIMIT 0,5");
    $workorders=$result->fetchAll(PDO::FETCH_ASSOC);
}
if(defined('OBJECT_DOCU')) {
    $result=$DB->query("SELECT DISTINCT CONCAT(dd.sha1,'/',dl.filename) AS 'filepath',dl.filename,dd.filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE dl.type='eq' AND dl.link='{$EQNUM}' AND dd.md5='0'");
    $docu=$result->fetchAll(PDO::FETCH_ASSOC);
}
if(defined('OBJECT_UPLOAD')) {
    $result=$DB->query("SELECT DISTINCT CONCAT(LEFT(dd.sha1,2),'/',LEFT(dd.sha1,1),'/',dl.filename) AS 'filepath',dl.filename,dd.filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE dl.type='eq' AND dl.link='{$EQNUM}' AND dd.md5<>'0'");
    $upload=$result->fetchAll(PDO::FETCH_ASSOC);
}
if(defined('OBJECT_TASKS')) {
    $result=$DB->query("SELECT task.TASKNUM,task.DESCRIPTION,te.EQNUM FROM task LEFT JOIN taskeq te ON task.TASKNUM=te.TASKNUM WHERE te.EQNUM='{$EQNUM}'");
    $object_tasks=$result->fetchAll(PDO::FETCH_ASSOC); 
}
?>
