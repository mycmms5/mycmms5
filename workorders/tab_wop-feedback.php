<?PHP
/** 
* Feedback on spares use
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback
* @filesource
* @todo check warehouse connection
* CVS
* $Id: tab_wop-feedback.php,v 1.3 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_wop-feedback.php,v $
* $Log: tab_wop-feedback.php,v $
* Revision 1.3  2013/11/04 07:50:04  werner
* CVS version shows
*
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

if ($_SESSION['Ident_1']=="new") {
    require("tab_wo-unsaved.php");
    exit();
}

class WOPFeedbackPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT wop.ID,wop.ITEMNUM,invy.DESCRIPTION AS 'ITEMDESCRIPTION',wop.DATEUSED,wop.QTYREQD,wop.QTYUSED FROM wop LEFT JOIN invy ON wop.ITEMNUM=invy.ITEMNUM WHERE wop.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    $sql="SELECT SERIALNUM,CHARGETO,ITEMNUM,ISSUEDATE,QTY,ISSUETO FROM issrec WHERE NUMCHARGEDTO={$this->input1} ORDER BY ITEMNUM,ISSUEDATE";
    $result=$DB->query($sql);
    $data_history=$result->fetchAll(PDO::FETCH_ASSOC);
   
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('usedspares',$data);
    $tpl->assign('history',$data_history);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tw/wop-feedback.tpl');        
} // End page_content
function process_form() {   // Only Updating...
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if($_REQUEST['QTYUSED']!=0) { $STOCK_InOut=true; } else { $STOCK_InOut=false; }
                if(!WAREHOUSE AND $STOCK_InOut) {
                    DBC::execute("UPDATE wop SET QTYUSED=:qtyused WHERE ID=:id",array("id"=>$_REQUEST['ID'],"qtyused"=>$_REQUEST['QTYUSED']));
                }
                if (WAREHOUSE AND $STOCK_InOut) {
                    $itemnum=DBC::fetchcolumn("SELECT ITEMNUM FROM wop WHERE ID={$_REQUEST['ID']}",0);
                    DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,TRANSTYPE,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY) VALUES (NULL,:itemnum,'OUT_IN',NOW(),'DEFAULT',:issueto,'WO',:wonum,:qtyused)",array("wonum"=>$this->input1,"itemnum"=>$itemnum,"qtyused"=>$_REQUEST['QTYUSED'],"issueto"=>$_SESSION['user']));
                    DBC::execute("UPDATE wop SET QTYUSED=QTYUSED+:qtyused WHERE ID=:id",array("qtyused"=>$_REQUEST['QTYUSED'],"id"=>$_REQUEST['ID']));
                    DBC::execute("UPDATE stock SET QTYONHAND=QTYONHAND-:qtyused WHERE WAREHOUSEID='DEFAULT' AND ITEMNUM=:itemnum",array("qtyused"=>$_REQUEST['QTYUSED'],"itemnum"=>$itemnum));
                } 
            $DB->commit();        
            return __FILE__." OK";
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        } // EO try
        break;
    case "INSERT":
        try {
            $DB->beginTransaction();
            $found=DBC::fetchcolumn("SELECT COUNT(*) FROM invy WHERE ITEMNUM='{$_REQUEST['ITEMNUM']}'",0);
            if ($found==0) {
                PDO_log("Article not found");
                break;
            } 
            if ($_REQUEST['QTYUSED']!=0) { $STOCK_InOut=true; } else { $STOCK_InOut=false; }
/**
* WAREHOUSE is not managed             
*/
            if(!WAREHOUSE AND $STOCK_InOut) {
                    DBC::execute("INSERT INTO wop (WONUM,ITEMNUM,DATEUSED,QTYUSED) SELECT :wonum,ITEMNUM,NOW(),:qtyused FROM invy WHERE ITEMNUM=:itemnum",array("wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'])); 
            } // EO TXID when warehouse is unmanaged
/**
* WAREHOUSE is managed            
*/
            if (WAREHOUSE AND $STOCK_InOut) {
                    $unitcost=DBC::fetchcolumn("SELECT UNITCOST FROM invcost WHERE ITEMNUM={$_REQUEST['ITEMNUM']}",0);
                    DBC::execute("INSERT INTO wop (WONUM,DATEUSED,ITEMNUM,QTYUSED,WAREHOUSEID,UNITCOST) VALUES (:wonum,NOW(),:itemnum,:qtyused,'DEFAULT',:unitcost)",array("wonum"=>$this->input1,"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'],"unitcost"=>$unitcost));
                    DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY)  
                    VALUES (NULL,:itemnum,NOW(),'DEFAULT',:issueto,'WO',:wonum,:qtyused)",array("wonum"=>$this->input1,"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'],"issueto"=>$_SESSION['user']));
                    DBC::execute("UPDATE wop SET COST=QTYUSED*UNITCOST WHERE COST IS NULL",array());
                    DBC::execute("UPDATE stock SET QTYONHAND=QTYONHAND-:qtyused WHERE WAREHOUSEID='DEFAULT' AND ITEMNUM=:itemnum",array("qtyused"=>$_REQUEST['QTYUSED'],"itemnum"=>$_REQUEST['ITEMNUM']));
            } // EO TXID when warehouse is managed
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }  // EO try
        break;
    default:
        break;                           
    }
} // End process_form
} // End class

$inputPage=new WOPFeedbackPage();
$inputPage->version=$version; 
$inputPage->flow();
?>
