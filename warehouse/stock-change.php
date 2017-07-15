<?PHP
/** Edit stock data for spares
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package warehouse
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class stockchangePage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=(array)$this->get_data($this->input1,$this->input2);
    $ordered=DBC::fetchcolumn("SELECT SUM(QTYREQUESTED) FROM purreq WHERE ITEMNUM='{$this->input1}' AND STATUS='A'",0);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('ordered',$ordered);
    $tpl->display_error($this->template);
} // EO page_content
function process_form() {
    $DB=DBC::get();
    // $DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    try {
        $DB->beginTransaction();
        $inventory_change=(float) $_REQUEST['QTYONHAND']- (float) $_REQUEST['QTYONHAND_OLD'];
        DBC::execute("UPDATE stock SET QTYONHAND=:qtyonhand WHERE ITEMNUM=:itemnum AND WAREHOUSEID='DEFAULT'",array("itemnum"=>$_REQUEST['id1'],"qtyonhand"=>$_REQUEST['QTYONHAND']));
        if ($inventory_change>0) {
            DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,TRANSTYPE,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY) VALUES (NULL,:itemnum,'INVO',NOW(),'DEFAULT','INVENTORY','ACCT','10',:changed)",array("itemnum"=>$_REQUEST['id1'],"changed"=>$inventory_change));
        } else {
            DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,TRANSTYPE,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY) VALUES (NULL,:itemnum,'INVO',NOW(),'DEFAULT','INVENTORY','ACCT','20',:changed)",array("itemnum"=>$_REQUEST['id1'],"changed"=>$inventory_change));
        }
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
} // EO process_form
} // EO Class

$inputPage=new stockchangePage();
$inputPage->data_sql="SELECT stock.*,invy.DESCRIPTION,whi.* FROM invy LEFT JOIN stock ON invy.ITEMNUM=stock.ITEMNUM LEFT JOIN warehouseinfo whi ON stock.ITEMNUM=whi.ITEMNUM WHERE invy.ITEMNUM='{$inputPage->input1}'";
$inputPage->flow();
?>    
    