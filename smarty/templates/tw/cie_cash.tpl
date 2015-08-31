<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include "_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><th colspan="2">{t}Cash Register Information{/t}</td></tr>
<tr><td align="right">{t}Firm / Supplier{/t}</td>
    <td align="left"><B><input type="text" name="FIRM" size="30" value="{$data.FIRM}"</B>&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Quarter{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="NUM"  options=$quarters NAME="QUARTER" SELECTEDITEM=$data.QUARTER}</td></tr>
<tr><td align="right">{t}Transaction{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="TDATE" VALUE=$data.TDATE}</td></tr>    
<tr><td align="right">{t}Comments{/t}</td>
    <td align="left"><textarea name="COMMENT" cols="50" rows="3">{$data.COMMENT}</textarea></td></tr>
<tr><td align="right">{t}Type{/t}</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$tx_types NAME="TYPE" SELECTEDITEM=$data.TYPE}</br>
        {include file="_combobox.tpl" type="LIST"  options=$genledgers NAME="GENLEDGER" SELECTEDITEM=$data.GENLEDGER}</td></td></tr> 
       
<tr><td align="right">{t}Expenses{/t}</td>
    <td align="left"><input type="text" name="EXPENSES" size="10" style="text-align: right" value="{$data.EXPENSES}"></td></tr>    
<tr><td align="right">{t}Revenues{/t}</td>
    <td align="left"><input type="text" name="REVENUES" size="10" style="text-align: right" value="{$data.REVENUES}">
{if $data.TYPE eq 'Facture'}    
     {include file="_calendar.tpl" NAME="PDATE" VALUE=$data.PDATE}
{/if}</td></tr>    
<tr><td align="right">{t}VAT{/t} / {t}VAT Rate{/t}</td>
    <td align="left"><input type="text" name="VAT" size="10" style="text-align: right" value="{$data.VAT}"></td></tr>    
<tr><td align="right">{t}Origin{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="NUM"  options=$origins NAME="ORIGIN" SELECTEDITEM=$data.ORIGIN}</td></tr>
<tr><td align="right"><b>{t}CBC PRO account{/t}</b></td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$cbc NAME="TXID" SELECTEDITEM=$data.TXID}</td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</body>
</html>