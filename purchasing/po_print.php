<?
/** 
* Purchase Order Print Out 
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package purchasing
* @subpackage printout
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("HTML/Table.php");
require(CMMS_LIB."/class_printPage.php");
$PONUM=$_REQUEST['id1'];

class printPage_PO extends printPage {
    var $data;
    
public function PrintMainData() {
?>
<table>
<tr><td colspan="3"><?PHP echo "<B>"._("Purchase Order ")."</B> ".$this->data['PONUM']; ?></td></tr>
<tr><td colspan="3"><?PHP echo "<I>"._("Reason for purchase")." : ".$this->data['NOTES']."</I>"; ?></td></tr>
<tr><th><?PHP echo _("Approval"); ?></th><th></th><th></th></tr>
<tr><td><?PHP echo $this->data["STATUS"]; ?></td><td><?PHP echo $this->data["SINGLESOURCE"]; ?></td><td><?PHP echo $this->data["REQUISITIONNUM"]; ?></td></tr>
</table>
<?PHP    
}    
}

$printout=new printPage_PO();
$printout->PrintoutTitle="Printout Purchase ORDER ".$PONUM;
$printout->stylesheet=CSS_PRINTOUT;
$printout->HeaderPage();

$printout->TableTitle=_("Request Data");
$printout->sql="SELECT r.REQUISITIONNUM,APPROVALSTATUS,r.SINGLESOURCE,r.NOTES,PONUM FROM reqstion r LEFT JOIN purreq p ON r.REQUISITIONNUM=p.REQUISITIONNUM WHERE p.PONUM=".$PONUM;
$printout->data=$printout->getData();
$printout->PrintMainData();

$printout->TableTitle=_("Vendor data");
$printout->sql="SELECT p.VENDORID,v.NAME,ADDR1,ZIP,CITY FROM POHEADER p LEFT JOIN vendors v ON p.VENDORID=v.id WHERE p.PONUM=".$PONUM;
$printout->header=array("SAP","Vendor","Address","ZIP","CITY");
$printout->PrintTable();

$printout->TableTitle=_("Ordered Line items");
$printout->sql="SELECT SEQNUM,ITEMNUM,DESCRIPTIONONPO,QTYREQUESTED,QTYRECEIVED,UNITCOST,WONUM,UNITCOST*QTYREQUESTED AS LINECOST FROM purreq p WHERE p.PONUM=".$PONUM;
$printout->header=array(_("Seqnum"),_("ITEMNUM"),_("Description"),_("Quantity"),_("Qty Recvd"),_("UnitCost"),_("WO"),_("Total"));
$printout->PrintTable();

$printout->FooterPage();
?>
