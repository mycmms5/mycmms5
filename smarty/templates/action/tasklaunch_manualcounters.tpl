<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>

{if $step eq 'FORM'}
<h1 class="action">Task launching Sub-System</h1>    
<h3 class="action">Pre-Selection</h3>
<form action="" method="post">
<input type="hidden" name="STEP" value="1">
<input type="submit" name="launch" value="{t}Launch All Counter Tasks{/t}">
</form>
{/if}

{if $step eq 'STEP1'}
<h1 class="action">Task launching Sub-System: STEP1</h1>
<h3 class="action"><u>STEP 1:</u></h3>
<ol>
<li>{t}Recuperating latest counter states{/t}</li>
<li>{t}Updating counters in PPM tasks{/t}</li>
<li>{t}Checking counter-based PPM tasks{/t}</li>
</ol>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="2">
<input type="submit" name="check" value="{t}Launch Tasks{/t}">
</form>
<table>
<tr><th>{t}DBFLD_INDICATOR{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_INDICATOR{/t}</th><th>{t}Last Counter{/t}</th><th>{t}Interval{/t}</th><th>{t}SUM{/t}</th><th>{t}Counter Now{/t}</th><th>{t}Action{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.TASKNUM}</td>
    <td>{$task.EQNUM}</td>
    <td>{$task.COUNTER}</td>
    <td style="text-align=right">{$task.COUNTER}</td>
    <td style="text-align=right">{$task.NUMOFDATE}</td>
    <td style="text-align=right">{$task.NEXTDUE}</td>
    <td style="text-align=right">{$task.STATE}</td>
    {if $task.STATE ge $task.NEXTDUE}
        <td style="background-color=red;">LAUNCH</td>
    {else}
        <td style="background-color=darkgreen;">OK</td>        
    {/if}
    </tr>
{/foreach}
</table>
{/if}
 
{if $step eq 'STEP2'}
<h1 class="action">Task launching Sub-System: CHECKING</h1>
<h3 class="action"><u>STEP 2:</u></h3>
<ol>
<li>{t}Launching the WO{/t}</li>
<li>{t}Setting the WO information in the PPM task{/t}</li>
<ul><li>WONUM</li>
    <li>LASTCOUNTER</li></ul>
</ol>
<form action="{$SCRIPT_NAME}" method="post">
<input type="hidden" name="STEP" value="2">
<input type="submit" name="check" value="{t}Launch Tasks{/t}">
</form>
<table>
<tr><th>{t}DBFLD_TASKNUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_INDICATOR{/t}</th>
    <th>{t}DBFLD_WONUM{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach from=$tasks item=task}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$task.TASKNUM}</td>
    <td>{$task.EQNUM}</td>
    <td>{$task.COUNTER}</td>
    <td>{$task.WONUM}</td>
    <td style="background-color=red;">LAUNCH</td>
    </tr>
{/foreach}
</table>
{/if}

<div class="CVS">{$version}</div>
</body>
</html>

 
