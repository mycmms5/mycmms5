<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
document.treeform.ITEMNUM.style.background='lightblue'; 
document.treeform.ITEMNUM.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="800">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_QTYUSED{/t}</th></tr>
{foreach item=part from=$parts}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$part.ITEMNUM}</td><td>{$part.DESCRIPTION}</td><td>{$part.QTYUSED}</td>
{/foreach}
</table>
<hr>
<table width="800">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$parts.WONUM}">
<tr><td>{t}BARCODE spare part{/t}</td><td><input type="text" name="ITEMNUM" size="10"></td></tr>
<tr><td>{t}Quantity{/t}</td><td><input type="text" name="QTYUSED" size="5" value="0"></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}"   name="form_save"></td></tr>
</table>
</body>
</html>