<?PHP
/** 
* Reservation of Spare Parts during WO preparation
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* CVS
* $Id: tab_woparts.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_woparts.php,v $
* $Log: tab_woparts.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";
$OPNUM_ID=$_REQUEST['ID'];

class WOPartsPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT wop.ID,wop.ITEMNUM,invy.DESCRIPTION,wop.DATEUSED,wop.QTYREQD FROM wop LEFT JOIN invy ON wop.ITEMNUM=invy.ITEMNUM WHERE wop.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('parts',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tw/woparts.tpl');        
} // End page_content
function process_form() {  
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if($_REQUEST['QTYREQD']>0) {
                DBC::execute("UPDATE wop SET QTYREQD=:qtyreqd,DATEUSED=NOW() WHERE ID=:id",array("id"=>$_REQUEST['ID'],"qtyreqd"=>$_REQUEST['QTYREQD']));    
            } else {
                DBC::execute("DELETE FROM wop WHERE ID=:id",array("id"=>$_REQUEST['ID']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    case "INSERT":
         try {
            $DB->beginTransaction();
            $found=DBC::fetchcolumn("SELECT COUNT(*) FROM invy WHERE ITEMNUM='{$_REQUEST['ITEMNUM']}'",0);
            if ($found==0) {
                PDO_log("Article not found");
            } else if ($_REQUEST['QTYREQD']>0) {
                DBC::execute("INSERT INTO wop (ID,WONUM,ITEMNUM,QTYREQD,DATEUSED) VALUES (NULL,:wonum,:itemnum,:qtyreqd,NOW())",array("wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyreqd"=>$_REQUEST['QTYREQD']));
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

$inputPage=new WOPartsPage();
$inputPage->version=$version;
//$inputPage->pageTitle="";
//$inputPage->contentTitle="";
//$inputPage->formName="treeform";
//$inputPage->input1=$_SESSION['Ident_1'];
//$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>
