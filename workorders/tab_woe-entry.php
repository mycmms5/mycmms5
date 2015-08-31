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
$version=__FILE__." :V5.0 Build 20150808";
$DB=DBC::get(); # Connection to CMMS DB
$ID=$_SESSION['Ident_1'];

class NewPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $wonum=DBC::fetchcolumn("SELECT WONUM FROM woe WHERE ID={$_SESSION['Ident_1']}",0);
    $sql="SELECT woe.*,woop.OPSCHEDULE,sys_groups.longname FROM woe 
        LEFT JOIN woop ON woe.WONUM=woop.WONUM AND woe.OPNUM=woop.OPNUM 
        LEFT JOIN sys_groups ON woe.EMPCODE=sys_groups.uname 
        WHERE woe.WONUM=$wonum ORDER BY WODATE DESC,EMPCODE";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('prestations',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('employees',$DB->query("SELECT uname AS 'id',longname AS 'text' FROM sys_groups",PDO::FETCH_NUM));
    $tpl->assign('opnums',$DB->query("SELECT OPNUM AS 'id',OPDESC AS 'text' FROM woop WHERE WONUM='{$this->input1}'",PDO::FETCH_NUM));
    $tpl->display_error('tw/woe.tpl');    
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
                $wonum=DBC::fetchcolumn("SELECT WONUM FROM woe WHERE ID={$_SESSION['Ident_1']}",0);
                DBC::execute("INSERT INTO woe (ID,WONUM,OPNUM,EMPCODE,WODATE,ESTHRS) VALUES (NULL,:wonum,:opnum,:empcode,:wodate,:esthrs)",
                    array(
                        "wonum"=>$wonum,
                        "opnum"=>10,
                        "empcode"=>$_REQUEST['EMPCODE'],
                        "wodate"=>$_REQUEST['WODATE'],
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
$inputPage->flow();
?>