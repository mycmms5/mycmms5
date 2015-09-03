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
<input type="hidden" name="id1" value="{$data.WONUM}" />
<input type="hidden" name="id2" value="{$data.EQNUM}" />
<table width="800">
<tr><td align="right">{t}Demander{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$users1 NAME="USER1" SELECTEDITEM=$data.USER1}</td></tr>
<tr><td align="right">{t}Supplier{/t}</td>
    <td align="left">{include file="_combobox.tpl" type="LIST"  options=$users2 NAME="USER2" SELECTEDITEM=$data.USER2}</td></tr>
<tr><td align="right">{t}DBFLD_DESCRIPTIONONPO{/t}<BR>{t}Long Text{/t}</td>
    <td align="left"><textarea name="DESCRIPTIONONPO" cols="70" rows="5">{$data.DESCRIPTIONONPO}</textarea></td></tr>
<tr><td colspan="2" align="center"><textarea name="NOTES" cols="120" rows="8">{$data.NOTES}</textarea></td></tr>
<tr><td align="right">{t}DBFLD_QTYREQUESTED{/t}</td>
    <td align="left"><input type="text" name="QTYREQUESTED" size="5" value="0"></td></tr>
<tr><td align="right">{t}DBFLD_DATEGENERATED{/t}</td>
    <td align="left">{t}DBFLD_DUEDATE{/t}</td></tr>
<tr><td align="right">{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}</td>
    <td align="left">{include file="_calendar2.tpl" NAME="DUEDATE" VALUE=$data.SCHEDSTARTDATE}</td></tr>  
<tr><td align="right">{t}DBFLD_ACCTCODE{/t}</td>
    <td align="center">
        {include file="_combobox.tpl" type="LIST"  options=$plants NAME="USER5" SELECTEDITEM=""}&nbsp;
        {include file="_combobox.tpl" type="LIST"  options=$ledgers NAME="USER4" SELECTEDITEM=""}&nbsp;
        {include file="_combobox.tpl" type="LIST"  options=$expenses NAME="USER6" SELECTEDITEM=""}</td></tr>        
<tr><td colspan="2"><input type="submit" class="submit" value="{t}Save & Close{/t}" name="close"></td></tr>
</table>
</form>

</body>
</html>