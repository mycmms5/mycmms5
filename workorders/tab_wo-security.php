<?PHP
/** 
* Security evaluation form
* 
* @author  Werner Huysmans 
* @access  public
* @package BETA
* @subpackage security_form
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPage.php");

class wosecurityPage extends inputPage {
    public $input3;
    
public function page_content() {
    if (empty($_SESSION['PONUM'])) {
?>    
<input type="hidden" name="PRESELECT" value="on"/>
<input type="hidden" name="PONUM_OLD" value=<?PHP echo $_SESSION['PONUM']; ?>>
<table>
<tr><td><?PHP echo _("Select PO"); ?></td>
    <td><?PHP echo create_combo("SELECT CONCAT(PONUM,'_',VENDORID) AS 'id',CONCAT(PONUM,'_',VENDORID) AS 'text' FROM wov WHERE WONUM={$this->input1}","PONUM","",""); ?></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="<? echo _("Save"); ?>"   name="form_save">
    <input type="submit" class="submit" value="<? echo _("Close"); ?>"  name="close"></td></tr>    
</table>
<?PHP
    } else {
    $this->input3=$_SESSION['PONUM'];
    $this->data_sql="SELECT ws.*,wo.TASKDESC,wo.ORIGINATOR FROM wo_security ws LEFT JOIN wo ON ws.WONUM=wo.WONUM WHERE ws.WONUM={$this->input1} AND ws.PONUM_SUPPLIER='{$this->input3}'";
    $data=$this->get_data($this->input1,$this->input3);
    $a_data=unserialize($data->DATA);
?>
<script type="text/javascript">
top.resizeTo(1000,700);
</script>
<input type="hidden" name="id1" value="<?PHP echo $this->input1; ?>">
<table width="800">
<tr><th colspan="2"><?PHP echo _("Security Information")." ".$_SESSION['PONUM']; ?></td></tr>
<tr><td align="center"><?PHP echo _("Work Requestor"); ?></td><td class="important" align="center"><B><?PHP echo $data->ORIGINATOR; ?></B></td></tr>
<tr><td align="center"><?PHP echo _("Purchase Order"); ?></td>
    <td><?PHP echo create_combo("SELECT PONUM AS 'id',CONCAT(PONUM,'_',VENDORID) AS 'text' FROM wov WHERE WONUM={$this->input1}","PONUM_SUPPLIER",$data->PONUM_SUPPLIER,$data->PONUM_SUPPLIER); ?></td></tr>
<tr><td class="important" colspan="2"><?PHP echo $data->TASKDESC; ?></td></tr>

<tr><th colspan="2"><?PHP echo _("Supplier qualification"); ?></th></tr>
<tr><td><?PHP echo _("Is the supplier qualified to execute the requested job"); ?></td>
    <td><?PHP echo create_checkbox("CHK_QUALIFICATION",$a_data['CHK_QUALIFICATION'])._("YES")." ".create_area("SEC_QUALIFICATION",50,3,$a_data['SEC_QUALIFICATION']); ?></td></tr>
<tr><td><?PHP echo _("Has a Risk Analysis been done together with the supplier (the document may be scanned of stored on paper)"); ?></td>
    <td><?PHP echo create_checkbox("CHK_RA",$a_data['CHK_RA'])._("YES")." ".create_area("SEC_RISKANALYSIS",50,3,$a_data['SEC_RISKANALYSIS']); ?></td></tr>    
<tr><td><?PHP echo _("Communication possible between supplier / responsible (Indicate Mobile nr)"); ?></td>
    <td><?PHP echo create_checkbox("CHK_MOBILE",$a_data['CHK_MOBILE'])._("YES")." ",create_text("SEC_MOBILE",25,$a_data['SEC_MOBILE']); ?></td></tr>
<tr><td><?PHP echo _("Is a Control Check planned after the end of the work (Indicate name)"); ?></td>
    <td><?PHP echo create_checkbox("CHK_AFTERCHECK",$a_data['CHK_AFTERCHECK'])._("YES")." ".create_text("SEC_AFTERCHECK",25,$a_data['SEC_AFTERCHECK']); ?></td></tr>

<tr><th colspan="2"><?PHP echo _("Fire risk assesment"); ?></th></tr>
<tr><td><?PHP echo _("Are works carried out with open flame?"); ?></td>
    <td><?PHP echo create_checkbox("CHK_FIRERISK",$a_data['CHK_FIRERISK'])._("YES")." ".create_area("SEC_FIRERISK",50,3,$a_data['SEC_FIRERISK']); ?></td></tr>
<tr><td><?PHP echo _("Are inflammable products in the working range"); ?></td>
    <td><?PHP echo create_checkbox("CHK_AREA",$a_data['CHK_AREA'])._("YES")." ".create_area("SEC_AREA",50,3,$a_data['SEC_AREA']); ?></td></tr>
<tr><td><?PHP echo _("Is a fire extinguisher at reach for the supplier (correct type/controlled)"); ?></td>
    <td><?PHP echo create_checkbox("CHK_FIREEXT",$a_data['CHK_FIREEXT'])._("YES")." ".create_text("SEC_FIRE_EXTINGUISHER",25,$a_data['SEC_FIRE_EXTINGUISHER']); ?></td></tr>

<tr><th colspan="2"><?PHP echo _("Working at heights"); ?></th></tr>
<tr><td><?PHP echo _("Working at heights with scaffolding"); ?></td>
    <td><?PHP echo create_checkbox("CHK_SCAFFOLDING",$a_data['CHK_SCAFFOLDING'])._("YES")." ".create_area("SEC_SCAFFOLDING",50,3,$a_data['SEC_SCAFFOLDING']); ?></td></tr>

<tr><th colspan="2"><?PHP echo _("Working in confined spaces"); ?></th></tr>    
<tr><td><?PHP echo _("Working in confined spaces (Equipment check, evacuation procedure, toxic products)"); ?></td>
    <td><?PHP echo create_checkbox("CHK_CONFINEDSPACE",$a_data['CHK_CONFINEDSPACE'])._("YES")." ".create_area("SEC_CONFINEDSPACE",50,3,$a_data['SEC_CONFINEDSPACE']); ?></td></tr>

<tr><td colspan="2">
    <input type="submit" class="submit" value="<? echo _("Save"); ?>"   name="form_save">
    <input type="submit" class="submit" value="<? echo _("Close"); ?>"  name="close"></td></tr>    
</table>
<?php
    } // EO else
} // End page_content
public function process_form() {
    if ($_REQUEST['PRESELECT']=="on") {
        $_SESSION['PONUM']=$_REQUEST['PONUM'];
        header("location {$_SERVER['PHP_SELF']}");
    } else {
        $DB=DBC::get();
        $a_data=serialize($_REQUEST);
        try {
            $DB->beginTransaction();
            DBC::execute("REPLACE INTO wo_security SET WONUM=:wonum,PONUM_SUPPLIER=:po_supplier,DATA=:a_data",array("wonum"=>$_REQUEST['id1'],"po_supplier"=>$_REQUEST['PONUM_SUPPLIER'],"a_data"=>$a_data)); 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        unset($_SESSION['PONUM']);
?>
<script type="text/javascript">
    top.resizeTo(800,700);
</script>        
<?PHP    
    }     
}
} // End class

$inputPage=new wosecurityPage();
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->stylesheet=CSS_SMARTY;
$inputPage->formName="treeform";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>

