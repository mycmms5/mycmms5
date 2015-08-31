<?php
/**
* Smarty Setup: defines the location of the different directories
* 
* @author  Werner Huysmans 
* @access  public
* @package framework
* @subpackage smarty
* @filesource
*/
require('config_settings.inc.php');
require('smarty/Smarty.class.php');

class smarty_mycmms extends Smarty { 
   function __construct() { 
        parent::__construct(); 
        $this->template_dir = SMARTY.'templates/'; 
        $this->compile_dir  = PEAR_PATH.'/temp/templates_c/'; 
        $this->config_dir   = SMARTY.'configs/'; 
        $this->cache_dir    = SMARTY.'cache/'; 

        $this->caching = Smarty::CACHING_OFF;
        $this->assign('app_name', 'mycmms'); 
   } 
   function display_error($template) {
       try {
            $this->display($template);
       } catch (exception $e) {
            error_log($e.message);
            echo nl2br($e.message);
       }
   }
} 
?>
