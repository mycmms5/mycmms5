<?PHP
/** 
* Reception for POQuick
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package purchasing
* @subpackage REMACLE
* @filesource
* @todo Integrate this in the WO tabs
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class newPage extends inputPageSmarty {
public function validate_form() {
    $errors = array();
    if ($_REQUEST['PR']=="on" AND $_REQUEST['PC']=="on" ) { 
        $errors['PR']="POQ_Error: Only one can be selected"; 
        $errors['PC']="POQ_Error: Only one can be selected"; 
    }
    if ($_REQUEST['PR']!="on" AND $_REQUEST['PC']!="on" ) { 
        $errors['PR']="POQ_Error: Select Partial OR Complete reception"; 
        $errors['PC']="POQ_Error: Select Partial OR Complete reception"; 
    }
    return $errors;
}    
public function page_content() {
# Data
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    if ($data['STATUS']=="A") { 
        $PR_checked=false; $PC_checked=false;
    } else if ($data['STATUS']=="PR") {
        $PR_checked=true; $PC_checked=false;
    } else if ($data['STATUS']=="PC") {
        $PR_checked=false; $PC_checked=true;
    }
# template
    require("setup.php");
    $tpl = new smarty_mycmms();
    $tpl->debugging=true;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('PR_State',$PR_checked);
    $tpl->assign('PC_State',$PC_checked);
    $tpl->assign('receipts',$DB->query("SELECT PONUM,SEQNUM,QTYRECEIVED,DATERECEIVED FROM poreceiv WHERE SEQNUM={$_SESSION['Ident_1']}",PDO::FETCH_ASSOC));
    try {
        $tpl->display_error('tab_poq-receipt.tpl');
    } catch (exception $e) {
        trigger_error($e.message, E_ERROR);
        echo $e.message;
    } 
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        $ponum=DBC::fetchcolumn("SELECT PONUM FROM purreq WHERE SEQNUM={$_SESSION['Ident_1']}",0);
        if ($_REQUEST['QTYRECEIVED']>0) {
            DBC::execute("UPDATE purreq SET QTYRECEIVED=:qtyreceived WHERE SEQNUM=:id1",array("qtyreceived"=>$_REQUEST['QTYRECEIVED'],"id1"=>$_REQUEST['SEQNUM']));    
        }
        if ($_REQUEST['PR']=="on") { // Partial Receipt
            DBC::execute("INSERT INTO poreceiv (RECEIPTNUM,PONUM,SEQNUM,QTYRECEIVED,UNITCOST,DATERECEIVED) VALUES(NULL,:ponum,:seqnum,0,1,NOW())",array("ponum"=>$ponum,"seqnum"=>$_REQUEST['SEQNUM']));
            DBC::execute("UPDATE purreq SET STATUS='I' WHERE SEQNUM=:seqnum",array("seqnum"=>$_REQUEST['SEQNUM']));
        }
        if ($_REQUEST['PC']=="on") { // Complete Receipt
            DBC::execute("INSERT INTO poreceiv (RECEIPTNUM,PONUM,SEQNUM,QTYRECEIVED,UNITCOST,DATERECEIVED) VALUES(NULL,:ponum,:seqnum,1,1,NOW())",array("ponum"=>$ponum,"seqnum"=>$_REQUEST['SEQNUM']));
            DBC::execute("UPDATE purreq SET STATUS='B' WHERE SEQNUM=:seqnum",array("seqnum"=>$_REQUEST['SEQNUM']));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
        trigger_error($e->getMessage(),E_WARNING);
    }   
} // End process_form
} // End class

$inputPage=new newPage();
$inputPage->data_sql="SELECT purreq.* FROM purreq WHERE purreq.SEQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>

