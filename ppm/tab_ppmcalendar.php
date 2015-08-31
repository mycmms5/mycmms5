<?PHP
/**
* Add/Change PPM calendar dates
*  
* @author  Werner Huysmans 
* @access  public
* @package ppm
* @subpackage calendar
* @filesource
* @todo Use Smarty Template
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

$OPNUM_ID=$_REQUEST['ID'];
if ($_SESSION['Ident_1']=="new") {
    require("tab_task-unsaved.php");
    exit();
}

class ppmcalendarPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT * FROM ppmcalendar WHERE TASKNUM='{$this->input1}' AND EQNUM='{$this->input2}' ORDER BY PLANDATE ASC LIMIT 0,100";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('tasks',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tab_ppmcalendar.tpl');    
} // End page_content
function process_form() {   // Only Updating...
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE ppmcalendar SET PLANDATE=:plandate WHERE ID=:id AND WONUM IS NULL",array("plandate"=>$_REQUEST['PLANDATE'],"id"=>$_REQUEST['ID']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }    
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            DBC::execute("INSERT INTO ppmcalendar (ID,TASKNUM,EQNUM,PLANDATE) VALUES (NULL,:tasknum,:eqnum,:plandate)",array("tasknum"=>$this->input1,"eqnum"=>$this->input2,"plandate"=>$_REQUEST['PLANDATE']));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }
        break;
    default:
        break;                           
    }
} // End process_form
} // End class

$inputPage=new ppmcalendarPage();
$inputPage->version=$version; 
$inputPage->pageTitle="";
$inputPage->contentTitle="";
$inputPage->input1=$_SESSION['Ident_1'];
$inputPage->input2=$_SESSION['Ident_2'];
$inputPage->flow();

/**
<table class='list'>
<tr><th class="th"><?PHP echo _("DBFLD_PLANDATE"); ?></th>
    <th class="th"><?PHP echo _("DBFLD_WONUM"); ?></th>
    <th class="th"><?php echo _("ACTION"); ?></th></tr>
<?PHP
    foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
        $this->data_sql="SELECT ID,PLANDATE,WONUM FROM ppmcalendar pc WHERE pc.ID='{$row->ID}'";
        $data=$this->get_data($this->input1,$row->ID);    
        if ($_REQUEST['ID']!=$data->ID) {
?>
<!-- Activate Edit screen -->
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="<?PHP echo $data->ID; ?>">
        <?PHP echo $data->PLANDATE; ?></td>
    <td><?PHP echo $data->WONUM; ?></td>
    <td><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</tr></form>
<?PHP            
        } else {
?>
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="<?PHP echo $data->ID; ?>">
        <?PHP echo create_date_box("PLANDATE","PLANDATE",12,$data->PLANDATE); ?></td>
    <td><?PHP echo create_text("WONUM",8,$data->WONUM); ?></td>
    <td><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</tr></form>
<?PHP
        }
} 
?>
<tr><td>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
        <?PHP echo create_date_box("PLANDATE","PLANDATE",12,$data->PLANDATE); ?></td>
    <td><?PHP echo create_text("WONUM",8,$data->WONUM); ?></td>
    <td><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td>
</tr></form>
</table>
<form>
<!-- Avoiding problems with standard form -->
<?PHP               
}
**/
?>
