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
<tr><td align="right">{t}Project Task Description{/t}</td>
    <td><input type="text" name="NAME" size="80" value="{$data.NAME}"}</td></tr>
<tr><td align="right">{t}Project{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$projects NAME="PROJECTS" SELECTEDITEM=$data.PROJECT}</td></tr>
<tr><td colspan="2" align="left"><textarea cols="120" rows="6" name="REMARKS">{$data.REMARKS}</textarea></td></tr>
<tr><td align="right">{t}Status{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$project_states NAME="STATUS" SELECTEDITEM=$data.STATUS}</td></tr>
<tr><td align="right">{t}Started{/t}</td>
    <td>{include file="_calendar2.tpl" NAME="START" VALUE=$data.START}</td></tr>
<tr><td align="right">{t}Finished{/t}</td>
    <td>{include file="_calendar2.tpl" NAME="FINISH" VALUE=$data.FINISH}</td></tr>    
<tr><td colspan="2"><input type="submit" class="submit" value="{t}Save & Close{/t}" name="close"></td></tr>
</table>
</form>
