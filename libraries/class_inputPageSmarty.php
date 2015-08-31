<?php
/**
* CVS
* $Id: class_inputPageSmarty.php,v 1.3 2013/07/05 07:41:07 werner Exp $
* $Source: /var/www/cvs/mycmms40_lib/mycmms40_lib/class_inputPageSmarty.php,v $
* $Log: class_inputPageSmarty.php,v $
* Revision 1.3  2013/07/05 07:41:07  werner
* No Changes - only sync
*
* Revision 1.2  2013/06/10 09:50:27  werner
* Rewrite for MediaWIKI
*
* Revision 1.1  2013/04/18 06:28:37  werner
* Inserted CVS variables Id,Source and Log
*
*/
/** 
* class inputPageSmarty: 
*   class for input pages using Smarty Templates
* 
* @author  Werner Huysmans <werner.huysmans@skynet.be>
* @access  public
* @package library
* @subpackage classes
*/
class inputPageSmarty {
    public $data_sql;  // SELECT statement for 
    public $input1;    // Set to $_REQUEST or $_SESSION
    public $input2;
    public $version;
#    private $wiki;
/** 
* Constructor: 
* - The 2 first columns of a list are stored in the Session. We'll transfer them to public values input1 and input2
* - the data_sql statement gets the form-values 
*/
function __construct() {
    $this->input1=$_SESSION['Ident_1'];
    $this->input2=$_SESSION['Ident_2'];
    #$basename=basename($_SERVER['SCRIPT_NAME']);
    # $wiki_locale="wiki_".$_SESSION['locale'];
    # $this->wiki=DBC::fetchcolumn("SELECT $wiki_locale AS 'wiki' FROM sys_security WHERE functionality='$basename'",0);
} // EO __construct
/**
* Gets data from myCMMS 
* 
* @param mixed $in1 (for example the WONUM)
* @param mixed $in2 (for example the EQNUM)
* @return array
*/
public function get_data($in1, $in2) {
    $DB=DBC::get();
    $result=$DB->query($this->data_sql);
    if ($result) {
        $data=$result->fetch(PDO::FETCH_ASSOC);
    }
    return $data;
} // EO get_data
/**
* Validate the transmitted values -- will be overridden
* 
*/
public function validate_form() {
    // Must be overridden when used
    $errors = array();
    return $errors;
} // End validate_form
/**
* Page Content : see Smarty
* 
*/
public function page_content() {} // End page_content, this function is empty, since handled by Smarty
/**
* The Page Footer will always contain:
* - WIKI link
* - eventual errors that occured during data-handling
* 
* @param mixed $errors
* @todo better formatting
*/
private function page_footer($errors) {
/**
* WIKI HELP has been removed
*/
    $tpl=new smarty_mycmms();
    $tpl->assign("version",$this->version);
    $tpl->assign("errors",$errors);
    $tpl->display_error("fw/inputPageFooter.tpl");
    unset($_SESSION['PDO_ERROR']);
} // End page_footer
/**
* display form content+footer_of_page
* @param mixed $errors
*/
public function display_form($errors) {
    $this->page_content();
    $this->page_footer($errors);
}
/**
* empty process_form, must be created during class instantiantion
*/
public function process_form() {} // End process_form
/**
* Process flow
* - If 1st time show Form
* - Verify input
* - Do data handling: form_save; process and reshow form
* - Do data handling: close; process but then close form
* 
*/
public function flow() {
    if ($_SERVER['REQUEST_METHOD']=='GET') 
    {   $this->display_form(array());      
    } else {
        $errors=$this->validate_form();
    if (count($errors)) {
        $this->display_form($errors);  // Redisplay 
    } else {
        if (isset($_REQUEST['form_save'])) {
            $data=$this->process_form($_REQUEST);
?>
<script type="text/javascript">
function reload() {    
    window.location="<?PHP echo $_SERVER['SCRIPT_NAME']; ?>"; 
} 
setTimeout("reload();", 250);
</script>
<?PHP        
        } 
        if (isset($_REQUEST['close'])) {
            $data=$this->process_form($_REQUEST);
?>
<script type="text/javascript">
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
    window.parent.close();
    
</script>
<?PHP            
}}}
} // End flow
}   // End class
?>
