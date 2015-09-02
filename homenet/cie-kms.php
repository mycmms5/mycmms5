<?PHP
/** tab_cash_edit.php: Basic work information
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091115
* @access  public
* @package mycmms_work
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");


class CashEdit extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $reasons=array("Prospectie","ORDER","FILL-UP","Commercial","NEGOTIATION","Insurance","Tax","Maintenance");
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."smarty_base.css");
    $tpl->assign("stylesheet_calendar","../styles/calendar-win2K-1.css");
    $tpl->assign("data",$data);
    $tpl->assign("reasons",$reasons);
    $tpl->display_error("tw/cie_prokms.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO mycmms_kms (ID,FIRM,TDATE,START,END,DISTANCE,REASON,COST) VALUES (NULL,:firm,:tdate,:start,:end,:distance,:reason,:cost)",
                array("firm"=>$_REQUEST['FIRM'],"tdate"=>$_REQUEST['TDATE'],"start"=>$_REQUEST['START'],"end"=>$_REQUEST['END'],"distance"=>$_REQUEST['DISTANCE'],"reason"=>$_REQUEST['REASON'],"cost"=>$_REQUEST['COST']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else {    
            DBC::execute("UPDATE mycmms_kms SET FIRM=:firm,TDATE=:tdate,START=:start,END=:end,DISTANCE=:distance,REASON=:reason,COST=:cost WHERE ID=:id",
                array("firm"=>$_REQUEST['FIRM'],"tdate"=>$_REQUEST['TDATE'],"start"=>$_REQUEST['START'],"end"=>$_REQUEST['END'],"distance"=>$_REQUEST['DISTANCE'],"reason"=>$_REQUEST['REASON'],"cost"=>$_REQUEST['COST'],"id"=>$this->input1));
        }
        if ($_REQUEST['DISTANCE'] > 0) {
            DBC::execute("UPDATE mycmms_kms SET DCOST=DISTANCE*.3460 WHERE ID=:id",array("id"=>$this->input1));
        } else {
            DBC::execute("UPDATE mycmms_kms SET DCOST=0 WHERE ID=:id",array("id"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
}
} // End class

$inputPage=new CashEdit();
$inputPage->data_sql="SELECT * FROM mycmms_kms WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

