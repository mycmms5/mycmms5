<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
function gotoInsert() {
document.INSERT.TrackTitle.style.background='lightblue'; 
document.INSERT.TrackTitle.focus();
}
</script>
<script src="../libraries/calendar.js" type="text/javascript"></script>
<script src="../libraries/calendar-en.js" type="text/javascript"></script>
<script src="../libraries/calendar-setup.js" type="text/javascript"></script>
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body onload="setFocus(); gotoInsert();">
<table width="800">
<tr><th>{t}TrackID{/t}</th><th>{t}CD_Nr{/t}</th><th>{t}Track_Nr{/t}</th><th>{t}Title{/t}</th><th>{t}Extra Info{/t}</th><th>{t}Action{/t}</th></tr>
{foreach item=track from=$tracks}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $track.TrackID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$track.TrackID}">
    <td style="text-align: center;">{$track.TrackID}</td>
    <td style="text-align: center;">{$track.CDNumber}</td>
    <td style="text-align: center;">{$track.TrackNumber}</td>
    <td>{$track.TrackTitle}</td>
    <td>{$track.TrackLength}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$track.TrackID}">
<td>{$track.TrackID}</td>
<td><input type="text" name="CDNumber" size="4" value="{$track.CDNumber}" style="text-align: center;"></td>
<td><input type="text" name="TrackNumber" size="4" value="{$track.TrackNumber}" style="text-align: center;"></td>
<td><input type="text" name="TrackTitle" size="35" value="{$track.TrackTitle}"></td>
<td><input type="text" name="TrackLength" size="35" value="{$track.TrackLength}"></td>
<td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
    <td>NEW</td>
    <td><input type="text" name="CDNumber" size="4" value="{$track.CDNumber}"></td>
    <td><input type="text" name="TrackNumber" size="4" value="{$nextTrackNumber}"></td>
    <td><input type="text" name="TrackTitle" size="35" value=""></td>
    <td><input type="text" name="TrackLength" size="35" value=""></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>