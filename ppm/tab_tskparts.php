<?PHP
/** 
* Registering Spare Part needs
* 
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @subpackage standard
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

$OPNUM_ID=$_REQUEST['ID'];
if ($_SESSION['Ident_1']=="new") {
    require("tw/task-unsaved.php");
    exit();
}

class tskpartsPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT ID,tskparts.ITEMNUM,invy.DESCRIPTION,QTYREQD FROM tskparts LEFT JOIN invy ON tskparts.ITEMNUM=invy.ITEMNUM WHERE tskparts.TASKNUM='{$this->input1}'";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('parts',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tw/tskparts.tpl');      
} // End page_content
function process_form() {   
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        # TXID_TSKPARTS_EDIT
        try {
            $DB->beginTransaction();
            if ($_REQUEST["QTYREQD"]==0) {
                DBC::execute("DELETE FROM tskparts WHERE ID=:id",array("id"=>$_REQUEST["ID"]));
            } else {
                DBC::execute("UPDATE tskparts SET QTYREQD=:qtyreqd WHERE ID=:id",array("id"=>$_REQUEST["ID"],"qtyreqd"=>$_REQUEST["QTYREQD"]));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    case "INSERT":
        # TXID_TSKPARTS_CREATE
        try {
            $DB->beginTransaction();
/**
* Check if this article exists in invy
*/
            $found=DBC::fetchcolumn("SELECT COUNT(*) FROM invy WHERE ITEMNUM='{$_REQUEST['ITEMNUM']}'",0);
            if ($found==0) {
                PDO_log("Article not found");
                break;
            } 
/**
* Registration only when >0
*/
            if ($_REQUEST['QTYREQD']>0) {
            DBC::execute("INSERT INTO tskparts (ID,TASKNUM,ITEMNUM,QTYREQD) VALUES (:id,:tasknum,:itemnum,:qtyreqd);",array("id"=>$_REQUEST['ID'],"tasknum"=>$this->input1,"itemnum"=>$_REQUEST['ITEMNUM'],"qtyreqd"=>$_REQUEST['QTYREQD']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    default:
        break;                           
    }
} // End process_form
} // End class

$inputPage=new tskpartsPage();
$inputPage->version=$version; 
$inputPage->flow();
?>
