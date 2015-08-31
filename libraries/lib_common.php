<?php
/** 
* Library lib_common
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @changed:   2010-07
* @access  public
* @package library
* @subpackage functions
* @filesource
* CVS
* $Id: lib_common.php,v 1.2 2013/06/10 09:51:49 werner Exp $
* $Source: /var/www/cvs/mycmms40_lib/mycmms40_lib/lib_common.php,v $
* $Log: lib_common.php,v $
* Revision 1.2  2013/06/10 09:51:49  werner
* Commented OUT PDO_log_XML which will be probably no longer be used.
*
* Revision 1.1  2013/04/18 06:36:34  werner
* Inserted CVS variables Id,Source and Log
*
*/
/**
* Convert NOW to a string
* @time boolean : indicate the time or not
*/
function now2string($time=false) {
    if ($time) {
        return date("Y-m-d H:i:s");
    } else {
        return date("Y-m-d");
    }
}

/** 
* Log PDO transactions to PDO_ERRORLOG
* @message string : message to show
*/
define("PDO_ERRORLOG","../documents/PDO_errorlog_include.xml");
function PDO_log($message,$extra="") {
/**
* Direct logging to php.log
*/
    error_log($message,0);
    $_SESSION['PDO_ERROR'].=$message;
}
/**
function PDO_log_XML($file,Exception $exception,$extra="No extra info available") {
    $fh=fopen(PDO_ERRORLOG,"a");
    $source=$exception->getFile();
    $line=$exception->getLine();
    $message=$exception->getMessage();
    $log_message="
    <error>
    <errordate>".now2string(true)."</errordate>
    <file>Transaction in $file (line $line) failed in $source</file>
    <message>$message</message>
    <extra>$extra</extra>
    </error>";
    fwrite($fh,$log_message);
    fclose($fh);
    $_SESSION['PDO_ERROR'].=$log_message;
}
*/
/** 
* DEBUG javascript ALERT
* @pause boolean : show ALERT box
*/
function debug_pause($pause=false) {
if ($pause) {
?>    
<script type="text/javascript">
    alert("Pause");
</script>    
<?PHP
}}
/** 
* Puts a warning screen on the window when the user is not allowed to execute an action.
* @action string: PHP module
*/
function warning_screen($action) { 
    if (empty($_SESSION['user'])) {
        $login_error="This operation is not allowed. Please log in!";
    } else {
        $login_error=" is not allowed to execute ";
    }    
    require("setup.php");
    $tpl=new smarty_mycmms();
    $tpl->caching=false;
    $tpl->assign("login_error",$login_error);
    $tpl->assign("action",$action);
    $tpl->display_error("fw/no_access.tpl");
}
/** 
* Operation_allowed? Check if user is allowed to do this. 
* Function was rewritten to handle INTEGER profiles.
* $functionality string: PHP module
*/
function operation_allowed($functionality) {    
    $profile=$_SESSION['profile'];
/** 
* There must be a login before we can do a check    
*/
    if (empty($profile)) {
        warning_screen("NOLOGIN");
        exit();
    } else {
        $DB=DBC::get();        
        $path_parts=pathinfo($functionality);
        $action=$path_parts['basename'];  // Only want wo-basic.php ...
/**
* Check authorisation
* profile=1 = System Administrator
*/
        if ($profile==1) {  // Backdoor
            $boolean_permission=TRUE;
        } else {    // Normal security check
            $numrecs=DBC::fetchcolumn("SELECT COUNT(*) FROM sys_security WHERE (profile & {$_SESSION['profile']}) <> 0 AND functionality like '$action'",0);
            if ($numrecs!=0) {
                $boolean_permission = TRUE;             
            } else { 
                $boolean_permission = FALSE; 
                warning_screen($action);
                exit();
            }
        }    
    }
    return $boolean_permission;
} // End operation_allowed
?>
