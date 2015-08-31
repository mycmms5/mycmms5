<?PHP
/** 
* Capture parts with a barcode scanner
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback_barcode
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* @todo Use Smarty template
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class woeBarcodePage extends inputPageSmarty {
public function validate_form() {
    $errors = array();
    if (substr($_REQUEST['BARCODE'],0,1)!="M") { $errors['BARCODE']=_("BARCODE Invalid: Not an employee number"); } 
    return $errors;
}    
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT woe.*,sys_groups.longname FROM woe LEFT JOIN sys_groups ON woe.EMPCODE=sys_groups.uname WHERE woe.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
      
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('data',$data);
    $tpl->display_error('tab_woe_barcode.tpl');       
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try{
        $DB->beginTransaction();
        DBC::execute("INSERT INTO woe (WONUM,EMPCODE,WODATE,ESTHRS,REGHRS) VALUES (:wonum,:empcode,NOW(),0,:reghrs)",array("wonum"=>$_SESSION['Ident_1'],"empcode"=>$_REQUEST['BARCODE'],"reghrs"=>$_REQUEST['REGHRS']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  
} // EO process_form
} // End class

$inputPage=new woeBarcodePage();
$inputPage->data_sql="SELECT * FROM woe WHERE woe.WONUM={$inputPage->input1}";
$inputPage->flow();
?>

