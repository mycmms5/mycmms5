<?php
/**
* SAP functions
* 
* @author  Werner Huysmans 
* @access  public
* @package libraries
* @subpackage SAP
* @filesource
*/
function SAP_trim($value,$length) {
    $trimmed_value=substr($value,0,$length);
    $trimmed_value=str_pad($trimmed_value,$length," ",STR_PAD_RIGHT);
    return $trimmed_value;
}
function SAP_date($value) {
// YYYY-MM-DD HH:MM:SS
    return substr($value,0,4).substr($value,5,2).substr($value,8,2);    
}
function SAP_datetime($value) {
    return substr($value,0,4).substr($value,5,2).substr($value,8,2).substr($value,11,2).substr($value,14,2);    
}
?>
