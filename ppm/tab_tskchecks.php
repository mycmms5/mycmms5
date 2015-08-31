<?PHP
/** 
* Registering Control Checks
* 
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @subpackage checks
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";
$OPNUM_ID=$_REQUEST['ID'];

class tskchecksPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT tc.ID,tc.INDICATOR,i.TYPE,i.EQNUM,i.LABEL,i.INSTRUCTIONS FROM tskchecks tc LEFT JOIN indicators i ON tc.INDICATOR=i.INDICATOR WHERE tc.TASKNUM='{$this->input1}'";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('checks',$data);
    $tpl->assign('indicator_types',array("BOOL","FLOAT","N/USED"));
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tw/tskchecks.tpl');      
} // End page_content
function process_form() {   // Only Updating...
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE indicators SET TYPE=:type,LABEL=:label,INSTRUCTIONS=:instructions WHERE INDICATOR=:id",array("id"=>$_REQUEST['ID'],"type"=>$_REQUEST['TYPE'],"label"=>$_REQUEST['LABEL'],"instructions"=>$_REQUEST['INSTRUCTIONS']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO indicators (INDICATOR,TYPE,EQNUM,LABEL,INSTRUCTIONS) VALUES (:indicator,:type,:eqnum,:label,:instructions)", array("indicator"=>$_REQUEST['INDICATOR'],"type"=>$_REQUEST['TYPE'],"eqnum"=>$_REQUEST['EQNUM'],"label"=>$_REQUEST['LABEL'],"instructions"=>$_REQUEST['INSTRUCTIONS']));
            DBC::execute("INSERT INTO tskchecks (ID,TASKNUM,EQNUM,INDICATOR) VALUES (NULL,:tasknum,:eqnum,:indicator)",array("tasknum"=>$this->input1,"eqnum"=>$this->input2,"indicator"=>$_REQUEST['INDICATOR']));
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

$inputPage=new tskchecksPage();
$inputPage->version=$version; 
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>
