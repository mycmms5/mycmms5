<?PHP
/** tab_hama for CD
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091108
* @access  public
* @package mycmms_ppm
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class tracks extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT purreq.* FROM purreq WHERE WONUM={$this->input1}");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('purchases',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display('tab_purchases.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE purreq SET VENDORID=:vendorid,DESCRIPTIONONPO=:descriptiononpo,NOTES=:notes,QTYRECEIVED=:qtyreceived,UNITCOST=:unitcost WHERE SEQNUM=:seqnum",array("vendorid"=>$_REQUEST['VENDORID'],"descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"notes"=>$_REQUEST['NOTES'],"qtyreceived"=>$_REQUEST['QTYRECEIVED'],"unitcost"=>$_REQUEST['UNITCOST'],"seqnum"=>$_REQUEST['ID']));
        DBC::execute("UPDATE purreq SET LINECOST=QTYRECEIVED*UNITCOST WHERE SEQNUM={$_REQUEST['ID']}",array());
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
        DBC::execute("INSERT INTO purreq (SEQNUM,DESCRIPTIONONPO,QTYRECEIVED,UNITCOST,NOTES,WONUM,VENDORID) VALUES (NULL,:descriptiononpo,:qtyreceived,:unitcost,:notes,:wonum,:vendorid)",array("descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"qtyreceived"=>$_REQUEST['QTYRECEIVED'],"unitcost"=>$_REQUEST['UNITCOST'],"notes"=>$_REQUEST['NOTES'],"wonum"=>$_SESSION['Ident_1'],"vendorid"=>$_REQUEST['VENDORID']));
        DBC::execute("UPDATE purreq SET LINECOST=QTYRECEIVED*UNITCOST WHERE SEQNUM=LAST_INSERT_ID()",array());
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End insertRecord
function process_form() {   // Only Updating...
        switch ($_REQUEST['ACTION']) {
        case "UPDATE":
            $this->updateRecord($_REQUEST);        
            break;
        case "INSERT":
            $this->insertRecord($_REQUEST);
            break;
        default:
            break;                           
        }
    } // EO process_form
} // EO class 

$inputPage=new tracks();
$inputPage->flow();
?>
    