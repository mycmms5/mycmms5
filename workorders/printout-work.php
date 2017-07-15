<?PHP
/** 
* Printout Object
* 
* @author  Werner Huysmans 
* @access  public
* @package objects
* @subpackage printout
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_printoutPageSmarty.php");
require("setup.php");
$WONUM=$_REQUEST['id1'];
switch ($_REQUEST['tm']) {
    case "pdf":
        $PDF_output=true;
        break;
    case "nopdf":
        $PDF_output=false;
        break;
    default:    
        $PDF_output=false;
        break;      
}
$DB=DBC::get();
$EQNUM=DBC::fetchcolumn("SELECT EQNUM FROM wo WHERE WONUM=$WONUM",0);

$printout=new printoutPageSmarty();
$printout->main_data("SELECT wo.*,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM='$WONUM'");  
$printout->listdata1("SELECT dl.filename, filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='$EQNUM'");$printout->listdata2("SELECT e.EQNUM,e.DESCRIPTION FROM equip e WHERE EQROOT='$EQNUM'");
$printout->listdata2("SELECT EQNUM, DESCRIPTION FROM equip WHERE EQROOT='$EQNUM'");
#$printout->listdata3("SELECT WONUM,TASKDESC,PRIORITY FROM wo WHERE EQNUM='$EQNUM'");
#$printout->listdata4
$printout->serialData("SELECT data FROM wo_security WHERE WONUM=$WONUM");
$printout->pdf=$PDF_output;

if ($PDF_output) {
/**
* Using HTML2PDF4 library, which offers more control    
*/
    error_reporting(E_ERROR);
    $output=$printout->display(); 
    require("HTML2PDF4/html2pdf.class.php");
    $pdf=new HTML2PDF('P','A4','fr');
    $pdf->WriteHTML($output);
    $pdf->Output("printout_".$WONUM.".pdf");   
/**
* Using HTML2PDF library, older no longer developped

    require("HTML2PDF/html2fpdf.php");
    $pdf=new HTML2FPDF();
    $pdf->AddPage();
    $pdf->WriteHTML($output);
    $pdf->Output("../tmp/printout_".$WONUM.".pdf");
?>
<script type="text/javascript">
function reload() {    
    window.location="<?PHP echo "../tmp/printout_".$WONUM.".pdf"; ?>"; 
} 
setTimeout("reload();", 50);
</script>
<?php
**/
} else {
    $printout->display();
}
?>

