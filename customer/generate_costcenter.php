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

/**
echo "This function cannot be run now, first verify that all costcenters are defined somewhere, otherwise you may corrupt good data";
exit();
*/
switch ($_REQUEST['STEP']) {
    case "1": { // Limit date set, calculating Next Due Dates
        $DB=DBC::get();
        $Table=$_REQUEST['TABLE'];
        $no_cc=0;
        echo "<table>";
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
        $result=$DB->query("SELECT EQNUM,EQROOT,postid,parent,COSTCENTER FROM $Table WHERE COSTCENTER IS NULL OR COSTCENTER=''");
        foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $CC=DBC::fetchcolumn("SELECT COSTCENTER FROM equip WHERE postid='{$row['parent']}'",0);
            if (is_null($CC) OR ($CC=='')) {
                $no_cc++;
            } else {
#                DebugBreak();
                echo "<tr><td>".$row['EQNUM']."</td><td>".$row['EQROOT']."</td><td>".$CC."</td></tr>";
                DBC::execute("UPDATE $Table SET COSTCENTER=:costcenter WHERE EQNUM=:eqnum",array("costcenter"=>$CC,"eqnum"=>$row['EQNUM']));    
            }
        } 
        echo "<tr><td colspan='3'>".$no_cc."</td></tr>";
        echo "</table>";
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("step","END");
        $tpl->display_error("action/gen_tree.tpl");
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
        $tpl->assign("step","FORM");
        $tpl->assign("title","Look for a CostCenter in the parent(s)");
        $tpl->assign('tables',$DB->query("SELECT treetablename AS id, treetablename AS text FROM tbl_treetables WHERE active=1",PDO::FETCH_NUM));
        $tpl->display_error("action/gen_tree.tpl");
    }
}
set_time_limit(30);
?>
