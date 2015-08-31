<html>
<head>
<title>{t}New DOCUMENT description{/t}</title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<h1>{t}New DOCUMENT description{/t}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="FILENAME_OLD" value="{$data.FILENAME}">
<table width="700">
<tr><td class="LABEL">{t}Existing Filename{/t}</td>
    <td>{$data.filename}</td></tr>
<tr><td class="LABEL">{t}Existing Filename{/t}</td>
    <td><input type="text" name="FILENAME_NEW" size="50" value="{$data.filename}"></td></tr>
<tr><td class="LABEL">{t}Description{/t}</td>
    <td><textarea name="FILEDESCRIPTION" cols="50" rows="10">{$data.filedescription}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save then Close{/t}" name="close">
</table>
</form>

