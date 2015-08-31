<?PHP
/** 
* Manual OEE registration, it also contains a link to 8D - which is still BETA
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage oee
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
define("WITH_8D",false);

class OEEPage extends inputPageSmarty {
public function page_content() {
    $data=(array)$this->get_data($this->input1,$this->input2);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('stylesheet_calendar',STYLE_PATH."/".CSS_CALENDAR);
    $tpl->assign('data',$data);
    $tpl->display_error("tab_wo-oee.tpl");
} // EO content_page
public function process_form() {
    $DB=DBC::get();
    try {
        $DB->beginTransaction();
        $downtime=(strtotime($_REQUEST['DT_END'])-strtotime($_REQUEST['DT_START']))/60;
        DBC::execute("UPDATE wo SET RFOCODE=:rfocode,RFFCODE=:rffcode,DT_START=:start,DT_END=:end,DT_DURATION=:downtime,COMPLETIONDATE=:completiondate,WOSTATUS='F' WHERE WONUM=:wonum",array("rfocode"=>$_REQUEST['OEE'],"rffcode"=>$_REQUEST['RFF'],"start"=>$_REQUEST['DT_START'],"end"=>$_REQUEST['DT_END'],"completiondate"=>$_REQUEST['DT_END'],"downtime"=>$downtime,"wonum"=>$_REQUEST['id1']));
        // 8D
        if (WITH_8D) {
            if ($_REQUEST['REF8D']!="0" AND $_REQUEST['REF8D']!="NEW") {
                DBC::execute("UPDATE wo SET REF8D=:ref8D WHERE WONUM=:wonum",array("wonum"=>$this->input1,"ref8D"=>$_REQUEST['REF8D']));
            }  
            if ($_REQUEST['REF8D']=="NEW") {
                DBC::execute("INSERT INTO 8D (ID,STARTDATE,TITLE,EQNUM,DATA) VALUES (NULL,NOW(),'New 8D',:eqnum,'New 8D')",array("eqnum"=>$_REQUEST['id2']));
                $new8D=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                DBC::execute("UPDATE wo SET REF8D=:new8D WHERE WONUM=:wonum",array("wonum"=>$this->input1,"new8D"=>$new8D));
                $EQNUM=DBC::fetchcolumn("SELECT EQNUM FROM wo WHERE WONUM={$_REQUEST['id1']}",0);
                DBC::execute("INSERT INTO wo_8D_eqnum (WONUM,REF8D,EQNUM) VALUES (:wonum,:ref8d,:eqnum)",array("wonum"=>$_REQUEST['id1'],"ref8d"=>$new8D,"eqnum"=>$EQNUM));
            }
        } // EO WITH_8D
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
        PDO_log($e);
    }   
} // EO process_form
} // EOF Class

$inputPage=new OEEPage();
$inputPage->data_sql="SELECT wo.WONUM,wo.EQNUM,wo.RFOCODE,wo.RFFCODE,wo.TASKDESC,wo.TEXTS_B,wo.DT_START,wo.DT_END,wo.DT_DURATION,wo.REF8D,equip.DESCRIPTION,oee_tree.DESCRIPTION AS OEE_DESCRIPTION,rff_tree.DESCRIPTION AS RFFCODEDESC FROM wo LEFT JOIN equip ON wo.EQNUM=equip.EQNUM LEFT JOIN oee_tree ON wo.RFOCODE=oee_tree.EQNUM LEFT JOIN rff_tree ON wo.RFFCODE=rff_tree.EQNUM WHERE WONUM='{$inputPage->input1}'";
$inputPage->flow();
?>