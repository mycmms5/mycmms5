<html>
<head>
<title>Export Query to EXCEL#query_name</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;" />
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
    <td>{$cell.ORIGINATOR}</td>
    <td>{$cell.PROJET}<br><b>{$cell.WOTYPE}-{$cell.REPORT_AX}</b><br>{$cell.AX}<br>{$cell.ASSIGNEDTECH}</td>
    <td><b>{$cell.TASKDESC}</b><br>
        {$cell.TEXTS_B|nl2br}</td>
    <td>{$cell.SCHEDSTARTDATE}<br><i>{$cell.AX_DATE}</i></td>
    <td>{$cell.EQ_AX}</td>
    <td></td>
</tr>
    
{/foreach}
</table>

{include file="_wikilink.tpl" WIKIPage=$wikipage}
</body>
</html>
