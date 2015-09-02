<?PHP
/** tab_tracks for Record Tracks        
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package homenet
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class tracks extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $result=$DB->query("SELECT * FROM tracks WHERE RecordingID={$this->input1} ORDER BY CDNumber,TrackNumber");
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
        $actualCD=DBC::fetchcolumn("SELECT MAX(CDNumber) FROM tracks WHERE RecordingID={$this->input1}",0);
        if ($actualCD) {
            $nextTrackNumber=DBC::fetchcolumn("SELECT MAX(TrackNumber)+1 AS NEXT FROM tracks WHERE RecordingID={$this->input1} AND CDNumber={$actualCD}",0); 
        } else {
            $actualCD=1;
            $nextTrackNumber=1;        
        }
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->caching=false;
        $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign('tracks',$data);
        $tpl->assign('actual_id',$_REQUEST['ID']);
        $tpl->assign('nextTrackNumber',$nextTrackNumber);
        $tpl->display('tw/music_tracks.tpl');    
    } // EO page_content
private function updateRecord($data) {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        DBC::execute("UPDATE tracks SET CDNumber=:cdnumber,TrackNumber=:tracknumber,TrackTitle=:tracktitle,TrackLength=:tracklength WHERE TrackID=:trackid",array("cdnumber"=>$_REQUEST["CDNumber"],"tracknumber"=>$_REQUEST['TrackNumber'],"tracktitle"=>$_REQUEST['TrackTitle'],"tracklength"=>$_REQUEST['TrackLength'],"trackid"=>$_REQUEST['ID']));
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
} // End updateRecord
private function insertRecord() {
    DBC::execute("INSERT INTO tracks (TrackID,CDNumber,TrackNumber,TrackTitle,TrackLength,RecordingID) VALUES (NULL,:cdnumber,:tracknumber,:tracktitle,:tracklength,:recordingid)",array("cdnumber"=>$_REQUEST['CDNumber'],"tracknumber"=>$_REQUEST['TrackNumber'],"tracktitle"=>$_REQUEST['TrackTitle'],"tracklength"=>$_REQUEST['TrackLength'],"recordingid"=>$_SESSION['Ident_1'])); 
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

$inputPage=new tracks();
$inputPage->version=$version;
$inputPage->js="document.INSERT.TrackTitle.style.background='lightblue'; document.INSERT.TrackTitle.focus();";
$inputPage->flow();
?>
    