<?PHP 
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class logbook extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("data",$data);
    $tpl->assign("types",$DB->query("SELECT type AS id,type_description AS text FROM tbl_logadmin",PDO::FETCH_NUM));
    $tpl->assign("ID",$this->input1);
    $tpl->display("tw/logbook_admin.tpl");
} // EO page_content
function process_form() {   // Only updating
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") {    
            DBC::execute("INSERT INTO logbook_admin (ID,sender,content,docdate,type,keep) VALUES (NULL,:sender,:content,:docdate,:type,:keep)",
                array("sender"=>$_REQUEST['sender'],"content"=>$_REQUEST['content'],"docdate"=>$_REQUEST['docdate'],"type"=>$_REQUEST['type'],"keep"=>$_REQUEST['keep']));
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;
        } else {    
            DBC::execute("UPDATE logbook_admin SET content=:content,type=:type,keep=:keep WHERE ID=:id",
                array("content"=>$_REQUEST['content'],"type"=>$_REQUEST['type'],"keep"=>$_REQUEST['keep'],"id"=>$this->input1));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
    } // EO process_form                
} // EO Class

$inputPage=new logbook();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM logbook_admin WHERE ID='{$inputPage->input1}'";
$inputPage->flow();    
?>
