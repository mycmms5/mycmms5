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
    $tx_types=array("TVA due","TVA to receive","Payment","PrePay","Other");
    $quarters=array("2009Q4",
        "2010Q1","2010Q2","2010Q3","2010Q4",
        "2011Q1","2011Q2","2011Q3","2011Q4",
        "2012Q1","2012Q2","2012Q3","2012Q4",
        "2013Q1","2013Q2","2013Q3","2013Q4",
        "2014Q1","2014Q2","2014Q3","2014Q4");
    $DB=DBC::get();
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("tx_types",$tx_types);
    $tpl->assign("quarters",$quarters);
    $tpl->assign("origins",$origins);
    $tpl->display("tab_tva.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
#            DBC::execute("INSERT INTO cash (ID,FIRM,QUARTER,TDATE,COMMENT,EXPENSES,REVENUES,VAT,VATRATE,TYPE,GENLEDGER,ORIGIN) VALUES (NULL,:firm,:quarter,:tdate,:comment,:expenses,:revenues,:vat,:vatrate,:type,:genledger,:origin)",array("firm"=>$_REQUEST['FIRM'],"quarter"=>$_REQUEST["QUARTER"],"tdate"=>$_REQUEST['TDATE'],"comment"=>$_REQUEST['COMMENT'],"expenses"=>$_REQUEST['EXPENSES'],"revenues"=>$_REQUEST['REVENUES'],"vat"=>$_REQUEST['VAT'],"vatrate"=>$_REQUEST['VATRATE'],"type"=>$_REQUEST['TYPE'],"genledger"=>$_REQUEST['GENLEDGER'],"origin"=>$_REQUEST['ORIGIN']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else {    
            DBC::execute("UPDATE tva SET type=:type,type2=:type2,comment=:comment,txdate=:txdate,YYYYQQ=:YYYYQQ,payment=:payment,solde=:solde WHERE ID=:id",array("type"=>$_REQUEST['type'],"type2"=>$_REQUEST['type2'],"comment"=>$_REQUEST['comment'],"txdate"=>$_REQUEST['txdate'],"YYYYQQ"=>$_REQUEST['YYYYQQ'],"payment"=>$_REQUEST['payment'],"solde"=>$_REQUEST['solde'],"id"=>$this->input1));
        }        
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}
} // End class

$inputPage=new CashEdit();
$inputPage->data_sql="SELECT * FROM tva WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

