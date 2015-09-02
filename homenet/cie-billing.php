<?php
/**
* tab_billing
*   
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class billing extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM billing WHERE FactuurID={$this->input1} ORDER BY WorkDate");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('works',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display('tw/cie_billing.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE billing SET workdate=:workdate,workhours=:workhours,comments=:comments,costs=:costs,costs_nb=:costs_nb WHERE ID=:id",
            array("id"=>$_REQUEST['ID'],"workdate"=>$_REQUEST['workdate'],"workhours"=>$_REQUEST['workhours'],"comments"=>$_REQUEST['commentaar'],"costs"=>$_REQUEST['costs'],"costs_nb"=>$_REQUEST['costs_nb']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End updateRecord
private function insertRecord() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO billing (ID,FactuurID,workdate,workhours,rate,comments,costs,costs_nb) 
            VALUES (NULL,:factuurid,:workdate,:workhours,70,:comments,:costs,:costs_nb)",
            array("factuurid"=>$this->input1,"workdate"=>$_REQUEST['workdate'],"workhours"=>$_REQUEST['workhours'],"comments"=>$_REQUEST['comments'],
            "costs"=>$_REQUEST['costs'],"costs_nb"=>$_REQUEST['costs_nb'])); 
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End insertRecord
private function calculate() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        $tobe_billed=DBC::fetchcolumn("SELECT SUM(workhours*rate)+SUM(costs) FROM billing WHERE FactuurID={$this->input1}",0);
        DBC::execute("UPDATE cash SET REVENUES=:tobe_billed, VAT=:vat WHERE ID=:factuurid", 
            array("factuurid"=>$this->input1,"tobe_billed"=>$tobe_billed,"vat"=>$tobe_billed*(-.21)));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}
function process_form() {   // Only Updating...
        switch ($_REQUEST['ACTION']) {
        case "UPDATE":
            $this->updateRecord($_REQUEST);        
            break;
        case "INSERT":
            $this->insertRecord($_REQUEST);
            break;
        case "CALCULATE":
            $this->calculate($_REQUEST);
            break;
        default:
            break;                           
        }
    } // EO process_form
} // EO class 

$inputPage=new billing();
// $inputPage->js="document.INSERT.TrackTitle.style.background='lightblue'; document.INSERT.TrackTitle.focus();";
$inputPage->flow();
?>
