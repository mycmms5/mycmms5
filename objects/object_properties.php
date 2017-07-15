<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    $security_data=DBC::fetchcolumn("SELECT data FROM equip_properties WHERE EQNUM='{$this->input1}'",0);
    $a_data=unserialize($security_data);
    $eqtype=DBC::fetchcolumn("SELECT EQTYPE FROM equip WHERE EQNUM='{$this->input1}'",0);
    $this->template="tw/eqtype_motor.tpl";
        
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign("data",$data);
    $tpl->assign("sec",$a_data);
    $tpl->display_error($this->template);
}//EO page_content
public function process_form() {
    $DB=DBC::get();
    $a_data=serialize($_REQUEST);
    try {
        $DB->beginTransaction();
        $existing_properties=DBC::fetchcolumn("SELECT data FROM equip_properties WHERE EQNUM='{$this->input1}'",0);
        if ($existing_properties) {
            DBC::execute("UPDATE equip_properties SET data=:data WHERE EQNUM=:eqnum",
                array("eqnum"=>$this->input1,"data"=>$a_data));
        } else {
            DBC::execute("INSERT INTO equip_properties (EQNUM,DATA) VALUES(:eqnum,:data)",                   
                array("eqnum"=>$this->input1,"data"=>$a_data));
        }
        $DB->commit();
    } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
    }//EO try     
}//EO process_form
}// End class

$inputPage=new thisPage();
$inputPage->data_sql="SELECT * FROM equip WHERE EQNUM='{$inputPage->input1}'";
$inputPage->flow();
?>
