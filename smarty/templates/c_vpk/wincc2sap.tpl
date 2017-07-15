{debug}
<html>
<head>
<title></title>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
    screen.width=1500;
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_tw}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus();">
<form method="post" class="form" name="treeform" action="{$SCRIPT_NAME}">
<input type="hidden" name="id1" value="{$data.EQNUM}">
<input type="hidden" name="EQROOT_OLD" value="{$data.EQROOT}">
<input type="hidden" name="BOM" value="{$data.SPARECODE}">
<table width="800">
<tr><td class="LABEL">{t}SAP ROOT{/t}&nbsp;</td>
    <td colspan="2" align="left"><input type="text" name="EQROOT" size="75" value="{$data.QAS_ROOT}"></br>
    <b>{$data.EQROOT_DESC}</b>&nbsp;(postid:&nbsp;{$data.parent})</td></tr>
<tr><td class="LABEL">{t}EQNUM{/t}-WinCC</td>
    <td align="left"><input type="text" name="SCADA" value="{$data.scada}" size="50"</b></br>
        <input type="text" size="50" name="SCADA_DESCRIPTION" value="{$data.scada_description}"></td></tr>
<tr><td class="LABEL">{t}EQNUM{/t}-SAP</td>
    <td><input type="text" size="50" name="EQNUM" value="{$data.QAS}"></td></tr>

<tr><td colspan="2"><input type="submit" value="{t}Save{/t}" name="form_save">
                    <input type="submit" value="{t}Close{/t}" name="close"></td></tr>
</form>
</table>
