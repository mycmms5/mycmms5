{include file="printout_header.tpl"}
<body>
<table border="solid" width="100%">
<tr><td colspan="3" bgcolor="red">{$wo_main_data.WONUM}: RAPPORT {$wo_main_data.ASSIGNEDTECH}/{$wo_main_data.REPORT}</td></tr>
<tr><td><B>{t}DBFLD_TASKDESC{/t} : </B></td><td colspan="2">{$wo_main_data.TASKDESC}</td></tr>
<tr><td><B>{t}DBFLD_EQNUM{/t}</B></td><td colspan="2">{$wo_main_data.DESCRIPTION} : {$wo_main_data.EQNUM}</td></tr>
<tr><td><B>{t}DBFLD_ORIGINATOR{/t}</B></td><td>{$wo_main_data.ORIGINATOR}:{$wo_main_data.NAME}</td><td><B> : </B>{$wo_main_data.REQUESTDATE}</td></tr>
<tr><td><B>{t}Intervention{/t}</B></td><td colspan="2">{$wo_main_data.SCHEDSTARTDATE}</td></tr>
{if $wo_main_data.TASKNUM neq 'NONE'}
<tr><td colspan="3" bgcolor="red">{$wo_main_data.TASKNUM}</td></tr>
{else}
{/if}
</table>

{* Preparation Text and Technical comments *}
<table border="solid" width="100%">
<tr><th>{t}Preparation{/t}</th><th>{t}Report{/t}</th></tr>
<tr><td>{$wo_main_data.TEXTS_A|nl2br}</td><td>{$wo_main_data.TEXTS_B|nl2br}</td></tr>
</table>

{* Documentation *}
<table border="solid" width="100%">
<tr><th>{t}DBFLD_FILENAME{/t}</th><th>{t}DBFLD_FILEDESC{/t}</th></tr>
<tr><td>{$wo_docs.FILENAME}</td><td>{$wo_docs.DESCRIPTION}</td></tr>
</table>

{* Spares *}
<table border="solid" width="100%">
<tr><th>{t}AF_REF{/t}</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}MAGASIN{/t}</th><th>{t}DBFLD_QTYUSED{/t}</th></tr>
{foreach item=spare from=$spares}
<tr><td>{$spare.MAPICS}</td><td>{$spare.DESCRIPTION}</td><td>{$spare.WAREHOUSEID}</td><td>{$spare.QTYUSED}</td></tr>
{/foreach}
</table>
<p>{$free_text}</p>

</body>
</html>

