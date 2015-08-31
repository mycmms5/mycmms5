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
<table width="700" align="center">
<tr><th colspan="2">Brol {$data.Objekt}#{$data.ID}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="manuals">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right">Object</td>
    <td><input type="text" name="Brand" size="40" value="{$data.Brand}"/>&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="Right">Content</td>
    <td><textarea name="Content" cols="80" rows="4">{$data.Content}</textarea></td></tr>
<tr><td align="Right">Location</td>
    <td><input type="text" name="Location" size="25" value="{$data.Location}"></td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
