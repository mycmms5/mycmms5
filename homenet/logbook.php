<?PHP 
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPageSmarty.php");

class logbook extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("ID",$this->input1);
    $tpl->display("logbook.tpl");
} // EO page_content
function process_form() {   // Only updating
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") {
            DBC::execute("INSERT INTO logbook (Logbook,Input,Content,Page,Extra,Document) VALUES (:logbook,:input,:content,:page,:extra,NULL)",array("logbook"=>$_REQUEST['Logbook'],"input"=>$_REQUEST['Input'],"content"=>$_REQUEST['Content'],"page"=>$_REQUEST['Page'],"extra"=>$_REQUEST['Extra']));
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;
        } else {    
            DBC::execute("UPDATE logbook SET Logbook=:logbook,Input=:input,Content=:content,Page=:page,Extra=:extra WHERE Document=:id1",array("logbook"=>$_REQUEST['Logbook'],"input"=>$_REQUEST['Input'],"content"=>$_REQUEST['Content'],"page"=>$_REQUEST['Page'],"extra"=>$_REQUEST['Extra'],"id1"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
    } // EO process_form                
} // EO Class

$inputPage=new logbook();
$inputPage->data_sql="SELECT * FROM logbook WHERE Document='{$inputPage->input1}'";
$inputPage->flow();    
?>
