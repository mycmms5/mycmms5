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
$DB=DBC::get();
$result=$DB->query("SELECT * FROM equip WHERE equip.EQNUM='$EQNUM'");
$object_main_data=$result->fetch(PDO::FETCH_ASSOC);
/**
* Adapted version where the BOMs are attached to the equip objects
*/
if (CMMS_DB=="AUBY") {
$result=$DB->query("SELECT EQNUM FROM equip WHERE EQROOT='$EQNUM'");
$boms=$result->fetchAll(PDO::FETCH_NUM);
$str_select="SELECT EQROOT AS 'BOM',equip.EQNUM AS 'ITEMNUM',equip.DESCRIPTION AS 'DESCRIPTION',Q12,Q13,Q14,VAL14/Q14 AS 'VALUE' FROM equip LEFT JOIN ISSREC_AUBY AS ia ON equip.EQNUM=ia.ITEMNUM WHERE EQROOT IN (";
foreach ($boms as $bom) {
    $str_select=$str_select."'".$bom[0]."',";
}
$str_select=$str_select."'xxx')";
# DebugBreak();
$result=$DB->query($str_select);
$spares=$result->fetchAll(PDO::FETCH_ASSOC);
}

#DebugBreak();
$str_select="SELECT * FROM issrec_mb51 WHERE EQNUM='$EQNUM'";
$result=$DB->query($str_select);
$mb51=$result->fetchAll(PDO::FETCH_ASSOC);

#$doc_links["equipment"];
#$result=$DB->query("SELECT dl.FILENAME, FILEDESCRIPTION FROM document_links dl LEFT JOIN document_descriptions dd ON dl.FILENAME=dd.FILENAME WHERE EQNUM='$EQNUM'");
#$documents=$result->fetchAll(PDO::FETCH_ASSOC);

$result=$DB->query("SELECT * FROM wo WHERE EQNUM='$EQNUM' ORDER BY REQUESTDATE DESC LIMIT 0,5");
$workorders=$result->fetchAll(PDO::FETCH_ASSOC);
/**
* NOT USED
* $result=$DB->query("SELECT * FROM wo_copy WHERE EQNUM='$EQNUM' ORDER BY REQUESTDATE DESC LIMIT 0,5");
* $workorders2=$result->fetchAll(PDO::FETCH_ASSOC);
*/


/**
* Only After-Sales
* 
$result=$DB->query("SELECT EQNUM,EQROOT,NAME,DESCRIPTION FROM equip_clients LEFT JOIN clients ON clients.CLID=equip_clients.EQROOT WHERE EQTYPE='$EQNUM'");
$installed=$result->fetchAll(PDO::FETCH_ASSOC);
*/

# Printout
$tpl=new smarty_mycmms();
$tpl->debugging=false;
$tpl->caching=false;
$tpl->assign('stylesheet',STYLE_PATH."/".CSS_PRINTOUT);
$tpl->assign("doc_link",DOC_LINK);
$tpl->assign("object_main_data",$object_main_data);
$tpl->assign("components",$components);
$tpl->assign("workorders",$workorders);
$tpl->assign("mb51",$mb51);
$tpl->assign("spares",$spares);
$tpl->assign("documents",$documents);
$tpl->assign("status",$status);
$tpl->assign("installed",$installed);
$tpl->display_error('printout_nyrstar.tpl');
?>
