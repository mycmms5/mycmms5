<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    parent.resizeTo(1000,500);
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
<table width="100%">
<tr><th>ID</th><th>Bill#</th><th>Date</th><th>Hours</th><th>Comment</th><th>Costs (B)</th><th>Costs (NB)</th><th>Action</th></tr>
{foreach item=work from=$works}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $work.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$work.ID}">
    <td style="text-align: center;">{$work.ID}</td>
    <td style="text-align: center;">{$work.FactuurID}</td>
    <td style="text-align: center;">{$work.workdate}</td>
    <td style="text-align: center;">{$work.workhours}</td>
    <td style="text-align: left;">{$work.comments|nl2br}</td>
    <td style="text-align: right;">{$work.costs}</td>
    <td style="text-align: right;">{$work.costs_nb}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/edit2.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$work.ID}">
    <td style="text-align: center;">{$work.ID}</td>
    <td style="text-align: center;">{$work.FactuurID}</td>
    <td style="text-align: center;"><input type="text" name="workdate" size="10" value="{$work.workdate}" ></td>
    <td style="text-align: center;"><input type="text" name="workhours" size="4" value="{$work.workhours}" style="text-align: center;"></td>
    <td style="text-align: center;"><textarea name="commentaar" cols="75" rows="4">{$work.comments}</textarea></td>
    <td style="text-align: right;"><input type="text" name="costs" size="5"></td>
    <td style="text-align: right;"><input type="text" name="costs_nb" size="5"></td>    
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
    <td style="text-align: center;">{$work.FactuurID}</td>
    <td style="text-align: center;"><input type="text" name="workdate" size="10"></td>
    <td style="text-align: center;"><input type="text" name="workhours" size="4"></td>
    <td style="text-align: left;"><textarea name="comments" cols="75" rows="4">...</textarea></td>    
    <td style="text-align: right;"><input type="text" name="costs" size="5"></td>
    <td style="text-align: right;"><input type="text" name="costs_nb" size="5"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/add2.png" width="20" alt="UPDATE"></a></td></tr>
</form>
{* CALCULATE *}
<form action="{$SCRIPT_NAME}" name="CALCULATE" method="post">
<input type="hidden" name="ACTION" value="CALCULATE">
<input type="hidden" name="form_save" value="SET">
<tr><td colspan="6" align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/calendar.gif" width="20" alt="CALC"></a></td></tr>
</form>
</body>
</html>