<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
document.treeform.BARCODE.style.background='lightblue'; 
document.treeform.BARCODE.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus()">
<table width="800">
<tr><th>{t}DBFLD_EMPCODE{/t}</th><th>{t}DBPFLD_longname{/t}</th><th>{t}DBFLD_WODATE{/t}</th><th>{t}DBFLD_REGHRS{/t}</th></tr>
{foreach from=$data item=prestation}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>{$prestation.EMPCODE}</td>
    <td>{$prestation.longname}</td>
    <td>{$prestation.WODATE}</td>
    <td>{$prestation.REGHRS}</td></tr>
{/foreach}
</table>
<hr>
<table width="800">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.WONUM}">
<tr><td>{t}BARCODE employee{/t}</td><td><input type="text" name="BARCODE" size="10"></td></tr>
<tr><td>{t}DBFLD_REGHRS{/t}</td><td><input type="text" name="REGHRS" size="5" value="0"></td></tr>
<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save"></td></tr>
</form>
</table>
