<html>
<head>
<title></title>
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

{if $data.WONUM eq null}
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="WOTYPE" value="REPAIR" />
<input type="hidden" name="WONUM" value="{$data.WONUM}">
<table width="600">
<tr><td align="right">{t}LBLFLD_NOTIF{/t}</td><td><b>{$data.NOTIF}</b></td></tr>
<tr><td align="right">{t}LBLFLD_WONUM{/t}</td><td><b>{$data.WONUM}</b></td></tr>
<tr><td align="right">{t}LBLFLD_EQNUM{/t}</td><td><b>{$data.EQNUM}</b></td></tr>
<tr><td></td></tr>
<tr><td align="right">{t}DBFLD_PRIORITY{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$priorities NAME="PRIORITY" SELECTEDITEM=""}</td></tr>
<tr><td align="center">{t}DT Duration{/t}</td><td><b>{$data.DT_DURATION}</b></td></tr>    
<tr><td align="center">{t}Start Event{/t}</td>
    <td>{include file="_calendartime.tpl" NAME="DT_START" VALUE=$smarty.now|date_format:"%Y-%m-%d %H:%M"}</td></tr>
<tr><td align="center">{t}End of Event{/t}</td>
    <td>{include file="_calendartime.tpl" NAME="DT_END" VALUE=$smarty.now|date_format:"%Y-%m-%d %H:%M"}</td></tr>
<tr><td colspan="2" align="center"><input class="submit" type="submit" value="{t}Generate Work Order{/t}" name="form_save"></td></tr>
</table>
</form>
{else}
<h1>{t}This notification was already converted to a Work Order{/t}</h1>
<table width="600">
<tr><td align="right">{t}LBLFLD_NOTIF{/t}</td><td><b>{$data.NOTIF}</b></td></tr>
<tr><td align="right">{t}LBLFLD_WONUM{/t}</td><td><b>{$wo_data.WONUM}</b></td></tr>
<tr><td align="right">{t}DBFLD_PRIORITY{/t}</td><td>{$wo_data.PRIORITY}</td></tr>
<tr><td align="right">{t}DT Duration{/t}</td><td><b>{$wo_data.DT_DURATION}</b></td></tr>    
<tr><td align="right">{t}Start Event{/t}</td><td><b>{$wo_data.DT_START|date_format:"%Y-%m-%d %H:%M"}</b></td></tr>
<tr><td align="right">{t}End of Event{/t}</td><td><b>{$wo_data.DT_END|date_format:"%Y-%m-%d %H:%M"}</b></td></tr>
</table>
{/if}