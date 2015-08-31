<?PHP
/** 
* PPM: Linking tasks to machines
* 
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @subpackage standard
* @filesource 
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

$OPNUM_ID=$_REQUEST['ID'];
if ($_SESSION['Ident_1']=="new") {
    require("tw/task-unsaved.php");
    exit();
}

class taskeqMachines extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    
    $sql="SELECT ID,te.EQNUM,e.DESCRIPTION,te.SCHEDTYPE,te.LASTPERFDATE FROM taskeq te LEFT JOIN equip e ON te.EQNUM=e.EQNUM WHERE te.TASKNUM='{$this->input1}'";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    $labels=array(
    "DBFLD_EQNUM"=>_("DBFLD_EQNUM"),
    "DBFLD_NUMOFDATE"=>_("DBFLD_NUMOFDATE"),
    "DBFLD_LASTPERFDATE"=>_("DBFLD_LASTPERFDATE"),
    "ADD"=>_("Add"),
    "CHANGE"=>_("Change")
    );
       
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('taskeq',$data);
    $tpl->assign('schedtypes',array('C','F','X','T'));
//    $tpl->assign('labels',$labels);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tw/taskeq-machines.tpl');    
} // End page_content
function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        if ($_REQUEST["NUMOFDATE"]==-1) {
            try {
                $DB->beginTransaction();
                # TXID_TASKEQ_DELETE
                $st=DBC::execute("DELETE FROM taskeq where TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$this->input1,"eqnum"=>$_REQUEST['EQNUM']));
                $DB->commit();
            } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
            } // EO try
        } else {
            try {
                $DB->beginTransaction();
                # TXID_TASKEQ_EDIT
                DBC::execute("UPDATE taskeq SET EQNUM=:eqnum,LASTPERFDATE=:lastperfdate,SCHEDTYPE=:schedtype WHERE ID=:id",array("id"=>$_REQUEST['ID'],"eqnum"=>$_REQUEST['EQNUM'],"lastperfdate"=>$_REQUEST['LASTPERFDATE'],"schedtype"=>$_REQUEST['SCHEDTYPE']));
                $DB->commit();
            } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
            } // EO try
        }
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            # TXID_TASKEQ_CREATE
            DBC::execute("INSERT INTO taskeq (TASKNUM,EQNUM,SCHEDTYPE,LASTPERFDATE,NEXTDUEDATE,ACTIVE) VALUES (:tasknum,:eqnum,:schedtype,:lastperfdate,:nextduedate,-1)",array("tasknum"=>$this->input1,"eqnum"=>$_REQUEST['EQNUM'],"schedtype"=>$_REQUEST['SCHEDTYPE'],"lastperfdate"=>$_REQUEST['LASTPERFDATE'],"nextduedate"=>$_REQUEST['LASTPERFDATE']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
    default:
        break;                           
    }
} // End process_form
} // End class newPage

$inputPage=new taskeqMachines();
$inputPage->version=$version; 
$inputPage->flow();
?>
