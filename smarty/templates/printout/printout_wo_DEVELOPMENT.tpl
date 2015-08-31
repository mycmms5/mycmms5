{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="3" bgcolor="red">{$wo_main_data.WOPREV} - <B>{$wo_main_data.WONUM}</B> - {$wo_main_data.WONEXT}</td></tr>
<tr><td colspan="3"><B>{t}DBFLD_TASKDESC{/t} : </B>{$wo_main_data.TASKDESC}</td></tr>
<tr><td colspan="3"><B>{t}DBFLD_EQNUM{/t}</B>{$wo_main_data.DESCRIPTION} : {$wo_main_data.EQNUM}</td></tr>
<tr><td><B>{t}DBFLD_ORIGINATOR{/t}</B></td><td>{$wo_main_data.ORIGINATOR}</td><td><B> : </B>{$wo_main_data.REQUESTDATE}</td></tr>
<tr><td><B>{t}DBFLD_APPROVEDBY{/t}</B></td><td>{$wo_main_data.APPROVEDBY}</td><td><B> : </B>{$wo_main_data.APPROVEDDATE}</td></tr>
<tr><td><B>{t}DBFLD_SCHEDSTARTDATE{/t}</B></td><td colspan="2">{$wo_main_data.SCHEDSTARTDATE}</td></tr>

{if $wo_main_data.TASKNUM neq 'NONE'}
<tr><td colspan="3" bgcolor="red">{$wo_main_data.TASKNUM}</td></tr>
{else}
<tr><td><B>{t}DBFLD_ASSIGNEDBY{/t}</B></td><td colspan="2">{$wo_main_data.ASSIGNEDBY}</td></tr>
{/if}

<tr><td><B>{t}DBFLD_ASSIGNEDTO{/t}</B></td><td colspan="2">{$wo_main_data.ASSIGNEDTO}</td></tr>
<tr><td><B>{t}DBFLD_COMPLETIONDATE{/t}</B></td><td colspan="2">{$wo_main_data.COMPLETIONDATE} <B>({$wo_main_data.WOSTATUS}</B></td></tr>
</table>
{* Preparation Text and Technical comments *}
<table>
<tr><th>{t}DBFLD_TEXTS_A{/t}</th><th>{t}DBFLD_TEXTS_B{/t}</th></tr>
<tr><td>{$wo_main_data.TEXTS_A|nl2br}</td><td>{$wo_main_data.TEXTS_B|nl2br}</td></tr>
</table>
{* Documentation *}
<table>
<tr><th>{t}DBFLD_FILENAME{/t}</th><th>{t}DBFLD_FILEDESC{/t}</th></tr>
{foreach item=wo_docu from=$wo_docs}
<tr><td><a href="{$doc_path}{$wo_docu.FILENAME}">{$wo_docu.FILENAME}</a></td><td>{$wo_docu.FILEDESCRIPTION}</td></tr>
{/foreach}
</table>

{* Resource Planning *}                                      
<table>
<tr><th>{t}DBFLD_OPNUM{/t}</th><th>{t}DBFLD_OPDESC{/t}</th><th>{t}DBFLD_CRAFT{/t}</th><th>{t}DBFLD_ESTHRS{/t}</th></tr>
{foreach item=operation from=$work}
<tr><td>{$operation.OPNUM}</td><td>{$operation.OPDESC}</td><td>{$operation.CRAFT}</td><td>{$operation.ESTHRS}</td></tr>
{/foreach}
</table>

{* Spares *}
<table>
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}DBFLD_QTYREQD{/t}</th><th>{t}DBFLD_LOCATION{/t}</th><th>{t}DBFLD_QTYUSED{/t}</th></tr>
{foreach item=spare from=$spares}
<tr><td>{$spare.ITEMNUM}</td><td>{$spare.DESCRIPTION}</td><td>{$spare.QTYREQD}</td><td>{$spare.LOCATION}</td><td>{$spare.QTYUSED}</td></tr>
{/foreach}
</table>

{* Technicians *}
<table>
<tr><th>{t}DBFLD_ASSIGNEDTECH{/t}</th><th>{t}DBFLD_ENDED{/t}</th></tr>
{foreach item=intervention from=$interventions}
<tr><td>{$intervention.ASSIGNEDTECH}</td><td>{$intervention.ENDED}</td></tr>
{/foreach}
</table>

</body>
</html>