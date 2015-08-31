<?php
/** 
* TXID_TASK2WO: generate a WO based on TASK 
* 
* @author  Werner Huysmans
* @access  public
* @package obsolete
* @subpackage work
* @filesource
*/
DBC::execute("INSERT INTO wo (WONUM,EQNUM,TASKNUM,TASKDESC,TEXTS_A,TEXTS_B,WOTYPE,PRIORITY,ORIGINATOR,WOSTATUS,EXPENSE,REQUESTDATE,APPROVEDDATE,APPROVEDBY,SCHEDSTARTDATE) SELECT NULL,EQNUM,task.TASKNUM,DESCRIPTION,TEXTS_A,'Feedback:','PPM',2,'CMMS','P','MAINT',NOW(),NOW(),'CMMS',NEXTDUEDATE FROM taskeq LEFT JOIN task ON taskeq.TASKNUM=task.TASKNUM WHERE taskeq.TASKNUM=:tasknum AND taskeq.EQNUM=:eqnum",array("tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));
$new_wo=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
DBC::execute("INSERT INTO woop (WONUM,OPNUM,OPDESC) SELECT :wonum,OPNUM,OPDESC FROM tskop WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$pTASKNUM));
DBC::execute("INSERT INTO wocraft (WONUM,OPNUM,CRAFT,TEAM,ESTHRS) SELECT :wonum,OPNUM,CRAFT,TEAM,ESTHRS FROM tskcraft WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$pTASKNUM));
DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,QTYREQD) SELECT :wonum,ITEMNUM,QTYREQD FROM tskparts WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$pTASKNUM));
DBC::execute("INSERT INTO document_links (FILENAME,WONUM) SELECT FILENAME,:wonum FROM document_links WHERE TASKNUM=:tasknum",array("wonum"=>$new_wo,"tasknum"=>$pTASKNUM));
DBC::execute("UPDATE taskeq SET WONUM=:wonum WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("wonum"=>$new_wo,"tasknum"=>$pTASKNUM,"eqnum"=>$pEQNUM));
?>
