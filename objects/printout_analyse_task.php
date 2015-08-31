<?PHP
/** 
* Printout Object
* 
* @author  Werner Huysmans 
* @access  public
* @package objects
* @subpackage printout
* @filesource
*/
$nosecurity_check=true;
require("../includes/config_mycmms.inc.php");
require("setup.php");
$PrtScn=true;
$EQNUM=$_REQUEST['id1'];
# Data preparation
define("OBJECT_DATA",true);
define("OBJECT_RISK",true);
define("OBJECT_TASKS",true);
define("OBJECT_WO",true);
require("printout_object_data.php");
# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign('stylesheet',STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("doc_link",DOC_LINK);
$tpl->assign("upload_path",UPLOAD_PATH);
$tpl->assign("object_main_data",$object_data);
$tpl->assign("object_risk_data",$object_risk);
# $tpl->assign("components",$components);
$tpl->assign("object_tasks",$object_tasks);
$tpl->assign("workorders",$workorders);
$tpl->display_error('printout_analyse_task.tpl');
?>
