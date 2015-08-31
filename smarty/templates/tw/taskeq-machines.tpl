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
<tr><th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_NUMOFDATE{/t}</th>
    <th>{t}DBFLD_LASTPERFDATE{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach item=data from=$taskeq}
<tr  bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $data.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$data.ID}">
<td>{$data.EQNUM}:{$data.DESCRIPTION}</td><td>{$data.SCHEDTYPE}</td><td>{$data.LASTPERFDATE}</td><td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr  bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="treeform" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$data.ID}">
<td><input type="text" name="EQNUM" size="25" value="{$data.EQNUM}"><a href="javascript://" onClick="treewindow_2('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Change{/t}</a><br><input type="text" name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td>
<td><input type="text" name="SCHEDTYPE" size="10" value="{$data.SCHEDTYPE}"></td>
<td>{include file="_calendar2.tpl" NAME="LASTPERFDATE" VALUE=$data.LASTPERFDATE}</td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="withtree" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr  bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td><input type="text" name="EQNUM" size="25"><a href="javascript://" onClick="treewindow_2('../actions/tree2/index.php?tree=EQUIP3','EQNUM')">{t}Add{/t}</a><br><input type="text" name="DESCRIPTION" size="35"></td>
<td>{include file="_combobox.tpl" type="NUM"  NAME="SCHEDTYPE" options=$schedtypes SELECTEDITEM="F"}</td>
<td>{include file="_calendar2.tpl" NAME="LASTPERFDATE" VALUE=""}</td> 
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>
{* End of SMARTY*}
