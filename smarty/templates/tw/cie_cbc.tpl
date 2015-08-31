<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><th colspan="2">{t}CBC PRO Register{/t}</td></tr>
<tr><td align="right">{t}TX date{/t}</td>
    <td align="left">{include file="_calendar.tpl" NAME="TXDATE" VALUE=$data.TXDATE}&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Amount{/t}</td>
    <td align="left"><input name="AMOUNT" type="text" size="8" value="{$data.AMOUNT}"></td></tr>
<tr><td align="right">{t}Transaction{/t}</td>
    <td align="left"><textarea name="TX" cols="50" rows="3">{$data.TX}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
</body>
</html>