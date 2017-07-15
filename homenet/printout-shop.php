<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @package homenet4
* @version 4.0 201106
* @subpackage printout
* @filesource
* @tpl printout_music.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
# Data preparation
$DB=DBC::get();
class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
    $tpl->assign("SHOP",$this->input1);
    $tpl->assign("tickets",$DB->query("SELECT ID AS 'ID', PurchaseDate AS 'Date', Shop AS 'SHOP', Item AS 'Item', Price AS 'Price', Enddate AS 'End', Type AS 'Type', Manual AS 'Manual' FROM Guarantee WHERE Shop='".$this->input1."' ORDER BY PurchaseDate DESC"),PDO::FETCH_NUM);
    $tpl->display_error($this->template);
} // End page_content
} // EO InputPageSmarty
$inputPage=new thisPage();
$inputPage->version=$version;
#$inputPage->data_sql="SELECT * FROM books WHERE BookID={$inputPage->input1}";
$inputPage->flow();
?>
