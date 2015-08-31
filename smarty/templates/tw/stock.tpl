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
<h1>{t}New Spare Part definition{/t}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="new">
<table width="600">
<tr><td align="right">{t}Item description{/t}</td>
    <td><input type="text" name="DESCRIPTION" size="70" value="{$data.DESCRIPTION}"></td></tr>
<tr><td align="right">{t}Part Notes{/t}</td>
    <td><textarea name="NOTES" cols="70" rows="10">{$data.NOTES}</textarea></td></tr>
<tr><td colspan="2">{t}Inventory Type{/t}</td></tr>
<tr><td>{include file="_combobox.tpl" type="LIST"  options=$inventory_types NAME="TYPE" SELECTEDITEM=""}</td>
    <td><input type="text" name="TYPE_DESC" size="50" value=""></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="close">
</table>
</form>

