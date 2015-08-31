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
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css">
</head>
<body onload="setFocus()">
<table width="700" align="center">
<form name="treeform" action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="id1" value="{$data.NAME}"> 
<tr><th colspan="2">New/Edit Composer</th></tr>
<tr><td align="right" VALIGN="Top">Long/Short name Composer</td>
    <td><input type="text" name="NAME" value="{$data.NAME}">&nbsp;
        <input type="text" name="NAMESHORT" value="{$data.NAMESHORT}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
{if $data.TYPE neq 'GROUP'}
<tr><td>Birth / Died</td>
    <td>{include file="_calendar.tpl" NAME="BIRTH" VALUE=$data.BIRTH}&nbsp;
        {include file="_calendar.tpl" NAME="DIED" VALUE=$data.DIED}</td></tr>
{/if}        
<tr><td>Nationality</td>
    <td><input type="text" name="NATIONALITY" value="{$data.NATIONALITY}"></td></tr>
<tr><td>Composer / Group</td>
    <td><input type="text" name="TYPE" value="{$data.TYPE}"></td></tr>    
<tr><td colspan="2"><textarea name="TEXT" cols="120" rows="15">{$data.TEXT}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
<table width="100%">
<tr><th>#</th><th>Album</th><th>Format</th></tr>
{foreach item=record from=$records}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>{$record.RecordingID}</td><td>{$record.Title}</td><td>{$record.Format}</td></tr>
{/foreach}    
</table>
</body>
</html>