<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">

<table width="800">
<tr><th>{t}Source{/t}</th>
    <th>{t}Action{/t}</th>
    <th>{t}Destination{/t}</th></tr>
<form method="post" class="form" action="{$SCRIPT_NAME}">
<input type="hidden" name="ACTION" value="TASK2WO">
<input type="hidden" name="WONUM" value="{$data.WONUM}">
<tr><td><b>{t}LBLFLD_TASKNUM{/t}</b>&nbsp;({t}TASK must exist{/t}){include file="_combobox.tpl" type="LIST"  NAME="TASKNUM" options=$tasks}</td>
    <td><input type="submit" class="submit" value="{t}Copy TASK to WO{/t}" name="form_save"></td>
    <td>{$data.WONUM}</br>
        {$data.TASKDESC}</br>
        {$data.EQNUM}</td></tr>
</form>

<tr><td colspan="3"></td></tr>
<form method="post" class="form" action="{$SCRIPT_NAME}">
<input type="hidden" name="ACTION" value="WO2TASK">
<input type="hidden" name="WONUM" value="{$data.WONUM}">
<input type="hidden" name="TASKDESC" value="{$data.TASKDESC}">
<input type="hidden" name="EQNUM" value="{$data.EQNUM}">
<tr><td>{$data.WONUM}</br>
        {$data.TASKDESC}</br>
        {$data.EQNUM}</td>
    <td><input type="submit" class="submit" value="{t}Copy WO to TASK{/t}" name="form_save"></td>
    <td><b>{t}LBLFLD_TASKNUM{/t}</b>&nbsp;({t}TASK does not exist{/t})<input type="text" size="50" name="TASKNUM"></td></tr>
</form>

<tr><td colspan="3"></td></tr>
<form method="post" class="form" action="{$SCRIPT_NAME}">
<input type="hidden" name="ACTION" value="WO2WO">
<input type="hidden" name="WONUM" value="{$data.WONUM}">
<input type="hidden" name="TASKDESC" value="{$data.TASKDESC}">
<input type="hidden" name="EQNUM" value="{$data.EQNUM}">
<tr><td>{$data.WONUM}</br>
        {$data.TASKDESC}</br>
        {$data.EQNUM}</td>
    <td><input type="submit" class="submit" value="{t}Copy WO to WO{/t}" name="form_save"></td>
    <td><b>{t}LBLFLD_WONUM{/t}</b>&nbsp;<input type="checkbox" name="NEWWO">&nbsp;{t}Create NEW wo{/t}
        </br><input type="text" size="50" name="WONUM_NEW"></td></tr>
</form>
</table>
