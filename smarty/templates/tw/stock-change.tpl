<html>
<head>
<title></title>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ITEMNUM}">
<input type="hidden" name="QTYONHAND_OLD" value="{$data.QTYONHAND}">
<table>
<tr><td align="right"><b>{t}Stock Location{/t}</b></td>
    <td align="left">{$data.LOCATION}</td></tr>
<tr><td align="right">{t}Quantity On Hand{/t}</td>
    <td><input type="text" name="QTYONHAND" size="5" value="{$data.QTYONHAND}"></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Change{/t}"   name="form_save"></td></tr>
</table>
</form>
</body>
</html>


