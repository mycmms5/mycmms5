<?php
/** Billing of PO
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20081201
* @access  public
* @package purchasing
* @subpackage standard
* @filesource
* @todo Results of purchase should go into wov
* @todo Smarty
*/
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPage.php");

class pobillingPage extends inputPage {
private function poreceived() {    
    echo $this->make_table("","SELECT R.SEQNUM,R.ITEMNUM,P.DESCRIPTIONONPO,R.QTYRECEIVED,R.UNITCOST,(R.QTYRECEIVED*R.UNITCOST) AS LINECOST,R.RECEIPTNUM FROM poreceiv R LEFT JOIN purreq P ON R.PONUM=P.PONUM AND R.SEQNUM=P.SEQNUM WHERE R.PONUM={$this->input1}",array(_("Sequence nr"),_("Item nr"),_("Description on PO"),_("Quantity"),_("UnitCost"),_("LC"),_("Receipt nr")));
    echo "<h2>"._("Total value received: ").DBC::fetchcolumn("SELECT SUM(QTYRECEIVED*UNITCOST) AS TOTAL FROM poreceiv WHERE PONUM={$this->input1}",0)."</h2>";
} // End poreceived    
private function pobilled() {
    echo $this->make_table("","SELECT R.SEQNUM,R.INVOICEDATE,INVOICENUM,INVOICEAMOUNT FROM poreceiv R WHERE R.PONUM={$this->input1}",array(_("Sequence nr"),_("Invoice Date"),_("Invoice Reference"),_("Amount")));
    echo "<h2>"._("Total billed: ").DBC::fetchcolumn("SELECT SUM(INVOICEAMOUNT) FROM poreceiv WHERE PONUM={$this->input1}",0)."</h2>";
}
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
?>
<input type="hidden" name="id1" value="<?PHP echo $data->PONUM ?>">
<input type="hidden" name="id2" value="<?PHP echo $data->SEQNUM ?>">
<?PHP $this->poreceived(); ?>    
<?PHP $this->pobilled(); ?></h2>
<TABLE WIDTH="600">
<tr><td><? echo _("VENDOR"); ?></td>
    <td><? echo create_text("VENDORID", 20, $data->VENDORID); ?></td></tr>
<tr><td><? echo _("Bill"); ?></td>
    <td><? echo create_text("INVOICENUM", 15, $data->INVOICENUM); ?></td></tr>
<tr><td><? echo _("Bill Date"); ?></td>
    <td><?     if (empty($po->INVOICEDATE)) {
                   $bill_date = date("Y-m-d H:i:s", strtotime("now")); 
            } else {
                $bill_date = $data->INVOICEDATE; }
            echo create_date_box("INVOICEDATE","invoicedate", 15, $bill_date);
         ?></td></tr>
<tr><td><? echo _("Bill Amount"); ?></td>
    <td><? echo create_text("INVOICEAMOUNT", 8, $data->INVOICEAMOUNT); ?></td></tr>    
<tr><td colspan="2"><?PHP echo _("Close this Purchase Order? ").create_checkbox("CLOSE",false); ?></td></tr>        
<tr><td colspan="2">
    <input type="submit" class="submit" value="<? echo _("Save"); ?>" name="form_save">
    <input type="submit" class="submit" value="<? echo _("Close"); ?>" name="close"></td></tr>
</table>
<?php
} // New
public function process_form() {
    $NOW = date("Y-m-d H:i:s", strtotime("now"));
    DBC::execute("UPDATE PORECEIV SET INVOICENUM=:bill,INVOICEDATE=:billdate,INVOICEAMOUNT=:billamount WHERE PONUM=:ponum AND SEQNUM=:seqnum",array("bill"=>$_REQUEST["INVOICENUM"],"billdate"=>$_REQUEST['INVOICEDATE'],"billamount"=>$_REQUEST['INVOICEAMOUNT'],"ponum"=>$this->input1,"seqnum"=>$this->input2));
    DBC::execute("UPDATE PURREQ SET STATUS='B' WHERE PONUM=:ponum AND SEQNUM=:seqnum",array("ponum"=>$this->input1,"seqnum"=>$this->input2));

    if (isset($_REQUEST['CLOSE'])) {
        DBC::execute("UPDATE PURREQ SET CLOSEDATE=:now,STATUS='C' WHERE PONUM=:ponum",array("ponum"=>$_REQUEST['id1'],"now"=>$NOW));
        DBC::execute("UPDATE PORECEIV SET CLOSEDATE=:now WHERE PONUM=:ponum",array("ponum"=>$_REQUEST['id1'],"now"=>$NOW));
        DBC::execute("UPDATE POHEADER SET CLOSEDATE=:now WHERE PONUM=:ponum",array("ponum"=>$_REQUEST['id1'],"now"=>$NOW));
    } else {
        echo "<h2>This PO remains open !</h2>"; 
    }
} // New
} // End class 

$inputPage=new pobillingPage();
$inputPage->pageTitle=_("Edit Purchase Line");
$inputPage->stylesheet=CSS_INPUT;
$inputPage->formName="treeform";
$inputPage->calendar=true;
$inputPage->input1=$_SESSION["Ident_1"];
$inputPage->input2=$_SESSION["Ident_2"];
$inputPage->data_sql="SELECT P.PONUM,P.SEQNUM,P.ITEMNUM,P.QTYRECEIVED,R.UNITCOST,R.QTYRECEIVED,DESCRIPTIONONPO,H.VENDORID,R.INVOICENUM,R.INVOICEDATE,R.INVOICEAMOUNT FROM purreq P LEFT JOIN poheader H ON P.PONUM=H.PONUM LEFT JOIN poreceiv R ON P.PONUM=R.PONUM AND P.SEQNUM=R.SEQNUM WHERE P.PONUM={$inputPage->input1}";
$inputPage->flow();
?>
