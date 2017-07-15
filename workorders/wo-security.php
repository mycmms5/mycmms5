<?PHP
/** 
* Security evaluation form
* 
* @author  Werner Huysmans 
* @access  public
* @package BETA
* @subpackage security_form
* @filesource
* @todo Use Smarty
*/
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class thisPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $data=$this->get_data($this->input1,$this->input2);
    $security_data=DBC::fetchcolumn("SELECT data FROM wo_security WHERE WONUM={$this->input1}",0);
    $a_data=unserialize($security_data);
        
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign("data",$data);
    $tpl->assign("sec",$a_data);
    $tpl->display_error($this->template);
}
public function process_form() {
    $DB=DBC::get();
    $a_data=serialize($_REQUEST);
    try {
        $DB->beginTransaction();
        $existing_riskanalysis=DBC::fetchcolumn("SELECT data FROM wo_security WHERE WONUM={$this->input1}",0);
        if ($existing_riskanalysis) {
            DBC::execute("UPDATE wo_security SET data=:data WHERE WONUM=:wonum",
                array("wonum"=>$this->input1,"data"=>$a_data));
        } else {
            DBC::execute("INSERT INTO wo_security (WONUM,DATA) VALUES(:wonum,:data)",                   array("wonum"=>$this->input1,"data"=>$a_data));
        }
        $DB->commit();
    } catch (Exception $e) {
            $DB->rollBack();
            PDO_log($e);
    }//EO try     
}
} // End class

$inputPage=new thisPage();
$inputPage->data_sql="SELECT wo.* FROM wo WHERE wo.WONUM={$inputPage->input1}";
$inputPage->flow();
?>

