<?php
/** 
* BOM handling: Pick parts available in the BOM of the machine
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package work
* @subpackage preparation
* @filesource
* @tpl tab_bom-parts.tpl
* @txid No TX
* CVS
* $Id: tab_bom-parts.php,v 1.4 2013/11/04 07:50:04 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/workorders/tab_bom-parts.php,v $
* $Log: tab_bom-parts.php,v $
* Revision 1.4  2013/11/04 07:50:04  werner
* CVS version shows
*
* Revision 1.3  2013/08/07 11:05:42  werner
* DEMB version it shows not only EQNUM spares, but also EQROOT and ASSY parts
*
* Revision 1.2  2013/04/27 09:04:52  werner
* Inserted CVS variables Id,Source and Log
*
*/
require("../includes/config_mycmms.inc.php");

switch ($_REQUEST['STEP']) {
case "1": {
    $DB=DBC::get();
    for ($c=0; $c < sizeof($_REQUEST['itemnum']); $c++) {
       $needed="itemnum_needed_".$_REQUEST['itemnum'][$c];
       $result=$DB->prepare("INSERT INTO wop (WONUM,ITEMNUM,QTYREQD) VALUES (:wonum,:itemnum,:qtyreqd)");
       $result->execute(array("qtyreqd"=>$_REQUEST[$needed],"wonum"=>$_SESSION['Ident_1'],"itemnum"=>$_REQUEST['itemnum'][$c]));
   } 
?>
<script type="text/javascript">
function reload() {    
    window.location="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>"; 
} 
setTimeout("reload();", 500);
</script>
<?PHP   
   break;
}
default: {
    $DB=DBC::get();
/**
* SPARES from EQNUM, EQROOT and ASSY's
*/
    $eqnum=DBC::fetchcolumn("SELECT EQNUM FROM wo WHERE WONUM={$_SESSION['Ident_1']}",0);
    $sparecode=DBC::fetchcolumn("SELECT SPARECODE FROM equip WHERE EQNUM='$eqnum'",0);
    if (strlen($sparecode) > 2) {
        $result=$DB->query("SELECT sp.SPARECODE,sp.ITEMNUM,sp.TYPE,iv.DESCRIPTION,0,0 FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM WHERE sp.SPARECODE='$sparecode' AND sp.ITEMNUM NOT IN (SELECT ITEMNUM FROM wop WHERE WONUM={$_SESSION['Ident_1']})");
        $bomparts_eqnum=$result->fetchAll(PDO::FETCH_ASSOC);
        $result=$DB->query("SELECT DISTINCT sp.ITEMNUM FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM WHERE SPARECODE='$sparecode' AND sp.TYPE='ASSY'");
        $assys_eqnum=$result->fetchAll(PDO::FETCH_ASSOC);
    } 
    foreach ($assys_eqnum as $assy) {
        $result=$DB->query("SELECT sp.SPARECODE,sp.ITEMNUM,sp.TYPE,iv.DESCRIPTION,0,0 FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM 
            WHERE sp.SPARECODE='{$assy['ITEMNUM']}' 
            AND sp.ITEMNUM NOT IN (SELECT ITEMNUM FROM wop WHERE WONUM={$_SESSION['Ident_1']})");
        $assy_parts[]=$result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $eqroot=DBC::fetchcolumn("SELECT EQROOT FROM equip WHERE EQNUM='{$eqnum}'",0);
    $sparecode=DBC::fetchcolumn("SELECT SPARECODE FROM equip WHERE EQNUM='$eqroot'",0);
    if (strlen($sparecode) > 2) {
        $result=$DB->query("SELECT sp.SPARECODE,sp.ITEMNUM,sp.TYPE,iv.DESCRIPTION,0,0 FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM WHERE sp.SPARECODE='$sparecode' AND sp.ITEMNUM NOT IN (SELECT ITEMNUM FROM wop WHERE WONUM={$_SESSION['Ident_1']})");
        $bomparts_eqroot=$result->fetchAll(PDO::FETCH_ASSOC);
        $result=$DB->query("SELECT DISTINCT sp.ITEMNUM FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM WHERE SPARECODE='$sparecode' AND sp.TYPE='ASSY'");
        $assys_eqroot=$result->fetchAll(PDO::FETCH_ASSOC);
    } 
    foreach ($assys_root as $assy) {
        $result=$DB->query("SELECT sp.SPARECODE,sp.ITEMNUM,sp.TYPE,iv.DESCRIPTION,0,0 FROM spares sp LEFT JOIN invy iv ON sp.ITEMNUM=iv.ITEMNUM 
            WHERE sp.SPARECODE='{$assy['ITEMNUM']}' 
            AND sp.ITEMNUM NOT IN (SELECT ITEMNUM FROM wop WHERE WONUM={$_SESSION['Ident_1']})");
        $assy_parts[]=$result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->version=$version;
    $tpl->debugging=false;
    $tpl->caching=false;
    $tpl->assign('stylesheet',STYLE_PATH."/".CSS_SMARTY);
    $tpl->assign('data_eqnum',$bomparts_eqnum);
    $tpl->assign('data_eqroot',$bomparts_eqroot);
    $tpl->assign('assy_parts',$assy_parts);
    $tpl->display_error($this->template);    
} // EO default
} // EO Switch
?>
