{config_load file="colors.conf"}
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.PL {
    color: Black;
    background-color: lightgreen; }
td.P {
    color: white;
    background-color: orange; }
</style>
{include file="_jscal2.tpl"}
</head>
<body>
<h1>{t}Week Planning{/t}</h1>
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="STEP" value="3">
<input type="hidden" name="EQNUM" value="{$eqline}">
<table>
<input type="submit" name="RePlan" value="RePlan">
<tr><th>{t}DBFLD_WONUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_TASKDESC{/t}</th>
    <th>{t}DBFLD_SCHEDSTARTDATE{/t}</th>
    <th>{t}DBFLD_ASSIGNEDTECH{/t}</th>
    <th>{t}DBFLD_PRIORITY{/t}</th>
    <th>{t}DBFLD_WOSTATUS{/t}</th>
    <th>{t}DBFLD_ESTHRS{/t}</th>
    <th>{t}Action{/t}</th></tr>
<tr>
<th>{t}DBFLD_SCHEDSTARTDATE{/t}</th><th colspan="8">{include file="_calendar2.tpl" NAME="SCHEDSTARTDATE" VALUE=$wo.SCHEDSTARTDATE}</th></tr>
{foreach item=wo from=$data}
<tr><td class="{$wo.WOSTATUS}"><a href="../workorders/printout_wo_{$smarty.const.CMMS_DB}.php?id1={$wo.WONUM}" target="new">{$wo.WONUM}</a></td>
    <td class="{$wo.WOSTATUS}">{$wo.EQNUM}</td>
    <td width="30%">{$wo.TASKDESC}</td> 
    <td align="center">{$wo.PLANWEEK}</td>
    <td>{$wo.ASSIGNEDTECH}</td>
    <td align="center">{$wo.PRIORITY}</td>
    <td class={$wo.WOSTATUS}>{$wo.WOSTATUS}</td>
    <td align="center">{$wo.PLANHOURS}</td>
    <td align="center"><input type="checkbox" name="WONUM[]" value="{$wo.WONUM}"></td></tr>
{/foreach}
</table>
<input type="submit" name="RePlan" value="RePlan">
</form>
<hr>

<h2>{t}Already Planned Work{/t}</h2>
<table width="300">
<tr><th>{t}Type Work{/t}</th><th>{t}Planweek{/t}</th><th>{t}Planned{/t}</th></tr>
{foreach item=wo from=$wo_planned}
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td>{$wo.TYPE}</td>
    <td>{$wo.PLANWEEK}</td>
    <td align="right">{$wo.PLANHOURS}</td></tr>
{/foreach}
</table>
</body>
</html>