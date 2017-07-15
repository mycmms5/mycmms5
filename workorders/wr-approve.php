<?php
/** 
* Work approval
* 
* @author  Werner Huysmans 
* @access  public
* @version $Id: tab_wr-approve.php,v 1.2 2013/06/10 09:48:25 werner Exp $4.0 201106
* @package work
* @subpackage approval
* @filesource
* @tpl tab_wr-approve.tpl
* @txid Inside
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class wrApprovePage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);

    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('data',$data);
    $tpl->assign('wotypes',$DB->query("SELECT WOTYPE,DESCRIPTION FROM wotype",PDO::FETCH_NUM));
//    $tpl->assign("originators",$DB->query("SELECT uname as id, longname as text FROM sys_groups ORDER BY uname",PDO::FETCH_NUM));
    $tpl->assign('preparation',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 8)=8",PDO::FETCH_NUM));
    $tpl->assign('supervision',$DB->query("SELECT uname AS id, longname AS text FROM sys_groups WHERE (profile & 4)=4",PDO::FETCH_NUM));
    $tpl->assign('user',$_SESSION['user']);
    $tpl->display_error($this->template);
} // New
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE wo SET APPROVEDBY=:approvedby,APPROVEDDATE=NOW(),WOTYPE=:wotype,WOSTATUS='A',ASSIGNEDBY=:assignedby,ASSIGNEDTO=:assignedto,ESTCOST=:estcost,TEXTS_A=:texts_a WHERE WONUM=:wonum",array("approvedby"=>$_REQUEST['APPROVEDBY'],"wotype"=>$_REQUEST['WOTYPE'],"assignedby"=>$_REQUEST['ASSIGNEDBY'],"assignedto"=>$_REQUEST['ASSIGNEDTO'],"estcost"=>$_REQUEST['ESTCOST'],"texts_a"=>$_REQUEST['COMMENT'],"wonum"=>$_SESSION['Ident_1']));  
        $DB->commit();    
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }
    return("WO ".$this->input1." Approved<BR>");
} // EO process_form
} // End class

$inputPage=new wrApprovePage();
$inputPage->data_sql="SELECT * FROM wo WHERE WONUM={$inputPage->input1}";
$inputPage->flow();
?>
