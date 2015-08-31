<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Lookup Work Orders{/t}</h1>
<h1 class="action">{t}Select criteria (tick to activate){/t}</h1>
<form action="{$SCRIPT_NAME}" name="treeform" method="post">
<input type="hidden" name="STEP" value="1">
<table width="1000" align="center">
<!-- Date Ranges -->
<tr><td><input type="checkbox" name="LOOK_DT1_2">{t}Date of Request{/t}</td>
    <td rowspan="3"><input type="radio" name="group" value="group1">group1</td>
    <td>{t}From{/t} : {include file="_calendar2.tpl" NAME="DT1" VALUE=$data.QBE.DT1} - {t}Until{/t} : {include file="_calendar2.tpl" NAME="DT2" VALUE=$data.QBE.DT2}</td></tr>
<tr><td><input type="checkbox" name="LOOK_DT3_4">{t}Planned Start{/t}</td>
    <td>{t}From{/t} : {include file="_calendar2.tpl" NAME="DT3" VALUE=$data.QBE.DT3} - {t}Until{/t} : {include file="_calendar2.tpl" NAME="DT4" VALUE=$data.QBE.DT4}</td></tr>
<tr><td><input type="checkbox" name="LOOK_DT5_6">{t}Completed{/t}</td>
    <td>{t}From{/t} : {include file="_calendar2.tpl" NAME="DT5" VALUE=$data.QBE.DT5} - {t}Until{/t} : {include file="_calendar2.tpl" NAME="DT6" VALUE=$data.QBE.DT6}</td></tr>
<tr><td colspan="3"><hr></td></tr>
<tr><td><input type="checkbox" name="LOOK_DT7_8">{t}Commented{/t} by {t}LBLFLD_ASSIGNEDTECH_DEMB{/t}</td>
    <td><input type="radio" name="group" value="group2" checked="checked">group2</td>
    <td>{t}From{/t} : {include file="_calendartime2.tpl" NAME="DT7" VALUE=$data.QBE.DT7} - {t}Until{/t} : {include file="_calendartime2.tpl" NAME="DT8" VALUE=$data.QBE.DT8}</td></tr>
<tr><td colspan="3"><hr></td></tr>    
<tr><td><input type="checkbox" name="LOOK_TECHNICIAN">{t}LBLFLD_ASSIGNEDTECH_DEMB{/t}</td>
    <td colspan="2">{include file="_combobox.tpl" type="MULTIPLE"  options=$assignedtechs NAME="ASSIGNEDTECH[]" SELECTEDITEM=""}</td></tr>
<tr><td><input type="checkbox" name="LOOK_TEXT">{t}Text Search{/t}</td>
    <td colspan="2" align="left"><input type="text" name="TEXT" size="80" value="{$data.QBE.TEXT}"></td></tr>
<tr><td><input type="checkbox" name="LOOK_ORIGINATOR">{t}Originator{/t}</td>
    <td colspan="2">{include file="_combobox.tpl" type="MULTIPLE"  options=$originators NAME="ORIGINATOR[]" SELECTEDITEM=""}</td></tr>
<tr><td><input type="checkbox" name="LOOK_WOSTATUS">{t}WO Status{/t}</td>
    <td colspan="2">{include file="_combobox.tpl" type="MULTIPLE"  options=$wostati NAME="WOSTATUS[]" SELECTEDITEM=""}</td></tr>
<tr><td><input type="checkbox" name="LOOK_PRIORITY">{t}WO Prioriteit{/t}</td>
    <td colspan="2">{include file="_combobox.tpl" type="MULTIPLE"  options=$priorities NAME="PRIORITY[]" SELECTEDITEM=""}</td></tr>
<tr><td><input type="checkbox" name="LOOK_EQNUM" checked>{t}EQNUM - refining search{/t}</td>
    <td colspan="2"><input type="text" name="EQNUM" size="30" value="{$data.QBE.EQNUM}">
                    <input type="text" name="DESCRIPTION" size="50">
                    </br>
                    <a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=EQUIP2','EQNUM')">{t}Select equipment{/t}</a></td></tr>
<tr><td>{t}Static List{/t}</td><td colspan="2"><input type="checkbox" name="STATIC" checked="checked"></td></tr>
<tr><td colspan="3"><input type="submit" name="check" value="Logboek"></td></tr>
</table>
</form>
<div class="CVS">CVS: {$version}</div>
</body>
</html>