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
$PrtScn=true;
$ID=$_REQUEST['id1'];
$maxImage=11;


# Data preparation
$DB=DBC::get();
// DebugBreak();
$result=$DB->query("SELECT * FROM video WHERE VideoID=$ID");
$video_data=$result->fetch(PDO::FETCH_ASSOC);
// Cover?
$directory=floor($ID/100);
if (file_exists($doc_paths['video'].$directory."/DVD".$ID.".jpg")) {   $CoverAvailable=true;   }
// Extra Images?
$MoreImages=0;
for ($i=1;$i<$maxImage;$i++) {
    $extra=$doc_paths['video'].$directory."/DVD".$ID."_".$i.".jpg";
    if (file_exists($extra)) {  $MoreImages++; }        
}

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("doc_path",DOC_LINK."/video/{$directory}/DVD");
$tpl->assign("video_data",$video_data);
$tpl->assign("CoverAvailable",$CoverAvailable);
$tpl->assign("MoreImages",$MoreImages);
$tpl->assign("hamas",$DB->query("SELECT * FROM video2 WHERE VideoID={$ID}",PDO::FETCH_ASSOC));
if($PrtScn) {
    $tpl->display_error('printout_video.tpl');
} else {
    require('HTML2PDF/html2fpdf.php');
    require("HTML/Table.php");
    $html_content=$tpl->fetch('printout_video.tpl');
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