<?PHP
/** 
* Edit Work Order classification data
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @done Reviewed 20130126
* 
* CVS
* $Id: tab_task-wo.php,v 1.1 2013/11/04 07:56:28 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/ppm/tab_task-wo.php,v $
* $Log: tab_task-wo.php,v $
* Revision 1.1  2013/11/04 07:56:28  werner
* NEW task --> WO
*
* Revision 1.5  2013/09/07 16:38:47  werner
* CVS variable $Id
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class thisPage extends inputPageSmarty {
public function validate_form() {
    $errors=array();
    if ($_REQUEST['ACTION']=="WO2TASK") {
        $found=DBC::fetchcolumn("SELECT COUNT(*) FROM task WHERE TASKNUM='{$_REQUEST['TASKNUM']}'",0);
        if ($found!=0) {
            $errors['WO2TASK']=_("WO2TASK_ERROR:Task already exists");
        } 
        if(empty($_REQUEST['TASKNUM'])) {
            $errors['WO2TASK']=_("WO2TASK_ERROR:TASKNUM cannot be empty");
        }
    }
    if ($_REQUEST['ACTION']=="TASK2WO") {    
       if (empty($_REQUEST['TASKNUM'])) {
           $errors['TASK2WO']=_("TASK2WO_ERROR: Task cannot be empty");
       }
    }
    if ($_REQUEST['ACTION']=="WO2WO") {   
        if (empty($_REQUEST['WONUM_NEW']) AND $_REQUEST['NEWWO']!="on") {
            $errors['WO2WO']=_("WO2WO_ERROR: WONUM cannot be empty");
        }
        if (!empty($_REQUEST['WONUM_NEW']) AND $_REQUEST['NEWWO']!="on") {
            $found=DBC::fetchcolumn("SELECT COUNT(*) FROM wo WHERE WONUM='{$_REQUEST['WONUM_NEW']}'",0);
            if ($found==0) {
                $errors['WO2WO']=_("WO2WO_ERROR: WO doesn't exist");
            }
        }
        if (!empty($_REQUEST['WONUM_NEW']) AND $_REQUEST['NEWWO']=="on") {
            $errors['WO2WO']=_("WO2WO_ERROR: Create NEW WO <> WONUM indicated");
        }
    } // EO WO2WO
    return $errors;
}
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->display_error("tw/task-wo.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "TASK2WO":
        try {
            $DB->beginTransaction(); 
            $param_WONUM=$_REQUEST['WONUM']; $param_TASKNUM=$_REQUEST['TASKNUM']; $param_TASKDESC=$_REQUEST['TASKDESC'];
            DBC::execute("UPDATE wo SET TEXTS_A='No Methods' WHERE WONUM=:wonum AND TEXTS_A IS NULL",array("wonum"=>$param_WONUM));
/** 
* Generate new TASK                
*/
            DBC::execute("INSERT INTO task (TASKNUM,DESCRIPTION,WOTYPE,TEXTS_A,LASTEDITDATE) SELECT :tasknum,:description,'PPM',TEXTS_A,NOW() FROM wo WHERE WONUM=:wonum",
                array("tasknum"=>$param_TASKNUM,"description"=>$param_TASKDESC,"wonum"=>$param_WONUM));
            DBC::execute("INSERT INTO tskop (TASKNUM,OPNUM,OPDESC) SELECT :tasknum,OPNUM,OPDESC FROM woop WHERE WONUM=:wonum",
                array("tasknum"=>$param_TASKNUM,"wonum"=>$param_WONUM));
            DBC::execute("INSERT INTO tskcraft (TASKNUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :tasknum,OPNUM,CRAFT,TEAM,ESTHRS FROM wocraft WHERE WONUM=:wonum",
                array("tasknum"=>$param_TASKNUM,"wonum"=>$param_WONUM));
            DBC::execute("INSERT INTO tskparts (TASKNUM,ITEMNUM,QTYREQD) SELECT DISTINCT :tasknum,ITEMNUM,QTYREQD FROM wop WHERE WONUM=:wonum AND QTYREQD IS NOT NULL",
                array("tasknum"=>$param_TASKNUM,"wonum"=>$param_WONUM));
/**
* No hours are assigned                 
*/
            DBC::execute("INSERT INTO document_links (FILENAME,TASKNUM) SELECT FILENAME,:tasknum FROM document_links WHERE WONUM=:wonum",
                array("tasknum"=>$param_TASKNUM,"wonum"=>$param_WONUM)); 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }        
        break;
        case "TASK2WO":        
            try {
                $DB->beginTransaction();  
                $param_WONUM=$_REQUEST['WONUM']; $param_TASKNUM=$_REQUEST['TASKNUM'];
                DBC::execute("DELETE FROM woop WHERE WONUM=:wonum",array("wonum"=>$param_WONUM));
                DBC::execute("DELETE FROM wocraft WHERE WONUM=:wonum",array("wonum"=>$param_WONUM));
                DBC::execute("DELETE FROM wop WHERE WONUM=:wonum",array("wonum"=>$param_WONUM));
                DBC::execute("DELETE FROM document_links WHERE WONUM=:wonum",array("wonum"=>$param_WONUM));
                DBC::execute("UPDATE wo SET TASKNUM=:tasknum WHERE WONUM=:wonum",array("wonum"=>$param_WONUM,"tasknum"=>$param_TASKNUM));
                DBC::execute("INSERT INTO woop (WONUM,OPNUM,OPDESC) SELECT :wonum,OPNUM,OPDESC FROM tskop WHERE TASKNUM=:tasknum",array("wonum"=>$param_WONUM,"tasknum"=>$param_TASKNUM));
                DBC::execute("INSERT INTO wocraft (WONUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :wonum,OPNUM,CRAFT,TEAM,ESTHRS FROM tskcraft WHERE TASKNUM=:tasknum",array("wonum"=>$param_WONUM,"tasknum"=>$param_TASKNUM));
                DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,QTYREQD) SELECT :wonum,ITEMNUM,QTYREQD FROM tskparts WHERE TASKNUM=:tasknum",array("wonum"=>$param_WONUM,"tasknum"=>$param_TASKNUM));
                DBC::execute("INSERT INTO document_links (FILENAME,WONUM) SELECT FILENAME,:wonum FROM document_links WHERE TASKNUM=:tasknum",array("wonum"=>$param_WONUM,"tasknum"=>$param_TASKNUM));
                $DB->commit();
            } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
            }
            break;
        case "WO2WO":
            try {
                $DB->beginTransaction();
                $param_WONUM=$_REQUEST['WONUM'];$param_WONUM_NEW=$_REQUEST['WONUM_NEW'];
/**
* Generate a new WO based on the this WO        
*/
                if ($_REQUEST['NEWWO']=='on') {
                    $taskdesc=DBC::fetchcolumn("SELECT TASKDESC FROM wo WHERE WONUM='{$this->input1}'");
                    $texts_a =DBC::fetchcolumn("SELECT TEXTS_A FROM wo WHERE WONUM='{$this->input1}'");
                    DBC::execute("INSERT INTO wo (WONUM,EQNUM,WOPREV,REQUESTDATE,TASKNUM,TASKDESC,TEXTS_A,TEXTS_B,ORIGINATOR,WOTYPE, EXPENSE,PRIORITY,CLOSEDATE,COMPLETIONDATE,SCHEDSTARTDATE,APPROVEDBY,APPROVEDDATE,WOSTATUS) 
                    VALUES (NULL,:eqnum,0,NOW(),'NONE',:taskdesc,:texts_a,'Feedback',:originator,'REPAIR','MAINT','2','1900-01-01','1900-01-01',NOW(),:approvedby,'1900-01-01','R')",
                    array("eqnum"=>$this->input2,"taskdesc"=>$taskdesc,"texts_a"=>$texts_a,"originator"=>$_SESSION['user'],"approvedby"=>$_SESSION['APPROVER']));
                    $new_wo=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0); 
                    $param_WONUM_NEW=$new_wo;      
                    $result=$DB->query("SELECT * FROM wo WHERE WONUM='{$param_WONUM}'");
                    $data=$result->fetch(PDO::FETCH_ASSOC);   
                    DBC::execute("UPDATE wo SET TASKDESC=:taskdesc,TEXTS_A=:texts_a,WOTYPE=:wotype,EXPENSE=:expense,PRIORITY=:priority 
                        WHERE wo.WONUM=:newwo",
                        array("taskdesc"=>$data['TASKDESC'],"texts_a"=>$data['TEXTS_A'],
                            "wotype"=>$data['WOTYPE'],"expense"=>$data['EXPENSE'],"priority"=>$data['PRIORITY'],
                            "newwo"=>$param_WONUM_NEW));
                } else {
/**
* Fetch an existing WO
*/
/**
* Clean the existing WO before inserting the new information
*/          
                    DBC::execute("DELETE FROM woop WHERE WONUM=:wonum",array("wonum"=>$param_WONUM_NEW));
                    DBC::execute("DELETE FROM wocraft WHERE WONUM=:wonum",array("wonum"=>$param_WONUM_NEW));
                    DBC::execute("DELETE FROM wop WHERE WONUM=:wonum",array("wonum"=>$param_WONUM_NEW));
                    DBC::execute("DELETE FROM document_links WHERE WONUM=:wonum",array("wonum"=>$param_WONUM_NEW));
/**
* Get all information from existing WO and copy into new WO
*/
                    $texts_a=DBC::fetchcolumn("SELECT TEXTS_A FROM wo WHERE WONUM=$param_WONUM",0);
                    DBC::execute("UPDATE wo SET TEXTS_A=:texts_a WHERE WONUM=:wonum_new",array("wonum_new"=>$param_WONUM_NEW,"texts_a"=>$texts_a));
                    } // EO else 
                DBC::execute("INSERT INTO woop (WONUM,OPNUM,OPDESC) SELECT :wonum_new,OPNUM,OPDESC FROM woop WHERE WONUM=:wonum",
                    array("wonum"=>$param_WONUM,"wonum_new"=>$param_WONUM_NEW));
                DBC::execute("INSERT INTO wocraft (WONUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :wonum_new,OPNUM,CRAFT,TEAM,ESTHRS FROM wocraft WHERE WONUM=:wonum",
                    array("wonum"=>$param_WONUM,"wonum_new"=>$param_WONUM_NEW));
                DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,QTYREQD) SELECT :wonum_new,ITEMNUM,QTYREQD FROM wop WHERE WONUM=:wonum",
                    array("wonum"=>$param_WONUM,"wonum_new"=>$param_WONUM_NEW));
                DBC::execute("INSERT INTO document_links (FILENAME,WONUM) SELECT FILENAME,:wonum_new FROM document_links WHERE WONUM=:wonum",
                    array("wonum"=>$param_WONUM,"wonum_new"=>$param_WONUM_NEW));
                $DB->commit();
            } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
            }
            break;            
        } // EO switch
     
} // EO process_form
} // End class

$inputPage=new thisPage();
$inputPage->data_sql="SELECT task.*,taskeq.* FROM task 
    LEFT JOIN taskeq ON task.TASKNUM=taskeq.TASKNUM 
    WHERE task.TASKNUM='{$inputPage->input1}' AND taskeq.EQNUM='{$inputPage->input2}'";
$inputPage->flow();
?>

