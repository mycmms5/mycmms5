<?PHP
/** tab_cover for CD
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091108
* @access  public
* @package 
*/
require("../includes/config_mycmms.inc.php");
$directory=floor($_SESSION['Ident_1']/100);
?>
<img src="<?PHP echo DOC_LINK."music/".$directory."/".$_SESSION['Ident_1'].".jpg"; ?>" alt="Image" width="100%">