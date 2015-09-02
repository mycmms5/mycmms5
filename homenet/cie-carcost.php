<?PHP 
/** tab_work_edit.php: Basic work information
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091115
* @access  public
* @package mycmms_work
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class page extends inputPageSmarty {
public function page_content() {
    # DebugBreak();
    $year=substr($this->input1,0,4);
    $month=substr($this->input1,4,2);
    $DB=DBC::get();
    $result1=$DB->query("SELECT * FROM mycmms_kms WHERE YEAR(TDATE)={$year} AND MONTH(TDATE)={$month}");
    $kms=$result1->fetchAll(PDO::FETCH_ASSOC);
    $result2=$DB->query("SELECT * FROM cash WHERE YEAR(TDATE)={$year} AND MONTH(TDATE)={$month} AND GENLEDGER LIKE '61208%'");
    $costs=$result2->fetchAll(PDO::FETCH_ASSOC);
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("kms",$kms);
    $tpl->assign("costs",$costs);
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->display("tab_carcosts.tpl");
} // End page_content
public function process_form() {
    #No data processing
}
} // End class

$inputPage=new page();
$inputPage->flow();
?>