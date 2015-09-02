<?php
/**
* tabwindow for Book Editing
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package tabwindow
* @subpackage books
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

/**
* class BookEdit
* @package tabwindow
* @subpackage books
*/
class book extends inputPageSmarty {
/**
* page_content: builds the page with SMARTY templates
*/
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    // $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign("data",$data);
    $tpl->assign("publishers",$DB->query("SELECT DISTINCT Publisher AS id, Publisher AS text FROM Books ORDER BY id",PDO::FETCH_NUM));
    $tpl->assign("topics",$DB->query("SELECT Topic AS id, Description AS text FROM tbl_BookTopic ORDER BY Topic",PDO::FETCH_NUM));
    $tpl->assign("stores",$DB->query("SELECT STORAGE AS id, Description AS text FROM tbl_BookStores",PDO::FETCH_NUM));
    $tpl->display("tw/book.tpl");
} // End page_content
/**
* process_form() handles the form and INSERT or UPDATE the Books table
* 
*/
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        if ($_REQUEST['new']=="on") { 
            DBC::execute("INSERT INTO books (Author,Title,Publisher,Topic,Storage,ISBN,PublishDate) VALUES (:author,:title,:publisher,:topic,:storage,:isbn,:publishdate)", array("author"=>$_REQUEST['Author'],"title"=>$_REQUEST['Title'],"publisher"=>$_REQUEST["Publisher"],"topic"=>$_REQUEST['Topic'],"storage"=>$_REQUEST['Storage'],"isbn"=>$_REQUEST['ISBN'],"publishdate"=>$_REQUEST['PublishDate']));                           $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
            $_SESSION['Ident_2']=0;
        } else {
            DBC::execute("UPDATE Books SET Author=:author,Title=:title,Publisher=:publisher,Topic=:topic,ISBN=:isbn,PublishDate=:publishdate,Storage=:storage WHERE BookID=:id1",array("author"=>$_REQUEST['Author'],"title"=>$_REQUEST['Title'],"publisher"=>$_REQUEST['Publisher'],"topic"=>$_REQUEST['Topic'],"isbn"=>$_REQUEST['ISBN'],"publishdate"=>$_REQUEST['PublishDate'],"storage"=>$_REQUEST['Storage'],"id1"=>$_REQUEST['id1']));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}    
} // End class

$inputPage=new book();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM books WHERE BookID={$inputPage->input1}";
$inputPage->flow();
?>

