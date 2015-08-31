<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
function gotoInsert() {
document.INSERT.VENDORID.style.background='lightblue'; 
document.INSERT.VENDORID.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus(); gotoInsert();">
<table width="800">
<tr><th>ID</th><th>Vendor</th><th>Description/Notes</th><th>Qty</th><th>UC</th><th>LC</th><th>Action</th></tr>
{foreach item=purchase from=$purchases}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $purchase.SEQNUM}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$purchase.SEQNUM}">
    <td style="text-align: center;">{$purchase.SEQNUM}</td>
    <td style="text-align: center;">{$purchase.VENDORID}</td>
    <td style="text-align: center;">{$purchase.DESCRIPTIONONPO}<br />{$purchase.NOTES}</td>
    <td align="right">{$purchase.QTYRECEIVED}</td>
    <td align="right">{$purchase.UNITCOST}</td>
    <td align="right">{$purchase.LINECOST}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$purchase.SEQNUM}">
<td>{$purchase.SEQNUM}</td>
<td><input type="text" name="VENDORID" size="10" value="{$purchase.VENDORID}" style="text-align: center;"></td>
<td><input type="text" name="DESCRIPTIONONPO" size="40" value="{$purchase.DESCRIPTIONONPO}" style="text-align: left;">
    <input type="text" name="NOTES" size="40" value="{$purchase.NOTES}" style="text-align: left;"></td>
<td><input type="text" name="QTYRECEIVED" size="10" value="{$purchase.QTYRECEIVED}"></td>
<td><input type="text" name="UNITCOST" size="10" value="{$purchase.UNITCOST}"></td>
<td>CALCULATED</td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
    <td>NEW</td>
    <td><input type="text" name="VENDORID" size="10"></td>
    <td><input type="text" name="DESCRIPTIONONPO" size="40" value=""><br />
        <input type="text" name="NOTES" size="40" value=""></td>
    <td><input type="text" name="QTYRECEIVED" size="5" value=""></td>
    <td><input type="text" name="UNITCOST" size="10"></td>
    <td>CALCULATED</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>