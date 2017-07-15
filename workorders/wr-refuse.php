<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @version $Id: tab_wr-refuse.php,v 1.3 2013/07/30 10:36:58 werner Exp $4.0 201106
* @package work
* @subpackage approval
* @filesource
* @tpl tab_wr-approve.tpl
* @txid Inside
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class wrRefusePage extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=(array)$this->get_data($this->input1,$this->input2);
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
        $tpl->assign('data',$data);
        $tpl->display_error($this->template);
    }// EO page_content
    function process_form() {
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO wo_refused (WONUM,EQNUM,TASKDESC,ORIGINATOR,REQUESTDATE,REJECTDATE,REASON)  VALUES(:WONUM,:EQNUM,:TASKDESC,:ORIGINATOR,:REQUESTDATE,NOW(),:REASON)",array("WONUM"=>$_REQUEST['id1'],"EQNUM"=>$_REQUEST['id2'],"TASKDESC"=>$_REQUEST['TASKDESC'],"ORIGINATOR"=>$_REQUEST['ORIGINATOR'],"REQUESTDATE"=>$_REQUEST['REQUESTDATE'],"REASON"=>$_REQUEST['REASON']));     
            DBC::execute("DELETE FROM WO WHERE WONUM=:WONUM",array("WONUM"=>$_REQUEST['id1']));        
            $DB->commit();    
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
    } // EO process_form
}

$inputPage=new wrRefusePage();
$inputPage->data_sql="SELECT * FROM wo WHERE WONUM={$inputPage->input1}";
$inputPage->flow();
?>
