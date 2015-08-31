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

<table width="600">
<tr><th>{t}DBFLD_VENDORID{/t}</th><th>{t}DBFLD_NAME{/t}</th><th>{t}DBFLD_UNITCOST{/t}</th><th>{t}DBFLD_UOP{/t}</th><th>{t}OEM Reference{/t}</th><th>{t}DBFLD_PRIMARYVENDOR{/t}</th></tr>
{foreach from=$vendors item=vendor}
<tr><td class="LABEL">{$vendor.VENDORID}</td>
    <td>{$vendor.NAME}</td>
    <td align="right">{$vendor.UNITCOST}</td>
    <td>{$vendor.UOP}</td>
    <td>{$vendor.MANUFACTID}</td>
    <td>{$vendor.PRIMARYVENDOR}</td></tr>
{/foreach}
</table>

<hr>

<table width="600">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYONHAND{/t}</th><th>{t}Stock Value{/t}</th></tr>
{foreach from=$stock item=stock_item}
<tr><td class="LABEL">{$stock_item.ITEMNUM}</td><td>{$stock_item.DESCRIPTION}</td><td>{$stock_item.LOCATION}</td><td>{$stock_item.QTYONHAND}</td><td>{$stock_item.STOCKVALUE}</td></tr>
{/foreach}
</table>

<hr>

<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ITEMNUM}">
<input type="hidden" name="VENDOR_OLD" value="{$data.VENDORID}">
<table width="600">
<tr><th>{t}Vendor Selection{/t}</th>
    <td align="center">{include file="_combobox.tpl" type="LIST"  options=$vendorlist NAME="VENDORID" SELECTEDITEM=$data.VENDORID}</td></tr>
<tr><th align="right">{t}Manufacturing Reference{/t}</th>
    <th align="left">{t}OEM Reference{/t}</th></tr>
<tr><td class="LABEL"><B>{$data.OEMMFG}</b></td>
    <td align="left"><input type="text" name="MANUFACTID" size="50" value="{$data.MANUFACTID}"></td></tr>
<tr><td class="LABEL">{t}Unit cost{/t}</td>
    <td><input type="text" name="UNITCOST" size="8" value="{$data.UNITCOST}"></td></tr>
<tr><td class="LABEL">{t}Unit Quantity{/t}</td>
    <td><input type="text" name="UNITQTY" size="8" value="{$data.UNITQTY}"></td></tr>
<tr><td class="LABEL">{t}Unit of Purchase{/t}</td>
    <td><input type="text" name="UOP" size="8" value="{$data.UOP}"></td></tr>
<tr><td class="LABEL">{t}Min.order quantity{/t}</td>
    <td><input type="text" name="MINORDERQTY" size="8" value="{$data.MINORDERQTY}"></td></tr>
{foreach from=$suppliers item=supplier}    
{if $supplier.VENDORID eq $data.VENDORID}
<tr><td class="LABEL"><input type="radio" name="vendorswitch" value="{$supplier.VENDORID}" checked>
{else}
<tr><td class="LABEL"><input type="radio" name="vendorswitch" value="{$supplier.VENDORID}">
{/if}
    &nbsp<b>{$supplier.VENDORID}</b></td>
    <td>{t}UnitCost{/t}&nbsp:&nbsp{$supplier.UNITCOST}&nbsp({t}His Reference{/t}&nbsp;{$supplier.MANUFACTID})</td></tr>    
{/foreach}

<tr><td>
    <input type="submit" class="submit" value="{t}Change{/t}" name="form_save"></td></tr>
</table>
</form>
</body>
</html>


