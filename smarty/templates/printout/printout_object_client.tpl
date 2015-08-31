{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="2" bgcolor="red"><b>{$object_main_data.EQNUM}</b> - <i>{$object_main_data.DESCRIPTION}</i></td></tr>
<tr><td><B>{$smarty.config.IS_EQTYPE}</B></td><td>{$object_main_data.EQTYPE}</td></tr>
<tr><td><B>{$smarty.config.IS_SPARECODE}</B></td><td>{$object_main_data.SPARECODE}</td></tr>
</table>

{* Documentation *}
<table>
<tr><th>{t}Filename{/t}</th><th>{t}Content{/t}</th></tr>
{foreach item=document from=$documents}
<tr><td><a href='{$doc_link}{$document.FILENAME}'>{$document.FILENAME}</a></td><td>{$document.FILEDESCRIPTION}</td></tr>
{/foreach}
</table>
{* Components *}                                      
<table>
<tr><th>{t}DBFLD_COMPONENT{/t}</th><th>{t}DBFLD_DESC_COMP{/t}</th><th>{t}DBFLD_COMPTYPE{/t}</th></tr>
{foreach item=component from=$components}
<tr><td>{$component.COMPONENT}</td><td>{$component.DESC_COMP}</td><td>{$component.COMPTYPE}</td></tr>
{/foreach}
</table>
{* Workorders *}
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th></tr>
{foreach item=workorder from=$workorders}
<tr><td><a href="../workorders/wo_print.php?id1={$workorder.WONUM}">{$workorder.WONUM}</a></td><td>{$workorder.TASKDESC}</td><td>{$workorder.REQUESTDATE}</td></tr>
{/foreach}
</table>

{* spares *}
<table>
<tr><th>{t}DBFLD_ITEMNUM{/t}<BR>MAPICS</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}DBFLD_NOTES{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYONHAND{/t}</th></tr>
{foreach item=spare from=$spares}
<tr><td>{$spare.ITEMNUM}<br><b>{$spare.MAPICS}</b></td><td>{$spare.DESCRIPTION}</td><td>{$spare.NOTES}</td><td>{$spare.LOCATION}</td><td>{$spare.QTYONHAND}</td></tr>
{/foreach}
</table>

</body>
</html>