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
    $tpl->assign('stylesheet_tw',STYLES_PATH.'tw.css');
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
    $tpl->display_error("c_vpk/object.tpl");
} // EO page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['NEW']){
                DBC::execute("INSERT INTO equip (EQNUM,EQROOT,DESCRIPTION,EQFL,postid,children) VALUES (:eqnum,:eqroot,:description,:eqfl,NULL,1)",
                    array("eqnum"=>$_REQUEST['EQNUM'],"eqroot"=>$_REQUEST['EQROOT'],"description"=>$_REQUEST['DESCRIPTION'],"eqfl"=>"NEW"));
                $postid=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_REQUEST['EQROOT']}'",0);
                DBC::execute("UPDATE equip SET parent=:parent WHERE postid=:postid",array("postid"=>$postid,"parent"=>$parent));
                $DB->commit();
        } else {
                # DebugBreak();
                $eqfl=$_REQUEST['EQFL'];
                if ($_REQUEST['EQROOT']!=$_REQUEST['EQROOT_OLD']) {  $eqfl='MOV'; } # Change to MOV when the root is changed
                if ($_REQUEST['EQFL']=="NEW") { $eqfl="NEW"; }
                
                $postid=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_REQUEST['EQROOT']}'",0);
                DBC::execute("UPDATE equip SET EQTYPE=:eqtype,COSTCENTER=:costcenter,EQROOT=:eqroot,DESCRIPTION=:description,EQFL=:eqfl,SAFETYNOTE=:safetynote,parent=:parent,children=:children WHERE EQNUM=:eqnum",
                array("eqnum"=>$_REQUEST['id1'],"eqtype"=>$_REQUEST['EQTYPE'],"eqroot"=>$_REQUEST['EQROOT'],"costcenter"=>$_REQUEST['COSTCENTER'],"description"=>$_REQUEST['DESCRIPTION'],"eqfl"=>$eqfl,"parent"=>$postid,"children"=>$_REQUEST['children'],"safetynote"=>$_REQUEST['SAFETYNOTE']));
                # Check if element has children
                $HasChildren=DBC::fetchcolumn("SELECT COUNT(*) FROM equip WHERE EQROOT='{$_REQUEST['id1']}'",0);
                if ($HasChildren > 0) {
                    DBC::execute("UPDATE equip SET children=1 WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['EQNUM']));
                } else {
                    DBC::execute("UPDATE equip SET children=0 WHERE EQNUM=:eqnum",array("eqnum"=>$_REQUEST['EQNUM']));
                }
                $DB->commit();
        } // EO else
        } catch (Exception $e) {
                $DB->rollBack();
                PDO_log($e);
        } // EO try 
?>
<script type="text/javascript"></script>      
<?php        
} // EO process_form
} // EO class

$inputPage=new objectPage();
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->data_sql="SELECT e.*,e2.DESCRIPTION AS 'EQROOT_DESC' FROM equip e LEFT JOIN equip e2 ON e.parent=e2.postid WHERE e.EQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>

