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
<tr><th colspan="2">{t}Lubrication Instruction{/t}</td></tr>
<tr><td align="right">{t}DBFLD_ID{/t}</td><td align="center"><B>{$data.ID}</B></td></tr>
<tr><td align="right">{t}DBFLD_RID{/t}</td>
    <td align="left"><input type="text" name="RID" value="{$data.RID}">&nbsp;
        <input type="checkbox" name="new">&nbsp;NEW</td></tr>
<!-- Machine -->        
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=MCH','MACHINE')">{t}Select machine{/t}</a></td>
    <td><input type="text" size="25" name="MACHINE" value="{$data.MACHINE}">
        <input type="text" size="50" name="EQ_DESCRIPTION" value="{$data.EQ_DESCRIPTION}"></td></tr>    
<!-- Functional Location -->        
<tr><td align="right"><a href="javascript://" onClick="treewindow('../actions/tree2/index.php?tree=FL','MACHINE')">{t}Select equipment{/t}</a></td>
    <td><input type="text" size="25" name="FUNCTION" value="{$data.FUNCTION}">
        <input type="text" size="50" name="FL_DESCRIPTION" value="{$data.FL_DESCRIPTION}"></td></tr>    
        
<tr><td align="center">{t}Instruction Code{/t}</td><td align="center">{t}DBFLD_NOTE{/t}</td></tr>
<tr><td align="center">{include file="_combobox.tpl" type="LIST"  options=$appcodes NAME="APP" SELECTEDITEM=$data.APP}</td>
    <td><textarea name="NOTE" cols="60" rows="4">{$data.NOTE}</textarea></td></tr>
    
<tr><th colspan="2">{t}Lubrication Products{/t}</td></tr>
<tr><th align="center">{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_QTYREQD{/t}</th></tr>
<tr><td align="center"><input type="text" size="7" name="PRODUCT" value="{$data.PRODUCT}">&nbsp;<i>{$data.DESCRIPTION}</i></td>
    <td align="center"><input type="text" size="5" name="QTYREQD" value="{$data.QTYREQD}"></td></tr>
    
<tr><th colspan="2">{t}Lubrication Frequency{/t}</td></tr>
<tr><th align="center">{t}DBFLD_NEXTDUEDATE{/t}</th><th>{t}DBFLD_NUMOFDATE{/t}</th></tr>
<tr><td align="center">{include file="_calendar.tpl" NAME="NEXTDUEDATE" VALUE=$data.NEXTDUEDATE|date_format:"%Y-%m-%d"}</td>
    <td align="center"><input type="text" size="5" name="NUMOFDATE" value="{$data.NUMOFDATE}"></td></tr>

<!-- Save or Close -->
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}"  name="close"></td></tr>
</table>
</form>

