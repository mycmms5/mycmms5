<?PHP
/** 
* Startpage for MYCMMS with full Smarty support
* 
* @author  Werner Huysmans 
* @access  public
* @package framework
* @subpackage framework
* @filesource
* @tpl fw/index.tpl
* CVS
* $Id: index.php,v 5.0 2015/07/26 12:35:00 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/index.php,v $
* $Log: index.php,v $
* Revision 5.0  
* -added support for database configuration; we no longer need to change code to change behavior; system and tabdefault are in table sys_system
*/ 
$nosecurity_check=true;
$rootfile=true;
require("./includes/config_mycmms.inc.php");    # direct path
$template=operation_template(__FILE__);
require("./libraries/setup.php");
$DB=DBC::get();

$system=DBC::fetchcolumn("SELECT setting FROM sys_system WHERE id='system'",0);
if(!empty($_GET['nav'])) {
    $_SESSION['nav']=$_GET['nav'];    
    $_SESSION['system']=$system;
} else {
/**
* @todo remove
* $_SESSION['nav']=$row['tabdefault'];
*/
    
    $_SESSION['system']=$system;
}
/**
* In order to construct the main page we will retrieve the Tabs and their default actions from the table sys_mainwindow
* - tab= name of the TAB (will be translated by GetText)
* - tabdefault = default list (WO_APPROVED for example will get the data as defined in sys_queries)
*/
$result=$DB->query("SELECT tab,tabdefault FROM sys_mainwindow WHERE system='{$_SESSION['system']}' ORDER BY taborder");
foreach ($result->fetchAll(PDO::FETCH_ASSOC) AS $tab_action) {
    $action[$tab_action['tab']]=$tab_action['tabdefault'];   
}
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign("page_title",CMMS_TITLE);
$tpl->assign("nav",$_SESSION['nav']);
$tpl->assign("query",$action[$_SESSION['nav']]);
$tpl->assign("title","title.php");
$tpl->display_error($template);
?>
