<?PHP
/** tab_vendor_edit: Edit commercial data for spares
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package warehouse
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class vendoreditPage extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    // All possible suppliers
    $vendors=$DB->query("SELECT iv.VENDORID,v.NAME,iv.UNITCOST,iv.UNITQTY,iv.UOP,iv.MANUFACTID,iv.PRIMARYVENDOR FROM invy LEFT JOIN invvend iv ON invy.ITEMNUM=iv.ITEMNUM LEFT JOIN vendors v ON iv.VENDORID=v.id WHERE invy.ITEMNUM='{$this->input1}'",PDO::FETCH_ASSOC);
    // Stock status based on preferred supplier
    $stock=$DB->query("SELECT invy.ITEMNUM,DESCRIPTION,LOCATION,QTYONHAND,(QTYONHAND*UNITCOST) AS 'STOCKVALUE' FROM invy LEFT JOIN stock ON invy.ITEMNUM=stock.ITEMNUM LEFT JOIN invvend ON invy.ITEMNUM=invvend.ITEMNUM WHERE invy.ITEMNUM='{$this->input1}' AND invvend.PRIMARYVENDOR='Y'",PDO::FETCH_ASSOC);
    // Supplier List
    $suppliers=$DB->query("SELECT VENDORID,UNITCOST,MANUFACTID FROM invvend WHERE ITEMNUM='{$this->input1}'",PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('vendors',$vendors);
    $tpl->assign('vendorlist',$DB->query("SELECT id AS 'id',NAME AS 'text' FROM vendors",PDO::FETCH_NUM));
    $tpl->assign('suppliers',$suppliers);
    $tpl->assign('stock',$stock);
    $tpl->display_error("tw/stock_vendor-edit.tpl");

} // EO page_content
function process_form() {
    $DB=DBC::get();
    $DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    try {
        $DB->beginTransaction();
        if ($_REQUEST['VENDORID']!=$_REQUEST['VENDOR_OLD']) { // New Primary Vendor
            DBC::execute("DELETE FROM invvend WHERE ITEMNUM=:itemnum AND VENDORID='UNKNOWN'",array("itemnum"=>$_REQUEST['id1'])); // UNKNOWN may be removed
            DBC::execute("UPDATE invvend SET PRIMARYVENDOR='N' WHERE ITEMNUM=:itemnum",array("itemnum"=>$_REQUEST['id1']));
            DBC::execute("INSERT INTO invvend (ITEMNUM,VENDORID,PRIMARYVENDOR,MANUFACTID,UNITCOST,UNITQTY,UOP,MINORDERQTY) VALUES (:itemnum,:vendorid,'Y',:manufactid,:unitcost,:unitqty,:uop,:minorderqty)",array("itemnum"=>$_REQUEST['id1'],"vendorid"=>$_REQUEST['VENDORID'],"manufactid"=>$_REQUEST['MANUFACTID'],"unitcost"=>$_REQUEST['UNITCOST'],"unitqty"=>$_REQUEST['UNITQTY'],"uop"=>$_REQUEST['UOP'],"minorderqty"=>$_REQUEST['MINORDERQTY']));
            DBC::execute("UPDATE invcost LEFT JOIN invvend ON invcost.ITEMNUM=invvend.ITEMNUM AND invvend.PRIMARYVENDOR='Y' SET invcost.UNITCOST=invvend.UNITCOST WHERE invcost.ITEMNUM=:itemnum",array("itemnum"=>$_REQUEST['id1']));
        } else { // Change existing data
            DBC::execute("UPDATE invvend SET MANUFACTID=:manufactid,UNITCOST=:unitcost,UNITQTY=:unitqty,UOP=:uop,MINORDERQTY=:minorderqty WHERE ITEMNUM=:itemnum AND VENDORID=:vendorid",array("itemnum"=>$_REQUEST['id1'],"vendorid"=>$_REQUEST['VENDORID'],"manufactid"=>$_REQUEST['MANUFACTID'],"unitcost"=>$_REQUEST['UNITCOST'],"unitqty"=>$_REQUEST['UNITQTY'],"uop"=>$_REQUEST['UOP'],"minorderqty"=>$_REQUEST['MINORDERQTY']));
            DBC::execute("UPDATE invcost LEFT JOIN invvend ON invcost.ITEMNUM=invvend.ITEMNUM AND invvend.PRIMARYVENDOR='Y' SET invcost.UNITCOST=invvend.UNITCOST WHERE invcost.ITEMNUM=:itemnum",array("itemnum"=>$_REQUEST['id1']));
        } 
        if ($_REQUEST['vendorswitch']!=$_REQUEST['VENDOR_OLD']) {
            DBC::execute("UPDATE invvend SET PRIMARYVENDOR='Y' WHERE ITEMNUM=:itemnum AND VENDORID=:vendorid",array("itemnum"=>$_REQUEST['id1'],"vendorid"=>$_REQUEST['vendorswitch']));
            DBC::execute("UPDATE invvend SET PRIMARYVENDOR='N' WHERE ITEMNUM=:itemnum AND VENDORID<>:vendorid",array("itemnum"=>$_REQUEST['id1'],"vendorid"=>$_REQUEST['vendorswitch']));
        }
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  
} // EO process_form
private function make_SupplierList($itemnum,$vendor) {
    $DB=DBC::get();
    $result=$DB->query("SELECT VENDORID,UNITCOST,MANUFACTID FROM invvend WHERE ITEMNUM=$itemnum");
    foreach ($result->fetchAll(PDO::FETCH_OBJ) as $row) {
        if ($row->VENDORID==$vendor) {
?>
<tr><td align="right"><?PHP echo create_radio("vendor_switch",$row->VENDORID,"checked")." ".$row->VENDORID;; ?></td><td><?PHP echo _("UnitCost")." : ".$row->UNITCOST; ?></td><td><?PHP $row->MANUFACTID; ?></td></tr>    
<?PHP
        } else {
?>
<tr><td align="right"><?PHP echo create_radio("vendor_switch",$row->VENDORID,"")." ".$row->VENDORID; ?></td><td><?PHP echo _("UnitCost")." : ".$row->UNITCOST; ?></td><td><?PHP $row->MANUFACTID; ?></td></tr>    
<?PHP
        }
    }    
}
} // EO Class

$inputPage=new vendoreditPage();
$inputPage->data_sql="SELECT invy.ITEMNUM,invy.DESCRIPTION,invy.OEMMFG,iv.* FROM invy LEFT JOIN invvend iv ON invy.ITEMNUM=iv.ITEMNUM  WHERE invy.ITEMNUM='{$inputPage->input1}' AND iv.PRIMARYVENDOR='Y'";
$inputPage->flow();
?>    
    