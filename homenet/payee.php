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
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    $tx=$DB->query("SELECT * FROM money WHERE PAYTO='{$this->input2}' ORDER BY TXDATE DESC",PDO::FETCH_ASSOC);
    $turnover=DBC::fetchcolumn("SELECT SUM(AMOUNT) FROM money WHERE PAYTO='{$this->input2}'",0);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."smarty_base.css");
    $tpl->assign("data",$data);
    $tpl->assign("tx",$tx);
    $tpl->assign("turnover",$turnover);
    $tpl->display_error("tw/payee.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO tbl_payees (ID,CONTACT,TYPE,LOCATION) VALUES (NULL,:contact,:type,:location)",
                array("contact"=>$_REQUEST['CONTACT'],"type"=>$_REQUEST['TYPE'],"location"=>$_REQUEST['LOCATION']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else if ($_REQUEST['delete']=="Delete") {
            DBC::execute("DELETE FROM tbl_payees WHERE ID=:id",
                array("id"=>$this->input1));
            
        } else {    
            DBC::execute("UPDATE tbl_payees SET CONTACT=:contact,TYPE=:type,LOCATION=:location WHERE ID=:id",
                array("contact"=>$_REQUEST['CONTACT'],"type"=>$_REQUEST['TYPE'],"location"=>$_REQUEST['LOCATION'],"id"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
}
} // End class

$inputPage=new CashEdit();
$inputPage->data_sql="SELECT * FROM tbl_payees WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

