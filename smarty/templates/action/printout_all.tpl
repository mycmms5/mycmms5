{config_load file="colors.conf"}
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html;" />
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<h1>{t}Print Out{/t}</h1>
<table>
<tr><th>{t}DBFLD_WONUM{/t}</th>
    <th>{t}DBFLD_EQNUM{/t}</th>
    <th>{t}DBFLD_TASKDESC{/t}</th>
    <th>{t}DBFLD_SCHEDSTARTDATE{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach item=wo from=$data}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{$wo.WONUM}</td>
    <td>{$wo.EQNUM}</td>
    <td>{$wo.TASKDESC}</td>
    <td>{$wo.SCHEDSTARTDATE}</td>
    <td><form action="../workorders/wo_print.php" target="temp">
        <input type="hidden" name="id1" value="{$wo.WONUM}">
        <input type="hidden" name="AUTO" value="ON">
        <input type="submit" value="PRINT"></form></td></tr>
{/foreach}    
</table>
</body>
</html>