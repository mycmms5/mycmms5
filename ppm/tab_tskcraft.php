<?PHP
/** 
* Registering resource needs
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

class tskcraftPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT tskcraft.ID,tskop.OPNUM,tskop.EQNUM,tskop.OPDESC,tskop.OPLDESC,tskcraft.CRAFT,tskcraft.TEAM,tskcraft.ESTHRS FROM tskop LEFT JOIN tskcraft ON tskop.TASKNUM=tskcraft.TASKNUM AND tskop.OPNUM=tskcraft.OPNUM WHERE tskop.TASKNUM='{$this->input1}'";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('operations',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('crafts',$DB->query("SELECT CRAFT AS 'id',CRAFT AS 'text' FROM crafts",PDO::FETCH_NUM));
    $tpl->display_error('tw/tskcraft.tpl');    
} // End page_content
function process_form() {   // Only Updating...
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        # TXID_TSKCRAFT_EDIT
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']!="0") {
                DBC::execute("UPDATE tskcraft SET CRAFT=:craft,TEAM=:team,ESTHRS=:esthrs WHERE ID=:id",array("id"=>$_REQUEST['ID'],"craft"=>$_REQUEST['CRAFT'],"team"=>$_REQUEST['TEAM'],"esthrs"=>$_REQUEST['ESTHRS']));
            } else {
                $values=DBC::fetchcolumns("SELECT TASKNUM,OPNUM FROM tskcraft WHERE ID={$_REQUEST['ID']}");
                DBC::execute("DELETE FROM tskcraft WHERE ID=:id",array("id"=>$_REQUEST['ID']));
                $num=DBC::fetchcolumn("SELECT COUNT(*) FROM tskcraft WHERE TASKNUM='{$values[0]}' AND OPNUM={$values[1]}",0);
                if ($num==0) {
                    DBC::execute("DELETE FROM tskop WHERE TASKNUM=:tasknum AND OPNUM=:op",array("tasknum"=>$values[0],"op"=>$values[1]));
                }
            }
            if (strlen($_REQUEST['OPDESC'])>5 AND $_REQUEST['ESTHRS']!="0") {
                $values=DBC::fetchcolumns("SELECT TASKNUM,OPNUM FROM tskcraft WHERE ID={$_REQUEST['ID']}");
                DBC::execute("UPDATE tskop SET OPDESC=:opdesc,OPLDESC='None' WHERE TASKNUM=:tasknum AND OPNUM=:op",
                    array("opdesc"=>$_REQUEST['OPDESC'],"tasknum"=>$values[0],"op"=>$values[1]));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }    
        break;
    case "INSERT":
        # TXID_TSKCRAFT_CREATE
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']!="0") {
                DBC::execute("INSERT INTO tskcraft (ID,TASKNUM,OPNUM,CRAFT,TEAM,ESTHRS) VALUES (NULL,:tasknum,:opnum,:craft,:team,:esthrs)",array("tasknum"=>$this->input1,"opnum"=>$_REQUEST['OPNUM'],"craft"=>$_REQUEST['CRAFT'],"team"=>$_REQUEST['TEAM'],"esthrs"=>$_REQUEST['ESTHRS']));
            }
            if (strlen($_REQUEST['OPDESC']) >= 3) {   
                DBC::execute("REPLACE tskop SET TASKNUM=:tasknum,OPNUM=:opnum,EQNUM=:eqnum,OPDESC=:opdesc,OPLDESC=:opldesc,OPDURATION=:opduration",array("tasknum"=>$this->input1,"opnum"=>$_REQUEST['OPNUM'],"eqnum"=>$_REQUEST['EQNUM'],"opdesc"=>$_REQUEST['OPDESC'],"opldesc"=>$_REQUEST['OPLDESC'],"opduration"=>0));
            } // By using REPLACE we can change texts in WOOP          
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

$inputPage=new tskcraftPage();
$inputPage->version=$version; 
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>
