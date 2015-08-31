<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!-- Start of header section -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>PLAN calendar for myCMMS</title>
<script type="text/javascript" src="../includes/js/prototype.js"></script>
<script type="text/javascript" src="../includes/menu/JSCookMenu.js"></script>
<script type="text/javascript" src="../includes/menu/themes/default/theme.js"></script>
<script type="text/javascript" src="../includes/js/util.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/menu/themes/default/theme.css" />
<link rel="stylesheet" type="text/css" href="../includes/menu/themes/default/basic.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script language="JavaScript" type="text/javascript">
<!-- <![CDATA[
      var myMenu =
[[_cmNoAction,'<td>&nbsp;&nbsp;</td>'],['<img src="../includes/menu/icons/home.png" alt="Home" />','<blink></blink>','view_x.php','',''],
 [_cmNoAction, '<td>&nbsp;&nbsp;</td>'],['<img src="../includes/menu/icons/printer.png" alt="" />','<blink></blink>','view_x.php','',''],
];
//]]> -->
</script>
</head>

<!-- Start of BODY - HEADER1 -->
<body id="year" onload="cmDraw( 'myMenuID', myMenu, 'hbr', cmTheme, 'Theme' ); positionPage();">  
<table width="100%" class="ThemeMenubar" cellspacing="0" cellpadding="0" summary="">
    <td class="ThemeMenubackgr ThemeMenu" align="right">
    <a class="menuhref" title="Logout" href="login.php?action=logout">Logout:</a>&nbsp;<label>{$user}</label>&nbsp;</td>
    </tr>
</table> 
<div style="width:99%;">
<div class="title">
<span class="date">{$thisdate|date_format: "%d-%B (%Y)"}&nbsp;&nbsp;&nbsp; <span class="viewname">{$view_name}</span> &nbsp;&nbsp;&nbsp; {$wkend|date_format: "%d-%B (%Y)"}</span><br />
</div>
</div>                  


<div class="title">
    <a title="Previous" class="prev" href="year.php?year={$prevYear}{$userStr}"><img src="../images/leftarrow.gif" alt="{t}Previous{/t}" /></a>
    <a title="Next" class="next" href="year.php?year={$nextYear}{$userStr}"><img src="../images/rightarrow.gif" alt="{$nextStr}" /></a>
    <span class="date">{$thisYear}</span><br />
    <span class="user">{$user}</span><br />
    </div><br />
<div align="center">
<table id="monthgrid">
{for $col=1 to 3}
    <tr>
    {for $row=1 to 4}
        <td>{$minicals.$col.$row}</td>
    {/for}
    </tr>
{/for}
</table>
</div>
