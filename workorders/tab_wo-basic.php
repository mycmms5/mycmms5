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
* $Id: tab_wo-basic.php,v 1.4 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wo-basic.php,v $
* $Log: tab_wo-basic.php,v $
* Revision 1.4  2013/11/04 07:50:04  werner
* CVS version shows
*
* Revision 1.3  2013/06/08 11:43:44  werner
* Option PROJECTS re-inserted
*
* Revision 1.2  2013/05/26 07:08:29  werner
* CVS keywords inserted, no code change
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('data',$data);
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("priorities",$DB->query("SELECT PRIORITY AS id, DESCRIPTION AS text FROM wopriority",PDO::FETCH_NUM));
    $tpl->assign('wotypes',$DB->query("SELECT WOTYPE AS id, DESCRIPTION AS text FROM wotype",PDO::FETCH_NUM));
    $tpl->assign('budgets',$DB->query("SELECT EXPENSE AS id, DESCRIPTION AS text FROM expense",PDO::FETCH_NUM));
    $tpl->assign('projects',$DB->query("SELECT PROJECTID AS id, PROJECTTASK AS text FROM projects",PDO::FETCH_NUM));    
    $tpl->assign('previous_wos',$DB->query("SELECT WONUM AS id, CONCAT(WONUM,':',TASKDESC) AS text FROM wo WHERE WOTYPE='PPM' AND WOSTATUS='P'",PDO::FETCH_NUM));  
    $tpl->assign('tasks',$DB->query("SELECT te.TASKNUM,CONCAT(DESCRIPTION,':',te.TASKNUM) AS 'OPTION' FROM taskeq te LEFT JOIN task t ON te.TASKNUM=t.TASKNUM WHERE EQNUM='{$_REQUEST['EQNUM']}'"));  
    $tpl->display_error("file:tw/wo-basic.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();  
        DBC::execute("UPDATE wo SET WOPREV=:woprev,TASKDESC=:taskdesc,WOTYPE=:wotype,EXPENSE=:expense,PROJECTID=:projectid,PRIORITY=:priority,SCHEDSTARTDATE=:schedstartdate WHERE WONUM=:wonum",array("woprev"=>$_REQUEST['WOPREV'],"taskdesc"=>$_REQUEST['TASKDESC'],"wotype"=>$_REQUEST['WOTYPE'],"expense"=>$_REQUEST['EXPENSE'],"projectid"=>$_REQUEST['PROJECTID'],"priority"=>$_REQUEST['PRIORITY'],"schedstartdate"=>$_REQUEST['SCHEDSTARTDATE'],"wonum"=>$_REQUEST['id1']));
        if ($_REQUEST['EQNUM']!=$_REQUEST['OLD']) {
            DBC::execute("UPDATE wo SET EQNUM=:eqnum WHERE WONUM=:wonum",array("wonum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM']));
            DBC::execute("UPDATE wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM SET wo.EQLINE=equip.EQROOT WHERE WONUM=:wonum",array("wonum"=>$_REQUEST['id1']));
            $_SESSION['id2']=$_REQUEST['EQNUM'];  
            DBC::execute("UPDATE wo SET COMPONENT='' WHERE WONUM=:wonum",array("wonum"=>$_REQUEST['id1']));  
        }
        if ($_REQUEST['COMPONENT']!=$_REQUEST['OLD_COMP']) {
            DBC::execute("UPDATE wo SET COMPONENT=:component WHERE WONUM=:wonum",array("component"=>$_REQUEST['COMPONENT'],"wonum"=>$_REQUEST['id1']));  
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }        
} // EO process_form
} // End class

$inputPage=new thisPage();
$inputPage->version=$version;
$inputPage->data_sql="SELECT wo.*,wo.EQNUM AS OLD,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>

