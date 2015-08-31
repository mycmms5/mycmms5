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
<table width="600">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYONHAND{/t}</th><th>{t}DBFLD_STOCKITEM{/t}</th></tr>
{foreach from=$stock item=stock_item}
<tr><td>{$stock_item.ITEMNUM}</td><td>{$stock_item.DESCRIPTION}</td><td>{$stock_item.LOCATION}</td><td>{$stock_item.QTYONHAND}</td><td>{$stock_item.STOCKITEM}</td></tr>
{/foreach}
</table>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ITEMNUM}">
<input type="hidden" name="LOCATION_OLD" value="{$data.LOCATION}">
<table width="600">
<tr><td class="LABEL">{t}Stock Location{/t}</td>
    <td><input type="text" name="LOCATION" size="10" value="{$data.LOCATION}"></td></tr>
<tr><td class="LABEL">{t}Stock Item{/t}&nbsp<input type="text" name="STOCKITEM" size="5" value="{$data.STOCKITEM}"></td>
    <td><input type="text" name="ABCCLASS" size="5" value="{$data.ABCCLASS}">&nbsp{t}ABC Class{/t}</td></tr>
<tr><td class="LABEL">{t}ReOrder Point{/t}&nbsp<input type="text" name="REORDERPOINT" size="5" value="{$data.REORDERPOINT}"></td>
    <td><input type="text" name="REORDERQTY" size="5" value="{$data.REORDERQTY}">&nbsp{t}ReOrder Quantity{/t}</td></tr>
<tr><td class="LABEL">{t}Minimum Stock Level{/t}&nbsp<input type="text" name="MINSTOCKLEVEL" size="5" value="{$data.MINSTOCKLEVEL}"></td>
    <td><input type="text" name="REORDERMETHOD" size="5" value="{$data.REORDERMETHOD}">&nbsp{t}ReOrder Method{/t}</td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
</table>
</form>

