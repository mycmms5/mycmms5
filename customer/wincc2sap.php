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
    $tpl->assign('stylesheet',STYLE_PATH."smarty_base.css");
    $tpl->assign('stylesheet_tw',STYLES_PATH.'tw.css');
    $tpl->assign('data',$data);
    $tpl->display_error("c_vpk/wincc2sap.tpl");
} // EO page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO equip (EQNUM,EQROOT,DESCRIPTION,EQFL,SCADA) 
            VALUES (:eqnum,:eqroot,:description,'NEW',:scada)",
            array("eqnum"=>$_REQUEST['EQNUM'],
                "eqroot"=>$_REQUEST['EQROOT'],
                "description"=>$_REQUEST['SCADA_DESCRIPTION'],
                "scada"=>$_REQUEST['SCADA']));
            $postid=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $parent=DBC::fetchcolumn("SELECT postid FROM equip WHERE EQNUM='{$_REQUEST['EQROOT']}'",0);
            DBC::execute("UPDATE equip SET parent=:parent WHERE postid=:postid",array("postid"=>$postid,"parent"=>$parent));
            $DB->commit();
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
#$inputPage->input1=$_SESSION['Ident_1'];
#$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->data_sql="SELECT w.EQNUM AS 'scada',w.DESCRIPTION AS 'scada_description',e.EQNUM AS 'QAS',e.EQROOT AS 'QAS_ROOT' FROM tmp_wincc w LEFT JOIN equip e ON w.EQNUM=e.SCADA WHERE w.EQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>

