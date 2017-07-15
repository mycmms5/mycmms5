<?PHP
/** 
* @author  Werner Huysmans 
* @access  public
* @package warehouse
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class invyeditPage extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('inventory_types',$DB->query("SELECT TYPE AS 'id',DESCRIPTION AS 'text' FROM INVTYPE",PDO::FETCH_NUM));
    $tpl->display_error($this->template);
} // EO page_content
function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO invy (ITEMNUM,DESCRIPTION,NOTES,TYPE,UOM) VALUES (NULL,:description,:notes,:type,'PCE')",array("description"=>$_REQUEST['ITEM_DESC'],"notes"=>$_REQUEST['NOTES'],"type"=>$_REQUEST['TYPE']));
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;
            DBC::execute("INSERT INTO stock (ITEMNUM,WAREHOUSEID,LOCATION,QTYONHAND) VALUES (LAST_INSERT_ID(),'DEFAULT','UNKNOWN',0)",array());
            DBC::execute("INSERT INTO warehouseinfo (ITEMNUM,WAREHOUSEID,STOCKITEM,REORDERPOINT,REORDERQTY,MINSTOCKLEVEL) VALUES (LAST_INSERT_ID(),'DEFAULT','Y',0,1,1)",array());
            DBC::execute("INSERT INTO invvend(ITEMNUM,VENDORID,PRIMARYVENDOR,UNITCOST,UNITQTY,UOP) VALUES (LAST_INSERT_ID(),'UNKNOWN','Y',1,1,'PCE')",array());
            DBC::execute("INSERT INTO invcost(ITEMNUM,WAREHOUSEID,UNITCOST) VALUES (LAST_INSERT_ID(),'DEFAULT',1)",array());
        } else {
           DBC::execute("UPDATE invy SET DESCRIPTION=:description,NOTES=:notes,OEMMFG=:oemmfg,TYPE=:type WHERE ITEMNUM=:itemnum",array("itemnum"=>$_REQUEST['id1'],"description"=>$_REQUEST['ITEM_DESC'],"notes"=>$_REQUEST['NOTES'],"oemmfg"=>$_REQUEST['OEMMFG'],"type"=>$_REQUEST['TYPE']));
        }
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
} // EO process_form
} // EO Class

$inputPage=new invyeditPage();
$inputPage->data_sql="SELECT invy.*,invtype_tree.DESCRIPTION AS 'TYPE_DESC' FROM invy LEFT JOIN invtype_tree ON invy.TYPE=invtype_tree.EQNUM  WHERE invy.ITEMNUM='{$inputPage->input1}'";
$inputPage->flow();
?>    