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
<input type="hidden" name="id1" value="{$data.EQNUM}">
<input type="hidden" name="BOM" value="{$data.SPARECODE}">
<table width="800">
<tr><td align="right">{t}DBFLD_EQROOT{/t}&nbsp;({$data.parent})</td>
    <td colspan="2" align="right"><input type="text" name="EQROOT" size="100" value="{$data.EQROOT}"></td></tr>
<tr><td align="right">{t}DBFLD_EQNUM{/t}</td>
    <td align="right"><b>{$data.EQNUM}</b>&nbsp;({$data.postid})&nbsp;</td>
    <td><input type="text" size="50" name="DESCRIPTION" value="{$data.DESCRIPTION}"></td></tr>
<tr><td align="right">{t}Object Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$eqtypes NAME="EQTYPE" SELECTEDITEM=$data.EQTYPE}</td></tr>
<tr><td align="right">{t}SAP Type{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$floc NAME="EQFL" SELECTEDITEM=$data.EQFL}</td>
    <td><input type="text" size="5" name="children" value="{$data.children}"></td></tr>
<tr><td align="right">{t}Cost Center{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$ccs NAME="COSTCENTER" SELECTEDITEM=$data.COSTCENTER}</td></tr>
<tr><td align="right">{t}BOM{/t}</td>
    <td colspan="2"><b>{$data.SPARECODE}</b></td></tr>
<tr><td align="right">{t}Safety Note{/t}</td>
    <td colspan="2"><textarea name="SAFETYNOTE" cols="60" rows="10">{$data.SAFETYNOTE}</textarea></td></tr>

<tr><td colspan="2"><input type="submit" value="{t}Save{/t}" name="form_save">
                    <input type="submit" value="{t}Close{/t}" name="close"></td></tr>
</form>
</table>
