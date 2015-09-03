<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="700" align="center">
<tr><th colspan="2">Purchase {$data.ID} at {$data.Shop} on {$data.PurchaseDate}</th></tr>
<form action="{$SCRIPT_NAME}" method="post" class="form" name="guarantee">
<input type="hidden" name="id1" value="{$ID}">
<tr><td align="Right">Purchase date</td>
    <td>{include file="_calendar2.tpl" NAME="PurchaseDate" VALUE=$data.PurchaseDate}<BR>
        {include file="_calendar2.tpl" NAME="EndDate" VALUE=$data.EndDate}</td></tr>
<tr><td align="right">SHOP</td>
    <td><input type="text" name="Shop" size="20" value="{$data.Shop}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">Item</td>
    <td><input type="text" name="Item" size="55" value="{$data.Item}"></td></tr>
<tr><td colspan="2"><textarea name="Manual" cols="80" rows="3">{$data.Manual}</textarea></td></tr>    
<tr><td align="right">Price</td>
    <td><input type="text" name="Price" size="8" value="{$data.Price}"></td></tr>
<tr><td align="right">Type</td>
    <td><input type="text" name="Type" size="8" value="{$data.Type}"></td></tr>
<tr><td colspan="2">
        <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
        <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</html>
