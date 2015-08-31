<?php
/** 
* TXID_TASK_RESET: resets the task and recalculates the next due date. 
* 
* @author  Werner Huysmans
* @access  public
* @package work
* @subpackage feedback
* @filesource
*/
if ($_REQUEST['TASKNUM']!="NONE") {
    $pTASKNUM=$_REQUEST['TASKNUM'];
    $pEQNUM=$_REQUEST['EQNUM'];
    $schedtype=DBC::fetchcolumn("SELECT SCHEDTYPE FROM taskeq WHERE TASKNUM='{$pTASKNUM}' AND EQNUM='{$pEQNUM}'",0);
/**
* When SCHEDTYPE = floating, we STOP the TASK and calculate the next date
* When SCHEDTYPE = fixed, we do the same thing                
*/    
    if ($schedtype=="F") {
        DBC::execute("UPDATE taskeq SET WONUM=NULL,LASTPERFDATE=NOW() WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));    
        DBC::execute("UPDATE taskeq SET NEXTDUEDATE=ADDDATE(LASTPERFDATE,INTERVAL NUMOFDATE DAY) WHERE TASKNUM=:tasknum AND EQNUM=:eqnum AND NEXTDUEDATE<NOW() AND DATEUNIT='D'",array("tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));
    } // EO Floating
    if ($schedtype=="X") {
        DBC::execute("UPDATE taskeq SET WONUM=NULL,LASTPERFDATE=NOW() WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));    
        $num=DBC::fetchcolumn("SELECT CEIL(DATEDIFF(NOW(),NEXTDUEDATE)/NUMOFDATE) FROM taskeq WHERE TASKNUM='{$pTASKNUM}' AND EQNUM='{$pEQNUM}'",0);
        DBC::execute("UPDATE taskeq SET NEXTDUEDATE=ADDDATE(NEXTDUEDATE,INTERVAL (:num*NUMOFDATE) DAY) WHERE TASKNUM=:tasknum AND EQNUM=:eqnum AND NEXTDUEDATE < NOW() AND DATEUNIT='D'",array("num"=>$num,"tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));                   
    } // EO Fixed
} // If PPM task
?>
