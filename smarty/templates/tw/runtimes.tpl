<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}DBFLD_EQNUM{/t}</th><th>{t}DBFLD_DESCRIPTION{/t}</th><th>{t}DBFLD_SCHEDSTARTDATE{/t}</th><th>{t}DBFLD_COUNTER{/t}</th><th>{t}Report{/t}</th><th>ACTION</th></tr>

<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{include file="_combobox.tpl" type="LIST"  options=$machines NAME="EQNUM" SELECTEDITEM="$wo_data[1]"}</td> 
    <td>-</td>
    <td>{include file="_calendar.tpl" NAME="DATE" VALUE=$wo_data[0]}</td>
    <td><input type="text" name="COUNTER" align="center" size="6"></td>
    <td><input type="text" name="REPORT" align="right" size="6" value="{$wo_data[2]}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" alt="INSERT"></a></td></tr>
</form>

{foreach item=counter from=$counters}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $counter.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$counter.ID}">
    <td>{$counter.EQNUM}</td>
    <td>{$counter.DESCRIPTION}</td>
    <td>{$counter.DATE}</td>
    <td>{$counter.COUNTER}</td>
    <td>{$counter.REPORT}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$counter.ID}">
<td>{$counter.EQNUM}</td> 
<td>{$counter.DESCRIPTION}</td>
<td>{include file="_calendar.tpl" NAME="DATE" VALUE=$counter.DATE}</td>
<td><input type="text" name="COUNTER" size="6" value="{$counter.COUNTER}"></td>
<td>{$counter.REPORT}</td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
</table>
</body>
</html>