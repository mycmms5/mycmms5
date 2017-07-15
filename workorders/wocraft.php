<?PHP
/**
* Plan generic resources 
*  
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage preparation
* @filesource
* @link http://localhost/_documentation/mycmms40_lib/
* CVS
* $Id: tab_wocraft.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wocraft.php,v $
* $Log: tab_wocraft.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

$OPNUM_ID=$_REQUEST['ID'];
class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT wocraft.ID,woop.OPNUM,woop.OPDESC,woop.OPSCHEDULE,wocraft.CRAFT,wocraft.TEAM,wocraft.ESTHRS FROM woop LEFT JOIN wocraft ON woop.WONUM=wocraft.WONUM AND woop.OPNUM=wocraft.OPNUM WHERE woop.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('operations',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->assign('crafts',$DB->query("SELECT CRAFT AS 'id',CRAFT AS 'text' FROM crafts",PDO::FETCH_NUM));
    $tpl->display_error($this->template);    
}
function process_form() {
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']!="0") {
                DBC::execute("UPDATE wocraft SET CRAFT=:craft,TEAM=:team,ESTHRS=:esthrs WHERE ID=:id",array("id"=>$_REQUEST['ID'],"craft"=>$_REQUEST['CRAFT'],"team"=>$_REQUEST['TEAM'],"esthrs"=>$_REQUEST['ESTHRS']));
            } else {
                $values=DBC::fetchcolumns("SELECT WONUM,OPNUM FROM wocraft WHERE ID={$_REQUEST['ID']}");
                DBC::execute("DELETE FROM wocraft WHERE ID=:id",array("id"=>$_REQUEST['ID']));
                $num=DBC::fetchcolumn("SELECT COUNT(*) FROM wocraft WHERE WONUM='{$values[0]}' AND OPNUM={$values[1]}",0);
                if ($num==0) {
                    DBC::execute("DELETE FROM woop WHERE WONUM=:wonum AND OPNUM=:op",array("wonum"=>$values[0],"op"=>$values[1]));
                }
            }
            if (strlen($_REQUEST['OPDESC'])>5 AND $_REQUEST['ESTHRS']!="0") {
                $values=DBC::fetchcolumns("SELECT WONUM,OPNUM FROM wocraft WHERE ID={$_REQUEST['ID']}");
                DBC::execute("UPDATE woop SET OPDESC=:opdesc,OPDURATION=:opduration WHERE WONUM=:wonum AND OPNUM=:op",array("opdesc"=>$_REQUEST['OPDESC'],"opduration"=>$_REQUEST['ESTHRS'],"wonum"=>$values[0],"op"=>$values[1]));
            }
            $values=DBC::fetchcolumns("SELECT WONUM,OPNUM FROM wocraft WHERE ID={$_REQUEST['ID']}");
            DBC::execute("UPDATE woop SET OPSCHEDULE=:opschedule WHERE WONUM=:wonum AND OPNUM=:op",array("opschedule"=>$_REQUEST['OPSCHEDULE'],"wonum"=>$values[0],"op"=>$values[1]));
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }      
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            if ($_REQUEST['ESTHRS']!="0") {
                DBC::execute("INSERT INTO wocraft (ID,WONUM,OPNUM,CRAFT,TEAM,ESTHRS) VALUES (NULL,:wonum,:opnum,:craft,:team,:esthrs)",array("wonum"=>$this->input1,"opnum"=>$_REQUEST['OPNUM'],"craft"=>$_REQUEST['CRAFT'],"team"=>$_REQUEST['TEAM'],"esthrs"=>$_REQUEST['ESTHRS']));
                $schedstartdate=DBC::fetchcolumn("SELECT SCHEDSTARTDATE FROM wo WHERE WONUM='{$this->input1}'",0);
                $woe_exists=intval(DBC::fetchcolumn("SELECT COUNT(*) FROM woe WHERE WONUM='{$this->input1}' AND EMPCODE='UNASSIGNED' AND WODATE='{$schedstartdate}'",0));
                if ($woe_exists == 0) {
                    DBC::execute("INSERT INTO woe (WONUM,EMPCODE,WODATE,ESTHRS) VALUES (:wonum,'UNASSIGNED',:wodate,:esthrs)",                      array("wonum"=>$this->input1,"wodate"=>$schedstartdate,"esthrs"=>$_REQUEST['ESTHRS']));
                } else {
                    DBC::execute("UPDATE woe SET ESTHRS=ESTHRS+:esthrs WHERE WONUM=:wonum AND EMPCODE='UNASSIGNED' AND WODATE=:wodate", array("wonum"=>$this->input1,"wodate"=>$schedstartdate,"esthrs"=>$_REQUEST['ESTHRS']));                      
                }
            }
            if (strlen($_REQUEST['OPDESC']) >= 3) {  
                DBC::execute("REPLACE woop SET WONUM=:wonum,OPNUM=:opnum,OPDESC=:opdesc,OPDURATION=:opduration,OPSCHEDULE=:opschedule",array("wonum"=>$this->input1,"opnum"=>$_REQUEST['OPNUM'],"opdesc"=>$_REQUEST['OPDESC'],"opduration"=>0,"opschedule"=>$_REQUEST['OPSCHEDULE']));
            } // By using REPLACE we can change texts in WOOP          
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
} // End of class

$inputPage=new thisPage();
$inputPage->flow();
?>