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
<input type="hidden" name="id1" value="{$data.SEQNUM}">
<input type="hidden" name="req_id" value="{$data.USER3}"/>
<table width="800">
<tr><th colspan="2">{t}Purchase Request Information{/t}</td></tr>
<tr><td align="right">{t}Demander{/t}</td><td align="center">{$data.USER1}</td></tr>
<tr><td align="right">{t}DBFLD_DATEGENERATED{/t}</td><td align="center"><B>{$data.DATEGENERATED|date_format:"%Y-%m-%d %H:%M:%S"}</B></td></tr>
<tr><td align="right">{t}DBFLD_DESCRIPTIONONPO{/t}</td>
    <td><input type="text" name="DESCRIPTIONONPO" size="50" value="{$data.DESCRIPTIONONPO}"></td></tr>
<tr><td align="right">{t}DBFLD_NOTES{/t}</td>
    <td><textarea name="NOTES" cols="70" rows="5">{$data.NOTES}</textarea></td></tr>
<tr><td align="right">{t}DBFLD_QTYREQUESTED{/t}</td>
    <td><input type="text" name="QTYREQUESTED" size="5" value="{$data.QTYREQUESTED}"></td></tr>
<tr><td align="right">{t}DBFLD_VENDORINFO{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$users2 NAME="USER2" SELECTEDITEM=$data.USER2}</td></tr>
<tr><td align="right">{t}DBFLD_ACCTCODE{/t}</td>
    <td align="center">
        {include file="_combobox.tpl" type="LIST"  options=$plants NAME="USER5" SELECTEDITEM=""}&nbsp;
        {include file="_combobox.tpl" type="LIST"  options=$ledgers NAME="USER4" SELECTEDITEM=""}&nbsp;
        {include file="_combobox.tpl" type="LIST"  options=$expenses NAME="USER6" SELECTEDITEM=""}</td></tr>        
<tr><td colspan="2"><input type="submit" class="submit" value="{t}Save{/t}" name="form_save"></td></tr>
</table>
</form>

</body>
</html>