<?PHP
/** 
* Quick PO request - used in lean organizations
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package purchasing
* @subpackage REMACLE
* @todo Integrate this directly into wo tabmenu
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class newPage extends inputPageSmarty {
public function page_content() {
# Data
    $DB=DBC::get();
//    $data=$this->get_data($this->input1,$this->input2);
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('users1',$DB->query("SELECT uname,longname FROM sys_groups ORDER BY longname",PDO::FETCH_NUM));
    $tpl->assign('users2',$DB->query("SELECT id,CONCAT(NAME,'-',id) AS 'NAME' FROM vendors ORDER BY NAME",PDO::FETCH_NUM));
    $tpl->assign("plants",$DB->query("SELECT PLANT,DESCRIPTION FROM plants",PDO::FETCH_NUM));
    $tpl->assign("ledgers",$DB->query("SELECT GENLEDGERNUM,DESCRIPTION FROM ledger",PDO::FETCH_NUM));    
    $tpl->assign("expenses",$DB->query("SELECT EXPENSE,DESCRIPTION FROM expense",PDO::FETCH_NUM));    
    $tpl->display_error('po-quick.tpl');
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO purreq (DESCRIPTIONONPO,NOTES,USER1,USER2,USER3,DATEGENERATED,DUEDATE,DUEDATE_SAP,QTYREQUESTED,QTYRECEIVED,PONUM,USER4,USER5,USER6,STATUS) VALUES (:descriptiononpo,:notes,:user1,:user2,:user3,NOW(),:duedate,:duedate,:qtyrequested,0,0,:user4,:user5,:user6,'R')",array("descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"notes"=>$_REQUEST['NOTES'],"user1"=>$_REQUEST['USER1'],"user2"=>$_SESSION['user'],"user3"=>$SuperID,"duedate"=>$_REQUEST['DUEDATE'],"qtyrequested"=>$_REQUEST['QTYREQUESTED'],"user4"=>$_REQUEST['USER4'],"user5"=>$_REQUEST['USER5'],"user6"=>$_REQUEST['USER6']));
        $new_poline=DBC::fetchcolumns("SELECT LAST_INSERT_ID()",0);        
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }    
} // End process_form
} // End class

$inputPage=new newPage();
$inputPage->data_sql="";
$inputPage->flow();
?>
