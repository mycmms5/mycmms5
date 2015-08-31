<?PHP
/** 
* Feedback on spares use
* 
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback_AS
* @filesource
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class WOPFeedbackPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT wop.ID,wop.ITEMNUM,invy.MAPICS,invy.DESCRIPTION AS 'ITEMDESCRIPTION',wop.DATEUSED,wop.QTYREQD,wop.QTYUSED,wop.WAREHOUSEID,stock.QTYONHAND 
        FROM wop 
        LEFT JOIN invy ON wop.ITEMNUM=invy.ITEMNUM 
        LEFT JOIN stock ON wop.ITEMNUM=stock.ITEMNUM AND wop.WAREHOUSEID=stock.WAREHOUSEID        
        WHERE wop.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    $sql="SELECT SERIALNUM,CHARGETO,ITEMNUM,ISSUEDATE,QTY,ISSUETO FROM issrec WHERE NUMCHARGEDTO={$this->input1} ORDER BY ITEMNUM,ISSUEDATE";
    $result=$DB->query($sql);
    $data_history=$result->fetchAll(PDO::FETCH_ASSOC);
    
    $sql="SELECT SCHEDSTARTDATE,ASSIGNEDTECH FROM wo WHERE WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data_techwh=$result->fetchAll(PDO::FETCH_ASSOC);
    $default_warehouse=array(
        "JEAN-LUC"=>"W01",
        "BERNARD"=>"W02",
        "JOEY"=>"W03",
        "JEAN-PIERRE"=>"W04",
        "SAHBI"=>"W05",
        "ALBERT"=>"W06",
        "YAHYA"=>"W07",
        "SEBASTIEN"=>"W08");
        
    $sql="SELECT FREE_TEXT FROM WOP WHERE WONUM={$this->input1} AND ITEMNUM='999999'";
    $result=$DB->query($sql);
    $data_freetext=$result->fetch(PDO::FETCH_NUM);
    $free_text=$data_freetext[0];
    
    if ($_SESSION['ACTION']=='SEARCH') {
        if (strlen($_SESSION['ITEMNUM'])>0) {
            $result=$DB->query("SELECT i.ITEMNUM,MAPICS,DESCRIPTION,QTYONHAND,WAREHOUSEID FROM invy i 
                LEFT JOIN stock s ON i.ITEMNUM=s.ITEMNUM
                WHERE MAPICS LIKE '%".$_SESSION['ITEMNUM']."%'");
            $search_results=$result->fetchAll(PDO::FETCH_NUM);        
        }
        if (strlen($_SESSION['DESCRIPTION'])>0) {
            $result=$DB->query("SELECT i.ITEMNUM,MAPICS,DESCRIPTION,QTYONHAND,WAREHOUSEID FROM invy i 
                LEFT JOIN stock s ON i.ITEMNUM=s.ITEMNUM
                WHERE DESCRIPTION LIKE '%".$_SESSION['DESCRIPTION']."%'");
            $search_results=$result->fetchAll(PDO::FETCH_NUM);        
        }
    }
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('usedspares',$data);
//    $tpl->assign('history',$data_history);
    $tpl->assign('FREE_TEXT',$free_text);
    $tpl->assign('stock_OK',$stock_OK);
    $tpl->assign('TECH_WH',$default_warehouse[$data_techwh[0]['ASSIGNEDTECH']]);
    $tpl->assign('WH_OUT',$data_techwh[0]['SCHEDSTARTDATE']);
    $tpl->assign('search_results',$search_results);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tab_wop-feedback_af.tpl');        
} // End page_content
function process_form() {   // Only Updating...
    $DB=DBC::get();
    switch ($_REQUEST['ACTION']) {
    case "UPDATE":
        try {
            $DB->beginTransaction();
            if($_REQUEST['QTYUSED']!=0) { $STOCK_InOut=true; } else { $STOCK_InOut=false; }
                if(!WAREHOUSE AND $STOCK_InOut) {
                    DBC::execute("UPDATE wop SET QTYUSED=:qtyused,WAREHOUSEID=:warehouseid WHERE ID=:id",array("id"=>$_REQUEST['ID'],"warehouseid"=>$_REQUEST['WAREHOUSEID'],"qtyused"=>$_REQUEST['QTYUSED']));
                    if ($_REQUEST['QTYUSED']==-1) {
                        DBC::execute("DELETE FROM wop WHERE ID=:id",array("id"=>$_REQUEST['ID']));
                    } // Remove from WOP
                }
/**             if (WAREHOUSE AND $STOCK_InOut) {
                    $itemnum=DBC::fetchcolumn("SELECT ITEMNUM FROM wop WHERE ID={$_REQUEST['ID']}",0);
                    DBC::execute("INSERT INTO issrec (SERIALNUM,ITEMNUM,TRANSTYPE,ISSUEDATE,FROMWAREHOUSEID,ISSUETO,CHARGETO,NUMCHARGEDTO,QTY) VALUES (NULL,:itemnum,'OUT_IN',NOW(),'DEFAULT',:issueto,'WO',:wonum,:qtyused)",array("wonum"=>$this->input1,"itemnum"=>$itemnum,"qtyused"=>$_REQUEST['QTYUSED'],"issueto"=>$_SESSION['user']));
                    DBC::execute("UPDATE wop SET QTYUSED=QTYUSED+:qtyused WHERE ID=:id",array("qtyused"=>$_REQUEST['QTYUSED'],"id"=>$_REQUEST['ID']));
                    DBC::execute("UPDATE stock SET QTYONHAND=QTYONHAND-:qtyused WHERE WAREHOUSEID='DEFAULT' AND ITEMNUM=:itemnum",array("qtyused"=>$_REQUEST['QTYUSED'],"itemnum"=>$itemnum));
                }
**/
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
            if($_REQUEST['ITEMNUM']!="-" AND $_REQUEST['QTYUSED']!=0) { $STOCK_InOut=true; } else { $STOCK_InOut=false; }
            if(!WAREHOUSE AND $STOCK_InOut) {
                    DBC::execute("INSERT INTO wop (WONUM,DATEUSED,ITEMNUM,QTYUSED,WAREHOUSEID) VALUES (:wonum,:dateused,:itemnum,:qtyused,:warehouseid)",
			array("wonum"=>$this->input1,"dateused"=>$_REQUEST['DATEUSED'],"itemnum"=>$_REQUEST['ITEMNUM'],"qtyused"=>$_REQUEST['QTYUSED'],"warehouseid"=>$_REQUEST['WAREHOUSEID']));
            } // EO TXID when warehouse is unmanaged
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }  // EO try
        break;
    case "FREE":
        try {
            $DB->beginTransaction();
            DBC::execute("UPDATE wop SET FREE_TEXT=:free_text WHERE WONUM=:wonum AND ITEMNUM='999999'",array("wonum"=>$_SESSION['Ident_1'],"free_text"=>$_REQUEST['FREE_TEXT'])); 
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
        }  // EO try
        break;
    case "SEARCH":
        $_SESSION['ACTION']=$_REQUEST['ACTION'];
        $_SESSION['ITEMNUM']=$_REQUEST['ITEMNUM'];
        $_SESSION['DESCRIPTION']=$_REQUEST['DESCRIPTION'];
        break;
    default:
        break;                           
    }
} // End process_form
} // End class

$inputPage=new WOPFeedbackPage();
$inputPage->flow();
?>
