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
</head>
<body onload="setFocus()">
<table width="700" align="center">
<form name="treeform" action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="id1" value="{$data.RecordingID}"> 
<tr><th colspan="2">{t}New/Edit Music Record{/t}</td></tr>
<tr><td align="Right" VALIGN="Top">{t}Artist or Composer{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$composers NAME="Artist" SELECTEDITEM=$data.Artist}&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td align="right">{t}Record title{/t}</td>
    <td><input type="text" name="Title" size="40" value="{$data.Title}"></td></tr>
<tr><td align="right">{t}Music category{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$categories NAME="Category" SELECTEDITEM=$data.Category}</td></tr>
<tr><td align="right">Format (CD;LP;ITUNES;QOBUZ)</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$formats NAME="Format" SELECTEDITEM=$data.Format}&nbsp;({$data.Format})</td></tr>
<tr><td align="right">Audio Encoding</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$audios NAME="Audio" SELECTEDITEM=$data.Audio}</td></tr>
<tr><td align="right">ITunes - VAULT</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$storage NAME="STORAGE" SELECTEDITEM=$data.STORAGE}</td></tr>
<tr><td align="right">Label</td>
    <td><input type="text" name="Label" size="15" value="{$data.Label}"></td></tr>
<tr><td align="right">Classification</td>
    <td><input type="text" name="Classification" size="15" value="{$data.Classification}"></td></tr>
<tr><td align="right">Rating</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$ratings NAME="Rating" SELECTEDITEM=$data.Rating}</td>
</tr>
<tr><td colspan="2"><textarea name="Performer" cols="100" rows="7">{$data.Performer}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
