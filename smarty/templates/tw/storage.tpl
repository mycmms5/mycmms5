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
<tr><th colspan="2">Storage {$data.brand}#{$data.ID}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right" class="SPEC_{$data.category}">Category</td></td>
    <td><input type="text" name="category" size="15" value="{$data.category}"></td></tr>
<tr><td align="Right">Brand</td></td>
    <td><input type="text" name="brand" size="50" value="{$data.brand}">&nbsp;<input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="Right">Object</td>
    <td><textarea name="object" cols="80" rows="4">{$data.object}</textarea></td></tr>
<tr><td align="Right">Storage</td>
    <td><input type="text" name="storage" size="50" value="{$data.storage}"></td></tr>
<tr><td align="Right">YEAR in storage</td>
    <td><input type="text" name="yyyy" size="6" value="{$data.yyyy}"></td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
