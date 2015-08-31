<?PHP
/** 
* @author  Werner Huysmans 
* @access  public
* @package warehouse
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

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
    $tpl->display_error("tw/stock_invy-edit.tpl");
} // EO page_content
function process_form() {
    $DB=DBC::get();
    $DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE invy SET DESCRIPTION=:description,NOTES=:notes,OEMMFG=:oemmfg,TYPE=:type WHERE ITEMNUM=:itemnum",array("itemnum"=>$_REQUEST['id1'],"description"=>$_REQUEST['DESCRIPTION'],"notes"=>$_REQUEST['NOTES'],"oemmfg"=>$_REQUEST['OEMMFG'],"type"=>$_REQUEST['TYPE']));
        
        $DB->commit();        
        return __FILE__." OK";
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
} // EO process_form
} // EO Class

$inputPage=new invyeditPage();
$inputPage->version=$version;
$inputPage->data_sql="SELECT invy.*,invtype.DESCRIPTION AS 'TYPE_DESC' FROM invy LEFT JOIN invtype ON invy.TYPE=invtype.TYPE  WHERE invy.ITEMNUM='{$inputPage->input1}'";
$inputPage->flow();
?>    