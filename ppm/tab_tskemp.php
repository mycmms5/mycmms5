<?PHP
/** 
* Version of tab_woe in combination with WebCal
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage webcal
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @todo Use Smarty Template
* @todo Warning: there is a link to WebCalendar here !!!
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$ID=$_REQUEST['ID'];
if ($_SESSION['Ident_1']=="new") {
    require("tab_task-unsaved.php");
    exit();
}

class NewPage extends inputPageSmarty {
public function validate_form() {
    $DB=DBC::get();
    $errors = array();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM sys_groups WHERE uname='{$_REQUEST['EMPCODE']}'",0);
    if ($found==0) { $errors['WO_ERROR:EMPCODE']=_("WO:ERROR:EMPCODE_UNKNOWN"); }
    return $errors;
}            
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT tskemp.*,sg.longname FROM tskemp LEFT JOIN sys_groups sg ON tskemp.EMPCODE=sg.uname WHERE TASKNUM='{$this->input1}' ORDER BY EMPCODE";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('prestations',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('employees',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups ORDER BY uname",PDO::FETCH_NUM));
    $tpl->assign('opnums',$DB->query("SELECT OPNUM AS 'id',OPDESC AS 'text' FROM woop WHERE WONUM='{$this->input1}'",PDO::FETCH_NUM));
    $tpl->display_error('tab_tskemp.tpl');    
} // EO content_page
public function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']=="0") {
                DBC::execute("DELETE FROM tskemp WHERE ID=:id",array("id"=>$_REQUEST['ID']));
            } else {
                DBC::execute("UPDATE tskemp SET EMPCODE=:empcode, ESTHRS=:esthrs WHERE ID=:id",array("id"=>$_REQUEST['ID'],"empcode"=>$_REQUEST['EMPCODE'],"esthrs"=>$_REQUEST['ESTHRS']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']!="0") {
                DBC::execute("INSERT INTO tskemp (ID,TASKNUM,OPNUM,EMPCODE,ESTHRS) VALUES (NULL,:tasknum,:opnum,:empcode,:esthrs)",
                    array(
                        "tasknum"=>$this->input1,
                        "opnum"=>10,
                        "empcode"=>$_REQUEST['EMPCODE'],
                        "esthrs"=>$_REQUEST['ESTHRS']));
            } 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    default:
        break;                           
    }
} // End process_form} // EO process_form
} // EOF Class

$inputPage=new NewPage();
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>