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
<!--
    "IS_LASTCOUNTER"=>_(""),
    "IS_COUNTER"=>_(""),
    "HDR_TASKACTIVATION"=>_("Setting Task ACTIVE"),
    "IS_TASKACTIVE"=>_("Is Task activated?"),
    "IS_SETFREQUENCY"=>_("Adapt Frequency")
    -->
</head>
<body onload="setFocus()">
<h1>{$data.TASKNUM}&nbsp;-&nbsp;{$data.DESCRIPTION}&nbsp;({t}DBFLD_SCHEDTYPE{/t}:{$data.SCHEDTYPE})&nbsp;{$data.EQNUM}</h1>
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.TASKNUM}">
<input type="hidden" name="EQNUM" value="{$data.EQNUM}">
<input type="hidden" name="SCHEDTYPE" value="{$data.SCHEDTYPE}">
<table width="800">
<tr><td class="LABEL">{t}LBLFLD_TASKNUM{/t}</td><td><b>{$data.TASKNUM}</b></td></tr>
<tr><td class="LABEL">{t}LBLFLD_TASKTYPE{/t}</td><td><b>{$data.WOTYPE}</b></td></tr>
<tr><td class="LABEL">{t}LBLFLD_TASKDESCRIPTION{/t}</td><td><b>{$data.DESCRIPTION}</b></td></tr>
<tr><td class="LABEL">{t}LBLFLD_EQNUM{/t}</td><td><b>{$data.EQNUM} : {$data.EQDESC}</b></td></tr>

{if $data.SCHEDTYPE eq "F"}
{* Interval data for Time Based Maintenance *}
<tr><th colspan="2">{t}Time Based PPM{/t} - {t}Floating interval{/t}</th></tr>
<tr><td class="LABEL">{t}LBLFLD_NUMOFDATE{/t}</td>
    <td><input type="text" name="NUMOFDATE" size="5" align="right" value="{$data.NUMOFDATE}">{t}Days between task{/t}</td></tr>
<tr><td class="LABEL">{t}LBLFLD_LASTPERFDATE{/t}</td><td class="LABELLEFT">{t}LBLFLD_NEXTDUEDATE{/t}</td></tr>
<tr><td align="right">{include file="_calendar2.tpl" NAME="LASTPERFDATE" VALUE="{$data.LASTPERFDATE}"}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="NEXTDUEDATE" VALUE="{$data.NEXTDUEDATE}"}</td></tr>
<tr><th colspan="2">{t}LBLFLD_TASKACTIVE{/t}</th></tr>
<tr><td class="LABEL">{t}Is Task activated?{/t}</td>
    <td>{if $data.ACTIVE eq "1"}{assign var="active" value="CHECKED"}{else}{assign var="active" value=""}{/if}    
<input type="checkbox" name="ACTIVATE" {$active}></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value="{t}Adapt Frequency{/t}" name="form_save"></td></tr>
</table>
</form>    
{/if}

{if $data.SCHEDTYPE eq "X"}
{* Interval data for Time Based Maintenance *}
<tr><th colspan="2">{t}Time Based PPM{/t} - {t}Fixed interval{/t}</th></tr>
<tr><td align="right">{t}LBLFLD_NUMOFDATE{/t}</td>
    <td><input type="text" name="NUMOFDATE" size="10" align="center" value="{$data.NUMOFDATE}">{t}Days between tasks{/t}</td></tr>
<tr><td align="center">{t}LBLFLD_LASTPERFDATE{/t}</td><td align="center">{t}LBLFLD_NEXTDUEDATE{/t}</td></tr>
<tr><td align="center">{include file="_calendar2.tpl" NAME="LASTPERFDATE" VALUE="{$data.LASTPERFDATE}"}</td>
    <td align="center">{include file="_calendar2.tpl" NAME="NEXTDUEDATE" VALUE="{$data.NEXTDUEDATE}"}</td></tr>
<tr><td align="right">{t}LBLFLD_TASKACTIVE{/t}</td>
    <td>{if $data.ACTIVE eq "1"}{assign var="active" value="CHECKED"}{else}{assign var="active" value=""}{/if}    
<input type="checkbox" name="ACTIVATE" {$active}></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value="{t}Adapt Frequency{/t}" name="form_save"></td></tr>
</table>
</form>    
{/if}

{if $data.SCHEDTYPE eq "T"}
<tr><th colspan="2">{t}Counter Based PPM{/t}</th></tr>
<tr><td align="right">{t}LBLFLD_NUMOFDATE{/t}</td>
    <td><input type="text" name="NUMOFDATE" size="10" align="center" value="{$data.NUMOFDATE}">{t}Days between tasks{/t}</td></tr>
<tr><th align="center">{t}LBLFLD_LASTCOUNTER{/t}</th><th align="center">{t}LBLFLD_COUNTER{/t}</th></tr>
<tr><td align="center"><input type="text" name="LASTCOUNTER" size="10" value="{$data.LASTCOUNTER}"></td>
    <td align="center"><input type="text" name="COUNTER" size="10" value="{$data.COUNTER}"></td></tr>
<tr><td align="right">{t}LBLFLD_TASKACTIVE{/t}</td>
    <td>{if $data.ACTIVE eq "1"}{assign var="active" value="CHECKED"}{else}{assign var="active" value=""}{/if}    
<input type="checkbox" name="ACTIVATE" {$active}></td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value="{t}Adapt Frequency{/t}" name="form_save"></td></tr>
</table>
</form>    
{/if}

{if $data.SCHEDTYPE eq "C"}
<tr><th colspan="2">{t}Calendar Based PPM{/t}</th></tr>
<tr><td align="right">{t}Intervals{/t}</td>
    <td>{t}Not Applicable since the dates are fixed in the calendar{/t}</td></tr>
<tr><th align="center">{t}LBLFLD_LASTPERFDATE{/t}</th><th align="center">{t}LBLFLD_NEXTDUEDATE{/t}</th></tr>
<tr><td align="center">{t}Determined in the Calendar{/t}</td>
    <td align="center">{t}Determined in the Calendar{/t}</td></tr>
<tr><td align="right">{t}LBLFLD_TASKACTIVE{/t}</td>
    <td>{t}Task is automatically activated when dates are defined in table ppmcalendar{/t}</td></tr>
<tr><td colspan="2" align="center"><input type="submit" class="submit" value="{t}Adapt Frequency{/t}" name="form_save"></td></tr>
</table>
</form>    
{/if}
