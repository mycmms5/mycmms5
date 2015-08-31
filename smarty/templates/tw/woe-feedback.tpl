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
<tr><th>{t}DBFLD_longname{/t}</th><th>{t}DBFLD_WODATE{/t}</th><th>{t}DBFLD_ESTHRS{/t}</th><th>{t}DBFLD_REGHRS{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=workedhour from=$workedhours}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>
{if $actual_id ne $workedhour.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$workedhour.ID}">
        {$workedhour.longname}</td>
    <td>{$workedhour.WODATE}</td>
    <td>{$workedhour.ESTHRS}</td>
    <td>{$workedhour.REGHRS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$workedhour.ID}">
    <td>{include file="_combobox.tpl" type="LIST"  options=$names NAME="EMPCODE" SELECTEDITEM=$workedhour.EMPCODE}</td> 
    <td>{include file="_calendar2.tpl" NAME="WODATE" VALUE=$workedhour.WODATE}</td>
    <td>{$workedhour.ESTHRS}</td>
    <td><input type="text" name="REGHRS" size="5" value="{$workedhour.REGHRS}"></td>
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
    <td>{include file="_combobox.tpl" type="LIST"  options=$names2 NAME="EMPCODE" SELECTEDITEM=$smarty.session.user}</td> 
    <td>{include file="_calendar2.tpl" NAME="WODATE" VALUE=$smarty.now|date_format:"%Y-%m-%d %H:%M"}</td>
    <td>{$operation.ESTHRS}</td>
    <td><input type="text" name="REGHRS" size="5"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
<div class="CVS">{$version}</div>
</body>
</html>