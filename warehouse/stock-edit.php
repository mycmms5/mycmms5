<?PHP
/** Edit stock parameters for spares
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package warehouse
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class stockeditPage extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    $stock=$DB->query("SELECT invy.ITEMNUM,DESCRIPTION,LOCATION,QTYONHAND,whi.STOCKITEM FROM stock LEFT JOIN invy on stock.ITEMNUM=invy.ITEMNUM LEFT JOIN warehouseinfo whi ON stock.ITEMNUM=whi.ITEMNUM WHERE stock.ITEMNUM='{$this->input1}'",PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('stock',$stock);
    $tpl->display_error($this->template);
} // EO page_content
function process_form() {
    $DB=DBC::get();
    $DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE warehouseinfo SET STOCKITEM=:stockitem,ABCCLASS=:abcclass,REORDERPOINT=:reorderpoint,REORDERQTY=:reorderqty,REORDERMETHOD=:reordermethod,MINSTOCKLEVEL=:minstocklevel WHERE ITEMNUM=:itemnum AND WAREHOUSEID='DEFAULT'",
            array("itemnum"=>$_REQUEST['id1'],"stockitem"=>$_REQUEST['STOCKITEM'],"abcclass"=>$_REQUEST['ABCCLASS'],"reorderpoint"=>$_REQUEST['REORDERPOINT'],"minstocklevel"=>$_REQUEST['MINSTOCKLEVEL'],"reorderqty"=>$_REQUEST['REORDERQTY'],"reordermethod"=>$_REQUEST['REORDERMETHOD']));
        if ($_REQUEST['LOCATION_OLD']!=$_REQUEST['LOCATION']) { // Move stock
            DBC::execute("UPDATE stock SET LOCATION=:location_new WHERE ITEMNUM=:itemnum AND WAREHOUSEID='DEFAULT' AND LOCATION=:location_old",array("itemnum"=>$_REQUEST['id1'],"location_old"=>$_REQUEST['LOCATION_OLD'],"location_new"=>$_REQUEST['LOCATION']));
        }
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }  
} // EO process_form
} // EO Class

$inputPage=new stockeditPage();
$inputPage->data_sql="SELECT stock.*,invy.DESCRIPTION,whi.* FROM invy LEFT JOIN stock ON invy.ITEMNUM=stock.ITEMNUM LEFT JOIN warehouseinfo whi ON stock.ITEMNUM=whi.ITEMNUM WHERE invy.ITEMNUM='{$inputPage->input1}'";
$inputPage->flow();
?>    
    