<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class objectPage extends inputPageSmarty {
public function page_content() {
    $DB=DBC::get();
    $analyses=$this->get_data($this->input1,$this->input2);
    $analyse_data=DBC::fetchcolumn("SELECT DATA FROM 8D WHERE ID='{$this->input2}'",0);
    $a_data=unserialize($analyse_data);
        
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->debugging=false;
    $tpl->assign('stylesheet',STYLE_PATH.CSS_SMARTY);
    $tpl->assign("data",$a_data);
    $tpl->assign("analyses",$analyses);
    $tpl->display_error($this->template);
}
public function process_form() {
    $DB=DBC::get();
    $a_data=serialize($_REQUEST);
    try {
        $DB->beginTransaction();
        if ($_REQUEST['NEW'] == "on") {
            DBC::execute("INSERT INTO 8D (ID,STARTDATE,TITLE,EQNUM,DATA) VALUES(NULL,NOW(),:title,:eqnum,:data)",
                array("title"=>$_REQUEST['TITLE'],"eqnum"=>$_REQUEST['EQNUM'],"data"=>$a_data));
            
        } else {
            DBC::execute("UPDATE 8D SET DATA=:data WHERE ID=:id",
                array("id"=>$this->input2,"data"=>$a_data));
        }
        $DB->commit();
    } catch (Exception $e) {
        $DB->rollBack();
    } // EO try 
    if ($_REQUEST['NEW']=="on") {   
        $Record=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
    } else {  
        $Record=$_REQUEST['id1'];}
    $this->input1=$_SESSION['Ident_1']=$_REQUEST['EQNUM'];
    $this->input2=$_SESSION['Ident_2']=$Record;
} // EO process_form
} // EO class

$inputPage=new objectPage();
$inputPage->data_sql="SELECT * FROM 8D WHERE ID='{$inputPage->input2}'";
$inputPage->flow();  
?>
