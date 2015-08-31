<?php
/**
* Retrieve the WIKI HELP Page
* 
* @author  Werner Huysmans
* @access  public
* @package framework
* @subpackage wiki
* @filesource
* CVS
* $Id: _wikihelp.php,v 1.1 2013/06/10 09:46:07 werner Exp $
* $Source: /var/www/cvs/mycmms40/mycmms40/libraries/_wikihelp.php,v $
* $Log: _wikihelp.php,v $
* Revision 1.1  2013/06/10 09:46:07  werner
* Retrieves MediaWIKI page or shows a message
*
* Revision 1.2  2013/04/17 05:40:09  werner
* TEMP
*
*/
function get_wiki_help($script) {
    if (MEDIA_WIKI) {
        $DB=DBC::get();
        $basename=basename($script);
        define("WIKI","href='http://".SERVER_ADDRESS."/_documentation/myCMMS_MEDIAWIKI/index.php/mycmms_interface:");
        $wiki_locale="wiki_".$_SESSION['locale'];
        $wiki_HELP_Page=DBC::fetchcolumn("SELECT $wiki_locale FROM sys_security WHERE functionality='$basename'",0);   
        $wiki_URL=WIKI.$wiki_HELP_Page."' target='new'";
        return $wiki_URL;
    } else {
        return "href=\"javascript: alert('No MediaWiki installed');\"";
    }
}
?>
