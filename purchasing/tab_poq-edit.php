<?PHP
/** Edit POQuick
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2013
* @access  public
* @package purchasing
* @subpackage REMACLE
* @filesource
* @todo Integrate this in the WO tabs
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class newPage extends inputPageSmarty {
public function page_content() {
# Data
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
# template
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('combobox',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 8)<>0",PDO::FETCH_NUM));
    $tpl->assign('users1',$DB->query("SELECT uname,longname FROM sys_groups ORDER BY longname",PDO::FETCH_NUM));
    $tpl->assign('users2',$DB->query("SELECT id,CONCAT(NAME,'-',id) AS 'NAME' FROM vendors ORDER BY NAME",PDO::FETCH_NUM));
    $tpl->assign("plants",$DB->query("SELECT PLANT,DESCRIPTION FROM plants",PDO::FETCH_NUM));
    $tpl->assign("ledgers",$DB->query("SELECT GENLEDGERNUM,DESCRIPTION FROM ledger",PDO::FETCH_NUM));    
    $tpl->assign("expenses",$DB->query("SELECT EXPENSE,DESCRIPTION FROM expense",PDO::FETCH_NUM));    
    $tpl->display_error('tab_poq-edit.tpl');
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE purreq SET DESCRIPTIONONPO=:descriptiononpo,NOTES=:notes,QTYREQUESTED=:qtyrequested,USER2=:user2,USER4=:user4,USER5=:user5,USER6=:user6,STATUS='A' WHERE SEQNUM=:id1",array("descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"notes"=>$_REQUEST['NOTES'],"qtyrequested"=>$_REQUEST['QTYREQUESTED'],"user2"=>$_REQUEST['USER2'],"user4"=>$_REQUEST['USER4'],"user5"=>$_REQUEST['USER5'],"user6"=>$_REQUEST['USER6'],"id1"=>$_REQUEST['id1']));    
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }   
} // End process_form
} // End class

$inputPage=new newPage();
$inputPage->data_sql="SELECT purreq.* FROM purreq WHERE purreq.SEQNUM={$inputPage->input1}";
$inputPage->flow();


class poqeditPage extends inputPage {
public function page_content() {
} // End page_content
public function process_form() {
} // End process
} // End class
?>

