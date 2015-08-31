<?PHP
/** 
* This is a special function to quickly change the status of an object.
* Developed for the VPK Project
* 
* @author  Werner Huysmans
* @access  public
* @package objects
* @filesource
* @todo direct integration in tree
*/
require("../includes/config_mycmms.inc.php");
$EQNUM=$_REQUEST['id1'];
$DB=DBC::get();
DBC::execute("UPDATE equip SET EQFL='ARTICLE' WHERE EQNUM=:eqnum",array("eqnum"=>$EQNUM));
?>
<script type="text/javascript">
window.opener.location.reload();
// window.close();
</script>

