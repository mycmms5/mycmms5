<?PHP
/** tab_cover for CD
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   20091108
* @access  public
* @package 
*/
require("../includes/config_mycmms.inc.php");
session_start();
$directory=floor($_SESSION['Ident_1']/100);
?>
<img src="<?PHP echo DOC_LINK."video/dvd".$directory."/DVD".$_SESSION['Ident_1'].".jpg"; ?>" width="800" alt="Image">