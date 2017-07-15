<?PHP
/** 
* Reporting worked hours
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback
* @link http://localhost/_documentation/mycmms40_lib/
* @filesource
* CVS
* $Id: tab_woe-feedback.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_woe-feedback.php,v $
* $Log: tab_woe-feedback.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

if ($_SESSION['Ident_1']=="new") {
    require("wo-unsaved.php");
    exit();
}

class woeWorkedHoursPage extends inputPageSmarty {
public function validate_form() {
    $DB=DBC::get();
    $errors = array();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM sys_groups WHERE uname='{$_REQUEST['EMPCODE']}'",0);
    if ($found==0) { $errors['WO_ERROR:EMPCODE']=_("WO:ERROR:EMPCODE_UNKNOWN"); }
    return $errors;
}    
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT woe.ID,woe.EMPCODE,woe.WODATE,woe.ESTHRS,woe.REGHRS,sys_groups.longname FROM woe 
        LEFT JOIN sys_groups ON woe.EMPCODE=sys_groups.uname 
        WHERE woe.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('workedhours',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('names',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups WHERE (profile & 64)<>0",PDO::FETCH_NUM));
    $tpl->assign('names2',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups WHERE (profile & 64)<>0",PDO::FETCH_NUM));
    $tpl->display_error($this->template);        
}
private function updateRecord($data) {
    $DB=DBC::get();
    try{
        $DB->beginTransaction();
        DBC::execute("UPDATE woe SET REGHRS=:reghrs WHERE ID=:id",array("id"=>$data['ID'],"reghrs"=>$data['REGHRS']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  
} // End updateRecord
private function insertRecord() {
    $DB=DBC::get();
    try{
        $DB->beginTransaction();
        DBC::execute("INSERT INTO woe (WONUM,EMPCODE,OPNUM,WODATE,ESTHRS,REGHRS) VALUES (:wonum,:empcode,10,:wodate,0,:reghrs)",array("wonum"=>$_SESSION['Ident_1'],"empcode"=>$_REQUEST['EMPCODE'],"wodate"=>$_REQUEST['WODATE'],"reghrs"=>$_REQUEST['REGHRS']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
} // End insertRecord
function process_form() {   // Only Updating...
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        $this->updateRecord($_REQUEST);        
        break;
    case "INSERT":
        $this->insertRecord($_REQUEST);
        break;
    default:
        break;                           
    }
} // End process_form
} // End of class

$inputPage=new woeWorkedHoursPage();
$inputPage->flow();
?>