<?php
/** 
* @author  Werner Huysmans 
* @tpl printout_recipe.tpl
* @txid No DB changes
* @todo Link the printing to PDF generation
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$ID=$_REQUEST['id1'];

# Data preparation
$DB=DBC::get();
$result=$DB->query("SELECT * FROM recipes WHERE ID=$ID");
$recipe_data=$result->fetch(PDO::FETCH_ASSOC);

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("stylesheet",STYLE_PATH.CSS_PRINTOUT);
$tpl->assign("recipe_data",$recipe_data);
$PrtScn=true;
if($PrtScn) {
    $tpl->display("printout/printout-recipe.tpl");
} 
?>