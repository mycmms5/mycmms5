<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>{$BOM}</h1>
<table width="800">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}MAPICS{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_QTY{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=part from=$bom_parts}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $part.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$part.ID}">
<input type="hidden" name="SPARECODE" value="{$part.SPARECODE}">
    <td>{$part.ITEMNUM}</td>
    <td>{$part.MAPICS}</td>
    <td>{$part.DESCRIPTION}</td>
    <td>{$part.QTY}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$part.ID}">
<input type="hidden" name="SPARECODE" value="{$BOM}">
    <td>{$part.ITEMNUM}</td>
    <td>{$part.MAPICS}</td>
    <td>{$part.DESCRIPTION}</td>
    <td><input type="text" name="QTY" align="right" size="5" value="{$part.QTY}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="BOM" value="{$BOM}">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<td><input type="text" name="ITEMNUM" align="left" size="10"></td>
<td>-</td>
<td>-</td>
<td><input type="text" name="QTY" align="right" size="5"></td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>