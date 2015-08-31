<!--
CVS
$Id: tab_wr-approve.tpl,v 1.3 2013/06/10 09:49:40 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/smarty/templates/tab_wr-approve.tpl,v $
$Log: tab_wr-approve.tpl,v $
Revision 1.3  2013/06/10 09:49:40  werner
Made static fields of fields that shouldn't be changed

Revision 1.2  2013/04/18 07:25:11  werner
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
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="WOPREV" value="0" />
<input type="hidden" name="EXPENSE" value="MAINT" />
<input type="hidden" name="WOTYPE" value="REPAIR" />
<input type="hidden" name="APPROVEDBY" value="{$smarty.session.user}">
<table width="800">
<tr><td align="right">{t}DBFLD_ORIGINATOR{/t}</td><td align="center"><b>{$data.ORIGINATOR}</b></td></tr>
<tr><td valign ="top" align="right" width="30%">{t}DBFLD_TASKDESC{/t}</td>
    <td><textarea name="TASKDESC" id="TASKDESC" cols="80" rows="2">{$data.TASKDESC}</textarea></td></tr>
<tr><td align="right">{t}DBFLD_APPROVEDBY{/t}</td>
    <td align="center"><b>{$smarty.session.user}</b></td></tr>
<tr><td align="right">{t}DBFLD_APPROVEDDATE{/t}</td>
    <td align="center"><b>{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</b></td></tr>
<tr><td align="right">{t}DBFLD_WOTYPE{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$wotypes NAME="WOTYPE" SELECTEDITEM=$data.WOTYPE}</td></tr>    
<tr><td align="right">{t}DBFLD_ESTCOST{/t}</td>
{if $data.ESTCOST eq null}
    <td><input type="text" name="ESTCOST" size="5" value="0"></td></tr>    
{else}
    <td><input type="text" name="ESTCOST" size="5" value="{$data.ESTCOST}"></td></tr>    
{/if}    
<tr><td align="right">{t}DBFLD_ASSIGNEDBY{/t}</td><td align="left">{t}DBFLD_ASSIGNEDTO{/t}</td></tr>
<tr><td align="right">{include file="_combobox.tpl" type="LIST"  options=$preparation NAME="ASSIGNEDBY" SELECTEDITEM=$data.ASSIGNEDBY}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$supervision NAME="ASSIGNEDTO" SELECTEDITEM=$data.ASSIGNEDTO}</td></tr>
<tr><td colspan="2" align="center"><textarea cols="100" rows="10" name="COMMENT">{$data.TEXTS_A}</textarea></td></tr>
<tr><td colspan="2">    
<!--    <input type="submit" value="{t}Save{/t}" name="form_save">  -->
    <input type="submit" value="{t}Save & Close{/t}" name="close"></td></tr>
</table>
</form>

