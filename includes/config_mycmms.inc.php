<?php
/** Configuration file for myCMMS
* -- Shouldn't be changed --
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2010
* @access  public
* @version: 4.0
* @package framework
* @subpackage includes
* @filesource
* CVS
* $Id: config_mycmms.inc.php,v 1.1 2015/08/27 10:10:29 MicrosoftAccount\sky38071@skynet.be Exp $
* $Source: /mycmms5/myCMMS_archive/mycmms5/includes/config_mycmms.inc.php,v $
* $Log: config_mycmms.inc.php,v $
* Revision 1.1  2015/08/27 10:10:29  MicrosoftAccount\sky38071@skynet.be
* V5.0 (VPK version)
*
* Revision 1.6  2013/11/04 07:52:04  werner
* Removed $Id
*
* Revision 1.5  2013/09/07 16:27:20  werner
* $Id added LINE 56
*
* Revision 1.4  2013/08/30 14:56:21  werner
* CVS variable $Id
*
* Revision 1.3  2013/06/10 09:47:29  werner
* Cleanup - removal of old settings
*
* Revision 1.2  2013/06/08 11:28:55  werner
* CVS keywords inserted, no code change
* 
*/
session_start();
$_SESSION['DEBUG']=true;
if ($rootfile) {
    require("config_settings.inc.php");
    set_include_path(".".PATH_SEPARATOR."./includes".PATH_SEPARATOR."./libraries".PATH_SEPARATOR."./styles".PATH_SEPARATOR.PEAR_PATH);  
} else if($deep2) {
    require("config_settings.inc.php");
    set_include_path(".".PATH_SEPARATOR."../../includes".PATH_SEPARATOR."../../libraries".PATH_SEPARATOR."../styles".PATH_SEPARATOR.PEAR_PATH);      
}
else {
    require("config_settings.inc.php");
    set_include_path(".".PATH_SEPARATOR."../includes".PATH_SEPARATOR."../libraries".PATH_SEPARATOR."../styles".PATH_SEPARATOR.PEAR_PATH);
}
/**
* Initialization of the Database interface
*/
require_once("class_PDO_MySQL.php");
require_once("lib_common.php");
if (!$nosecurity_check) {
    $permission=operation_allowed($_SERVER["SCRIPT_NAME"]);
}
# $page_title=CMMS_TITLE;
# $WIKI=WIKI;
if (false) {
    $OEE_Server=OEE_SERVER;
    $OEE_Server_Uname=OEE_UID;
    $OEE_Server_Pwd=OEE_PWD;
    $OEE_Server_DB=OEE_DB;
    $OEE_Server_Table=OEE_TABLE;
}
?>
