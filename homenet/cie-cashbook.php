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
    $tx_types=array("TVA","RSZ","Facture","Couts","Investissement","Expenses","Auto");
    $origins=array("B","NL","F","USA","GE");
#    DebugBreak();
    $quarters=array("2009Q4",
        "2010Q1","2010Q2","2010Q3","2010Q4",
        "2011Q1","2011Q2","2011Q3","2011Q4",
        "2012Q1","2012Q2","2012Q3","2012Q4",
        "2013Q1","2013Q2","2013Q3","2013Q4",
        "2014Q1","2014Q2","2014Q3","2014Q4",
        "2015Q1","2015Q2","2015Q3","2015Q4",);
    $no_cbcpro_txs=substr($data['TDATE'],0,4)."-12-31"; 
    if ($data['TYPE']=="Facture") {
        $cbc_sql="SELECT ID AS 'id', CONCAT(TXDATE,':(',AMOUNT,')',TX) AS 'text' FROM cbcpro WHERE TXDATE BETWEEN ADDDATE('".$data['PDATE']."',INTERVAL -2 WEEK) AND ADDDATE('".$data['PDATE']."',INTERVAL 2 WEEK) UNION SELECT ID AS 'id', CONCAT(TXDATE,':(',AMOUNT,')',TX) AS 'text' FROM cbcpro WHERE TXDATE='".$no_cbcpro_txs."'";      
    } else {
        $cbc_sql="SELECT ID AS 'id', CONCAT(TXDATE,':(',AMOUNT,')',TX) AS 'text' FROM cbcpro WHERE TXDATE BETWEEN ADDDATE('".$data['TDATE']."',INTERVAL -2 WEEK) AND ADDDATE('".$data['TDATE']."',INTERVAL 2 WEEK) UNION SELECT ID AS 'id', CONCAT(TXDATE,':(',AMOUNT,')',TX) AS 'text' FROM cbcpro WHERE TXDATE='".$no_cbcpro_txs."'";      
    }
#    DebugBreak();
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
    $tpl->assign("cbc",$DB->query($cbc_sql,PDO::FETCH_NUM));
    $tpl->display("tw/cie_cash.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO cash (ID,FIRM,QUARTER,TDATE,COMMENT,EXPENSES,REVENUES,VAT,VATRATE,TYPE,GENLEDGER,ORIGIN) VALUES (NULL,:firm,:quarter,:tdate,:comment,:expenses,:revenues,:vat,:vatrate,:type,:genledger,:origin)",array("firm"=>$_REQUEST['FIRM'],"quarter"=>$_REQUEST["QUARTER"],"tdate"=>$_REQUEST['TDATE'],"comment"=>$_REQUEST['COMMENT'],"expenses"=>$_REQUEST['EXPENSES'],"revenues"=>$_REQUEST['REVENUES'],"vat"=>$_REQUEST['VAT'],"vatrate"=>$_REQUEST['VATRATE'],"type"=>$_REQUEST['TYPE'],"genledger"=>$_REQUEST['GENLEDGER'],"origin"=>$_REQUEST['ORIGIN']));  
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;

        } else {    
            if (empty($_REQUEST['PDATE']) && $_REQUEST['TYPE']=="Facture") {    $_REQUEST['PDATE']='2015-01-01'; }
            DBC::execute("UPDATE cash SET FIRM=:firm,QUARTER=:quarter,TDATE=:tdate,TXID=:txid,PDATE=:pdate,COMMENT=:comment,
                EXPENSES=:expenses,REVENUES=:revenues,VAT=:vat,VATRATE=:vatrate,TYPE=:type,GENLEDGER=:genledger,ORIGIN=:origin WHERE ID=:id",
                array("firm"=>$_REQUEST['FIRM'],"quarter"=>$_REQUEST['QUARTER'],"tdate"=>$_REQUEST['TDATE'],
                    "comment"=>$_REQUEST['COMMENT'],
                    "expenses"=>$_REQUEST['EXPENSES'],"revenues"=>$_REQUEST['REVENUES'],"txid"=>$_REQUEST['TXID'],
                    "pdate"=>$_REQUEST['PDATE'],"vat"=>$_REQUEST['VAT'],"vatrate"=>$_REQUEST['VATRATE'],"type"=>$_REQUEST['TYPE'],"genledger"=>$_REQUEST['GENLEDGER'],"origin"=>$_REQUEST['ORIGIN'],"id"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}
} // End class

$inputPage=new CashEdit();
$inputPage->data_sql="SELECT * FROM cash WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

