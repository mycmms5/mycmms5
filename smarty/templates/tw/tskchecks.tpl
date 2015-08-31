<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}Indicator{/t}</th><th>{t}Type{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Label{/t}</th><th>{t}Long Text{/t}</th><th>{t}DBFLD_action{/t}</th></tr>
{foreach item=check from=$checks}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $check.INDICATOR}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$check.INDICATOR}">
    <td>{$check.INDICATOR}</td>
    <td>{$check.TYPE}</td>
    <td>{$check.EQNUM}</td>
    <td>{$check.LABEL}</td>
    <td>{$check.INSTRUCTIONS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr  bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$check.INDICATOR}">
    <td>{$check.INDICATOR}</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$indicator_types NAME="TYPE" SELECTEDITEM=$check.TYPE}</td>
    <td><input type="text" name="EQNUM" value="{$check.EQNUM}"></td>
    <td colspan="2"><input type="text" name="LABEL" size="50" value="{$check.LABEL}"><BR>
        <textarea name="INSTRUCTIONS" cols="50" rows="5">{$check.INSTRUCTIONS}</textarea></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
    <td><input type="text" name="INDICATOR" value=""></td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$indicator_types NAME="TYPE" SELECTEDITEM=""}</td>
    <td><input type="text" name="EQNUM" value=""></td>
    <td colspan="2"><input type="text" name="LABEL" size="50" value=""><BR>
        <textarea name="INSTRUCTIONS" cols="50" rows="5"></textarea></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>