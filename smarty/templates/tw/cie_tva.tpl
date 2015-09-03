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
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><th colspan="2">{t}TVA Extrait de compte{/t}</td></tr>
<tr><td align="right"><input type="checkbox" name="new">&nbsp;NEW</td>
    <td align="left">{include file="_combobox.tpl" type="NUM"  options=$quarters NAME="YYYYQQ" SELECTEDITEM=$data.YYYYQQ}&nbsp;{t}Quarter{/t}</td></tr>
<tr><td align="right">{t}TVA extrait{/t}</td>
    <td align="left"><B><input type="text" name="type" size="10" value="{$data.type}"</B></td></tr>
<tr><td align="right">{t}TX type{/t}</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$tx_types NAME="type2" SELECTEDITEM=$data.type2} &nbsp;{$data.type2}</td></tr>
<tr><td align="right">{t}TX date{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="txdate" VALUE=$data.txdate}</td></tr>
<tr><td align="right">{t}Comments{/t}</td>
    <td align="left"><textarea name="comment" cols="50" rows="3">{$data.comment}</textarea></td></tr>
<tr><td align="right">{t}TX{/t}&nbsp;<input type="text" name="payment" size="10" style="text-align: right" value="{$data.payment}"></td>    
    <td align="left">&nbsp;&nbsp;<input type="text" name="solde" size="10" style="text-align: right" value="{$data.solde}">&nbsp;{t}TVA solde{/t}</td></tr>    
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</body>
</html>