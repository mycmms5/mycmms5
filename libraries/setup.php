<?php
/**
* Smarty Setup: defines the location of the different directories
* @author  Werner Huysmans 
*/
# require(".inc.php");
require("SMARTY/Smarty.class.php");

class smarty_mycmms extends Smarty { 
   function __construct() { 
       parent::__construct(); 
        $this->template_dir = $_SERVER['DOCUMENT_ROOT'].MYCMMS_ROOTDIR.'/smarty/templates/'; 
        $this->compile_dir  = $_SERVER['DOCUMENT_ROOT'].'/common/smarty/templates_c/'; 
        $this->config_dir   = $_SERVER['DOCUMENT_ROOT'].MYCMMS_ROOTDIR.'/smarty/configs/'; 
        $this->cache_dir    = $_SERVER['DOCUMENT_ROOT'].MYCMMS_ROOTDIR.'/smarty/cache/'; 

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
