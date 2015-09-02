<?php
/** 
* @author  Werner Huysmans 
* @access  public
* @package printout
* @version 4.0 201106
* @subpackage books
* @filesource
* @tpl printout_music.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$PrtScn=true;
$ID = $_REQUEST['id1'];

# Data preparation
$DB=DBC::get();
// DebugBreak();
$result=$DB->query("SELECT * FROM books WHERE BookID=$ID");
$book_data=$result->fetch(PDO::FETCH_ASSOC);


# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("book_data",$book_data);
$tpl->assign("quotes",$DB->query("SELECT * FROM quotes WHERE BookID={$ID}",PDO::FETCH_ASSOC));
$tpl->assign("series",$DB->query("SELECT * FROM books2 WHERE BookID={$ID}",PDO::FETCH_ASSOC));
if($PrtScn) {
    $tpl->display('printout_book.tpl');
} else {
    require('HTML2PDF/html2fpdf.php');
    require("HTML/Table.php");
    $html_content=$tpl->fetch('printout_wo.tpl');
//    $fh=fopen("test.html","w");
//    fwrite($fh,$html_content);
//    fclose($fh);
    $pdf=new HTML2FPDF();
    $pdf->AddPage();
    $pdf->WriteHTML($html_content);
    $pdf->Output("WO_PrintOut.pdf");   
    echo "Work Order printout succeeded <a href='WO_PrintOut.pdf'>PDF PrintOut</a>";
}
?>
