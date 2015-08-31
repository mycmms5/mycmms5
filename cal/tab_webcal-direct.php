<?php
/**
* WEBCAL connection
* 
* @author  Werner Huysmans 
* @access  public
* @version $Id: tab_webcal-direct.php,v 1.5 2013/09/07 16:38:16 werner Exp $4.0 201105
* @package work
* @subpackage webcal
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
require("setup.php");
$DB=DBC::get(); # Connection to CMMS DB
$ID=$_SESSION['Ident_1'];   # woe record

switch($_REQUEST['STEP']) {
case '1':
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "ADD":
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO woe (WONUM,EMPCODE,OPNUM,WODATE,ESTHRS) VALUE (:wonum,:empcode,10,:wodate,:esthrs)",
                array(
                "wonum"=>$_REQUEST['WONUM'],
                "wodate"=>$_REQUEST['WODATE'],
                "empcode"=>$_REQUEST['EMPCODE'],
                "esthrs"=>$_REQUEST['ESTHRS']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        $_SESSION['WEBCAL_LOCATION']="pop".DBC::fetchcolumn("SELECT LAST_INSERT_ID()");  
        break;
    case "EDIT":
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE woe SET ESTHRS=:esthrs WHERE ID=:id",
                array(
                    "id"=>$ID,
                    "esthrs"=>$_REQUEST['ESTHRS']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
        $_SESSION['WEBCAL_LOCATION']="pop".DBC::fetchcolumn("SELECT LAST_INSERT_ID()");  
    case "MOVE":
        try {
            $DB->beginTransaction();
            DBC::execute("DELETE FROM woe WHERE ID={$ID} AND REGHRS=0",array());        
            DBC::execute("INSERT INTO woe (WONUM,EMPCODE,OPNUM,WODATE,ESTHRS) VALUE (:wonum,:empcode,10,:wodate,:esthrs)",
                array(
                    "wonum"=>$_REQUEST['WONUM'],
                    "wodate"=>$_REQUEST['WODATE'],
                    "empcode"=>$_REQUEST['EMPCODE'],
                    "esthrs"=>$_REQUEST['ESTHRS']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
        $_SESSION['WEBCAL_LOCATION']="pop".DBC::fetchcolumn("SELECT LAST_INSERT_ID()");  
    case "DELETE":
        try {
            $DB->beginTransaction();
            DBC::execute("DELETE FROM woe WHERE ID={$ID} AND REGHRS=0",array());        
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    default:
        break;                           
    }
?>
<script type="text/javascript">
function call_refreshParent() {    
    parent.refreshParent(); 
    window.close();
} 
setTimeout("call_refreshParent();", 25);
</script>
<?php
    break;
default:
    $DB=DBC::get();
    $test=$_REQUEST['DAY'];



    
    
    $esthrs=DBC::fetchcolumn("SELECT ESTHRS FROM woe WHERE ID={$_SESSION['Ident_1']}",0);
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
/**
* Find the WO - store it in $wonum
* Get all data from the WO - store in $wo_data
* Get all records from WOE - store in $woe_data
*/
    $wonum=DBC::fetchcolumn("SELECT WONUM FROM woe WHERE ID={$_SESSION['Ident_1']}",0);
    $result=$DB->query("SELECT * FROM wo WHERE WONUM=$wonum");
    $wo_data=$result->fetch(PDO::FETCH_ASSOC);
    
    $sql="SELECT * FROM woe WHERE WONUM={$wonum}";
    $result=$DB->query($sql);
    $woe_data=$result->fetchAll(PDO::FETCH_ASSOC);
        $tpl->assign('wo_data',$wo_data);
        $tpl->assign('woe_data',$woe_data);
/** 
* Get some global values:
* 1: planned_hours : how many hours were planned 
* 2: real_hours : how many are planned now
* 3: what's this day charge?
*/
    $info=array();
    $info['planned_hours']=DBC::fetchcolumn("SELECT SUM(ESTHRS*TEAM) FROM wocraft WHERE WONUM=$wonum",0);
    $info['real_hours']=DBC::fetchcolumn("SELECT SUM(REGHRS) FROM woe WHERE WONUM=$wonum",0);
    $info['day_charge']=DBC::fetchcolumn("SELECT SUM(ESTHRS) FROM woe WHERE EMPCODE='{$_SESSION['webcal_user']}' AND WODATE='{$_SESSION['Ident_2']}'",0);
        $tpl->assign("info",$info);
    # $tpl->assign('plan_data',$_SESSION['plan_data']);
    $tpl->assign('esthrs',$esthrs);
    $tpl->assign('employees',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups",PDO::FETCH_NUM));
    $tpl->display_error('cal/webcal-direct.tpl'); 
    break;
}
?>
