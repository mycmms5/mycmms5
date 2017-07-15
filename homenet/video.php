<?php
/** tab_video
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package tabwindow
* @subpackage video
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));
/**
* Class Video
* @package tabwindow
* @subpackage video
*/
class Video extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("stylesheet_extra",STYLE_PATH."/".CSS_LIST_TD);
        $tpl->assign("hama",DBC::fetchcolumn("SELECT MIN(HAMA) FROM video2 WHERE VideoID='{$this->input1}'",0));
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->display_error("tw/video.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {    
                DBC::execute("INSERT INTO video (title,director,actors,comment,category,recorded,SubID,storage,HAMA,unviewed) VALUES (:title,:director,:actors,:comment,:category,:recorded,:SubID,:storage,:HAMA,-1)",
                array("title"=>$_REQUEST['title'],"director"=>$_REQUEST['director'],"actors"=>$_REQUEST['actors'],"comment"=>$_REQUEST['comment'],"category"=>$_REQUEST['category'],"recorded"=>$_REQUEST['recorded'],"SubID"=>$_REQUEST['SubID'],"storage"=>$_REQUEST['storage'],"HAMA"=>$_REQUEST['HAMA']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {  
                if ($_REQUEST['unviewed']=="on") {  $unviewed=-1; } else {   $unviewed=0;   }
                DBC::execute("UPDATE video SET title=:title,director=:director,actors=:actors,comment=:comment,category=:category,recorded=:recorded,SubID=:SubID,HAMA=:HAMA,storage=:storage,unviewed=:unviewed WHERE VideoID=:videoid",
                array("title"=>$_REQUEST['title'],"director"=>$_REQUEST['director'],"actors"=>$_REQUEST['actors'],"comment"=>$_REQUEST['comment'],"category"=>$_REQUEST['category'],"recorded"=>$_REQUEST['recorded'],"SubID"=>$_REQUEST['SubID'],"storage"=>$_REQUEST['storage'],"HAMA"=>$_REQUEST['HAMA'],"videoid"=>$_REQUEST['id1'],"unviewed"=>$unviewed));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new Video();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM video WHERE VideoID='{$inputPage->input1}'";
$inputPage->flow();
?>

