<?PHP
/** 
* Planable work
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage request
* @filesource
* CVS
* $Id: tab_wr2.php,v 1.2 2013/08/31 09:06:23 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wr2.php,v $
* $log$
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class WR2Page extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    if ($_SESSION['Ident_1']!="new") { $errors['NO_NEW']=_("WO_ERROR:NONEW"); }
    if (empty($_REQUEST['TASKDESC'])) { $errors['TASKDESC']=_("WO_ERROR:TASKDESC"); }
    $DB=DBC::get();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
    if ($found == 0) { $errors['EQNUM']=_("WO_ERROR:EQNUM");   }
    if ($_REQUEST['EQNUM']==$_SESSION['dept']) {    $errors['EQNUM']=_("WO_ERROR:EQNUM");   }
    if ($_REQUEST['PRIORITY']=="") { $errors['PRIORITY']=_("WO_ERROR:PRIORITY"); }
    if ($_REQUEST['WOTYPE']=="") { $errors['WOTYPE']=_("WO_ERROR:WOTYPE"); }
    return $errors;
} // New
public function page_content() {
    $DB=DBC::get();
    if ($_SESSION['Ident_1']=="new") {  // New demand or adding missing information
        $data=unserialize($_SESSION['form_data']);
    } 
    if ($_SESSION['Ident_1']>100000) {  
        $obj_data=$this->get_data($_SESSION['Ident_1'],$_SESSION['Ident_2']);
        $data=(array)$obj_data;
    }
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH.CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH.CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("user",$_SESSION['user']);
    # $tpl->assign("originators",$DB->query("SELECT uname as id, longname as text FROM sys_groups ORDER BY uname",PDO::FETCH_NUM));
    $tpl->assign("technicians",$DB->query("SELECT uname as id, longname as text FROM sys_groups WHERE (profile & 64=64) ORDER BY uname",PDO::FETCH_NUM));
    $tpl->assign("priorities",$DB->query("SELECT PRIORITY,DESCRIPTION FROM wopriority WHERE PRIORITY IN (2,3,4,5)",PDO::FETCH_NUM));
    $tpl->assign("wotypes",$DB->query("SELECT WOTYPE,DESCRIPTION FROM wotype",PDO::FETCH_NUM));
    $tpl->display_error($this->template);
} // New
public function process_form() {
    // Resetting the values
    unset($_SESSION['form_data']);
    // From FORM
    $pEQNUM=$_REQUEST['EQNUM'];$pTASKDESC=$_REQUEST['TASKDESC'];$pORIGINATOR=$_SESSION['user'];
    $pWOTYPE=$_REQUEST['WOTYPE'];$pEXPENSE=$_REQUEST['EXPENSE'];$pPRIORITY=$_REQUEST['PRIORITY'];
    // Fixed values for URGENT work
    $pWOPREV=0;$pTASKNUM="NONE";$pTEXTS_A="No preparation was done";
    $pWOSTATUS="R";
    $pAPPROVEDDATE=now2string(true);
    $DB=DBC::get();
    if ($_SESSION['Ident_1']!="new") { return 0; } // Only NEW
/** Changed for DEMB: all approvers are listed inside the equip table
*/
    switch (CMMS_DB) {
    case 'DEMB':
        $pAPPROVEDBY=DBC::fetchcolumn("SELECT approver FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
        break;
    default: 
        $pAPPROVEDBY=$_SESSION['APPROVER'];   
        break;
    } 
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO wo (WONUM,EQNUM,WOPREV,REQUESTDATE,TASKNUM,TASKDESC,TEXTS_A,TEXTS_B,ORIGINATOR,WOTYPE, EXPENSE,PRIORITY,CLOSEDATE,COMPLETIONDATE,SCHEDSTARTDATE,APPROVEDBY,APPROVEDDATE,ASSIGNEDTECH,WOSTATUS) 
        VALUES (NULL,:eqnum,:woprev,NOW(),'NONE',:taskdesc,:methods,'Feedback',:originator,:wotype,'MAINT',:priority,'1900-01-01','1900-01-01',:schedstartdate,:approvedby,:approveddate,:assignedtech,:wostatus)",
        array("eqnum"=>$pEQNUM,"woprev"=>$pWOPREV,
            "taskdesc"=>$pTASKDESC,"methods"=>$pTEXTS_A,
            "originator"=>$pORIGINATOR,"priority"=>$pPRIORITY,
            "wotype"=>$pWOTYPE,"schedstartdate"=>$pSCHEDSTARTDATE,
            "approvedby"=>$pAPPROVEDBY,"approveddate"=>$pAPPROVEDDATE,
            "assignedtech"=>$_REQUEST["ASSIGNEDTECH"],"wostatus"=>$pWOSTATUS));
        $new_wo=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }       
    $this->input1=$_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
    $this->input2=$_SESSION['Ident_2']=$_REQUEST['EQNUM'];
} // New
} // End class

$inputPage=new WR2Page();
$inputPage->data_sql="SELECT wo.*,e.DESCRIPTION FROM wo LEFT JOIN equip e ON wo.EQNUM=e.EQNUM WHERE WONUM={$_SESSION['Ident_1']}";
$inputPage->flow();
?>