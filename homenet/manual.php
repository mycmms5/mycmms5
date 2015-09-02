<?PHP
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class manual extends inputPageSmarty {
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
        $tpl->display("tab_manual.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO palm_manuals (Brand,Content,Location) VALUES (:brand,:content,:location)",
                    array("brand"=>$_REQUEST['Brand'],"content"=>$_REQUEST['Content'],"location"=>$_REQUEST['Location']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE palm_manuals SET Brand=:brand,Content=:content,Location=:location WHERE ID=:id",
                    array("brand"=>$_REQUEST['Brand'],"content"=>$_REQUEST['Content'],"location"=>$_REQUEST['Location'],"id"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new manual();
$inputPage->data_sql="SELECT * FROM palm_manuals WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>
