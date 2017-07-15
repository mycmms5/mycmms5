<?PHP 
/**
* tabwindow for Music Editing
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package tabwindow
* @subpackage music
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

/**
* class MusicEdit
* @package tabwindow
* @subpackage music
*/
class MusicEdit extends inputPageSmarty {
    public function page_content() {
        $data=$this->get_data($this->input1,$this->input2);
        $DB=DBC::get();
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("data",$data);
        
        $tpl->assign("composers",$DB->query("SELECT DISTINCT NAME AS id, NAME AS text FROM tbl_Composers ORDER BY NAME",PDO::FETCH_NUM));
        $tpl->assign("categories",$DB->query("SELECT Category AS id, Description AS text FROM tbl_MusicCategories ORDER BY Category",PDO::FETCH_NUM));
        $tpl->assign("ratings",$DB->query("SELECT Rating AS id, Description AS text FROM tbl_RATING ORDER BY Rating",PDO::FETCH_NUM));
        $tpl->assign("formats",$DB->query("SELECT Format AS id, Description AS text FROM tbl_format ORDER BY Format",PDO::FETCH_NUM));
        $tpl->assign("audios",$DB->query("SELECT format AS id,Description AS text FROM tbl_AUDIO ORDER BY format",PDO::FETCH_NUM));
        $tpl->assign("storage",$DB->query("SELECT storage AS id,Description AS text FROM tbl_itunes ORDER BY storage",PDO::FETCH_NUM));
               
        $tpl->display($this->template);
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
#            DebugBreak();
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") { 
                DBC::execute("INSERT INTO Records (RecordingID,Artist,Title,Category,Format,Audio,Classification,Label,Rating,Performer,STORAGE) 
                    VALUES (NULL,:artist,:title,:category,:format,:audio,:classification,:label,:rating,:performer,:storage)",
                array("artist"=>$_REQUEST['Artist'],"title"=>$_REQUEST['Title'],"category"=>$_REQUEST['Category'],"audio"=>$_REQUEST['Audio'],"format"=>$_REQUEST['Format'],"classification"=>$_REQUEST['Classification'],"label"=>$_REQUEST['Label'],"rating"=>$_REQUEST['Rating'],"performer"=>$_REQUEST['Performer'],"storage"=>$_REQUEST['STORAGE']));  
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {
                DBC::execute("UPDATE Records SET Artist=:artist,Title=:title,Performer=:performer,Category=:category,Audio=:audio,Format=:format,Label=:label,Classification=:classification,Rating=:rating,STORAGE=:storage WHERE RecordingID=:id1",
                array("artist"=>$_REQUEST['Artist'],"title"=>$_REQUEST['Title'],"performer"=>$_REQUEST['Performer'],"category"=>$_REQUEST['Category'],"format"=>$_REQUEST['Format'],"label"=>$_REQUEST['Label'],"classification"=>$_REQUEST['Classification'],"audio"=>$_REQUEST['Audio'],"rating"=>$_REQUEST['Rating'],"storage"=>$_REQUEST['STORAGE'],"id1"=>$_REQUEST['id1']));            
            }
#            DebugBreak();
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form
}

$inputPage=new MusicEdit();
$inputPage->data_sql="SELECT * FROM records WHERE RecordingID={$inputPage->input1}";
$inputPage->flow();
?>

