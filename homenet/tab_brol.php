<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class password extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->display("tw/brol.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO palm_brol (Objekt,Brand,Storage) VALUES (:objekt,:brand,:storage)",array("objekt"=>$_REQUEST['Objekt'],"brand"=>$_REQUEST['Brand'],"storage"=>$_REQUEST['Storage']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE palm_brol SET Objekt=:objekt,Brand=:brand,Storage=:storage WHERE ID=:id",array("objekt"=>$_REQUEST['Objekt'],"brand"=>$_REQUEST['Brand'],"storage"=>$_REQUEST['Storage'],"id"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new password();
$inputPage->data_sql="SELECT * FROM palm_brol WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>