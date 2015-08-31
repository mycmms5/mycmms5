<?php
/** 
* Feedback, RFF and PPM proposal
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @todo Review DB handling...
* CVS 
* $Id: tab_wo-feedback.php,v 1.2 2013/08/31 09:02:50 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wo-feedback.php,v $
* $Log: tab_wo-feedback.php,v $
* Revision 1.2  2013/08/31 09:02:50  werner
* CVS variable $Id
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";
if ($_SESSION['Ident_1']=="new") {
    require("tab_wo-unsaved.php");
    exit();
}

class woFeedbackCommentsRFFPage extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors=array();
    if ($_POST['NEXTACTION']=="REVISION" AND empty($_POST['NEXTWO'])) {   
            $errors['NEXTWO']=_("WO_ERROR:NEXTWO"); }
    if (empty($_POST['ASSIGNEDTECH'])) { $errors['ASSIGNEDTECH']=_("WO_ERROR:ASSIGNEDTECH"); }
    if (empty($_POST['COMMENT'])) {   $errors['COMMENT']=_("WO_ERROR:COMMENT"); }
    if ($_POST['PRIORITY']==0 AND empty($_POST['RFFCODE'])) {
        $errors['RFFCODE']=_("WO_ERROR:RFFCODE");
    }
    if ($_POST['PRIORITY']==0 AND empty($_POST['TEXTS_PPM'])) {
        // $errors['TEXTS_PPM']=_("?: Geen verbetering mogelijk");
    }
    return $errors;
} // New
public function page_content() {
    if (count($errors)) {  // New demand or adding missing information
        $data=unserialize($_SESSION['form_data']);
    } else {
        $obj_data=$this->get_data($_SESSION['Ident_1'],$_SESSION['Ident_2']);
        $data=(array)$obj_data;
    }
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('pageTitle',_("Maintenance Workorder")."#".$_SESSION['Ident_1']);
    $tpl->assign('data',$data);
    $tpl->assign('ASSIGNEDTECH',$_SESSION['user']);
    $tpl->display_error('tw/wo-feedback.tpl');
} // New
public function process_form() {
/**
* The TEXTS_B field is preceded with a date / the name of the technician
*/
    $NEW_COMMENT="<BR>\n".now2string(true)."(".$_REQUEST['ASSIGNEDTECH'].") ".$_REQUEST['COMMENT'];
    
    $DB=DBC::get();
    switch ($_REQUEST['NEXTACTION']) {
    case "INTERMEDIATE":
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO wo_assign (ID,WONUM,ASSIGNEDTECH,ENDED) VALUES (NULL,:wonum,:assignedtech,NOW())",
                array("wonum"=>$_REQUEST['id1'],
                "assignedtech"=>$_REQUEST['ASSIGNEDTECH']));
            DBC::execute("CALL WO_FEEDBACK(:texts_b,:texts_ppm,:wostatus,:completiondate,:rffcode,:wonum)",
                array("wonum"=>$_REQUEST['id1'],
                "texts_b"=>$NEW_COMMENT,
                "texts_ppm"=>$_REQUEST['TEXTS_PPM'],
                "wostatus"=>$_REQUEST['WOSTATUS'],
                "completiondate"=>'1900-01-01',                
                "rffcode"=>$_REQUEST['RFFCODE']));
            $DB->commit();        
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }  
        break;
    case "END":
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO wo_assign (ID,WONUM,ASSIGNEDTECH,ENDED) VALUES (NULL,:wonum,:assignedtech,NOW())",
                array("wonum"=>$_REQUEST['id1'],
                "assignedtech"=>$_REQUEST['ASSIGNEDTECH']));
            DBC::execute("CALL WO_FEEDBACK(:texts_b,:texts_ppm,:wostatus,:completiondate,:rffcode,:wonum)",
                array("wonum"=>$_REQUEST['id1'],
                "texts_b"=>$NEW_COMMENT,
                "texts_ppm"=>$_REQUEST['TEXTS_PPM'],
                "wostatus"=>"F",
                "completiondate"=>now2string(true),               
                "rffcode"=>$_REQUEST['RFFCODE']));
            if ($_REQUEST['TASKNUM']!="NONE") {
                DBC::execute("CALL TASKEQ_RESET(:tasknum,:eqnum)",
                    array("tasknum"=>$_REQUEST['TASKNUM'],
                    "EQNUM"=>$_REQUEST['EQNUM']));
            } 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }  
        break;
    case "REVISION":
        try {
            $DB->beginTransaction();        
            DBC::execute("INSERT INTO wo_assign (ID,WONUM,ASSIGNEDTECH,ENDED) VALUES (NULL,:wonum,:assignedtech,NOW())",
                array("wonum"=>$_REQUEST['id1'],
                "assignedtech"=>$_REQUEST['ASSIGNEDTECH']));
            DBC::execute("CALL WO_FEEDBACK(:texts_b,:texts_ppm,:wostatus,:completiondate,:rffcode,:wonum)",
                array("wonum"=>$_REQUEST['id1'],
                "texts_b"=>$NEW_COMMENT,
                "texts_ppm"=>$_REQUEST['TEXTS_PPM'],
                "wostatus"=>"F",
                "completiondate"=>now2string(true),               
                "rffcode"=>$_REQUEST['RFFCODE']));
            if ($_REQUEST['TASKNUM']!="NONE") {
                DBC::execute("CALL TASKEQ_RESET(:tasknum,:eqnum)",
                    array("tasknum"=>$_REQUEST['TASKNUM'],
                    "EQNUM"=>$_REQUEST['EQNUM']));
            } 
/** 
* Generate a follow-up WO            
*/
            switch (CMMS_DB) {
            case 'DEMB':
                $pAPPROVEDBY=DBC::fetchcolumn("SELECT approver FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
                break;
            default: 
                $pAPPROVEDBY=$_SESSION['APPROVER'];   
                break;
            } 
            DBC::execute("CALL CREATE_WR_REV(:eqnum,:taskdesc,:wotype,:originator,:priority,:approver,:texts_a,:schedstartdate,:assignedtech,:woprev)",
            array(
                "eqnum"=>$_REQUEST['EQNUM'],
                "taskdesc"=>$_REQUEST['NEXTWO'],
                "wotype"=>"REPAIR",
                "originator"=>$_SESSION['user'],
                "priority"=>"2",
                "approver"=>$pAPPROVEDBY,
                "texts_a"=>"Methode: ",
                "schedstartdate"=>now2string(false),
                "assignedtech"=>$_REQUEST['ASSIGNEDTECH'],
                "woprev"=>$_REQUEST['id1']));  
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } 
        break;
    }
/**
* Change the machine
*/
/*    if ($_REQUEST['EQNUM']!=$_REQUEST['OLD']) {
        try {
            $DB->beginTransaction();    
            DBC::execute("UPDATE wo SET EQNUM=:eqnum WHERE WONUM=:wo",array("wo"=>$pWONUM,"eqnum"=>$_REQUEST['EQNUM']));
            DBC::execute("UPDATE wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM SET wo.EQLINE=equip.EQROOT WHERE WONUM=:wonum",array("wonum"=>$pWONUM));
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } 
    } // EO if
*/    
} // process_form
} // End class

$inputPage=new woFeedbackCommentsRFFPage();
$inputPage->version=$version;
$inputPage->pageTitle=_("Maintenance Workorder")."#".$_SESSION['Ident_1'];
$inputPage->contentTitle="";
$inputPage->formName="treeform";
$inputPage->calendar=false;
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2="";
$inputPage->data_sql="SELECT wo.*,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>
