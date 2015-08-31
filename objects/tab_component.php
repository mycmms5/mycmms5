<?PHP
/** 
* Components 
* 
* @author  Werner Huysmans 
* @access  public
* @package objects
* @subpackage components
* @filesource
* @todo DB transaction
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$OPNUM_ID=$_REQUEST['ID'];

class componentsPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT * FROM equip WHERE EQFL='COMP' AND EQROOT='{$this->input1}'";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
/*    $labels=array(
    "DBFLD_EQNUM"=>_("DBFLD_EQNUM"),
    "DBFLD_EQTYPE"=>_("DBFLD_EQTYPE"),
    "DBFLD_DESCRIPTION"=>_("DBFLD_DESCRIPTION")
    );
    */

    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('components',$data);
//    $tpl->assign('labels',$labels);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('eqtypes',$DB->query("SELECT EQTYPE AS 'id',EQTYPE AS 'text' FROM eqtype",PDO::FETCH_NUM));
    $tpl->display_error('tab_component.tpl');    
}
function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE equip SET EQTYPE=:eqtype,DESCRIPTION=:description WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['ID'],"eqtype"=>$_REQUEST['EQTYPE'],"description"=>$_REQUEST['DESCRIPTION']));
            $DB->commit();        
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
    case "INSERT":
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO equip (EQROOT,EQNUM,EQTYPE,DESCRIPTION,EQFL) VALUES(:eqroot,:eqnum,:eqtype,:description,'COMP')",array("eqroot"=>$this->input1,"eqnum"=>$_REQUEST['EQNUM'],"eqtype"=>$_REQUEST['EQTYPE'],"description"=>$_REQUEST['DESCRIPTION']));
            $id=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$this->input1}'",0);
            DBC::execute("UPDATE equip SET parent={$parent},children=0 WHERE postid={$id}",array());
            DBC::execute("UPDATE equip SET children=1 WHERE postid={$parent}",array());
            $DB->commit();        
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
    default:
        break;                           
    }
} // End process_form
} // End of class

$inputPage=new componentsPage();
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>