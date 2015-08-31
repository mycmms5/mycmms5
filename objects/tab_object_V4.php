<?PHP
/** 
* Create / Edit object
* 
* @author  Werner Huysmans
* @access  public
* @package objects
* @filesource
* @todo direct integration in tree
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class objectPage extends inputPageSmarty {
public function page_content() {
    $obj_data=$this->get_data($this->input1,$this->input2);
    $data=(array)$obj_data;
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->assign('eqtypes',$DB->query("SELECT EQTYPE AS id, DESCRIPTION AS text FROM eqtype",PDO::FETCH_NUM));
    $tpl->assign('ccs',$DB->query("SELECT COSTCENTER AS id, DESCRIPTION AS text FROM costctr",PDO::FETCH_NUM));
    $tpl->display_error("tab_object.tpl");
} // EO page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE equip SET EQTYPE=:eqtype,COSTCENTER=:costcenter,DESCRIPTION=:description,SAFETYNOTE=:safetynote WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['id1'],"eqtype"=>$_REQUEST['EQTYPE'],"costcenter"=>$_REQUEST['COSTCENTER'],"description"=>$_REQUEST['DESCRIPTION'],"safetynote"=>$_REQUEST['SAFETYNOTE']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }    
} // EO process_form
} // EO class

$inputPage=new objectPage();
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->data_sql="SELECT * FROM equip WHERE EQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>

