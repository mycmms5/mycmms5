{config_load file="colors.conf"}
<html>
<head>
<title></title>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<h1 class="action">{t}Automatic Task launching Sub-System{/t}</h1>
<table>
<tr><th colspan="7">{t}LOG autolauncher: {/t}{$smarty.now|date_format:"%D"}</th></tr>
<tr><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_DESCRIPTION{/t}<th>{t}DBFLD_TASKDESC{/t}</th><th>{t}DBFLD_TASKNUM{/t}</th><th>{t}DBFLD_REQUESTDATE{/t}</th><th>{t}DBFLD_SCHEDSTARTDATE{/t}</th></tr>
{foreach item=wo from=$data}
<tr bgcolor="{cycle values="{#LINECOLOR_ODD#},{#LINECOLOR_EVEN#}"}">
    <td>{$wo.WONUM}</td><td>{$wo.EQNUM}</td><td>{$wo.DESCRIPTION}</td><td>{$wo.TASKDESC}</td><td>{$wo.TASKNUM}</td><td>{$wo.REQUESTDATE}</td><td>{$wo.SCHEDSTARTDATE}</td></tr>
{/foreach}
</table>
</body>
</html>