{include file="printout_header.tpl"}
<body>
<table>
<tr><td colspan="2" bgcolor="lightgrey"><b>{$object_main_data.EQNUM}</b> - <i>{$object_main_data.DESCRIPTION}</i></td></tr>
<tr><td><B>{$LBLFIELD_EQTYPE}</B></td><td>{$object_main_data.EQTYPE}</td></tr>
<tr><td><B>{$smarty.config.IS_SPARECODE}</B></td><td>{$object_main_data.SPARECODE}</td></tr>
</table>

<table>
<tr><td colspan="2" color="red">RISK FACTOR: {$object_risk_data.TOTALSCORE}</td></tr></table>

{if count($object_tasks) eq 0}
<table border="solid" width="100%">
<tr><th class="no-info">{t}No TASKS found{/t}</th></tr>
</table>
{else}        
<table>
<tr><td>{t}DBFLD_TASKNUM{/t}</td><td>{t}DBFLD_DESCRIPTION{/t}</td></tr>
{foreach item=task from=$object_tasks}
<tr><td>{$task.TASKNUM}</td><td>{$task.DESCRIPTION}</td></tr>
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