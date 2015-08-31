<?PHP
/** Urgent work
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2010
* @access  public
* @package mycmms32_work
* @subpackage work_request
* 
* CVS
* $Id: tab_notification.php,v 1.1 2013/06/08 11:44:11 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_notification.php,v $
* $Log: tab_notification.php,v $
* Revision 1.1  2013/06/08 11:44:11  werner
* Notification in main project
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class notificationPage extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    return $errors;
} // New
public function page_content() {
    if ($_SESSION['Ident_1']=="new") {  // New demand or adding missing information
        $data=unserialize($_SESSION['form_data']);
    } 
    if ($_SESSION['Ident_1']>0) {  
        $obj_data=$this->get_data($_SESSION['Ident_1'],$_SESSION['Ident_2']);
        $data=(array)$obj_data;
    }
    $DB=DBC::get();
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('notiftypes',$DB->query("SELECT NOTIFTYPE AS id, DESCRIPTION AS text FROM notificationtype",PDO::FETCH_NUM));
    $tpl->display_error('tab_notification.tpl');
} // New
public function process_form() {
    // Resetting the values
    unset($_SESSION['form_data']);
    $DB=DBC::get();
    if ($_SESSION['Ident_1']=="new") { 
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO notification (NOTIF,NOTIFIER,NOTIFICATION,LNOTIFICATION,NOTIFTYPE,NOTIFDATE,EQNUM) VALUES (NULL,:notifier,:notification,:lnotification,:notiftype,NOW(),:eqnum)",array("notifier"=>$_REQUEST['NOTIFIER'],"notification"=>$_REQUEST['NOTIFICATION'],"lnotification"=>$_REQUEST['LNOTIFICATION'],"notiftype"=>$_REQUEST['NOTIFTYPE'],"eqnum"=>$_REQUEST['EQNUM']));
            $new_notification=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } 
        $_SESSION['Ident_1']=$new_notification;
        $_SESSION['Ident_2']=$_REQUEST['EQNUM'];
        $this->input1=$new_notification;
        $this->input2=$_REQUEST['EQNUM'];
    } else {
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE notification SET NOTIFICATION=:notification,LNOTIFICATION=:lnotification,NOTIFTYPE=:notiftype,EQNUM=:eqnum WHERE NOTIF=:id",array("notification"=>$_REQUEST['NOTIFICATION'],"lnotification"=>$_REQUEST['LNOTIFICATION'],"notiftype"=>$_REQUEST['NOTIFTYPE'],"eqnum"=>$_REQUEST['EQNUM'],"id"=>$_SESSION['Ident_1']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try     
    }
} // New
} // End class

$inputPage=new notificationPage();
$inputPage->data_sql="SELECT n.*,e.DESCRIPTION FROM notification n 
    LEFT JOIN equip e ON n.EQNUM=e.EQNUM 
    WHERE NOTIF={$_SESSION['Ident_1']}";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>
