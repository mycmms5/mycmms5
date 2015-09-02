<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class password extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        $tpl->assign("stylesheet_calendar",STYLE_PATH."/".CSS_CALENDAR);
        $tpl->assign("categories",array("Delete","Active","Archive"));
        $tpl->assign("sitetypes",array("INFO","eBusiness","eStore"));
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->display("tw/password.tpl");
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO palm_password (URL,Username,Password,Email,Categories,SiteType,Memo) VALUES (:url,:username,:password,:email,:categories,:sitetypes,:memo)",array("url"=>$_REQUEST['URL'],"username"=>$_REQUEST['Username'],"password"=>$_REQUEST['Password'],"email"=>$_REQUEST['Email'],"categories"=>$_REQUEST['Categories'],"sitetypes"=>$_REQUEST['SiteType'],"memo"=>$_REQUEST['Memo']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;

            } else {    
                DBC::execute("UPDATE palm_password SET URL=:url,Username=:username,Password=:password,Email=:email,Categories=:categories,SiteType=:sitetypes,Memo=:memo WHERE ID=:id",array("url"=>$_REQUEST['URL'],"username"=>$_REQUEST['Username'],"password"=>$_REQUEST['Password'],"email"=>$_REQUEST['Email'],"categories"=>$_REQUEST['Categories'],"sitetypes"=>$_REQUEST['SiteType'],"memo"=>$_REQUEST['Memo'],"id"=>$_REQUEST['id1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
            PDO_log("Transaction ".__FILE__." failed: ".$e->getMessage());
        }
    } // EO process_form                
} // EO Class

$inputPage=new password();
$inputPage->data_sql="SELECT * FROM palm_password WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>