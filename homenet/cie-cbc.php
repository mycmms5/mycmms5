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
    $tx_types=array("TVA","RSZ","Facture","Couts","Investissement","Auto");
    $origins=array("B","NL","USA","GE");
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
    $tpl->assign("genledgers",$DB->query("SELECT GENLEDGER AS id, CONCAT('<b>',GENLEDGER,'</b>:',DESCRIPTION) AS text FROM genledger WHERE ACTIVE='A' ORDER BY GENLEDGER",PDO::FETCH_NUM));
    $tpl->display("tw/cie_cbc.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO cbcpro (ID,TXDATE,TX,AMOUNT) VALUES (NULL,:txdate,:tx,:amount)",
                array("txdate"=>$_REQUEST['TXDATE'],"tx"=>$_REQUEST["TX"],"amount"=>$_REQUEST['AMOUNT']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else {    
#            DebugBreak();
            DBC::execute("UPDATE cbcpro SET TXDATE=:txdate,TX=:tx,AMOUNT=:amount WHERE ID=:id",
                array("txdate"=>$_REQUEST['TXDATE'],"tx"=>$_REQUEST["TX"],"amount"=>$_REQUEST['AMOUNT'],"id"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}
} // End class

$inputPage=new CashEdit();
$inputPage->data_sql="SELECT * FROM cbcpro WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

