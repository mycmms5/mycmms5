<?PHP
/** 
* Generate a Purchase Request and link to WO
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package work
* @subpackage purchasing
* @link http://localhost/_documentation/mycmms40_lib/
* @todo Use Smarty Template
*/
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPage.php");
require(CMMS_LIB."/class_PDO_WebCal.php");

class purreqPage extends inputPage {
public function page_content() {
    $DB=DBC::get();
    $result=$DB->query("SELECT SEQNUM AS 'ID' FROM purreq WHERE WONUM={$this->input1}");
    if ($result) { // Header  
?>    
</form>
<!-- Ending the standard form -->
<table class='list'>
<tr><th class="th"><?PHP echo _("DBFLD_ITEMNUM"); ?></th> 
    <th class="th"><?PHP echo _("DBFLD_DESCRIPTIONONPO"); ?></th>   
    <th class="th"><?PHP echo _("DBFLD_QTYREQUESTED"); ?></th></tr>
<?PHP
    foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
        $this->data_sql="SELECT SEQNUM AS 'ID',ITEMNUM,DESCRIPTIONONPO,NOTES,QTYREQUESTED FROM purreq WHERE WONUM={$this->input1} AND SEQNUM={$row->ID}";
        $data=$this->get_data($this->input1,$row->ID);    
        if ($_REQUEST['ID']!=$data->ID) {
?>
<!-- Activate Edit screen -->
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="<?PHP echo $data->ID; ?>">
        <?PHP echo $data->ITEMNUM; ?></td>
    <td><?PHP echo $data->DESCRIPTIONONPO; ?></td> 
    <td><?PHP echo $data->QTYREQUESTED; ?></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td></tr>
</form>
<?PHP            
        } else {
?>
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ITEMNUM" value="<?PHP echo $data->ITEMNUM; ?>">
<input type="hidden" name="ID" value="<?PHP echo $data->ID; ?>">
        <?PHP echo $data->ITEMNUM; ?></td>
    <td><?PHP echo create_area("DESCRIPTIONONPO",40,3,$data->DESCRIPTIONONPO)."<BR>".
                create_area("NOTES",40,5,$data->NOTES); ?></td>
    <td><?PHP echo create_text("QTYREQUESTED",3,$data->QTYREQUESTED); ?></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</tr></form>
<?PHP
        } //EO Update
} 
?>
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="WONUM" value="<?PHP echo $this->input1; ?>">
<input type="hidden" name="form_save" value="SET">
        <?PHP echo create_text("ITEMNUM",6,""); ?></td>
    <td><?PHP echo create_area("DESCRIPTIONONPO",40,5,""); ?></td>
    <td><?PHP echo create_text("QTYREQUESTED",3,"0"); ?></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
<!-- Avoiding problems with standard form -->
<form>
<form>
<?PHP               
}
?>
<?PHP
} // EO content_page
public function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ITEMNUM']=="-") {    // Service or non-stock part
                DBC::execute("UPDATE purreq SET DESCRIPTIONONPO=:descriptiononpo,NOTES=:notes,QTYREQUESTED=:qtyrequested WHERE SEQNUM=:seqnum",array("descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"notes"=>$_REQUEST['NOTES'],"qtyrequested"=>$_REQUEST['QTYREQUESTED'],"seqnum"=>$_REQUEST['ID']));
            } else {
                $item_description=DBC::fetchcolumn("SELECT DESCRIPTION FROM invy WHERE ITEMNUM={$_REQUEST['ITEMNUM']}",0);
                DBC::execute("UPDATE purreq SET QTYREQUESTED=:qtyrequested WHERE SEQNUM=:seqnum",array("qtyrequested"=>$_REQUEST['QTYREQUESTED'],"seqnum"=>$_REQUEST['ID']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ITEMNUM']=="-") {    // Service or non-stock part
                DBC::execute("INSERT INTO purreq (SEQNUM,STATUS,ITEMNUM,DESCRIPTIONONPO,NOTES,QTYREQUESTED,UOP,QTYRECEIVED,DATEGENERATED,PONUM,WONUM,DESTID) VALUES (NULL,'R',:itemnum,:descriptiononpo,:notes,:qtyrequested,'ST',0,NOW(),0,:wonum,'WO')",array("descriptiononpo"=>$_REQUEST['DESCRIPTIONONPO'],"notes"=>$_REQUEST['NOTES'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyrequested"=>$_REQUEST['QTYREQUESTED'],"wonum"=>$_REQUEST['WONUM']));
            } else {
                $item_description=DBC::fetchcolumn("SELECT DESCRIPTION FROM invy WHERE ITEMNUM={$_REQUEST['ITEMNUM']}",0);
                DBC::execute("INSERT INTO purreq (SEQNUM,STATUS,ITEMNUM,DESCRIPTIONONPO,NOTES,QTYREQUESTED,UOP,DATEGENERATED,PONUM,WONUM,DESTID) VALUES (NULL,'R',:itemnum,:descriptiononpo,:notes,:qtyrequested,'ST',NOW(),0,:wonum,'WH')",array("descriptiononpo"=>$item_description,"notes"=>'-',"itemnum"=>$_REQUEST['ITEMNUM'],"qtyrequested"=>$_REQUEST['QTYREQUESTED'],"wonum"=>$_REQUEST['WONUM']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    default:
        break;                           
    }
} // End process_form} // EO process_form
} // EOF Class

$inputPage=new purreqPage();
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->stylesheet=CSS_INPUT;
$inputPage->calendar=true;
$inputPage->formName="treeform";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();
?>