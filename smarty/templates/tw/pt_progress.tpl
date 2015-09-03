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
<tr><th>{t}DBFLD_ASSIGNEDTECH{/t}</th><th>{t}Report{/t}</th><th>{t}Report Date{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=report from=$reports}
<tr>
{if $actual_id ne $report.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$report.ID}">
    <td>{$report.ASSIGNEDTECH}</td>
    <td>{$report.REPORT}</td>
    <td>{$report.REPORTDATE}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr>
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$report.ID}">
<td><input type="text" name="ASSIGNEDTECH"  align="right" size="10" value="{$report.ASSIGNEDTECH}"></td>
    <td><textarea cols="60" rows="4" name="REPORT">{$report.REPORT}</textarea></td>
    <td>{include file="_calendar2.tpl" NAME="REPORTDATE" VALUE=$report.REPORTDATE}</td>   
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr><td><input type="text" name="ASSIGNEDTECH" align="left" size="10" value=""></td>
    <td><textarea cols="60" rows="4" name="REPORT"></textarea></td>
    <td>{include file="_calendar2.tpl" NAME="REPORTDATE" VALUE=$report.REPORTDATE}</td>   
 <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>