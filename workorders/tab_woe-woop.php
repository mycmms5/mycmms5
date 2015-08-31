<?PHP
/** 
* Planning hours for technicians based on operations 
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
require(CMMS_LIB."/class_PDO_WebCal.php");

class woePage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT woe.*,woop.OPSCHEDULE FROM woe LEFT JOIN woop ON woe.WONUM=woop.WONUM AND woe.OPNUM=woop.OPNUM WHERE woe.WONUM={$this->input1} ORDER BY OPNUM";
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
    $tpl->assign('employees',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups",PDO::FETCH_NUM));
    $tpl->assign('opnums',$DB->query("SELECT OPNUM AS 'id',OPDESC AS 'text' FROM woop WHERE WONUM='{$this->input1}'",PDO::FETCH_NUM));
    $tpl->display_error('tab_woe.tpl');    
} // EO content_page
public function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']=="0") {
                DBC::execute("DELETE FROM woe WHERE ID=:id",array("id"=>$_REQUEST['ID']));
            } else {
                DBC::execute("UPDATE woe SET WODATE=:wodate,ESTHRS=:esthrs WHERE ID=:id",array("id"=>$_REQUEST['ID'],"wodate"=>$_REQUEST['WODATE'],"esthrs"=>$_REQUEST['ESTHRS']));
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
                $wodate=DBC::fetchcolumn("SELECT OPSCHEDULE FROM woop WHERE WONUM={$_SESSION['Ident_1']} AND OPNUM={$_REQUEST['OPNUM']}",0);
                DBC::execute("INSERT INTO woe (ID,WONUM,OPNUM,EMPCODE,WODATE,ESTHRS) VALUES (NULL,:wonum,:opnum,:empcode,:wodate,:esthrs)",
                    array(
                        "wonum"=>$_SESSION['Ident_1'],
                        "opnum"=>$_REQUEST['OPNUM'],
                        "empcode"=>$_REQUEST['EMPCODE'],
                        "wodate"=>$wodate,
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

$inputPage=new woePage();
$inputPage->flow();
?>