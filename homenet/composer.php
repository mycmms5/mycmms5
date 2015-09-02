<?
require("../includes/config_mycmms.inc.php");
require(CMMS_LIB."/class_masterPage.php");

$MTPage=new masterPage();
$MTPage->table="tbl_composers";
$MTPage->keyfield="NAME";
$MTPage->stylesheet=CSS_INPUT;
$MTPage->formName="treeform";
$MTPage->calendar=false;
$MTPage->input1=$_REQUEST['id1'];
$MTPage->input2="";
$MTPage->flow();
?>

