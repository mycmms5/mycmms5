<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>

{if $step eq "FORM"}
<h1 class="action">Task launching Sub-System</h1>    
<h3 class="action">Extending the Forecast</h3>
<form action="" method="post">
<input type="hidden" name="STEP" value="1">
{t}Limit Days ahead:{/t}&nbsp;<input type="text" class="text" name="LIMIT" id="LIMIT" size="5" value="0">
<input type="submit" name="launch" value="{t}Forecast in days{/t}">
</form>
{/if}

{if $step eq "STEP1"}
<h1 class="action">Task launching Sub-System</h1>
<h3 class="action">{t}Checking the Due Dates{/t}</br>{t}List of tasks -ready to launch-{/t}</h3>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="2">
<input type="submit" name="check" value="{t}Mark tasks ACTIVE{/t}">
<table>
<tr><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Description{/t}</th><th>{t}DBFLD_NEXTDUEDATE{/t}</th><th>{t}Launch{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.tasknum}</td>
    <td>{$task.eqnum}</td>
    <td>{$task.description}</td>
    <td>{$task.next}</td>
    <td>
    {if $task.active eq 1}
        <input type="checkbox" name="taskid[]" value="{$task.tasknum}:{$task.eqnum}" checked>
    {else}
        <input type="checkbox" name="taskid[]" value="{$task.tasknum}:{$task.eqnum}">
    {/if}</td></tr>
{/foreach}
</table>
</form>
{/if}

{if $step eq "STEP2"}
<h1 class="action">Task launching Sub-System</h1>
<h3 class="action">{t}Marking time-based WorkOrders{/t}</u><BR>
    {t}List of tasks -ready to launch-{/t}</h3>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="3">
<input type="submit" name="check" value="{t}Launch selected TASKS --> WO{/t}">
<table>
<tr><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Description{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.tasknum}</td>
    <td>{$task.eqnum}</td>
    <td>{$task.description}</td></tr>
{/foreach}
</table>
{/if}

{if $step eq "END"}
<h1 class="action">Task launching Sub-System</h1>
{if $tasks eq null}
<h3 class="action">{t}Marked WorkOrders created{/t}</u></h3>
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Description{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.WONUM}</td>
    <td>{$task.tasknum}</td>
    <td>{$task.eqnum}</td>
    <td>{$task.description}</td></tr>
{/foreach}
</table>
{else}
<h3 class="action">{t}No Work Orders were created{/t}</u></h3>
{/if}
<p class="info">{$smarty.session.PDO_ERROR}</p>
{/if}

<div class="CVS">{$version}</div>
</body>
</html>
 
