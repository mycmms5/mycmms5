<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
function gotoInsert() {
document.INSERT.SubID.style.background='lightblue'; 
document.INSERT.SubID.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus(); gotoInsert();">
<table>
<tr><th>ID</th><th>DVD#</th><th>#</th><th>HAMA</th><th>Action</th></tr>
{foreach item=dvd from=$dvds}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $dvd.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$dvd.ID}">
    <td style="text-align: center;">{$dvd.ID}</td>
    <td style="text-align: center;">{$dvd.VideoID}</td>
    <td style="text-align: center;">{$dvd.SubID}</td>
    <td style="text-align: center;">{$dvd.HAMA}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$dvd.ID}">
    <td style="text-align: center;">{$dvd.ID}</td>
    <td style="text-align: center;">{$dvd.VideoID}</td>
    <td style="text-align: center;"><input type="text" name="SubID" size="4" value="{$dvd.SubID}" ></td>
    <td style="text-align: center;"><input type="text" name="HAMA" size="4" value="{$dvd.HAMA}" style="text-align: center;"></td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/refresh2.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
    <td style="text-align: center;">NEW</td>
    <td style="text-align: center;">{$dvd.VideoID}</td>
    <td style="text-align: center;"><input type="text" name="SubID" size="4"></td>
    <td style="text-align: center;"><input type="text" name="HAMA" size="4"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>