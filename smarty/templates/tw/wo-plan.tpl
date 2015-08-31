<!--
CVS
$Id: tab_wo-plan.tpl,v 1.2 2013/04/18 07:25:31 werner Exp $
$Source: /var/www/cvs/mycmms40/mycmms40/smarty/templates/tab_wo-plan.tpl,v $
$Log: tab_wo-plan.tpl,v $
Revision 1.2  2013/04/18 07:25:31  werner
Added Approval and prepared date

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
<input type="hidden" name="ACTION" value="STANDARD">
<input type="hidden" name="id1" value="{$data.WONUM}" />
<input type="hidden" name="id2" value="{$data.EQNUM}" />
<input type="hidden" name="ASSIGNEDBY_OLD" value="{$data.ASSIGNEDBY}">
<input type="hidden" name="ASSIGNEDTO_OLD" value="{$data.ASSIGNEDTO}">
<input type="hidden" name="WOSTATUS_OLD" value="{$data.WOSTATUS}">
<input type="hidden" name="COMMENTS" value="{$data.TEXTS_A}">
<table width="800">
<tr><td align="right">{t}LBLFLD_ASSIGNEDBY{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$preparation NAME="ASSIGNEDBY" SELECTEDITEM=$data.ASSIGNEDBY}</td></tr>
<tr><td align="right">{t}LBLFLD_ASSIGNEDTO{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$supervision NAME="ASSIGNEDTO" SELECTEDITEM=$data.ASSIGNEDTO}</td></tr>
<tr><td align="right">{t}LBLFLD_ASSIGNEDTECH{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$execution NAME="ASSIGNEDTECH" SELECTEDITEM=$data.ASSIGNEDTECH}</td></tr>
<tr><td align="right">{t}DBFLD_APPROVEDDATE{/t}</td><td>{$data.APPROVEDDATE}</td></tr>
<tr><td align="right">{t}LBLFLD_PREPARED{/t}</td><td>{$data.PREPARED}</td></tr>
<tr><td align="right">{t}LBLFLD_SCHEDSTARTDATE{/t}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="SCHEDSTART" VALUE=$data.SCHEDSTARTDATE}</td></tr>
<tr><td align="right">{t}LBLFLD_ESTCOST{/t}</td><td><input type="text" name="ESTCOST" value="{$data.ESTCOST}"></td></tr>
<tr><td align="center" colspan="2">{t}LBLFLD_WOSTATUS{/t}&nbsp;(<I>{$WOSTATUS_Message}</I>)&nbsp;
    {include file="_combobox.tpl" type="LIST"  options=$wostatus NAME="WOSTATUS" SELECTEDITEM=$data.WOSTATUS}</td></tr>
<tr><td align="center" colspan="2"><textarea name="PREPARATION" cols="100" rows="10">{$data.TEXTS_A}</textarea></td></tr>
<tr><td align="left" colspan="2">
    <input class="submit" type="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>            
</form>

{* SARALEE extension TASKNUM=SPOELEN with 1 operation 900 *}
<!--
<form action="{$SCRIPT_NAME}" method="post" class="form" name="spoelen">
<input type="hidden" name="ACTION" value="ADD_OPERATION">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="id1" value="{$data.WONUM}">
<input type="hidden" name="id2" value="{$data.EQNUM}">
<input type="hidden" name="TASKNUM" value="SPOELEN">
<table width="800">
<tr><td>{t}Na werken MOETEN de koffieleidingen steeds gespoeld worden{/t}</td>
    <td align="right"><input type="submit" class="submit" value="{t}Spoelen{/t}" name="form_save"></td></tr>
</table>
</form>
-->


{* Generic Tasks / Removed *}
<!--
<form action="{$SCRIPT_NAME}" method="post" class="form" name="task2wo">
<input type="hidden" name="ACTION" value="TASK2WO">
<input type="hidden" name="form_save" value="SET">
<table width="800">
<tr><td>{include file="_combobox.tpl" type="LIST"  options=$tasklist NAME="TASKNUM" SELECTEDITEM=$data.TASKNUM}</td>
    <td align="right"><input type="submit" class="submit" value="{t}Task Copy{/t}" name="form_save"></td></tr>
</table>  
</form>  
-->
</body>
</html>