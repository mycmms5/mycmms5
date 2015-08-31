<html>
<head>
<title>Export Query to EXCEL#query_name</title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
window.focus();}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<p>Size of WORKSHEET: {$HCOL} x {$HROW}</p>

<table>
{foreach item=cell from=$TEST}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$cell.MAPICS}</td>
    <td>{$cell.WAREHOUSEID}</td>
    <td>{$cell.QTYONHAND}</td>
</tr>
    
{/foreach}
</table>

{include file="_wikilink.tpl" WIKIPage=$wikipage}
</body>
</html>
