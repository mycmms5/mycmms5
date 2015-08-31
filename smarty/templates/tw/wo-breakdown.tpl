<html>
<head>
<title>{t}Breakdown Event Registration{/t}</title>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="600">
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_DURATION{/t}</th><th>{t}DBFLD_COMMENTS{/t}</th></tr>
{foreach from=$breakdowns item=breakdown}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$breakdown.WONUM}</td>
    <td>{$breakdown.EQNUM}</td>
    <td>{$breakdown.REQUESTDATE}</td>
    <td>{$breakdown.DURATION}</td>
    <td>{$breakdown.TEXTS_B}</td></tr>
{/foreach}
</table>
<h1>{t}Breakdown registration{/t}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="new">
<table width="600">
<tr><td align="right">{t}DBFLD_WONUM{/t}</td>
    <td><input type="text" name="WONUM" size="10"></td></tr>
<tr><td align="right">{t}DBFLD_EQNUM{/t}</td>
    <td><input type="text" name="EQNUM" size="10"></td></tr>
<tr><td>{t}DBFLD_REQUESTDATE{/t}</td>
    <td>{include file="_calendartime.tpl" NAME="REQUESTDATE" VALUE=$DATE_MONITORING}</td></tr>
<tr><td>{t}DBFLD_DT_DURATION{/t}</td>    
    <td><input type="text" name="DURATION" size="4" value="0"></td></tr>
<tr><td>{t}DBFLD_COMMENTS{/t}</td>
    <td><textarea cols="70" rows="5" name="TEXTS_B"></textarea></td></tr>    
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save & Close{/t}" name="form_save">
</table>
</form>

