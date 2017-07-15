<?PHP
/** 
* Urgent Work Request Smarty format
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage request
* @filesource
* 
* CVS
* $Id: tab_wr0.php,v 1.3 2013/08/30 15:09:00 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wr0.php,v $
* $Log: tab_wr0.php,v $
* Revision 1.3  2013/08/30 15:09:00  werner
* CVS variable $Id
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class WR0Page extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    if ($_SESSION['Ident_1']!="new") { $errors['NO_NEW']=_("WO_ERROR:")._("WO already made"); }
    if (empty($_REQUEST['TASKDESC'])) { $errors['TASKDESC']=_("WO_ERROR:")._("No description of job"); }
    if (empty($_REQUEST['EQNUM'])) { $errors['EQNUM']=_("WO_ERROR:").("No EQNUM indicated"); }
/**
* The given EQNUM must exist!
*/
    $DB=DBC::get();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
    if ($found == 0) { $errors['EQNUM']=_("WO_ERROR:EQNUM");   }
#    if ($_REQUEST['PRIORITY']=="") { $errors['PRIORITY']=_("WO_ERROR:PRIORITY"); }
#    if ($_REQUEST['WOTYPE']=="") { $errors['WOTYPE']=_("WO_ERROR:WOTYPE"); }
    return $errors;
} // New
public function page_content() {
    $DB=DBC::get();
    if ($_SESSION['Ident_1']=="new") {  // New demand or adding missing information
        $data=unserialize($_SESSION['form_data']);
    } 
    if ($_SESSION['Ident_1']>1) {  
        $obj_data=$this->get_data($_SESSION['Ident_1'],$_SESSION['Ident_2']);
        $data=(array)$obj_data;
    }
        
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign('data',$data);
    # $tpl->assign('originators',$DB->query("SELECT uname as id, longname as text FROM sys_groups ORDER BY uname",PDO::FETCH_NUM));
    $tpl->assign('originator_preset',$_SESSION['user']);
    $tpl->assign('priorities',$DB->query("SELECT PRIORITY AS id, DESCRIPTION AS text FROM wopriority WHERE PRIORITY IN (0,1,9)",PDO::FETCH_NUM));
    $tpl->assign('wotypes',$DB->query("SELECT WOTYPE AS id,DESCRIPTION AS text FROM wotype WHERE WOTYPE IN ('REPAIR','ADJUST')",PDO::FETCH_NUM));
    $tpl->display_error($this->template);
} // New
public function process_form() {
    // Resetting the values
    unset($_SESSION['form_data']);
    $pEQNUM=$_REQUEST['EQNUM'];$pTASKDESC=$_REQUEST['TASKDESC'];$pORIGINATOR=$_SESSION['user'];
    $pWOTYPE=$_REQUEST['WOTYPE'];$pEXPENSE=$_REQUEST['EXPENSE'];$pPRIORITY=$_REQUEST['PRIORITY'];
    // Fixed values for URGENT work
    $pWOPREV=0;$pTASKNUM="NONE";$pAPPROVEDBY="CMMS";$pTEXTS_A="No Preparation";$pWOSTATUS="PR";
    $pAPPROVEDDATE=now2string(true);
    $DB=DBC::get();
    if ($_SESSION['Ident_1']!="new") { return 0; } // Only NEW
    try {
        $DB->beginTransaction();
/**
* Create a new WO:
* - fixed values : WOTYPE='REPAIR', EXPENSE='MAINT'
* - TEXTS_B='Feedback' 
* - CLOSEDATE and COMPLETIONDATE='1900-01-01'        
*/
        DBC::execute("INSERT INTO wo (WONUM,EQNUM,WOPREV,REQUESTDATE,TASKNUM,TASKDESC,TEXTS_A,TEXTS_B,ORIGINATOR,WOTYPE, EXPENSE,PRIORITY,CLOSEDATE,COMPLETIONDATE,SCHEDSTARTDATE,APPROVEDBY,APPROVEDDATE,WOSTATUS) 
        VALUES (NULL,:eqnum,:woprev,NOW(),'NONE',:taskdesc,:methods,'Feedback',:originator,'REPAIR','MAINT','0','1900-01-01','1900-01-01',NOW(),:approvedby,:approveddate,:wostatus)",
        array("eqnum"=>$pEQNUM,"woprev"=>$pWOPREV,"taskdesc"=>$pTASKDESC,"methods"=>$pTEXTS_A,"originator"=>$pORIGINATOR,"approvedby"=>$pAPPROVEDBY,"approveddate"=>$pAPPROVEDDATE,"wostatus"=>$pWOSTATUS));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  
    $this->input1=$_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
    $this->input2=$_SESSION['Ident_2']=$_REQUEST['EQNUM'];
} // New
} // End class

$inputPage=new WR0Page();
$inputPage->data_sql="SELECT wo.*,e.DESCRIPTION FROM wo LEFT JOIN equip e ON wo.EQNUM=e.EQNUM WHERE WONUM={$_SESSION['Ident_1']}";
$inputPage->flow();
?>
