<!--
CVS
$Id: tab_task-edit.tpl,v 1.3 2013/04/18 07:25:11 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/smarty/templates/tab_task-edit.tpl,v $
$Log: tab_task-edit.tpl,v $
Revision 1.3  2013/04/18 07:25:11  werner
Inserted CVS variables Id,Source and Log

-->
<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
{if $smarty.session.Ident_1 ne "new"}
<input type="hidden" name="id1"   value="{$data.TASKNUM}">
<input type="hidden" name="TASKNUM" value="{$data.TASKNUM}">
<input type="hidden" name="EQNUM" value="{$data.EQNUM}">
{/if}
<table width="800">
{if $smarty.session.Ident_1 ne "new"}
<tr><td class="LABEL">{t}LBLFLD_TASKNUM{/t}</td><td>{$data.TASKNUM}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_EQNUM{/t}</td><td>{$data.EQNUM}&nbsp;{$data.DESCRIPTION}</td></tr>
{else}
<tr><td valign ="top" class="LABEL">{t}LBLFLD_TASKNUM{/t}</td>
    <td><input type="text" name="TASKNUM" size="50" value="{$data.TASKNUM}"></td></tr>
<tr><td class="LABEL"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td>
    <td><input name="EQNUM" size="25" value="{$data.EQNUM}"><input name="DESCRIPTION" size="50" value="{$data.DESCRIPTION}"></td></tr>    
{/if}    
<tr><td class="LABEL">{t}Task Description{/t}</td>
    <td><input type="text" name="TASK_DESCRIPTION" size="70" value="{$data.TASK_DESCRIPTION}"></td></tr>
<tr><td class="LABEL">{t}Task Instructions{/t}</td>
    <td><textarea name="TEXTS_A" cols="70" rows="10">{$data.TEXTS_A}</textarea></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>
</form>
