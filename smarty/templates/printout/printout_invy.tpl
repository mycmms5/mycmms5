{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="2" bgcolor="red"><b>{t}Printout Stock Item: {/t}{$invy.ITEMNUM}</b> - <i>{$invy.DESCRIPTION}</i></td></tr>
<tr><td width="25%"><B>{t}DBFLD_ITEMDESCRIPTION{/t}</B></td><td>{$invy.DESCRIPTION}</td></tr>
<tr><td><B>{t}DBFLD_NOTES{/t}</B></td><td>{$invy.NOTES|nl2br}</td></tr>
</table>

{* Documentation *}
<table width="100%">
<tr><th>{t}Filename{/t}</th><th>{t}Content{/t}</th></tr>
{foreach item=document from=$documents}
<tr><td><a href='{$doc_path}{$document.FILENAME}'>{$document.FILENAME}</a></td><td>{$document.FILEDESCRIPTION}</td></tr>
{/foreach}
</table>

{* Stock *}                                      
<table width="100%">
<tr><th>{t}DBFLD_WAREHOUSEID{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYONHAND{/t}</th></tr>
{foreach item=stock from=$stocks}
<tr><td>{$stock.WAREHOUSEID}</td><td>{$stock.LOCATION}</td><td>{$stock.QTYONHAND}</td></tr>
{/foreach}
</table>

</body>
</html>