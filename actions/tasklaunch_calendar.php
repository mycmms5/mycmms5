<?php
/** 
* PPM launcher:
* - Gets the tasks for (selected) machines between (selection) two dates
* - The planner can remove the selection when het doesn't want to launch the task
* - The remaining tasks will be launched
*
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @subpackage tasklaunch
* @filesource
* CVS
* $Id: tasklaunch_calendar.php,v 1.2 2013/04/17 05:59:41 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/actions/tasklaunch_calendar.php,v $
* $Log: tasklaunch_calendar.php,v $
* Revision 1.2  2013/04/17 05:59:41  werner
* Inserted CVS variables Id,Source and Log
*
*/
require("../includes/config_mycmms.inc.php");  
unset($_SESSION['PDO_ERROR']);
require("setup.php");
$tpl=new smarty_mycmms();
$tpl->assign("stylesheet",STYLE_PATH.CSS_SMARTY);
$version=__FILE__." :V5.0 Build 20150808";
$tpl->assign("version",$version); 

switch ($_REQUEST['STEP']) {
    case "1": {
        $DB=DBC::get();
        $result=$DB->query("SELECT pc.TASKNUM AS 'tasknum',pc.EQNUM AS 'eqnum',t.DESCRIPTION AS 'description',pc.PLANDATE FROM ppmcalendar pc LEFT JOIN task t ON pc.TASKNUM=t.TASKNUM WHERE PLANDATE BETWEEN '{$_REQUEST['START']}' AND '{$_REQUEST['END']}' AND pc.EQNUM LIKE '{$_REQUEST['EQNUM']}' AND pc.WONUM IS NULL");
        if ($result) {
            $tasks=$result->fetchAll(PDO::FETCH_ASSOC);
        }

        $tpl->assign("tasks",$tasks);
        $tpl->assign("step","STEP1");
        $tpl->display_error("action/tasklaunch_calendar.tpl");
        break;
        } // EO STEP1
    case "2": { 
        $DB=DBC::get();
        try{
            $DB->beginTransaction();
            DBC::execute("UPDATE ppmcalendar SET LAUNCH=-1",array());    // Reset            
            for ($c=0; $c < sizeof($_REQUEST['taskid']); $c++) {
                $taskid = split(":",$_REQUEST['taskid'][$c]);
                DBC::execute("UPDATE ppmcalendar SET LAUNCH=1 WHERE TASKNUM=:tasknum AND EQNUM=:eqnum AND PLANDATE=:plandate",array("tasknum"=>$taskid[0],"eqnum"=>$taskid[1],"plandate"=>$taskid[2]));
            } // EO for
            $result=$DB->query("SELECT pc.TASKNUM AS 'tasknum',pc.EQNUM AS 'eqnum',pc.PLANDATE AS 'PLANDATE',t.DESCRIPTION AS 'description' FROM ppmcalendar pc LEFT JOIN task t ON pc.TASKNUM=t.TASKNUM WHERE pc.LAUNCH=1 AND pc.WONUM IS NULL");
                if ($result) {
                    $tasks=$result->fetchAll(PDO::FETCH_ASSOC);
                } // EO if
            $DB->commit();                
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }        
        $tpl->assign("tasks",$tasks);
        $tpl->assign("step","STEP2");
        $tpl->display_error("action/tasklaunch_calendar.tpl");
        break;
    } // EO STEP2
    case "3":   {
        $DB=DBC::get();
        $result=$DB->query("SELECT pc.TASKNUM,pc.EQNUM,pc.PLANDATE,task.DESCRIPTION,task.TEXTS_A FROM ppmcalendar pc LEFT JOIN task ON pc.TASKNUM=task.TASKNUM WHERE pc.WONUM is NULL AND LAUNCH=1");
        if ($result) {
            foreach($result->fetchAll(PDO::FETCH_OBJ) as $task) {
            try {
                $DB->beginTransaction();
                DBC::execute("INSERT INTO wo (WONUM,EQNUM,TASKNUM,TASKDESC,TEXTS_A,WOTYPE,PRIORITY,ORIGINATOR,WOSTATUS,EXPENSE,REQUESTDATE,SCHEDSTARTDATE,APPROVEDDATE,APPROVEDBY) VALUES (NULL,:eqnum,:tasknum,:taskdesc,:texts_a,'PPM',2,'CMMS','PL','MAINT',NOW(),:schedstartdate,NOW(),'CMMS')",array("tasknum"=>$task->TASKNUM,"eqnum"=>$task->EQNUM,"taskdesc"=>$task->DESCRIPTION,"texts_a"=>$task->TEXTS_A,"schedstartdate"=>$task->PLANDATE));
                $new_wo=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                DBC::execute("INSERT INTO woop (WONUM,OPNUM,OPDESC) SELECT :wonum,OPNUM,OPDESC FROM tskop WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$task->TASKNUM));
                DBC::execute("INSERT INTO wocraft (WONUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :wonum,OPNUM,CRAFT,TEAM,ESTHRS FROM tskcraft WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$task->TASKNUM));
                DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,QTYREQD) SELECT :wonum,ITEMNUM,QTYREQD FROM tskparts WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$task->TASKNUM));
/**
* Added INSERT from woe for use with WebCalendar                
*/
                DBC::execute("INSERT INTO woe (WONUM,EMPCODE,WODATE,ESTHRS) SELECT :wonum,EMPCODE,:schedstartdate,ESTHRS FROM tskemp WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"schedstartdate"=>$task->PLANDATE,"tasknum"=>$task->TASKNUM));
                DBC::execute("INSERT INTO document_links (FILENAME,WONUM) SELECT FILENAME,:wonum FROM document_links WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$task->TASKNUM));
                // Block PPMCalendar
                DBC::execute("UPDATE ppmcalendar SET WONUM=:wonum WHERE TASKNUM=:tasknum AND EQNUM=:eqnum AND PLANDATE=:plandate",array("wonum"=>$new_wo,"eqnum"=>$task->EQNUM,"tasknum"=>$task->TASKNUM,"plandate"=>$task->PLANDATE));;
                // Block TaskEq
                DBC::execute("UPDATE taskeq SET WONUM=:wonum WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("wonum"=>$new_wo,"eqnum"=>$task->EQNUM,"tasknum"=>$task->TASKNUM));
                $DB->commit();
            } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
            }
        } // EO foreach
        } // EO result

        $result=$DB->query("SELECT pc.TASKNUM AS 'tasknum',pc.EQNUM AS 'eqnum',pc.PLANDATE AS 'PLANDATE',t.DESCRIPTION AS 'description',pc.WONUM AS 'WONUM' FROM ppmcalendar pc LEFT JOIN task t ON pc.TASKNUM=t.TASKNUM WHERE pc.LAUNCH=1");
        $tasks=$result->fetchAll(PDO::FETCH_ASSOC);
        
        $tpl->assign("tasks",$tasks);
        $tpl->assign("step","END");
        $tpl->display_error("action/tasklaunch_calendar.tpl");
        break;
    } // EO END
    default: {
        $DB=DBC::get();
        $tpl->assign("machines",$DB->query("SELECT EQLINE AS 'id',EQLINE AS 'text' FROM tbl_eqline",PDO::FETCH_NUM));
        $tpl->assign("step","FORM");
        $tpl->display_error("action/tasklaunch_calendar.tpl");
    } // EO default
}
?>
 
