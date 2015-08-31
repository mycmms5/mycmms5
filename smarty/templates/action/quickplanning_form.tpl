<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO8859-1" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
{include file="_jscal2.tpl"}
</head>
<body>
<h1 class="action">{t}Quick assignment of Resources{/t}</h1>
<h2 class="action">{t}Quick assignment of Resources{/t} -- {t}STEP 0: {/t}{t}Work ready for planning{/t}</h2>

<table width="100%" align="center">
<tr><th>{t}DBFLD_WONUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_TASKDESC{/t}</th>
    <th>{t}DBFLD_REQUESTDATE{/t}</th>
    <th>{t}DBFLD_SCHEDSTARTDATE{/t}</th>
    <th>{t}DBFLD_WOSTATUS{/t}</th>
    <th>{t}DBFLD_ASSIGNEDTECH{/t}</th>
    <th>{t}WeekPlan{/t}</th>
{foreach item=wo from=$wos}
{if $actual_id ne $wo.WONUM}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$wo.WONUM}">
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td>{$wo.WONUM}</td>
    <td>{$wo.EQNUM}</td>
    <td width="40%">{$wo.TASKDESC}</td>
{if $wo.DELAY1 le -5}
    <td bgcolor="orange">
{else}
    <td bgcolor="green">
{/if}
        {$wo.REQUESTDATE|date_format: '%d-%m (%Y)'}<br>{$wo.DELAY1}</td>    
{if $wo.DELAY2 le -20}
    <td bgcolor="red">
{else}
    <td bgcolor="green">
{/if}
        {$wo.SCHEDSTARTDATE|date_format: '%d-%m (%Y)'}<br>{$wo.DELAY2}</td>
    <td>{$wo.WOSTATUS}</td>
    <td>UNPLANNED</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" alt="EDIT"></a></td>
</form>        
{else}
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$wo.WONUM}">
<tr bgcolor="{cycle values="#CCCCCC,#DDDDDD"}">
    <td>{$wo.WONUM}</td>
    <td>{$wo.EQNUM}</td>
    <td>{$wo.TASKDESC}</td>
{if $wo.DELAY1 le -5}
    <td bgcolor="orange">
{else}
    <td bgcolor="green">
{/if}
        {$wo.REQUESTDATE|date_format: '%d-%m (%Y)'}</td>    
    <td>{include file="_calendar2.tpl" NAME="SCHEDSTARTDATE" VALUE=$wo.SCHEDSTARTDATE}</td>
    <td>{$wo.WOSTATUS}</td>
    <td>{include file="_checkboxes.tpl" NAME="EMPCODE[]" options=$options}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" alt="UPDATE"></a></td>  
</form>
{/if}
{/foreach}

</table>
</body>
</html>