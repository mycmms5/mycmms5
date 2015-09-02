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
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$ID = $_REQUEST['id1'];

# Data preparation
$DB=DBC::get();
// DebugBreak();
$result=$DB->query("SELECT * FROM records WHERE RecordingID=$ID");
$music_data=$result->fetch(PDO::FETCH_ASSOC);
$directory=floor($ID/100);

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("doc_path",DOC_LINK."music/".$directory."/");
$tpl->assign("music_data",$music_data);
$tpl->assign("tracks",$DB->query("SELECT * FROM tracks WHERE RecordingID={$ID}",PDO::FETCH_ASSOC));
$PrtScn=true;
if($PrtScn) {
    $tpl->display('printout_music.tpl');
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