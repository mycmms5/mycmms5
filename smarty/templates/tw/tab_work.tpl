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
<tr><th colspan="2">Work Information</td></tr>
<tr><td align="right">Task Description</td>
    <td align="left"><input type="text" name="TASKDESC" size="60" value="{$data.TASKDESC}"></B>&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<tr><td colspan="2"><textarea cols="120" rows="10" name="TEXTS">{$data.TEXTS}</textarea></td></tr>        
<tr><td align="right">Requestor</td>
    <td align="left"><input type="text" name="ORIGINATOR" size="20" value="HUYSMANS_WERNER"></td></tr>
<tr><td align="right">Request Date</td>
    <td align="left">{include file="_calendar.tpl" NAME="REQUESTDATE" VALUE=$data.REQUESTDATE}</td></tr>    
<!--
<tr><td align="right">Object</td>
    <td><input type="text" name="EQNUM" value="{$data.EQNUM}">&nbsp;
        <input type="text" name="DESCRIPTION" value="{$data.DESCRIPTION}">
        <a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=HOME_SELECT','EQNUM')">Select</a></td></tr>
-->        
        
<tr><td align="right"><a href="javascript:window.open('../libraries/tree_equip_select.php',
    'select_equip',
    'toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, titlebar=no, copyhistory=yes, width=700, height=800');">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}">&nbsp;
        <input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>    
        
<tr><td align="right">WO Type</td>
    <td>{include file="_combobox_num.tpl" type="NUM"  options=$types NAME="WOTYPE" SELECTEDITEM=$data.WOTYPE}</td></tr>    
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</body>
</html>