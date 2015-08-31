{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="2" bgcolor="red"><b>{$object_main_data.EQNUM}</b> - <i>{$object_main_data.DESCRIPTION}</i></td></tr>
<tr><td><B>{$LBLFIELD_EQTYPE}</B></td><td>{$object_main_data.EQTYPE}</td></tr>
<tr><td><B>{$smarty.config.IS_SPARECODE}</B></td><td>{$object_main_data.SPARECODE}</td></tr>
</table>

{* Documentation *}
{if count($documents) eq 0 and count($uploads) eq 0}
<table border="solid" width="100%">
<tr><th class="no-info">{t}No documents linked to Object{/t}</th></tr>
</table>
{else}                  
<table>
<tr><th>{t}DBFLD_filename{/t}</th><th>{t}DBFLD_filedescription{/t}</th></tr>
{foreach item=document from=$documents}
<tr><td><a href='{$doc_link}{$document.filename}'>{$document.filename}</a></td><td>{$document.filedescription}</td></tr>
{/foreach}
{foreach item=document from=$uploads}
<tr><td><a href='{$upload_path}{$document.filepath}'>{$document.filename}</a></td><td>{$document.filedescription}</td></tr>
{/foreach}
</table>
{/if}

{* spares *}
{if count($bom_spares) eq 0}
<table border="solid" width="100%">
<tr><th class="no-info">{t}No BOM spares defined{/t}</th></tr>
</table>
{else}                  
<table>
<tr><th>{t}DBFLD_ITEMNUM{/t}<BR>SAP</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}DBFLD_NOTES{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYONHAND{/t}</th></tr>
{foreach item=spare from=$bom_spares}
<tr><td>{$spare.ITEMNUM}<br><b>{$spare.MAPICS}</b></td><td>{$spare.DESCRIPTION}</td><td>{$spare.NOTES}</td><td>{$spare.LOCATION}</td><td>{$spare.QTYONHAND}</td></tr>
{/foreach}
</table>
{/if}

{* Workorders *}
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th></tr>
{foreach item=workorder from=$workorders}
<tr><td><a href="../workorders/wo_print.php?id1={$workorder.WONUM}" target="printout_wo">{$workorder.WONUM}</a></td><td>{$workorder.TASKDESC}</td><td>{$workorder.REQUESTDATE}</td></tr>
{/foreach}
</table>
</body>
</html>