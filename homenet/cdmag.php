<?php
/**
* tabwindow for Software, Information and logbook
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package tabwindow
* @subpackage software
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
/**
* class software
* @package tabwindow
* @subpackage software
* @todo review last location
*/
class software extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("categories",$DB->query("SELECT category AS id, description AS text FROM tbl_software_categories",PDO::FETCH_NUM));
    $tpl->assign("boxes",$DB->query("SELECT storage AS id,CONCAT(description,' (',storage,')') AS text FROM tbl_storage",PDO::FETCH_NUM));
    $tpl->assign("latest_location",DBC::fetchcolumn("SELECT MAX(Classification) FROM CD_Mag",0));
    $tpl->display("tw/software.tpl");
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") {   
            DBC::execute("INSERT INTO software (ID,date_ID,category,title,content,box,classification) VALUES (NULL,:date_ID,:category,:title,:content,:box,:classification)",array("date_ID"=>$_REQUEST['date_ID'],"category"=>$_REQUEST['category'],"title"=>$_REQUEST['title'],"content"=>$_REQUEST['content'],"box"=>$_REQUEST['box'],"classification"=>$_REQUEST['classification']));
            $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;
        } else {
            DBC::execute("UPDATE software SET date_ID=:date_ID,category=:category,title=:title,content=:content,box=:box,classification=:classification WHERE ID=:id1",array("date_ID"=>$_REQUEST['date_ID'],"category"=>$_REQUEST['category'],"title"=>$_REQUEST['title'],"content"=>$_REQUEST['content'],"box"=>$_REQUEST['box'],"classification"=>$_REQUEST['classification'],"id1"=>$_REQUEST['id1']));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}    
} // End class

$inputPage=new software();
/**
* Source date for FORM: SELECT * FROM software WHERE ID=?
*/
$inputPage->data_sql="SELECT * FROM software WHERE ID={$inputPage->input1}";
$inputPage->flow();
?>

