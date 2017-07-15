<?PHP
/** 
* New 
* 
* @author  Werner Huysmans
* @access  public
* @package warehouse
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class stockPage extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    if (empty($_REQUEST['DESCRIPTION'])) { $errors['DESCRIPTION']=_("STOCK_Error: Part should have a description"); }
    if (empty($_REQUEST['TYPE'])) { $errors['TYPE']=_("STOCK_Error: Part must belong to a group"); }
    return $errors;
}
public function page_content() {
    $data=unserialize($_SESSION['form_data']);
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('inventory_types',$DB->query("SELECT TYPE AS 'id',DESCRIPTION AS 'text' FROM INVTYPE",PDO::FETCH_NUM));
    $tpl->display_error($this->template);
}
function process_form() {  
    unset($_SESSION['form_data']);
    $DB=DBC::get();
    $DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO invy (ITEMNUM,DESCRIPTION,NOTES,TYPE,UOM) VALUES (NULL,:description,:notes,:type,'PCE')",array("description"=>$_REQUEST['DESCRIPTION'],"notes"=>$_REQUEST['NOTES'],"type"=>$_REQUEST['TYPE']));
        DBC::execute("INSERT INTO stock (ITEMNUM,WAREHOUSEID,LOCATION,QTYONHAND) VALUES (LAST_INSERT_ID(),'DEFAULT','UNKNOWN',0)",array());
        DBC::execute("INSERT INTO warehouseinfo (ITEMNUM,WAREHOUSEID,STOCKITEM,REORDERPOINT,REORDERQTY,MINSTOCKLEVEL) VALUES (LAST_INSERT_ID(),'DEFAULT','Y',0,1,1)",array());
        DBC::execute("INSERT INTO invvend(ITEMNUM,VENDORID,PRIMARYVENDOR,UNITCOST,UNITQTY,UOP) VALUES (LAST_INSERT_ID(),'UNKNOWN','Y',1,1,'PCE')",array());
        DBC::execute("INSERT INTO invcost(ITEMNUM,WAREHOUSEID,UNITCOST) VALUES (LAST_INSERT_ID(),'DEFAULT',1)",array());
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
}
} // EO Class
 
$inputPage=new stockPage();
$inputPage->flow();
?>