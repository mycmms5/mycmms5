<?PHP
/** 
* Set SAP PO number
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2010
* @access  public
* @package purchasing
* @subpackage REMACLE
* @filesource
* @todo Integrate this in the WO tabs when we need SAP interaction
* @tpl No Smarty
* @txid 5012
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class newPage extends inputPageSmarty {
public function validate_form() {
    $errors = array();
    if (substr($_REQUEST['PONUM'],0,4)!='4500') {   $errors['NO_SAP']=_("POQuick_Error: Not a SAP PO"); } 
    return $errors;
}    
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
    $tpl->assign('users2',$DB->query("SELECT id,CONCAT(NAME,'-',id) AS 'NAME' FROM vendors ORDER BY NAME",PDO::FETCH_NUM));
    $tpl->assign('combobox',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 8)<>0",PDO::FETCH_NUM));
    try {
        $tpl->display_error('tab_poq-sap.tpl');
    } catch (exception $e) {
        trigger_error($e.message, E_ERROR);
        echo $e.message;
    } 
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE purreq SET PONUM=:ponum,STATUS='A',USER2=:user2,DUEDATE_SAP=:duedate_sap WHERE SEQNUM=:seqnum",
            array("ponum"=>$_REQUEST['PONUM'],"user2"=>$_REQUEST['USER2'],"duedate_sap"=>$_REQUEST['DUEDATE_SAP'],"seqnum"=>$_REQUEST['SEQNUM']));  
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
        trigger_error($e->getMessage(),E_WARNING);
    }   
} // End process_form
} // End class

$inputPage=new newPage();
$inputPage->data_sql="SELECT purreq.* FROM purreq WHERE purreq.SEQNUM={$inputPage->input1}";
$inputPage->flow();

/** Old code
class poqSAPPage extends inputPage {
public function page_content() {
} // End page_content
public function process_form() {
    $DB=DBC::get();
    require("TXID_5012.php");
}
} // End class
*/
?>

