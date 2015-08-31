<html>
<head>
<script src="../libraries/functions.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function setFocus() {
    window.focus();
}
</script>
{include file="_jscal2.tpl"}
<link href="{$stylesheet}" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="800">
<tr><th>{t}DBFLD_EMPCODE{/t}</th>
    <th>{t}DBFLD_OPNUM{/t}</th>
    <th>{t}DBFLD_WODATE{/t}</th>
    <th>{t}DBFLD_ESTHRS{/t}</th>
    <th>{t}Action{/t}</th></tr>
{foreach item=prestation from=$prestations}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
{if $actual_id ne $prestation.ID}
<form action="{$SCRIPT_NAME}" name="EDIT" method="get">
<input type="hidden" name="ACTION" value="EDIT">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$prestation.ID}">
    <td>{$prestation.EMPCODE}</td>
    <td>{$prestation.OPNUM}</td>
    <td>{$prestation.OPSCHEDULE|date_format:"%Y-%m-%d"}</td>
    <td>{$prestation.ESTHRS}</td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="EDIT"></a></td>
</form>
</tr>
{else}
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
<form action="{$SCRIPT_NAME}" name="EDIT" method="post">  
<input type="hidden" name="ACTION" value="UPDATE">
<input type="hidden" name="form_save" value="SET">
<input type="hidden" name="ID" value="{$prestation.ID}">
    <td>{include file="_combobox.tpl" type="LIST"  options=$employees NAME="EMPCODE" SELECTEDITEM=$data.EMPCODE}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$opnums NAME="OPNUM" SELECTEDITEM=$data.OPNUM}</td>
    <td>{include file="_calendar2.tpl" NAME="WODATE" VALUE=$prestation.OPSCHEDULE|date_format:"%Y-%m-%d"}</td>
    <td><input type="text" name="ESTHRS" align="right" size="4" value="{$prestation.ESTHRS}"></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/UPDATE.png" width="20" alt="UPDATE"></a></td>
</form>
</tr>
{/if}
{/foreach}
{* INSERT *}
<form action="{$SCRIPT_NAME}" name="INSERT" method="post"> 
<input type="hidden" name="ACTION" value="INSERT">
<input type="hidden" name="form_save" value="SET">
<tr bgcolor="{cycle values="WHITE,LIGHTSTEELBLUE"}">
    <td>{include file="_combobox.tpl" type="LIST"  options=$employees NAME="EMPCODE" SELECTEDITEM=""}</td>
    <td>{include file="_combobox.tpl" type="LIST"  options=$opnums NAME="OPNUM" SELECTEDITEM="10"}</td>
    <td>-</td>
    <td><input type="text" name="ESTHRS" align="right" size="4" value=""></td>
    <td align="center"><a href="javascript:document.EDIT.submit()"><input type="image" src="../images/INSERT.jpg" width="20" alt="UPDATE"></a></td></tr>
</form>
</table>
</body>
</html>