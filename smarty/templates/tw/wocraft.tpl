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
<tr><th>{t}DBFLD_ID{/t}</th><th>{t}DBFLD_OPDESC{/t}</th><th>{t}DBFLD_CRAFT{/t}</th><th>{t}DBFLD_TEAM{/t}</th><th>{t}DBFLD_WODATE{/t}</th><th>{t}DBFLD_ESTHRS{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=operation from=$operations}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $operation.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$operation.ID}">
    <td align="center">{$operation.OPNUM}</td>
    <td>{$operation.OPDESC}</td>
    <td>{$operation.CRAFT}</td>
    <td align="right">{$operation.TEAM}</td>
    <td align="center">{$operation.OPSCHEDULE}</td>
    <td align="right">{$operation.ESTHRS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$operation.ID}">
<td><input type="text" name="OPNUM"  align="right" size="4" value="{$operation.OPNUM}"></td>
<td><input type="text" name="OPDESC" size="25" value="{$operation.OPDESC}"></td>
<td>{include file="_combobox.tpl" type="LIST"  options=$crafts NAME="CRAFT" SELECTEDITEM=$operation.CRAFT}</td> 
<td><input type="text" name="TEAM" align="right" size="4" value="{$operation.TEAM}"></td>
<td>{include file="_calendar2.tpl" NAME=OPSCHEDULE VALUE=$operation.OPSCHEDULE}</td>   
<td><input type="text" name="ESTHRS" align="right" size="4" value="{$operation.ESTHRS}"></td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td><input type="text" name="OPNUM" align="left" size="4"></td>
    <td><input type="text" name="OPDESC" size="25"></td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$crafts NAME="CRAFT" SELECTEDITEM=""}</td>
    <td><input type="text" name="TEAM" align="right" size="4"></td>
    <td>{include file="_calendar2.tpl" NAME=OPSCHEDULE VALUE=$operation.OPSCHEDULE}</td>   
    <td><input type="text" name="ESTHRS" align="right" size="4"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" alt="INSERT"></a></td></tr>
</form>
</table>
