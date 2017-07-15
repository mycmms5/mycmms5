<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    $billing_data=DBC::fetchcolumn("SELECT BILL FROM cash WHERE ID='{$this->input1}'",0);
    $a_data=unserialize($billing_data);
        
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign("data",$data);
    $tpl->assign("bill",$a_data);
    $tpl->display_error($this->template);
}//EO page_content
public function process_form() {
    $DB=DBC::get();
    $a_data=serialize($_REQUEST);
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE cash SET BILL=:data WHERE ID=:id",
                array("id"=>$this->input1,"data"=>$a_data));
        $DB->commit();
    } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
    }//EO try     
}//EO process_form
}// End class

$inputPage=new thisPage();
$inputPage->data_sql="SELECT * FROM cash WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>
