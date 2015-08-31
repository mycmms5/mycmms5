<?PHP
/** 
* PrintOut Quick PO
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package purchasing
* @subpackage printout
* @filesource
* @todo Smarty
*/
require("../includes/config_mycmms.inc.php");
require('HTML/Table.php');
require(CMMS_LIB."/class_printPage.php");
$SEQNUM=$_REQUEST['id1'];

class printPage_PQ extends printPage {
    var $data;
    
public function PrintMainData() {
?>
<table>
<tr><td colspan="3"><?PHP echo "<B>"._("Requisition nr")."</B> ".$this->data['USER3']." / SAP : ".$this->data['PONUM']; ?></td></tr>
</table>
<?PHP    
}    
}

$printout=new printPage_PQ();
$printout->PrintoutTitle="Printout Purchase Request ".$SEQNUM;
$printout->stylesheet=CSS_PRINTOUT;  
$printout->HeaderPage();

$printout->TableTitle=_("Request Data");
$printout->sql="SELECT USER3,PONUM,USER2 FROM purreq WHERE SEQNUM=".$SEQNUM;
$printout->data=$printout->getData();
$printout->PrintMainData();
$po=$printout->data['USER3'];
$vendor=$printout->data['USER2'];

$printout->TableTitle=_("Vendor Data");
$printout->sql="SELECT id,NAME,PHONE FROM vendors WHERE id='".$vendor."'";
$printout->header=array(_("DBFLD_id"),_("DBFLD_NAME"),_("DBFLD_PHONE"));
$printout->PrintTable();

$printout->TableTitle=_("Line items");
$printout->sql="SELECT SEQNUM,DESCRIPTIONONPO,NOTES,QTYREQUESTED,DUEDATE,DUEDATE_SAP FROM PURREQ WHERE PURREQ.USER3='".$po."'";
$printout->header=array(_("DBFLD_SEQNUM"),_("DBFLD_DESCRIPTIONONPO"),_("DBFLD_NOTES"),_("DBFLD_QTYREQUESTED"),_("DBFLD_DUEDATE"),_("DBFLD_DUEDATE_SAP"));
$printout->PrintTable();


$printout->FooterPage();
?>

