<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class software extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("categories",array("Delete","Active","Archive"));
        $tpl->assign("sitetypes",array("INFO","eBusiness","eStore"));
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->display("tw/software.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO palm_software (Software,Code) VALUES (:software,:code)",
                    array("software"=>$_REQUEST['Software'],"code"=>$_REQUEST['Code']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE palm_software SET Software=:software,Code=:code WHERE ID=:id",
                    array("software"=>$_REQUEST['Software'],"code"=>$_REQUEST['Code'],"id"=>$_SESSION['Ident_1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new software();
$inputPage->data_sql="SELECT * FROM palm_software WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>
   