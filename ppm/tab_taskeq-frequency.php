<?PHP
/** 
* Change Type-of and interval of PPM
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

if ($_SESSION['Ident_1']=="new") {
    require("tab_task-unsaved.php");
    exit();
}

class taskeqFrequencyPage extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->display_error('tw/taskeq-frequency.tpl');
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        switch ($_REQUEST['SCHEDTYPE']) {
        case 'F':   // Floating
            DBC::execute("UPDATE taskeq SET NUMOFDATE=:numofdate,LASTPERFDATE=:lastperfdate,NEXTDUEDATE=:nextduedate WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM'],"numofdate"=>$_REQUEST['NUMOFDATE'],"lastperfdate"=>$_REQUEST['LASTPERFDATE'],"nextduedate"=>$_REQUEST['NEXTDUEDATE']));
            break;
        case 'X':   // Fixed
            DBC::execute("UPDATE taskeq SET NUMOFDATE=:numofdate,LASTPERFDATE=:lastperfdate,NEXTDUEDATE=:nextduedate WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM'],"numofdate"=>$_REQUEST['NUMOFDATE'],"lastperfdate"=>$_REQUEST['LASTPERFDATE'],"nextduedate"=>$_REQUEST['NEXTDUEDATE']));
            break;
        case 'T':
            DBC::execute("UPDATE taskeq SET NUMOFDATE=:numofdate,COUNTER=:counter,LASTCOUNTER=:lastcounter WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM'],"numofdate"=>$_REQUEST['NUMOFDATE'],"counter"=>$_REQUEST['COUNTER'],"lastcounter"=>$_REQUEST['LASTCOUNTER']));
            break;
        case 'C':
            break;
        }
        if ($_REQUEST['ACTIVATE']=="on") {
            DBC::execute("UPDATE taskeq SET ACTIVE=1 WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM']));
        } else {
            DBC::execute("UPDATE taskeq SET ACTIVE=-1 WHERE TASKNUM=:tasknum AND EQNUM=:eqnum",array("tasknum"=>$_REQUEST['id1'],"eqnum"=>$_REQUEST['EQNUM']));
        }
        $DB->commit(); 
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } 
} // End process_form
} // End class

$inputPage=new taskeqFrequencyPage();
$inputPage->version=$version; 
$inputPage->data_sql="SELECT task.*,taskeq.EQNUM,taskeq.NUMOFDATE,taskeq.LASTPERFDATE,taskeq.NEXTDUEDATE,taskeq.SCHEDTYPE,taskeq.COUNTER,taskeq.LASTCOUNTER,taskeq.ACTIVE,equip.DESCRIPTION AS 'EQDESC' FROM task LEFT JOIN taskeq ON task.TASKNUM=taskeq.TASKNUM LEFT JOIN equip ON taskeq.EQNUM=equip.EQNUM WHERE task.TASKNUM='{$inputPage->input1}' AND taskeq.EQNUM='{$inputPage->input2}'";
$inputPage->flow();
?>    