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
<tr><th colspan="2">Recipe {$data.Recipe}#{$data.ID}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right">Recipe</td>
    <td><input type="text" name="Recipe" size="50" value="{$data.Recipe}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="Right">Ingredients</td>
    <td><textarea name="Ingredients" cols="100" rows="12">{$data.Ingredients}</textarea></td></tr>
<tr><td align="Right">Preparation</td>
    <td><textarea name="Preparation" cols="100" rows="15">{$data.Preparation}</textarea></td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
