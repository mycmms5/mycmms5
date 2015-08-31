<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
<link href="calendar-win2K-1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ITEMDESCRIPTION{/t}</th><th>{t}DBFLD_DATEUSED{/t}</th><th>{t}DBFLD_QTYUSED{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=usedspare from=$usedspares}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>
{if $actual_id ne $usedspare.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$usedspare.ID}">
        {$usedspare.ITEMNUM}</td>
    <td>{$usedspare.ITEMDESCRIPTION}</td>
    <td>{$usedspare.DATEUSED}</td>
    <td>{$usedspare.QTYUSED}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$usedspare.ID}">
        {$usedspare.ITEMNUM}</td>
    <td>{$usedspare.ITEMDESCRIPTION}</td>
    <td>{$usedspare.DATEUSED}</td>
    <td><input type="text" name="QTYUSED" size="5" value="{$usedspare.QTYUSED}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}"><td>
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
        <input type="text" name="ITEMNUM" size="15"></td>
    <td>-</td>
    <td>NOW</td>
    <td><input type="text" name="QTYUSED" size="5" value="{$usedspare.QTYUSED}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>

<table width="800">
<tr><th>{t}DBFLD_ID{/t}</th><th>{t}DBFLD_WONUM{/t}</th><th>{t}DBFLD_ITEMNUM{/t}</th><th>{t}DBFLD_ISSUEDATE{/t}</th><th>{t}DBFLD_QTY{/t}</th><th>{t}DBLFD_ISSUETO{/t}</th></tr>
{foreach item=event from=$history}
<tr><td>{$event.SERIALNUM}</td><td>{$event.CHARGETO}</td><td>{$event.ITEMNUM}</td><td>{$event.ISSUEDATE}</td><td>{$event.QTY}</td><td>{$event.ISSUETO}</td></tr>
</tr>
{/foreach}
</table>

</body>
</html>