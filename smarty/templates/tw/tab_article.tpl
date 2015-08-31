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
<h1>Article #&nbsp;{$data.InfoID}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="id1" value="{$data.InfoID}">
<table width="800">
<tr><td align="right">Date Article</td>
    <td align="left">{include file="_calendar.tpl" NAME="DateID" VALUE=$data.DateID}</td></tr>
<tr><td align="right">Theme</td>
    <td align="left"><input type="text" name="Theme" value="{$data.Theme}">
    &nbsp;<input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">Information</td>
    <td align="left"><textarea cols="80" rows="7" name="Information">{$data.Information}</textarea></td></tr>
<tr><td align="right">Keep / # Pages</td>
    <td align="left"><input type="text" name="Keep" size="8" value="{$data.Keep}">&nbsp;
    <input type="text" name="Page" size="2" value="{$data.Page}"></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</body>
</html>