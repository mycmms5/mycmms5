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
<input type="hidden" name="WOTYPE" value="REPAIR" />
<table width="800">
<tr><td align="right">{t}LBLFLD_NOTIFICATION{/t}</td><td><b>{$smarty.session.Ident_1}</b></td>
<tr><td align="right">{t}LBLFLD_NOTIFIER{/t}</td><td><b>{$smarty.session.user}</b></td>    
<!--
    <td>{include file="_combobox.tpl" type="LIST"  options=$notifiers NAME="NOTIFIER" SELECTEDITEM=$data.NOTIFIER}</td></tr>
-->
<tr><td align="right">{t}LBLFLD_WONUM{/t}</td><td><b>{$data.WONUM}</b></td></tr>
<tr><td align="right">{t}LBLFLD_EQNUM{/t}</td><td><b>{$data.EQNUM}</b></td></tr>
<tr><th align="right">{t}LBLFLD_NOTIFDATE{/t}</th>
    <th align="left">{t}LBLFLD_NOTIFDATE_END{/t}</th></tr>
<tr><td align="right">{include file="_calendartime2.tpl" NAME="NOTIFDATE" VALUE="{$data.NOTIFDATE}"}</td>
    <td align="left">{include file="_calendartime2.tpl" NAME="NOTIFDATE_END" VALUE="{$data.NOTIFDATE_END}"}</td></tr>
<tr><td>{t}Notification{/t}</td>
    <td><textarea name="NOTIFICATION" cols="70" rows="2">{$data.NOTIFICATION}</textarea>
<tr><td>{t}Notification (Long Text){/t}</td>
    <td><textarea name="LNOTIFICATION" cols="70" rows="4">{$data.LNOTIFICATION}</textarea></td></tr>
<tr><td align="right">{t}Type of notification{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$notiftypes NAME="NOTIFTYPE" SELECTEDITEM=$data.NOTIFTYPE}</td></tr>

<!-- Equipment Tree -->
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input type="text" name="EQNUM" value="{$data.EQNUM}"><input type="text" name="DESCRIPTION" value="{$data.DESCRIPTION}"></td></tr>
<tr><td colspan="2">    
    <input class="submit" type="submit" value="{t}Save{/t}" name="form_save">
    <input class="submit" type="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>