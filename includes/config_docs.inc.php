<?php
/**
* @access public
* @package framework
*/
switch($_SESSION['DOCTYPE']) {
case 'WONUM':
    $doctype='wo';
    break;
case 'TASKNUM':
    $doctype='task';
    break;  
case 'EQNUM':
    $doctype='eq';
    break;  
case 'ITEMNUM':
    $doctype='item';
    break;  
/**
* HOMENET
*/
case 'MUSIC':
    $doctype='mus';
    break;
case 'CDMAG':
    $doctype='cdmag';
    break;
case 'HOME':
    $doctype='home';
    break;   
case 'video':
    $doctype='dvd';
    break;  
case 'ADMIN':
    $doctype='admin';
    break;  
case 'CIE':
    $doctype='cie';
    break;  
case 'LOGBOOK':
    $doctype='log';
    break;  
case 'SOFT':
    $doctype='soft';
    break;        
case 'STOR':
    $doctype='storage';
    break;        
  
}
?>
