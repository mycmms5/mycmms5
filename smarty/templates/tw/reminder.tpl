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
<table width="800">
<tr><td align="right">{t}ID{/t}</td>
    <td><input type="text" name="ID" size="5" value="{$data.ID}"}</td></tr>
<tr><td align="right">{t}Responsible{/t}</td>
    <td><input type="text" name="RESPONSIBLE" value="{$data.RESPONSIBLE}"></td></tr>
<tr><td align="right">{t}DBFLD_PRIORITY{/t}</td>
    <td><input type="text" name="PRIORITY" value="{$data.PRIORITY}"></td></tr>
<tr><td align="right">{t}Demander{/t}</td>
    <td><input type="text" name="MAILFROM" value="{$data.MAILFROM}"></td></tr>
<tr><td colspan="2" align="left"><textarea cols="120" rows="6" name="SUBJECT">{$data.SUBJECT}</textarea></td></tr>
<tr><td align="right">{t}DeadLine{/t}</td>
    <td>{include file="_calendar2.tpl" NAME="DEADLINE" VALUE=$data.DEADLINE}</td></tr>
<tr><td align="right">{t}Closed{/t} (2020=open)</td>
    <td>{include file="_calendar2.tpl" NAME="CLOSED" VALUE=$data.CLOSED}</td></tr>

<tr><td colspan="2"><input type="submit" class="submit" value="{t}Save & Close{/t}" name="close"></td></tr>
</table>
</form>
