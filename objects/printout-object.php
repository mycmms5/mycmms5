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
require("../includes/config_mycmms.inc.php");
require("class_printoutPageSmarty.php");
require("setup.php");
$EQNUM=$_REQUEST['id1'];

$printout=new printoutPageSmarty();
$printout->main_data("SELECT * FROM equip WHERE equip.EQNUM='$EQNUM'");  
$printout->listdata1("SELECT dl.filename, filedescription FROM dl LEFT JOIN dd ON dl.filename=dd.filename WHERE link='$EQNUM'");
$printout->listdata2("SELECT e.EQNUM,e.DESCRIPTION FROM equip e WHERE EQROOT='$EQNUM'");
$printout->listdata3("SELECT WONUM,TASKDESC,PRIORITY FROM wo WHERE EQNUM='$EQNUM'");
#$printout->listdata4
$printout->display();
?>
