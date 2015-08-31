<?php
/** 
* Generate_levels
* In order to represent the table easily in EXCEL, we'll iterate through the database 
* and seek the parent until we hit ROOT; The count of seek operations represents the level.
*
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package framework
* @subpackage tree
* @filesource
* @done 20150625 code cleanup and revision of procedure (the existing one is long)
* @todo 20150812 try to use the code for the iteration as used in export_tree2excel.php, adapting the FindParent function?
* @todo 20150812 Use also the same representation?
**/
set_time_limit(0);
require("../includes/config_mycmms.inc.php");  
require("setup.php");
$version=__FILE__." :V5.0 Build 20150808";

function FindParent($parent) {
    $DB=DBC::get();
    $g_parent=DBC::fetchcolumn("SELECT DISTINCT parent FROM equip WHERE postid='{$parent}'",0);
    return $g_parent;
}
switch ($_REQUEST['STEP']) {
    case "1": { // Limit date set, calculating Next Due Dates
        $DB=DBC::get();
        $Table=$_REQUEST['TABLE'];
        $filter=$_REQUEST['FILTER'];
        /**
*         switch ($Table) {   
*            case 'taskeq_tree':
*                require("TXID_TASKEQ_TREE.php");
*                break;
*        }
*/        
/**
* Make an array of all PARENTS
* Update the CHILD records with the parent postid
*/
        $result=$DB->query("SELECT EQNUM,EQROOT,postid,parent FROM $Table WHERE EQNUM LIKE '{$filter}'");
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $level=0; $parent=$row['parent']; $a_parent=array();
            while ($parent <> 0) {
                $parent=FindParent($parent);
                $a_parent[]=$parent;
                $level++;
            }
            DBC::execute("UPDATE $Table SET LEVEL=:level WHERE EQNUM=:eqnum",array("level"=>$level,"eqnum"=>$row['EQNUM']));
            
            foreach ($a_parent as $parent_level) {
                echo "<td>$parent_level</td>";
            } 
            $array_equip[] = array(
                "LEVEL" => $level,
                "EQNUM" => $row["EQNUM"],
                "JUMP"  => str_repeat("<td></td>",$level-1));
            } 
        $tpl=new smarty_mycmms();
        $tpl->debugging=true;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("version",$version);
        $tpl->assign("step","END");
        $tpl->assign("levels",$array_equip);
        $tpl->display_error("action/gen_treelevels.tpl");
        break;
    }   // EO STEP1
    default: {
/**
* In the startup, you select an EXCEL file with a defined action 
* (See sys_import table) and the generating action starts.
* The table name will be transmitted to the routine.
*/
        $DB=DBC::get();
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("version",$version);
        $tpl->assign("step","FORM");
        $tpl->assign("title","Create tree-depth of the objects (stored in equip.LEVEL)");
        $tpl->assign('tables',$DB->query("SELECT treetablename AS id, treetablename AS text FROM tbl_treetables WHERE active=1",PDO::FETCH_NUM));
        $tpl->display_error("action/gen_treelevels.tpl");
    }
}
set_time_limit(30);
?>
