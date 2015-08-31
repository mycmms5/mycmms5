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
<input type="hidden" name="id1" value="{$data.OFFER}">
<table width="800">
<tr><th colspan="2">{t}Information on Offer {$data.OFFER}{/t}</td></tr>
<tr><td align="center"><B><input name="CLID" size="6" value="{$data.CLID}"></b></td><td><b>{$data.NAME}</b></td></tr>
<tr><td align="right">{$data.CONTACT}</td><td>{$data.PHONE} / {$data.GSM} / {$data.EMAIL}</td></tr>
<tr><td align="right">{t}Date of Offer{/t}</td><td align="left"><B>{$data.DATE_OFFER}</B></td></tr>
<tr><td align="right">{t}Status{/t}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$states NAME="STATE" SELECTEDITEM=$data.STATE}</td></tr>
<tr><td valign ="top" align="right">{t}Material{/t}</td>
    <td><textarea name="MATERIAL" cols="80" rows="3">{$data.MATERIAL}</textarea></td></tr>
<tr><td valign ="top" align="right">{t}Comments{/t}</td>
    <td><textarea name="COMMENTS" cols="80" rows="3">{$data.COMMENTS}</textarea></td></tr>

<tr><td colspan="2">
    <input type="submit" class="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}"  name="close"></td></tr>
</table>
</form>

