{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="2" bgcolor="red"><b>{t}Printout PPM task: {/t}{$ppm.TASKNUM}</b></td></tr>
<tr><td width="25%"><B>{t}DBFLD_DESCRIPTION{/t}</B></td><td>{$ppm.DESCRIPTION}</td></tr>
<tr><td><B>{t}DBFLD_TEXTS_A{/t}</B></td><td>{$ppm.TEXTS_A|nl2br}</td></tr>
</table>

{* Documentation *}
<table width="100%">
<tr><th>{t}Filename{/t}</th><th>{t}Content{/t}</th></tr>
{foreach item=document from=$documents}
<tr><td><a href='{$smarty.const.DOC_LINK}{$document.FILENAME}'>{$document.FILENAME}</a></td><td>{$document.FILEDESCRIPTION}</td></tr>
{/foreach}
</table>

{* Documentation in WIKI *}
<!--
<table width="100%">
<tr><th>{t}WIKILINK{/t}</th></tr>
{foreach item=wikilink from=$wikilinks}
<tr><td><a href='{$smarty.const.WIKIDOC}{$wikilink.WIKILINK}'>{$wikilink.WIKILINK}</a></td></tr>
{/foreach}
</table>
-->

{* Works *}                                      
<table width="100%">
<tr><th>{t}DBFLD_OPNUM{/t}</th><th>{t}DBFLD_OPDESC{/t}</th><th>{t}DBFLD_CRAFT{/t}</th><th>{t}DBFLD_TEAM{/t}</th><th>{t}DBFLD_ESTHRS{/t}</th></tr>
{foreach item=work from=$works}
<tr><td>{$work.OPNUM}</td><td>{$work.OPDESC}</td><td>{$work.CRAFT}</td><td>{$work.TEAM}</td><td>{$work.ESTHRS}</td></tr>
{/foreach}
</table>

{* Spares *}
<table width="100%">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_QTYREQD{/t}</th></tr>
{foreach item=spare from=$spares}
<tr><td>{$spare.ITEMNUM}</td><td>{$spare.DESCRIPTION}</td><td>{$spare.QTYREQD}</td></tr>
{/foreach}
</table>

{* Checks *}
<table width="100%">
<tr><th>{t}DBFLD_INDICATOR{/t}</th><th>{t}DBFLD_INDICATOR_TYPE{/t}</th><th>{t}DBFLD_INDICATOR_LABEL{/t}</th><th>{t}DBFLD_INDICATOR_INSTRUCTIONS{/t}</th></tr>
{foreach item=check from=$checks}
<tr><td>{$check.INDICATOR}</td>
    <td>{$check.TYPE}</td>
    <td>{$check.LABEL}</td>
    <td>{$check.INSTRUCTIONS}</td></tr>
{/foreach}
</table>

{* Machines *}
<table width="100%">
<tr><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_OBJECTDESCRIPTION{/t}</th><th>{t}DBFLD_WONUM{/t}</th></tr>
{foreach item=machine from=$machines}
<tr><td>{$machine.EQNUM}</td><td>{$machine.DESCRIPTION}</td><td>{$machine.WONUM}</td></tr>
{/foreach}
</table>

{* workorders *}
<table width="100%">
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_COMPLETIONDATE{/t}</th><th>{t}DBFLD_WOSTATUS{/t}</th></tr>
{foreach item=wo from=$workorders}
<tr><td>{$wo.WONUM}</td><td>{$wo.TASKDESC}</td><td>{$wo.REQUESTDATE}</td><td>{$wo.COMPLETIONDATE}</td><td>{$wo.WOSTATUS}</td></tr>
{/foreach}
</table>

</body>
</html>