<?PHP
/** tab_hama_video for DVD
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package homenet
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));

class hama extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM video2 WHERE VideoID={$this->input1} ORDER BY SubID");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('dvds',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display('tw/video_hama.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE video2 SET VideoID=:video,SubID=:dvd,HAMA=:hama WHERE ID=:id",array("id"=>$_REQUEST['ID'],"video"=>$this->input1,"dvd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA']));
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
        DBC::execute("INSERT INTO video2 (ID,VideoID,SubID,HAMA) VALUES (NULL,:video,:dvd,:hama)",array("video"=>$this->input1,"dvd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA'])); 
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

$inputPage=new hama();
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));
// $inputPage->js="document.INSERT.TrackTitle.style.background='lightblue'; document.INSERT.TrackTitle.focus();";
$inputPage->flow();
?>
