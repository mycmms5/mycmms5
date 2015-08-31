<?PHP
/**
* Special form used for barcode input
*  
* @author  Werner Huysmans 
* @access  public
* @package work
* @subpackage feedback_barcode
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class wopBarcodePage extends inputPageSmarty {
public function validate_form() {
    $errors = array();
    if (substr($_REQUEST['ITEMNUM'],0,3)!="200") { $errors['BARCODE']=_("BARCODE Invalid: Not a part number"); } 
    return $errors;
}    
public function page_content() {
    $DB=DBC::get();
    $sql="SELECT wop.*,invy.DESCRIPTION FROM wop LEFT JOIN invy ON wop.ITEMNUM=invy.ITEMNUM WHERE wop.WONUM={$this->input1}";
    $result=$DB->query($sql);
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('parts',$data);
    $tpl->assign('actual_id',$_REQUEST['ID']);
    $tpl->display_error('tab_wop_barcode.tpl');        
} // End page_content
public function process_form() {
    require("TXID_2002.php");
}
} // End class

$inputPage=new wopBarcodePage();
$inputPage->flow();
?>

