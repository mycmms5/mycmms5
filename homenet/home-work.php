<?PHP 
/** tab_work_edit.php: Basic work information
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091115
* @access  public
* @package mycmms_work
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class WorkEdit extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $types=array("REPAIR","PROJECT","MAINTENANCE");
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("types",$types);    
    $tpl->display("tab_work.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO wo (WONUM,EQNUM,REQUESTDATE,TASKDESC,TEXTS,ORIGINATOR,WOTYPE,CLOSEDATE,COMPLETIONDATE,APPROVEDBY,WOSTATUS) VALUES (NULL,:eqnum,:requestdate,:taskdesc,:texts,'HUYSMANS',:wotype,'1900-01-01','1900-01-01','CMMS_HOME','PR')",array("eqnum"=>$_REQUEST['EQNUM'],"requestdate"=>$_REQUEST['REQUESTDATE'],"taskdesc"=>$_REQUEST['TASKDESC'],"texts"=>$_REQUEST['TEXTS'],"wotype"=>$_REQUEST['WOTYPE']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else {    
            DBC::execute("UPDATE wo SET TASKDESC=:taskdesc,TEXTS=:texts,REQUESTDATE=:requestdate,EQNUM=:eqnum WHERE WONUM=:id1",array("taskdesc"=>$_REQUEST['TASKDESC'],"texts"=>$_REQUEST['TEXTS'],"requestdate"=>$_REQUEST['REQUESTDATE'],"eqnum"=>$_REQUEST["EQNUM"],"id1"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}
} // End class

$inputPage=new WorkEdit();
$inputPage->data_sql="SELECT wo.*,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>