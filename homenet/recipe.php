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
        $tpl->display("tab_recipe.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO recipes (ID,Recipe,Ingredients,Preparation) VALUES (null,:recipe,:ingredients,:preparation)",
                    array("recipe"=>$_REQUEST['Recipe'],"ingredients"=>$_REQUEST['Ingredients'],"preparation"=>$_REQUEST['Preparation']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE recipes SET Recipe=:recipe,Ingredients=:ingredients,Preparation=:preparation WHERE ID=:id",
                    array("recipe"=>$_REQUEST['Recipe'],"ingredients"=>$_REQUEST['Ingredients'],"preparation"=>$_REQUEST['Preparation'],"id"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new password();
$inputPage->data_sql="SELECT * FROM recipes WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>