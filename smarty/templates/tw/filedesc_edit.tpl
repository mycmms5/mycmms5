<html>
<head>
<title>{t}New Spare Part definition{/t}</title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<h1>{t}Change File description{/t}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="filename_old" value="{$data.filename}">
<input type="hidden" name="filedescription_old" value="{$data.filedescription}">
<table width="600">
<tr><td align="right">{t}Existing Filename{/t}</td>
    <td>{$data.filename}</td></tr>
<tr><td align="right">{t}Existing Filename{/t}</td>
    <td><input type="text" name="filename_new" size="70" value="{$data.filename}"></td></tr>
<tr><td align="right">{t}Description{/t}</td>
    <td><textarea name="filedescription_new" cols="70" rows="10">{$data.filedescription}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="close">
</table>
</form>

