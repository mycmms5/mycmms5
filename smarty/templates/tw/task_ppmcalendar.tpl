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
<h1>{t}Planned Dates for{/t}&nbsp;{$tasks.0.TASKNUM}&nbsp;{t}on equipment{/t}&nbsp;{$tasks.0.EQNUM}</h1>
<table width="600">
<tr><th>{t}DBFLD_PLANDATE{/t}</th><th>{t}DBFLD_WONUM{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=task from=$tasks}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $task.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$task.ID}">
    <td align="center">{$task.PLANDATE}</td>
    <td>
{if $task.WONUM eq ""}
    {$task.TASKNUM}&nbsp;{t}has not been launched yet!{/t}
{else}
    {$task.WONUM}
{/if}
</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$task.ID}">
    <td>{include file="_calendar2.tpl" NAME="PLANDATE" VALUE=$task.PLANDATE}</td>
    <td>{t}PPMCalendar: the WO will be shown here when it was launched{/t}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td align="center">{include file="_calendar2.tpl" NAME="PLANDATE" VALUE=""}</td>
    <td align="center">-</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" alt="INSERT"></a></td></tr>
</form>
</table>
</body>
</html>