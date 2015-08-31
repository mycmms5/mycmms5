<?PHP
/** 
* WO planning data
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* CVS
* $Id: tab_wo-plan.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wo-plan.php,v $
* $Log: tab_wo-plan.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
* Revision 1.2  2013/04/18 07:23:13  werner
* SARALEE: handling WO Status
* SARALEE: wo changes during preparation
* Removal of TASK2WO
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

define("TX_LOG",true);
define("PREPARED",true);

if ($_SESSION['Ident_1']=="new") {
    require("tab_wo-unsaved.php");
    exit();
}

class WOPlanPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    
    switch ($data['WOSTATUS']) {
    case 'R':
        $WOSTATUS_List="'{$obj_data->WOSTATUS}'";
        $WOSTATUS_Message=_("Status APPROVE via Gatekeeper"); 
        break;
    case 'A':   // Approved --> M or P
        $WOSTATUS_List="'A','IP','M','P'"; 
        $WOSTATUS_Message=_("Preparation Phases"); 
        break;
    case 'IP':   // In Preparation -> M or P
        $WOSTATUS_List="'IP','M','P'"; 
        $WOSTATUS_Message=_("Preparation Phases"); 
        break;
    case 'M':   // Waiting --> P
        $WOSTATUS_List="'IP','M','P'";                         
        $WOSTATUS_Message=_("Status PLANNED via Planner");          
        break;
    case 'P':   // Prepared --> (back to M)
        $WOSTATUS_List="'IP','M','P'";                                   
        $WOSTATUS_Message=_("Status PLANNED via Planner");
        break;
    case 'PL':  // Planned --> (back to M,P) or PR
        $WOSTATUS_List="'M','P','PL','PR'";  
        $WOSTATUS_Message=_("Status FINISH via Technician Feedback");                                 
        break;
    case 'PR':
        $WOSTATUS_List="'PR'";  
        $WOSTATUS_Message=_("Status FINISH via Technician Feedback");                                 
        break;
    case 'F':
        $WOSTATUS_List="'{$data->WOSTATUS}'";
        $WOSTATUS_Message=_("Status CLOSE via Administrator");
        break;                    
    case 'C':
        $WOSTATUS_List="'{$data->WOSTATUS}'";
        $WOSTATUS_Message=_("Only Administrator can change this");
        break;  
    default:
        $WOSTATUS_List="'R'";
        $WOSTATUS_Message=_("Only Administrator can change this");
        break;  
    }
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    # labels
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('pageTitle',_("Maintenance Workorder")."#".$_SESSION['Ident_1']);
    $tpl->assign('WOSTATUS_Message',$WOSTATUS_Message);
    # data
    $tpl->assign('data',$data);
    $tpl->assign('preparation',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 8)<>0",PDO::FETCH_NUM));
    $tpl->assign('supervision',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 4)<>0",PDO::FETCH_NUM));
    $tpl->assign('execution',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 64)<>0",PDO::FETCH_NUM));
    $tpl->assign('wostatus',$DB->query("SELECT WOSTATUS AS id,DESCRIPTION AS text FROM wostatus WHERE WOSTATUS IN ({$WOSTATUS_List})"));
    $tpl->assign('tasklist',$DB->query("SELECT taskeq.TASKNUM AS id,CONCAT(taskeq.TASKNUM,DESCRIPTION) AS text FROM taskeq LEFT JOIN task ON taskeq.TASKNUM=task.TASKNUM WHERE EQNUM='{$data['EQNUM']}'",PDO::FETCH_NUM));
    $tpl->display_error('tw/wo-plan.tpl');
} // End page_content
public function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "STANDARD":
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE wo SET ASSIGNEDBY=:assignedby,ASSIGNEDTO=:assignedto,ASSIGNEDTECH=:assignedtech,SCHEDSTARTDATE=:schedstartdate,WOSTATUS=:wostatus,TEXTS_A=:texts_a,ESTCOST=:estcost WHERE WONUM=:wonum",array("assignedby"=>$_REQUEST['ASSIGNEDBY'],"assignedto"=>$_REQUEST['ASSIGNEDTO'],"assignedtech"=>$_REQUEST['ASSIGNEDTECH'],"schedstartdate"=>$_REQUEST['SCHEDSTART'],"wostatus"=>$_REQUEST['WOSTATUS'],"texts_a"=>$_REQUEST['PREPARATION'],"estcost"=>$_REQUEST['ESTCOST'],"wonum"=>$_REQUEST['id1']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }   
        break;
    case "ADD_OPERATION":
        $pTASKNUM="SPOELEN";
        try {
            $DB->beginTransaction();
            $LastOperation=DBC::fetchcolumn("SELECT MAX(OPNUM)+10 FROM woop WHERE WONUM='{$_REQUEST['id1']}'",0);
            DBC::execute("INSERT INTO woop (WONUM,OPNUM,OPDESC) SELECT :wonum,:opnum,OPDESC FROM tskop WHERE TASKNUM=:tasknum",array("wonum"=>$_REQUEST['id1'],"opnum"=>$LastOperation,"tasknum"=>$pTASKNUM));
            DBC::execute("INSERT INTO wocraft (WONUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :wonum,:opnum,CRAFT,TEAM,ESTHRS FROM tskcraft WHERE TASKNUM=:tasknum",array("wonum"=>$_REQUEST['id1'],"opnum"=>$LastOperation,"tasknum"=>$pTASKNUM));
            DBC::execute("INSERT INTO wodocu (WONUM,FILENAME,DESCRIPTION) SELECT :wonum,FILENAME,DESCRIPTION FROM taskdocu WHERE TASKNUM=:tasknum",array("wonum"=>$_REQUEST['id1'],"tasknum"=>$pTASKNUM));
            // DBC::execute("CALL COPY_TASK2WO_ADD('SPOELEN',:wonum,:eqnum,0)",array("wonum"=>$_REQUEST['id1'],"eqnum"=>""));
            $DB->commit();        
            return __FILE__." OK";
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
/**
* The TASK2WO and WO2TASK were moved to separate tab
     case "TASK2WO":
        $pWONUM=$this->input1;
        $pTASKNUM=$_REQUEST['TASKNUM'];
        require("TXID_TASK2WO_REPLACE.php");    
        break;
**/        
    } 
    if (TX_LOG) {
        if (($_REQUEST['ASSIGNEDBY_OLD']!=$_REQUEST['ASSIGNEDBY']) OR
            ($_REQUEST['ASSIGNEDTO_OLD']!=$_REQUEST['ASSIGNEDTO']) OR
            ($_REQUEST['WOSTATUS_OLD']!=$_REQUEST['WOSTATUS'])) {
                try {
                    $DB->beginTransaction();
                    DBC::execute("INSERT INTO wo_changes (WONUM,ASSIGNEDBY,ASSIGNEDTO,WOSTATUS,CHANGED) VALUES (:wonum,:assignedby,:assignedto,:wostatus,NOW())",
                    array("wonum"=>$_REQUEST['id1'], "assignedby"=>$_REQUEST['ASSIGNEDBY_OLD'],
                        "assignedto"=>$_REQUEST['ASSIGNEDTO'], "wostatus"=>$_REQUEST['WOSTATUS_OLD']));
                    $DB->commit();
                } catch (Exception $e) {
                    $DB->rollBack();
                    PDO_log($e);
                } 
            } // Changes were made
    } // EO TX_LOG 
    if (PREPARED) {
        if (($_REQUEST['WOSTATUS']=='P') 
            AND ($_REQUEST['WO_STATUS_OLD']!=$_REQUEST['WOSTATUS'])) {
                try {
                    $DB->beginTransaction();
                    DBC::execute("UPDATE wo SET PREPARED=NOW() WHERE WONUM=:wonum",
                        array("wonum"=>$_REQUEST['id1']));
                    $DB->commit();
                } catch (Exception $e) {
                    $DB->rollBack();
                    PDO_log($e);
                } 
            }
    }
} // End process_form
} // End class

$inputPage=new WOPlanPage();
$inputPage->version=$version;
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->calendar=true;
$inputPage->formName="treeform";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->data_sql="SELECT wo.*,equip.Description FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM LEFT JOIN wocraft ON wo.WONUM=wocraft.WONUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>
