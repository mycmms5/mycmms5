<?php
/**
* @author Werner Huysmans
* @version 1.0
* @package webcalendar
* @subpackage standard
* @filesource
* CVS
* $Id: index.php,v 1.3 2013/08/19 13:29:20 werner Exp $
* $Source: /var/www/cvs/mycmms_wc/myCMMS_WC/index.php,v $
* $Log: index.php,v $
* Revision 1.3  2013/08/19 13:29:20  werner
* Date is retrieved from Session
*
*/
session_start();
if (empty($_SESSION['webcal_login'])) {
    $_SESSION['webcal_login']='admin';
    $_SESSION['STARTVIEW']="view_mycmms.php";
}
header("location: plan_mycmms.php?date={$_COOKIE['DAY']}");
?>
