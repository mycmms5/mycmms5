<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.WONUM}">
<input type="hidden" name="id2" value="{$data.EQNUM}">
<input type="hidden" name="ORIGINATOR" value="{$data.ORIGINATOR}">
<input type="hidden" name="REQUESTDATE" value="{$data.REQUESTDATE}">
<input type="hidden" name="TASKDESC" value="{$data.TASKDESC}">
<table width="600">
<tr><td align="right">{t}DBFLD_ORIGINATOR{/t}</td><td align="center"><b>{$data.ORIGINATOR}</b></td></tr>
<tr><td align="right">{t}Task Description{/t}</td>
    <td align="right"><input type="text" name="TASKDESC" size="70" value="{$data.TASKDESC}"></td></tr>
<tr><td align="right">{t}DBFLD_APPROVEDBY{/t}</td>
    <td align="center"><b>{$smarty.session.user}</b></td></tr>
<tr><td align="right">{t}DBFLD_REJECTDATE{/t}</td>
    <td align="center"><b>{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</b></td></tr>
<tr><td align="right">{t}DBFLD_REASON{/t}</td>
    <td><textarea name="REASON" cols="50" rows="3"></textarea></td></tr>            
<tr><td colspan="2">    
    <input type="submit" value="{t}Refuse & Close{/t}" name="close"></td></tr>
</table>
</form>

