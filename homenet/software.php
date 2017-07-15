<?php
require("../includes/config_mycmms.inc.php");
require("class_inputPageSmarty.php");

class software extends inputPageSmarty {
    public function page_content() {
        $DB=DBC::get();
        $data=$this->get_data($this->input1,$this->input2);
        require("setup.php");
        $tpl=new smarty_mycmms();
        $tpl->debugging=false;
        $tpl->assign("stylesheet",STYLE_PATH."/".CSS_SMARTY);
        switch ($data['category']) {
            case "SW":
                break;
            case "INFO":
                break;
            case "LOG":
                break;
            default:
                break;        
        }
        $tpl->assign("categories",$DB->query("SELECT category AS id,CONCAT(category,':',description) AS text FROM tbl_categories",PDO::FETCH_NUM));
        $tpl->assign("boxes",$DB->query("SELECT storage AS id,CONCAT(storage,':',description) AS text FROM tbl_storage",PDO::FETCH_NUM));
        $tpl->assign("data",$data);
        $tpl->assign("ID",$this->input1);
        $tpl->display($this->template);
    } // EO page_content
    function process_form() {   // Only updating
        $DB=DBC::get();
        try {
            $DB->beginTransaction();
            if ($_REQUEST['new']=="on") {
                DBC::execute("INSERT INTO software (ID,date_ID,category,title,content,box,classification) VALUES (NULL,:date_id,:category,:title,:content,:box,:classification)",
                    array("date_id"=>$_REQUEST['date_ID'],"category"=>$_REQUEST['category'],
                    "title"=>$_REQUEST['title'],"content"=>$_REQUEST['content'],"box"=>$_REQUEST['box'],"classification"=>$_REQUEST['classification']));
                $_SESSION['Ident_1']=DBC::fetchcolumn("SELECT LAST_INSERT_ID()",0);
                $_SESSION['Ident_2']=0;
            } else {    
                DBC::execute("UPDATE software SET date_ID=:date_id,category=:category,title=:title,content=:content,box=:box,classification=:classification  WHERE ID=:id",
                array("date_id"=>$_REQUEST['date_ID'],"category"=>$_REQUEST['category'],
                    "title"=>$_REQUEST['title'],"content"=>$_REQUEST['content'],"box"=>$_REQUEST['box'],"classification"=>$_REQUEST['classification'],
                    "id"=>$_SESSION['Ident_1']));
            }
            $DB->commit();
        } catch (Exception $e) {
            $DB->rollBack();
        }
    } // EO process_form                
} // EO Class

$inputPage=new software();
$inputPage->data_sql="SELECT * FROM software WHERE ID='{$inputPage->input1}'";
$inputPage->flow();
?>
   