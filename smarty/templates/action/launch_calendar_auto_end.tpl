<html>
<head>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head> 
<body>
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
<div class="error">{$smarty.session.PDO_ERROR}</div>
</body>
</html>
 
