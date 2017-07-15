<?PHP
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class ComposerEdit extends inputPageSmarty {
    public function page_content() {
        $data=$this->get_data($this->input1,$this->input2);
        $DB=DBC::get();
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
        $tpl->assign("data",$data);
        $tpl->assign("records",$DB->query("SELECT RecordingID,Title,Format FROM records WHERE Artist='{$this->input1}'",PDO::FETCH_ASSOC));
        $tpl->display($this->template);
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") { 
                DBC::execute("INSERT INTO tbl_composers (NAME,NAMESHORT,BIRTH,DIED,NATIONALITY,TYPE,TEXT) VALUES (:name,:nameshort,:birth,:died,:nationality,:type,:text)",array("name"=>$_REQUEST['NAME'],"nameshort"=>$_REQUEST['NAMESHORT'],"birth"=>$_REQUEST['BIRTH'],"died"=>$_REQUEST['DIED'],"nationality"=>$_REQUEST['NATIONALITY'],"type"=>$_REQUEST['TYPE'],"text"=>$_REQUEST['TEXT']));  
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {
                DBC::execute("UPDATE tbl_composers SET NAME=:name,NAMESHORT=:nameshort,BIRTH=:birth,DIED=:died,NATIONALITY=:nationality,TYPE=:type,TEXT=:text WHERE NAME=:id1",array("name"=>$_REQUEST['NAME'],"nameshort"=>$_REQUEST['NAMESHORT'],"birth"=>$_REQUEST['BIRTH'],"died"=>$_REQUEST['DIED'],"nationality"=>$_REQUEST['NATIONALITY'],"type"=>$_REQUEST['TYPE'],"text"=>$_REQUEST['TEXT'],"id1"=>$_REQUEST['id1']));     
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form
}

$inputPage=new ComposerEdit();
$inputPage->data_sql="SELECT * FROM tbl_composers WHERE NAME='{$inputPage->input2}'"; #$inputPage->input1
$inputPage->flow();
?>

