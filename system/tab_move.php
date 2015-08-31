<?PHP
/**
* Changing the file description, the content
*  
* @author  Werner Huysmans 
* @access  public
* @package framework
* @subpackage linking_docs
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class movePage extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data',$data);
    $tpl->display_error("tw/movefile.tpl");
} // EO page_content
function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
/**        
        if ($_REQUEST['FILENAME_NEW']!=$_REQUEST['FILENAME_OLD']) {
            DBC::execute("UPDATE document_descriptions SET FILENAME=:filename_new WHERE FILENAME=:filename_old",
                array("filename_new"=>$_REQUEST['FILENAME_NEW'],"filename_old"=>$_REQUEST['FILENAME_OLD']));
            // Since this is a pure renaming, we must relink
            $basename=basename($_REQUEST['FILENAME_NEW']);
            DBC::execute("UPDATE document_links SET FILENAME=:filename_new,BASENAME=:basename WHERE FILENAME=:filename_old",
                array("filename_new"=>$_REQUEST['FILENAME_NEW'],"basename"=>$basename,"filename_old"=>$_REQUEST['FILENAME_OLD']));
        }
*/        
        DBC::execute("UPDATE dd SET filedescription=:filedescription WHERE filename=:filename_new",
            array("filedescription"=>$_REQUEST['FILEDESCRIPTION'],"filename_new"=>$_REQUEST['FILENAME_NEW']));
        $DB->commit();        
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    } // EO try
//    $_SESSION['filename']=$_REQUEST['FILENAME_NEW'];
//    $this->input1=$_REQUEST['FILENAME_NEW'];
} // EO process_form
} // EO Class

$inputPage=new movePage();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM dd WHERE filename='{$_SESSION['filename']}'";
$inputPage->flow();
?>    