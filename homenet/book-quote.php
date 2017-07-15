<?php
/** tab_quote
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20111207
* @access  public
* @package tabwindow
* @subpackage books
*/
require("../includes/tw_header.php");
/**
* class book_quote
* @package tabwindow
* @subpackage books
*/
class book_quote extends inputPageSmarty {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
    $DB=DBC::get();
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("parent",$this->template);
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign("data",$data);
    $tpl->display('extends:'.$this->template.'|tw/tw_header.tpl');
} // End page_content
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        $num=DBC::fetchcolumn("SELECT COUNT(*) from Quotes WHERE BookID={$this->input1}",0);
        if($num == 0) {   
            DBC::execute("INSERT INTO Quotes (QuoteID,Quote,BookID) VALUES (NULL,:quote,:id1)",array("quote"=>$_REQUEST['Quote'],"id1"=>$_REQUEST['id1']));
        } else {
            DBC::execute("UPDATE Quotes SET Quote=:quote WHERE BookID=:id1",array("quote"=>$_REQUEST['Quote'],"id1"=>$_REQUEST['id1']));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
    }
}    
} // End class

$inputPage=new book_quote();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM quotes WHERE BookID={$inputPage->input1}";
$inputPage->flow();
?>


