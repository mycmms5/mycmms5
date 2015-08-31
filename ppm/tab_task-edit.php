<?PHP
/** 
* @author  Werner Huysmans
* @access  public
* @package ppm
* @subpackage standard
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class taskeditPage extends inputPageSmarty {
public function validate_form() {
    $_SESSION['form_data']=serialize($_REQUEST);
    $errors = array();
    $DB=DBC::get();
    $found=DBC::fetchcolumn("SELECT COUNT(*) FROM equip WHERE EQNUM='{$_REQUEST['EQNUM']}'",0);
    if ($found == 0) { $errors['EQNUM']=_("TASK_ERROR:EQNUM");   }
    if (empty($_REQUEST['TASKNUM'])) { $errors['TASKNUM']=_("TASK_ERROR:TASKNUM"); }
    if (empty($_REQUEST['TASK_DESCRIPTION'])) { $errors['DESCRIPTION']=_("TASK_ERROR:TASK_DESCRIPTION"); }
    if (empty($_REQUEST['TEXTS_A'])) { $errors['TEXTS_A']=_("TASK_ERROR:TEXTS_A"); }
    return $errors;
}    
public function page_content() {
    $DB=DBC::get();
    if ($_SESSION['Ident_1']=="new") {  // New demand or adding missing information
        $data=unserialize($_SESSION['form_data']);
    } else {  
        $sql="SELECT task.TASKNUM,taskeq.EQNUM,task.DESCRIPTION AS 'TASK_DESCRIPTION',task.TEXTS_A,equip.DESCRIPTION AS 'DESCRIPTION' FROM task 
            LEFT JOIN taskeq ON task.TASKNUM=taskeq.TASKNUM 
            LEFT JOIN equip ON taskeq.EQNUM=equip.EQNUM
            WHERE task.TASKNUM='{$this->input1}' AND taskeq.EQNUM='{$this->input2}'";
        $result=$DB->query($sql);
        $data=$result->fetch(PDO::FETCH_ASSOC);
    }
   
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->display_error("tw/task-edit.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    if ($_SESSION['Ident_1']=="new") { 
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO task (TASKNUM,DESCRIPTION,TEXTS_A,WOTYPE) VALUES (:tasknum,:short_description,:long_description,:wotype)",array("tasknum"=>$_REQUEST['TASKNUM'],"short_description"=>$_REQUEST['TASK_DESCRIPTION'],"long_description"=>$_REQUEST['TEXTS_A'],"wotype"=>$_REQUEST['WOTYPE']));
            DBC::execute("INSERT INTO taskeq(TASKNUM,EQNUM,SCHEDTYPE,LASTPERFDATE,NEXTDUEDATE,DATEUNIT,NUMOFDATE,LAUNCH,ACTIVE) VALUES (:tasknum,:eqnum,'F','20000101','20000101','D',30,-1,-1)",array("tasknum"=>$_REQUEST['TASKNUM'],"eqnum"=>$_REQUEST['EQNUM']));
            $DB->commit();
            unset($_SESSION['form_data']);
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        $_SESSION['Ident_1']=$_REQUEST['TASKNUM'];
        $_SESSION['Ident_2']=$_REQUEST['EQNUM'];
        $this->input1=$_REQUEST['TASKNUM'];
        $this->input2=$_REQUEST['EQNUM'];
    } else {
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE task SET DESCRIPTION=:DESCRIPTION,TEXTS_A=:TEXTS_A WHERE TASKNUM=:TASKNUM",
            array("TASKNUM"=>$_REQUEST['id1'],"DESCRIPTION"=>$_REQUEST['TASK_DESCRIPTION'],"TEXTS_A"=>$_REQUEST['TEXTS_A']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
    }
} // EO Processform
} // End class

$inputPage=new taskeditPage();
$inputPage->version=$version; 
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>    