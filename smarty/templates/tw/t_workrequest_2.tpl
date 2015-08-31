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
<input type="hidden" name="WOPREV" value="0" />
<input type="hidden" name="EXPENSE" value="MAINT" />
<input type="hidden" name="WOTYPE" value="REPAIR" />
<table width="800">
<tr><td valign ="top" align="right" width="30%">{t}Workorder Task Description{/t}</td>
    <td><textarea name="TASKDESC" id="TASKDESC" cols="80" rows="4">{$data.TASKDESC}</textarea></td></tr>
<tr><td align="right">{t}DBFLD_TEXTS_A{/t}</td>
    <td><textarea name="TEXTS_A" cols="80" rows="5">{$data.TEXTS_A}</textarea></td> </tr>    
<tr><td align="right">{t}DBFLD_ORIGINATOR{/t}</td>
    <td align="center"><b>{$smarty.session.user}</b></td></tr>
<tr><td align="right">{t}LBLFLD_ASSIGNEDTECH{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$technicians NAME="ASSIGNEDTECH" SELECTEDITEM=$data.ASSIGNEDTECH}</td></tr>
<tr><td align="right">{t}DBFLD_PRIORITY{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$priorities NAME="PRIORITY" SELECTEDITEM=$data.PRIORITY}</td></tr>
<tr><td align="right">{t}LBLFLD_WOTYPE{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$wotypes NAME="WOTYPE" SELECTEDITEM=$data.WOTYPE}</td></tr>
<tr><td align="right">{t}DBFLD_REQUESTDATE{/t}</td><td>{t}DBFLD_SCHEDSTARTDATE{/t}</td></tr>
<tr><td align="right">{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</td>
    <td>{include file="_calendar2.tpl" NAME="SCHEDSTARTDATE" VALUE=$data.SCHEDSTARTDATE}</td></tr>
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}"><input name="DESCRIPTION" size="35" value="{$data.DESCRIPTION}"></td></tr>
<tr><td colspan="2"><!-- <input type="submit" value="{t}Save{/t}" name="form_save"> -->
                    <input type="submit" value="{t}Save & Close{/t}" name="close"></td></tr>
</table>
</form>
