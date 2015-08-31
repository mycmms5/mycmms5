<?PHP
/** 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @done removed the WEBCAL connection
* CVS
* $Id: tab_woe.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_woe.php,v $
* $Log: tab_woe.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
* Revision 1.2  2013/05/12 08:26:05  werner
* + validate_form()
* check existence EMPCODE and return PDO_ERROR
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class woePage extends inputPageSmarty {
public function validate_form() {
    $DB=DBC::get();
    $errors = array();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM sys_groups WHERE uname='{$_REQUEST['EMPCODE']}'",0);
    if ($found==0) { $errors['WO_ERROR:EMPCODE']=_("WO:ERROR:EMPCODE_UNKNOWN"); }
    return $errors;
}        
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT woe.*,woop.OPSCHEDULE,sys_groups.longname FROM woe 
        LEFT JOIN woop ON woe.WONUM=woop.WONUM AND woe.OPNUM=woop.OPNUM 
        LEFT JOIN sys_groups ON woe.EMPCODE=sys_groups.uname 
        WHERE woe.WONUM={$this->input1} ORDER BY OPNUM";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('version',"$Id: tab_woe.php,v 1.3 2013/11/04 07:50:04 werner Exp $");
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
                DBC::execute("INSERT INTO woe (ID,WONUM,OPNUM,EMPCODE,WODATE,ESTHRS) VALUES (NULL,:wonum,10,:empcode,:wodate,:esthrs)",
                    array(
                        "wonum"=>$_SESSION['Ident_1'],
                        "empcode"=>$_REQUEST['EMPCODE'],
                        "wodate"=>$_REQUEST['WODATE'],
                        "esthrs"=>$_REQUEST['ESTHRS']));
            } 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
    default:
        break;                           
    }
} // End process_form} // EO process_form
} // EOF Class

$inputPage=new woePage();
$inputPage->version=$version;
$inputPage->flow();
?>