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
        $tpl->display("tw/storage.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO storage (brand,object,storage,yyyy,category) VALUES (:brand,:object,:storage,:yyyy,:category)",
                array("object"=>$_REQUEST['object'],"brand"=>$_REQUEST['brand'],"storage"=>$_REQUEST['storage'],"yyyy"=>$_REQUEST['yyyy'],"category"=>$_REQUEST['category']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
#                DebugBreak();
                DBC::execute("UPDATE storage SET object=:object,brand=:brand,storage=:storage,yyyy=:yyyy,category=:category WHERE ID=:id",
                array("object"=>$_REQUEST['object'],"brand"=>$_REQUEST['brand'],"storage"=>$_REQUEST['storage'],"yyyy"=>$_REQUEST['yyyy'],"category"=>$_REQUEST['category'],"id"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new password();
$inputPage->data_sql="SELECT * FROM storage WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>