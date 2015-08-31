<html>
<head>
<title>IMPORT PPM Calendar</title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
Information:<p>
<div class="error">{$smarty.session.PDO_ERROR}</div>
<table border="solid">
<tr><th>{t}DBFLD_TASKNUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_SCHEDSTARTDATE{/t}</th></tr>
{foreach from=$data item=task}
<tr><td>{$task.TASKNUM}</td>
    <td>{$task.EQNUM}</td>
    <td>{$task.LAUNCH}</td></tr>
{/foreach}
</table>

</body>
</html>