<?php
/** 
* Generate_tree
*
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package framework
* @subpackage tree
* @filesource
* @done 20150625 code cleanup and revision of procedure (the existing one is long)
**/
set_time_limit(0);
require("../includes/config_mycmms.inc.php");  
require("setup.php");
$version=__FILE__." :V5.0 Build ".date ("F d Y H:i:s.", filemtime(__FILE__));
$filter=$_REQUEST['FILTER'];
$check_parents = true;
$check_children = true;

switch ($_REQUEST['STEP']) {
    case "1": { // Limit date set, calculating Next Due Dates
        $DB=DBC::get();
        $Table=$_REQUEST['TABLE'];
        if ($check_parents) {
/**
* Make an array of all PARENTS
* Update the CHILD records with the parent postid
*/
            $result=$DB->query("SELECT DISTINCT e1.EQROOT,e2.postid FROM $Table e1 LEFT JOIN $Table e2 ON e1.EQROOT=e2.EQNUM WHERE e1.EQNUM LIKE '$filter'");
            foreach ($result->fetchAll(PDO::FETCH_NUM) as $row) {
                DBC::execute("UPDATE $Table SET parent=:parent WHERE EQROOT=:eqroot",array("parent"=>$row[1],"eqroot"=>$row[0]));
            }
        }
        if ($check_children) { 
/**
* First set children=0 on all records 
* Get all records that have children      
*/
            DBC::execute("UPDATE $Table SET children=0 WHERE EQNUM LIKE ':filter'",array("filter"=>$filter));
            DBC::execute("DELETE FROM tmp_equip_children",array());
            DBC::execute("INSERT INTO tmp_equip_children SELECT e1.EQROOT,COUNT(*) AS 'Aantal' FROM $Table e1 LEFT JOIN $Table e2 ON e1.EQNUM=e2.EQROOT GROUP BY e1.EQROOT;",array());
            $result=$DB->query("SELECT EQROOT,AANTAL FROM tmp_equip_children WHERE EQROOT LIKE '$filter'");
            $i=0;
            foreach ($result->fetchAll(PDO::FETCH_NUM) as $row) {
                $tree_report[$i]['MCH']=$row[0]; $tree_report[$i]['CHILDREN']=$row[1];
                DBC::execute("UPDATE $Table SET children=1 WHERE EQNUM=:eqnum",array("eqnum"=>$row[0]));
                $i++;
            } 
            DBC::execute("UPDATE $Table SET parent=0 WHERE EQROOT='ROOT'",array());
}        
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("version",$version);
        $tpl->assign("step","END");
        $tpl->assign("title","Each parent with children is shown with the number of.");
        $tpl->assign("tree_report",$tree_report);
        $tpl->display_error("action/gen_tree.tpl");
        break;
    }   // EO STEP1
    default: {
/**
* Select a table with the tree format (see the equip table)
*/
        $DB=DBC::get();
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("version",$version);
        $tpl->assign("step","FORM");
        $tpl->assign("title","Check parent-child relation and check if an object has children - select table");
        $tpl->assign('tables',$DB->query("SELECT treetablename AS id, treetablename AS text FROM tbl_treetables WHERE active=1",PDO::FETCH_NUM));
        $tpl->display_error("action/gen_tree.tpl");
    }
}
set_time_limit(30);
?>
