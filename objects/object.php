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
/**
* Search the children...
*/
    $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_SESSION['Ident_1']}'",0);
    $result=$DB->query("SELECT * FROM equip WHERE parent='$parent'",PDO::FETCH_ASSOC);
    $data_children=$result->fetchAll(PDO::FETCH_ASSOC);
/**
* Search the documents...
*/
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->assign('stylesheet',STYLE_PATH."smarty_base.css");
    $tpl->assign('data',$data);
    $tpl->assign('children',$data_children);
if (CMMS_DB=="VPK") {
    $result=$DB->query("SELECT dl.*,dd.* FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='{$_SESSION['Ident_1']}'",PDO::FETCH_ASSOC);
    $data_docs=$result->fetchAll(PDO::FETCH_ASSOC);
    $tpl->assign('docs',$data_docs);
    $tpl->assign('eqtypes',$DB->query("SELECT EQTYPE AS id, DESCRIPTION AS text FROM eqtype",PDO::FETCH_NUM));

    $tpl->assign('floc',$DB->query("SELECT EQFL AS id, DESCRIPTION AS text FROM eqfloc",PDO::FETCH_NUM));
    $tpl->assign('ccs',$DB->query("SELECT COSTCENTER AS id, COSTCENTER AS text FROM vpk_costcenter",PDO::FETCH_NUM));
    $tpl->assign('wincc',DBC::fetchcolumn("SELECT wc.EQNUM FROM equip e LEFT JOIN tmp_wincc wc ON e.SCADA=wc.EQNUM WHERE e.EQNUM='{$_SESSION[Ident_1]}'",0));
    $tpl->assign('units',$DB->query("SELECT unit AS id, unit AS text FROM vpk_unit",PDO::FETCH_NUM));
}
    $tpl->display_error($this->template);
} // EO page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['NEW']){
        /**
        * INSERT data into equip 
        * Retrieve the postid of the new object
        * Retrieve the postid of the parent object
        * Adjust the parent of the new object
        * Set children=1 for the parent object
        */
                DBC::execute("INSERT INTO equip (EQNUM,EQROOT,DESCRIPTION,EQFL,EQORDER,postid,children) VALUES (:eqnum,:eqroot,:description,:eqfl,:eqorder,NULL,1)",
                    array("eqnum"=>$_REQUEST['EQNUM'],"eqroot"=>$_REQUEST['EQROOT'],"description"=>$_REQUEST['DESCRIPTION'],"eqorder"=>$_REQUEST['EQORDER'],"eqfl"=>"NEW"));
                $postid=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_REQUEST['EQROOT']}'",0);
                $level=DBC::fetchcolumn("SELECT LEVEL FROM equip WHERE parent={$parent}");
                DBC::execute("UPDATE equip SET parent=:parent,LEVEL={$level}+1,children=0 WHERE postid=:postid",array("postid"=>$postid,"parent"=>$parent));
                DBC::execute("UPDATE equip SET children=1 WHERE postid=:parent",array("parent"=>$parent));
                $DB->commit();
        } else {
                $eqfl=$_REQUEST['EQFL'];
                if ($_REQUEST['EQROOT']!=$_REQUEST['EQROOT_OLD']) {  $eqfl='MOV'; } # Change to MOV when the root is changed
                if ($_REQUEST['EQFL']=="NEW") { $eqfl="NEW"; }
                
        /**
        * Retrieve the postid of the parent object
        * INSERT data into equip 
        * Adjust children if object has children
        * Adjust LEVEL of object by LEVEL-parent+1
        * Set children=1 for the parent object
        */
                $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_REQUEST['EQROOT']}'",0);
                DBC::execute("UPDATE equip SET EQTYPE=:eqtype,COSTCENTER=:costcenter,EQROOT=:eqroot,DESCRIPTION=:description,EQFL=:eqfl,EQORDER=:eqorder,SAFETYNOTE=:safetynote,parent=:parent,children=:children WHERE EQNUM=:eqnum",
                array("eqnum"=>$_REQUEST['id1'],"eqtype"=>$_REQUEST['EQTYPE'],"eqroot"=>$_REQUEST['EQROOT'],"costcenter"=>$_REQUEST['COSTCENTER'],"eqorder"=>$_REQUEST['EQORDER'],"description"=>$_REQUEST['DESCRIPTION'],"eqfl"=>$eqfl,"parent"=>$parent,"children"=>$_REQUEST['children'],"safetynote"=>$_REQUEST['SAFETYNOTE']));
/**
* DONE: Check if element has children
*/
                $HasChildren=DBC::fetchcolumn("SELECT COUNT(*) FROM equip WHERE EQROOT='{$_REQUEST['id1']}'",0);
                if ($HasChildren > 0) {
                    DBC::execute("UPDATE equip SET children=1 WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['EQNUM']));
                } else {
                    DBC::execute("UPDATE equip SET children=0 WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['EQNUM']));
                }
                $levelParent=DBC::fetchcolumn("SELECT LEVEL FROM equip WHERE parent={$parent}");
                DBC::execute("UPDATE equip SET LEVEL=:levelParent WHERE postid=:postid",array("postid"=>$postid,"levelParent"=>$levelParent+1));
                DBC::execute("UPDATE equip SET children=1 WHERE postid=:parent",array("parent"=>$parent));
/**
* DONE: Recalculate the LEVEL after a move
*/
                $DB->commit();
        } // EO else
        } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
        } // EO try 
        $this->input1=$_SESSION['Ident_1']=$_REQUEST['EQNUM'];
        $this->input2=$_SESSION['Ident_2']=$_REQUEST['EQNUM'];
} // EO process_form
} // EO class

$inputPage=new objectPage();
$inputPage->data_sql="SELECT e.*,e2.DESCRIPTION AS 'EQROOT_DESC' FROM equip e LEFT JOIN equip e2 ON e.parent=e2.postid WHERE e.EQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>

