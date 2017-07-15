<?PHP
/** tab_bookseries for books
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package tabwindow
* @subpackage books
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));
/**
* class book_series
* @package tabwindow
* @subpackage books
*/
class book_series extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM books2 WHERE BookID={$this->input1} ORDER BY SubID");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('books',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display('tw/bookseries.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE books2 SET BookID=:book,SubID=:booknr,Title=:title WHERE ID=:id",array("id"=>$_REQUEST['ID'],"book"=>$this->input1,"booknr"=>$_REQUEST['SubID'],"title"=>$_REQUEST['Title']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End updateRecord
private function insertRecord() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("INSERT INTO books2 (ID,BookID,SubID,Title) VALUES (NULL,:book,:booknr,:title)",array("book"=>$this->input1,"booknr"=>$_REQUEST['SubID'],"title"=>$_REQUEST['Title']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End insertRecord
function process_form() {   // Only Updating...
        switch ($_REQUEST['ACTION']) {
        case "UPDATE":
            $this->updateRecord($_REQUEST);        
            break;
        case "INSERT":
            $this->insertRecord($_REQUEST);
            break;
        default:
            break;                           
        }
    } // EO process_form
} // EO class 

$inputPage=new book_series();
$inputPage->version=$version;
$inputPage->flow();
?>
