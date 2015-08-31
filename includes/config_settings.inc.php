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
define("SERVER_ADDRESS","localhost");   # Change to IP address
// define("SERVER_ADDRESS","BEBRS01AS029.eu.crh-corp.net");
/**
* The database identifier will determine:
* - the DATABASE
* - documents
* - GETTEXT translations
*/
define("CMMS_DB","VPK");
define("PLANNER","sa");
# define("CMMS_LIB","myCMMS41_lib");              # In Version 5 the libraries are reintegrated in the MYCMMS directory
# define("CMMS_STYLESHEET","myCMMS41_styles");    # In Version 5 the libraries are reintegrated in the MYCMMS directory
define("CMMS_VERSION",5.0);
define("CMMS_TITLE","Version V5.0 Build 20150823");
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define("WAMP_DIR","C:/wamp/www"); 
    define(GETTEXT,"mycmms41");   
    if (isset($_SESSION['locale'])) {
        // define("LOCALE_PATH","C:\Program Files (x86)\NuSphere\TechPlat\apache\htdocs\common\locale");
        define("LOCALE_PATH","C:\wamp\www\common\locale");
		$language=$_SESSION['locale'];  // Set during login
        putenv("LC_ALL=$language");
        $_SESSION['locale_path']=bindtextdomain(GETTEXT,LOCALE_PATH); 
        $_SESSION['locale_domain']=textdomain(GETTEXT);
    } // EO $_SESSION
} else {    # LINUX section
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
define("MYCMMS_ROOTDIR","/mycmms5"); # Check & use always lowercase (relative path from WAMP_DIR)
define("CMMS_SERVER","http://".SERVER_ADDRESS.MYCMMS_ROOTDIR);
define("DOC_PATH","/common/documents_".CMMS_DB."/");    # Directory
define("DOC_LINK","http://".SERVER_ADDRESS.DOC_PATH);   # URL 
# define("MYCMMS_PEAR_PATH","/common/pear/PEAR");         # URL path to
# define("SMARTY",WAMP_DIR.MYCMMS_ROOTDIR."/smarty/");    # SMARTY Path
# define("PEAR_PATH",WAMP_DIR.MYCMMS_PEAR_PATH);          # PEAR Path 
/** Translations via GetText
* for GetText you must indicate the absolute path
*/
/**
* URL Settings
*/
define("MEDIA_WIKI",false);
// Settings
define("ITEMS_PER_PAGE",50); # Items per page
// Stylesheets that are frequently used
define("STYLE_PATH","../styles/"); # Path to styles
define("CSS_EMPTY",CMMS_STYLESHEET."/empty.css");
// define("CSS_UPLOAD","upload_style.css");
define("CSS_PRINTOUT",CMMS_STYLESHEET."/printout.css");
define("CSS_SMARTY","smarty_base.css");   
define("CSS_CALENDAR","calendar-win2K-1.css"); 
define("LAUNCH_LOG","../document_links/PPM_launched.txt");
// Logo
define("LOGO_TD",CMMS_SERVER."/images/logo_".CMMS_DB.".png");
#define("LOGO_MYSQL",CMMS_SERVER."/images/mysql.png");  // MySQL logo displayed
#define("LOGO_SF",CMMS_SERVER."/images/sf.png"); // SourceForge displayed
/**
* The OEE interface is not activated by default
define("OEE",false);  // OEE inactive
define("OEE_SERVER","http://192.168.1.3");
define("OEE_UID","root");
define("OEE_PWD","ibmhuy");
define("OEE_DB","mycmms_rt");
define("OEE_TABLE","beckhoff_free");
*/
/**
* WEBCAL interface supposes you have the WebCalendar application on a Server
* All settings must be set manually
*
define("WEBCAL",false);
define("WEBCAL_SERVER","http://backup/internet/webcalendar/login.php?login=admin&password=admin");
*/
/**
* myCMMS uses warehouse functionality:
* - registration of IN/OUT
*/
define("WAREHOUSE",false);
define("WITH_8D",false);
/** $doc_links=array(
    "warehouse"=>DOC_LINK."warehouse/",
    "task"=>DOC_LINK."workorders/",
    "workorders"=>DOC_LINK."workorders/",
    "purchasing"=>DOC_LINK."purchasing/",
    "equipment"=>DOC_LINK."equipments/",
    "projects"=>DOC_LINK."projects/",
    "temp"=>DOC_LINK."temporary/",
    "import"=>DOC_LINK."import/",
    "export"=>DOC_LINK."export/",
    "maintenance"=>DOC_LINK."maintenance/",
    "mycmms"=>DOC_LINK."mycmms/"
    );
**/
define("DOC_PATHS","c:/wamp/www/common/documents_".CMMS_DB."/");
$doc_paths=array(   # absolute path, is still used in im/export, should be avoided!
    "import"=>DOC_PATHS."import/",
    "export"=>DOC_PATHS."export/",
);
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
