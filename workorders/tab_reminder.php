<?PHP
/**
* Reminder input
*  
* @author  Werner Huysmans 
* @access  public
* @package BETA
* @subpackage reminders
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $obj_data=$this->get_data($this->input1,$this->input2);
    $data=(array)$obj_data;

    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('data',$data);
    $tpl->display_error('tab_reminder.tpl');    
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=='on') {
            DBC::execute("INSERT INTO reminders (ID,RESPONSIBLE,MAILFROM,SUBJECT,PRIORITY,DEADLINE,CLOSED) VALUES (null,:responsible,:mailfrom,:subject,:priority,:deadline,:closed)",
                array("responsible"=>$_REQUEST['RESPONSIBLE'],"mailfrom"=>$_REQUEST['MAILFROM'],"subject"=>$_REQUEST['SUBJECT'],"priority"=>$_REQUEST['PRIORITY'],"deadline"=>$_REQUEST['DEADLINE'],"closed"=>"2020-01-01"));        
        } else {
            DBC::execute("UPDATE reminders SET SUBJECT=:subject,MAILFROM=:mailfrom,DEADLINE=:deadline,PRIORITY=:priority,CLOSED=:closed WHERE ID=:id",
                array("subject"=>$_REQUEST['SUBJECT'],"deadline"=>$_REQUEST['DEADLINE'],"mailfrom"=>$_REQUEST['MAILFROM'],"priority"=>$_REQUEST['PRIORITY'],"closed"=>$_REQUEST['CLOSED'],"id"=>$_SESSION['Ident_1']));        
        }
            $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    } 
} // EO process_form
} // End class

$inputPage=new thisPage();
$inputPage->data_sql="SELECT * FROM reminders WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>

