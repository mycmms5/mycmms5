<?php
session_start();
require_once("../includes/config_mycmms.inc.php");
require("setup.php");

$DB=DBC::get();
$result=$DB->query("SELECT WONUM,EMPCODE,ESTHRS FROM woe WHERE ID={$_COOKIE['WO']} AND REGHRS=0");
$woe=$result->fetch(PDO::FETCH_ASSOC);
switch ($_REQUEST['ACTION']) {
case 'PLAN': {
    try {
        $DB->BeginTransaction();
        DBC::execute("INSERT INTO woe (WONUM,EMPCODE,OPNUM,WODATE,ESTHRS) VALUE (:wonum,:empcode,10,:wodate,:esthrs)",
            array(
            "wonum"=>$woe['WONUM'],
            "wodate"=>$_COOKIE['DAY'],
            "empcode"=>$_COOKIE['TECH'],
            "esthrs"=>$woe['ESTHRS']));
        $DB->commit();            
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
    $_SESSION['WEBCAL_LOCATION']="pop".DBC::fetchcolumn("SELECT LAST_INSERT_ID()");    
    break;    
}
case 'MOVE': {
    try {
        $DB->beginTransaction();
        DBC::execute("DELETE FROM woe WHERE ID={$_COOKIE['WO']} AND REGHRS=0",array());        
        DBC::execute("INSERT INTO woe (WONUM,EMPCODE,OPNUM,WODATE,ESTHRS) VALUE (:wonum,:empcode,10,:wodate,:esthrs)",
            array(
            "wonum"=>$woe['WONUM'],
            "wodate"=>$_COOKIE['DAY'],
            "empcode"=>$_COOKIE['TECH'],
            "esthrs"=>$woe['ESTHRS']));
        $DB->commit();            
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
    $_SESSION['WEBCAL_LOCATION']="pop".DBC::fetchcolumn("SELECT LAST_INSERT_ID()");    
    break;    
}
case "DELETE": {
    try {
        $DB->beginTransaction();
        DBC::execute("DELETE FROM woe WHERE ID={$_COOKIE['WO']} AND REGHRS=0",array());        
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
    break;
} // EO case DELETE
} // EO switch

$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
$tpl->assign("cookies",$_COOKIE);
$tpl->display('cal/plan_direct.tpl');
?>
