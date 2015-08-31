<?php
/** 
* Reception of goods/services of PO
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2009
* @access  public
* @package purchasing
* @subpackage standard
* @filesource
* @todo Use Smarty
* @todo Review the transactions and migrate to TXID
*/
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPage.php");

class poreceivePage extends inputPage {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
?>
    <input type="hidden" name="id1" value="<?PHP echo $data->PONUM ?>">
    <input type="hidden" name="id2" value="<?PHP echo $data->SEQNUM ?>">
    <input type="hidden" name="ITEMNUM" value="<?PHP echo $data->ITEMNUM ?>">
    <input type="hidden" name="VENDORID" value="<?PHP echo $data->VENDORID ?>">
<TABLE WIDTH="600">
<tr><td><?PHP echo _("DBFLD_VENDORID"); ?></td>
    <td><?PHP echo $data->VENDORID; ?></td></tr>
<tr><td><?PHP echo _("DBFLD_ITEMNUM"); ?></td>
    <td><?PHP echo $data->ITEMNUM; ?></td></tr>
<tr><td><?PHP echo _("DBFLD_DESCRIPTIONONPO"); ?></td>
    <td><?PHP echo $data->DESCRIPTIONONPO; ?></td></tr>
<tr><td><?PHP echo _("DBFLD_NOTES"); ?></td>
    <td><?PHP echo nl2br($data->NOTES); ?></td></tr>
<tr><td><?PHP echo _("DBFLD_QTYREQUESTED"); ?></td>
    <td><?PHP echo $data->QTYREQUESTED; ?></td><tr>
<tr><td><?PHP echo _("DBFLD_QTYRECEIVED"); ?></td>
    <td><?PHP echo $data->QTYRECEIVED; ?></td><tr>
<tr><td align="right"><?PHP echo "<B>"._("QTYRECEIVENOW"); ?></B></td>
    <td><?PHP echo create_text("QTYRECEIVEDNOW", 8, "0")."</B>"; ?></td></tr>    
<tr><td align="right"><?PHP echo "<B>"._("UNITCOST"); ?></td>
    <td><?PHP echo create_text("UNITCOST", 8, $data->UNITCOST)."</B>"; ?></td></tr>
<?PHP 
if ($data->ITEMNUM=='-') {  // No Warehouse
?>
<tr><td align="right"><?PHP echo "<B>"._("WONUM")."</B>"; ?></td><td><? echo "<B>"._("EQNUM")."</B>"; ?></td></tr>
<tr><td align="right"><?PHP echo create_text("WONUM",6,$data->WONUM); ?></td><td><?PHP echo create_text("EQNUM",40,$data->EQNUM); ?></td></tr>
<?PHP
} else {    
?>
<tr><td colspan=2><? echo _("Warehouse")." : "._("Location"); ?></td></tr>
<tr><td colspan=2 align="center"><? echo create_combo("SELECT CONCAT(WAREHOUSEID,':',LOCATION) AS id, CONCAT(WAREHOUSEID,':',LOCATION) as text FROM STOCK WHERE ITEMNUM=$data->ITEMNUM", 
                    "WHLOC",
                    "",
                    ""); ?></td>

<?PHP 
} 
?>
<tr><td colspan="2">
    <input type="submit" class="submit" value="<?PHP echo _("Save") ?>" name="form_save">
    <input type="submit" class="submit" value="<?PHP echo _("Close"); ?>" name="close"></td></tr>
</table>
<?php
} // New
public function process_form() {
    $DB=DBC::get();
    $WHLOC = split(":",$_REQUEST['WHLOC']);
    $bQTYRECEIVED=false;
    $bSERVICE=false;    
    $bSPARES=true;
    if ($_REQUEST['QTYRECEIVEDNOW']!=0) {
        $bQTYRECEIVED=TRUE;    // Goods were received
    } 
    if ($_REQUEST['ITEMNUM']=='-') {
        $bSERVICE=TRUE; $bSPARES=false;
    } 
    $reception_data = array(
    'Quantity'=>$bQTYRECEIVED,
    'Price'=>TRUE,
    'Service'=>$bSERVICE,
    'Spares'=>$bSPARES
    );

    # Now let's do some logic
    if ($bSERVICE AND $bQTYRECEIVED) {
        $TOTALCOST=$_REQUEST['QTYRECEIVEDNOW']*$_REQUEST['UNITCOST'];
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE purreq SET QTYRECEIVED=QTYRECEIVED+:qtyreceived,STATUS='I' WHERE PONUM=:ponum AND SEQNUM=:seqnum",array("qtyreceived"=>$_REQUEST["QTYRECEIVEDNOW"],"ponum"=>$_REQUEST['id1'],"seqnum"=>$_REQUEST['id2']));
            DBC::execute("INSERT INTO poreceiv (RECEIPTNUM,PONUM,SEQNUM,QTYRECEIVED,UNITCOST,DATERECEIVED,RECEIVETO,DESTID,ITEMNUM)  VALUES(NULL,:ponum,:seqnum,:qtyreceived,:unitcost,NOW(),'WorkOrder',:wonum,0)",array("qtyreceived"=>$_REQUEST["QTYRECEIVEDNOW"],"ponum"=>$_REQUEST['id1'],"seqnum"=>$_REQUEST['id2'],"unitcost"=>$_REQUEST['UNITCOST'],"wonum"=>$_REQUEST['WONUM']));
            DBC::execute("INSERT INTO wov (WONUM,PONUM,SEQNUM,QTYRECEIVED,VENDORID,UNITCOST,TOTALCOST,WODATE) VALUES (:wonum,:ponum,:seqnum,:qtyreceived,:vendorid,:unitcost,:totalcost,NOW())",array("qtyreceived"=>$_REQUEST["QTYRECEIVEDNOW"],"ponum"=>$_REQUEST['id1'],"seqnum"=>$_REQUEST['id2'],"vendorid"=>$_REQUEST['VENDORID'],"unitcost"=>$_REQUEST['UNITCOST'],"totalcost"=>$TOTALCOST,"wonum"=>$_REQUEST['WONUM']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
    }
    if ($bSPARES AND $bQTYRECEIVED) {
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE purreq SET QTYRECEIVED=QTYRECEIVED+:qtyreceived,STATUS='I' WHERE PONUM=:ponum AND SEQNUM=:seqnum",array("qtyreceived"=>$_REQUEST["QTYRECEIVEDNOW"],"ponum"=>$_REQUEST['id1'],"seqnum"=>$_REQUEST['id2']));
            DBC::execute("INSERT INTO poreceiv (RECEIPTNUM,PONUM,SEQNUM,QTYRECEIVED,UNITCOST,DATERECEIVED,RECEIVETO,DESTID,ITEMNUM)  VALUES(NULL,:ponum,:seqnum,:qtyreceived,:unitcost,NOW(),'WorkOrder',:wonum,0)",array("qtyreceived"=>$_REQUEST["QTYRECEIVEDNOW"],"ponum"=>$_REQUEST['id1'],"seqnum"=>$_REQUEST['id2'],"unitcost"=>$_REQUEST['UNITCOST'],"wonum"=>$_REQUEST['WONUM']));
            if (WAREHOUSE) {
                DBC::execute("UPDATE stock SET QTYONHAND=QTYONHAND+:qtyreceived WHERE ITEMNUM=:itemnum AND WAREHOUSEID='DEFAULT'",array("qtyreceived"=>$_REQUEST['QTYRECEIVEDNOW'],"itemnum"=>$_REQUEST['ITEMNUM']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
    }
} // New
} // End class

$inputPage=new poreceivePage();
$inputPage->pageTitle=_("Reception");
$inputPage->stylesheet=CSS_INPUT;
$inputPage->formName="treeform";
$inputPage->calendar=true;
$inputPage->input1=$_SESSION["Ident_1"];
$inputPage->input2=$_SESSION["Ident_2"];
$inputPage->data_sql="SELECT REQUISITIONNUM,p.PONUM,SEQNUM,ITEMNUM,QTYREQUESTED,UNITCOST,QTYRECEIVED,DESCRIPTIONONPO,NOTES,p.WONUM, EQNUM,VENDORID FROM purreq p LEFT JOIN wo ON p.WONUM=wo.WONUM LEFT JOIN poheader ph ON p.PONUM=ph.PONUM WHERE p.PONUM={$inputPage->input1} AND SEQNUM={$inputPage->input2}";
$inputPage->flow();
?>
