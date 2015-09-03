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
<input type="hidden" name="SEQNUM" value="{$data.SEQNUM}">
<input type="hidden" name="REQ_ID" value="{$data.USER3}"/>
<table width="800">
<tr><th colspan="2">{t}Purchase Request Information{/t}</td></tr>
<tr><td align="right">{t}DBFLD_USER1{/t}</td><td align="center">{$data.USER1}</</td></tr>
<tr><td align="right">{t}Date Purchase Request{/t}</td><td align="center"><b>{$data.DATEGENERATED|date_format: "%Y-%m-%d %H:%M:%S"}</B></td></tr>
<tr><td align="right">{t}DBFLD_DESCRIPTIONONPO{/t}</td><td>{$data.DESCRIPTIONONPO}</td></tr>
<tr><td align="right">{t}DBFLD_NOTES{/t}</td><td>{t}{$data.NOTES}{/t}</td></tr>
<tr><td align="right">{t}DBFLD_QTYREQUESTED{/t}</td><td>{t}{$data.QTYREQUESTED}{/t}</td></tr>   
<tr><td align="center">{t}DBFLD_VENDORID{/t}</td><td>{include file="_combobox.tpl" type="LIST"  options=$users2 NAME="USER2" SELECTEDITEM=$data.USER2}
</td></tr>
<tr><td colspan="2" align="center">{$data.USER5}&nbsp;-&nbsp;{$data.USER6}.&nbsp;-&nbsp;{$data.USER4}</td></tr>          
<tr><td align="center">{t}DBFLD_DUEDATE_SAP{/t}</td>
    <td>{include file="_calendar2.tpl" NAME="DUEDATE_SAP" VALUE=$data.DUEDATE_SAP}</td></tr>  
<tr><td align="center">{t}DBFLD_PONUM{/t}</td>
    <td><input type="text" name="PONUM" size="15" value="{$data.PONUM}"></td></tr>  
<tr><td align="right" colspan="2">
    <input class="submit" type="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>            
<!-- Other inputs -->
</form>
</body>
</html>