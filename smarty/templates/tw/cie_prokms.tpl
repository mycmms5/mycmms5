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
<tr><th colspan="2">{t}myCMMS kms register{/t}</td></tr>
<tr><td align="right">{t}Firm / Supplier{/t}</td>
    <td align="left"><B><input type="text" name="FIRM" size="30" value="{$data.FIRM}"</B>&nbsp;<input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Transaction{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="TDATE" VALUE=$data.TDATE}</td></tr>    
<tr><td align="right">{t}Reason{/t}</td>
    <td>{include file="_combobox.tpl" type="NUM"  options=$reasons NAME="REASON" SELECTEDITEM=$data.REASON}</td></tr>    
<tr><th align="center" colspan="2">{t}Start - End = Distance{/t}</th></tr>
<tr><td align="right"><input type="text" size="7" name="START" value="{$data.START}">&nbsp;<input type="text" size="7" name="END" value="{$data.END}"></td>
    <td align="left">&nbsp;=&nbsp;<input type="text" size="7" name="DISTANCE" value="{$data.DISTANCE}"></td></tr>
<tr><td>{t}Cost{/t}</td><td><input type="text" name="COST" value="{$data.COST}"></td></tr>
<tr><td>{t}Declared Cost{/t}</td><td>{$data.DCOST}</td></tr>    
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</body>
</html>