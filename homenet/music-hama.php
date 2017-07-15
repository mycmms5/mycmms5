<?PHP
/** tab_tracks for Record Tracks        
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package homenet
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class hama extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM records2 WHERE RecordingID={$this->input1} ORDER BY SubID");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('cds',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display($this->template);    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE records2 SET RecordingID=:cdid,SubID=:cd,HAMA=:hama WHERE ID=:id",array("id"=>$_REQUEST['ID'],"cdid"=>$this->input1,"cd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA']));
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
        DBC::execute("INSERT INTO records2 (ID,RecordingID,SubID,HAMA) VALUES (NULL,:cdid,:cd,:hama)",array("cdid"=>$this->input1,"cd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA'])); 
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
// $inputPage->js="document.INSERT.TrackTitle.style.background='lightblue'; document.INSERT.TrackTitle.focus();";
$inputPage->flow();
?>