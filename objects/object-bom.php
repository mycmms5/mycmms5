<?PHP
/** 
* @author  Werner Huysmans
* @access  public
* @package objects
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$OPNUM_ID=$_REQUEST['ID'];

class BOMPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $BOM=DBC::fetchcolumn("SELECT SPARECODE FROM equip WHERE EQNUM='{$this->input1}'",0);
    $data=$DB->query("SELECT s.*,i.SAP,i.DESCRIPTION FROM spares s LEFT JOIN invy i ON s.ITEMNUM=i.ITEMNUM WHERE SPARECODE='{$BOM}' ORDER BY ITEMNUM",PDO::FETCH_ASSOC);

    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('bom_parts',$data);
    $tpl->assign('BOM',$BOM);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error($this->template);        
}
private function updateRecord($data) {
    if ($data['QTY']==0) {
        DBC::execute("DELETE FROM spares WHERE ID=:id",array("id"=>$data['ID']));
    } else {
        DBC::execute("UPDATE spares SET QTY=:qty WHERE ID=:id",array("id"=>$data['ID'],"qty"=>$data['QTY']));
    }
} // End updateRecord
private function insertRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO spares (ID,SPARECODE,ITEMNUM,QTY) VALUES (NULL,:sparecode,:itemnum,:qty)",array("sparecode"=>$_REQUEST['BOM'],"itemnum"=>$data['ITEMNUM'],"qty"=>$data['QTY']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } 
/**
* This code is kept for ASCO
     if (!empty($_REQUEST['MAPICS'])) {
        try {
            $DB->beginTransaction();
            $ITEMNUM=DBC::fetchcolumn("SELECT ITEMNUM FROM invy WHERE MAPICS LIKE '%{$_REQUEST['MAPICS']}%'",0);
            if (!empty($ITEMNUM)) {
                DBC::execute("INSERT INTO spares (ID,SPARECODE,ITEMNUM,QTY) VALUES (null,:sparecode,:itemnum,:qty)",array("sparecode"=>$data['BOM'],"itemnum"=>$ITEMNUM,"qty"=>$data['QTY']));
            } else {
                DBC::execute("INSERT INTO invy (ITEMNUM,MAPICS,DESCRIPTION) VALUES (NULL,:mapics,:description)",array("mapics"=>$_REQUEST['MAPICS'],"description"=>$_REQUEST['DESCRIPTION']));
                $new_invy=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                DBC::execute("INSERT INTO stock (ITEMNUM,LOCATION,QTYONHAND) VALUES (:itemnum,'NOT_IN_WH',0)",array("itemnum"=>$new_invy));
                DBC::execute("INSERT INTO spares (SPARECODE,ITEMNUM,QTY) VALUES (:sparecode,:itemnum,:qty)",array("sparecode"=>$_REQUEST['BOM'],"itemnum"=>$new_invy,"qty"=>$_REQUEST['QTY']));
            }
            $DB->commit();
        } 
**/        
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
} // End process_form
} // End of class

$inputPage=new BOMPage();
$inputPage->flow();
?>
