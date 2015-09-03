<?php
/** Configuration file for myCMMS
* -- Customizable --
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2010
* @access  public
* @version: 4.1
* @package framework
* @subpackage includes
* @filesource
* CVS
* $Id: config_settings.inc.php,v 1.1 2015/08/27 10:10:46 MicrosoftAccount\sky38071@skynet.be Exp $
* $Source: /mycmms5/myCMMS_archive/mycmms5/includes/config_settings.inc.php,v $
* $Log: config_settings.inc.php,v $
* Revision 1.1  2015/08/27 10:10:46  MicrosoftAccount\sky38071@skynet.be
* *** empty log message ***
*
* Revision 1.3  2013/07/05 07:42:21  werner
* Handling MEDIA_WIKI setting
*
* Revision 1.2  2013/06/08 11:29:36  werner
* CVS keywords inserted, no code change
*
* @todo remove obsolete define statements
*/
define("DEMB",true);
define("SERVER_ADDRESS","localhost");   
/** Change to IP address
* i.e. define("SERVER_ADDRESS","BEBRS01AS029.eu.crh-corp.net");
*/
define("CMMS_DB","VPK");    # See libraries/databases.inc.php
define("PLANNER","sa");     # Definition for Calendar
# @todo Use profiles in sys_groups 
define("CMMS_VERSION",5.0);
define("CMMS_TITLE","Version V5.0 Build 20150902");
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define("WAMP_DIR","C:/wamp/www"); 
    define(GETTEXT,"mycmms41");   
    if (isset($_SESSION['locale'])) {
        define("LOCALE_PATH","C:\wamp\www\common\locale");
		$language=$_SESSION['locale'];  // Set during login
        putenv("LC_ALL=$language");
        $_SESSION['locale_path']=bindtextdomain(GETTEXT,LOCALE_PATH); 
        $_SESSION['locale_domain']=textdomain(GETTEXT);
    } // EO $_SESSION
} 
/**
else {    # LINUX section

    define("WAMP_DIR","/var/www");
    if (isset($_SESSION['locale'])) {
        define("LOCALE_PATH","/var/www/common/locale");
        $language=$_SESSION['locale'];  // Set during login
        putenv("LC_ALL=$language");
        setlocale(LC_ALL,$language);
        $_SESSION['locale_path']=bindtextdomain("mycmms40","/var/www/common/locale");
        $_SESSION['locale_codeset']=bind_textdomain_codeset("mycmms40","UTF-8");
        $_SESSION['locale_domain']=textdomain("mycmms40");
    } // EO if   
} // EO else
*/
define("MYCMMS_ROOTDIR","/mycmms5");    # Check & use always lowercase (relative path from WAMP_DIR)
define("CMMS_SERVER","http://".SERVER_ADDRESS.MYCMMS_ROOTDIR);  # Full SERVER path
define("DOC_PATH","/common/documents_".CMMS_DB."/");    # relative Path to documentation 
define("DOC_LINK","http://".SERVER_ADDRESS.DOC_PATH);   # URL to documentation
define("DOC_PATHS","c:/wamp/www/common/documents_".CMMS_DB."/");    # Full Path to documentation
$doc_paths=array(   
    "import"=>DOC_PATHS."import/",
    "export"=>DOC_PATHS."export/" );
/**
* Settings
*/
# define("MEDIA_WIKI",false); 
define("ITEMS_PER_PAGE",50); # Items per page
define("WAREHOUSE",false);  # Activate warehouse interactivity
define("WITH_8D",false);
define("OEE",false);
if (OEE) {
    define("OEE_SERVER","http://192.168.1.3");
    define("OEE_UID","root");
    define("OEE_PWD","ibmhuy");
    define("OEE_DB","mycmms_rt");
    define("OEE_TABLE","beckhoff_free");
}
# Styles
define("STYLE_PATH","../styles/"); # Path to styles
define("CSS_EMPTY",CMMS_STYLESHEET."/empty.css");   
define("CSS_PRINTOUT",CMMS_STYLESHEET."/printout.css");
define("CSS_SMARTY","smarty_base.css");   
define("CSS_CALENDAR","calendar-win2K-1.css"); 
define("LAUNCH_LOG","../document_links/PPM_launched.txt");
# Logo
define("LOGO_TD",CMMS_SERVER."/images/logo_".CMMS_DB.".png");
# define("LOGO_MYSQL",CMMS_SERVER."/images/mysql.png");  // MySQL logo displayed
# define("LOGO_SF",CMMS_SERVER."/images/github.png"); // SourceForge displayed

$rootdirs=array (   # relative path from rootdir mycmms5
    'main'=>'../_main/',
    'wo'=>'../workorders/',
    'pt'=>'../projects/',
    'wh'=>'../warehouse/',
    'object'=>'../objects/',
    'oee'=>'../oee/',
    'po'=>'../purchasing/',
    'ppm'=>'../ppm/',
    'system'=>'../system/',
    'admin'=>'../_mycmms/',
    'docs'=>'../documents/'
    );
?>
