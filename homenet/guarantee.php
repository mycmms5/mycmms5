<?PHP
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");
$version=__FILE__." :V5.0 Build 20150808";

class Purchase extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->assign("stores",$DB->query("SELECT STORAGE AS id, Description AS text FROM tbl_BookStores",PDO::FETCH_NUM));
        $tpl->display("tw/guarantee.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {    
                DBC::execute("INSERT INTO Guarantee (PurchaseDate,Shop,Item,Manual,Price,EndDate,Type) VALUES (:purchasedate,:shop,:item,:manual,:price,:enddate,:type)",
                    array("purchasedate"=>$_REQUEST['PurchaseDate'],"shop"=>$_REQUEST['Shop'],"item"=>$_REQUEST['Item'],"manual"=>$_REQUEST['Manual'],"price"=>$_REQUEST['Price'],"enddate"=>$_REQUEST['EndDate'],"type"=>$_REQUEST['Type']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE Guarantee SET PurchaseDate=:purchasedate,EndDate=:enddate,Shop=:shop,Item=:item,Manual=:manual,Price=:price,Type=:type WHERE ID=:id1",
                    array("purchasedate"=>$_REQUEST['PurchaseDate'],"shop"=>$_REQUEST['Shop'],"item"=>$_REQUEST['Item'],"manual"=>$_REQUEST['Manual'],"price"=>$_REQUEST['Price'],"enddate"=>$_REQUEST['EndDate'],"type"=>$_REQUEST['Type'],"id1"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new Purchase();
$inputPage->version=$version;
$inputPage->data_sql="SELECT * FROM Guarantee WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>
