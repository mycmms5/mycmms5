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
<h1>CD Magazine #{$data.ID}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="id1" value="{$data.ID}">
<table width="800">
<tr><td align="right">{t}Date{/t}</td>
    <td align="left"><input type="text" name="Date" size="10" value="{$data.Date}"</B></td></tr>
<tr><td align="right">{t}Magazine{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$magazines NAME="Magazine" SELECTEDITEM=$data.Magazine}
    &nbsp;<input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Content{/t}</td>
    <td align="left"><textarea cols="60" rows="7" name="Comment">{$data.Comment}</textarea></td></tr>
<tr><td align="right">{t}Location{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$locations NAME="Box" SELECTEDITEM=$data.Box}&nbsp;
    <input type="text" name="Classification" value="{$data.Classification}">&nbsp;({$latest_location})</td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</body>
</html>