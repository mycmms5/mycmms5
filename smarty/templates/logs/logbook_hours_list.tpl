<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table border="0px">
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_WODATE{/t}</th><th>{t}DBFLD_EMPCODE{/t}</th><th>{t}DBFLD_REGHRS{/t}</th></tr>
{foreach item=woe from=$woes}
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td><a href="../workorders/wo_print.php?id1={$woe.DBFLD_WONUM}" target="new">{$woe.DBFLD_WONUM}</a></td>
    <td>{$woe.DBFLD_EQNUM}</td>
    <td>{$woe.DBFLD_TASKDESC}</td>
    <td>{$woe.DBFLD_WODATE}</td>
    <td>{$woe.DBFLD_EMPCODE}</td>
    <td>{$woe.DBFLD_REGHRS}</td></tr>
{foreachelse}
<tr><td colspan="2">No Items to list</td></tr>        
{/foreach}
</table>
</body>
</html>