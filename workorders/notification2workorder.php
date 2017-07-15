<?PHP
/**
* Convert a notfification to a work order
*  
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage notification
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @todo Smarty form
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class notification2workorderPage extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    return $errors;
} // EO Validation
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($_SESSION['Ident_1'],$_SESSION['Ident_2']);
    if ($data['WONUM']) {
        $result=$DB->query("SELECT * FROM wo WHERE WONUM={$data['WONUM']}");
        $wo_data=$result->fetch(PDO::FETCH_ASSOC);
    }
    require('setup.php');
    $tpl=new smarty_mycmms();
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('data',$data);
    $tpl->assign('wo_data',$wo_data);
    $tpl->assign('priorities',$DB->query("SELECT PRIORITY AS id, DESCRIPTION AS text FROM wopriority",PDO::FETCH_NUM));
    $tpl->display_error("tw/notification2workorder.tpl");
} // EO Displaying
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        # Only do when there is not yet a WO created
        if (empty($_REQUEST['WONUM'])) {    
            $downtime=(strtotime($_REQUEST['DT_END'])-strtotime($_REQUEST['DT_START']))/60;
            DBC::execute("INSERT INTO wo (WONUM,EQNUM,TASKDESC,TEXTS_B,REQUESTDATE,PRIORITY,WOTYPE,WOSTATUS,ORIGINATOR,DT_START,DT_END,DT_DURATION,RFOCODE) 
            SELECT NULL,EQNUM,NOTIFICATION,LNOTIFICATION,NOTIFDATE,:priority,'REPAIR','PR',:user,:dt_start,:dt_end,:downtime,'UNPLANNED_TECH' FROM notification 
            WHERE NOTIF=:id",array("id"=>$_SESSION['Ident_1'],"priority"=>$_REQUEST['PRIORITY'],"user"=>$_SESSION['user'],"dt_start"=>$_REQUEST['DT_START'],"dt_end"=>$_REQUEST['DT_END'],"downtime"=>$downtime));
            DBC::execute("UPDATE notification SET WONUM=LAST_INSERT_ID() WHERE NOTIF=:notification",array("notification"=>$_SESSION['Ident_1']));
        } 
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    } 
} // EO Processing
} // End class

$inputPage=new notification2workorderPage();
$inputPage->data_sql="SELECT n.*,e.DESCRIPTION,wo.DT_START,wo.DT_END,wo.DT_DURATION FROM notification n  LEFT JOIN wo ON n.WONUM=wo.WONUM LEFT JOIN equip e ON n.EQNUM=e.EQNUM WHERE NOTIF={$_SESSION['Ident_1']}";
$inputPage->flow();
?>
