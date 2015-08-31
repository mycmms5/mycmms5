{debug}
<html>
<head>
<meta http-equiv="content-type" content="text/html;">
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>

{if $step eq "FORM"}
<h1 class="action">Task launching Sub-System with PPM Calendar</h1>    
<h3 class="action">Select EQNUM and Date-Ranges</h3>
<table>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="1">
<tr><td colspan="2">{include file="_combobox.tpl" type="LIST"  NAME="EQNUM" options=$machines SELECTEDITEM=""}</td></tr>
<tr><td>{t}Start Date{/t}</td><td>{t}Until{/t}</td></tr>        
<tr><td>{include file="_calendar2.tpl" NAME="START" VALUE=$smarty.now|date_format:"%Y-%m-%d"}</td>
    <td>{include file="_calendar2.tpl" NAME="END" VALUE=$smarty.now|date_format:"%Y-%m-%d"}</td></tr>
<tr><td colspan="2"><input type="submit" name="launch" value="{t}Period to Launch{/t}"></td></tr>    
</form>
</table>
{/if}

{if $step eq "STEP1"}
<h1 class="action">Task launching Sub-System with PPM Calendar</h1>
<h3 class="action"><u>STEP 1:</u>{t}List of tasks found in PPM Calendar{/t}</h3>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="2">
<input type="submit" name="check" value="{t}Unmark if you want to block task{/t}">
<table>
<tr><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Description{/t}</th><th>{t}Planned Date{/t}</th><th>{t}Launch{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.tasknum}</td>
    <td>{$task.eqnum}</td>
    <td>{$task.description}</td>
    <td>{$task.PLANDATE}</td>
    <td><input type="checkbox" name="taskid[]" value="{$task.tasknum}:{$task.eqnum}:{$task.PLANDATE}" checked></td></tr>
{/foreach}
</table>
</form>
<div class="error">{$smarty.session.PDO_ERROR}</div>
{/if}

{if $step eq "STEP2"}
<h1 class="action">Task launching Sub-System with PPM Calendar</h1>
<h3 class="action"><u>STEP 2:</u>{t}Launch selected TASKS --> WO{/t}</h3>
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
</form>
{/if}

{if $step eq "END"}
<h1 class="action">Task launching Sub-System with PPM Calendar</h1>
<h3><u>END:</u>{t}Marked WorkOrders created{/t}</u></h3>
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}Description{/t}</th><th>{t}Planned Date{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.WONUM}</td>
    <td>{$task.tasknum}</td>
    <td>{$task.eqnum}</td>
    <td>{$task.description}</td>
    <td>{$task.PLANDATE}</td></tr>
{/foreach}
</table>
{/if}

<div class="error">{$smarty.session.PDO_ERROR}</div>
<div class="CVS">{$version}</div>
</body>
</html>
 
