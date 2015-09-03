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
<tr><th colspan="2">{t}Receptions{/t}</td></tr>
<tr><td align="right">{t}DBFLD_USER1{/t}</td><td align="center">{$data.USER1}</</td></tr>
<tr><td align="right">{t}Date Purchase Request{/t}</td><td align="center"><b>{$data.DATEGENERATED|date_format: "%Y-%m-%d %H:%M:%S"}</B></td></tr>
<tr><td align="right">{t}DBFLD_DESCRIPTIONONPO{/t}</td><td>{$data.DESCRIPTIONONPO}</td></tr>
<tr><td align="right">{t}DBFLD_NOTES{/t}</td><td>{t}{$data.NOTES}{/t}</td></tr>
<tr><td align="right">{t}DBFLD_QTYREQUESTED{/t}</td><td>{t}{$data.QTYREQUESTED}{/t}</td></tr>   
<tr><td align="center">{t}DBFLD_VENDORID{/t}</td><td>{$data.USER2}</td></tr>
<tr><td colspan="2" align="center">{$data.USER5}&nbsp;-&nbsp;{$data.USER6}.&nbsp;-&nbsp;{$data.USER4}</td></tr>          
<tr><td align="center">{t}DBFLD_DUEDATE_SAP{/t}</td><td>{$data.DUEDATE_SAP}</td></tr>  
<tr><td align="center">{t}DBFLD_PONUM{/t}</td><td>{$data.PONUM}</td></tr>  
<tr><td align="right">{t}DBFLD_QTYRECEIVED{/t}</td>
    <td><input type="text" name="QTYRECEIVED" size="5" value="{$data.QTYRECEIVED}"></td></tr>  
{if $PR_State}{assign var="PR_CHECKED" value="checked"}{/if}
{if $PC_State}{assign var="PC_CHECKED" value="checked"}{/if}    
<tr><td align="right">{t}Reception{/t}</td>
    <td><input type="checkbox" name="PC" {$PC_CHECKED}>&nbsp;{t}Complete{/t}&nbsp;-&nbsp;
        <input type="checkbox" name="PR" {$PR_CHECKED}>&nbsp;{t}Partial{/t}</td></tr>          
<tr><td align="right" colspan="2">
    <input class="submit" type="submit" value="{t}Save{/t}" name="form_save">
    <input type="submit" class="submit" value="{t}Close{/t}" name="close"></td></tr>
</table>            
<!-- Old -->
</table>
</form>

<table width="100%">
<tr><th>{t}DBFLD_PONUM{/t}</th><th>{t}DBFLD_SEQNUM{/t}</th><th>{t}DBFLD_QTYRECEIVED{/t}</th><th>{t}DBFLD_DATERECEIVED{/t}</th></tr>
{foreach item=reception from=$receipts}
<tr><td>{$reception.PONUM}</td>
    <td>{$reception.SEQNUM}</td>
    <td>{$reception.QTYRECEIVED}</td>
    <td>{$reception.DATERECEIVED}</td></tr>
{/foreach}
</table>
</body>
</html>