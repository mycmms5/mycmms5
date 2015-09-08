<?PHP
/** tab_hama_video for DVD
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package homenet
*/
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class hama extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM cd_mag2 WHERE CDID={$this->input1} ORDER BY SubID");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('cdmags',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->display('tab_hama_cdmag.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['HAMA']=="-1") {
            DBC::execute("DELETE FROM cd_mag2 WHERE ID=:id",array("id"=>$_REQUEST['ID']));
        } else {
            DBC::execute("UPDATE cd_mag2 SET CDID=:cdid,SubID=:cd,HAMA=:hama WHERE ID=:id",array("id"=>$_REQUEST['ID'],"cdid"=>$this->input1,"cd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA']));
        }
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
        DBC::execute("INSERT INTO cd_mag2 (ID,CDID,SubID,HAMA) VALUES (NULL,:cdid,:cd,:hama)",array("cdid"=>$this->input1,"cd"=>$_REQUEST['SubID'],"hama"=>$_REQUEST['HAMA'])); 
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
$inputPage->version=$version;
$inputPage->flow();
?>
