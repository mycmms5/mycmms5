<?PHP 
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_inputPage.php");

class newPage extends inputPage {
public function page_content() {
    $data=$this->get_data($this->input1,$this->input2);
?>
<input type="hidden" name="id1" value="<?PHP echo $this->input1; ?>">
<table width="600">
<tr><td valign ="top" class="LABEL"><?PHP echo _("Task Description"); ?></td>
    <td><?PHP echo create_text("TASKDESC",60,$data->TASKDESC) ?></td></tr>
<tr><td colspan="2"><?PHP echo create_area("TEXTS",80,10,$data->TEXTS) ?></td></tr>
<tr><td class="LABEL"><?PHP echo _("Requestor"); ?></td>
    <td><?PHP echo create_text("ORIGINATOR",20,"HUYSMANS_WERNER"); ?></td></tr>
<tr><td class="LABEL"><?PHP echo _("Request Date"); ?></td>
    <td><?PHP echo create_date_box("REQUESTDATE","REQUESTDATE",10,$data->REQUESTDATE); ?></td></tr>
<tr><td class="LABEL"><?PHP echo _("WO type") ?></td>
    <td><?PHP   $options = array("REPAIR","PROJECT","MAINTENANCE");
                echo create_combofix("WOTYPE",$options,"PROJECT",""); ?></td></tr>
<tr><td class="LABEL"><?PHP echo _("Techn.Object") ?>:</td>
    <td><?PHP   $Preselect_EQNUM = $data->EQNUM;
                if (empty($data->EQNUM)) {
                    $Preselect_EQNUM="HOME";
                }
                echo create_text("EQNUM",25,$Preselect_EQNUM);
                echo create_text("DESCRIPTION",35,$data->DESCRIPTION); ?>
                <a href="javascript://" onClick="treewindow('../actions/tree/index.php?tree=EQUIP','EQNUM')"><?PHP echo _("Select"); ?></a></td></tr>
<tr><td>
<table>
<tr><td><?PHP echo create_radio("action","new",false)." "._("New Work"); ?></td></tr>
<tr><td><?PHP echo create_radio("action","edit","checked")." "._("Edit Work"); ?></td></tr>
<tr><td><?PHP echo create_radio("action","delete",false)." "._("Delete Work"); ?></td></tr>
</table></td>    
    <td align="center"><input type="submit" class="submit" value="<?PHP echo _("Make a choice"); ?>" name="close"></td></tr>    
</table>
<?php
} // End page_content
private function process_form_edit($data) {  
    $DB=DBC::get();
    $st=$DB->prepare("UPDATE wo SET TASKDESC=:taskdesc,TEXTS=:texts,REQUESTDATE=:requestdate,EQNUM=:eqnum WHERE WONUM=:id1");
    $st->execute(array("taskdesc"=>$_REQUEST['TASKDESC'],"texts"=>$_REQUEST['TEXTS'],"requestdate"=>$_REQUEST['REQUESTDATE'],"eqnum"=>$_REQUEST["EQNUM"],"id1"=>$_REQUEST['id1']));
    return ("Changed transaction ".$_REQUEST['id1']);
} // process_form_edit
private function process_form_new() {  
    $DB=DBC::get();
    $st=$DB->prepare("INSERT INTO wo (WONUM,EQNUM,REQUESTDATE,TASKDESC,TEXTS,ORIGINATOR,WOTYPE,CLOSEDATE,COMPLETIONDATE,APPROVEDBY,WOSTATUS) VALUES (NULL,:eqnum,:requestdate,:taskdesc,:texts,'HUYSMANS',:wotype,'1900-01-01','1900-01-01','CMMS_HOME','PR')");
    $st->execute(array("eqnum"=>$_REQUEST['EQNUM'],"requestdate"=>$_REQUEST['REQUESTDATE'],"taskdesc"=>$_REQUEST['TASKDESC'],"texts"=>$_REQUEST['TEXTS'],"wotype"=>$_REQUEST['WOTYPE']));
    $result=$DB->query("SELECT LAST_INSERT_ID()");
    $_SESSION['Ident_1']=$result->fetchColumn(0);
    return _("OK")." : ".$_SESSION['Ident_1'];
} // process_form_new
private function process_form_delete() {
    $DB=DBC::get();
    return _("OK");
}
public function process_form() {
    $DB=DBC::get();
    switch($_REQUEST['action']) {
    case 'edit':
        $this->process_form_edit($_REQUEST);        
        break;
    case 'new':
        $this->process_form_new($_REQUEST);
        break;
    case 'delete':
        $this->process_form_delete($_REQUEST);
        break;
    }
}
} // End class

$inputPage=new newPage();
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->stylesheet=CSS_INPUT;
$inputPage->formName="treeform";
$inputPage->calendar=true;
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->data_sql="SELECT wo.*,equip.DESCRIPTION FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>