<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_QTYREQD{/t}</th><th>{t}DBFLD_DATEUSED{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=part from=$parts}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $part.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$part.ID}">
<td>{$part.ITEMNUM}</td><td>{$part.DESCRIPTION}</td><td>{$part.QTYREQD}</td><td>{$part.DATEUSED}</td><td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$part.ID}">
<td>{$part.ITEMNUM}</td>
<td>{$part.DESCRIPTION}</td>
<td><input type="text" name="QTYREQD" align="right" size="5" value="{$part.QTYREQD}"></td>
<td>{$part.DATEUSED}</td> 
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<td><input type="text" name="ITEMNUM" align="left" size="10"></td>
<td>...</td>
<td><input type="text" name="QTYREQD" align="right" size="5"></td>
<td>{$part.DATEUSED}</td>   
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>