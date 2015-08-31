<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table border="0px">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th>
    <th>{t}DBFLD_DESCRIPTION{/t}<BR>{t}DBFLD_NOTES{/t}</th>
    <th>{t}DBFLD_LOCATION{/t}</th>
    <th>{t}DBFLD_QTYONHAND{/t}</th></tr>
{foreach item=spare from=$spares}
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td><a href="../warehouse/stock_print.php?id1={$spare.ITEMNUM}" target="new">{$spare.ITEMNUM}</a></td>
    <td>{$spare.DESCRIPTION}<BR>{$spare.NOTES|nl2br}</td>
    <td>{$spare.LOCATION}</td>
    <td>{$spare.QTYONHAND}</td></tr>
{foreachelse}
<tr><td colspan="3">No Items to list</td></tr>        
{/foreach}
</table>
{if $with_wo}
<hr>
<table border="0px">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_QTYREQD{/t}</th><th>{t}DBFLD_QTYUSED{/t}</th></tr>
{foreach item=wo from=$wos}
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td>{$wo.ITEMNUM}</td>
    <td><a href="../workorders/wo_print.php?id1={$wo.WONUM}" target="new">{$wo.WONUM}</a></td></td>
    <td>{$wo.EQNUM}</td>
    <td>{$wo.TASKDESC}</td>
    <td>{$wo.REQUESTDATE}</td>
    <td>{$wo.QTYREQD}</td>
    <td>{$wo.QTYUSED}</td>
</tr>
{/foreach}
</table>
{/if}

{if $smarty.session.PDO_ERROR neq null}
<div class="error">{t}{$smarty.session.PDO_ERROR}{/t}</div>
{/if}
</body>
</html>