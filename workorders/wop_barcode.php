<?PHP
/**
* Special form used for barcode input
*  
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback_barcode
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

if ($_SESSION['Ident_1']=="new") {
    require("wo-unsaved.php");
    exit();
}

class wopBarcodePage extends inputPageSmarty {
public function validate_form() {
    $errors = array();
    if (substr($_REQUEST['ITEMNUM'],0,3)!="200") { $errors['BARCODE']=_("BARCODE Invalid: Not a part number"); } 
    return $errors;
}    
public function page_content() {
    $DB=DBC::get();
    if ($this->input1 != 'new') {
        $sql="SELECT wop.*,invy.DESCRIPTION FROM wop LEFT JOIN invy ON wop.ITEMNUM=invy.ITEMNUM WHERE wop.WONUM={$this->input1}";
        $result=$DB->query($sql);
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
    }
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('parts',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error($this->template);        
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        $found=DBC::fetchcolumn("SELECT COUNT(*) FROM invy WHERE ITEMNUM='{$_REQUEST['ITEMNUM']}'",0);
        if ($found==0) {
            PDO_log("Article not found");
            break;
        } 
        if ($_REQUEST['QTYUSED']!=0) { $STOCK_InOut=true; } else { $STOCK_InOut=false; }
/**
* WAREHOUSE is not managed             
*/
        if(!WAREHOUSE AND $STOCK_InOut) {
                DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,DATEUSED,QTYUSED) SELECT :wonum,ITEMNUM,NOW(),:qtyused FROM invy WHERE ITEMNUM=:itemnum",array("wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'])); 
        } // EO TXID when warehouse is unmanaged
/**
* WAREHOUSE is managed            
*/
        if (WAREHOUSE AND $STOCK_InOut) {
                $unitcost=DBC::fetchcolumn("SELECT UNITCOST FROM invcost WHERE ITEMNUM={$_REQUEST['ITEMNUM']}",0);
                DBC::execute("INSERT INTO wop (WONUM,DATEUSED,ITEMNUM,QTYUSED,WAREHOUSEID,UNITCOST) VALUES (:wonum,NOW(),:itemnum,:qtyused,'DEFAULT',:unitcost)",array("wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'],"unitcost"=>$unitcost));
                DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY)  
                VALUES (NULL,:itemnum,NOW(),'DEFAULT',:issueto,'WO',:wonum,:qtyused)",array("wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'],"issueto"=>$_SESSION['user']));
                DBC::execute("UPDATE wop SET COST=QTYUSED*UNITCOST WHERE COST IS NULL",array());
                DBC::execute("UPDATE stock SET QTYONHAND=QTYONHAND-:qtyused WHERE WAREHOUSEID='DEFAULT' AND ITEMNUM=:itemnum",array("qtyused"=>$_REQUEST['QTYUSED'],"itemnum"=>$_REQUEST['ITEMNUM']));
        } // EO TXID when warehouse is managed
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  // EO try

}
} // End class

$inputPage=new wopBarcodePage();
$inputPage->flow();
?>

