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

if ($_SESSION['Ident_1']=="new") {
    require("wo-unsaved.php");
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
    $tpl->display_error($this->template);
} // New
public function process_form() {
/**
* The TEXTS_B field is preceded with a date / the name of the technician
*/
    $NEW_COMMENT="<BR>\n".now2string(true)."(".$_REQUEST['ASSIGNEDTECH'].") ".$_REQUEST['COMMENT'];
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO wo_assign (ID,WONUM,ASSIGNEDTECH,ENDED) VALUES (NULL,:wonum,:assignedtech,NOW())",
            array("wonum"=>$_REQUEST['id1'],"assignedtech"=>$_REQUEST['ASSIGNEDTECH']));
        DBC::execute("UPDATE wo SET TEXTS_B=CONCAT(TEXTS_B,:texts_b),TEXTS_PPM=:texts_ppm,WOSTATUS=:wostatus,COMPLETIONDATE=:completiondate,RFFCODE=:rffcode WHERE WONUM=:wonum",
            array("wonum"=>$_REQUEST['id1'],
                "texts_b"=>$NEW_COMMENT,
                "texts_ppm"=>$_REQUEST['TEXTS_PPM'],
                "wostatus"=>$_REQUEST['WOSTATUS'],
                "completiondate"=>'1900-01-01',                
                "rffcode"=>$_REQUEST['RFFCODE']));
        switch ($_REQUEST['NEXTACTION']) {
        case "INTERMEDIATE":
            break;
        case "END":
            DBC::execute("UPDATE wo SET WOSTATUS='F',COMPLETIONDATE=NOW() WHERE WONUM=:wonum",array("wonum"=>$this->input1));
            if ($_REQUEST['TASKNUM']!="NONE") {
                DBC::execute("UPDATE taskeq SET WONUM=NULL,LASTPERFDATE=NOW() WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",
                    array("tasknum"=>$_REQUEST['TASKNUM'],"EQNUM"=>$_REQUEST['EQNUM']));
            } // EO Task RESET
            break;
        case "REVISION": 
            DBC::execute("UPDATE wo SET WOSTATUS='F',COMPLETIONDATE=NOW() WHERE WONUM=:wonum",array("wonum"=>$this->input1));
            if ($_REQUEST['TASKNUM']!="NONE") {
                DBC::execute("UPDATE taskeq SET WONUM=NULL,LASTPERFDATE=NOW() WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",
                    array("tasknum"=>$_REQUEST['TASKNUM'],"EQNUM"=>$_REQUEST['EQNUM']));
            } // EO Task RESET
            # $APPROVEDBY=DBC::fetchcolumn("SELECT approver FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
            $APPROVEDBY=$_SESSION['APPROVER'];   
            DBC::execute("INSERT INTO wo (WONUM,EQNUM,WOPREV,APPROVEDBY,REQUESTDATE,TASKNUM,TASKDESC,   ORIGINATOR,PRIORITY,WOTYPE,EXPENSE,WOSTATUS) VALUES (NULL,:eqnum,:prevwo,:approvedby,   NOW(),'NONE',:taskdesc,:originator,2,'REPAIR','MAINTENANCE','R')",
                array(
                "eqnum"=>$_REQUEST['EQNUM'],
                "prevwo"=>$_REQUEST['id1'],
                "approvedby"=>$APPROVEDBY,
                "taskdesc"=>$_REQUEST['NEXTWO'],
                "originator"=>$_SESSION['user']));   
            $revwo=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            DebugBreak();
            DBC::execute("UPDATE wo SET WONEXT=:revwo WHERE WONUM=:wonum",array("revwo"=>$revwo,"wonum"=>$this->input1));
            break;
        }//EO switch
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
    }  
} // process_form
} // End class

$inputPage=new woFeedbackCommentsRFFPage();
$inputPage->data_sql="SELECT wo.*,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>
