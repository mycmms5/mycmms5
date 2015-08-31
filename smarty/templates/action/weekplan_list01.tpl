{config_load file="colors.conf"}
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="{$stylesheet_calendar}" rel="stylesheet" type="text/css" />
<style type="text/css">
td.PL {
    color: black;
    background-color: lightgreen; }
td.P {
    color: white;
    background-color: orange; }
</style>
{include file="_jscal2.tpl"}
<!--
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
-->
</head>
<body>
<h1>{t}Week Planning{/t}</h1>
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_TASKDESC{/t}</th>
    <th>{t}DBFLD_SCHEDSTARTDATE{/t}</th>
    <th>{t}DBFLD_ASSIGNEDTECH{/t}</th>
    <th>{t}DBFLD_PRIORITY{/t}</th>
    <th>{t}DBFLD_WOSTATUS{/t}</th>
    <th>{t}DBFLD_ESTHRS{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach item=wo from=$data}
{if $active_wo neq $wo.WONUM}
<tr><td class="{$wo.WOSTATUS}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="STEP" value="1">
<input type="hidden" name="EQNUM" value="{$eqline}">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$wo.WONUM}"><a href="../workorders/printout_wo_{$smarty.const.CMMS_DB}.php?id1={$wo.WONUM}" target="new">{$wo.WONUM}</a></td>
    <td class="{$wo.WOSTATUS}">{$wo.EQNUM}</td>
    <td width="30%">{$wo.TASKDESC}</td> 
    <td align="center">{$wo.PLANWEEK}</td>
    <td>{$wo.ASSIGNEDTECH}</td>
    <td align="center">{$wo.PRIORITY}</td>
    <td class={$wo.WOSTATUS}>{$wo.WOSTATUS}</td>
    <td align="center">{$wo.PLANHOURS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td></tr>
</form>
{else}
<tr bgcolor="{cycle values="{#LINECOLOR_ODD#},{#LINECOLOR_EVEN#}"}"><td class="{$wo.WOSTATUS}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="PLAN">
<input type="hidden" name="STEP" value="2">
<input type="hidden" name="EQNUM" value="{$eqline}">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$wo.WONUM}">{$wo.WONUM}</td>
    <td class="{$wo.WOSTATUS}">{$wo.EQNUM}</td>
    <td width="30%">{$wo.TASKDESC}</td> 
    <td>{include file="_calendar2.tpl" NAME="SCHEDSTARTDATE" VALUE=$wo.SCHEDSTARTDATE}</td>
    <td>{$wo.ASSIGNEDTECH}</td>
    <td align="center">{$wo.PRIORITY}</td>
    <td>to PL</td>
    <td align="center">{$wo.PLANHOURS}</td>    
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td></tr>
</form>
{/if}
{/foreach}
</table>

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